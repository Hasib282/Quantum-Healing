$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'Gender' },
        { label: 'QT Status' },
        { label: 'SL:' },
        { label: 'Reg No' },
        { label: 'Barcode' },
        { label: 'Name' },
        { label: 'Branch' },
        { label: 'Phone' },
        { label: 'Date' },
    ]);

    UpdateUrl('/api/reports/attendance_statement/print', { date: $("#eventDate").val(), events: $('#events').val(), qt_status: $('#qt_status').val(), gender: $('#gender').val() });
    
    // Get Trantype
    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'name')
    });


    // Events Change 
    $('#events').off('change').on('change', function (e) {
        e.preventDefault();
        let search = $(this).val();
        $.ajax({
            url: `${apiUrl}/admin/event_schedule/get/date`,
            data: {search},
            success: function (res) {
                CreateSelectOptions('#eventDate', "Select Event Date", res.data, 'date', 'date');
            }
        });
    })
    
    
    
    // Events Change 
    $('#eventDate, #gender, #qt_status, #events').off('change','#eventDate, #gender, #qt_status').on('change', function (e) {
        e.preventDefault();
        let date = $("#eventDate").val();
        let events = $('#events').val();
        let texts = $('#events option:selected').text();
        let gender = $('#gender').val();
        let qt_status = $('#qt_status').val();
        let table = "";

        requestMethod = 'POST';

        $("#name").html(`${texts}`);
        $("#attend").html(`${date}`);

        $.ajax({
            url: `${apiUrl}/reports/attendance_statement`,
            method: 'POST',
            data: {events, date, gender, qt_status},
            success: function (res) {
                UpdateUrl('/api/reports/attendance_statement/print', { date: $("#eventDate").val(), events: $('#events').val(), qt_status: $('#qt_status').val(), gender: $('#gender').val() });
                
                if (res.data) {
                    let grouped = [];

                    res.data.map((item, key) => {
                        const p = item.participants[0];
                        p.date = item.date;

                        const id = `${p.gender}_${p.qt_status}`;
                        if (!grouped[id]) {
                            grouped[id] = [];
                        }
                        grouped[id].push(p);

                        // When group ends (gender or qt_status changes)
                        if (key === res.data.length - 1) {
                            for(const groupKey in grouped){
                                const [gender, qt_status] = groupKey.split('_');
                                const participants = grouped[groupKey];


                                participants.map((p,key) => {
                                    table += `<tr>`;
                                    if (key === 0) {
                                        table += `<td rowspan="${participants.length}">${p.gender}</td>`;
                                        table += `<td rowspan="${participants.length}">${p.qt_status}</td>`;
                                    }
                                    table += `<td>${key + 1}</td>
                                            <td>${p.reg_no}</td>
                                            <td>
                                                <svg class="barcode"
                                                    jsbarcode-value="${p.reg_no}" 
                                                    jsbarcode-format="code128"
                                                    jsbarcode-height="35"
                                                    jsbarcode-width="1"
                                                    jsbarcode-margin="2"
                                                    jsbarcode-displayvalue="true"
                                                    jsbarcode-fontsize="10">
                                                </svg>
                                            </td>
                                            <td>${p.name}</td>
                                            <td>${p.branchs.branch}</td>
                                            <td>${p.phone}</td>
                                            <td style="text-align:center">${p.date}</td>`;
                                    table += `</tr>`;
                                });
                            }
                        }
                    });

                    $('#data-table tbody').html(table);
                    JsBarcode(".barcode").init();
                } else {
                    $('#data-table tbody').html('');
                }
            }
        });
    })
});