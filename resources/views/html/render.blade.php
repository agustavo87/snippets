<x-layouts.base>
    {{-- {{ dd($html) }} --}}
    <div class=" pt-8 pb-8 px-8">
        <ul class="list-inside text-sm text-gray-800">
            <li class=" list-item"class=" list-item"><i> {{ $path }} </i></li>
            <li class=" list-item"><strong>{{ $file }}</strong></li>
        </ul>
        <hr>
        <div class="border m-4 p-4">
            {!! $html !!}
        </div>
        <hr class="my-8">
        <pre>
            <code class="text-sm h-72 overflow-auto w-full">
                {{ $html }}
            </code>
        </pre>
    </div>
</x-layouts.base>
