function ShowBranches(res) {
    // tableInstance = new GenerateTable({
    //     tableId: '#data-table',
    //     data: res.data,
    //     tbody: ['branch','short'],
       
    //     actions: (row) => {
    //         return `
    //             <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
    //             <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
    //         `;
    //     }
    // });
}



$(document).ready(function () {
    // // Render The Table Heads
    // renderTableHead([
    //     { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
    //     { label: 'Branch Name', key: 'branch' },
    //     { label: 'Short Form', key: 'short' },
    //     { label: 'Action', type: 'button' }
    // ]);


    // // Load Data on Hard Reload
    // ReloadData('admin/branches', ShowBranches);
    

    // // Add Modal Open Functionality
    // AddModalFunctionality("#branch");


    // // Insert Ajax
    // InsertAjax('admin/branches', {}, function() {
    //     $("#branch").focus();
    // });


    // //Edit Ajax
    // EditAjax(EditFormInputValue);


    // // Update Ajax
    // UpdateAjax('admin/branches', {department: { selector: '#updateDepartment', attribute: 'data-id' }}, function(){
    //     $('#updateDepartment').removeAttr('data-id');
    // });
    

    // // Delete Ajax
    // DeleteAjax('admin/branches');
    

    // // Delete status Ajax
    // DeleteStatusAjax('admin/branches');


    // // Additional Edit Functionality
    // function EditFormInputValue(item){
    //     $('#id').val(item.id);
    //     $('#updateBranch').val(item.branch);
    //     $('#updateShort').val(item.short);
    //     $('#updateBranch').focus();
    // }

    // Get Trantype
    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'name');
        CreateSelectOptions('#updateEvents', "Select Events", res.data, 'name');
    })


    $(document).on('click', '.addParticipants',function (res) {
        res.preventDefault();
        console.log($(this).data('id'));
    })

    // Keydown Event
    // $(document).off('keydown', '#participants').on('keydown', '#participants', function (e) {
    //     e.preventDefault();


    //     setTimeout(() => {
    //         if ((e.key.length === 1 && e.key.match(/^[a-zA-Z0-9]$/)) || e.key === "Backspace" || e.key === 'Space'){
    //             GetInputList('admin/users/user_info/get/participants', {name: $(this).val()}, '#participants-list');
    //             // $(targetInput).removeAttr('data-id');

    //             // Remove Input Data Events If Needed
    //             // if (typeof RemoveData === "function") {
    //             //     RemoveData(targetInput);
    //             // }
                
    //             // if (timeoutId) {
    //             //     clearTimeout(timeoutId);
    //             // }

    //             // Set a new timeout for the GetInputList call
    //             // timeoutId = setTimeout(() => {
    //             //     GetInputList(link, data, targetUl);
    //             // }, 800);
    //         }
    //         // $(targetTable).html('');
    //     }, 0);
    // });


    // Focus Event
    $(document).off('focus', '#participants').on('focus', '#participants', function (e) {
        e.preventDefault();
        let data = {name: $(this).val()};
        // let id = $(this).attr('data-id');
        GetInputList('admin/users/user_info/get/participants', data, '#participants-list');
    });
});

