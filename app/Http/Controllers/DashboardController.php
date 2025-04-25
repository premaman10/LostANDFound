<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use App\Models\FoundItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        
        $stats = [
            'total_lost' => LostItem::count(),
            'total_found' => FoundItem::count(),
            'matched_items' => LostItem::where('status', 'found')->count(),
            'user_items' => LostItem::where('user_id', auth()->id())->count() + 
                           FoundItem::where('user_id', auth()->id())->count(),
        ];

        $recentLostItems = LostItem::latest()
            ->take(6)
            ->get();

        $recentFoundItems = FoundItem::latest()
            ->take(6)
            ->get();

        return view('dashboard', compact('stats', 'recentLostItems', 'recentFoundItems'));
    }
}
