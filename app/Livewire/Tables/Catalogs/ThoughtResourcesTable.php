<?php

namespace App\Livewire\Tables\Catalogs;

use App\Models\Catalogs\ThoughtResource;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ThoughtResourcesTable extends DataTableComponent
{
    protected $model = ThoughtResource::class;

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
            Column::make('نام', "name")
                ->searchable()
                ->sortable(),
            Column::make('فایل پیوست', "attachmentFile.src")
                ->label(function ($model) {
                    return view('components.table.attachment_file', [
                        'src' => $model->attachmentFile->src,
                    ]);
                })
                ->html(),
            Column::make("ثبت کننده", "adderInfo.name")
                ->searchable()
                ->sortable(),
            Column::make("تاریخ ثبت", "created_at")
                ->format(function ($created_at) {
                    return Jalalian::fromCarbon($created_at)->format("H:i:s Y/m/d");
                })
                ->searchable()
                ->sortable(),
            Column::make("ویرایشگر", "editorInfo.name")
                ->sortable()
                ->searchable(),
            Column::make('تاریخ ویرایش', "updated_at")
                ->format(function ($date, $model) {
                    return $model['editorInfo.name'] != null ? Jalalian::forge($date)->format('H:i:s Y/m/d') : null;
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
            });
        }

        $data = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'نام' => $item->name,
                'فایل پیوست' => isset($item->attachmentFile->src) ? env('APP_URL') . $item->attachmentFile->src : '',
                'ثبت کننده' => $item->adderInfo->name,
                'تاریخ ثبت' => Jalalian::fromCarbon($item->created_at)->format("Y/m/d H:i:s"),
                'ویرایش کننده' => $item->editorInfo?->name,
                'تاریخ ویرایش' => Jalalian::fromCarbon($item->updated_at)->format("Y/m/d H:i:s"),
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
        }, "مقادیر اولیه - منبع اندیشه.xlsx");
    }
}
