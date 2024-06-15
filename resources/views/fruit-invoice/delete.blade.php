<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Delete' }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto">
                    <h2 class="text-2xl font-bold mb-6 text-center">Delete Fruit Invoice</h2>
                    <form id="fruitForm"  action="{{ $action }}" method="POST">
                        <div class="mb-4">
                            <label for="customerName" class="block mb-2">Customer Name:</label>
                            <input disabled value="{{ $fruitInvoice->customer_name }}" id="customerName" name="customerName" type="text" class="w-80 px-4 py-2 border rounded disabled">
                        </div>
                        @csrf
                        <table class="min-w-full bg-white border">
                            <thead>
                            <tr>
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Fruit</th>
                                <th class="px-4 py-2">Category</th>
                                <th class="px-4 py-2">Unit</th>
                                <th class="px-4 py-2">Price</th>
                                <th class="px-4 py-2">Quantity</th>
                                <th class="px-4 py-2">Amount</th>
                            </tr>
                            </thead>
                            <tbody id="fruitTableBody">
                                @foreach($fruitInvoiceDetails as $key => $invoiceDetail)
                                    <tr>
                                        <td disabled class="px-4 py-2 border rounded disabled">{{ $key + 1 }}</td>
                                        <td disabled class="px-4 py-2 border rounded disabled">{{ $invoiceDetail->fruit_item_name }}</td>
                                        <td disabled class="px-4 py-2 border rounded disabled">{{ $invoiceDetail->fruit_category_name }}</td>
                                        <td disabled class="px-4 py-2 border rounded disabled">{{ $invoiceDetail->unit_name }}</td>
                                        <td disabled class="px-4 py-2 border rounded disabled">{{ $invoiceDetail->price }}</td>
                                        <td disabled class="px-4 py-2 border rounded disabled">{{ $invoiceDetail->quantity }}</td>
                                        <td disabled class="px-4 py-2 border rounded disabled">{{ $invoiceDetail->amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6" class="text-right px-4 py-2 font-bold">Total</td>
                                <td id="totalAmount" colspan="2" class="border px-4 py-2">{{ $fruitInvoice->total }}</td>
                            </tr>
                            </tfoot>
                        </table>
                        <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
