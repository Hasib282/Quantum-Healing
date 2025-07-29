function ShowEvents(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name','all'],
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
        { label: 'Event Name', key: 'name' },
        { label: 'All Participant', key: 'all' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/events', ShowEvents);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#branch");


    // Insert Ajax
    InsertAjax('admin/events', {}, function() {
        $("#branch").focus();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/events');
    

    // Delete Ajax
    DeleteAjax('admin/events');
    

    // Delete status Ajax
    DeleteStatusAjax('admin/events');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.name);
        $('#updateAll').prop('checked', item.all == '1');
        $('#updateName').focus();
    }
});



// $(document).ready(function () {
//     // Function to load data
//     function show() {
//         $.ajax({
//             url: '/api/admin/events',
//             method: 'GET',
//             success: function (res) {
//                 let tableData = "";
//                 $.each(res.data, function (key, item) {
// tableData += `<tr>
//     <td>${key+1}</td>
//     <td>${item.name}</td>
//     <td>${item.added_at ?? '-'}</td>
//     <td>${item.updated_at ?? '-'}</td>
//     <td>
//         <button id="edit" data-id="${item.id}">Edit</button>
//         <button id="delete" data-id="${item.id}">Delete</button>
//     </td>
// </tr>`;



//                 });

//                 $('#event-data-table tbody').html(tableData);
//             },
//             error: function (response) {
//                 console.log("Error loading data", response);
//             },
//         });
//     }

//     show(); // Initial call

//     // Add event
//     $('#EventAddForm').on('submit', function (e) {
//         e.preventDefault();
//         let formdata = new FormData(this);

//       $.ajax({
//     url: '/api/admin/events',
//     method: "POST",
//     data: formdata,
//     processData: false,
//     contentType: false,
//     beforeSend: function () {
//         // Clear any previous errors
//         $(document).find('span[id$="_error"]').text('');
//     },
//     success: function (res) {
//         toastr.success("Event added successfully!");
//         $('#EventAddForm')[0].reset();
//         show(); // refresh the event list or table
//     },
//     error: function (response) {
//         if (response.responseJSON?.errors) {
//             // Display validation errors below form fields
//             $.each(response.responseJSON.errors, function (key, value) {
//                 $('#' + key + "_error").text(value);
//             });
           
//         } else {
//             // General server error
//             toastr.error("Failed to add event. Try again.");
//         }
//     },
// });

//     });

//     // Edit event - load data to modal
//     $(document).on('click', '#edit', function () {
//         let id = $(this).data('id');

//         $.ajax({
//             url: '/api/admin/events/edit',
//             method: "GET",
//             data: { id },
//             success: function (res) {
//                 $('#id').val(res.data.id);
//                 $('#updateName').val(res.data.name);
//                 $('#editModal').show();
//             },
//         });
//     });

//     // Update event
//     $('#EventEditForm').on('submit', function (e) {
//         e.preventDefault();
//         let formdata = new FormData(this);

//    $.ajax({
//     url: '/api/admin/events',
//     method: "POST", // You should still use PUT ideally, but keeping your current structure
//     data: formdata,
//     processData: false,
//     contentType: false,
//     beforeSend: function () {
//         // Clear previous validation errors
//         $(document).find('span[id^="update_"]').text('');
//     },
//     success: function (res) {
//         toastr.success("Event updated successfully!");
//         $('#EventEditForm')[0].reset();
//         $('#editModal').hide();
//         show(); // Refresh event list
//     },
//     error: function (response) {
//         if (response.responseJSON?.errors) {
//             $.each(response.responseJSON.errors, function (key, value) {
//                 $('#update_' + key + "_error").text(value);
//             });
           
//         } else {
//             toastr.error("Failed to update the event. Try again.");
//             console.log("Update error", response);
//         }
//     },
// });

//     });

//     // Show delete modal
//     $(document).on('click', '#delete', function () {
//         let id = $(this).data('id');
//         $('#confirm').attr('data-id', id);
//         $('#deleteModal').show();
//     });

//     // Confirm delete
//     $('#confirm').on('click', function () {
//         let id = $(this).data('id');

//         $.ajax({
//             url: '/api/admin/events',
//             method: "DELETE",
//             data: { id },
//             success: function (res) {
//                  toastr.success("Event deleted successfully!");
//                 $('#deleteModal').hide();
//                 show();
//                 alert(res.message);
//             },
//         });
//     });

//     // Cancel delete
//     $('#cancel').on('click', function () {
//         $('#deleteModal').hide();
//     });

//     // Search
//     $('#search').on('keyup', function () {
//         let option = $('#selectOption').val();
//         let search = $('#search').val();

//         $.ajax({
//             url: '/api/admin/events/search',
//             method: "GET",
//             data: { option, search },
//             success: function (res) {
//                 let tableData = "";
//                 $.each(res.data, function (key, item) {
//                     tableData += `<tr>
//                                     <td>${key + 1}</td>
//                                     <td>${item.name}</td>
//                                     <td>
//                                         <button id="edit" data-id="${item.id}">Edit</button>
//                                         <button id="delete" data-id="${item.id}">Delete</button>
//                                     </td>
//                                 </tr>`;
//                 });
//                 $('#data-table tbody').html(tableData);
//             },
//         });
//     });
// });
