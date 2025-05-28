<div class="p-6 bg-gray-100 min-h-screen">
    <h2 class="text-2xl font-bold mb-4">User Dashboard</h2>

    <div class="grid grid-cols-5 gap-4 mb-6">
        <!-- Total Order Card -->
        <div class="bg-white text-center p-4 rounded shadow border flex flex-col items-center">
            <div class="flex flex-row w-full justify-between items-center mb-2">
                <span class="text-3xl font-bold text-gray-800">{{ 115 }}</span>
                <!-- Product Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V7a2 2 0 00-2-2h-3.17a2 2 0 01-1.41-.59l-1.83-1.83A2 2 0 009.17 2H6a2 2 0 00-2 2v5m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0H4" />
                </svg>
            </div>
            <div class="text-gray-600 text-sm w-full">Total Order</div>
        </div>
        <!-- Checking Card -->
        <div class="bg-yellow-400 text-center p-4 rounded shadow text-white flex flex-col items-center">
            <div class="flex flex-row w-full justify-between items-center mb-2">
                <span class="text-3xl font-bold">{{ 10 }}</span>
                <!-- Checking Icon (Magnifying Glass) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </div>
            <div class="text-sm w-full">Checking</div>
        </div>
        <!-- Printing Card -->
        <div class="bg-green-500 text-center p-4 rounded shadow text-white flex flex-col items-center">
            <div class="flex flex-row w-full justify-between items-center mb-2">
                <span class="text-3xl font-bold">{{ 25 }}</span>
                <!-- Print Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V4h12v5M6 18h12v-5H6v5zm0 0v2a2 2 0 002 2h8a2 2 0 002-2v-2" />
                </svg>
            </div>
            <div class="text-sm w-full">Printing</div>
        </div>
        <!-- Ready Pick Up Card -->
        <div class="bg-blue-500 text-center p-4 rounded shadow text-white flex flex-col items-center">
            <div class="flex flex-row w-full justify-between items-center mb-2">
                <span class="text-3xl font-bold">{{ 30 }}</span>
                <!-- Pick Up Icon (Truck) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zm10 0a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 011-1h3a1 1 0 011 1v10m-1-4h-4m-6 0V6a1 1 0 011-1h3a1 1 0 011 1v10" />
                </svg>
            </div>
            <div class="text-sm w-full">Ready Pick Up</div>
        </div>
        <!-- Done Pick Up Card -->
        <div class="bg-gray-400 text-center p-4 rounded shadow text-white flex flex-col items-center">
            <div class="flex flex-row w-full justify-between items-center mb-2">
                <span class="text-3xl font-bold">{{ 50 }}</span>
                <!-- Tick Icon (Check Circle) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="text-sm w-full">Done Pick Up</div>
        </div>
    </div>

    <div class="bg-white p-4 shadow rounded">
        <h3 class="text-xl font-semibold mb-2">Order List</h3>
        <table class="w-full table-auto border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Product</th>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Time</th>
                    <th class="border px-4 py-2">Pick-up Details</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td class="border px-4 py-2">1</td>
                    <td class="border px-4 py-2">Fabric</td>
                    <td class="border px-4 py-2">23.5.2025</td>
                    <td class="border px-4 py-2">5.00 p.m.</td>
                    <td class="border px-4 py-2">014 312 3546</td>
                    <td class="border px-4 py-2">
                        <button class="bg-blue-500 text-white px-3 py-1 rounded">View</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>