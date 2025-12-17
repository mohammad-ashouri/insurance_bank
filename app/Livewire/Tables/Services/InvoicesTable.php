<?php

namespace App\Livewire\Tables\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Services\Invoice;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class InvoicesTable extends DataTableComponent
{
    protected $model = Invoice::class;

    protected $listeners = ['refreshTable' => '$refresh'];

    public $service;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchPlaceholder('جستجو در تمام جدول (حساس به حروف بزرگ و کوچک)');
        $this->setSearchDebounce(1000);
        $this->setSearchIcon('heroicon-m-magnifying-glass');
        $this->setDefaultSort('created_at', 'desc');
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Invoice::query()->with(['serviceInfo', 'bankAccountInfo'])->where('service_id', $this->service->id);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("اطلاعات سرویس", "serviceInfo.title")
                ->label(function ($query) {
                    $invoice = Invoice::findOrFail($query->id);
                    return $invoice->serviceInfo->id . " - " . $invoice->serviceInfo->title;
                })
                ->searchable()
                ->sortable(),
            Column::make("بانک", "bank_account_id")
                ->format(function ($bank, $bank_account_id) {
                    return $bank_account_id->bankAccountInfo->bankInfo->name . ' - ' . $bank_account_id->bankAccountInfo->card_number;
                })
                ->searchable()
                ->sortable(),
            Column::make("مبلغ", "amount")
                ->format(function ($amount) {
                    return number_format($amount) . ' ریال';
                })
                ->searchable()
                ->sortable(),
            Column::make("تاریخ پرداخت", "payment_date")
                ->format(function ($paymentDate) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $paymentDate)->format('H:i:s Y/m/d');
                })
                ->searchable()
                ->sortable(),
            Column::make("توضیحات", "description")
                ->searchable()
                ->sortable(),
            Column::make('فایل پیوست', "attachmentFile.src")
                ->format(function ($src) {
                    return view('components.table.attachment_file', [
                        'src' => $src,
                    ]);
                })
                ->html()
                ->sortable(),
            Column::make("ثبت کننده", "adderInfo.name")
                ->searchable()
                ->sortable(),
            Column::make("تاریخ ثبت", "created_at")
                ->format(function ($created_at) {
                    return Jalalian::fromCarbon($created_at)->format("H:i:s Y/m/d");
                })
                ->searchable()
                ->sortable(),
            Column::make('عملیات')
                ->label(fn($row) => view('components.table.actions', [
                    'row' => $row,
                    'buttons' => [
                        'delete',
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
                'آی دی سرویس' => $item->serviceInfo->id,
                'بانک' => $item->bankAccountInfo->bankInfo->name . ' - ' . $item->bankAccountInfo->card_number,
                'مبلغ' => number_format($item->amount) . ' ریال',
                'تاریخ پرداخت' => $item->payment_date,
                'توضیحات' => $item->description,
                'فایل پیوست' => isset($item->attachmentFile->src) ? env('APP_URL') . $item->attachmentFile->src : '',
                'ثبت کننده' => $item->adderInfo->name,
                'تاریخ ثبت' => Jalalian::fromCarbon($item->created_at)->format("Y/m/d H:i:s"),
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
        }, "مقادیر اولیه - فاکتورهای سرویس.xlsx");
    }
}
