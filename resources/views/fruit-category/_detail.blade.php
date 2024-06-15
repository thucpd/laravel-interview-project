<div class="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
    <form action="{{ $action }}" method="POST" class="gap-x-4">
        @csrf
        <div>
            <label for="fruit_category_name" class="block text-sm font-medium text-gray-700">Name</label>
            <input {{ $disabled ? "disabled=1" : ''}}  value="{{$fruitCategory->fruit_category_name}}" type="text" id="fruit_category_name" name="fruit_category_name"
                    class="{{ $disabled ? 'disabled': ''}} w-full mt-1 block px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <span style="color: red" class="@error('fruit_category_name') is-invalid @else is-valid @enderror">
                @error('fruit_category_name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </span>
        </div>
        <div>
            <label for="fruit_category_desc" class="block text-sm font-medium text-gray-700">Desc</label>
            <input {{ $disabled ? "disabled=1" : ''}} value="{{$fruitCategory->fruit_category_desc}}" type="text" id="fruit_category_desc" name="fruit_category_desc"
                   class="{{ $disabled ? 'disabled': ''}} w-full mt-1 block w-8 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <span style="color: red" class="@error('fruit_category_name') is-invalid @else is-valid @enderror">
                @error('fruit_category_desc')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </span>
        </div>
        <div>
            <button style="margin-top: 10px" type="submit" class="w-48 px-4 py-2 bg-blue-500 text-black text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit
            </button>
        </div>
    </form>
</div>
