<?php

namespace App\Livewire\Tables\BankAccounts;

use App\Models\Catalogs\Bank;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\BankAccount;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BankAccountsIndexTable extends DataTableComponent
{
    protected $model = BankAccount::class;

    protected $listeners = ['refreshTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchPlaceholder('جستجو در تمام جدول (حساس به حروف بزرگ و کوچک)');
        $this->setSearchDebounce(1000);
        $this->setSearchIcon('heroicon-m-magnifying-glass');
        $this->setDefaultSort('status', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("بانک", "bankInfo.name")
                ->sortable()
                ->searchable(),
            Column::make("شماره کارت", "card_number")
                ->sortable()
                ->searchable(),
            Column::make("شماره حساب", "account_number")
                ->sortable()
                ->searchable(),
            Column::make("شبا", "shaba")
                ->sortable(),
            Column::make("Cvv2", "cvv2")
                ->sortable(),
            Column::make("تاریخ انقضا", "expiration_date")
                ->sortable(),
            Column::make("رمز", "password")
                ->sortable(),
            Column::make("مقدار اولیه", "amount")
                ->format(function ($grid) {
                    return number_format($grid) . " ریال";
                })
                ->sortable(),
            Column::make("باقیمانده", "amount")
                ->format(function ($grid,$value) {
                    return number_format($value->remaining_amount) . " ریال";
                })
                ->sortable(),
            Column::make("تحویل گیرنده", "deliverInfo.name")
                ->sortable(),
            Column::make('وضعیت', "status")
                ->format(function ($value,$row){
                    return view('components.table.toggle', [
                        'checked' => $value,
                        'id' => $row->id,
                    ]);
                })
                ->html()
                ->sortable(),
            Column::make('عملیات')
                ->label(fn($row) => view('components.table.actions', [
                    'row' => $row,
                    'buttons' => [
                        'edit',
                        'invoices',
                    ],
                    'invoices_route' => 'bank_accounts.invoices'
                ]))
                ->html(),
        ];
    }

    public function filters(): array
    {
        return [
            MultiSelectFilter::make('بانک')
                ->options($this->bankAccounts())
                ->filter(function ($query, $value) {
                    if (!empty($value)) {
                        $query->whereIn('bank_accounts.bank_id', $value);
                    }
                }),
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

    public function bankAccounts(): array
    {
        $bank_accounts = BankAccount::query()->distinct('bank_id')->pluck('bank_id')->toArray();
        $banks = [];
        foreach ($bank_accounts as $bank_account) {
            $bank=Bank::findOrFail($bank_account);
            $banks[$bank->id] = $bank->name;
        }
        return $banks;
    }

    public function exportExcel(): BinaryFileResponse
    {
        $query = $this->builder();

        if ($this->getAppliedFilters()['بانک']) {
            $query->whereIn('bank_accounts.bank_id', $this->getAppliedFilters()['بانک']);
        }
        if (isset($this->getAppliedFilters()['وضعیت'])) {
            $query->where('status', $this->getAppliedFilters()['وضعیت']);
        }

        if ($this->getSearch()) {
            $search = $this->getSearch();
            $query->where(function ($q) use ($search) {
                $q->where('card_number', 'like', "%{$search}%")
                    ->orWhere('account_number', 'like', "%{$search}%")
                    ->orWhereHas('bankInfo', fn($b) => $b->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('deliverInfo', fn($d) => $d->where('name', 'like', "%{$search}%"));
            });
        }

        $data = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'بانک' => $item->bankInfo->name,
                'شماره کارت' => $item->card_number,
                'شماره حساب' => $item->account_number,
                'شبا' => $item->shaba,
                'cvv2' => $item->cvv2,
                'تاریخ انقضا' => $item->expiration_date,
                'رمز' => $item->password,
                'مقدار اولیه' => $item->amount,
                'باقیمانده' => $item->remaining_amount,
                'تحویل گیرنده' => $item->deliverInfo->name,
                'وضعیت' => $item->status ? 'فعال' : 'غیرفعال',
            ];
        });

        return Excel::download(new class($data) implements FromCollection, WithHeadings {
            protected $data;
            public function __construct($data) {
                $this->data = $data; }
            public function collection() { return $this->data; }
            public function headings(): array
            {
                return array_keys($this->data[0]);
            }
        }, 'حساب های بانکی.xlsx');
    }
}
