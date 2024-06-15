<?php

namespace App\Service;

use App\Models\FruitCategory;
use App\Models\FruitItem;
use App\Models\Unit;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class FruitItemService extends BaseService
{
    public function getAll(array $inputs = [])
    {
        return FruitItem::query()
            ->join(
                'fruit_category',
                'fruit_category.fruit_category_id',
                '=',
                'fruit_item.fruit_category_id'
            )->join(
                'unit',
                'unit.unit_id',
                '=',
                'fruit_item.unit_id'
            )->select([
                'fruit_item.fruit_item_id',
                'fruit_item.fruit_item_name',
                'fruit_item.price',
                'fruit_category.fruit_category_name',
                'fruit_category.fruit_category_id',
                'unit.unit_name',
                'unit.unit_id'
            ])->get();
    }

    public function addFruitItem($fruitCategory): FruitItem
    {
        $fruitCategory->save();
        return $fruitCategory;
    }

    public function initModel(): FruitItem
    {
        return new FruitItem();
    }

    public function get(int $id): FruitItem
    {
        return FruitItem::findOrFail($id);
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
            'fruit_item_name' => [
                'required',
                Rule::unique('fruit_item')->ignore($int, 'fruit_item_id'),
                'max:255'
            ],
            'unit_id' => [
                'required',
                Rule::exists(Unit::class, 'unit_id')
            ],
            'fruit_category_id' => [
                'required',
                Rule::exists(FruitCategory::class, 'fruit_category_id')
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999'
            ]
        ];
    }

    public function updateFruitItem($fruitCategory, $inputs): FruitItem
    {
        $fruitCategory->fill($inputs);
        $fruitCategory->save();
        return $fruitCategory;
    }

    public function delete(int $id)
    {
        return FruitItem::where('fruit_category_id', $id)->delete();
    }

    public function getDataLookups(): array
    {
        return [
            'units' => Unit::all(),
            'fruitCategories' => FruitCategory::all()
        ];
    }
}
