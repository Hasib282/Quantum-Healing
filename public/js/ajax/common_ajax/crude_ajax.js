//////////////////// -------------------- Show Data on Hard Reload -------------------- ////////////////////
//////////////////// -------------------- Reload Content in Current Pagination Page After Successful Add/Update/Delete -------------------- ////////////////////
// function ReloadData(link, RenderData){
//     const queryParams = GetQueryParams();
//     const url = window.location.href.includes('/search')
//         ? `${apiUrl}/${link}/search`
//         : `${apiUrl}/${link}`;
        
//     LoadBackendData(url, RenderData, queryParams);

//     // CheckIfLastPage(function(isLastPage) {
//     //     if(isLastPage){
//     //         queryParams['page'] = GetCurrentPageFromURL() - 1;
//     //     }
//     //     if (window.location.href.includes('/search')) {
//     //         LoadBackendData(`${apiUrl}/${link}/search`, RenderData, queryParams);
//     //     }
//     //     else{
//     //         LoadBackendData(`${apiUrl}/${link}`, RenderData, queryParams); 
//     //     }
//     // });
// }; // End Method





//////////////////// -------------------- Show Data Ajax Part Start -------------------- ////////////////////
// function LoadBackendData(url, RenderData, queryParams) {
//     $.ajax({
//         url: url,
//         type: 'GET',
//         data: queryParams,
//         success: function(response) {
//             if (response.status) {
//                 UpdateUrl(url, queryParams);

//                 if (response.redirect) {
//                     window.location.href = response.redirect;
//                     return;
//                 }
                
//                 let startIndex = (response.data.current_page - 1) * response.data.per_page;
//                 RenderData(response.data.data ? response.data.data : response.data, startIndex, response);
//                 response.data.path ? RenderPagination(response.data) : null;
//             }
//             else{
//                 toastr.error(response.message, "Wrong Command!");
//             }
//         }
//     });
// }; // End Method





function ReloadData(url, RenderData, queryParams = {}) {
    $.ajax({
        url: `${apiUrl}/${url}`,
        type: 'GET',
        data: queryParams,
        beforeSend: function () {
            $('.load-data tbody').html(`
                <tr>
                    <td colspan="15">
                        <div class="loader-container">
                            <div class="spinner"></div>
                            <div class="loader-text">Loading, please wait...</div>
                        </div>
                    </td>
                </tr>
            `);
        },
        success: function(response) {
            if (response.status) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                    return;
                }
                
                RenderData(response);
            }
            else{
                toastr.error(response.message, "Wrong Command!");
            }
        }
    });
}; // End Method





// Add Button Click Functionality
function AddModalFunctionality(focusVariable, AddClickEvent){
    $(document).off('click', '#add').on('click', '#add', function (e) {
        e.preventDefault();
        let modalId = $(this).data('modal-id');
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }
        
        $('#AddForm')[0].reset();
        $('#previewImage').attr('src', "/images/male.png");

        $(focusVariable).focus();

        if(typeof AddClickEvent === 'function'){
            AddClickEvent();
        }
    });
}





/////////////// ------------------ Insert Ajax Part Start ---------------- /////////////////////////////
function InsertAjax(link, AddData = {}, AddSuccessEvent, method ="POST") {
    $(document).off('submit', '#AddForm').on('submit', '#AddForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.each(AddData, function(key, value) {
            if (typeof value === 'object' && value.selector) {
                let selectedValue = value.attribute ? $(value.selector).attr(value.attribute) : $(value.selector).val();
                formData.append(key, selectedValue === undefined ? '' : selectedValue);
            } else {
                formData.append(key, value === undefined ? '' : value);
            }
        });

        // $submitButton = $(this).find('button[type="submit"]');
        $('#Insert').prop('disabled', true);
        requestMethod = method;

        $.ajax({
            url: `${apiUrl}/${link}`,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function (res) {
                if (res.status) {
                    $('#AddForm')[0].reset();
                    
                    if(typeof AddSuccessEvent === 'function'){
                        AddSuccessEvent(res);
                    }
                    $('#previewImage').attr('src', "/images/male.png");

                    // ReloadData(link, RenderData);
                    
                    if(res.data){
                        tableInstance.addRow(res.data);
                    }

                    toastr.success(res.message, 'Added!');
                }
                else if(res.status == false){
                    if(typeof AddSuccessEvent === 'function'){
                        AddSuccessEvent(res);
                    }
                }
            },
            complete: function () {
                $('#Insert').prop('disabled', false);
            },
        });
    });
}; // End Method





///////////// ------------------ Edit Location Ajax Part Start ---------------- /////////////////////////////
function EditAjax(AddEvent=undefined, Id = 'id') {
    $(document).off('click', '#edit').on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }

        let id = $(this).data('id');
        // let status = $('#status').val();
        
        let data = tableInstance.filteredData.find(row => row[Id] == id);

        if(typeof AddEvent === 'function'){
            AddEvent(data);
        }
    });
}




// Edit By Ajax Call
function EditAjaxCall(link, AddSuccessEvent, AddClickEvent=undefined) {
    $(document).off('click', '#edit').on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        let status = $('#status').val();
        
        if(typeof AddClickEvent === 'function'){
            AddClickEvent();
        }
        
        $.ajax({
            url: `${apiUrl}/${link}/edit`,
            method: 'GET',
            data: { id, status },
            success: function (res) {
                if(typeof AddSuccessEvent === 'function'){
                    AddSuccessEvent(res);
                }
                
                $('#editModal').show()
            }
        });
    });
}





/////////////// ------------------ Update Ajax Part Start ---------------- /////////////////////////////
function UpdateAjax(link, AditionalData = {}, AdditionalEvent) {
    $(document).off('submit', '#EditForm').on('submit', '#EditForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.each(AditionalData, function(key, value) {
            if (typeof value === 'function') {
                formData.append(key, value === undefined ? '' : value())
                // finalValue = value(); // call the function to get current value
            }
            else if (typeof value === 'object' && value.selector) {
                let selectedValue = value.attribute ? $(value.selector).attr(value.attribute) : $(value.selector).val();
                formData.append(key, selectedValue === undefined ? '' : selectedValue);
            } else {
                formData.append(key, value === undefined ? '' : value);
            }
        });

        $('#Update').prop('disabled', true);
        requestMethod = 'PUT';

        $.ajax({
            url: `${apiUrl}/${link}`,
            method: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function (res) {
                if (res.status) {
                    $('#editModal').hide();

                    $('#EditForm')[0].reset();

                    if(typeof AdditionalEvent === 'function'){
                        AdditionalEvent();
                    }
                    
                    // ReloadData(link, RenderData);
                    tableInstance.updateRow(formData.get('id'), res.updatedData);

                    toastr.success(res.message, 'Updated!');
                }
            },
            complete: function () {
                $('#Update').prop('disabled', false);
            },
        });
    });
}; // End Method





//////////////////// -------------------- Delete Ajax Part Start -------------------- ////////////////////
function DeleteAjax(link) {
    $(document).off('click', '#confirm').on('click', '#confirm', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let status = $('#status').val();
        $('#confirm').prop('disabled', true);
        $.ajax({
            url: `${apiUrl}/${link}`,
            method: 'DELETE',
            data:{ id, status },
            success: function (res) {
                if (res.status) {
                    tableInstance.deleteRow(id);

                    $('#deleteModal').hide();

                    toastr.success(res.message, 'Deleted!');
                }
            },
            complete: function () {
                $('#confirm').prop('disabled', false);
            },
        });
    });
}; // End Method



//////////////////// -------------------- Delete Status Ajax Part Start -------------------- ////////////////////
function DeleteStatusAjax(link) {
    $(document).off('click', '#confirm_status').on('click', '#confirm_status', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        $('#confirm_status').prop('disabled', true);
        $.ajax({
            url: `${apiUrl}/${link}/delete`,
            method: 'DELETE',
            data:{ id },
            success: function (res) {
                if (res.status) {
                    tableInstance.updateRow(id, res.updatedData);

                    $('#deleteStatusModal').hide();

                    toastr.success(res.message, 'Deleted!');
                }
            },
            complete: function () {
                $('#confirm_status').prop('disabled', false);
            },
        });
    });
}; // End Method





//////////////////// -------------------- Details Ajax Part Start -------------------- ////////////////////
function DetailsAjax(link) {
    $(document).off('click', '#details').on('click', '#details', function (e) {
        let id = $(this).attr('data-id');
        $.ajax({
            url: `${apiUrl}/${link}/details`,
            method: 'GET',
            data: { id },
            success: function (res) {
                if(res.status){
                    $("#detailsModal").show();
                    $('.details').html(res.data)
                }
            }
        });
    });
}; // End Method





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////// ----------------- Add Transaction Details Into Local Storage Start ----------------- //////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////// ------------------ Get Transaction Grid By Transaction Id Ajax Part Start ---------------- /////////////////////////////
function getTransactionGrid(tranId) {
    let status = $('#status').length ? $('#status').val() : 1;
    $.ajax({
        url: `${apiUrl}/transaction/get/transactiongrid`,
        method: 'GET',
        data: { tranId, status },
        success: function (res) {
            if(res.status){
                let transactions = res.data;

                // Retrieve existing productGrids from local storage
                let productGrids = JSON.parse(localStorage.getItem('transactionData')) || [];

                transactions.forEach(transaction => {
                    let productGrid = {
                        product: transaction.tran_head_id,
                        name: transaction.head.tran_head_name,
                        groupe: transaction.tran_groupe_id,
                        quantity: transaction.quantity_actual,
                        amount: transaction.amount,
                        unit: transaction.unit_id,
                        cp: transaction.cp,
                        mrp: transaction.mrp,
                        totAmount: transaction.total_amount,
                        expiry: transaction.expiry_date,
                        batch: transaction.batch,
                    };
                    
                    // Add the new productGrids to the list
                    productGrids.push(productGrid);
                });
                // Save updated productGrids back to local storage
                localStorage.setItem('transactionData', JSON.stringify(productGrids));

                DisplayTransactionGrid();
            }
        }
    });
}; // End Method



/////////////// ------------------ Display ProductGrids in The Transaction Grid Table Functionality Ajax Part Start ---------------- /////////////////////////////
function DisplayTransactionGrid() {
    let pathSegments = window.location.pathname.split('/');
    let segment1 = pathSegments[1];
    let segment3 = pathSegments[3];
    let productIssues = JSON.parse(localStorage.getItem('transactionData')) || [];
    $('.transaction_grid tbody').html("");

    let total = 0;
    productIssues.forEach((products, index) => {
        let dynamicColumn = '';

        // Set the value of dynamicColumn based on conditions
        if (segment1 === 'transaction' || segment1 === 'hospital' || segment3 === 'return' || segment1 === 'hotel') {
            dynamicColumn = `<td>${products.amount}</td>`;
        } else if (segment3 === 'purchase') {
            dynamicColumn = `<td>${products.cp}</td>`;
        } else if (segment3 === 'issue') {
            dynamicColumn = `<td>${products.mrp}</td>`;
        }


        $('.transaction_grid tbody').append(`
            <tr>
                <td>${index + 1}</td>
                <td>${products.name}</td>
                <td>${products.quantity}</td>
                ${dynamicColumn}
                <td>${products.totAmount}</td>
                ${segment3 === 'return' ? '<td>'+ products.pbatch + '</td>' : ""}
                <td><div class="center"><button class="remove" data-index="${index}"><i class="fas fa-trash"></i></button></div></td>
            </tr>`
        );

        total = total + Number(products.totAmount);
    });
    

    // Calculate Add Modal Bill
    $("#amountRP").val(total);
    let discount = Number($("#totalDiscount").val());
    let netAmount = total - discount;
    $("#netAmount").val(netAmount);
    let advance = Number($("#advance").val());
    let balance = netAmount - advance;
    $("#balance").val(balance);

    // Calculate Edit Modal Bill
    $("#updateAmountRP").val(total);
    let updateDiscount = Number($("#updateTotalDiscount").val());
    let updateNetAmount = total - updateDiscount;
    $("#updateNetAmount").val(updateNetAmount);
    let updateAdvance = Number($("#updateAdvance").val());
    let updateBalance = updateNetAmount - updateAdvance;
    $("#updateBalance").val(updateBalance);
} // End Method



/////////////// ------------------ Transaction Form Validation Functionality Ajax Part Start ---------------- /////////////////////////////
function validateFormData(isEdit = false, issue = false) {
    let isValid = true;
    let errors = {};

    let batch = $(isEdit ? '#updatePbatch' : '#pbatch').attr('data-id');
    let head = $(isEdit ? '#updateHead' : '#head').attr('data-id');
    let product = $(isEdit ? '#updateProduct' : '#product').attr('data-id');
    let quantity = $(isEdit ? '#updateQuantity' : '#quantity').val();
    let totAmount = $(isEdit ? '#updateTotAmount' : '#totAmount').val();

    let mrp = $(isEdit ? '#updateMrp' : '#mrp').val();
    let cp = $(isEdit ? '#updateCp' : '#cp').val();
    let amount = $(isEdit ? '#updateAmount' : '#amount').val();
    

    // Validate Product
    if (!head && !product) {
        isValid = false;
        errors.product = "Service/Product name is required.";
    }
    else if (isProductDuplicate(head || product)) {
        isValid = false;
        errors.product = "This service/product has already been added.";
    }

    // Check Product Stock Before Issue
    if(issue){
        $.ajax({
            url: `${apiUrl}/transaction/get/product/stock`,
            method: 'GET',
            data: { product, quantity, batch },
            async: false,
            success: function (res) {
                if(res.result){
                    isValid = false;
                    errors.product = `Product stock is low. \n only ${res.totQuantity} product left.`;
                }
                displayErrors(errors,isEdit);
                return isValid;
            }
        });
    }

    // Validate Quantity
    if (!quantity || isNaN(quantity) || quantity <= 0) {
        isValid = false;
        errors.quantity = "Quantity must be a positive number.";
    }

    // Validate Total Amount
    if (!totAmount || isNaN(totAmount) || totAmount <= 0) {
        isValid = false;
        errors.totAmount = "Total amount must be a positive number.";
    }


    // Validate Cost Price
    if (cp != undefined && (!cp || isNaN(cp) || cp <= 0)) {
        isValid = false;
        errors.cp = "CP must be a positive number.";
    }
    

    // Validate MRP
    if (mrp != undefined && (!mrp || isNaN(mrp) || mrp <= 0)) {
        isValid = false;
        errors.mrp = "MRP must be a positive number.";
    }
    

    // Validate amount
    if (amount != undefined && (!amount || isNaN(amount) || amount <= 0)) {
        isValid = false;
        errors.amount = "Amount must be a positive number.";
    }
    

    displayErrors(errors, isEdit);
    return isValid;
} // End Method



/////////////// ------------------ Check Duplicate Product Functionality Ajax Part Start ---------------- /////////////////////////////
function isProductDuplicate(product) {
    let productIssues = JSON.parse(localStorage.getItem('transactionData')) || [];
    return productIssues.some(products => products.product == product);
} // End Method



/////////////// ------------------ Display Errors Functionality Ajax Part Start ---------------- /////////////////////////////
function displayErrors(errors, isEdit = false) {
    const prefix = isEdit ? "update_" : "";
    $(`#${prefix}quantity_error`).html(errors.quantity || '');
    $(`#${prefix}totAmount_error`).html(errors.totAmount || '');

    $(`#${prefix}head_error`).html(errors.product || '');
    $(`#${prefix}product_error`).html(errors.product || '');
    $(`#${prefix}mrp_error`).html(errors.mrp || '');
    $(`#${prefix}cp_error`).html(errors.cp || '');
    $(`#${prefix}amount_error`).html(errors.amount || '');
} // End Method



/////////////// ------------------ Insert or Update Product Details Into Local Storage Ajax Part Start ---------------- /////////////////////////////
function InsertLocalStorage(isIssue = false, isReturn = false) {
    $(document).off('click', '#InsertTransaction, #UpdateTransaction').on('click', '#InsertTransaction, #UpdateTransaction', function (e) {
        e.preventDefault();

        const isUpdate = $(this).is('#UpdateTransaction')

        if (!validateFormData(isUpdate, isIssue)) {
            return;
        }

        
        
        
        // let mrp = $('#price').val();
        

        let product = isUpdate ? ($('#updateProduct').attr('data-id') || $('#updateHead').attr('data-id')) :($('#product').attr('data-id') || $('#head').attr('data-id'));
        let name = isUpdate ? ($('#updateProduct').val() || $('#updateHead').val()) : ($('#product').val() || $('#head').val());
        let groupe = isUpdate ? ($('#updateProduct').attr('data-groupe') || $('#updateHead').attr('data-groupe')) : ($('#product').attr('data-groupe') || $('#head').attr('data-groupe'));
        let quantity = isUpdate ? $('#updateQuantity').val() : $('#quantity').val();
        let mrp = isUpdate ? $('#updateMrp').val() : $('#mrp').val();
        let totAmount = isUpdate ? $('#updateTotAmount').val() : $('#totAmount').val();


        let unit = isUpdate ? $('#updateUnit').attr('data-id') : $('#unit').attr('data-id');
        let cp = isUpdate ? $('#updateCp').val() : $('#cp').val();
        let expiry = isUpdate ? $('#updateExpiry').val() : $('#expiry').val();
        let amount = isUpdate ? $('#updateAmount').val() : $('#amount').val();
        let batch = isUpdate ? $('#updatePbatch').attr('data-id') : $('#pbatch').attr('data-id');
        let pbatch = isUpdate ? $('#updateProduct').attr('data-batch') : $('#product').attr('data-batch');

        
        const path = window.location.pathname;
        const pathSegments = path.split("/");
        
        if (batch === undefined && pathSegments[3] === "issue") {
            if (!confirm('Batch ID is not selected. Do you want to proceed?')) {
                return;
            }
        }


        let productIssue = {
            product,
            name,
            groupe,
            quantity,
            mrp,
            totAmount,

            unit,
            cp,
            expiry,
            amount,
            batch,
            pbatch,
        };
        

        // Retrieve existing productIssue from local storage
        let productIssues = JSON.parse(localStorage.getItem('transactionData')) || [];

        // Add the new productIssue to the list
        productIssues.push(productIssue);

        // Save updated productIssue back to local storage
        localStorage.setItem('transactionData', JSON.stringify(productIssues));

        DisplayTransactionGrid();


        isUpdate ? $('#updateProduct').val('') : $('#product').val('') ;
        isUpdate ? $('#updateProduct').removeAttr('data-id') : $('#product').removeAttr('data-id');
        isUpdate ? $('#updateProduct').removeAttr('data-groupe') : $('#product').removeAttr('data-groupe');
        isUpdate ? $('#updateHead').val('') : $('#head').val('');
        isUpdate ? $('#updateHead').removeAttr('data-id') : $('#head').removeAttr('data-id');
        isUpdate ? $('#updateHead').removeAttr('data-groupe') : $('#head').removeAttr('data-groupe');
        
        isUpdate ? $('#updateQuantity').val('1') :$('#quantity').val('1');
        isUpdate ? $('#updateMrp').val('') :$('#mrp').val('');
        isUpdate ? $('#updateTotAmount').val('') :$('#totAmount').val('');
        !isReturn ? isUpdate ? $("#updateHead").focus() :$("#head").focus() : "";
        !isReturn ? isUpdate ? $("#updateProduct").focus() :$("#product").focus() : "";
        isReturn ? isUpdate ? $("#batch-details-list tbody tr").focus() :$("#batch-details-list tbody tr").focus() : "";

        isUpdate ? $('#updateUnit').val('') : $('#unit').val('');
        isUpdate ? $('#updateUnit').removeAttr('data-id') : $('#unit').removeAttr('data-id');
        isUpdate ? $('#updateCp').val('') : $('#cp').val('');
        isUpdate ? $('#updateAmount').val('') : $('#amount').val('');
        let currentDate = new Date().toISOString().split('T')[0];
        isUpdate ? $('#updateExpiry').val(currentDate) : $('#expiry').val(currentDate);

        isUpdate ? $('#updatePbatch').val('') : $('#pbatch').val('') ;
        isUpdate ? $('#updatePbatch').removeAttr('data-id') : $('#pbatch').removeAttr('data-id');
    }); // End Method
} // End Function


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////// ----------------- Add Transaction Details Into Local Storage End ----------------- //////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function InsertTransaction(url, method, type, AddSuccessEvent) {
    $(document).off('click', '#InsertMain').on('click', '#InsertMain', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('transactionData');
        if (!products) {
            $('#message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let withs = $('#user').attr('data-with');
        let user = $('#user').attr('data-id');
        let ptn_id = $('#patient').attr('data-id');
        let booking_id = $('#hotel-booking').val();
        let guest_id = $('#guest').attr('data-id');
        let name = $('#name').val();
        let phone = $('#phone').val();
        let address = $('#address').val();
        let store = $('#store').val();
        let amountRP = $('#amountRP').val();
        let discount = $('#totalDiscount').val();
        let netAmount = $('#netAmount').val();
        let advance = $('#advance').val();
        let balance = $('#balance').val();
        let company = $('#company').attr('data-id');
        let batch = $('#batch').val();
        $.ajax({
            url: `${apiUrl}/${url}`,
            method: 'POST',
            data: { products:JSON.stringify(products), booking_id, name, phone, address, type, method, withs, user, ptn_id, guest_id, store, amountRP, discount, netAmount, advance, balance, company, batch },
            success: function (res) {
                if (res.status) {
                    $('#AddForm')[0].reset();

                    if(typeof AddSuccessEvent === 'function'){
                        AddSuccessEvent();
                    }

                    localStorage.removeItem('transactionData');
                    tableInstance.addRow(res.data);
                    toastr.success(res.message, 'Added!');
                }
            }
        });
    });
};



function UpdateTransaction(url, method, type, AddSuccessEvent = undefined) {
    $(document).off('click', '#UpdateMain').on('click', '#UpdateMain', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('transactionData');
        if (!products) {
            $('#update_message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let tranid = $('#updateTranId').val();
        let booking_id = $('#updateHotel-booking').val();
        let id = $('#id').val();
        let amountRP = $('#updateAmountRP').val();
        let totalDiscount = $('#updateTotalDiscount').val();
        let netAmount = $('#updateNetAmount').val();
        let advance = $('#updateAdvance').val();
        let balance = $('#updateBalance').val();
        let name = $('#updateName').val();
        let phone = $('#updatePhone').val();
        let address = $('#updateAddress').val();
        let status = $('#status').val();
        $.ajax({
            url: `${apiUrl}/${url}`,
            method: 'PUT',
            data: { products:JSON.stringify(products), booking_id, name, phone, address, id, tranid, type, method, amountRP, totalDiscount, netAmount, advance, balance, status },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status) {
                    $('#editModal').hide();

                    if(typeof AddSuccessEvent === 'function'){
                        AddSuccessEvent();
                    }

                    localStorage.removeItem('transactionData');
                    tableInstance.updateRow(document.getElementById('id').value, res.updatedData);
                    toastr.success(res.message, 'Updated!');
                }
            }
        });
    });
}





//////////////////// -------------------- Search By Date Ajax Part Start -------------------- ////////////////////
function SearchByDateAjax(url, RenderData, data={}){
    $(document).off('change', '#startDate, #endDate').on('change', '#startDate, #endDate', function(e){
        e.preventDefault();
        $('#startDate').length ? data.startDate = $('#startDate').val() : '';
        $('#endDate').length ? data.endDate = $('#endDate').val() : '';
        $('#status').length ? data.status = $('#status').val() : '';
        $('#product-search').length ? data.search_id = $('#product-search').attr('data-id') : '';
        ReloadData(url, RenderData, data);
    });
}; // End Method





//////////////////// -------------------- Search By Select Input Change Ajax Part Start -------------------- ////////////////////
function SearchBySelect(url, RenderData, id, data={}){
    $(document).off('change', id).on('change', id, function(e){
        e.preventDefault();
        $('#startDate').length ? data.startDate = $('#startDate').val() : '';
        $('#endDate').length ? data.endDate = $('#endDate').val() : '';
        $(id).length ? data.status = $(id).val() : '';
        ReloadData(url, RenderData, data);
    });
}; // End Method







$(document).ready(function () {
    //////////////////// -------------------- Delete Ajax Part Start -------------------- ////////////////////
    // Delete Button Functionality
    $(document).on('click', '#delete', function (e) {
        e.preventDefault();
        $('#deleteModal').show();
        let id = $(this).data('id');
        $('#confirm').attr('data-id',id);
        $('#cancel').focus();
    });  // End Delete Button Event



    // Cancel Button Functionality
    $(document).on('click', '#cancel', function (e) {
        e.preventDefault();
        $('#deleteModal').hide();
    }); // End Cancel Button Event
    //////////////////// -------------------- Delete Ajax Part End -------------------- ////////////////////
    
    
    //////////////////// -------------------- Delete Status Ajax Part Start -------------------- ////////////////////
    // Delete Status Button Functionality
    $(document).on('click', '#delete_status', function (e) {
        e.preventDefault();
        $('#deleteStatusModal').show();
        let id = $(this).data('id');
        $('#confirm_status').attr('data-id',id);
        $('#cancel_status').focus();
    });  // End Delete Status Button Event



    // Cancel Status Button Functionality
    $(document).on('click', '#cancel_status', function (e) {
        e.preventDefault();
        $('#deleteStatusModal').hide();
    }); // End Cancel Status Button Event
    //////////////////// -------------------- Delete Status Ajax Part End -------------------- ////////////////////



    //////////////////// -------------------- Remove Product From Local Storage Part Start -------------------- ////////////////////
    $(document).off("click", '.remove').on("click", '.remove', function (e){
        e.preventDefault();
        let index = $(this).attr('data-index');
        let productGrids = JSON.parse(localStorage.getItem('transactionData')) || [];

        productGrids.splice(index, 1);
        localStorage.setItem('transactionData', JSON.stringify(productGrids));
        DisplayTransactionGrid();
    })
    //////////////////// -------------------- Remove Product From Local Storage Part End -------------------- ////////////////////
});