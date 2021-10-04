<x-layouts.base>
    <main class="container mx-auto">
        <h1 class=" text-xl py-4 font-bold text-gray-700">Links</h1>
        <ul class="list-inside list-disc text-sm">
            @forelse ($links as $path => $href)
                <li> <a href="{{ $href }}" class="text-blue-900 hover:text-blue-700"> {{ $path }} </a></li>
            @empty
                <p>Directorio vacío o inexistente.</p>
            @endforelse
        </ul>
    </main>
</x-layouts.base>
