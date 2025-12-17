<div class="flex gap-1 justify-center">
    @if($buttons)
        @if(in_array('edit',$buttons))
            {{-- دکمه ویرایش --}}
            @if(isset($route))
                <x-secondary-button
                        wire:navigate
                        href="{{ $route }}"
                        title="ویرایش"
                >ویرایش
                </x-secondary-button>
            @else
                <x-secondary-button
                        x-on:click="$dispatch('open-modal', 'edit'); $dispatch('get_data', { id: {{ $row->id }} } );"
                        title="ویرایش"
                >ویرایش
                </x-secondary-button>
            @endif
        @endif

        @if(in_array('delete',$buttons))
            {{-- دکمه حذف --}}
            <x-danger-button
                    x-on:click="$dispatch('open-modal', 'confirm-delete'); $dispatch('set_delete_id', { id: {{ $row->id }} }); $dispatch('set-selected-id', [{{ $row->id }}]);"
                    title="حذف"
            >
                حذف
            </x-danger-button>
        @endif

        @if(in_array('fields',$buttons))
            <a wire:navigate
               href="{{ route($fields_route, $row->id) }}">
                <x-success-button
                        title="فیلدها"
                >فیلدها
                </x-success-button>
            </a>
        @endif

        @if(in_array('invoices',$buttons))
            <a
               target="_blank"
               href="{{ route($invoices_route, $row->id) }}">
                <x-success-button
                        title="فاکتورها"
                >فاکتورها
                </x-success-button>
            </a>
        @endif
    @endif
</div>
