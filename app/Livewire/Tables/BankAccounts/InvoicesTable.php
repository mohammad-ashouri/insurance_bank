<?php

namespace App\Livewire\Tables\BankAccounts;

use Carbon\Carbon;
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

    public $bank_account;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchPlaceholder('جستجو در تمام جدول (حساس به حروف بزرگ و کوچک)');
        $this->setSearchDebounce(1000);
        $this->setSearchIcon('heroicon-m-magnifying-glass');
        $this->setDefaultSort('status', 'desc');
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Invoice::query()->with(['serviceInfo', 'bankAccountInfo'])->where('bank_account_id', $this->bank_account->id);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("اطلاعات سرویس", "serviceInfo.title")
                ->label(function ($query, $field) {
                    $invoice = Invoice::findOrFail($query->id);
                    return $invoice->serviceInfo->id . " - " . $invoice->serviceInfo->title;
                })
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
                'اطلاعات سرویس' => $item->serviceInfo->id . " - " . $item->serviceInfo->title,
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
        }, "مقادیر اولیه - فاکتورهای حساب بانکی.xlsx");
    }
}
