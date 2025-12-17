<?php

namespace App\Livewire\Tables\Catalogs;

use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Catalogs\ServiceTypeField;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ServiceTypeFieldsTable extends DataTableComponent
{
    protected $model = ServiceTypeField::class;

    public $service_type;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchPlaceholder('جستجو در تمام جدول (حساس به حروف بزرگ و کوچک)');
        $this->setSearchDebounce(1000);
        $this->setSearchIcon('heroicon-m-magnifying-glass');
        $this->setDefaultSort('priority', 'asc');
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return ServiceTypeField::query()->where('service_type_id', $this->service_type);
    }

    protected $listeners = ['refreshTable' => '$refresh'];

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("فیلد", "id")
                ->format(function ($model, $field) {
                    $service_type_field = ServiceTypeField::find($model);
                    return $service_type_field->fieldInfo->name . ' (' . $service_type_field->fieldInfo->fieldTypeInfo->name . ')';
                })
                ->searchable()
                ->sortable(),
            Column::make("فیلد اجباری", "is_required")
                ->format(function ($model, $field) {
                    return $field->is_required ? 'بله' : "خیر";
                })
                ->searchable()
                ->sortable(),
            Column::make("کمترین مقدار", "min")
                ->searchable()
                ->sortable(),
            Column::make(" بیشترین مقدار", "max")
                ->searchable()
                ->sortable(),
            Column::make(" مقدار پیش فرض", "default_value")
                ->searchable()
                ->sortable(),
            Column::make("اولویت", "priority")
                ->searchable()
                ->sortable(),
            Column::make('وضعیت', "is_active")
                ->format(function ($value, $row) {
                    return view('components.table.toggle', [
                        'checked' => (bool)$value,
                        'id' => $row->id,
                    ]);
                })
                ->html()
                ->searchable()
                ->sortable(),
            Column::make('عملیات')
                ->label(fn($row) => view('components.table.actions', [
                    'row' => $row,
                    'buttons' => [
                        'edit',
                        'delete',
                    ],
                ]))
                ->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('وضعیت')
                ->options([
                    '' => 'همه',
                    true => 'فعال',
                    false => 'غیرفعال',
                ])
                ->filter(function ($query, $value) {
                    if (isset($value) and $value !== '') {
                        $query->where('is_active', $value);
                    }
                }),
        ];
    }

    public function exportExcel(): BinaryFileResponse
    {
        $service_type_info = (clone $this->builder())->first()->serviceTypeInfo;
        $query = $this->builder();


        if ($this->getSearch()) {
            $search = $this->getSearch();
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
                $q->orWhere('is_required', 'like', "%{$search}%");
                $q->orWhere('is_active', 'like', "%{$search}%");
                $q->orWhere('min', 'like', "%{$search}%");
                $q->orWhere('max', 'like', "%{$search}%");
                $q->orWhere('priority', 'like', "%{$search}%");
                $q->orWhere('default_value', 'like', "%{$search}%");
            });
        }

        if (isset($this->getAppliedFilters()['وضعیت'])) {
            $query->where('is_active', $this->getAppliedFilters()['وضعیت']);
        }

        $data = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'فیلد' => $item->fieldInfo->name . ' (' . $item->fieldInfo->fieldTypeInfo->name . ')',
                'فیلد اجباری' => $item->is_required ? 'بله' : "خیر",
                'کمترین مقدار' => $item->min,
                'بیشترین مقدار' => $item->max,
                'مقدار پیش فرض' => $item->default_value,
                'اولویت' => $item->priority,
                'وضعیت' => $item->is_active ? 'فعال' : 'غیرفعال',
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
        }, "مقادیر اولیه - انواع سرویس - فیلدهای $service_type_info->name.xlsx");
    }
}
