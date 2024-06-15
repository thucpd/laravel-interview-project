<x-app-layout>
    <x-slot name="header">
        <div class="inline-flex">
            <a class="px-2 rounded-sm" style="background-color: #2dab48; border-radius: 10px" href="{{route('fruit-category')}}">Fruit Category List</a>
            |
            <a class="px-2" style="background-color: #2dab48; border-radius: 10px" href="{{route('fruit-category.create')}}">Create</a>
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
                <table class="table border-collapse table-auto w-full text-sm">
                    <thead>
                    <tr>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pb-3 text-slate-950 dark:text-slate-950 text-left">Action</th>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pb-3 text-slate-950 dark:text-slate-950 text-left">Fruit Name</th>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pb-3 text-slate-950 dark:text-slate-950 text-left">Fruit Description</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800">
                    @if(count($fruitCategories))
                        @foreach($fruitCategories as $fruitcategory)
                            <tr>
                                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-700 dark:text-slate-950">
                                    <a class="px-2 rounded-sm" style="background-color: #2dab48; border-radius: 10px"  href="{{ route('fruit-category.edit', $fruitcategory->getKey()) }}">Edit</a>
                                    <a class="px-2 rounded-sm text-white" style="background-color: #e16868; border-radius: 10px" href="{{ route('fruit-category.delete', $fruitcategory->getKey()) }}">Delete</a>
                                </td>
                                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-700 dark:text-slate-950">{{ $fruitcategory->fruit_category_name }}</td>
                                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-700 dark:text-slate-950">{{ $fruitcategory->fruit_category_desc }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-700 dark:text-slate-950" colspan="2">Data not found.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
