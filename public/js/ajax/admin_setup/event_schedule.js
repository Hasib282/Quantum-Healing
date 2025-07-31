function ShowEventSchedule(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['event.name','date'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}


$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Event Name', key: 'event.name' },
        { label: 'Date', key: 'date' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/event_schedule', ShowEventSchedule);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#events");


    // Insert Ajax
    InsertAjax('admin/event_schedule', {}, function() {
        $("#events").focus();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/event_schedule');
    

    // Delete Ajax
    DeleteAjax('admin/event_schedule');
    

    // Delete status Ajax
    DeleteStatusAjax('admin/event_schedule');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateEvents').val(item.event_id);
        $('#updateDate').val(item.date);
        $('#updateEvents').focus();
    }


    // Get Trantype
    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'name');
        CreateSelectOptions('#updateEvents', "Select Events", res.data, 'name');
    })
});