<div> <!-- ✅ Start of the single root wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('message'))
        <div class="text-center text-green-600 font-bold mb-4">{{ session('message') }}</div>
    @endif

    @php
        $user = auth()->user();
        $isAdmin = $user && $user->role === 'admin';
        $canManageAll = $isAdmin && in_array($user->position, ['SuperAdmin', 'Manager', 'Designer']);
        $canViewOnly = $isAdmin && $user->position === 'Marketing';
        $canEditStatusOnly = $isAdmin && $user->position === 'Production Staff';
    @endphp

    {{-- HEADER + SEARCH + ADD ORDER --}}
    <div class="px-10 flex flex-wrap gap-4 justify-between items-center mb-4">
        <div class="flex items-center gap-4 flex-wrap">
            <flux:heading size="xl" class="flex items-center gap-2">
                All Orders
                <flux:badge variant="primary">{{ $orders->total() }}</flux:badge>
            </flux:heading>

            
           

        <form wire:submit.prevent="search" class="flex items-center gap-2">
            <input
                type="text"
                wire:model.defer="searchOrderNo"
                placeholder="Search by Order No"
                class="border rounded-md px-3 py-1 text-sm"
            />
            <button type="submit" class="bg-teal-500 text-white px-3 py-1 rounded-md text-sm">
                Search
            </button>
            @if($searchOrderNo)
                <button type="button" wire:click="clearSearch" class="text-gray-500 text-xs underline ml-2">
                    Clear
                </button>
            @endif
        </form>
        </div>

        <button
            onclick="document.getElementById('order-form').scrollIntoView({ behavior: 'smooth' });"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm"
        >
            + Add Order
        </button>
    </div>
    <button
    onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
    class="fixed bottom-6 right-6 z-50 bg-gray-700 hover:bg-gray-900 text-black w-14 h-14 rounded-full shadow-lg flex items-center justify-center transition-all duration-300"
    style="right: 2rem; bottom: 2rem;"
    aria-label="Scroll to top"
    title="Scroll to top">
    <span class="text-2xl">↑</span>
</button>

    {{-- ORDER TABLE --}}
    <div class="rounded-xl border shadow-sm bg-white mx-10 mb-10">
        
        <div class="px-10 py-8">
            
            <div class="overflow-x-auto">
<table class="w-full text-sm text-left table-fixed border-collapse rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-teal-500 text-white text-sm uppercase">
                            <th class="p-2">No Order</th>
                            <th class="p-2">Description</th>
                            <th class="p-2">Price (RM)</th>
                            <th class="p-2">User</th>
<th class="p-2 w-[160px]">Status</th>
                            <th class="p-2">Products</th>
<th class="p-2 w-[150px]">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr wire:key="order-{{ $order->id }}" @class([
                            'hover:bg-teal-300 transition duration-200 border-b',
                            'bg-teal-200' => $loop->even,
                            'bg-white' => !$loop->even,
                        ])>
                            <td class="p-2 align-top">{{ $order->no_order }}</td>
                            <td class="p-2 align-top">{{ $order->description }}</td>
                            <td class="p-2 align-top">{{ $order->price }}</td>
                            <td class="p-2 align-top">{{ $order->user?->name ?? 'N/A' }}</td>
<td class="p-2 align-top w-[160px] whitespace-nowrap">
    <span class="inline-block min-w-[110px] text-center px-3 py-1 rounded-xl text-white text-xs font-semibold
        @switch($order->status)
            @case('waiting') bg-gray-400 @break
            @case('printing') bg-green-500 @break
            @case('can_pick_up') bg-orange-500 @break
            @case('picked_up') bg-purple-500 @break
            @default bg-gray-300
        @endswitch">
        {{ ucwords(str_replace('_', ' ', $order->status)) }}
    </span>
</td>
<td class="p-2 align-top w-[160px] whitespace-nowrap">
    <div class="bg-gray-50 rounded-lg p-2 shadow-inner max-h-28 overflow-y-auto">
        @if($order->products->isEmpty())
            <span class="text-gray-400 text-xs">No products</span>
        @else
            <ol class="space-y-1 list-decimal list-inside">
                @foreach($order->products as $product)
                    <li class="flex items-center justify-between text-xs">
                        <span class="font-medium text-gray-700 truncate">{{ $product->name }}</span>
                        <span class="ml-2 bg-teal-100 text-teal-700 rounded px-2 py-0.5 font-semibold">x{{ $product->pivot->quantity }}</span>
                    </li>
                @endforeach
            </ol>
        @endif
    </div>
</td>
<td class="p-2 align-top space-x-2 w-[150px] whitespace-nowrap">
                                @if($canManageAll || $canEditStatusOnly)
                                    <flux:button wire:click="edit({{ $order->id }})" icon="pencil-square" variant="primary" class="bg-sky-500 text-white rounded-md text-sm" aria-label="Edit order {{ $order->no_order }}" />
                                @endif

                                @if($canManageAll)
                                    <flux:button wire:click="$dispatch('confirmDelete', {{ $order->id }})" icon="trash" variant="danger" aria-label="Delete order {{ $order->no_order }}" />
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center p-2">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    {{-- ORDER FORM --}}
    <div id="order-form" class="flex flex-col gap-6 mx-10 mb-10">
        <div class="rounded-xl border shadow-sm">
            <br>
            <flux:heading class="px-10" size="xl">
                {{ $orderId ? 'Edit Order' : 'Add Order' }}
            </flux:heading>
            <div class="px-10 py-8">
                <form wire:submit.prevent="save" class="space-y-6" novalidate>
                    <div class="grid grid-cols-2 gap-6">
                        <flux:input wire:model.defer="no_order" label="No Order" placeholder="Order Number" required :disabled="$orderId !== null || $isProduction" />
                        <flux:input wire:model.defer="price" label="Total Price" placeholder="Total" type="number" step="0.01" min="0" readonly />
                        <flux:textarea wire:model.defer="description" label="Description" placeholder="Description" required :disabled="$isProduction" />
                        <flux:select wire:model.defer="orderOwnerId" label="User" required :disabled="$isProduction">
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

                    {{-- Product Select --}}
                    <div class="{{ $isProduction ? 'pointer-events-none opacity-60' : '' }}">
                        <label class="block font-bold text-sm text-gray-700 mt-6 mb-2">
                            <span class="text-red-500">*</span> Select Products
                        </label>

                        @foreach ($selectedProducts as $index => $product)
                            <div class="border p-4 rounded-xl mb-4">
                                <div class="mb-2">
                                    <select wire:model.defer="selectedProducts.{{ $index }}.product_id" class="border rounded-md p-2 w-full text-sm">
                                        <option value="">-- Choose Product --</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if(!empty($product['product_id']))
                                    <div class="flex items-center gap-2">
                                        <input type="number" placeholder="Qty" wire:model.defer="selectedProducts.{{ $index }}.quantity" class="border rounded-md p-2 w-1/3 text-sm" min="0" />
                                        <input type="number" placeholder="Price" wire:model.defer="selectedProducts.{{ $index }}.price" class="border rounded-md p-2 w-1/3 text-sm" step="0.01" min="0" />
                                    </div>
                                @endif

                                <button type="button" wire:click="removeProduct({{ $index }})" class="text-red-500 text-sm mt-2">Remove</button>
                            </div>
                        @endforeach

                        @if(!$isProduction)
                            <button type="button" wire:click="addProduct" class="mt-2 px-4 py-2 bg-sky-500 text-white rounded-md text-sm">Add Another Product</button>
                        @endif
                    </div>

                    <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' });" class="fixed bottom-6 right-6 z-50 bg-gray-700 hover:bg-gray-900 text-black w-14 h-14 rounded-full shadow-lg flex items-center justify-center transition-all duration-300" aria-label="Scroll to top" title="Scroll to top">
                        <span class="text-2xl">↑</span>
                    </button>

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
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete', { id: id });
                    }
                });
            });
        });
    </script>

</div> <!-- ✅ End of the single root wrapper -->
