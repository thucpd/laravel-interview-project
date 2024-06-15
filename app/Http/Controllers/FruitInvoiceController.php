<?php

namespace App\Http\Controllers;

use App\Service\FruitInvoiceService;
use App\Service\FruitItemService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use MongoDB\Driver\Session;

class FruitInvoiceController extends Controller
{
    private FruitInvoiceService $fruitInvoiceService;
    private FruitItemService $fruitItemService;

    public function __construct(FruitInvoiceService $fruitInvoiceService, FruitItemService $fruitItemService)
    {
        $this->fruitInvoiceService = $fruitInvoiceService;
        $this->fruitItemService = $fruitItemService;
    }

    public function index()
    {
        $fruitInvoices = $this->fruitInvoiceService->getAll();
        return view('fruit-invoice.index', ['fruitInvoices' => $fruitInvoices]);
    }

    public function create(Request $request)
    {
        $fruitInvoice = $this->fruitInvoiceService->initModel();
        $fruitInvoice = $this->fruitInvoiceService->assignOldInput($fruitInvoice, $request->old());
        $fruitItems = $this->fruitItemService->getAll();
        return view('fruit-invoice.create', [
            'fruitInvoice' => $fruitInvoice,
            'action' => route('fruit-invoice.store'),
            'disabled' => false,
            'fruitItems' => json_encode($fruitItems),
            'fruitInvoiceDetail' => json_encode([]),
        ]);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = $this->fruitInvoiceService->addFruitInvoice($inputs);
        if ($validator->fails()) {
            return redirect()->route('fruit-invoice.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            return $validator->fruitInvoiceId;
        }
    }

    public function edit(Request $request, $fruitInvoiceId)
    {
        $fruitInvoice = $this->fruitInvoiceService->get($fruitInvoiceId);
        $fruitInvoiceDetails = $this->fruitInvoiceService->getfruitInvoiceDetails($fruitInvoiceId);
        $fruitInvoice = $this->fruitInvoiceService->assignOldInput($fruitInvoice, $request->old());
        $fruitItems = $this->fruitItemService->getAll();
        return view('fruit-invoice.edit', [
            'fruitInvoice' => $fruitInvoice,
            'action' => route('fruit-invoice.update', [$fruitInvoiceId]),
            'disabled' => false,
            'fruitItems' => json_encode($fruitItems),
            'fruitInvoiceDetail' => json_encode($fruitInvoiceDetails),
        ]);
    }

    public function update(Request $request, $fruitInvoiceId)
    {
        $inputs = $request->all();
        $validator = $this->fruitInvoiceService->updateFruitInvoice($fruitInvoiceId, $inputs);
        if ($validator->fails()) {
            return redirect()->route('fruit-invoice.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            return $validator->fruitInvoiceId;
        }
    }

    public function delete(Request $request, $fruitInvoiceId)
    {
        $fruitInvoice = $this->fruitInvoiceService->get($fruitInvoiceId);
        $fruitInvoiceDetails = $this->fruitInvoiceService->getfruitInvoiceDetails($fruitInvoiceId);

        return view('fruit-invoice.delete', [
            'fruitInvoice' => $fruitInvoice,
            'fruitInvoiceDetails' => $fruitInvoiceDetails,
            'action' => route('fruit-invoice.destroy', $fruitInvoice->getKey()),
            'disabled' => true
        ]);
    }

    public function destroy(Request $request, $fruitInvoiceId)
    {
        $this->fruitInvoiceService->delete($fruitInvoiceId);
        return redirect()->route('fruit-invoice')->with('status', 'Delete Fruit Invoice Success');
    }

    public function print(Request $request, $fruitInvoiceId)
    {
        $fruitInvoice = $this->fruitInvoiceService->get($fruitInvoiceId);
        $fruitInvoiceDetails = $this->fruitInvoiceService->getfruitInvoiceDetails($fruitInvoiceId);
        $pdf = PDF::loadView('fruit-invoice.pdf', ['fruitInvoice'=> $fruitInvoice, 'fruitInvoiceDetails' => $fruitInvoiceDetails]);
        return $pdf->download('invoice_' . $fruitInvoice->getKey() . '.pdf');
    }
}
