<?php

namespace App\Livewire\Catalogs;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('مقادیر اولیه - مدیریت انواع بیمه')]
class InsuranceType extends Component
{
    public ?int $id;

    #[Validate('string|required|max:255|unique:insurance_types,name')]
    public string $name;

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
        $this->reset();
    }

    /**
     * Change status of InsuranceType
     * @param $id
     * @return void
     */
    #[On('change-status')]
    public function changeStatus($id): void
    {
        $catalog = \App\Models\Catalogs\InsuranceType::findOrFail($id);
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
        if (!auth()->user()->can('مقادیر اولیه | مدیریت انواع بیمه')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $this->validate();

        $catalog = new \App\Models\Catalogs\InsuranceType();
        $catalog->name = $this->name;
        $catalog->adder = auth()->user()->id;
        $catalog->save();

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
        if (!auth()->user()->can('مقادیر اولیه | مدیریت انواع بیمه')) {
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
        if (!auth()->user()->can('مقادیر اولیه | مدیریت انواع بیمه')) {
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
        return view('livewire.catalogs.insurance-type');
    }
}
