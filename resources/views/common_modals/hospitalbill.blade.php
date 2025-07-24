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
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td style="width: 15%;">Guest Id</td>
        <td style="width: 35%;">:{{ $booking->user->user_id }}</td>
        <td style="width: 15%;">Booking Id</td>
        <td style="width: 35%;">:{{ $booking->booking_id }}</td>
    </tr>
    <tr>
        <td style="width: 15%;">Guest Name</td>
        <td style="width: 35%;">:{{ $booking->user->user_name }}</td>
        <td style="width: 15%;">Check-In</td>
        <td style="width: 35%;">:{{ $booking->check_in }}</td>
    </tr>
    <tr>
        <td style="width: 15%;">Phone</td>
        <td style="width: 35%;">:{{ $booking->user->user_phone }}</td>
        <td style="width: 15%;">Check-Out</td>
        <td style="width: 35%;">:{{ $booking->check_out }}</td>
    </tr>
    <tr>
        <td style="width: 15%;">Address</td>
        <td style="width: 35%;">:{{ $booking->user->address }}</td>
        <td style="width: 15%;">Reference By:</td>
        <td style="width: 35%;">:</td>
    </tr>
    <tr>
        <td style="width: 15%;">Room Details</td>
        <td style="width: 35%;">:{{ $booking->category->name }} {{ $booking->list->name }}</td>
        {{-- <td style="width: 15%;">Check-Out</td>
        <td style="width: 35%;">:{{ $booking->check_out }}</td> --}}
    </tr>
</table>



{{-- product details part --}}
<table style="width: 100%; border-collapse: collapse;">
    <caption class="caption">Invoice Details</caption>
    <thead style="border-top: 1px dashed; border-bottom: 1px dashed;">
        <tr>
            <th style="text-align:left;width:5%;">#SL</th>
            <th style="text-align:left;width:10%;">Bill No</th>
            <th style="text-align:left;width:10%;">Date</th>
            <th style="text-align:left;width:40%;">Product</th>
            <th style="text-align:right;width:10%;">Qty</th>
            <th style="text-align:right;width:10%;">Unit Price</th>
            <th style="text-align:right;width:10%;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transDetailsInvoice as $key => $item)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $key+1 }}</td>
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
            <td style="text-align:right" colspan="6">Total:</td>
            <td style="text-align:right">{{ number_format($transactionMain->bill_amount) }}</td>
        </tr>
        <tr>
            <td style="text-align:right" colspan="6">(-) Discount:</td>
            <td style="text-align:right">{{ number_format($transactionMain->discount) }}</td>
        </tr>
        <tr >
            <td style="text-align:right;" colspan="6">Net Total:</td>
            <td style="text-align:right">{{ number_format($transactionMain->net_amount) }}</td>
        </tr>
        <tr>
            <td style="text-align:right" colspan="6">Advance:</td>
            <td style="text-align:right">
                {{ number_format($transactionMain->receive != null ? $transactionMain->receive : $transactionMain->payment ) }}
            </td>
        </tr>
        <tr>
            <td style="text-align:right" colspan="6">Due:</td>
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