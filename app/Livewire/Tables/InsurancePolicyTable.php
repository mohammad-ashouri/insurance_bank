<?php

namespace App\Livewire\Tables;

use App\Models\InsurancePolicy;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class InsurancePolicyTable extends DataTableComponent
{
    protected $model = InsurancePolicy::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchPlaceholder('جستجو در تمام جدول (حساس به حروف بزرگ و کوچک)');
        $this->setSearchDebounce(1000);
        $this->setSearchIcon('heroicon-m-magnifying-glass');
        $this->setDefaultSort('created_at', 'desc');
        $this->setQueryStringStatusForSearch(true);
    }

    protected $listeners = ['refreshTable' => '$refresh'];

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return InsurancePolicy::query()->with(['policyholderInfo', 'ownerInfo', 'insuranceTypeInfo']);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("نام", "policyholderInfo.first_name")
                ->sortable()
                ->searchable(),
            Column::make('تاریخ ثبت',"created_at")
                ->format(function ($model) {
                    return Jalalian::forge($model)->format('H:i:s Y/m/d');
                })
                ->sortable()
                ->searchable(),
            Column::make("ویرایشگر", "editorInfo.name")
                ->sortable()
                ->searchable(),
//            Column::make('تاریخ ویرایش',"updated_at")
//                ->format(function ($date,$model) {
//                    return $model['editorInfo.name']!=null ? Jalalian::forge($date)->format('H:i:s Y/m/d') : null;
//                })
//                ->sortable()
//                ->searchable(),
//            Column::make('عملیات')
//                ->label(fn($row) => view('components.table.actions', [
//                    'row' => $row,
//                    'buttons' => [
//                        'edit',
//                    ],
//                ]))
//                ->html(),
        ];
    }

    public function filters(): array
    {
        $all=[0 => 'همه'];
        $adders=array_merge($all,User::whereIn('id',InsurancePolicy::distinct('adder')->pluck('adder')->toArray())->orderBy('name')->pluck('name','id')->toArray());
        $editors=array_merge($all,User::whereIn('id',InsurancePolicy::distinct('editor')->pluck('adder')->toArray())->orderBy('name')->pluck('name','id')->toArray());
        return [
            SelectFilter::make('وضعیت')
                ->options([
                    '' => 'همه',
                    true => 'فعال',
                    false => 'غیرفعال',
                ])
                ->filter(function ($query, $value) {
                    if (isset($value) and $value !== '') {
                        $query->where('policyholders.status', $value);
                    }
                }),
            SelectFilter::make('ثبت کننده')
                ->options($adders)
                ->filter(function ($query, $value) {
                    if (isset($value) and $value !== '') {
                        $query->where('policyholders.adder', $value);
                    }
                }),
            SelectFilter::make('ویرایشگر')
                ->options($editors)
                ->filter(function ($query, $value) {
                    if (isset($value) and $value !== '') {
                        $query->where('policyholders.editor', $value);
                    }
                }),
        ];
    }

    public function exportExcel(): BinaryFileResponse
    {
        $query = $this->builder();

        if ($this->getSearch()) {
            $search = $this->getSearch();
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if (isset($this->getAppliedFilters()['وضعیت'])) {
            $query->where('status', $this->getAppliedFilters()['وضعیت']);
        }

        $data = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'نام' => $item->first_name,
                'نام خانوادگی' => $item->last_name,
                'نام پدر' => $item->father_name,
                'کد ملی' => $item->national_code,
                'تاریخ تولد' => $item->birthdate,
                'شماره همراه' => $item->mobile,
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
        }, 'بیمه گذاران.xlsx');
    }
}
