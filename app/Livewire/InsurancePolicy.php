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
    public Forms\InsurancePolicy $form;

    public $insurance_policy_photo = null;
    public $attachment_insurance_photo = null;
    public $vehicle_card_up = null;
    public $vehicle_card_down = null;

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
     * Store InsuranceType
     * @return void
     */
    public function store(): void
    {
        if (!auth()->user()->can('مدیریت بیمه نامه ها')) {
            abort(403, 'دسترسی غیرمجاز');
        }
        $this->form->validate();
        $this->form->validate([
            'policy_holder_id' => 'required|array',
            'policy_holder_id.*' => 'required|exists:policyholders,id',
            'owner_id' => 'required|array',
            'owner_id.*' => 'required|exists:policyholders,id',
            'insurance_type' => 'required|array',
            'insurance_type.*' => 'required|exists:insurance_types,id',
        ]);

        $catalog = new \App\Models\InsurancePolicy();
        $catalog->policyholder_id = (int)$this->form->policy_holder_id[0];
        $catalog->owner_id = (int)$this->form->owner_id[0];
        $catalog->insurance_type_id = (int)$this->form->insurance_type[0];
        $catalog->starts_at = $this->form->starts_at;
        $catalog->ends_at = $this->form->ends_at;
        $catalog->insurance_policy_number = $this->form->insurance_policy_number;
        $catalog->adder = auth()->user()->id;
        $catalog->save();

        if ($this->form->insurance_policy_photo) {
            FileManagerService::saveFile($this->form->insurance_policy_photo, 'insurance_policy', $catalog->id, \App\Models\InsurancePolicy::class, 'insurance_policy_photo');
        }

        if ($this->form->attachment_insurance_photo) {
            FileManagerService::saveFile($this->form->attachment_insurance_photo, 'insurance_policy', $catalog->id, \App\Models\InsurancePolicy::class, 'attachment_insurance_photo');
        }

        if ($this->form->vehicle_card_up) {
            FileManagerService::saveFile($this->form->vehicle_card_up, 'insurance_policy', $catalog->id, \App\Models\InsurancePolicy::class, 'vehicle_card_up');
        }

        if ($this->form->vehicle_card_down) {
            FileManagerService::saveFile($this->form->vehicle_card_down, 'insurance_policy', $catalog->id, \App\Models\InsurancePolicy::class, 'vehicle_card_down');
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
        $this->form->validate();
        $this->form->validate([
            'policy_holder_id' => 'required|array',
            'policy_holder_id.*' => 'required|exists:policyholders,id',
            'owner_id' => 'required|array',
            'owner_id.*' => 'required|exists:policyholders,id',
            'insurance_type' => 'required|array',
            'insurance_type.*' => 'required|exists:insurance_types,id',
        ]);

        $catalog = \App\Models\InsurancePolicy::find($this->id);
        $catalog->policy_holder_id = $this->form->policy_holder_id;
        $catalog->owner_id = $this->form->owner_id;
        $catalog->insurance_type = $this->form->insurance_type;
        $catalog->starts_at = $this->form->starts_at;
        $catalog->ends_at = $this->form->ends_at;
        $catalog->insurance_policy_number = $this->form->insurance_policy_number;
        $catalog->editor = auth()->user()->id;
        $catalog->save();

        if ($this->form->insurance_policy_photo) {
            FileManagerService::deleteFile($catalog->id, \App\Models\InsurancePolicy::class, 'insurance_policy_photo');
            FileManagerService::saveFile($this->form->insurance_policy_photo, 'insurance_policy', $catalog->id, \App\Models\InsurancePolicy::class, 'insurance_policy_photo');
        }

        if ($this->form->attachment_insurance_photo) {
            FileManagerService::deleteFile($catalog->id, \App\Models\InsurancePolicy::class, 'attachment_insurance_photo');
            FileManagerService::saveFile($this->form->attachment_insurance_photo, 'insurance_policy', $catalog->id, \App\Models\InsurancePolicy::class, 'attachment_insurance_photo');
        }

        if ($this->form->vehicle_card_up) {
            FileManagerService::deleteFile($catalog->id, \App\Models\InsurancePolicy::class, 'vehicle_card_up');
            FileManagerService::saveFile($this->form->vehicle_card_up, 'insurance_policy', $catalog->id, \App\Models\InsurancePolicy::class, 'vehicle_card_up');
        }

        if ($this->form->vehicle_card_down) {
            FileManagerService::deleteFile($catalog->id, \App\Models\InsurancePolicy::class, 'vehicle_card_down');
            FileManagerService::saveFile($this->form->vehicle_card_down, 'insurance_policy', $catalog->id, \App\Models\InsurancePolicy::class, 'vehicle_card_down');
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
            ->map(function ($policyholder) {
                return [
                    'value' => $policyholder->id,
                    'label' => "$policyholder->policyholder_full_name ($policyholder->mobile)",
                ];
            })
            ->toArray();

        $insurance_types = InsuranceType::where('status', 1)
            ->orderBy('name')
            ->get()
            ->map(function ($insurance_type) {
                return [
                    'value' => $insurance_type->id,
                    'label' => $insurance_type->name,
                ];
            })
            ->toArray();

        return view('livewire.insurance-policy', [
            'policyholders' => $policyholders,
            'insurance_types' => $insurance_types,
        ]);
    }
}
