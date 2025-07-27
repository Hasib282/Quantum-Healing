function ShowAttendance(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['event_id','date','req_no','added_at'],
       
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
        { label: 'Event name', key: 'event_id' },
        { label: 'Date', key: 'date' },
        { label: 'Registaration', key: 'reg_no' },
        { label: 'Attendence Time', key: 'added_at' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/attendance', ShowAttendance);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#branch");


    // Insert Ajax
    InsertAjax('admin/attendance',);


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/attendance', {department: { selector: '#updateDepartment', attribute: 'data-id' }}, function(){
        $('#updateDepartment').removeAttr('data-id');
    });
    

    // Delete Ajax
    DeleteAjax('admin/attendance');
    

    // Delete status Ajax
    DeleteStatusAjax('admin/attendance');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateEvents').val(item.event_id);
        $('#UpdateDate').val(item.date);
        $('#updateQr_url').val(item.reg_no);
        $('#updateBranch').focus();
    }

    // Get Trantype
    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'name');
        CreateSelectOptions('#updateEvents', "Select Events", res.data, 'name');
    })
});
