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

{{----------------------------------------------------- Common Part Of The Report Ends At Here -----------------------------------------}}

@php
    $grouped = [];
@endphp


{{----------------------------------------------------- Dynamic Part Of The Report Starts From Here ------------------------------------}}
<table class="show-table" style="width: 100%; border-collapse: collapse; page-break-inside: auto;">
    <caption style="background: #f2f2f25e;color:black;border: 1px solid #80808080;">Event {{$data[0]->events->name}} <br> Attendence on {{request()->query('date')}}</caption>
    <thead style="display: table-header-group;">
        <tr style="background:none;">
            <th>Gender</th>
            <th>QT Status</th>
            <th>Sl</th>
            <th>Reg No</th>
            <th>Name</th>
            <th>Branch</th>
            <th>Phone</th>
            <th style="text-align: center;">Date</th>
        </tr>
    </thead>
    <tbody>
        @php
            foreach ($data as $item) {
                $p = $item->participants[0];
                $p->date = $item->date;
                $id = $p->gender . '_' . $p->qt_status;

                if (!isset($grouped[$id])) {
                    $grouped[$id] = [];
                }

                $grouped[$id][] = $p;
            }
        @endphp

        @foreach ($grouped as $groupKey => $participants)
            @foreach ($participants as $index => $p)
                <tr>
                    <td>{{ $p->gender }}</td>
                    <td>{{ $p->qt_status }}</td>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->reg_no }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->branchs->branch ?? '-' }}</td>
                    <td>{{ $p->phone }}</td>
                    <td style="text-align: center;">{{ $p->date }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
{{----------------------------------------------------- Dynamic Part Of The Report Ends At Here ----------------------------------------}}