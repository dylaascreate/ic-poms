<!-- filepath: resources/views/livewire/manage-promotion.blade.php -->
<div>
    {{-- Success Message --}}
    @if (session('message'))
        <div class="text-center text-green-600 font-semibold mt-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Promotion Table --}}
    <div class="flex flex-col gap-6 mt-8">
        {{-- Heading + Add Button --}}
        <div class="px-10 flex items-center justify-between">
            <flux:heading class="flex items-center gap-2 text-xl font-semibold">
                All Promotions
                <flux:badge variant="primary">
                    {{ $promotions->total() }}
                </flux:badge>
            </flux:heading>
            <button
                onclick="document.getElementById('promotion-form').scrollIntoView({ behavior: 'smooth' });"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm"
            >
                + Add Promotion
            </button>
        </div>

        <div class="rounded-xl border shadow-sm bg-white">
            <div class="px-10 py-8 overflow-x-auto">
                <table class="w-full text-sm text-left table-auto border-collapse rounded-lg overflow-hidden">
                    <thead class="bg-yellow-500 text-white text-sm uppercase">
                        <tr>
                            {{-- <th class="py-3 px-4 text-center">ID</th> --}}
                            <th class="py-3 px-4">Image</th>
                            <th class="py-3 px-4">Title</th>
                            <th class="py-3 px-4">Description</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promotions as $index => $promo)
                            <tr class="{{ $index % 2 === 0 ? 'bg-yellow-200' : 'bg-yellow-100' }} hover:bg-blue-200 transition duration-200">
                                {{-- <td class="py-3 px-4 text-center font-medium">{{ $promo->id }}</td> --}}
                                <td class="py-3 px-4 text-center">
                                    @if ($promo->image)
                                        <img src="{{ asset('storage/' . $promo->image) }}" alt="Promotion Image" class="h-16 w-16 object-cover rounded-md border mx-auto">
                                    @else
                                        <span class="text-gray-400 italic">No Image</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-semibold text-gray-800">{{ $promo->title }}</td>
                                <td class="py-3 px-4 text-gray-700">{{ $promo->description }}</td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <flux:button wire:click="edit({{ $promo->id }})" icon="pencil-square" variant="primary" class="bg-sky-500 text-white rounded-md text-sm"></flux:button>
                                        <flux:button wire:click="delete({{ $promo->id }})" icon="trash" variant="danger"></flux:button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-6 flex justify-center">
                    {{ $promotions->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Promotion Form --}}
    <div id="promotion-form" class="flex flex-col gap-6 mt-10">
        <div class="rounded-xl border shadow-sm bg-white">
            <flux:heading class="px-10 pt-6 text-xl font-semibold">
                {{ $promotionId ? 'Edit Promotion' : 'Add Promotion' }}
            </flux:heading>
            <div class="px-10 py-8">
                <form wire:submit.prevent="save" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">

                        {{-- Image Upload --}}
                        <div class="col-span-2">
                            <label class="block mb-2 font-medium text-gray-700">Promotion Image</label>
                            <input type="file" wire:model="image" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100"/>

                            @error('image')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            @if ($image instanceof \Livewire\TemporaryUploadedFile)
                                <div class="mt-3">
                                    <label class="text-sm font-medium text-gray-600">Preview:</label>
                                    <img src="{{ $image->temporaryUrl() }}" class="h-24 mt-1 rounded shadow">
                                </div>
                            @elseif ($promotionId)
                                @php $existingPromotion = \App\Models\Promotion::find($promotionId); @endphp
                                @if ($existingPromotion && $existingPromotion->image)
                                    <div class="mt-3">
                                        <label class="text-sm font-medium text-gray-600">Current Image:</label>
                                        <img src="{{ asset('storage/' . $existingPromotion->image) }}" class="h-24 mt-1 rounded shadow">
                                    </div>
                                @endif
                            @endif
                        </div>

                        {{-- Title --}}
                        <flux:input wire:model="title" label="Promotion Title" placeholder="Promotion Title"/>
                        {{-- Description --}}
                        <flux:textarea wire:model="description" label="Description" placeholder="Promotion Description"/>

                        {{-- Submit Button --}}
                        <div class="col-span-2">
                            <flux:button type="submit" variant="primary" icon="paper-airplane" class="px-6 py-2 text-base bg-green-500 text-white rounded-md text-sm">
                                {{ $promotionId ? 'Update Promotion' : 'Add Promotion' }}
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>