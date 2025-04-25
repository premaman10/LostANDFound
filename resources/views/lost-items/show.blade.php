<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lost Item Details') }}
            </h2>
            <div class="flex space-x-2">
                @can('update', $lostItem)
                    <a href="{{ route('lost-items.edit', $lostItem) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Edit Item
                    </a>
                @endcan
                <a href="{{ route('lost-items.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Item Details -->
                        <div>
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $lostItem->name }}</h3>
                                <span class="px-3 py-1 text-sm rounded-full {{ $lostItem->status === 'found' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($lostItem->status) }}
                                </span>
                            </div>

                            @if($lostItem->image_path)
                                <div class="mb-6">
                                    <img src="{{ Storage::url($lostItem->image_path) }}" alt="{{ $lostItem->name }}" 
                                        class="w-full h-64 object-cover rounded-lg">
                                </div>
                            @endif

                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Description</h4>
                                    <p class="mt-1 text-gray-900">{{ $lostItem->description }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Location Lost</h4>
                                    <p class="mt-1 text-gray-900">{{ $lostItem->location }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Date Lost</h4>
                                    <p class="mt-1 text-gray-900">{{ $lostItem->date_lost->format('F d, Y') }}</p>
                                </div>

                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-500">Category</h4>
                                    <p class="mt-1">{{ ucfirst($lostItem->category) }}</p>
                                </div>

                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-500">Reported by</h4>
                                    <p class="mt-1">{{ $lostItem->user->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Matching Section -->
                        <div>
                            @if($lostItem->status === 'pending')
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Potential Matches</h3>
                                
                                    @if($lostItem->foundItem)
                                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                            <h4 class="text-green-800 font-medium mb-2">Item Found!</h4>
                                            <p class="text-green-700">This item has been matched with a found item. Contact the finder to arrange pickup.</p>
                                        </div>
                                    @else
                                        <div class="space-y-4">
                                            @forelse($potentialMatches ?? [] as $match)
                                                <div class="bg-white border rounded-lg p-4">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <h4 class="font-medium">{{ $match->name }}</h4>
                                                        <span class="text-sm text-gray-500">{{ $match->date_found->format('M d, Y') }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 mb-2">{{ Str::limit($match->description, 100) }}</p>
                                                    <p class="text-sm text-gray-500">Found at: {{ $match->location }}</p>
                                                    <div class="mt-3">
                                                        <a href="{{ route('found-items.show', $match) }}" 
                                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                            View Details →
                                                        </a>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-gray-500">No potential matches found at this time.</p>
                                            @endforelse
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Contact Information -->
                            <div class="mt-6 bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                                <div class="space-y-2">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Name:</span> {{ $lostItem->user->name }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Email:</span> {{ $lostItem->user->email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 