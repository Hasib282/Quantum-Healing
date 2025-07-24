function ShowAdmins(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['user_id','user_name','user_email', 'user_phone', {key:'image', type: 'image'},{key:'status', type: 'status'},'store.store_name'],
        actions: (row) => {
            let buttons = '';
            
            if (userPermissions.includes(3) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            if (userPermissions.includes(4) || role == 1) {
                buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
                `;

                if (role == 1 || role == 2) {
                    buttons += `
                        <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                    `;
                }
            }
            
            return buttons;
        }
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Admin Id', key: 'user_id' },
        { label: 'Name', key: 'user_name' },
        { label: 'Email', key: 'user_email' },
        { label: 'Phone', key: 'user_phone' },
        { label: 'Image'},
        { label: 'Status', status: [{key:1, label:'Active' }, { key:0, label:'Inactive'}]},
        { label: 'Store', type:"select", key: 'store_id', method:"fetch", link:'admin/stores/get', name:"store_name" },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/users/admins', ShowAdmins);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('admin/users/admins', {company: { selector: '#company', attribute: 'data-id' }, store: { selector: '#store', attribute: 'data-id' }}, function() {
        $('#name').focus();
        $('#location').removeAttr('data-id');
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/users/admins');
    

    // Delete Ajax
    DeleteAjax('admin/users/admins');


    // Delete Status Ajax
    DeleteStatusAjax('admin/users/admins');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.user_name);
        $('#updatePhone').val(item.user_phone);
        $('#updateEmail').val(item.user_email);

        $('#updatePreviewImage').attr('src',`${apiUrl.replace('/api', '')}/storage/${item.image ? item.image : 'male.png'}?${new Date().getTime()} `).show();
        $('#updateName').focus();
    }; // End Method


    // Show Detals Ajax
    DetailsAjax('admin/users/admins');


    // Get Store 
    GetSelectInputList('admin/stores/get', function (res) {
        CreateSelectOptions('#store', 'Select Store', res.data, 'store_name');
    })
});