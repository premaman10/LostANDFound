<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use App\Models\FoundItem;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_lost' => LostItem::count(),
            'total_found' => FoundItem::count(),
            'matched_items' => LostItem::where('status', 'found')->count(),
        ];

        return view('welcome', compact('stats'));
    }
} 