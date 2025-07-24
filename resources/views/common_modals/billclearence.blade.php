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
        <strong style="font-size: 25px;">Bill Clearence</strong> <br>
        {{-- {{$transactionMain->store->store_name}} --}}
    </p>
</div>



{{-- Customer Details Part --}}
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td style="width: 15%;">Guest Id</td>
        <td style="width: 40%;">:{{ $booking->user->user_id }}</td>
        <td style="width: 15%;">Booking Id</td>
        <td style="width: 30%;">:{{ $booking->booking_id }}</td>
    </tr>
    <tr>
        <td style="width: 15%;">Guest Name</td>
        <td style="width: 40%;">:{{ $booking->user->user_name }}</td>
        <td style="width: 15%;">Check-In</td>
        <td style="width: 30%;">:{{ $booking->check_in }}</td>
    </tr>
    <tr>
        <td style="width: 15%;">Phone</td>
        <td style="width: 40%;">:{{ $booking->user->user_phone }}</td>
        <td style="width: 15%;">Check-Out</td>
        <td style="width: 30%;">:{{ $booking->check_out }}</td>
    </tr>
    <tr>
        <td style="width: 15%;">Address</td>
        <td style="width: 40%;">:{{ $booking->user->address }}</td>
        <td style="width: 15%;">Reference By</td>
        <td style="width: 30%;">:</td>
    </tr>
    <tr>
        <td style="width: 15%;">Room Details</td>
        <td style="width: 40%;">:{{ $booking->category->name }} {{ $booking->list->name }}</td>
        {{-- <td style="width: 15%;">Check-Out</td>
        <td style="width: 35%;">:{{ $booking->check_out }}</td> --}}
    </tr>
</table>



{{-- product details part --}}
<table style="width: 100%; border-collapse: collapse;font-size:12px;margin-top:20px;">
    <caption>Invoice Details</caption>
    <thead style="border-top: 1px dashed; border-bottom: 1px dashed;">
        <tr style="background: none;">
            <th style="text-align:left;width:5%;">#SL</th>
            <th style="text-align:left;width:13%;">Bill No</th>
            <th style="text-align:left;width:12%;">Date</th>
            <th style="text-align:left;width:35%;">Product</th>
            <th style="text-align:right;width:15%;">Unit Price</th>
            <th style="text-align:right;width:5%;">Qty</th>
            <th style="text-align:right;width:15%;">Total</th>
        </tr>
    </thead>
    <tbody>
        @php $key = 0;  @endphp

        @foreach ($transDetailsInvoice as $groupId => $groupItems)
            @php
                $groupName = $groupItems->first()->groupe->tran_groupe_name ?? 'OTHERS';
                // dd($groupItems);
            @endphp
            
            <tr>
                <td style="padding-top: 10px; pdding-bottom:8px;" colspan="7"><strong>{{ strtoupper($groupName) }}</strong></td>
            </tr>

            @foreach($groupItems as $item)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $item->tran_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tran_date)->format('d M Y') }}</td>
                    <td>{{ $item->head->tran_head_name }} </td>
                    <td style="text-align:right"> {{ number_format($item->amount) }} </td>
                    <td style="text-align:right"> {{ $item->quantity_actual }} </td>
                    <td style="text-align:right"> {{ number_format($item->tot_amount) }} </td>
                </tr>
            @endforeach
        @endforeach
       
    </tbody>
    <tfoot style="border-top:1px dashed;">
        <tr>
            <td colspan="4"></td>
            <td style="text-align:right" colspan="2">Total:</td>
            <td style="text-align:right">{{ number_format($transactionMain->sum_bill_amount) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td style="text-align:right" colspan="2">(-) Discount:</td>
            <td style="text-align:right">{{ number_format($discount) }}</td>
        </tr>
        <tr >
            <td colspan="4"></td>
            <td style="text-align:right;" colspan="2">Net Total:</td>
            <td style="text-align:right">{{ number_format($transactionMain->sum_bill_amount - $discount) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td style="text-align:right;border-top:1px dashed;" colspan="2">Deposit:</td>
            <td style="text-align:right;border-top:1px dashed;">
                {{ number_format($deposit) }}
            </td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td style="text-align:right" colspan="2">Refund:</td>
            <td style="text-align:right">
                {{ number_format($refund) }}
            </td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td style="text-align:right;border-top:1px dashed;" colspan="2">Net Deposit:</td>
            <td style="text-align:right;border-top:1px dashed;">
                {{ number_format($deposit - $refund) }}
            </td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td style="text-align:right;border-top:1px dashed;" colspan="2"> 
                @if (($transactionMain->sum_bill_amount - $discount) > ($deposit - $refund))
                    Receiveable:
                @else
                    Payable:
                @endif
            </td>
            <td style="text-align:right;border-top:1px dashed;">
                @if (Request::segment(3) == 'billsettlement')
                    <input type="number" id="{{($transactionMain->sum_bill_amount - $discount) > ($deposit - $refund) ? 'receiveable' : 'payable'}}" value="{{ abs(($transactionMain->sum_bill_amount - $discount) - ($deposit - $refund)) }}" style="text-align: right;padding:0;" class="input-small" readonly>
                @else
                    {{ number_format(abs(($transactionMain->sum_bill_amount - $discount) - ($deposit - $refund))) }}
                @endif
            </td>
        </tr>
        @if (Request::segment(3) == 'billsettlement')
            <tr>
                <td colspan="4"></td>
                <td style="text-align:right;border-top:1px dashed;" colspan="2">Final Discount:</td>
                <td style="text-align:right;border-top:1px dashed;">
                    <input type="number" id="discount" value="0" style="text-align: right;padding:0;" class="input-small">
                </td>
            </tr>
        @endif
    </tfoot>
</table>

<p>Payment Mode: Cash</p>

    
@if (Request::segment(3) == 'billsettlement')
<div class="center">
    <span id="message_error"></span>
    <input type="submit" value="Bill Settlement" class="btn-blue" id="settlement" onclick="settlement(this)" data-id="{{ $booking->booking_id }}">
    <script>
        function settlement(element) {
            let id = $(element).attr('data-id');
            let receiveable = $('#receiveable').val();
            let payable = $('#payable').val();
            let discount = $('#discount').val();
            $.ajax({
                url: `${apiUrl}/hotel/billsettlement`,
                method: 'POST',
                data: { id, receiveable, payable, discount },
                success: function (res) {
                    $("#editModal").hide();
                    toastr.success(res.message, 'Updated!');
                    // if(res.status){
                    //     $("#editModal").show();
                    //     $('#bill').html(res.data)
                    // }
                },
            });
        }
    </script>
</div>
@else    
    <div style="border-bottom: 1px dashed;">
        <p style="text-align: center;">Thank you, Please come again</p>
    </div>
@endif

