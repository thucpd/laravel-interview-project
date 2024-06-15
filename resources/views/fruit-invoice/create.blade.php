<x-app-layout>
    <x-slot name="header">
        <div class="inline-flex">
            <a class="px-2 rounded-sm" style="background-color: #2dab48; border-radius: 10px" href="{{route('fruit-invoice')}}">Fruit Invoice List</a>
            |
            <a class="px-2" style="background-color: #2dab48; border-radius: 10px" href="{{route('fruit-invoice.create')}}">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-300 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-medium">{{session('status')}}</span>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @include('fruit-invoice._detail')
            </div>
        </div>
    </div>
</x-app-layout>
