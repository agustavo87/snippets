<x-layouts.base :title="$title">
    <div class="bg-gray-50 border-b px-10 py-4">
        <nav>
            <ol class="flex items-center">
                <li>
                    <a href="{{ route('components', ['path' => '']) }}"
                        class="text-indigo-600 hover:text-indigo-400">Inicio</a>
                </li>
                @foreach (explode('/', $path) as $i => $pathPart)
                <li class="flex items-center px-1 sm:px-2 opacity-25">
                    <svg class="hi-outline hi-chevron-right inline-block w-6 h-6" stroke="currentColor" fill="none"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </li>
                <li>
                    <a href="{{ route('components', ['path' => $pathStructure[$i + 1]]) }}"
                        class="text-indigo-600 hover:text-indigo-400">
                        {{ $pathPart}}
                    </a>
                </li>
                @endforeach
                </li>
            </ol>
        </nav>
        <div><strong class="text-gray-600">{{ $title }}</strong></div>
    </div>
    <div class=" pt-2 pb-8 px-8">

        <div class="w-full pt-12">
            <iframe class="border w-full mx-auto p-6"
                style="height: {{ key_exists('height', $attributes) ? $attributes['height'] . 'px' : '500px' }} ; width: {{ key_exists('width', $attributes) ? $attributes['width'] . 'px' : '1200px' }}"
                src="{{ route('components', ['path' => $relativePath ,'html' => 'true']) }}">
            </iframe>
        </div>

        <div x-data="{edit: false}" class=" my-5 ">

            @if(session('status'))
            <div x-data="{open: true}" class="bg-green-50 mb-4 p-4 rounded-md"
                x-init="setTimeout(() => {open = false}, 5000)" x-show="open" x-transition>
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Heroicon name: solid/check-circle -->
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('status') }}
                        </p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button x-on:click="open = false" type="button"
                                class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                                <span class="sr-only">Dismiss</span>
                                <!-- Heroicon name: solid/x -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif


            <div class="flex justify-end">
                <button x-on:click="edit = !edit" x-text="edit ? 'Listo' : 'Configurar'"
                    class="border focus:outline-none focus:ring-indigo-500 font-medium hover:bg-indigo-700 hover:text-white inline-flex items-center px-2.5 py-1.5 rounded shadow-sm text-indigo-600 text-xs">Configurar</button>
            </div>

            <div x-show="edit" class="border my-4" style="display: none">
                <div class="border-b-2 m-4 pb-2">
                    <ul class="text-gray-800 text-sm">
                        @forelse ($attributes as $name => $value)
                        <li><strong>{{ $name }}:</strong> {{$value}}</li>
                        @empty
                        <li class="text-gray-400">Sin attributos</li>
                        @endforelse
                    </ul>
                </div>
                <form action="{{ route('path.configure') }}" method="post"
                    class="flex flex-col items-stretch max-w-lg mx-auto space-y-6 m-6">
                    @csrf
                    <input type="hidden" name="path" value="{{ $relativePath }}">
                    <div class="flex space-x-2">
                        <div class="flex-1">
                            <label for="width" class="block text-sm font-medium text-gray-700">Width</label>
                            <div class="mt-1">
                                <input type="number" name="data[width]" id="width"
                                    value="{{ key_exists('width', $attributes) ? $attributes['width'] : '0' }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="##px">
                            </div>
                        </div>
                        <div class="flex-1">
                            <label for="height" class="block text-sm font-medium text-gray-700">Height</label>
                            <div class="mt-1">
                                <input type="number" name="data[height]" id="height"
                                    value="{{ key_exists('height', $attributes) ? $attributes['height'] : '0' }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="##px">
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="self-end inline-flex items-center px-4 py-2 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Configurar
                    </button>
                </form>
            </div>

        </div>
        <hr class="my-8">
        <pre>
            <code class="text-sm h-96 overflow-auto w-full">
                {{ $html }}
            </code>
        </pre>
    </div>

</x-layouts.base>
