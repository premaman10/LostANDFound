<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class FoundItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = FoundItem::with('user')->latest();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->get('category'));
        }

        // Status filter
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->get('status'));
        }

        $foundItems = $query->paginate(12);

        return view('found-items.index', [
            'foundItems' => $foundItems,
            'categories' => ['electronics', 'clothing', 'documents', 'accessories', 'other'],
            'statuses' => ['pending' => 'Unclaimed', 'matched' => 'Matched', 'claimed' => 'Claimed']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('found-items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date_found' => 'required|date',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
        ]);

        // Convert tags string to array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = [];
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('found-items', 'public');
            $validated['image_path'] = $path;
        }

        $validated['user_id'] = $request->user()->id;
        $validated['status'] = 'pending';
        $validated['item_id'] = uniqid('FOUND_');
        
        $foundItem = FoundItem::create($validated);

        // Check for potential matches in lost items
        $potentialMatches = LostItem::where('status', 'pending')
            ->where(function ($query) use ($foundItem) {
                $query->where('name', 'like', '%' . $foundItem->name . '%')
                    ->orWhere('description', 'like', '%' . $foundItem->description . '%')
                    ->orWhere(function ($q) use ($foundItem) {
                        foreach ($foundItem->tags as $tag) {
                            $q->orWhereJsonContains('tags', $tag);
                        }
                    });
            })
            ->where('category', $foundItem->category)
            ->get();

        if ($potentialMatches->isNotEmpty()) {
            // Update the status of the first matching lost item and this found item
            $matchingLostItem = $potentialMatches->first();
            $matchingLostItem->update(['status' => 'found']);
            $foundItem->update([
                'status' => 'matched',
                'lost_item_id' => $matchingLostItem->id
            ]);

            return redirect()->route('found-items.show', $foundItem)
                ->with('success', 'Item matched with an existing lost item! The owner will be notified.');
        }

        return redirect()->route('found-items.show', $foundItem)
            ->with('success', 'Item reported as found successfully. We\'ll notify you if someone claims it.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FoundItem $foundItem): View
    {
        $foundItem->load('user');
        
        // Find potential matches based on various criteria
        $potentialMatches = LostItem::where('status', 'pending')
            ->where(function ($query) use ($foundItem) {
                $query->where('name', 'like', '%' . $foundItem->name . '%')
                    ->orWhere('description', 'like', '%' . $foundItem->description . '%')
                    ->orWhere(function ($q) use ($foundItem) {
                        if (!empty($foundItem->tags)) {
                            foreach ($foundItem->tags as $tag) {
                                $q->orWhereJsonContains('tags', $tag);
                            }
                        }
                    });
            })
            ->where('category', $foundItem->category)
            ->get();
            
        return view('found-items.show', compact('foundItem', 'potentialMatches'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoundItem $foundItem): View
    {
        if (!Gate::allows('update', $foundItem)) {
            abort(403);
        }
        return view('found-items.edit', compact('foundItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FoundItem $foundItem): RedirectResponse
    {
        if (!Gate::allows('update', $foundItem)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date_found' => 'required|date',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            if ($foundItem->image_path) {
                Storage::disk('public')->delete($foundItem->image_path);
            }
            $path = $request->file('image')->store('found-items', 'public');
            $validated['image_path'] = $path;
        }

        $foundItem->update($validated);

        return redirect()->route('found-items.show', $foundItem)
            ->with('success', 'Found item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoundItem $foundItem): RedirectResponse
    {
        if (!Gate::allows('delete', $foundItem)) {
            abort(403);
        }

        if ($foundItem->image_path) {
            Storage::disk('public')->delete($foundItem->image_path);
        }

        $foundItem->delete();

        return redirect()->route('found-items.index')
            ->with('success', 'Found item deleted successfully.');
    }
}
