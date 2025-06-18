<div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Success Message --}}
    <div class="text-center text-green-600 font-bold">{{ session('message') }}</div>

    {{-- Staff Table --}}
    <div class="flex flex-col gap-6">
        <flux:heading class="px-10 flex items-center gap-2" size="xl">
            All Staff
            <flux:badge variant="primary">
                {{ $staffs->total() }}
            </flux:badge>
        </flux:heading>

        <div class="rounded-xl border shadow-sm bg-white overflow-x-auto">
            <div class="px-10 py-8">
                <table class="w-full table-auto border-collapse rounded-xl overflow-hidden text-sm">
                    <thead>
                        <tr class="bg-yellow-500 text-white uppercase text-sm">
                            <th class="p-2 text-center">ID</th>
                            <th class="p-2 text-left">Name</th>
                            <th class="p-2 text-left">Email</th>
                            <th class="p-2 text-center">Role</th>
                            <th class="p-2 text-center">Position</th>
                            <th class="p-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffs as $staff)
                            <tr class="{{ $loop->even ? 'bg-yellow-200' : 'bg-yellow-300' }} hover:bg-blue-200 transition duration-200 border-b">
                                <td class="p-2 text-center">{{ $staff->id }}</td>
                                <td class="p-2">{{ $staff->name }}</td>
                                <td class="p-2">{{ $staff->email }}</td>
                                <td class="p-2 text-center">{{ ucfirst($staff->role) }}</td>
                                <td class="p-2 text-center">{{ ucfirst($staff->position) }}</td>
                                <td class="p-2 text-center space-x-2">
                                    <flux:button wire:click="edit({{ $staff->id }})" icon="pencil-square" variant="primary" class="bg-sky-500 text-white rounded-md text-sm" />
                                    <flux:button wire:click="$dispatch('confirmDelete', {{ $staff->id }})" icon="trash" variant="danger" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 flex justify-center">
                    {{ $staffs->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    <br>

    {{-- Staff Form --}}
    <div class="flex flex-col gap-6">
        <div class="rounded-xl border">
            <br>
            <flux:heading class="px-10" size="xl">{{ $staffId ? 'Edit Staff' : 'Add Staff' }}</flux:heading>
            <div class="px-10 py-8">
                <form wire:submit.prevent="save" class="space-y-4 mb-6">
                    <div class="grid grid-col-2 gap-4">
                        <flux:input wire:model="name" label="Name" placeholder="Staff Name"/>
                        <flux:input wire:model="email" label="Email" placeholder="Email Address"/>
                        <flux:input wire:model="password" type="password" label="Password" placeholder="{{ $staffId ? 'Leave blank to keep current password' : 'Password' }}"/>

                        {{-- Role dropdown (Fixed to Admin) --}}
                        <div class="flex flex-col">
                            <label for="role" class="font-medium text-sm text-gray-700 mb-1">Role</label>
                            <select wire:model="role" id="role" class="border rounded-md px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        {{-- Position dropdown --}}
                        <div class="flex flex-col">
                            <label for="position" class="font-medium text-sm text-gray-700 mb-1">Position</label>
                            <select wire:model="position" id="position" class="border rounded-md px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                                <option value="SuperAdmin">SuperAdmin</option>
                                <option value="Designer">Designer</option>
                                <option value="Manager">Manager</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Production Staff">Production Staff</option>
                            </select>
                        </div>

                        <div class="flex justify-start w-full">
                            <flux:button type="submit" variant="primary" icon="paper-airplane" class="mt-6 bg-green-500 text-white rounded-md text-sm">
                                {{ $staffId ? 'Edit' : 'Add' }}
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JS for SweetAlert --}}
    <script>
        document.addEventListener('livewire:init', function() {
            Livewire.on('staffSaved', function(res) {
                Swal.fire('Success!', res.message, 'success');
            });

            Livewire.on('confirmDelete', function(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This staff member will be permanently deleted.",
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
            Livewire.on('userDeleteFailed', e => alert(e.message));
            Livewire.on('userSaved', e => alert(e.message));
        });
        

</script>

</div>
