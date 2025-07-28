function ShowEventUsers(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name',{ type:'multi-data', key:'users' }],
        actions: (row) => {
            return `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
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
    

    //  Edit Ajax
    EditAjaxCall('admin/event_users', EditFormInputValue, function(){
        localStorage.removeItem('participants');
        $('#all-participants tbody').html("");
        $('#participants-list').html("");
    });


    // Update Ajax
    UpdateAjax('admin/event_users', {all_participants: () => JSON.stringify(JSON.parse(localStorage.getItem('participants') || '[]')) }, function(){
        $("#branch").focus();
        localStorage.removeItem('participants');
        $('#all-participants tbody').html("");
        $('#participants-list').html("");
    });


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.data[0].event_id);
        $('#events').val(item.data[0].event_id);

        $('#participants').focus();

        let participants = localStorage.getItem('participants') || [];

        item.data.forEach(item => {
            let productIssue = {
                id: item.id,
                name: item.participants[0]?.name || '',
                phone: item.participants[0]?.phone || '',
                reg_no: item.participants[0]?.reg_no || '',
                gender: item.participants[0]?.gender || '',
            };
            participants.push(productIssue);
        });

        // Save updated productIssue back to local storage
        localStorage.setItem('participants', JSON.stringify(participants));

        gridShow();
    }

    // Get Trantype
    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'name');
        CreateSelectOptions('#updateEvents', "Select Events", res.data, 'name');
    })


    $(document).on('click', '.addData',function (e) {
        e.preventDefault();
        // console.log($(this));
        
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

        $(this).remove();
    })



    $(document).off("click", '.remove-participant').on("click", '.remove-participant', function (e){
        e.preventDefault();
        let index = $(this).attr('data-index');
        let perticipants = JSON.parse(localStorage.getItem('participants')) || [];

        perticipants.splice(index, 1);
        localStorage.setItem('participants', JSON.stringify(perticipants));
        gridShow();
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
                // $(targetList).html(res);
            }
        });
    });



    FixedScrollSearch(
        'admin/users/user_info/get/participants',

        function (currentPage) {
            let data = JSON.parse(localStorage.getItem('participants')) || [];
            let reg_no = data.map(p => p.reg_no);
            return {
                search: $('#participants').val(),
                page: currentPage,
                reg_no: reg_no
            };
        }, 

        '#participants', 

        '#participants-list',

        '#participants-list tbody tr',
    )
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

