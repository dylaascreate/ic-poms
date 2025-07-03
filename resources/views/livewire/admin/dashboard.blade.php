<div>
    <div class="p-6 bg-gray-100 min-h-screen">
        <h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>

        <div class="grid grid-cols-5 gap-6 mb-8">
            <!-- Total Order Card -->
            <div wire:click="filterOrders(null)" 
                class="cursor-pointer p-6 rounded-2xl shadow-lg border hover:shadow-2xl transition flex flex-col items-center 
                    {{ $filterStatus === null ? 'ring-4 ring-blue-300 bg-white' : 'bg-white' }}">
                <div class="flex items-center justify-between w-full mb-3">
                    <span class="text-4xl font-extrabold text-gray-800">{{ $totalOrders }}</span>
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V7a2 2 0 00-2-2h-3.17a2 2 0 01-1.41-.59l-1.83-1.83A2 2 0 009.17 2H6a2 2 0 00-2 2v5m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0H4" />
                        </svg>
                    </span>
                </div>
                <div class="text-gray-600 text-base font-semibold mt-2">Total Order</div>
            </div>

            <!-- Waiting Order Card -->
            <div wire:click="filterOrders('waiting')" 
                class="cursor-pointer p-6 rounded-2xl shadow-lg border hover:shadow-2xl transition flex flex-col items-center 
                    {{ $filterStatus === 'waiting' ? 'ring-4 ring-yellow-400 bg-yellow-400' : 'bg-gray-400' }}">
                <div class="flex items-center justify-between w-full mb-3">
                    <span class="text-4xl font-extrabold text-white">{{ $waitingOrders }}</span>
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-yellow-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <div class="text-white text-base font-semibold mt-2">Waiting Order</div>
            </div>

            <!-- Printing Card -->
            <div wire:click="filterOrders('printing')" 
                class="cursor-pointer p-6 rounded-2xl shadow-lg border hover:shadow-2xl transition flex flex-col items-center 
                    {{ $filterStatus === 'printing' ? 'ring-4 ring-green-300 bg-green-500' : 'bg-green-500' }}">
                <div class="flex items-center justify-between w-full mb-3">
                    <span class="text-4xl font-extrabold text-white">{{ $printingOrders }}</span>
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-green-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V4h12v5M6 18h12v-5H6v5zm0 0v2a2 2 0 002 2h8a2 2 0 002-2v-2" />
                        </svg>
                    </span>
                </div>
                <div class="text-white text-base font-semibold mt-2">Printing</div>
            </div>

            <!-- Ready Pick Up Card -->
            <div wire:click="filterOrders('can_pick_up')" 
                class="cursor-pointer p-6 rounded-2xl shadow-lg border hover:shadow-2xl transition flex flex-col items-center 
                    {{ $filterStatus === 'can_pick_up' ? 'ring-4 ring-orange-300 bg-orange-500' : 'bg-orange-500' }}">
                <div class="flex items-center justify-between w-full mb-3">
                    <span class="text-4xl font-extrabold text-white">{{ $readyOrders }}</span>
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-blue-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zm10 0a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 011-1h3a1 1 0 011 1v10m-1-4h-4m-6 0V6a1 1 0 011-1h3a1 1 0 011 1v10" />
                        </svg>
                    </span>
                </div>
                <div class="text-white text-base font-semibold mt-2">Can Pick Up</div>
            </div>

            <!-- Done Pick Up Card -->
            <div wire:click="filterOrders('picked_up')" 
                class="cursor-pointer p-6 rounded-2xl shadow-lg border hover:shadow-2xl transition flex flex-col items-center 
                    {{ $filterStatus === 'picked_up' ? 'ring-4 ring-purple-300 bg-purple-500' : 'bg-purple-500' }}">
                <div class="flex items-center justify-between w-full mb-3">
                    <span class="text-4xl font-extrabold text-white">{{ $pickedUpOrders }}</span>
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <div class="text-white text-base font-semibold mt-2">Picked Up</div>
            </div>
        </div>

        <div class="bg-white p-4 shadow rounded">
            
            <div class="mb-4 flex justify-between items-center">
    <h3 class="text-xl font-semibold">Order List</h3>
    
</div>

            <table class="w-full table-auto border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">No order</th>
                        <th class="border px-4 py-2">Product</th>
                        <th class="border px-4 py-2">Date</th>
                        <th class="border px-4 py-2">Time</th>
                        <th class="border px-4 py-2">Pick-up Details</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                       <tr class="text-center">
    <td class="border px-4 py-2">{{ $order->no_order }}</td>
    <td class="border px-4 py-2">
        @if($order->products && $order->products->count())
            {{ $order->products->pluck('name')->join(', ') }}
        @else
            -
        @endif
    </td>
    <td class="border px-4 py-2">{{ $order->created_at->format('d.m.Y') }}</td>
    <td class="border px-4 py-2">{{ $order->created_at->format('h:i A') }}</td>
    <td class="border px-4 py-2">{{ $order->user->name ?? '-' }}</td>
    <td class="border px-4 py-2">
        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full capitalize
            {{ 
                $order->status === 'waiting' ? 'bg-gray-300 text-gray-800' :
                ($order->status === 'printing' ? 'bg-green-300 text-green-800' :
                ($order->status === 'can_pick_up' ? 'bg-yellow-300 text-yellow-800' :
                ($order->status === 'picked_up' ? 'bg-purple-300 text-purple-800' :
                'bg-red-300 text-red-800')))
            }}">
            {{ str_replace('_', ' ', $order->status) }}
        </span>
    </td>
    <td class="border px-4 py-2">
        <a href="{{ route('manage-order') }}" class="bg-blue-500 text-white px-3 py-1 rounded">View</a>
    </td>
</tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
