{{----------------------------------------------------- Common Part Of The Report Starts From Here -------------------------------------}}
<style>
    /* .show-table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }

    .show-table td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 2px 4px;
    } */

     /* General table styling */
    table.show-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        page-break-inside: avoid; /* Prevent table from breaking mid-way */
    }

    table.show-table caption {
        caption-side: top;
        padding: 10px;
        font-weight: bold;
        background: #f2f2f2;
    }

    table.show-table th,
    table.show-table td {
        border: 1px solid #ccc;
        padding: 6px 10px;
        font-size: 12px;
        text-align: left;
    }

    /* Avoid breaking thead across pages */
    thead {
        display: table-header-group;
    }

    tbody {
        display: table-row-group;
    }

    /* Page break after each table */
    .page-break {
        page-break-after: always;
    }

    @media print {
        .no-print {
            display: none;
        }

        body {
            margin: 0;
            padding: 0;
        }
    }
</style>

<div style="text-align: center; width: 100%; margin: 0 auto;">
    <p>
        <strong style="font-size: 20px;">{{ $data[0]->events->name }} Event</strong> <br>
    </p>
    <p>
       <strong style="font-size: 18px;">Attendence on {{ request()->query('date') }}</strong> <br>
    </p>
</div>

{{----------------------------------------------------- Common Part Of The Report Ends At Here -----------------------------------------}}

@php
    $lastGender = null;
    $lastQtStatus = null;
    $groupCount = 0;
@endphp


{{----------------------------------------------------- Dynamic Part Of The Report Starts From Here ------------------------------------}}
@foreach($data as $key => $item)
    @php
        $p = $item->participants[0];
        $showGender = $p->gender !== ($lastGender ?? null);
        $showQtStatus = $p->qt_status !== ($lastQtStatus ?? null);

        if ($showGender || $showQtStatus) {
            if ($key !== 0) {
                echo "</tbody></table><br>"; 
            }


            echo '<table class="show-table">
                    <caption style="background: #f2f2f25e;color:black;border: 1px solid #80808080;""><strong>'.$p->gender. '(' . $p->qt_status .')</strong></caption>
                    <thead>
                        <tr style="background:none;">
                            <th>Sl</th>
                            <th>Reg No</th>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Phone</th>
                            <th style="text-align: center;">Date</th>
                        </tr>
                    </thead>
                    <tbody>';
            $groupCount = 0;
        }

        $lastGender = $p->gender;
        $lastQtStatus = $p->qt_status;
        $groupCount++;
    @endphp

    <tr>
        <td>{{ $groupCount }}</td>
        <td>{{ $item->participants[0]->reg_no }}</td>
        <td>{{ $item->participants[0]->name }}</td>
        <td>{{ $item->participants[0]->branchs->short }}</td>
        <td>{{ $item->participants[0]->phone }}</td>
        <td style="text-align: center;">{{ $item->date }}</td>
    </tr>

    @if($groupCount > 0 && $groupCount % 3 == 0)
        <div class="page-break"></div>
    @endif
@endforeach
{{----------------------------------------------------- Dynamic Part Of The Report Ends At Here ----------------------------------------}}