<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ManageStaff extends Component
{
    use WithPagination;

    public $name, $email, $password, $role = 'admin', $position, $staffId;
    protected $paginationTheme = 'bootstrap'; // optional: use 'tailwind' if you're using Tailwind CSS

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->staffId,
            'role' => 'required|in:admin',
            'position' => 'required|string|max:255',
            'password' => $this->staffId ? 'nullable|min:6' : 'required|min:6',
        ];
    }

    public function render()
    {
        return view('livewire.manage-staff', [
            'staffs' => User::where('role', 'admin')->paginate(10),
        ]);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'position' => $this->position,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->staffId) {
            $user = User::find($this->staffId);
            $user->update($data);
            $this->dispatch('staffSaved', message: 'Staff updated successfully.');
        } else {
            $data['password'] = Hash::make($this->password);
            User::create($data);
            $this->dispatch('staffSaved', message: 'Staff created successfully.');
        }

        $this->resetInput();
    }

    public function edit($id)
    {
        $user = User::find($id);

        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->position = $user->position;
        $this->staffId = $user->id;
        $this->password = ''; // Leave empty unless changed
    }

    // public function delete($id)
    // {
    //     $user = User::find($id);
    //     $user->delete();

    //     session()->flash('message', 'Staff deleted successfully.');
    //     $this->dispatch('staffSaved', message: 'Staff deleted successfully.');
    // }

    public function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'admin';
        $this->position = '';
        $this->staffId = null;
    }

    #[On('delete')]
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            session()->flash('message', 'User Deleted Successfully.');
            $this->dispatch('userSaved', message: 'User Deleted Successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                // Foreign key constraint violation
                session()->flash('error', 'Cannot delete user. The user is linked to other records.');
                $this->dispatch('userDeleteFailed', message: 'Cannot delete user. The user is linked to other records.');
            } else {
                session()->flash('error', 'Database error occurred.');
                $this->dispatch('userDeleteFailed', message: 'Database error occurred.');
            }

            Log::error('User delete failed (QueryException): ' . $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', 'Unexpected error: ' . $e->getMessage());
            $this->dispatch('userDeleteFailed', message: 'Unexpected error: ' . $e->getMessage());

            Log::error('User delete failed (Exception): ' . $e->getMessage());
        }
    }

}
