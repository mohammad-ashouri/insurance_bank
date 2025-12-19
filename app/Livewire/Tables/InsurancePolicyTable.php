<?php

namespace App\Livewire\Tables;

use App\Models\InsurancePolicy;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class InsurancePolicyTable extends DataTableComponent
{
    protected $model = InsurancePolicy::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Id", "id")
                ->sortable(),
        ];
    }
}
