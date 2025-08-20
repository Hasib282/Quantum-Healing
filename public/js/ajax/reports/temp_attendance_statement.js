$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:' },
        { label: 'Event Name' },
        { label: 'Qr URl' },
        { label: 'Date' },
    ]);

    UpdateUrl('/api/reports/temp_attendance_statement/print', { date: $("#eventDate").val(), events: $('#events').val() });
    
    // Get Trantype
    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'name')
    });


    // Events Change 
    $(document).off('change','#events').on('change','#events', function (e) {
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
    $(document).off('change','#eventDate, #events').on('change','#eventDate, #events', function (e) {
        e.preventDefault();
        let date = $("#eventDate").val();
        let events = $('#events').val();
        let texts = $('#events option:selected').text();
        let table = "";

        requestMethod = 'POST';

        $("#name").html(`${texts}`);
        $("#attend").html(`${date}`);

        $.ajax({
            url: `${apiUrl}/reports/temp_attendance_statement`,
            method: 'POST',
            data: {events, date},
            success: function (res) {
                UpdateUrl('/api/reports/temp_attendance_statement/print', { date: $("#eventDate").val(), events: $('#events').val() });
                
                if (res.data) {
                    let table = "";
                    // let grouped = [];

                    res.data.map((item, key) => {
                        table += `<tr>
                                    <td>${key + 1}</td>
                                    <td>${item.events?.name}</td>
                                    <td>${item.qr_url}</td>
                                    <td>${item.date}</td>
                                </tr>`;

                        // // const p = item.participants[0];
                        // p.date = item.date;

                        // const id = `${p.gender}_${p.qt_status}`;
                        // if (!grouped[id]) {
                        //     grouped[id] = [];
                        // }
                        // grouped[id].push(p);

                        // // When group ends (gender or qt_status changes)
                        // if (key === res.data.length - 1) {
                        //     for(const groupKey in grouped){
                        //         const [gender, qt_status] = groupKey.split('_');
                        //         const participants = grouped[groupKey];


                        //         participants.map((p,key) => {
                                    
                        //         });
                        //     }
                        // }
                    });

                    $('#data-table tbody').html(table);
                } else {
                    $('#data-table tbody').html('');
                }
            }
        });
    })
});