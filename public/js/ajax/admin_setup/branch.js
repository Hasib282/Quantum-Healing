function ShowBranches(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['branch','short'],
       
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
        { label: 'Branch Name', key: 'branch' },
        { label: 'Short Form', key: 'short' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/branches', ShowBranches);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#branch");


    // Insert Ajax
    InsertAjax('admin/branches', {}, function() {
        $("#branch").focus();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/branches', {department: { selector: '#updateDepartment', attribute: 'data-id' }}, function(){
        $('#updateDepartment').removeAttr('data-id');
    });
    

    // Delete Ajax
    DeleteAjax('admin/branches');
    

    // Delete status Ajax
    DeleteStatusAjax('admin/branches');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateBranch').val(item.branch);
        $('#updateShort').val(item.short);
        $('#updateBranch').focus();
    }
});


// $(document).ready(function () {
//     // Show all branches
//     function show() {
//         $.ajax({
//             url: '/api/admin/branches',
//             method: 'GET',
//             success: function (res) {
//                 let tableData = "";
//                 $.each(res.data, function (key, item) {
//                     tableData += `<tr>
//                         <td>${key + 1}</td>
//                         <td>${item.branch}</td>
//                         <td>${item.short}</td>
//                         <td>${item.added_at}</td>
//                         <td>
//                             <button id="edit" data-id="${item.id}">Edit</button>
//                             <button id="delete" data-id="${item.id}">Delete</button>
//                         </td>
//                     </tr>`;
//                 });

//                 $('#branch-data-table tbody').html(tableData);
//             },
//             error: function (err) {
//                 console.log("Error:", err);
//             }
//         });
//     }

//     show();

//     // Reload utility
//     function reloadData() {
//         show();
//     }

//     // Add branch
//     $('#BranchAddForm').on('submit', function (e) {
//         e.preventDefault();
//         let formData = new FormData(this);

//         $.ajax({
//             url: '/api/admin/branches',
//             method: 'POST',
//             data: formData,
//             processData: false,
//             contentType: false,
//             beforeSend: function () {
//                 $(document).find('span[id$="_error"]').text('');
//             },
//             success: function (res) {
//                 toastr.success("Branch added successfully!");
//                 $('#BranchAddForm')[0].reset();
//                 reloadData();
                
                
//             },
//             error: function (response) {
//                 if (response.responseJSON?.errors) {
//                     $.each(response.responseJSON.errors, function (key, value) {
//                         $('#' + key + "_error").text(value);
//                     });
//                 } else {
//             // General server error
//             toastr.error("Failed to add event. Try again.");
//         }
//             }
//         });
//     });

//     // Open edit modal and load data
//     $(document).on('click', '#edit', function () {
//         let id = $(this).data('id');
//         $.ajax({
//             url: '/api/admin/branches/edit',
//             method: 'GET',
//             data: { id },
//             success: function (res) {
//                 $('#id').val(res.data.id);
//                 $('#updateBranch').val(res.data.branch);
//                 $('#updateShort').val(res.data.short);
//                 $('#editModal').show();
//             }
//         });
//     });

//     // Update branch
//     $('#BranchEditForm').on('submit', function (e) {
//         e.preventDefault();
//         let formData = new FormData(this);

//         $.ajax({
//             url: '/api/admin/branches',
//             method: 'POST',
//             data: formData,
//             processData: false,
//             contentType: false,
//             headers: { 'X-HTTP-Method-Override': 'PUT' },
//             beforeSend: function () {
//                 $(document).find('span[id$="_error"]').text('');
//             },
//             success: function (res) {
//                 toastr.success("Branch updated successfully!");
//                 $('#BranchEditForm')[0].reset();
//                 $('#editModal').hide();
//                 reloadData();
//             },
//             error: function (response) {
//                 if (response.responseJSON?.errors) {
//                     $.each(response.responseJSON.errors, function (key, value) {
//                         $('#update_' + key + "_error").text(value);
//                     });
//                 } else {
//             toastr.error("Failed to update the branch. Try again.");
//             console.log("Update error", response);
//         }
//             }
//         });
//     });

//     // Open delete modal
//     $(document).on('click', '#delete', function () {
//         let id = $(this).data('id');
//         $('#confirm').attr('data-id', id);
//         $('#deleteModal').show();
//     });

//     // Confirm delete
//     $('#confirm').on('click', function () {
//         let id = $(this).data('id');
//         $.ajax({
//             url: '/api/admin/branches',
//             method: 'DELETE',
//             data: { id },
//             success: function (res) {
//                  toastr.success("Branch deleted successfully!");
//                 $('#deleteModal').hide();
//                 reloadData();
//                 alert(res.message);
//             }
//         });
//     });

//     // Cancel delete
//     $('#cancel').on('click', function () {
//         $('#deleteModal').hide();
//     });

//     // Search branch
//     $('#search').on('keyup', function () {
//         let option = $('#selectOption').val();
//         let search = $('#search').val();

//         $.ajax({
//             url: '/api/admin/branches/search',
//             method: 'GET',
//             data: { option, search },
//             success: function (res) {
//                 let tableData = "";
//                 $.each(res.data, function (key, item) {
//                     tableData += `<tr>
//                         <td>${key + 1}</td>
//                         <td>${item.branch}</td>
//                         <td>${item.short}</td>
//                         <td>${item.added_at}</td>
                       
//                         <td>
//                             <button id="edit" data-id="${item.id}">Edit</button>
//                             <button id="delete" data-id="${item.id}">Delete</button>
//                         </td>
//                     </tr>`;
//                 });

//                 $('#data-table tbody').html(tableData);
//             }
//         });
//     });
// });
