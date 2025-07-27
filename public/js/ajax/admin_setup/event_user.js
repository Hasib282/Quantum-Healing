function ShowEventUsers(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name',{ type:'multi-data', key:'eventparticipants' }],
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
        { label: 'Event Name', key: 'name' },
        { label: 'Participants', key: '' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/event_users', ShowEventUsers);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#events");


    // Insert Ajax
    InsertAjax('admin/event_users', {all_participants: localStorage.getItem('participants') }, function() {
        $("#branch").focus();
    });


    // //Edit Ajax
    // EditAjax(EditFormInputValue);


    // // Update Ajax
    // UpdateAjax('admin/event_users', {department: { selector: '#updateDepartment', attribute: 'data-id' }}, function(){
    //     $('#updateDepartment').removeAttr('data-id');
    // });
    

    // // Delete Ajax
    // DeleteAjax('admin/event_users');
    

    // // Delete status Ajax
    // DeleteStatusAjax('admin/event_users');


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


    $(document).on('click', '.addParticipants',function (e) {
        e.preventDefault();
        console.log($(this).data('id'));
        // $('.addParticipants').prop('disabled', true);

        let id = $(this).data('id');
        let name = $(this).data('name');
        let phone = $(this).data('phone');
        let reg_no = $(this).data('reg_no');
        let gender = $(this).data('gender');

        // Retrieve existing productIssue from local storage
        let participants = JSON.parse(localStorage.getItem('participants')) || [];
        let pid = participants.map(p => p.id);

        if (pid.includes(id)) {
            return;
        }

        let productIssue = {
            id,
            name,
            phone,
            reg_no,
            gender,
        };
        

        // Add the new productIssue to the list
        participants.push(productIssue);

        // Save updated productIssue back to local storage
        localStorage.setItem('participants', JSON.stringify(participants));


        gridShow();
        

        // $('.addParticipants').prop('disabled', false);
    })


    function gridShow() {
        let data = JSON.parse(localStorage.getItem('participants')) || [];
        let ids = data.map(p => p.id);
        let datas = {name: $('#participants').val(),ids};
        // let id = $(this).attr('data-id');
        GetInputList('admin/users/user_info/get/participants', datas, '#participants-list');

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



    $(document).off("click", '.remove-participant').on("click", '.remove-participant', function (e){
        e.preventDefault();
        console.log('a');
        
        let index = $(this).attr('data-index');
        let perticipants = JSON.parse(localStorage.getItem('participants')) || [];

        perticipants.splice(index, 1);
        localStorage.setItem('participants', JSON.stringify(perticipants));
        gridShow();
    })

    // Focus Event
    $(document).on('focus', '#participants', function (e) {
        e.preventDefault();
        let participants = JSON.parse(localStorage.getItem('participants')) || [];
        let ids = participants.map(p => p.id);
        let data = {name: $(this).val(),ids};
        // let id = $(this).attr('data-id');
        GetInputList('admin/users/user_info/get/participants', data, '#participants-list');
    });


    // $(document).off("change", '#events').on("change", '#events', function (e){
    //     console.log(e);
        
    //     let id = $(this).val();
    //     localStorage.setItem('participants',[])
    //     $.ajax({
    //         url: `${apiUrl}/admin/event_users/get`,
    //         data: {id},
    //         success: function (res) {
    //             let participants = localStorage.getItem('participants') || [];

    //             res.data.forEach(item => {
    //                 let productIssue = {
    //                     id:item.id,
    //                     name:item.name,
    //                     phone:item.phone,
    //                     reg_no:item.reg_no,
    //                     gender:item.gender,
    //                 };
    //                 console.log(item.name);
                    

    //                 // Add the new productIssue to the list
    //                 participants.push(productIssue);
    //             });

    //             // let productIssue = {
    //             //     id,
    //             //     name,
    //             //     phone,
    //             //     reg_no,
    //             //     gender,
    //             // };

    //             // Save updated productIssue back to local storage
    //             localStorage.setItem('participants', JSON.stringify(participants));
    //             // $(targetList).html(res);
    //         }
    //     });
    // });

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


    
});

