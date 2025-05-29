<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ManageProduct extends Component
{
    use WithFileUploads;

    public $image, $name, $description, $price, $productId; // public properties for input fields


    protected $rules = [
        'name' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048',
    ];// validation rules (error-handling)
    
    public function render()
    {
        // $data['products'] = Product::get(); // get all products
        // return view('livewire.product-index');
        $data['products'] = Product::paginate(10); // get all products with pagination
        return view('livewire.manage-product', $data);
        
    }

    public function save(){
        $this->validate(); // validate input
        $input['name'] = $this->name;
        $input['description'] = $this->description;
        $input['price'] = $this->price;

        // Handle image upload if provided
        if ($this->image) {
            $input['image'] = $this->image->store('products', 'public');
        }

        if($this->productId){
            $product = Product::find($this->productId);

            // If new image uploaded, delete old one (optional)
            if (isset($input['image']) && $product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->update($input);
            // session()->flash('message', 'Product Updated Successfully.');
            // $this->dispatch('productSaved'); // dispatch event to notify parent component
            $this->dispatch('productSaved', message:'Product Updated Successfully.');
            }else{
                Product::create($input);
                // session()->flash('message', 'Product Created Successfully.');
                $this->dispatch('productSaved', message:'Product created successfully.');
        }
        $this->reset();
    }

    public function edit($id){
        $product = Product::find($id);
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;       
        $this->image = $product->image;

        // $productId = $product->id; // get product id
        $this->productId = $product->id; // set product id to public property
    }

    // public function deleteConfirm($id){
    //     $this->dispatch('confirmDelete', id:$id, message:'Are you sure you want to delete this product?');
    // }

    #[On('delete')]
    public function delete($id){
        $product = Product::find($id);
        $product->delete();
        session()->flash('message', 'Product Deleted Successfully.');
        $this->dispatch('productSaved', message:'Product Deleted Successfully.');
    }
}