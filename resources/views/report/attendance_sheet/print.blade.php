{{----------------------------------------------------- Common Part Of The Report Starts From Here -------------------------------------}}
<style>
    body {
        margin: 0;
        padding: 0;
        font-size: 12px;
        color: black;
    }

    .show-table th,
    .show-table td {
        border: 1px solid #999;
        padding: 5px;
        text-align: left;
        vertical-align: top;
        page-break-inside: avoid !important;
    }

    .show-table tr {
        page-break-inside: avoid !important;
        page-break-after: auto;
    }
</style>

{{----------------------------------------------------- Dynamic Part Of The Report Starts From Here ------------------------------------}}
<table class="show-table" style="width: 100%; border-collapse: collapse; page-break-inside: auto;">
    <caption style="background: #f2f2f25e;color:black;border: 1px solid #80808080;">{{$event->name}} Attendence Sheet <br>  From {{request()->query('from')}} - To {{request()->query('to')}}</caption>
    <thead style="display: table-header-group;">
        <tr style="background:none;font-size:14px;">
            <th>SL</th>
            <th>Reg. No</th>
            <th>Name</th>
            @foreach($dates as $date)
                <th style="font-size:9px;">{{ $date }}</th>
            @endforeach
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key => $user)
            @php
                $total = 0;
            @endphp
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $user->reg_no }}</td>
                <td>{{ $user->name }}</td>

                @foreach($dates as $date)
                    @php
                        $attended = isset($data[$user->reg_no][$date]) && $data[$user->reg_no][$date];
                        if ($attended) $total++;
                    @endphp
                    <td>{{ $attended ? 1 : 0 }}</td>
                @endforeach

                <td><b>{{ $total }}</b></td>
            </tr>
        @endforeach
    </tbody>
</table>







{{-- <table class="table table-bordered" id="data-table">
    <thead>
        <tr>
            <th>SL</th>
            <th>Reg. No</th>
            <th>Name</th>
            @foreach($dates as $date)
                <th style="font-size:9px;">{{ $date }}</th>
            @endforeach
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key => $user)
            @php
                $total = 0;
            @endphp
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $user->reg_no }}</td>
                <td>{{ $user->name }}</td>

                @foreach($dates as $date)
                    @php
                        $attended = isset($data[$user->reg_no][$date]) && $data[$user->reg_no][$date];
                        if ($attended) $total++;
                    @endphp
                    <td>{{ $attended ? 1 : 0 }}</td>
                @endforeach

                <td>{{ $total }}</td>
            </tr>
        @endforeach
    </tbody>
</table> --}}
{{----------------------------------------------------- Dynamic Part Of The Report Ends At Here ----------------------------------------}}