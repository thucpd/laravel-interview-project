<div class="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
    <form action="{{ $action }}" method="POST" class="gap-x-4">
        @csrf
        <div>
            <label for="fruit_item_name" class="block text-sm font-medium text-gray-700">Name</label>
            <input  {{ $disabled ? "disabled=1" : ''}}  value="{{$fruitItem->fruit_item_name}}" type="text" id="fruit_item_name" name="fruit_item_name"
                    class="{{ $disabled ? 'disabled': ''}} w-full mt-1 block px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <span style="color: red" class="@error('fruit_item_name') is-invalid @else is-valid @enderror">
                @error('fruit_item_name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </span>
        </div>
        <div>
            <label for="fruit_category_id" class="block text-sm font-medium text-gray-700">Fruit Category</label>
            <select {{ $disabled ? "disabled=1" : ''}} name="fruit_category_id" id="fruit_category_id" class="mt-1 block w-48 px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">{{ 'Select' }}</option>
                @foreach($lookups['fruitCategories'] as $category)
                    <option value="{{ $category->fruit_category_id }}" {{ $fruitItem->fruit_category_id === $category->fruit_category_id ? 'selected' : '' }}>{{ $category->fruit_category_name }}</option>
                @endforeach
            </select>
            <span style="color: red" class="@error('fruit_category_id') is-invalid @else is-valid @enderror">
                @error('fruit_category_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </span>
        </div>
        <div>
            <label for="fruit_category_id" class="block text-sm font-medium text-gray-700">Unit</label>
            <select {{ $disabled ? "disabled=1" : ''}} name="unit_id" id="unit_id" class="mt-1 block w-48 px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">{{ 'Select' }}</option>
                @foreach($lookups['units'] as $unit)
                    <option value="{{ $unit->unit_id }}" {{ $unit->unit_id === $category->unit_id ? 'selected' : '' }}>{{ $unit->unit_name }}</option>
                @endforeach
            </select>
            <span style="color: red" class="@error('fruit_category_id') is-invalid @else is-valid @enderror">
                @error('fruit_category_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </span>
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <input  {{ $disabled ? "disabled=1" : ''}}  value="{{$fruitItem->price}}" type="text" id="price" name="price"
                    class="{{ $disabled ? 'disabled': ''}} w-full mt-1 block px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <span style="color: red" class="@error('price') is-invalid @else is-valid @enderror">
                @error('price')
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
