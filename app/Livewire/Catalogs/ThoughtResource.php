<?php

namespace App\Livewire\Catalogs;

use App\Service\FileManagerService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\LivewireFilepond\WithFilePond;

#[Title('مقادیر اولیه - منبع اندیشه')]
class ThoughtResource extends Component
{
    use WithFilePond;

    #[Validate('nullable|exists:thought_resources,id')]
    public $id;

    public $name;

    public $attachment_file;

    public $thought_resource_photo;

    /**
     * Listeners
     * @var string[]
     */
    protected $listeners = [
        'resetCatalogName',
        'set-selected-id' => 'setSelectedId',
    ];

    /**
     * Set selected id
     * @param $id
     * @return void
     */
    public function setSelectedId($id): void
    {
        $this->id = \App\Models\Catalogs\ThoughtResource::findOrFail($id)->id;
    }

    /**
     * Reset catalog name before new modal opened
     * @return void
     */
    public function resetCatalogName(): void
    {
        $this->reset('name');
    }

    /**
     * Store thought resource
     * @return void
     */
    public function store(): void
    {
        $this->validate([
            'name' => 'required|string|max:15|unique:thought_resources,name',
            'attachment_file' => 'required|file|mimes:jpeg,jpg,png|max:300|dimensions:min_width:50,min_height:50,max_width:50,max_height:50'
        ]);
        $thought_resource = \App\Models\Catalogs\ThoughtResource::create([
            'name' => $this->name,
            'adder' => auth()->user()->id,
        ]);

        if ($thought_resource) {
            FileManagerService::saveFile($this->attachment_file, 'catalogs/thought_resources', $thought_resource->id, \App\Models\Catalogs\ThoughtResource::class, 'thought_resource_image');
        }

        $this->dispatch('close-modal', 'create');
        $this->dispatch('show-notification', 'success-notification');
        $this->dispatch('filepond-reset');
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
        $catalog = \App\Models\Catalogs\ThoughtResource::findOrFail($id);
        $this->id = $catalog->id;
        $this->name = $catalog->name;
        $this->thought_resource_photo = $catalog->attachmentFile->src;
    }

    /**
     * Update thought resource
     * @return void
     */
    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|max:15|unique:thought_resources,name,' . $this->id,
            'attachment_file' => 'nullable|file|mimes:jpeg,jpg,png|max:300|dimensions:min_width:50,min_height:50,max_width:50,max_height:50'
        ]);
        $thought_resource = \App\Models\Catalogs\ThoughtResource::find($this->id)
            ->update([
                'name' => $this->name,
                'editor' => auth()->user()->id,
            ]);

        if ($thought_resource and $this->attachment_file) {
            FileManagerService::deleteFile($this->id, \App\Models\Catalogs\ThoughtResource::class, 'thought_resource_image');
            FileManagerService::saveFile($this->attachment_file, 'catalogs/thought_resources', $this->id, \App\Models\Catalogs\ThoughtResource::class, 'thought_resource_image');
        }

        $this->dispatch('close-modal', 'edit');
        $this->dispatch('show-notification', 'success-notification');
        $this->dispatch('filepond-reset');
        $this->dispatch('refreshTable');
    }

    /**
     * Render the component
     * @return View|Application|Factory|\Illuminate\View\View
     */
    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        if (!auth()->user()->can('مقادیر اولیه | مدیریت منبع اندیشه')) {
            abort(403, 'دسترسی غیرمجاز');
        }
        return view('livewire.catalogs.thought-resource');
    }
}
