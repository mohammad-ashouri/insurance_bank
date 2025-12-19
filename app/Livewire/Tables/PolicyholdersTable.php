<?php

namespace App\Livewire\Tables;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Policyholder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PolicyholdersTable extends DataTableComponent
{
    protected $model = Policyholder::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchPlaceholder('جستجو در تمام جدول (حساس به حروف بزرگ و کوچک)');
        $this->setSearchDebounce(1000);
        $this->setSearchIcon('heroicon-m-magnifying-glass');
        $this->setDefaultSort('created_at', 'desc');
    }

    protected $listeners = ['refreshTable' => '$refresh'];

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("نام", "first_name")
                ->sortable(),
            Column::make("نام خانوادگی", "last_name")
                ->sortable(),
            Column::make("نام پدر", "father_name")
                ->sortable(),
            Column::make("کد ملی", "national_code")
                ->sortable(),
            Column::make("تاریخ تولد", "birthdate")
                ->sortable(),
            Column::make("شماره همراه", "mobile")
                ->sortable(),
            Column::make("ثبت کننده", "adderInfo.name")
                ->sortable(),
            Column::make('تاریخ ثبت',"created_at")
                ->format(function ($model) {
                    return Jalalian::forge($model)->format('H:i:s Y/m/d');
                })
                ->sortable(),
            Column::make("ویرایشگر", "editorInfo.name")
                ->sortable(),
            Column::make('تاریخ ویرایش',"updated_at")
                ->format(function ($date,$model) {
                    return $model['editorInfo.name']!=null ? Jalalian::forge($date)->format('H:i:s Y/m/d') : null;
                })
                ->sortable(),
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
                        $query->where('status', $value);
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
