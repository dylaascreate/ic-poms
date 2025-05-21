<div>
    {{-- likewire must in div --}}
    {{-- form --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- success message --}}
    <div class="text-center text-green-600 bold">{{ session('message') }}</div>
    {{-- table --}}
    <div class="flex flex-col gap-6">
            {{-- heading --}}
            <flux:heading class="px-10 flex items-center gap-2" size="xl">
                All Products 
                <flux:badge variant="primary">
                    {{ $products->total() }}
                </flux:badge>
            </flux:heading>

        <div class="rounded-xl border">
            
            <div class="px-10 py-8">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>Id</th>
                            {{-- <th style="text-align: left">Image</th> --}}
                            <th style="text-align: left">Name</th>
                            <th style="text-align: left">Description</th>
                            <th>Price</th>
                            <th>Action{{--  --}} {{-- column for action button --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $pt)    {{-- loop through products --}}
                        <tr>
                            <td class="px-2 text-center">{{ $pt->id }}</td>
                            <td>{{ $pt->name }}</td>
                            {{-- <td>{{ $pt->Image }}</td> --}}
                            <td class="px-2" style="min-width: 500px">{{ $pt->description }}</td>
                            <td class="px-2 text-center">{{ $pt->price }}</td>
                            <td class="py-2 text-center">
                                <flux:button wire:click="edit({{ $pt->id }})" icon="pencil-square" variant="primary"></flux:button>
                                <flux:button wire:click="$dispatch('confirmDelete',{{ $pt->id }})" icon="trash" variant="danger"></flux:button>
                            </td>                               {{-- column for action button --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center p-2">
                    {{-- pagination --}}
                    {{ $products->links() }} {{-- pagination links --}}
            </div>
        </div>
    </div>
</div>
<br>
<div class="flex flex-col gap-6">
    <div class="rounded-xl border">
        <br>
        
        {{-- heading --}}
        <flux:heading class="px-10" size="xl">{{ $productId ? 'Edit Product' : 'Add Product' }}</flux:heading> 
        <div class="px-10 py-8">
        {{-- inset form here --}}
            <form wire:submit.prevent="save" class="space-y-4 mb-6">
                <div class="grid grid-col-2 gap-4">
                    <flux:input wire:model="name" label="Product Name" placeholder="Product Name"/>
                    {{-- wire:model is used to kept temp data into model --}}
                    <flux:textarea wire:model="description" label="Description" placeholder="Description"/>
                    <flux:input wire:model="price" label="Price" placeholder="Price"/>
                    {{-- button --}}
                    <flux:button type="submit" variant="primary" icon="paper-airplane">{{ $productId ? 'Edit' : 'Add' }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</div>
<br>

{{-- script --}}
<script>
    document.addEventListener('livewire:init', function(){
        // alert('Livewire is loaded');
        // Swal.fire('Hi','Hello world!', 'error');
        // Swal.fire('Hi','Hello world!', 'warning');
        Livewire.on('productSaved', function(res){ // show success alert // res is passed from controller
            // Swal.fire('Success!', 'Product saved successfully!', 'success');
            Swal.fire('Success!', res.message, 'success'); // res.message is passed from controller
        });

        Livewire.on('confirmDelete', function(id){ // show confirm delete alert // id is passed from button
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete', {id: id});
                }
            })
        });
    });
</script>
{{-- script --}}
