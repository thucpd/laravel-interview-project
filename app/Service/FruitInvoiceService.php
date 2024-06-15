<?php

namespace App\Service;

use App\Models\FruitCategory;
use App\Models\FruitInvoice;
use App\Models\FruitInvoiceDetail;
use App\Models\FruitItem;
use App\Models\Unit;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FruitInvoiceService extends BaseService
{
    public function getAll(array $inputs = [])
    {
        return FruitInvoice::all();
    }

    public function addFruitInvoice($inputs): \Illuminate\Validation\Validator
    {
        $validator = Validator::make($inputs,
            $this->validaterule(),
        );
        $fruitInvoiceId = null;
        if ($validator->passes()) {
            DB::transaction(function () use ($inputs, &$fruitInvoiceId) {
                $newFruitInvoice = new FruitInvoice();
                $newFruitInvoice->customer_name = Arr::get($inputs, 'customerName', '');
                $newFruitInvoice->total = Arr::get($inputs, 'totalAmount', 0);
                $newFruitInvoice->save();
                $fruitInvoiceId = $newFruitInvoice->getKey();
                $details = Arr::get($inputs, 'data', []);
                foreach ($details as $detail) {
                    $newFruitInvoiceDetail = new FruitInvoiceDetail();
                    $newFruitInvoiceDetail->fruit_invoice_id = $fruitInvoiceId;
                    $newFruitInvoiceDetail->fruit_item_id = Arr::get($detail, 'fruitItemId', 0);
                    $newFruitInvoiceDetail->amount = Arr::get($detail, 'Amount', 0);
                    $newFruitInvoiceDetail->quantity = Arr::get($detail, 'Quantity', 0);
                    $newFruitInvoiceDetail->save();
                }
            });
        }
        $validator->fruitInvoiceId = $fruitInvoiceId;
        return $validator;
    }

    public function updateFruitInvoice($fruitInvoiceId, $inputs): \Illuminate\Validation\Validator
    {
        $validator = Validator::make($inputs,
            $this->validaterule(),
        );
        if ($validator->passes()) {
            DB::transaction(function () use ($inputs, $fruitInvoiceId) {
                $newFruitInvoice = FruitInvoice::findOrFail($fruitInvoiceId);
                $newFruitInvoice->customer_name = Arr::get($inputs, 'customerName', '');
                $newFruitInvoice->total = Arr::get($inputs, 'totalAmount', 0);
                $newFruitInvoice->save();
                $details = Arr::get($inputs, 'data', []);
                foreach ($details as $detail) {
                    $detailId = Arr::get($detail, 'detailId', 0);
                    if ($detailId) {
                        $newFruitInvoiceDetail = FruitInvoiceDetail::findOrFail($detailId);
                        $newFruitInvoiceDetail->fruit_invoice_id = $fruitInvoiceId;
                        $newFruitInvoiceDetail->fruit_item_id = Arr::get($detail, 'fruitItemId', 0);
                        $newFruitInvoiceDetail->amount = Arr::get($detail, 'Amount', 0);
                        $newFruitInvoiceDetail->quantity = Arr::get($detail, 'Quantity', 0);
                        $newFruitInvoiceDetail->save();
                    } else {
                        $newFruitInvoiceDetail = new FruitInvoiceDetail();
                        $newFruitInvoiceDetail->fruit_invoice_id = $fruitInvoiceId;
                        $newFruitInvoiceDetail->fruit_item_id = Arr::get($detail, 'fruitItemId', 0);
                        $newFruitInvoiceDetail->amount = Arr::get($detail, 'Amount', 0);
                        $newFruitInvoiceDetail->quantity = Arr::get($detail, 'Quantity', 0);
                        $newFruitInvoiceDetail->save();
                    }
                }
            });
        }
        $validator->fruitInvoiceId = $fruitInvoiceId;
        return $validator;
    }

    public function initModel(): FruitCategory
    {
        return new FruitCategory();
    }

    public function get(int $id): FruitInvoice
    {
        return FruitInvoice::findOrFail($id);
    }

    public function getfruitInvoiceDetails(int $id)
    {
        return FruitInvoice::query()->join(
            'fruit_invoice_detail',
            'fruit_invoice_detail.fruit_invoice_id',
            '=',
            'fruit_invoice.fruit_invoice_id'
        )->join(
            'fruit_item',
            'fruit_item.fruit_item_id',
            '=',
            'fruit_invoice_detail.fruit_item_id'
        )->join(
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
            'fruit_invoice_detail_id',
            'fruit_item.fruit_item_id',
            'fruit_item.fruit_item_name',
            'fruit_item.price',
            'fruit_category.fruit_category_name',
            'fruit_category.fruit_category_id',
            'unit.unit_name',
            'unit.unit_id',
            'fruit_invoice_detail.quantity',
            'fruit_invoice_detail.amount'
        ])->where('fruit_invoice_detail.fruit_invoice_id', $id)->orderBy('fruit_invoice_detail_id')->get();
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
            'customerName' => 'required|string|max:255',
            'data' => 'required|array',
            'data.*.Quantity' => 'required|integer|min:1',
            'data.*.Amount' => 'required|numeric|min:0.01', // Adjust min value as needed
            'data.*.fruitItemId' => Rule::exists(FruitItem::class, 'fruit_item_id'),
            'data.*.UnitId' => Rule::exists(Unit::class, 'unit_id'),
            'data.*.FruitCategoryId' => Rule::exists(FruitCategory::class, 'fruit_category_id')
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
        return DB::transaction(function () use ($id) {
            FruitInvoice::where('fruit_invoice_id', $id)->delete();
            FruitInvoiceDetail::where('fruit_invoice_id', $id)->delete();
            return true;
        });
    }
}
