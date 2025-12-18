<?php

namespace App\Livewire;

use App\Models\File;
use App\Service\FileManagerService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\LivewireFilepond\WithFilePond;

#[Title('مدیریت بیمه گذاران')]
class Policyholder extends Component
{
    use WithFilePond;

    /**
     *
     * @var Forms\Policyholder
     */
    public \App\Livewire\Forms\Policyholder $form;

    public ?int $id;

    public bool $status = true;

    /**
     * Listeners
     * @var string[]
     */
    protected $listeners = ['resetForm'];

    /**
     * Reset form
     * @return void
     */
    public function resetForm(): void
    {
        $this->form->reset();
    }

    /**
     * Change status of InsuranceType
     * @param $id
     * @return void
     */
    #[On('change-status')]
    public function changeStatus($id): void
    {
        $catalog = \App\Models\Policyholder::findOrFail($id);
        $catalog->status = !$catalog->status;
        $catalog->save();

        $this->dispatch('refreshTable');
    }

    /**
     * Store InsuranceType
     * @return void
     */
    public function store(): void
    {
        if (!auth()->user()->can('مدیریت بیمه گذاران')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $this->form->validate();

        $catalog = new \App\Models\Policyholder();
        $catalog->first_name = $this->form->first_name;
        $catalog->last_name = $this->form->last_name;
        $catalog->father_name = $this->form->father_name;
        $catalog->national_code = $this->form->national_code;
        $catalog->birthdate = $this->form->birthdate;
        $catalog->mobile = $this->form->mobile;
        $catalog->email = $this->form->email;
        $catalog->address = $this->form->address;
        $catalog->postal_code = $this->form->postal_code;
        $catalog->adder = auth()->user()->id;
        $catalog->save();

        if ($this->form->national_photo_file_up) {
            FileManagerService::saveFile($this->form->national_photo_file_up,'policy_holders',$catalog->id,\App\Models\Policyholder::class,'national_photo_file_up');
        }

        if ($this->form->national_photo_file_down) {
            FileManagerService::saveFile($this->form->national_photo_file_down,'policy_holders',$catalog->id,\App\Models\Policyholder::class,'national_photo_file_down');
        }

        if ($this->form->id_card_photo) {
            FileManagerService::saveFile($this->form->id_card_photo,'policy_holders',$catalog->id,\App\Models\Policyholder::class,'id_card_photo');
        }

        if ($this->form->personal_photo) {
            FileManagerService::saveFile($this->form->personal_photo,'policy_holders',$catalog->id,\App\Models\Policyholder::class,'personal_photo');
        }

        $this->reset();
        $this->dispatch('close-modal', 'create');
        $this->dispatch('show-notification', 'success-notification');
        $this->dispatch('refreshTable');
    }

    /**
     * Update InsuranceType
     * @return void
     */
    public function edit(): void
    {
        if (!auth()->user()->can('مدیریت بیمه گذاران')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $this->validate(['name' => 'string|required|max:255|unique:insurance_types,name,' . $this->id]);

        $catalog = \App\Models\Catalogs\InsuranceType::find($this->id);
        $catalog->name = $this->name;
        $catalog->status = $this->status;
        $catalog->editor = auth()->user()->id;
        $catalog->save();

        $this->reset();
        $this->dispatch('close-modal', 'edit');
        $this->dispatch('show-notification', 'success-notification');
        $this->dispatch('refreshTable');
    }

    /**
     * Get data before opened edit modal
     * @param $id
     * @return void
     */
    #[On('get_data')]
    public function get_data($id): void
    {
        if (!auth()->user()->can('مدیریت بیمه گذاران')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $catalog = \App\Models\Catalogs\InsuranceType::findOrFail($id);
        $this->id = $catalog->id;
        $this->name = $catalog->name;
        $this->status = (int)$catalog->status;
    }

    /**
     * Render the component
     * @return View|Application|Factory|\Illuminate\View\View
     */
    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.policyholder');
    }
}
