<x-app-layout>
    <div class="space-y-6 p-6" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);">
        <!-- Statistics Section -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistics</h3>
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-blue-600">Total Lost Items</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $stats['total_lost'] }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-green-600">Total Found Items</p>
                    <p class="text-2xl font-bold text-green-700">{{ $stats['total_found'] }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="text-sm text-purple-600">Matched Items</p>
                    <p class="text-2xl font-bold text-purple-700">{{ $stats['matched_items'] }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('lost-items.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Report Lost Item
                </a>
                <a href="{{ route('found-items.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Report Found Item
                </a>
            </div>
        </div>

        <!-- Recent Items Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Recent Lost Items -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Recent Lost Items</h3>
                    <a href="{{ route('lost-items.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                </div>
                
                @if($recentLostItems->isEmpty())
                    <p class="text-gray-500 text-sm">No lost items reported yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($recentLostItems as $item)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                <div class="flex">
                                    @if($item->image)
                                        <div class="flex-shrink-0 mr-4">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" 
                                                class="h-16 w-16 object-cover rounded-lg">
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <h4 class="font-medium text-gray-900">{{ $item->name }}</h4>
                                            <span class="text-sm {{ $item->status === 'found' ? 'text-green-600' : 'text-yellow-600' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($item->description, 100) }}</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-500">Lost on {{ $item->date_lost->format('M d, Y') }}</span>
                                            <a href="{{ route('lost-items.show', $item) }}" class="text-sm text-blue-600 hover:text-blue-800">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Recent Found Items -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Recent Found Items</h3>
                    <a href="{{ route('found-items.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                </div>
                
                @if($recentFoundItems->isEmpty())
                    <p class="text-gray-500 text-sm">No found items reported yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($recentFoundItems as $item)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                <div class="flex">
                                    @if($item->image)
                                        <div class="flex-shrink-0 mr-4">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" 
                                                class="h-16 w-16 object-cover rounded-lg">
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <h4 class="font-medium text-gray-900">{{ $item->name }}</h4>
                                            <span class="text-sm {{ $item->status === 'claimed' ? 'text-green-600' : 'text-yellow-600' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($item->description, 100) }}</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-500">Found on {{ $item->date_found->format('M d, Y') }}</span>
                                            <a href="{{ route('found-items.show', $item) }}" class="text-sm text-blue-600 hover:text-blue-800">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
