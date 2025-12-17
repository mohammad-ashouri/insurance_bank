<?php

namespace App\Livewire\Tables\Catalogs;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Catalogs\Field;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FieldsTable extends DataTableComponent
{
    protected $model = Field::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchPlaceholder('جستجو در تمام جدول (حساس به حروف بزرگ و کوچک)');
        $this->setSearchDebounce(1000);
        $this->setSearchIcon('heroicon-m-magnifying-glass');
        $this->setDefaultSort('fields.created_at', 'desc');
    }

    protected $listeners = ['refreshTable' => '$refresh'];

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("نوع فیلد", "fieldTypeInfo.name")
                ->sortable()
                ->searchable(),
            Column::make("نام", "name")
                ->sortable()
                ->searchable(),
            Column::make("نام انگلیسی", "model_name")
                ->sortable()
                ->searchable(),
            Column::make("مقادیر", "options")
                ->format(function ($field, $options) {
                    return !empty($options->options) ? implode(',', json_decode($options->options, true)) : null;
                })
                ->sortable()
                ->searchable(),
            Column::make('عملیات')
                ->label(fn($row) => view('components.table.actions', [
                    'row' => $row,
                    'buttons' => [
                        'edit',
                    ],
                ]))
                ->html(),
        ];
    }

    public function exportExcel(): BinaryFileResponse
    {
        $query = $this->builder();

        if ($this->getSearch()) {
            $search = $this->getSearch();
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
                $q->orWhereHas('fieldTypeInfo', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
                $q->orWhere('model_name', 'like', "%{$search}%");
            });
        }

        $data = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'نوع فیلد' => $item->fieldTypeInfo->name,
                'نام' => $item->name,
                'نام انگلیسی' => $item->model_name,
                'مقادیر' => !empty($item->options) ? implode(',', json_decode($item->options, true)) : null,
            ];
        });

        return Excel::download(new class($data) implements FromCollection, WithHeadings {
            protected $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                return $this->data;
            }

            public function headings(): array
            {
                return array_keys($this->data[0]);
            }
        }, 'مقادیر اولیه - فیلد ها.xlsx');
    }
}
