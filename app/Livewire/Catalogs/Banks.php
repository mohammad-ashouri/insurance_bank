<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Bank;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('مقادیر اولیه - مدیریت بانک ها')]
class Banks extends Component
{
    use WithPagination;

    public ?int $id;

    #[Validate('string|required|max:255|unique:banks,name')]
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
     * Change status of bank
     * @param $id
     * @return void
     */
    #[On('change-status')]
    public function changeStatus($id): void
    {
        $bank = Bank::findOrFail($id);
        $bank->status = !$bank->status;
        $bank->save();

        $this->dispatch('refreshTable');
    }

    /**
     * Store Bank
     * @return void
     */
    public function store(): void
    {
        if (!auth()->user()->can('مقادیر اولیه | مدیریت بانک ها')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $this->validate();

        $slider = new Bank();
        $slider->name = $this->name;
        $slider->adder = auth()->user()->id;
        $slider->save();

        $this->reset();
        $this->dispatch('close-modal', 'create');
        $this->dispatch('show-notification', 'success-notification');
        $this->dispatch('refreshTable');
    }

    /**
     * Update Bank
     * @return void
     */
    public function edit(): void
    {
        if (!auth()->user()->can('مقادیر اولیه | مدیریت بانک ها')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $this->validate(['name' => 'string|required|max:255|unique:banks,name,' . $this->id]);

        $cycle = Bank::find($this->id);
        $cycle->name = $this->name;
        $cycle->status = $this->status;
        $cycle->editor = auth()->user()->id;
        $cycle->save();

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
        if (!auth()->user()->can('مقادیر اولیه | مدیریت بانک ها')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $cycle = Bank::findOrFail($id);
        $this->id = $cycle->id;
        $this->name = $cycle->name;
        $this->status = (int)$cycle->status;
    }

    /**
     * Render the component
     * @return Factory|View|\Illuminate\View\View
     */
    public function render(): Factory|View|\Illuminate\View\View
    {
        if (!auth()->user()->can('مقادیر اولیه | مدیریت بانک ها')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $banks = Bank::orderByDesc('created_at')->paginate(50);
        return view('livewire.catalogs.banks', [
            'banks' => $banks ?? collect(),
        ]);
    }
}
