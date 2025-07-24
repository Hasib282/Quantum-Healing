let requestMethod;
let $submitButton;

// For Globally Initialize Ajax Setup 
function AjaxSetup(){
    var token = localStorage.getItem('token');
    if (token) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
            },
            // xhrFields: {
            //     withCredentials: true, // Send session cookies
            // },
            beforeSend:function() {
                $(document).find('span.error').text('');
            },
            statusCode: {
                403: function() {
                    toastr.error('You are not allowed to access this.', "Permission denied");
                },
            }, 
            error: function(response, textStatus, errorThrown) {
                // Form Input Errors
                if (response.responseJSON && response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (key, value) {
                        if(requestMethod == 'POST'){
                            $('#' + key + "_error").text(value);
                        }
                        else if(requestMethod == "PUT"){
                            $('#update_' + key + "_error").text(value);
                        }
                        else if(requestMethod == "Multi POST"){
                            let keys = key.replace('.', '_');
                            $('#' + keys + "_error").text(value[0]);
                        }
                        else if(requestMethod == "Multi PUT"){
                            let keys = key.replace('.', '_');
                            $('#update_' + keys + "_error").text(value[0]);
                        }
                    });
                }

                // Redirect If Needed
                if (response.responseJSON && response.responseJSON.redirect) {
                    sessionStorage.setItem('redirectMessage', response.responseJSON.message);
                    window.location.href = response.responseJSON.redirect;
                }

                // If Unauthenticate then Redirect to Login
                if (response.responseJSON.message == "Unauthenticated.") {
                    sessionStorage.setItem('redirectMessage', 'You need to login First');
                    window.location.href = '/login';
                }

                // Show Error Message
                toastr.error('An unexpected error occurred.', errorThrown);
                // console.log('Failed to load dashboard data:', error);
                // console.log("Error: ", response);
                // console.log("Text Status: ", textStatus);
                // console.log("Error Thrown: ", errorThrown);
                // toastr.error('An unexpected error occurred.', "Error");
            },
        });
    } 
    else {
        // console.log('unauthorised')
        window.location.href = '/login';
    }
};


function sendAjaxRequest(url, method, data, success, beforeSend, error, processData, contentType) {
    $.ajax({
        url: url,
        
        method: method,
        
        data: data,
        
        beforeSend: beforeSend || function(response, settings) {
            $(document).find('span.error').text('');
            console.log('before send response',response)
            console.log('before send settings',settings)
        },
        
        success: success || function(data, textStatus, jqXHR){
            console.log('Success:', data);
            console.log('Success:', textStatus);
            console.log('Success:', jqXHR);
        },
        
        error: error || function(response, textStatus, errorThrown) {
            if (response.responseJSON && response.responseJSON.errors) {
                $.each(response.responseJSON.errors, function (key, value) {
                    $('#' + key + "_error").text(value);
                });
            } 
            else {
                console.log("Error: ", response);
                console.log("Text Status: ", textStatus);
                console.log("Error Thrown: ", errorThrown);
                toastr.error('An unexpected error occurred.', "Error");
            }
        },
        
        statusCode: {
            403: function() {
                toastr.error('You are not allowed to access this.', "Permission denied");
            },
        }, 
        
        processData: processData || true,
        
        contentType: contentType || 'application/x-www-form-urlencoded',
        
        // dataType: dataType || undefined,
        
        // timeout: timeout || undefined,
        
        // cache: cache || true,
        
        // headers: headers || undefined,
        
        // complete: complete || undefined,    
        
        // dataFilter: undefined,
        
        // crossDomain: crossDomain || false,
    });
};

$(document).ready(function () {
    AjaxSetup();
    SidebarAjax();
});