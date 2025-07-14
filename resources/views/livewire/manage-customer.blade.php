<div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Success message --}}
    @if(session('message'))
        <div class="text-center text-green-600 font-semibold mt-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Customer Table --}}
<div class="flex flex-col gap-6">
    <div class="px-10 flex items-center justify-between">
        <flux:heading class="flex items-center gap-2" size="xl">
            All Customers
            <flux:badge variant="primary">
                {{ $customers->total() }}
            </flux:badge>
        </flux:heading>

        <button
            onclick="document.getElementById('customer-form').scrollIntoView({ behavior: 'smooth' });"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm"
        >
            + Add Customer
        </button>
    </div>
{{-- Scroll to Top Floating Button --}}
{{-- Scroll to Top Floating Button --}}
<button
    onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
    class="fixed bottom-6 right-6 z-50 bg-gray-700 hover:bg-gray-900 text-black w-14 h-14 rounded-full shadow-lg flex items-center justify-center transition-all duration-300"
    style="right: 2rem; bottom: 2rem;"
    aria-label="Scroll to top"
    title="Scroll to top">
    <span class="text-2xl">↑</span>
</button>




        <div class="rounded-xl border shadow-sm bg-white overflow-x-auto">
            <div class="px-10 py-8">
                <table class="w-full table-auto border-collapse rounded-xl overflow-hidden text-sm">
                    <thead>
                        <tr class="bg-yellow-500 text-white uppercase text-sm">
                            {{-- <th class="p-2 text-center">ID</th> --}}
                            <th class="p-2 text-left">Name</th>
                            <th class="p-2 text-left">Email</th>
                            <th class="p-2 text-center">Role</th>
                            <th class="p-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $cs)
                            <tr class="{{ $loop->even ? 'bg-yellow-200' : 'bg-yellow-100' }} hover:bg-blue-200 transition duration-200 border-b">
                                {{-- <td class="p-2 text-center">
                                    {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                                </td> --}}
                                <td class="p-2">{{ $cs->name }}</td>
                                <td class="p-2">{{ $cs->email }}</td>
                                <td class="p-2 text-center">{{ ucfirst($cs->role) }}</td>
                                <td class="p-2 text-center space-x-2">
                                    <flux:button 
                                        wire:click="edit({{ $cs->id }})" 
                                        icon="pencil-square" 
                                        variant="primary" 
                                        class="bg-sky-500 text-white rounded-md text-sm" 
                                    />
                                    <flux:button 
                                        wire:click="$dispatch('confirmDelete', {{ $cs->id }})" 
                                        icon="trash" 
                                        variant="danger" 
                                        class="bg-red-500 text-white rounded-md text-sm"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 flex justify-center">
                    {{ $customers->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
    <br>
    

   {{-- Customer Form --}}
<div id="customer-form" class="flex flex-col gap-6">

        <div class="rounded-xl border">
            <br>
            <flux:heading class="px-10" size="xl">{{ $customerId ? 'Edit Customer' : 'Add Customer' }}</flux:heading>
            <div class="px-10 py-8">
                <form wire:submit.prevent="save" class="space-y-4 mb-6">
                    <div class="grid grid-col-2 gap-4">
                        <flux:input wire:model="name" label="Name" placeholder="Customer Name"/>
                        <flux:input wire:model="email" label="Email" placeholder="Email Address"/>
                        <flux:input wire:model="password" type="password" label="Password" placeholder="{{ $customerId ? 'Leave blank to keep current password' : 'Password' }}"/>

                        {{-- Role dropdown --}}
                        <div class="flex flex-col">
                            <label for="role" class="font-medium text-sm text-gray-700 mb-1">Role</label>
                            <select wire:model="role" id="role" class="border rounded-md px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        {{-- Submit button --}}
                        <div class="flex justify-start w-full">
                            <flux:button type="submit" variant="primary" icon="paper-airplane" class="mt-6 bg-green-500 text-white rounded-md text-sm">
                                {{ $customerId ? 'Edit' : 'Add' }}
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>  
        
    </div>
    

    {{-- JavaScript --}}
    <script>
        document.addEventListener('livewire:init', function() {
            Livewire.on('customerSaved', function(res) {
                Swal.fire('Success!', res.message, 'success');
            });

            Livewire.on('confirmDelete', function(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This customer will be permanently deleted.",
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
    {{-- Scroll to Top Button (Half-visible on Right) --}}
<!-- Scroll to Top Button (Half-visible on Right) -->

    
    
</div>

