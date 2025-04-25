<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use App\Models\FoundItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class LostItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = LostItem::with('user')->latest();

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

        $lostItems = $query->paginate(12);

        return view('lost-items.index', [
            'lostItems' => $lostItems,
            'categories' => ['electronics', 'clothing', 'documents', 'accessories', 'other'],
            'statuses' => ['pending' => 'Still Lost', 'found' => 'Found']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('lost-items.create');
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
            'date_lost' => 'required|date',
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
            $path = $request->file('image')->store('lost-items', 'public');
            $validated['image_path'] = $path;
        }

        $validated['user_id'] = $request->user()->id;
        $validated['status'] = 'pending';
        $validated['item_id'] = uniqid('LOST_');
        
        $lostItem = LostItem::create($validated);

        // Check for potential matches in found items
        $potentialMatches = FoundItem::where('status', 'pending')
            ->where(function ($query) use ($lostItem) {
                $query->where('name', 'like', '%' . $lostItem->name . '%')
                    ->orWhere('description', 'like', '%' . $lostItem->description . '%')
                    ->orWhere(function ($q) use ($lostItem) {
                        foreach ($lostItem->tags as $tag) {
                            $q->orWhereJsonContains('tags', $tag);
                        }
                    });
            })
            ->where('category', $lostItem->category)
            ->get();

        if ($potentialMatches->isNotEmpty()) {
            return redirect()->route('lost-items.show', $lostItem)
                ->with('info', 'We found some potential matches for your lost item!')
                ->with('potentialMatches', $potentialMatches);
        }

        return redirect()->route('lost-items.show', $lostItem)
            ->with('success', 'Item reported as lost successfully. We\'ll notify you if someone finds it!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LostItem $lostItem): View
    {
        $lostItem->load('user');
        
        // Find potential matches based on various criteria
        $potentialMatches = FoundItem::where('status', 'pending')
            ->where(function ($query) use ($lostItem) {
                $query->where('name', 'like', '%' . $lostItem->name . '%')
                    ->orWhere('description', 'like', '%' . $lostItem->description . '%')
                    ->orWhere(function ($q) use ($lostItem) {
                        if (!empty($lostItem->tags)) {
                            foreach ($lostItem->tags as $tag) {
                                $q->orWhereJsonContains('tags', $tag);
                            }
                        }
                    });
            })
            ->where('category', $lostItem->category)
            ->get();
            
        return view('lost-items.show', compact('lostItem', 'potentialMatches'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LostItem $lostItem): View
    {
        if (!Gate::allows('update', $lostItem)) {
            abort(403);
        }
        return view('lost-items.edit', compact('lostItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LostItem $lostItem): RedirectResponse
    {
        if (!Gate::allows('update', $lostItem)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date_lost' => 'required|date',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'item_id' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($lostItem->image_path) {
                Storage::disk('public')->delete($lostItem->image_path);
            }
            $path = $request->file('image')->store('lost-items', 'public');
            $validated['image_path'] = $path;
        }

        $lostItem->update($validated);

        return redirect()->route('lost-items.show', $lostItem)
            ->with('success', 'Lost item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LostItem $lostItem): RedirectResponse
    {
        if (!Gate::allows('delete', $lostItem)) {
            abort(403);
        }

        if ($lostItem->image_path) {
            Storage::disk('public')->delete($lostItem->image_path);
        }

        $lostItem->delete();

        return redirect()->route('lost-items.index')
            ->with('success', 'Lost item deleted successfully.');
    }
}
