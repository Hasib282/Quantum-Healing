$(document).ready(function () {
    UpdateUrl('/api/reports/attendance_sheet/print', { from: $("#from").val(), to: $("#to").val(), events: $('#events').val() });
    
    // Get Trantype
    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'name')
    });

    
    // // Render The Table Heads
    // renderTableHead([
    //     { label: 'Gender' },
    //     { label: 'QT Status' },
    //     { label: 'SL:' },
    //     { label: 'Reg No' },
    //     { label: 'Barcode' },
    //     { label: 'Name' },
    //     { label: 'Branch' },
    //     { label: 'Phone' },
    //     { label: 'Date' },
    // ]);



    // // Events Change 
    // $('#events').off('change').on('change', function (e) {
    //     e.preventDefault();
    //     let search = $(this).val();
    //     $.ajax({
    //         url: `${apiUrl}/admin/event_schedule/get/date`,
    //         data: {search},
    //         success: function (res) {
    //             CreateSelectOptions('#eventDate', "Select Event Date", res.data, 'date', 'date');
    //         }
    //     });
    // })
    
    
    
    // // Events Change 
    $('#from, #to, #events').off('change','#from, #to').on('change', function (e) {
        e.preventDefault();
        let from = $("#from").val();
        let to = $('#to').val();
        let events = $('#events').val();

        let body = "";
        let head = "";

        requestMethod = 'POST';

        // $("#name").html(`${texts}`);
        // $("#attend").html(`${date}`);

        $.ajax({
            url: `${apiUrl}/reports/attendance_sheet`,
            method: 'POST',
            data: {events, from, to},
            success: function (res) {
                UpdateUrl('/api/reports/attendance_sheet/print', { from: $("#from").val(), to: $("#to").val(), events: $('#events').val() });
                
                if (res.status) {
                    console.log(res)

                    res.dates.map((item, key) => {
                        head += `<td style="font-size:9px;">${item}</td>`;
                    });

                    res.users.map((item, key) => {
                        let total = 0; // count attendance

                        const dateCells = res.dates
                            .map((date) => {
                                const hasAttendance = res.data[item.reg_no] && res.data[item.reg_no][date];
                                if (hasAttendance) total++;
                                return `<td>${hasAttendance ? 1 : 0}</td>`;
                            })
                            .join('');


                        body += `<tr>
                                    <td>${key + 1}</td>
                                    <td>${item.reg_no}</td>
                                    <td>${item.name}</td>
                                    ${dateCells}
                                    <td>${total}</td>
                                </tr>`;
                    });

                    $('#data-table thead').html(`<tr>
                                                    <td>SL</td>
                                                    <td>Reg. No</td>
                                                    <td>Name</td>
                                                    ${head}
                                                    <td>Total</td>
                                                </tr>`);
                    $('#data-table tbody').html(body);
                } else {
                    $('#data-table tbody').html('');
                }
            }
        });
    })
});