<div class="relative flex flex-col min-w-full" x-data="{open: false}" x-on:click="open=true" x-on:click.away="open=false">
    <div class="flex min-w-full p-4 overflow-x-auto bg-gray-100 outline-none rounded-xl" contenteditable="true">
        @foreach ($value as $i => $item)
            @if ($item['type'] === 'field')
                <div class="px-2 py-1 mx-1 text-gray-500 bg-white border border-gray-200 cursor-pointer rounded-xl" contenteditable="false">
                    {{ $item['translation'] }}
                    <a wire:click="deleteItem({{ $i }})" class="mx-2 cursor-pointer">X</a>
                </div>
            @else
                <div class="px-2 py-1 mx-1 text-gray-500" contenteditable="true">{{ $item['value'] }}</div>
            @endif
        @endforeach
    </div>
    <div class="absolute z-10 min-w-full p-4 bg-white border border-blue-400 top-14 rounded-xl" x-show="open">
        <div style="border-bottom: 2px solid #eaeaea" x-data="{module: '{{ $modules[0]['name'] }}' }">
            <ul class="flex cursor-pointer">
                @foreach ($modules as $module)
                    <li class="px-6 py-2 bg-white rounded-t-lg"
                        x-on:click="module = '{{ $module['name'] }}'"
                        :class="{'text-gray-500': module !== '{{ $module['name'] }}', 'bg-gray-200': module !== '{{ $module['name'] }}'}">{{ $module['translation'] }}</li>
                @endforeach
            </ul>

            @foreach ($modules as $module)
                <div class="grid grid-cols-2 gap-4" x-show="module === '{{ $module['name'] }}'">
                    @foreach ($module['fields'] as $field)
                        <a wire:click="addField('{{ $module['name'] }}', '{{ $field['name'] }}', '{{ $field['translation'] }}')" class="px-2 py-1 mx-1 text-gray-500 bg-white border border-gray-200 cursor-pointer rounded-xl">{{ $field['translation'] }}</a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
