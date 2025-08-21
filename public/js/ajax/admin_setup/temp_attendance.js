function ShowTempAttendance(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['events.name','date','qr_url','added_at'],
        actions: (row) => {
            return `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
            `;
        }
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Event name', key: 'events.name' },
        { label: 'Date', key: 'date' },
        { label: 'Qr Url', key: 'qr_url' },
        { label: 'Attendence Time', key: 'added_at' },
        { label: 'Actions' },
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/temp_attendance', ShowTempAttendance);
    

    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Insert Ajax
    InsertAjax('admin/temp_attendance', {events: { selector: '#events' },date: { selector: '#date' }}, function(res){
        let id = $('#id').val();
        tableInstance.deleteRow(id);
    });


    // Delete  Ajax
    DeleteAjax('admin/temp_attendance');


    // Search by Type
    SearchBySelect('admin/temp_attendance/search', ShowTempAttendance, "#searchEvents, #searchDates", {event: { selector: '#searchEvents'}, date: { selector: '#searchDates'}});


    // Get Events By Date
    GetSelectInputList('admin/event_schedule/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'event.name', 'event.id');
    })
    
    
    // Get Events
    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#searchEvents', "Select Events", res.data, 'name');
        CreateSelectOptions('#allevents', "Select Events", res.data, 'name');
    })


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#events').val(item.event_id);
        $('#date').val(item.date);
        $('#qr_url').val(item.qr_url);
        $('#reg_no').val('');
        $('#userData').html('');
        $('#reg_no').focus();
    }


    $(document).off("keyup", '#reg_no').on("keyup", '#reg_no', function (e){
        let reg_no = $(this).val();
        $.ajax({
            url: `${apiUrl}/admin/users/user_info/get/reg`,
            data: {reg_no},
            success: function (res) {
                $('#userData').html(``);
                if(res.data){
                    $('#userData').html(`
                        <h2 class="center">User Details</h2>
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <div class="center">
                                            <img src="${apiUrl.replace('/api', '')}/storage/${res.data.image ? res.data.image : 'male.png'}?${new Date().getTime()}" width="100" height="100">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Reg No :</td>
                                    <td>${res.data.reg_no}</td>
                                </tr>
                                <tr>
                                    <td>Name :</td>
                                    <td>${res.data.name}</td>
                                </tr>
                                <tr>
                                    <td>Phone :</td>
                                    <td>${res.data.phone}</td>
                                </tr>
                                <tr>
                                    <td>Branch :</td>
                                    <td>${res.data.branchs.short}</td>
                                </tr>
                            </tbody>
                        </table>
                    `);
                }
            }
        });
    });




    // Upload CSV Form Submit Event
    $(document).off('submit','#CsvForm').on('submit','#CsvForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: `${apiUrl}/admin/attendance/upload_data`,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function (res) {
                if (res.status == true) {
                    $('#CsvForm')[0].reset();

                    $('#message').html(res.message)

                    tableInstance.updateRow(res.updatedData.id, res.updatedData);

                    toastr.success(res.message, 'Added!');
                }
            }
        });
    })
});
