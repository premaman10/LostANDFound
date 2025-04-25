<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Found Items') }}
            </h2>
            <a href="{{ route('found-items.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Report Found Item
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <form action="{{ route('found-items.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Search by name, description, or location">
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category" id="category" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">All Categories</option>
                                <option value="electronics" {{ request('category') === 'electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="clothing" {{ request('category') === 'clothing' ? 'selected' : '' }}>Clothing</option>
                                <option value="accessories" {{ request('category') === 'accessories' ? 'selected' : '' }}>Accessories</option>
                                <option value="documents" {{ request('category') === 'documents' ? 'selected' : '' }}>Documents</option>
                                <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($foundItems as $item)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $item->name }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full {{ $item->status === 'matched' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                            
                            @if($item->image_path)
                                <div class="mb-4">
                                    <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}" 
                                        class="w-full h-48 object-cover rounded-lg">
                                </div>
                            @endif

                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($item->description, 100) }}</p>
                            
                            <div class="text-sm text-gray-500 space-y-1">
                                <p><span class="font-medium">Location:</span> {{ $item->location }}</p>
                                <p><span class="font-medium">Date Found:</span> {{ $item->date_found->format('M d, Y') }}</p>
                            </div>

                            <div class="mt-2">
                                <span class="text-sm text-gray-500">Category:</span>
                                <span class="text-sm font-medium">{{ ucfirst($item->category) }}</span>
                            </div>

                            <div class="mt-2">
                                <span class="text-sm text-gray-500">Reported by:</span>
                                <span class="text-sm font-medium">{{ $item->user->name }}</span>
                            </div>

                            <div class="mt-4 flex justify-end space-x-2">
                                <a href="{{ route('found-items.show', $item) }}" 
                                    class="inline-flex items-center px-3 py-1 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Details
                                </a>
                                @can('update', $item)
                                    <a href="{{ route('found-items.edit', $item) }}" 
                                        class="inline-flex items-center px-3 py-1 bg-green-100 border border-transparent rounded-md font-semibold text-xs text-green-700 uppercase tracking-widest hover:bg-green-200 focus:bg-green-200 active:bg-green-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Edit
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                            <p class="text-gray-500">No found items found.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $foundItems->links() }}
            </div>
        </div>
    </div>
</x-app-layout> 