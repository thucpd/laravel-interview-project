<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h2>Invoice #{{ $fruitInvoice->getKey() }}</h2>
<p>Customer Name: {{ $fruitInvoice->customer_name }}</p>

<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Fruit</th>
        <th>Category</th>
        <th>Unit</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($fruitInvoiceDetails as $key => $invoiceDetail)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $invoiceDetail->fruit_item_name }}</td>
            <td>{{ $invoiceDetail->fruit_category_name }}</td>
            <td>{{ $invoiceDetail->unit_name }}</td>
            <td>{{ $invoiceDetail->price }}</td>
            <td>{{ $invoiceDetail->quantity }}</td>
            <td>{{ $invoiceDetail->amount }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6" style="text-align: right;"><strong>Total</strong></td>
        <td><strong>{{ number_format($fruitInvoice->total, 2) }}</strong></td>
    </tr>
    </tfoot>
</table>
</body>
</html>
