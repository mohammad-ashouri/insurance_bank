<?php

namespace App\Livewire;

use App\Models\Catalogs\InsuranceType;
use App\Service\FileManagerService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\LivewireFilepond\WithFilePond;

#[Title('مدیریت بیمه نامه ها')]
class InsurancePolicy extends Component
{
    use WithFilePond;

    /**
     *
     * @var Forms\InsurancePolicy
     */
    public \App\Livewire\Forms\InsurancePolicy $form;

    public ?int $id;

    public bool $status = true;

    public $insurance_policy_photo = null;
    public $vehicle_registration_card = null;
    public $id_card_photo = null;
    public $personal_photo = null;

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
     * Store InsuranceType
     * @return void
     */
    public function store(): void
    {
        if (!auth()->user()->can('مدیریت بیمه نامه ها')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $this->form->validate();

        $catalog = new \App\Models\InsurancePolicy();
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
            FileManagerService::saveFile($this->form->national_photo_file_up, 'policy_holders', $catalog->id, \App\Models\InsurancePolicy::class, 'national_photo_file_up');
        }

        if ($this->form->national_photo_file_down) {
            FileManagerService::saveFile($this->form->national_photo_file_down, 'policy_holders', $catalog->id, \App\Models\InsurancePolicy::class, 'national_photo_file_down');
        }

        if ($this->form->id_card_photo) {
            FileManagerService::saveFile($this->form->id_card_photo, 'policy_holders', $catalog->id, \App\Models\InsurancePolicy::class, 'id_card_photo');
        }

        if ($this->form->personal_photo) {
            FileManagerService::saveFile($this->form->personal_photo, 'policy_holders', $catalog->id, \App\Models\InsurancePolicy::class, 'personal_photo');
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
        if (!auth()->user()->can('مدیریت بیمه نامه ها')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $catalog = \App\Models\InsurancePolicy::find($this->id);
        $catalog->first_name = $this->form->first_name;
        $catalog->last_name = $this->form->last_name;
        $catalog->father_name = $this->form->father_name;
        $catalog->national_code = $this->form->national_code;
        $catalog->birthdate = $this->form->birthdate;
        $catalog->mobile = $this->form->mobile;
        $catalog->email = $this->form->email;
        $catalog->address = $this->form->address;
        $catalog->postal_code = $this->form->postal_code;
        $catalog->editor = auth()->user()->id;
        $catalog->save();

        if ($this->form->national_photo_file_up) {
            FileManagerService::deleteFile($catalog->id, \App\Models\InsurancePolicy::class, 'national_photo_file_up');
            FileManagerService::saveFile($this->form->national_photo_file_up, 'policy_holders', $catalog->id, \App\Models\InsurancePolicy::class, 'national_photo_file_up');
        }

        if ($this->form->national_photo_file_down) {
            FileManagerService::deleteFile($catalog->id, \App\Models\InsurancePolicy::class, 'national_photo_file_down');
            FileManagerService::saveFile($this->form->national_photo_file_down, 'policy_holders', $catalog->id, \App\Models\InsurancePolicy::class, 'national_photo_file_down');
        }

        if ($this->form->id_card_photo) {
            FileManagerService::deleteFile($catalog->id, \App\Models\InsurancePolicy::class, 'id_card_photo');
            FileManagerService::saveFile($this->form->id_card_photo, 'policy_holders', $catalog->id, \App\Models\InsurancePolicy::class, 'id_card_photo');
        }

        if ($this->form->personal_photo) {
            FileManagerService::deleteFile($catalog->id, \App\Models\InsurancePolicy::class, 'personal_photo');
            FileManagerService::saveFile($this->form->personal_photo, 'policy_holders', $catalog->id, \App\Models\InsurancePolicy::class, 'personal_photo');
        }

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
        if (!auth()->user()->can('مدیریت بیمه نامه ها')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $catalog = \App\Models\InsurancePolicy::findOrFail($id);
        $this->id = $catalog->id;
        $this->form->first_name = $catalog->first_name;
        $this->form->last_name = $catalog->last_name;
        $this->form->father_name = $catalog->father_name;
        $this->form->national_code = $catalog->national_code;
        $this->form->birthdate = $catalog->birthdate;
        $this->form->mobile = $catalog->mobile;
        $this->form->email = $catalog->email;
        $this->form->address = $catalog->address;
        $this->form->postal_code = $catalog->postal_code;

        $this->national_photo_file_up = FileManagerService::getFile($catalog->id, \App\Models\InsurancePolicy::class, 'national_photo_file_up');
        $this->national_photo_file_down = FileManagerService::getFile($catalog->id, \App\Models\InsurancePolicy::class, 'national_photo_file_down');
        $this->id_card_photo = FileManagerService::getFile($catalog->id, \App\Models\InsurancePolicy::class, 'id_card_photo');
        $this->personal_photo = FileManagerService::getFile($catalog->id, \App\Models\InsurancePolicy::class, 'personal_photo');
    }

    /**
     * Render the component
     * @return View|Application|Factory|\Illuminate\View\View
     */
    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        $policyholders = \App\Models\Policyholder::where('status', 1)
            ->orderBy('last_name')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'full_name' => $item->policyholder_full_name,
                ];
            })
            ->toArray();
        $insurance_types = InsuranceType::where('status', 1)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        return view('livewire.insurance-policy', [
            'policyholders' => $policyholders,
            'insurance_types' => $insurance_types,
        ]);
    }
}
