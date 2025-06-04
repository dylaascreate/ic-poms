<x-layouts.app :title="__('Dashboard')">
    <div class="p-6 bg-gray-100 min-h-screen">
        <h2 class="text-2xl font-bold mb-4">User Dashboard</h2>

        <div class="grid grid-cols-5 gap-6 mb-8">
            <!-- Total Order Card -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border hover:shadow-2xl transition flex flex-col items-center">
                <div class="flex items-center justify-between w-full mb-3">
                    <span class="text-4xl font-extrabold text-gray-800">{{2 }}</span>
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                        <!-- Product Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V7a2 2 0 00-2-2h-3.17a2 2 0 01-1.41-.59l-1.83-1.83A2 2 0 009.17 2H6a2 2 0 00-2 2v5m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0H4" />
                        </svg>
                    </span>
                </div>
                <div class="text-gray-600 text-base font-semibold mt-2">Total Order</div>
            </div>

            <!-- Waiting Order Card -->
            <div class="bg-gray-400 p-6 rounded-2xl shadow-lg border hover:shadow-2xl transition flex flex-col items-center">
                <div class="flex items-center justify-between w-full mb-3">
                    <span class="text-4xl font-extrabold text-white">{{ 1 }}</span>
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-yellow-300">
                        <!-- Clock Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <div class="text-white text-base font-semibold mt-2">Waiting Order</div>
            </div>

            <!-- Printing Card -->
            <div class="bg-green-500 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition flex flex-col items-center">
                <div class="flex items-center justify-between w-full mb-3">
                    <span class="text-4xl font-extrabold text-white">{{ 1 }}</span>
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-green-200">
                        <!-- Print Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V4h12v5M6 18h12v-5H6v5zm0 0v2a2 2 0 002 2h8a2 2 0 002-2v-2" />
                        </svg>
                    </span>
                </div>
                <div class="text-white text-base font-semibold mt-2">Printing</div>
            </div>

            <!-- Ready Pick Up Card -->
            <div class="bg-orange-500 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition flex flex-col items-center">
                <div class="flex items-center justify-between w-full mb-3">
                    <span class="text-4xl font-extrabold text-white">{{ 0 }}</span>
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-blue-200">
                        <!-- Pick Up Icon (Truck) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zm10 0a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 011-1h3a1 1 0 011 1v10m-1-4h-4m-6 0V6a1 1 0 011-1h3a1 1 0 011 1v10" />
                        </svg>
                    </span>
                </div>
                <div class="text-white text-base font-semibold mt-2">Can Pick Up</div>
            </div>

            <!-- Done Pick Up Card -->
            <div class="bg-purple-500 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition flex flex-col items-center">
                <div class="flex items-center justify-between w-full mb-3">
                    <span class="text-4xl font-extrabold text-white">{{ 1 }}</span>
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-gray-200">
                        <!-- Tick Icon (Check Circle) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <div class="text-white text-base font-semibold mt-2">Picked Up</div>
            </div>
        </div>

        <!-- Order List Section -->
        <div class="bg-white p-4 shadow rounded">
            <h3 class="text-xl font-semibold mb-2">Order List</h3>
            <table class="w-full table-auto border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">No</th>
                        <th class="border px-4 py-2">Product</th>
                        <th class="border px-4 py-2">Date</th>
                        <th class="border px-4 py-2">Time</th>
                        <th class="border px-4 py-2">Order Status</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td class="border px-4 py-2">1</td>
                        <td class="border px-4 py-2">A4 Paper</td>
                        <td class="border px-4 py-2">04.06.2025</td>
                        <td class="border px-4 py-2">10:00 AM</td>
                        <td class="border px-4 py-2">Waiting</td>
                        <td class="border px-4 py-2">
                            <a href="#" class="bg-blue-500 text-white px-3 py-1 rounded">View</a>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td class="border px-4 py-2">2</td>
                        <td class="border px-4 py-2">Color Print</td>
                        <td class="border px-4 py-2">03.06.2025</td>
                        <td class="border px-4 py-2">02:30 PM</td>
                        <td class="border px-4 py-2">Printing</td>
                        <td class="border px-4 py-2">
                            <a href="#" class="bg-blue-500 text-white px-3 py-1 rounded">View</a>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td class="border px-4 py-2">3</td>
                        <td class="border px-4 py-2">Binding</td>
                        <td class="border px-4 py-2">02.06.2025</td>
                        <td class="border px-4 py-2">11:15 AM</td>
                        <td class="border px-4 py-2">Picked Up</td>
                        <td class="border px-4 py-2">
                            <a href="#" class="bg-blue-500 text-white px-3 py-1 rounded">View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>