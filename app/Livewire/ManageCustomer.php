<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ManageCustomer extends Component
{
    use WithPagination;

    public $name, $email, $password, $role = 'user', $customerId;
    protected $paginationTheme = 'bootstrap'; // optional: for Tailwind use 'tailwind'

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->customerId,
            'role' => 'required|in:user,admin',
            'password' => $this->customerId ? 'nullable|min:6' : 'required|min:6',
        ];
    }

    // public function render()
    // {
    //     // Show both user and admin in the list (since you can assign roles now)
    //     $customers = User::paginate(10);
    //     return view('livewire.manage-customer', ['customers' => $customers]);
    // }

    public function render()
{
    return view('livewire.manage-customer', [
        'customers' => User::where('role', 'user')->paginate(10),
    ]);
}

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->customerId) {
            $user = User::find($this->customerId);
            $user->update($data);
            $this->dispatch('customerSaved', message: 'Customer updated successfully.');
        } else {
            // Make sure password is always required when creating
            $data['password'] = Hash::make($this->password);
            User::create($data);
            $this->dispatch('customerSaved', message: 'Customer created successfully.');
        }

        $this->resetInput();
    }

    public function edit($id)
    {
        $user = User::find($id);

        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->customerId = $user->id;
        $this->password = ''; // Leave empty unless changed
    }

    // public function delete($id)
    // {
    //     $user = User::find($id);
    //     $user->delete();

    //     session()->flash('message', 'Customer deleted successfully.');
    //     $this->dispatch('customerSaved', message: 'Customer deleted successfully.');
    // }

    public function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'user';
        $this->customerId = null;
    }


     #[On('delete')]
    public function delete($id){
        $user = User::find($id);
        $user->delete();
        session()->flash('message', 'User Deleted Successfully.');
        $this->dispatch('userSaved', message:'User Deleted Successfully.');
    }

