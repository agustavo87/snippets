<x-layouts.base :title="$title">
    {{-- {{ dd($html) }} --}}
    <div class=" pt-8 pb-8 px-8">
        <ul class="list-inside text-sm text-gray-800">
            <li class=" list-item"class=" list-item"><i> {{ $path }} </i></li>
            <li class=" list-item"><strong>{{ $title }}</strong></li>
        </ul>
        <hr>
        <div class="w-full px-8 pt-8">
            <iframe class="border w-full h-64 p-4" src="{{ route('components', ['path' => $relativePath ,'html' => 'true']) }}">
            </iframe>
        </div>
        <hr class="my-8">
        <pre>
            <code class="text-sm h-72 overflow-auto w-full">
                {{ $html }}
            </code>
        </pre>
    </div>
</x-layouts.base>
