$(document).ready(function () {
    // Function to load data
    function show() {
        $.ajax({
            url: '/api/events',
            method: 'GET',
            success: function (res) {
                let tableData = "";
                $.each(res.data, function (key, item) {
tableData += `<tr>
    <td>${key+1}</td>
    <td>${item.name}</td>
    <td>${item.added_at ?? '-'}</td>
    <td>${item.updated_at ?? '-'}</td>
    <td>
        <button id="edit" data-id="${item.id}">Edit</button>
        <button id="delete" data-id="${item.id}">Delete</button>
    </td>
</tr>`;



                });

                $('#event-data-table tbody').html(tableData);
            },
            error: function (response) {
                console.log("Error loading data", response);
            },
        });
    }

    show(); // Initial call

    // Add event
    $('#EventAddForm').on('submit', function (e) {
        e.preventDefault();
        let formdata = new FormData(this);

      $.ajax({
    url: '/api/events',
    method: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    beforeSend: function () {
        // Clear any previous errors
        $(document).find('span[id$="_error"]').text('');
    },
    success: function (res) {
        toastr.success("Event added successfully!");
        $('#EventAddForm')[0].reset();
        show(); // refresh the event list or table
    },
    error: function (response) {
        if (response.responseJSON?.errors) {
            // Display validation errors below form fields
            $.each(response.responseJSON.errors, function (key, value) {
                $('#' + key + "_error").text(value);
            });
           
        } else {
            // General server error
            toastr.error("Failed to add event. Try again.");
        }
    },
});

    });

    // Edit event - load data to modal
    $(document).on('click', '#edit', function () {
        let id = $(this).data('id');

        $.ajax({
            url: '/api/events/edit',
            method: "GET",
            data: { id },
            success: function (res) {
                $('#id').val(res.data.id);
                $('#updateName').val(res.data.name);
                $('#editModal').show();
            },
        });
    });

    // Update event
    $('#EventEditForm').on('submit', function (e) {
        e.preventDefault();
        let formdata = new FormData(this);

   $.ajax({
    url: '/api/events',
    method: "POST", // You should still use PUT ideally, but keeping your current structure
    data: formdata,
    processData: false,
    contentType: false,
    beforeSend: function () {
        // Clear previous validation errors
        $(document).find('span[id^="update_"]').text('');
    },
    success: function (res) {
        toastr.success("Event updated successfully!");
        $('#EventEditForm')[0].reset();
        $('#editModal').hide();
        show(); // Refresh event list
    },
    error: function (response) {
        if (response.responseJSON?.errors) {
            $.each(response.responseJSON.errors, function (key, value) {
                $('#update_' + key + "_error").text(value);
            });
           
        } else {
            toastr.error("Failed to update the event. Try again.");
            console.log("Update error", response);
        }
    },
});

    });

    // Show delete modal
    $(document).on('click', '#delete', function () {
        let id = $(this).data('id');
        $('#confirm').attr('data-id', id);
        $('#deleteModal').show();
    });

    // Confirm delete
    $('#confirm').on('click', function () {
        let id = $(this).data('id');

        $.ajax({
            url: '/api/events',
            method: "DELETE",
            data: { id },
            success: function (res) {
                 toastr.success("Event deleted successfully!");
                $('#deleteModal').hide();
                show();
                alert(res.message);
            },
        });
    });

    // Cancel delete
    $('#cancel').on('click', function () {
        $('#deleteModal').hide();
    });

    // Search
    $('#search').on('keyup', function () {
        let option = $('#selectOption').val();
        let search = $('#search').val();

        $.ajax({
            url: '/api/events/search',
            method: "GET",
            data: { option, search },
            success: function (res) {
                let tableData = "";
                $.each(res.data, function (key, item) {
                    tableData += `<tr>
                                    <td>${key + 1}</td>
                                    <td>${item.name}</td>
                                    <td>
                                        <button id="edit" data-id="${item.id}">Edit</button>
                                        <button id="delete" data-id="${item.id}">Delete</button>
                                    </td>
                                </tr>`;
                });
                $('#data-table tbody').html(tableData);
            },
        });
    });
});
