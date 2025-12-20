@props([
    'tags' => [],
    'wireModel' => '',
    'variable'=>'form.tags',
    'ignore'=>true,
    'loadDefaultTags'=>false,
    'allowUserInput'=>true,
    'placeholderText'=>'کلیدواژه ها را انتخاب کنید'
  ])

@php
    $defaultTags = json_encode($tags);
    $whitelist = json_encode($tags);
@endphp

<div
        @if($ignore)
            wire:ignore
        @endif
        x-data="{
        tagify: null,

        init() {
            this.$nextTick(() => {
                this.initializeTagify();
            });
        },

        initializeTagify() {
            const input = this.$refs.input;
            const allowUserInput = @json($allowUserInput);

            if (this.tagify) {
                this.tagify.destroy();
            }

            this.tagify = new Tagify(input, {
                whitelist: {{ $whitelist }},
                dropdown: {
                    mapValueTo: 'label',
                    classname: 'tagify__dropdown--rtl',
                    enabled: 0,
                    escapeHTML: false,
                    searchKeys: ['label'],
                },
                duplicates: false,
                skipInvalid: false,
                keepInvalidTags: false,
                editTags: false,
                maxTags: undefined,
                backspace: true,
                mode: 'select',
                originalInputValueFormat: valuesArr =>
                    valuesArr.map(item => ({
                        id: item.value,
                        label: item.label
                })),
                enforceWhitelist: allowUserInput,
                tagTextProp: 'label',
            });

            // تنظیم مقادیر اولیه
            const defaultTags = {{ $defaultTags }};
            const loadDefaultTags = @json($loadDefaultTags);
            if (loadDefaultTags && defaultTags && defaultTags.length > 0) {
                this.tagify.loadOriginalValues(defaultTags);
            }

            // هندل کردن تغییرات
             this.tagify.on('add', (e) => {
                const currentIds = this.tagify.value.map(tag => tag.value);
                @this.set('{{ $variable }}', currentIds);
            });

            this.tagify.on('remove', (e) => {
                const currentTags = this.tagify.value.map(tag => tag.value);
                @this.set('{{ $variable }}', currentTags);
            });

            this.tagify.on('invalid', (e) => {
                if (e.detail.message === 'duplicate') {
                    console.log('این تگ قبلاً اضافه شده است');
                }
            });
        }
    }"
>
    <style>
        .tag-container {
            display: flex;
            align-items: center;
            gap: 5px;
            width: 100%;
        }

        .tagify--rtl {
            color: black;
            background-color: white;
            width: 100%;
            box-sizing: border-box;
            border-radius: 8px;
            padding: 1px;
            border: 1px solid #ccc;
        }

        @media (prefers-color-scheme: dark) {
            .tagify--rtl {
                color: white;
                background-color: #111827;
                border-color: #555;
            }
        }
    </style>
    <div class="tag-container" wire:ignore>
        <input name='rtl' class='tagify--rtl' placeholder='{{ $placeholderText }}' x-ref="input">
    </div>
</div>

<script>
    // برای اطمینان از اجرای مجدد بعد از navigation
    document.addEventListener('livewire:navigated', () => {
        Alpine.initTree(document.body);
    });
</script>

