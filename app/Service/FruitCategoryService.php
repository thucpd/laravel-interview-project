<?php

namespace App\Service;

use App\Models\FruitCategory;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class FruitCategoryService extends BaseService
{
    public function getAll(array $inputs = [])
    {
        return FruitCategory::all();
    }

    public function addFruitCategory($fruitCategory): FruitCategory
    {
        $fruitCategory->save();
        return $fruitCategory;
    }

    public function initModel(): FruitCategory
    {
        return new FruitCategory();
    }

    public function get(int $id): FruitCategory
    {
        return FruitCategory::findOrFail($id);
    }

    public function assignOldInput($fruitCategory, $oldInput)
    {
        $fruitCategory->fruit_category_name = Arr::get($oldInput, 'fruit_category_name', $fruitCategory->fruit_category_name);
        $fruitCategory->fruit_category_desc = Arr::get($oldInput, 'fruit_category_desc', $fruitCategory->fruit_category_desc);
        return $fruitCategory;
    }

    public function validaterule($int = ''): array
    {
        return [
            'fruit_category_name' => [
                'required',
                Rule::unique('fruit_category')->ignore($int, 'fruit_category_id'),
            ],
            'fruit_category_desc' => 'max:255',
        ];
    }

    public function updateFruitCategory($fruitCategory, $inputs): FruitCategory
    {
        $fruitCategory->fill($inputs);
        $fruitCategory->save();
        return $fruitCategory;
    }

    public function delete(int $id)
    {
        return FruitCategory::where('fruit_category_id', $id)->delete();
    }

}
