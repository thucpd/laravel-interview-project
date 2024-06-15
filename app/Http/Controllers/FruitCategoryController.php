<?php

namespace App\Http\Controllers;

use App\Service\FruitCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FruitCategoryController extends Controller
{
    private FruitCategoryService $fruitCategoryService;

    public function __construct(FruitCategoryService $fruitCategoryService)
    {
        $this->fruitCategoryService = $fruitCategoryService;
    }

    public function index()
    {
        $fruitCategories = $this->fruitCategoryService->getAll();
        return view('fruit-category.index', [
            'fruitCategories' => $fruitCategories
        ]);
    }

    public function create(Request $request)
    {
        $fruitCategory = $this->fruitCategoryService->initModel();
        $fruitCategory = $this->fruitCategoryService->assignOldInput($fruitCategory, $request->old());
        return view('fruit-category.create', [
            'fruitCategory' => $fruitCategory,
            'action' => route('fruit-category.store'),
            'disabled' => false
        ]);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $fruitCategory = $this->fruitCategoryService->initModel();
        $fruitCategory->fill($inputs);
        $validator = Validator::make($fruitCategory->getAttributes(),
            $this->fruitCategoryService->validaterule(),
        );
        if ($validator->fails()) {
            return redirect()->route('fruit-category.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $fruitCategory = $this->fruitCategoryService->addFruitCategory($fruitCategory);
            return redirect()->route('fruit-category.edit', $fruitCategory->getKey())
                ->with('status', 'Create Fruit Category success!');
        }
    }

    public function edit(Request $request, $fruitCategoryId)
    {
        $fruitCategory = $this->fruitCategoryService->get($fruitCategoryId);
        $fruitCategory = $this->fruitCategoryService->assignOldInput($fruitCategory, $request->old());

        return view('fruit-category.edit', [
            'fruitCategory' => $fruitCategory,
            'action' => route('fruit-category.update', $fruitCategory->getKey()),
            'disabled' => false
        ]);
    }

    public function update(Request $request, $fruitCategoryId)
    {
        $fruitCategory = $this->fruitCategoryService->get($fruitCategoryId);
        $validator = Validator::make($request->all(),
            $this->fruitCategoryService->validaterule($fruitCategoryId),
        );
        if ($validator->fails()) {
            return redirect()->route('fruit-category.edit', $fruitCategoryId)
                ->withErrors($validator)
                ->withInput();
        } else {
            $fruitCategory = $this->fruitCategoryService->updateFruitCategory($fruitCategory, $request->all());
            return redirect()->route('fruit-category.edit', $fruitCategory->getKey())
                ->with('status', 'Update Fruit Category success!');
        }
    }

    public function delete(Request $request, $fruitCategoryId)
    {
        $fruitCategory = $this->fruitCategoryService->get($fruitCategoryId);

        return view('fruit-category.delete', [
            'fruitCategory' => $fruitCategory,
            'action' => route('fruit-category.destroy', $fruitCategory->getKey()),
            'disabled' => true
        ]);
    }

    public function destroy(Request $request, $fruitCategoryId)
    {
        $this->fruitCategoryService->delete($fruitCategoryId);
        return redirect()->route('fruit-category')->with('status', 'Delete Fruit Category Success');
    }
}
