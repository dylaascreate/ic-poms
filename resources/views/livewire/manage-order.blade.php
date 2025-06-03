<div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('message'))
        <div class="text-center text-green-600 font-bold mb-4">{{ session('message') }}</div>
    @endif

    {{-- ORDER TABLE --}}
    <div class="flex flex-col gap-6">
        <flux:heading class="px-10 flex items-center gap-2" size="xl">
            All Orders
            <flux:badge variant="primary">{{ $orders->total() }}</flux:badge>
        </flux:heading>

        <div class="rounded-xl border shadow-sm bg-white">
            <div class="px-10 py-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left table-auto border-collapse rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-teal-500 text-white text-sm uppercase">
                                <th class="p-2">No Order</th>
                                <th class="p-2">Description</th>
                                <th class="p-2">Price (RM)</th>
                                <th class="p-2">User</th>
                                <th class="p-2">Status</th>
                                <th class="p-2">Products</th>
                                <th class="p-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr wire:key="order-{{ $order->id }}" @class([
                                'hover:bg-teal-50 transition duration-200 border-b',
                                'bg-teal-100' => $loop->even,
                                'bg-white' => !$loop->even,
                            ])>
                                <td class="p-2 align-top">{{ $order->no_order }}</td>
                                <td class="p-2 align-top">{{ $order->description }}</td>
                                <td class="p-2 align-top">{{ $order->price }}</td>
                                <td class="p-2 align-top">{{ $order->user?->name ?? 'N/A' }}</td>
                                <td class="p-2 align-top">
                                    <span class="px-3 py-1 rounded-xl text-white text-xs font-semibold
                                        @switch($order->status)
                                            @case('waiting') bg-gray-400 @break
                                            @case('printing') bg-green-500 @break
                                            @case('can_pick_up') bg-orange-500 @break
                                            @case('picked_up') bg-purple-500 @break
                                            @default bg-gray-300
                                        @endswitch
                                    ">
                                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td class="p-2 align-top">
                                    <ul class="list-disc list-inside text-xs max-h-24 overflow-auto">
                                        @foreach($order->products as $product)
                                            <li>{{ $product->name }} (x{{ $product->pivot->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="p-2 align-top space-x-2">
                                    <flux:button wire:click="edit({{ $order->id }})" icon="pencil-square" variant="primary" class="bg-sky-500 text-white rounded-md text-sm" aria-label="Edit order {{ $order->no_order }}" />
                                    <flux:button wire:click="$dispatch('confirmDelete', {{ $order->id }})" icon="trash" variant="danger" aria-label="Delete order {{ $order->no_order }}" />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-center">
                    {{ $orders->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    {{-- ORDER FORM --}}
    <br>
    <div class="flex flex-col gap-6">
        <div class="rounded-xl border shadow-sm">
            <br>
            <flux:heading class="px-10" size="xl">
                {{ $orderId ? 'Edit Order' : 'Add Order' }}
            </flux:heading>
            <div class="px-10 py-8">
                <form wire:submit.prevent="save" class="space-y-6" novalidate>
                    <div class="grid grid-cols-2 gap-6">
                        <flux:input wire:model.defer="no_order" label="No Order" placeholder="Order Number" required />
                        <flux:input wire:model.defer="price" label="Total Price" placeholder="Total" type="number" step="0.01" min="0" readonly />
                        <flux:textarea wire:model.defer="description" label="Description" placeholder="Description" required />
                        <flux:input wire:model.defer="total" label="Total Price" placeholder="Total" type="number" step="0.01" min="0" required />
                        <flux:textarea wire:model.defer="order_desc" label="Description" placeholder="Description" required />
                        <flux:select wire:model.defer="orderOwnerId" label="User" required>
                            <option value="">Select User</option>
                            @foreach($orderOwners as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model.defer="status" label="Status" required>
                            <option value="waiting">Waiting</option>
                            <option value="printing">Printing</option>
                            <option value="can_pick_up">Can Pick Up</option>
                            <option value="picked_up">Picked Up</option>
                        </flux:select>
                    </div>

                    {{-- Product Selection --}}
                    <div class="mt-6">
                        <label class="block font-bold text-sm text-gray-700 mb-2">Select Products</label>
                        @foreach ($selectedProducts as $index => $product)
                            <div class="border p-4 rounded-xl mb-4">
                                <div class="mb-2">
                                    <select 
                                        wire:model.defer="selectedProducts.{{ $index }}.product_id"
                                        class="border rounded-md p-2 w-full text-sm"
                                    >
                                        <option value="">-- Choose Product --</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if(!empty($product['product_id']))
                                    <div class="flex items-center gap-2">
                                        <input
                                            type="number"
                                            placeholder="Qty"
                                            wire:model.defer="selectedProducts.{{ $index }}.quantity"
                                            class="border rounded-md p-2 w-1/3 text-sm"
                                            min="0"
                                            aria-label="Quantity"
                                        />
                                        <input
                                            type="number"
                                            placeholder="Price"
                                            wire:model.defer="selectedProducts.{{ $index }}.price"
                                            class="border rounded-md p-2 w-1/3 text-sm"
                                            step="0.01"
                                            min="0"
                                            aria-label="Price"
                                        />
                                    </div>
                                @endif

                                <button type="button" wire:click="removeProduct({{ $index }})" class="text-red-500 text-sm mt-2">Remove</button>
                            </div>
                        @endforeach

                        <button type="button" wire:click="addProduct" class="mt-2 px-4 py-2 bg-sky-500 text-white rounded-md text-sm">
                            Add Another Product
                        </button>
                    </div>

                    {{-- Submit Button --}}
                    <flux:button type="submit" variant="primary" icon="paper-airplane" class="mt-6 bg-green-500 text-white rounded-md text-sm">
                        {{ $orderId ? 'Update' : 'Add Order' }}
                    </flux:button>
                </form>
            </div>
        </div>
    </div>

    {{-- SWEETALERT SCRIPT --}}
    <script>
        document.addEventListener('livewire:init', function(){
            Livewire.on('orderSaved', function(res){
                Swal.fire('Success!', res.message, 'success');
            });

            Livewire.on('confirmDelete', (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This order will be deleted.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('delete', id);
                    }
                });
            });
        });
    </script>
</div>
