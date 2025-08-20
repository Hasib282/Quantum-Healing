function ShowAttendance(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['events.name','date','users.name','added_at'],
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Event name', key: 'events.name' },
        { label: 'Date', key: 'date' },
        { label: 'Registaration', key: 'users.name' },
        { label: 'Attendence Time', key: 'added_at' },
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/attendance', ShowAttendance);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#branch");


    // Insert Ajax
    InsertAjax('admin/attendance', {events: { selector: '#events' },date: { selector: '#date' }}, function(res){
        $('#userData').html("")
        if(res.user){
            $('#userData').html(`
                <h2 class="center">User Details</h2>
                <table>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <div class="center">
                                    <img src="${apiUrl.replace('/api', '')}/storage/${res.user.image ? res.user.image : 'male.png'}?${new Date().getTime()}" height="200" onerror="this.onerror=null;this.src='${apiUrl.replace('/api', '')}/storage/male.png';">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Reg No :</td>
                            <td>${res.user.reg_no}</td>
                        </tr>
                        <tr>
                            <td>Name :</td>
                            <td>${res.user.name}</td>
                        </tr>
                        <tr>
                            <td>Phone :</td>
                            <td>${res.user.phone}</td>
                        </tr>
                        <tr>
                            <td>Branch :</td>
                            <td>${res.user.branch}</td>
                        </tr>
                    </tbody>
                </table>
            `);
        }
        $('#userData').append(`<span class="${res.status == false ? 'red':'green'}" style="padding:10px;display:flex;align-items:center;gap:5px;">${res.status == false ? '<i class="fa-solid fa-circle-xmark" style="font-size:25px;"></i>':'<i class="fa-solid fa-circle-check" style="font-size:25px;"></i>'} ${res.message}</span>`);
        $('#qr_url').val('');
        $('#qr_url').focus();

        let events = $('#events').val();
        let date = $('#date').val();
        
        $.ajax({
            url: `${apiUrl}/admin/attendance/count`,
            data: {events, date},
            success: function (res) {
                $('#grad').html(res.graduate ?? 0)
                $('#pro').html(res.prograduate ?? 0)
                $('#other').html(res.temp ?? 0)
                let total = Number(res.graduate) + Number(res.prograduate) + Number(res.temp);
                $('#tot').html(total ?? 0)
            }
        });
    });


    // Search by Type
    SearchBySelect('admin/attendance/search', ShowAttendance, "#searchEvents, #searchDates", {event: { selector: '#searchEvents'}, date: { selector: '#searchDates'}});


    // $(document).off('input','#qr_url').on('input','#qr_url', function (e) {
        
    //     if (e.key === "Enter") {
    //         e.preventDefault(); // Only stop Enter
    //         // your custom logic here
    //     }
    //     else if(e.key === "Tab"){
    //         e.preventDefault();
    //     }
    //     setTimeout(() => {
    //         let value = $(this).val();
    //         // $('#AddForm')[0].submit()
    //         console.log(value);
    //         // KeyDown(e);
    //         // $(targetTable).html('');
    //     }, 100);
        
        
    //     // $('#profileShow').attr('src',value)
    //     // console.log(e.key);
    //     // console.log(value);
        
    // })

    // Get Events By Date
    GetSelectInputList('admin/event_schedule/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'event.name', 'event.id');
        CreateSelectOptions('#updateEvents', "Select Events", res.data, 'event.name', 'event.id');
    })
    
    
    // Get Events
    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#searchEvents', "Select Events", res.data, 'name');
    })


    // Events Change 
    $(document).off('change','#date').on('change','#date', function (e) {
        e.preventDefault();
        let search = $(this).val();
        $.ajax({
            url: `${apiUrl}/admin/event_schedule/get`,
            data: {search},
            success: function (res) {
                CreateSelectOptions('#events', "Select Events", res.data, 'event.name', 'event.id');
                CreateSelectOptions('#updateEvents', "Select Events", res.data, 'event.name', 'event.id');
                // CreateSelectOptions('#eventDate', "Select Event Date", res.data, 'date', 'date');
                
                
            }
        });
    })
    
    
    // Events Change 
    $(document).off('change','#events').on('change','#events', function (e) {
        e.preventDefault();
        let events = $('#events').val();
        let date = $('#date').val();
        $.ajax({
            url: `${apiUrl}/admin/attendance/count`,
            data: {events, date},
            success: function (res) {
                $('#grad').html(res.graduate ?? 0)
                $('#pro').html(res.prograduate ?? 0)
                $('#other').html(res.temp ?? 0)
                let total = Number(res.graduate) + Number(res.prograduate) + Number(res.temp);
                $('#tot').html(total ?? 0)
            }
        });
    })
    


    // $(document).off("change", '#events').on("change", '#events', function (e){
    //     let id = $(this).val();
    //     localStorage.removeItem('participants');
    //     $.ajax({
    //         url: `${apiUrl}/admin/event_users/get`,
    //         data: {id},
    //         success: function (res) {
    //             let participants = localStorage.getItem('participants') || [];

    //             res.data.forEach(item => {
    //                 let productIssue = {
    //                     id: item.id,
    //                     name: item.participants? item.participants[0]?.name : item.name,
    //                     phone: item.participants? item.participants[0]?.phone : item.phone,
    //                     reg_no: item.participants? item.participants[0]?.reg_no : item.reg_no,
    //                     gender: item.participants? item.participants[0]?.gender : item.gender,
    //                 };
                    
    //                 console.log();
                    
    //                 // Add the new productIssue to the list
    //                 participants.push(productIssue);
    //             });

    //             // Save updated productIssue back to local storage
    //             localStorage.setItem('participants', JSON.stringify(participants));

    //             gridShow();
    //         }
    //     });
    // });
});


// function gridShow() {
//     let data = JSON.parse(localStorage.getItem('participants')) || [];

//     $('#all-participants tbody').html("");

//     data.forEach((item, index) => {
//         $('#all-participants tbody').append(`
//             <tr>
//                 <td>${index + 1}</td>
//                 <td>${item.reg_no}</td>
//                 <td>${item.name}</td>
//                 <td>${item.phone}</td>
//                 <td>${item.gender}</td>
//                 <td><div class="center"><button class="remove remove-participant"  data-index="${index}"><i class="fas fa-trash"></i></button></div></td>
//             </tr>`
//         );
//     });
// }
