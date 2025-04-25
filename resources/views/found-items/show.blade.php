@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Found Item Details</h2>
                    <div class="flex space-x-4">
                        @can('update', $foundItem)
                            <a href="{{ route('found-items.edit', $foundItem) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Edit Item
                            </a>
                        @endcan
                        <a href="{{ route('found-items.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Item Details -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $foundItem->name }}</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Status: 
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $foundItem->status === 'claimed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($foundItem->status) }}
                                </span>
                            </p>
                        </div>

                        @if($foundItem->image)
                            <div>
                                <img src="{{ asset('storage/' . $foundItem->image) }}" alt="{{ $foundItem->name }}" class="w-full h-64 object-cover rounded-lg">
                            </div>
                        @endif

                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Description</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ $foundItem->description }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Location Found</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ $foundItem->location_found }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Date Found</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ $foundItem->date_found->format('F j, Y') }}</p>
                        </div>

                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-500">Category</h4>
                            <p class="mt-1">{{ ucfirst($foundItem->category) }}</p>
                        </div>

                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-500">Reported by</h4>
                            <p class="mt-1">{{ $foundItem->user->name }}</p>
                        </div>
                    </div>

                    <!-- Matching Section -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Potential Matches</h3>
                        
                        @if($foundItem->status === 'claimed')
                            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                                <p class="text-sm text-green-800">This item has been claimed by its owner.</p>
                            </div>
                        @elseif($potentialMatches->isEmpty())
                            <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                                <p class="text-sm text-gray-800">No potential matches found at this time.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($potentialMatches as $match)
                                    <div class="border border-gray-200 rounded-md p-4">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $match->name }}</h4>
                                        <p class="mt-1 text-sm text-gray-500">{{ Str::limit($match->description, 100) }}</p>
                                        <div class="mt-2">
                                            <a href="{{ route('lost-items.show', $match) }}" class="text-sm text-blue-600 hover:text-blue-800">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Name</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ $foundItem->user->name }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Email</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ $foundItem->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 