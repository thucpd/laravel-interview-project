<?php

namespace App\Http\Controllers;

use App\Service\FruitItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FruitItemController extends Controller
{
    private FruitItemService $fruitItemService;

    public function __construct(FruitItemService $fruitItemService)
    {
        $this->fruitItemService = $fruitItemService;
    }

    public function index()
    {
        $fruitItems = $this->fruitItemService->getAll();
        return view('fruit-item.index', [
            'fruitItems' => $fruitItems
        ]);
    }

    public function create(Request $request)
    {
        $fruitItem = $this->fruitItemService->initModel();
        $lookups = $this->fruitItemService->getDataLookups();
        $fruitItem = $this->fruitItemService->assignOldInput($fruitItem, $request->old());
        return view('fruit-item.create', [
            'fruitItem' => $fruitItem,
            'lookups' => $lookups,
            'action' => route('fruit-item.store'),
            'disabled' => false
        ]);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $fruitItem = $this->fruitItemService->initModel();
        $fruitItem->fill($inputs);
        $validator = Validator::make($fruitItem->getAttributes(),
            $this->fruitItemService->validaterule(),
        );
        if ($validator->fails()) {
            return redirect()->route('fruit-item.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $fruitItem = $this->fruitItemService->addFruitItem($fruitItem);
            return redirect()->route('fruit-item.edit', $fruitItem->getKey())
                ->with('status', 'Create Fruit Item success!');
        }
    }

    public function edit(Request $request, $fruitItemId)
    {
        $fruitItem = $this->fruitItemService->get($fruitItemId);
        $fruitItem = $this->fruitItemService->assignOldInput($fruitItem, $request->old());
        $lookups = $this->fruitItemService->getDataLookups();
        return view('fruit-item.edit', [
            'fruitItem' => $fruitItem,
            'lookups' => $lookups,
            'action' => route('fruit-item.update', $fruitItem->getKey()),
            'disabled' => false
        ]);
    }

    public function update(Request $request, $fruitItemId)
    {
        $fruitItem = $this->fruitItemService->get($fruitItemId);
        $validator = Validator::make($request->all(),
            $this->fruitItemService->validaterule($fruitItemId),
        );
        if ($validator->fails()) {
            return redirect()->route('fruit-item.edit', $fruitItemId)
                ->withErrors($validator)
                ->withInput();
        } else {
            $fruitItem = $this->fruitItemService->updateFruitItem($fruitItem, $request->all());
            return redirect()->route('fruit-item.edit', $fruitItem->getKey())
                ->with('status', 'Update Fruit Item success!');
        }
    }

    public function delete(Request $request, $fruitItemId)
    {
        $fruitItem = $this->fruitItemService->get($fruitItemId);

        return view('fruit-item.delete', [
            'fruitItem' => $fruitItem,
            'action' => route('fruit-item.destroy', $fruitItem->getKey()),
            'disabled' => true
        ]);
    }

    public function destroy(Request $request, $fruitItemId)
    {
        $this->fruitItemService->delete($fruitItemId);
        return redirect()->route('fruit-item')->with('status', 'Delete Fruit Item Success');
    }
}
