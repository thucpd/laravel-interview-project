<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">Fruit Invoice</h2>
    <input id="fruitItems" type="hidden" value="{{ $fruitItems }}">
    <input id="fruitInvoice" type="hidden" value="{{ $fruitInvoice }}">
    <input id="fruitInvoiceDetail" type="hidden" value="{{ $fruitInvoiceDetail }}">
    <form id="fruitForm" onsubmit="validateAndSubmit(event)" action="{{ $action }}" method="POST">
        <div class="mb-4">
            <label for="customerName" class="block mb-2">Customer Name:</label>
            <input value="{{ $fruitInvoice->customer_name }}" id="customerName" name="customerName" type="text" class="w-80 px-4 py-2 border rounded">
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
                <th class="px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody id="fruitTableBody">
            <!-- Rows will be added here dynamically -->
            </tbody>
            <tfoot>
            <tr>
                <td colspan="6" class="text-right px-4 py-2 font-bold">Total</td>
                <td id="totalAmount" colspan="2" class="border px-4 py-2">{{ $fruitInvoice->total }}</td>
            </tr>
            </tfoot>
        </table>
        <button id="addRowButton" onclick="addRow()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Add Row</button>
        <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">Submit</button>
        <a href="{{ route('fruit-invoice.print', $fruitInvoice->getKey())}}" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded float-right">Print</a>
    </form>
</div>


<script>
    const fruits = JSON.parse(document.getElementById('fruitItems').value);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const fruitInvoiceDetails = JSON.parse(document.getElementById('fruitInvoiceDetail').value);
    let rowCount = fruitInvoiceDetails.length;
    if(rowCount) {
        fruitInvoiceDetails.forEach((fruitInvoiceDetail, index) => {
            addHocRow(fruitInvoiceDetail, index)
        });
    }
    function addHocRow(fruitInvoiceDetail, index) {
        const tableBody = document.getElementById('fruitTableBody');
        const row = document.createElement('tr');
        row.innerHTML = `
                <td class="border px-4 py-2 detail-id" detail-id="${fruitInvoiceDetail.fruit_invoice_detail_id}">${index+1}</td>
                <td class="border px-4 py-2">
                    <select class="fruitSelect bg-white w-full px-4 py-2 border rounded" onchange="updateRow(this)">
                        <option value="">Select Fruit</option>
                        ${fruits.map(fruit => `<option ${fruit.fruit_item_id == fruitInvoiceDetail.fruit_item_id ? 'selected' : ''} value="${fruit.fruit_item_id}">${fruit.fruit_item_name}</option>`).join('')}
                    </select>
                </td>
                <td class="border px-4 py-2 category">${fruitInvoiceDetail.fruit_category_name}</td>
                <td class="border px-4 py-2 unit">${fruitInvoiceDetail.unit_name}</td>
                <td class="border px-4 py-2 price">${fruitInvoiceDetail.price}</td>
                <td class="border px-4 py-2">
                    <input type="number" class="quantity w-full bg-white border rounded px-4 py-2" value="${fruitInvoiceDetail.quantity}" oninput="updateAmount(this)" >
                </td>
                <td class="border px-4 py-2 amount">${fruitInvoiceDetail.amount}</td>
                <td class="border px-4 py-2">
                    <button type="button" onclick="removeRow(this)" class="px-4 py-2 bg-red-500 text-white rounded">Remove</button>
                </td>
            `;
        tableBody.appendChild(row);
        updateAddRowButton();
    }

    function addRow() {
        rowCount++;
        const tableBody = document.getElementById('fruitTableBody');
        const row = document.createElement('tr');
        row.innerHTML = `
                <td class="border px-4 py-2 detail-id" detail-id="null">${rowCount}</td>
                <td class="border px-4 py-2">
                    <select class="fruitSelect bg-white w-full px-4 py-2 border rounded" onchange="updateRow(this)">
                        <option value="">Select Fruit</option>
                        ${fruits.map(fruit => `<option value="${fruit.fruit_item_id}">${fruit.fruit_item_name}</option>`).join('')}
                    </select>
                </td>
                <td class="border px-4 py-2 category"></td>
                <td class="border px-4 py-2 unit"></td>
                <td class="border px-4 py-2 price"></td>
                <td class="border px-4 py-2">
                    <input type="number" class="quantity w-full bg-gray-200 border rounded px-4 py-2" value="1" oninput="updateAmount(this)" disabled>
                </td>
                <td class="border px-4 py-2 amount">0</td>
                <td class="border px-4 py-2">
                    <button type="button" onclick="removeRow(this)" class="px-4 py-2 bg-red-500 text-white rounded">Remove</button>
                </td>
            `;
        tableBody.appendChild(row);
        updateAddRowButton();
    }

    function updateRow(selectElement) {
        const row = selectElement.parentElement.parentElement;
        const fruitItemId = parseInt(selectElement.value);
        const fruit = fruits.find(fruit => fruit.fruit_item_id === fruitItemId);

        if (!fruit) return;

        row.querySelector('.category').innerText = fruit.fruit_category_name;
        row.querySelector('.unit').innerText = fruit.unit_name;
        row.querySelector('.price').innerText = fruit.price;
        row.querySelector('.quantity').disabled = false;
        row.querySelector('.quantity').classList.remove('bg-gray-200');
        row.querySelector('.quantity').classList.add('bg-white');
        updateAmount(row.querySelector('.quantity'));
        updateAddRowButton();
    }

    function updateAmount(inputElement) {
        const row = inputElement.parentElement.parentElement;
        const price = parseFloat(row.querySelector('.price').innerText);
        const quantity = parseInt(inputElement.value) || 0;
        const amount = price * quantity;
        row.querySelector('.amount').innerText = amount.toFixed(2);
        updateTotalAmount();
    }

    function removeRow(buttonElement) {
        const row = buttonElement.parentElement.parentElement;
        row.remove();
        updateRowNumbers();
        updateAddRowButton();
        updateTotalAmount();
    }

    function updateRowNumbers() {
        const rows = document.querySelectorAll('#fruitTableBody tr');
        rows.forEach((row, index) => {
            row.querySelector('td').innerText = index + 1;
        });
        rowCount = rows.length;
    }

    function updateAddRowButton() {
        const fruitSelects = document.querySelectorAll('.fruitSelect');
        let enableButton = true;
        fruitSelects.forEach(select => {
            if (select.value === '') {
                enableButton = false;
            }
        });
        document.getElementById('addRowButton').disabled = !enableButton;
    }

    function updateTotalAmount() {
        const amounts = document.querySelectorAll('.amount');
        let total = 0;
        amounts.forEach(amount => {
            total += parseFloat(amount.innerText);
        });
        document.getElementById('totalAmount').innerText = total.toFixed(2);
    }

    function validateAndSubmit(event) {
        event.preventDefault();

        const customerName = document.getElementById('customerName').value.trim();
        const totalAmount = parseFloat(document.getElementById('totalAmount').innerText);
        if (customerName === '') {
            alert('Please enter Customer Name');
            return;
        }

        const fruitSelects = document.querySelectorAll('.fruitSelect');
        if (fruitSelects.length === 0) {
            alert('Please add at least one row');
            return;
        }

        const data = [];
        fruitSelects.forEach(select => {
            const row = select.parentElement.parentElement;
            const fruitItemId = parseInt(select.value);
            const fruit = fruits.find(fruit => fruit.fruit_item_id === fruitItemId);
            const quantity = parseInt(row.querySelector('.quantity').value) || 0;
            const amount = parseFloat(row.querySelector('.amount').innerText) || 0;
            const detailId = parseInt(row.querySelector('.detail-id').getAttribute('detail-id')) || null;
            data.push({
                detailId: detailId,
                fruitItemId: fruitItemId,
                Quantity: quantity,
                Amount: amount,
                FruitCategoryId: fruit.fruit_category_id,
                UnitId: fruit.unit_id
            });
        });
        const formData = {
            customerName,
            data,
            totalAmount
        };

        const form = document.getElementById('fruitForm');
        const URL = form.action;

        // Retrieve CSRF token from meta tags (assuming Laravel default)
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Sending the data to the server using fetch API
        fetch(URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(formData)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                alert('Success');
                window.location.replace('/fruit-invoice/' + data + '/edit');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting form');
            });
    }
</script>
