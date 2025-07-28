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
    InsertAjax('admin/attendance', {events: { selector: '#events' },date: { selector: '#date' }});


    $(document).off('input','#qr_url').on('input','#qr_url', function (e) {
        if (e.key === "Enter") {
            e.preventDefault(); // Only stop Enter
            // your custom logic here
        }
        else if(e.key === "Tab"){
            e.preventDefault();
        }
        let value = $(this).val();

        // $('#profileShow').attr('src',value)
        // console.log(e.key);
        // console.log(value);
        
    })


    // //Edit Ajax
    // EditAjax(EditFormInputValue);


    // // Update Ajax
    // UpdateAjax('admin/attendance', {department: { selector: '#updateDepartment', attribute: 'data-id' }}, function(){
    //     $('#updateDepartment').removeAttr('data-id');
    // });
    

    // // Delete Ajax
    // DeleteAjax('admin/attendance');
    

    // // Delete status Ajax
    // DeleteStatusAjax('admin/attendance');


    // // Additional Edit Functionality
    // function EditFormInputValue(item){
    //     $('#id').val(item.id);
    //     $('#updateEvents').val(item.event_id);
    //     $('#UpdateDate').val(item.date);
    //     $('#updateQr_url').val(item.reg_no);
    //     $('#updateBranch').focus();
    // }

    // Get Trantype
    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'name');
        CreateSelectOptions('#updateEvents', "Select Events", res.data, 'name');
    })


    $(document).off("change", '#events').on("change", '#events', function (e){
        let id = $(this).val();
        localStorage.removeItem('participants');
        $.ajax({
            url: `${apiUrl}/admin/event_users/get`,
            data: {id},
            success: function (res) {
                let participants = localStorage.getItem('participants') || [];

                res.data.forEach(item => {
                    let productIssue = {
                        id: item.id,
                        name: item.participants[0]?.name || '',
                        phone: item.participants[0]?.phone || '',
                        reg_no: item.participants[0]?.reg_no || '',
                        gender: item.participants[0]?.gender || '',
                    };
                    

                    // Add the new productIssue to the list
                    participants.push(productIssue);
                });

                // Save updated productIssue back to local storage
                localStorage.setItem('participants', JSON.stringify(participants));

                gridShow();
            }
        });
    });
});


function gridShow() {
    let data = JSON.parse(localStorage.getItem('participants')) || [];

    $('#all-participants tbody').html("");

    data.forEach((item, index) => {
        $('#all-participants tbody').append(`
            <tr>
                <td>${index + 1}</td>
                <td>${item.reg_no}</td>
                <td>${item.name}</td>
                <td>${item.phone}</td>
                <td>${item.gender}</td>
                <td><div class="center"><button class="remove remove-participant"  data-index="${index}"><i class="fas fa-trash"></i></button></div></td>
            </tr>`
        );
    });
}
