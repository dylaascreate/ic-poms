<?php
// app/Livewire/ManagePromotion.php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Promotion;
use Illuminate\Support\Facades\Storage;

class ManagePromotion extends Component
{
    use WithFileUploads;

    public $promotionId, $title, $description, $image, $oldImage;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('promotions', 'public');
            if ($this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
        }

        if ($this->promotionId) {
            Promotion::find($this->promotionId)->update($data);
            session()->flash('message', 'Promotion updated!');
        } else {
            Promotion::create($data);
            session()->flash('message', 'Promotion created!');
        }

        $this->reset(['promotionId', 'title', 'description', 'image', 'oldImage']);
    }

    public function edit($id)
    {
        $promo = Promotion::findOrFail($id);
        $this->promotionId = $promo->id;
        $this->title = $promo->title;
        $this->description = $promo->description;
        $this->oldImage = $promo->image;
    }

    public function delete($id)
    {
        $promo = Promotion::findOrFail($id);
        if ($promo->image) {
            Storage::disk('public')->delete($promo->image);
        }
        $promo->delete();
        session()->flash('message', 'Promotion deleted!');
    }

    public function render()
    {
        return view('livewire.manage-promotion', [
            'promotions' => Promotion::latest()->paginate(10),
        ]);
    }
}