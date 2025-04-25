<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lost Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('lost-items.update', $lostItem) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Item Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $lostItem->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>{{ old('description', $lostItem->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location" :value="__('Location Lost')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $lostItem->location)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>

                        <!-- Date Lost -->
                        <div>
                            <x-input-label for="date_lost" :value="__('Date Lost')" />
                            <x-text-input id="date_lost" name="date_lost" type="date" class="mt-1 block w-full" :value="old('date_lost', $lostItem->date_lost->format('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('date_lost')" />
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category" :value="__('Category')" />
                            <select id="category" name="category" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select a category</option>
                                <option value="electronics" {{ old('category', $lostItem->category) == 'electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="clothing" {{ old('category', $lostItem->category) == 'clothing' ? 'selected' : '' }}>Clothing</option>
                                <option value="accessories" {{ old('category', $lostItem->category) == 'accessories' ? 'selected' : '' }}>Accessories</option>
                                <option value="documents" {{ old('category', $lostItem->category) == 'documents' ? 'selected' : '' }}>Documents</option>
                                <option value="other" {{ old('category', $lostItem->category) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category')" />
                        </div>

                        <!-- Current Image -->
                        @if($lostItem->image_path)
                            <div>
                                <x-input-label :value="__('Current Image')" />
                                <div class="mt-2">
                                    <img src="{{ Storage::url($lostItem->image_path) }}" alt="{{ $lostItem->name }}" class="h-32 w-32 object-cover rounded-lg">
                                </div>
                            </div>
                        @endif

                        <!-- Image Upload -->
                        <div>
                            <x-input-label for="image" :value="__('New Image (optional)')" />
                            <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100" />
                            <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Update Lost Item') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 