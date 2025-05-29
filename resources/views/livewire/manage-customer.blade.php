<div>
    {{-- Livewire must be inside a div --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Success message --}}
    <div class="text-center text-green-600 bold">{{ session('message') }}</div>

    {{-- Customer Table --}}
    <div class="flex flex-col gap-6">
        <flux:heading class="px-10 flex items-center gap-2" size="xl">
            All Customers
            <flux:badge variant="primary">
                {{ $customers->total() }}
            </flux:badge>
        </flux:heading>

        <div class="rounded-xl border">
            <div class="px-10 py-8">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="text-align: left">Name</th>
                            <th style="text-align: left">Email</th>
                            <th style="text-align: left">Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $cs)
                            <tr>
                                <td class="px-2 text-center">{{ $cs->id }}</td>
                                <td>{{ $cs->name }}</td>
                                <td>{{ $cs->email }}</td>
                                <td class="text-center">{{ ucfirst($cs->role) }}</td>
                                <td class="py-2 text-center">
                                    <flux:button wire:click="edit({{ $cs->id }})" icon="pencil-square" variant="primary"></flux:button>
                                    <flux:button wire:click="$dispatch('confirmDelete', {{ $cs->id }})" icon="trash" variant="danger"></flux:button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-center p-2">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
    <br>

    {{-- Customer Form --}}
    <div class="flex flex-col gap-6">
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
                        <flux:button type="submit" variant="primary" icon="paper-airplane">{{ $customerId ? 'Edit' : 'Add' }}</flux:button>
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
</div>
