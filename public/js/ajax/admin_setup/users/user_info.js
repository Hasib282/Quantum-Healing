$(document).ready(function () {

    // Show user_info data
    function show() {
        $.ajax({
            url: '/api/admin/users/user_info/show',
            method: 'GET',
            success: function (res) {
                let tableData = "";
                $.each(res.data, function (key, item) {
                    tableData += `<tr>
                    <td>${item.id}</td>
                    <td>${item.sl}</td>
                    <td>${item.qr_url}</td>
                    <td>${item.u_id}</td>
                    <td>${item.reg_no}</td>
                    <td>${item.name}</td>
                    <td>${item.phone}</td>
                    <td>${item.duplicate}</td>
                    <td>${item.gender}</td>
                    <td>${item.age}</td>
                    <td>${item.dob}</td>
                    <td>${item.occupation}</td>
                    <td>${item.qt_status}</td>
                    <td>${item.quantum}</td>
                    <td>${item.quantier}</td>
                    <td>${item.ardentier}</td>
                    <td>${item.branch}</td>
                    <td>${item.job_status}</td>
                    <td>${item.psyche_certificate}</td>
                    <td>${item.sp}</td>
                    <td>${item.group}</td>
                    <td>${item.call}</td>
                    <td>${item.sms}</td>
                    <td>${item.color}</td>
                    <td>${item.barcode}</td>
                    <td>${item.new_barcode}</td>
                    <td>${item.new_barcode_sl}</td>
                    <td>${item.barcode_delivery}</td>
                    <td>${item.first_attend}</td>
                    <td>${item.last_attend}</td>
                    <td>${item.status}</td>
                    <td>${item.added_at}</td>
                    <td>${item.updated_at}</td>
                    <td>
                        <button id="edit" data-id="${item.id}">Edit</button>
                        <button id="delete" data-id="${item.id}">Delete</button>
                    </td>
                </tr>
                `
                });
                $('#data-table tbody').html(tableData);
            },
            error: function (response, textStatus, errorThrown) {
                console.log("Error: ", response);
                console.log("Text Status: ", textStatus);
                console.log("Error Thrown: ", errorThrown);
            },
        });
    }
    

    show();

    // Add user_info
    $('#AddForm').on('submit', function (e) {
        e.preventDefault();
        let formdata = new FormData(this);

        $.ajax({
            url: '/api/admin/users/user_info',
            method: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(document).find('span[id$="_error"]').text('');
            },
            success: function (res) {
                $('#AddForm')[0].reset();
                $('#addModal').hide();
                show();
                console.log(res);
                alert(res.message);
            },
            error: function (response) {
                if (response.responseJSON && response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (key, value) {
                        $('#' + key + "_error").text(value);
                    });
                } else {
                    console.log("Error: ", response);
                }
            },
        });
    });

   // Load data into edit modal
$(document).on('click', '#edit', function () {
    let id = $(this).data('id');

    $.ajax({
        url: '/api/admin/users/user_info/edit',
        method: "GET",
        data: { id },
        success: function (res) {
            $('#id').val(res.data.id);
            $('#update_sl').val(res.data.sl);
            $('#update_reg_no').val(res.data.reg_no);
            $('#update_name').val(res.data.name);
            $('#update_phone').val(res.data.phone);
            $('#update_gender').val(res.data.gender);
            $('#update_age').val(res.data.age);
            $('#update_dob').val(res.data.dob);
            $('#update_occupation').val(res.data.occupation);
            $('#update_sp').val(res.data.sp);
            $('#update_group').val(res.data.group);
            $('#update_call').val(res.data.call);
            $('#update_branch').val(res.data.branch);
            $('#update_first_attend').val(res.data.first_attend);
            $('#update_last_attend').val(res.data.last_attend);
            $('#update_uid').val(res.data.uid);
            $('#update_quantum').val(res.data.quantum);
            $('#update_quantier').val(res.data.quantier);
            $('#update_ardentier').val(res.data.ardentier);
            $('#update_job_status').val(res.data.job_status);
            $('#update_psyche_certificate').val(res.data.psyche_certificate);
            $('#update_sms').val(res.data.sms);
            $('#update_color').val(res.data.color);
            $('#update_barcode').val(res.data.barcode);
            $('#update_new_barcode').val(res.data.new_barcode);
            $('#update_new_barcode_sl').val(res.data.new_barcode_sl);
            $('#update_barcode_delivery').val(res.data.barcode_delivery);
            $('#update_status').val(res.data.status);
            $('#update_qt_status').val(res.data.qt_status);
            $('#update_qr_url').val(res.data.qr_url);           
            $('#update_duplicate').val(res.data.duplicate);
            $('#update_added_at').val(res.data.added_at);
            $('#update_updated_at').val(res.data.updated_at);
            $('#editModal').show();
        },
        error: function (response) {
            console.log("Error loading edit data: ", response);
        }
    });
});


    // Update user_info
    $('#EditForm').on('submit', function (e) {
        e.preventDefault();
        let formdata = new FormData(this);
    
        $.ajax({
            url: '/api/admin/users/user_info',
            method: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: function () {
                // $(document).find('span[id^="update_"]').text('');
            },
            success: function (res) {
                $('#EditForm')[0].reset();
                $('#editModal').hide();
                show();
                alert(res.message);
            },
            error: function (response) {
                if (response.responseJSON && response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (key, value) {
                        $('#update_' + key + "_error").text(value);
                    });
                } else {
                    console.log("Error: ", response);
                }
            },
        });
    });
    

    // Delete user_info
    $(document).on('click', '#delete', function () {
        if (!confirm('Are you sure you want to delete this user?')) {
            return;
        }
        let id = $(this).data('id');

        $.ajax({
            url: '/api/admin/users/user_info',
            method: "DELETE",
            data: { id },
            success: function (res) {
                show();
                console.log(res);
                alert(res.message);
            },
            error: function (response) {
                console.log("Error deleting: ", response);
            }
        });
    });

});
