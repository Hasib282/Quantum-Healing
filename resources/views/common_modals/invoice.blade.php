{{-- company Details Part --}}
<div style="text-align: center; width: 100%; margin: 0 auto;">
    <p style="margin-bottom: 10px;font-size:25px;">
        <strong>{{ auth()->user()->company ? auth()->user()->company->company_name : 'Team-Solutions-Bangladesh' }}</strong>
    </p>
    <p style="margin: 0 auto; max-width: 35%;">
        {{ auth()->user()->company ? auth()->user()->company->address : '12th floor, 28 Kazi Nazrul Islam Ave, Banglamotor, Dhaka 1000' }} <br>
        Phone no: {{ auth()->user()->company ? auth()->user()->company->company_phone : '01314353560' }}
    </p>
    <p style="margin-top: 10px;">
        <strong style="font-size: 25px;">Retail Invoice</strong> <br>
        {{-- {{$transactionMain->store->store_name}} --}}
    </p>
</div>



{{-- Customer Details Part --}}
<p><strong>Bill No:</strong> {{ $transactionMain->tran_id }}</p>

<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td style="width: 60%; vertical-align: top;">
            <p><strong>Invoice To:</strong> <br>
            <strong>Name:</strong> {{ $transactionMain->tran_user ? $transactionMain->user->user_name : $transactionMain->patient->name }} <br>
            <strong>Address:</strong> {{ $transactionMain->tran_user ? $transactionMain->user->address : $transactionMain->patient->address }} <br>
            <strong>Email:</strong> {{ $transactionMain->tran_user ? $transactionMain->user->user_email : $transactionMain->patient->email }} <br>
            <strong>Phone:</strong> {{ $transactionMain->tran_user ? $transactionMain->user->user_phone : $transactionMain->patient->phone }}</p>
        </td>
        <td style="width: 40%; vertical-align: top;">
            <p><strong>Invoice Date:</strong> {{ $transactionMain->tran_date }} <br>
            <strong>Sales By:</strong> TSBD</p>
        </td>
    </tr>
</table>



{{-- product details part --}}
<table style="width: 100%; border-collapse: collapse;">
    <caption class="caption">Invoice Details</caption>
    <thead style="border-top: 1px dashed; border-bottom: 1px dashed;">
        <tr>
            <th style="text-align:left;width:5%;">#SL:</th>
            <th style="text-align:left;width:50%;">Product:</th>
            <th style="text-align:right;width:15%;">Qty</th>
            <th style="text-align:right;width:15%;">Unit Price</th>
            <th style="text-align:right;width:15%;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transDetailsInvoice as $key => $item)
        <tr>
            <td>{{ $key+1 }}</td>
            <td> {{ $item->head->tran_head_name }} </td>
            <td style="text-align:right"> {{ $item->sum_quantity_actual }} </td>
            <td style="text-align:right"> {{ number_format($item->amount) }} </td>
            <td style="text-align:right"> {{ number_format($item->sum_tot_amount) }} </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot style="border-top:1px dashed;">
        <tr>
            <td style="text-align:right" colspan="4">Total:</td>
            <td style="text-align:right">{{ number_format($transactionMain->bill_amount) }}</td>
        </tr>
        <tr>
            <td style="text-align:right" colspan="4">(-) Discount:</td>
            <td style="text-align:right">{{ number_format($transactionMain->discount) }}</td>
        </tr>
        <tr >
            <td style="text-align:right;" colspan="4">Net Total:</td>
            <td style="text-align:right">{{ number_format($transactionMain->net_amount) }}</td>
        </tr>
        <tr>
            <td style="text-align:right" colspan="4">Advance:</td>
            <td style="text-align:right">
                {{ number_format($transactionMain->receive != null ? $transactionMain->receive : $transactionMain->payment ) }}
            </td>
        </tr>
        <tr>
            <td style="text-align:right" colspan="4">Due:</td>
            <td style="text-align:right">
                {{ number_format($transactionMain->net_amount-$transactionMain->receive- $transactionMain->payment) }}
            </td>
        </tr>
    </tfoot>
</table>

<p>Payment Mode: Cash</p>

    

<div style="border-bottom: 1px dashed;">
    <p style="text-align: center;">Thank you, come again</p>
</div>