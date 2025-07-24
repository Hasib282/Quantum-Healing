let timeoutId = null;
// Search By Input Function For Searching in Input
function SearchByInput(link, getData, targetInput, targetUl, targetList, tableData = undefined, targetTable="", AdditionalEvent = undefined, RemoveData = undefined) {
    let keyDownProcessed = false;
    // Keydown Event
    $(document).off('keydown', targetInput).on('keydown', targetInput, function (e) {
        keyDownProcessed = true;
        setTimeout(() => {
            let data = getData($(this));
            KeyDown(e, link, data, targetUl, targetList, targetInput, AdditionalEvent, RemoveData);
            $(targetTable).html('');
        }, 0);
    });



    // List Keypup Event
    $(document).off('keydown', `${targetList}`).on('keydown', `${targetList}`, function (e) {
        // Skip the list keyup event if input keydown was processed
        if (keyDownProcessed) {
            keyDownProcessed = false; // Reset the flag
            return;
        }

        ListKeyUp(e, targetUl, targetList, targetInput, AdditionalEvent);
    });



    // Focus Event
    $(document).off('focus', targetInput).on('focus', targetInput, function (e) {
        let data = getData($(this));
        let id = $(this).attr('data-id');
        if(id == undefined) {
            GetInputList(link, data, targetUl);
        }
        else{
            if (typeof tableData === "function") {
                tableData(id);
            }
        }
    });



    // Focous out event
    $(document).off('focusout', targetInput).on('focusout', targetInput, function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $(targetUl).html('');
                }
            });
        }
    });


    // Company List Click Event
    $(document).off('click', `${targetList}`).on('click', `${targetList}`, function () {
        let value = $(this).text();
        let id = $(this).data('id');
        
        $(targetInput).val(value);
        $(targetInput).attr('data-id', id);
        $(targetUl).html('');

        // Additional Events If Needed
        if (typeof AdditionalEvent === "function") {
            AdditionalEvent(targetInput, $(this));
        }
        
        $(targetInput).focus();
    });
}





// Keydown Event Function Start
function KeyDown(e, link, data, targetUl, targetList, targetInput, AdditionalEvent, RemoveData){
    let key = e.key;
    let list = $(`${targetList}`);
    
    if (key === 'Enter') { // Enter Key
        e.preventDefault();
    }
    else if (key === 'Tab') { // Tab key
        $(targetUl).html('');
    }
    else if ((key.length === 1 && key.match(/^[a-zA-Z0-9]$/)) || key === "Backspace" || key === 'Space'){
        $(targetInput).removeAttr('data-id');

        // Remove Input Data Events If Needed
        if (typeof RemoveData === "function") {
            RemoveData(targetInput);
        }
        
        if (timeoutId) {
            clearTimeout(timeoutId);
        }

        // Set a new timeout for the GetInputList call
        timeoutId = setTimeout(() => {
            GetInputList(link, data, targetUl);
        }, 800);
    }
    if (list.length > 0) {
        if (key === 'ArrowDown') {
            e.preventDefault();
            UpdateInput(list, 0, targetInput, AdditionalEvent);
        } 
        else if (key === 'ArrowUp') {
            e.preventDefault();
            UpdateInput(list, list.length - 1, targetInput, AdditionalEvent);
        }
    }
} // Keydown Event Function End




// List Keyup Event Function Start
function ListKeyUp(e, targetUl, targetList, targetInput, AdditionalEvent) {
    e.preventDefault();
    let key = e.key;
    let list = $(`${targetList}`);
    let focused = $(`${targetList}:focus`);
    let nextIndex, prevIndex;

    if (key === 'ArrowDown') {
        nextIndex = (focused.index() + 1) % list.length;
        UpdateInput(list, nextIndex, targetInput, AdditionalEvent);
    } 
    else if (key === 'ArrowUp') {
        prevIndex = (focused.index() - 1) % list.length;
        UpdateInput(list, prevIndex, targetInput, AdditionalEvent);
    }
    else if (key === 'Enter') {
        $(targetUl).html('');
        $(targetInput).focus();
    }
}



// Update The Input Value When Focusing on Lists
function UpdateInput(list, index, targetInput, AdditionalEvent) {
    let item = list.eq(index);
    item.focus();
    $(targetInput).val(item.text());
    $(targetInput).attr("data-id", item.data('id'));
    
    // Additional Events If Needed
    if (typeof AdditionalEvent === "function") {
        AdditionalEvent(targetInput, item);
    }
}





$(document).ready(function () {
    /////////////// ------------------ Search Company by name and add value to input ajax part start ---------------- /////////////////////////////
    // Company Input Search
    SearchByInput(
        'admin/companies/get', 

        function ($input) {
            return {
                company: $input.val(),
            };
        }, 

        '#company', 

        '#company-list',

        '#company-list li',
    );


    // Update Company Input Search
    SearchByInput(
        'admin/companies/get', 

        function ($input) {
            return {
                company: $input.val(),
            };
        }, 

        '#updateCompany', 

        '#update-company',

        '#update-company li',
    );

    
    
    /////////////// ------------------ Search Department by name and add value to input ajax part start ---------------- /////////////////////////////
    // Department Input Search
    SearchByInput(
        'hr/setup/department/get', 

        function ($input) {
            return {
                department: $input.val(),
            };
        }, 

        '#department', 

        '#department-list',

        '#department-list li',
    );


    // Update Department Input Search
    SearchByInput(
        'hr/setup/department/get', 

        function ($input) {
            return {
                department: $input.val(),
            };
        }, 

        '#updateDepartment', 

        '#update-department',

        '#update-department li',
    );

    
    
    /////////////// ------------------ Search Designation by name and Department and add value to input ajax part start ---------------- /////////////////////////////
    // Designation Input Search
    SearchByInput(
        'hr/setup/designation/get', 

        function ($input) {
            return {
                department: $('#department').attr('data-id'),
                designation: $input.val(),
            };
        }, 

        '#designation', 

        '#designation-list',

        '#designation-list li',
    );


    // Update Designation Input Search
    SearchByInput(
        'hr/setup/designation/get', 

        function ($input) {
            return {
                department: $('#updateDepartment').attr('data-id'),
                designation: $input.val(),
            };
        }, 

        '#updateDesignation', 

        '#update-designation',

        '#update-designation li',
    );

    
    
    /////////////// ------------------ Search Location by Upazila and add value to input ajax part start ---------------- /////////////////////////////
    // Location Input Search
    SearchByInput(
        'admin/locations/get', 

        function ($input) {
            if ($('#division').length) {
                return {
                    division: $('#division').val(),
                    location: $input.val(),
                };
            }
            else{
                return {
                    division: 'undefined',
                    location: $input.val(),
                };
            }
        }, 

        '#location', 

        '#location-list',

        '#location-list li',
    );


    // Update Location Input Search
    SearchByInput(
        'admin/locations/get', 

        function ($input) {
            if ($('#updateDivision').length) {
                return {
                    division: $('#updateDivision').val(),
                    location: $input.val(),
                };
            }
            else{
                return {
                    division: 'undefined',
                    location: $input.val(),
                };
            }
        }, 

        '#updateLocation', 

        '#update-location',

        '#update-location li'
    );
    
    
    
    /////////////// ------------------ Search Bank by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Bank Input Search
    SearchByInput(
        'admin/banks/get', 

        function ($input) {
            return {
                bank: $input.val(),
            };
        }, 

        '#bank', 

        '#bank-list',

        '#bank-list li',
    );


    // Update Bank Input Search
    SearchByInput(
        'admin/banks/get', 

        function ($input) {
            return {
                bank: $input.val(),
            };
        }, 

        '#updateBank', 

        '#update-bank',

        '#update-bank li',
    );
    
    
    
    // /////////////// ------------------ Search Store by Name and add value to input ajax part start ---------------- /////////////////////////////
    // // Store Input Search
    // SearchByInput(
    //     'admin/stores/get', 

    //     function ($input) {
    //         return {
    //             store: $input.val(),
    //         };
    //     }, 

    //     '#store', 

    //     '#store-list',

    //     '#store-list li',
    // );


    // // Update Store Input Search
    // SearchByInput(
    //     'admin/stores/get', 

    //     function ($input) {
    //         return {
    //             store: $input.val(),
    //         };
    //     }, 

    //     '#updateStore', 

    //     '#update-store',

    //     '#update-store li',
    // );
    
    
    
    /////////////// ------------------ Search Manufacturer by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Manufacturer Input Search
    SearchByInput(
        'inventory/setup/manufacturer/get',  

        function ($input) {
            return {
                manufacturer: $input.val(),
                type: $('#type').val()
            };
        }, 

        '#manufacturer', 

        '#manufacturer-list',

        '#manufacturer-list li',
    );


    // Update Manufacturer Input Search
    SearchByInput(
        'inventory/setup/manufacturer/get', 

        function ($input) {
            return {
                manufacturer: $input.val(),
                type: $('#updateType').val()
            };
        }, 

        '#updateManufacturer', 

        '#update-manufacturer',

        '#update-manufacturer li',
    );
    
    
    
    /////////////// ------------------ Search Category by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Category Input Search
    SearchByInput(
        'inventory/setup/category/get',  

        function ($input) {
            return {
                category: $input.val(),
                type: $('#type').val()
            };
        }, 

        '#category', 

        '#category-list',

        '#category-list li',
    );


    // Update Category Input Search
    SearchByInput(
        'inventory/setup/category/get', 

        function ($input) {
            return {
                category: $input.val(),
                type: $('#updateType').val()
            };
        }, 

        '#updateCategory', 

        '#update-category',

        '#update-category li',
    );
    
    
    
    /////////////// ------------------ Search Form by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Form Input Search
    SearchByInput(
        'inventory/setup/form/get',  

        function ($input) {
            return {
                form: $input.val(),
                type: $('#type').val()
            };
        }, 

        '#form', 

        '#form-list',

        '#form-list li',
    );


    // Update Form Input Search
    SearchByInput(
        'inventory/setup/form/get', 

        function ($input) {
            return {
                form: $input.val(),
                type: $('#updateType').val()
            };
        }, 

        '#updateForm', 

        '#update-form',

        '#update-form li',
    );
    
    
    
    /////////////// ------------------ Search Unit by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Unit Input Search
    SearchByInput(
        'inventory/setup/unit/get',  

        function ($input) {
            return {
                unit: $input.val(),
                type: $('#type').val()
            };
        }, 

        '#unit', 

        '#unit-list',

        '#unit-list li',
    );


    // Update Unit Input Search
    SearchByInput(
        'inventory/setup/unit/get', 

        function ($input) {
            return {
                unit: $input.val(),
                type: $('#updateType').val()
            };
        }, 

        '#updateUnit', 

        '#update-unit',

        '#update-unit li',
    );



    /////////////// ------------------ Search Product Batch Id and add value to input ajax part start ---------------- /////////////////////////////
    // Product Batch Input Search
    SearchByInput(
        'transaction/get/productbatch',  

        function ($input) {
            return {
                batch: $input.val(),
                product: $('#product').attr('data-id'),
            };
        }, 

        '#pbatch', 

        '#pbatch-list',

        '#pbatch-list li',
    );


    // Update Product Batch Input Search
    SearchByInput(
        'transaction/get/productbatch', 

        function ($input) {
            return {
                batch: $input.val(),
                product: $('#updateProduct').attr('data-id'),
            };
        }, 

        '#updatePbatch', 

        '#update-pbatch',

        '#update-pbatch li',
    );
    
    
    
    /////////////// ------------------ Search Batch Id and add value to input ajax part start ---------------- /////////////////////////////
    // Batch Input Search
    SearchByInput(
        'transaction/get/batch',  

        function ($input) {
            return {
                batch: $input.val(),
                type : $('#type').val(), 
                method : $('#method').val(),
            };
        }, 

        '#batch', 

        '#batch-list',

        '#batch-list li',

        function () {
            GetInputList('transaction/get/batch/details', {batch: $('#batch').attr('data-id')}, '#batch-details-list tbody');
        },

        '#batch-details-list tbody',
    );

    

    // Update Batch Input Search
    SearchByInput(
        'transaction/get/batch', 

        function ($input) {
            return {
                batch: $input.val(),
                type : $('#type').val(), 
                method : $('#method').val(),
            };
        }, 

        '#updateBatch', 

        '#update-batch',

        '#update-batch li',

        function () {
            GetInputList('transaction/get/batch/details', {batch: $('#updateBatch').attr('data-id')}, '#update-batch-details-list tbody');
        },

        '#batch-details-list tbody',
    );



    // Select batch item to return 
    $(document).off('click', '.batch-table tbody tr').on('click', '.batch-table tbody tr', function (e) {
        $('#product').val($(this).attr('data-name'))
        $('#product').attr("data-id", $(this).attr('data-id'))
        $('#product').attr("data-groupe",$(this).attr('data-groupe'))
        $('#product').attr("data-batch",$(this).attr('data-batch'))
        $('#product').attr("data-quantity",$(this).attr('data-quantity'))
        $('#quantity').val($(this).attr('data-quantity'))
        $('#amount').val($(this).attr('data-amount'))
        $('#totAmount').val($(this).attr('data-tot'))
        $('#quantity').focus();
    });
    
    
    
    ////////////// ------------------- Search Transaction User and add value to input ajax part start --------------- ////////////////////////////
    // User Input Search
    SearchByInput(
        'transaction/get/user',  

        function ($input) {
            if ($('#within').length) {
                tranUserType = $('.with-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                within = 1;
            } else {
                tranUserType = $('#type').val();
                within = 0;
            }

            return {
                tranUserType,
                within,
                tranUser: $input.val(),
            };
        }, 

        '#user', 

        '#user-list',

        '#user-list li',

        function (id) {
            getDueListByUserId(id, '.due-grid tbody');
            getPayrollByUserId(id, '.payroll-grid tbody');
        },

        ".due-grid tbody, .due-grid tfoot, .payroll-grid tbody, .payroll-grid tfoot",

        function (targetInput, item) {
            $(targetInput).attr("data-with", item.data('with'));
            $('#name').val(item.data('name'));
            $('#phone').val(item.data('phone'));
            $('#address').val(item.data('address'));
        }
    );


    // Update User Input Search
    SearchByInput(
        'transaction/get/user', 

        function ($input) {
            if ($('#within').length) {
                tranUserType = $('.with-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                within = 1;
            } else {
                tranUserType = $('#updateType').val();
                within = 0;
            }

            return {
                tranUserType,
                within,
                tranUser: $input.val(),
            };
        }, 

        '#updateUser', 

        '#update-user',

        '#update-user li',
        
        function (id) {
            getDueListByUserId(id, '.due-grid tbody');
            getPayrollByUserId(id, '.payroll-grid tbody');
        },

        ".due-grid tbody, .due-grid tfoot, .payroll-grid tbody, .payroll-grid tfoot",

        function (targetInput, item) {
            $(targetInput).attr("data-with", item.data('with'));
            $('#updateName').val(item.data('name'));
            $('#updatePhone').val(item.data('phone'));
            $('#updateAddress').val(item.data('address'));
        }
    );



    /////////////// ------------------ Search Transaction Heads By Name And Group Add value to input ajax part start ---------------- /////////////////////////////
    // Head Input Search
    SearchByInput(
        'admin/tranheads/get',  

        function ($input) {
            let groupe;
            let groupein;
            if ($('#groupein').length) {
                groupe = $('.groupe-checkbox:checked').map(function() {
                    return $(this).val()
                }).get();
                groupein = 1;
            } else {
                groupe = $('#groupe').val();
                groupein = 0;
            }
            return {
                groupe,
                groupein,
                head: $input.val(),
            };
        }, 

        '#head', 

        '#head-list',

        '#head-list li',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).attr("data-groupe", item.data('groupe'));
            $('#amount').val(item.data('mrp'));
            let qty = $('#quantity').val();
            $('#totAmount').val(item.data('mrp') * qty);
        },

        function (targetInput) {
            $(targetInput).removeAttr('data-groupe');
            $('#amount').val('');
            $('#totAmount').val('');
        }
    );



    // Update Head Input Search
    SearchByInput(
        'admin/tranheads/get', 

        function ($input) {
            let groupe;
            let groupein;
            if ($('#groupein').length) {
                groupe = $('.groupe-checkbox:checked').map(function() {
                    return $(this).val()
                }).get();
                groupein = 1;
            } else {
                groupe = $('#updateGroupe').val();
                groupein = 0;
            }

            return {
                groupe,
                groupein,
                head: $input.val(),
            };
        }, 

        '#updateHead', 

        '#update-head',

        '#update-head li',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).attr("data-groupe", item.data('groupe'));
            $('#updateAmount').val(item.data('mrp'));
            let qty = $('#quantity').val();
            $('#updateTotAmount').val(item.data('mrp') * qty);
        },

        function (targetInput) {
            $(targetInput).removeAttr('data-groupe');
            $('#updateAmount').val('');
            $('#updateTotAmount').val('');
        }
    );







    /////////////// ------------------ Search Products By Name And Group add value to input ajax part start ---------------- /////////////////////////////
    // Product Input Search
    SearchByInput(
        'inventory/setup/product/get',  

        function ($input) {
            let groupe;
            let groupein;
            if ($('#groupein').length) {
                groupe = $('.groupe-checkbox:checked').map(function() {
                    return $(this).val()
                }).get();
                groupein = 1;
            } else {
                groupe = $('#updateGroupe').val();
                groupein = 0;
            }

            return {
                groupe,
                groupein,
                product: $input.val(),
            };
        }, 

        '#product', 

        '#product-list table tbody',

        '#product-list table tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
            $(targetInput).attr("data-groupe", item.data('groupe'));
            $('#mrp').val(item.attr('data-mrp'));
            $('#cp').val(item.attr('data-cp'));
            $('#unit').val(item.attr('data-unit'));
            $('#unit').attr('data-id',item.data('unit-id'));
            let qty = $('#quantity').val();

            const path = window.location.pathname;
            const pathSegments = path.split("/");
            
            if(pathSegments[3] === 'issue'){
                $('#totAmount').val(item.attr('data-mrp') * qty);
            }
            else if(pathSegments[3] === 'purchase'){
                $('#totAmount').val(item.attr('data-cp') * qty);
            }
        },

        function (targetInput) {
            $(targetInput).removeAttr('data-groupe');
            $('#unit').removeAttr('data-id');
            $('#mrp').val('');
            $('#cp').val('');
            $('#unit').val('');
            $('#totAmount').val('');
        }
    );


    
    // Update Product Input Search
    SearchByInput(
        'inventory/setup/product/get', 

        function ($input) {
            let groupe;
            let groupein;
            if ($('#groupein').length) {
                groupe = $('.groupe-checkbox:checked').map(function() {
                    return $(this).val()
                }).get();
                groupein = 1;
            } else {
                groupe = $('#updateGroupe').val();
                groupein = 0;
            }
            
            return {
                groupe,
                groupein,
                product: $input.val(),
            };
        }, 

        '#updateProduct', 

        '#update-product table tbody',

        '#update-product table tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
            $(targetInput).attr("data-groupe", item.data('groupe'));
            $('#updateMrp').val(item.attr('data-mrp'));
            $('#updateCp').val(item.attr('data-cp'));
            $('#updateUnit').val(item.attr('data-unit'));
            $('#updateUnit').attr('data-id',item.data('unit-id'));
            let qty = $('#updateQuantity').val();

            const path = window.location.pathname;
            const pathSegments = path.split("/");
            
            if(pathSegments[3] === 'issue'){
                $('#updateTotAmount').val(item.attr('data-mrp') * qty);
            }
            else if(pathSegments[3] === 'purchase'){
                $('#updateTotAmount').val(item.attr('data-cp') * qty);
            }
        }, 

        function (targetInput) {
            $(targetInput).removeAttr('data-groupe');
            $('#updateUnit').removeAttr('data-id');
            $('#updateMrp').val('');
            $('#updateCp').val('');
            $('#updateUnit').val('');
            $('#updateTotAmount').val('');
        }
    );

    /////////////// ------------------ Search Products By Name And Groupe add value to input ajax part end ---------------- /////////////////////////////





    /////////////// ------------------ Search Specialization by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Specialization Input Search
    SearchByInput(
        'hospital/setup/specialization/get',  

        function ($input) {
            return {
                specialization: $input.val(),
            };
        }, 

        '#specialization', 

        '#specialization-list',

        '#specialization-list li',
    );


    // Update Specialization Input Search
    SearchByInput(
        'hospital/setup/specialization/get', 

        function ($input) {
            return {
                specialization: $input.val(),
            };
        }, 

        '#updateSpecialization', 

        '#update-specialization',

        '#update-specialization li',
    );
    
    
    
    /////////////// ------------------ Search Floor by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Floor Input Search
    SearchByInput(
        'hospital/setup/floor/get',  

        function ($input) {
            return {
                floor: $input.val(),
            };
        }, 

        '#floor',

        '#floor-list',

        '#floor-list li',
    );


    // Update Specialization Input Search
    SearchByInput(
        'hospital/setup/floor/get', 

        function ($input) {
            return {
                floor: $input.val(),
            };
        }, 

        '#updateFloor', 

        '#update-floor',

        '#update-floor li',
    );





    /////////////// ------------------ Search Bed Category by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Bed Category Input Search
    SearchByInput(
        'hospital/setup/bedcategory/get',  

        function ($input) {
            return {
                bed_category: $input.val(),
            };
        }, 

        '#bed_category', 

        '#bed_category-list',

        '#bed_category-list li',

        function (id) {
            GetInputList('hotel/setup/roomlist/get/all', {bed_category: $('#bed_category').attr('data-id')}, "#bed-list-table table tbody");
        },

        "#bed-list-table table tbody",
    );


    // Update Bed Category Input Search
    SearchByInput(
        'hospital/setup/bedcategory/get', 

        function ($input) {
            return {
                bed_category: $input.val(),
            };
        }, 

        '#updateBed_Category', 

        '#update-bed_category',

        '#update-bed_category li',

        function (id) {
            GetInputList('hotel/setup/roomlist/get/all', {bed_category: $('#updateBed_Category').attr('data-id')}, "#updateBed-list-table table tbody");
        },

        "#updateBed-list-table table tbody",
    );
    
    
    
    
    
    /////////////// ------------------ Search Bed List by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Bed List Input Search
    SearchByInput(
        'hospital/setup/bedlist/get',  

        function ($input) {
            return {
                bed_list: $input.val(),
                bed_category: $('#bed_category').attr('data-id'),
            };
        }, 

        '#bed_list', 

        '#bed_list-list',

        '#bed_list-list li',

        undefined, 

        "",

        function (targetInput, item) {
            $('#total').val(item.attr('data-price'));
            $('#balance').val(item.attr('data-price'));
            $('#adult').val(item.attr('data-capacity'));
        },

        function (targetInput) {
            $('#total').val(0);
            $('#balance').val(0);
            $('#adult').val(0);
        }
    );


    // Update Bed List Input Search
    SearchByInput(
        'hospital/setup/bedlist/get', 

        function ($input) {
            return {
                bed_list: $input.val(),
                bed_category: $('#updateBed_Category').attr('data-id'),
            };
        }, 

        '#updateBed_List', 

        '#update-bed_list',

        '#update-bed_list li',

        undefined, 

        "",

        function (targetInput, item) {
            $('#updateTotal').val(item.attr('data-price'));
            $('#updateBalance').val(item.attr('data-price'));
            $('#updateAdult').val(item.attr('data-capacity'));
            
        },

        function (targetInput) {
            $('#updateTotal').val(0);
            $('#updateBalance').val(0);
            $('#updateAdult').val(0);
        }
    );





    /////////////// ------------------ Search Nursing Station by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Nursing Station Input Search
    SearchByInput(
        'hospital/setup/nursingstation/get',  

        function ($input) {
            return {
                nursing_station: $input.val(),
            };
        }, 

        '#nursing_station', 

        '#nursing_station-list',

        '#nursing_station-list li',
    );


    // Update Nursing Station Input Search
    SearchByInput(
        'hospital/setup/nursingstation/get', 

        function ($input) {
            return {
                nursing_station: $input.val(),
            };
        }, 

        '#updateNursing_Station', 

        '#update-nursing_station',

        '#update-nursing_station li',
    );





    /////////////// ------------------ Search Sales Representative by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Sales Representative Input Search
    SearchByInput(
        'transaction/get/user',  

        function ($input) {
            return {
                tranUser: $input.val(),
                tranUserType: '4',
            };
        }, 

        '#sr', 

        '#sr-list',

        '#sr-list li',
    );


    // Update Sales Representative Input Search
    SearchByInput(
        'transaction/get/user', 

        function ($input) {
            return {
                tranUser: $input.val(),
                tranUserType: '4',
            };
        }, 

        '#updateSR', 

        '#update-sr',

        '#update-sr li',
    );





    /////////////// ------------------ Search Marketing Head by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Marketing Head Input Search
    SearchByInput(
        'transaction/get/user',  

        function ($input) {
            return {
                tranUser: $input.val(),
                tranUserType: '5',
            };
        }, 

        '#marketing_head', 

        '#marketing_head-list',

        '#marketing_head-list li',
    );


    // Update Marketing Head Input Search
    SearchByInput(
        'transaction/get/user', 

        function ($input) {
            return {
                tranUser: $input.val(),
                tranUserType: '5',
            };
        }, 

        '#updateMarketing_Head', 

        '#update-marketing_head',

        '#update-marketing_head li',
    );





    /////////////// ------------------ Search Doctor by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Doctor Input Search
    SearchByInput(
        'hospital/users/doctors/get',  

        function ($input) {
            return {
                doctor: $input.val(),
            };
        }, 

        '#doctor', 

        '#doctor-list',

        '#doctor-list tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
        }
    );


    // Update Doctor Input Search
    SearchByInput(
        'hospital/users/doctors/get', 

        function ($input) {
            return {
                doctor: $input.val(),
            };
        }, 

        '#updateDoctor', 

        '#update-doctor',

        '#update-doctor tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
        }
    );





    /////////////// ------------------ Search Patients And add value to input ajax part start ---------------- /////////////////////////////
    // Patient Input Search
    SearchByInput(
        'hospital/users/patients/get',  

        function ($input) {
            return {
                patient: $input.val(),
            };
        }, 

        '#patient', 

        '#patient-list',

        '#patient-list tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
            $('#title').val(item.attr('data-title'));
            $('#name').val(item.attr('data-name'));
            $('#phone').val(item.attr('data-phone'));
            $('#email').val(item.attr('data-email'));
            $('#gender').val(item.attr('data-gender'));
            $('#nationality').val(item.attr('data-nationality'));
            $('#religion').val(item.attr('data-religion'));
            $('#address').val(item.attr('data-address'));

            const age = calculateAge(item.attr('data-dob'));

            $('#age_years').val(age.years);
            $('#age_months').val(age.months);
            $('#age_days').val(age.days);
        },

        function (targetInput) {
            $('#title').val('');
            $('#name').val('');
            $('#phone').val('');
            $('#email').val('');
            $('#gender').val('');
            $('#nationality').val('');
            $('#religion').val('');
            $('#address').val('');
            $('#age_years').val('');
            $('#age_months').val('');
            $('#age_days').val('');
        }
    );


    
    // Update Patient Input Search
    SearchByInput(
        'hospital/users/patients/get', 

        function ($input) {
            return {
                patient: $input.val(),
            };
        }, 

        '#updatePatient', 

        '#update-patient',

        '#update-patient tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
            $('#updateTitle').val(item.attr('data-title'));
            $('#updateName').val(item.attr('data-name'));
            $('#updatePhone').val(item.attr('data-phone'));
            $('#updateEmail').val(item.attr('data-email'));
            $('#updateGender').val(item.attr('data-gender'));
            $('#updateNationality').val(item.attr('data-nationality'));
            $('#updateReligion').val(item.attr('data-religion'));
            $('#updateAddress').val(item.attr('data-address'));

            const age = calculateAge(item.attr('data-dob'));

            $('#updateAge_years').val(age.years);
            $('#updateAge_months').val(age.months);
            $('#updateAge_days').val(age.days);
        },

        function (targetInput) {
            $('#updateTitle').val('');
            $('#updateName').val('');
            $('#updatePhone').val('');
            $('#updateEmail').val('');
            $('#updateGender').val('');
            $('#updateNationality').val('');
            $('#updateReligion').val('');
            $('#updateAddress').val('');
            $('#updateAge_years').val('');
            $('#updateAge_months').val('');
            $('#updateAge_days').val('');
        }
    );
    
    
    
    /////////////// ------------------ Search guests And add value to input ajax part start ---------------- /////////////////////////////
    // Guest Input Search
    SearchByInput(
        'hotel/users/guests/get',  

        function ($input) {
            return {
                guest: $input.val(),
            };
        }, 

        '#guest', 

        '#guest-list',

        '#guest-list tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
            $('#title').val(item.attr('data-title'));
            $('#name').val(item.attr('data-name'));
            $('#phone').val(item.attr('data-phone'));
            $('#email').val(item.attr('data-email'));
            $('#address').val(item.attr('data-address'));
            $('#bed_category').val(item.attr('data-category-name'));
            $('#bed_category').attr('data-id',item.attr('data-category-id'));
            $('#from_bed').val(item.attr('data-list-name'));
            $('#from_bed').attr('data-id',item.attr('data-list-id'));
            $('#hotel-booking').val(item.attr('data-booking'));
            $('#hotel-booking').attr('data-id',item.attr('data-booking'));
            $('#check_in').val(item.attr('data-checkin'));
            $('#check_out').val(item.attr('data-checkout'));
        },

        function (targetInput) {
            $('#title').val('');
            $('#name').val('');
            $('#phone').val('');
            $('#email').val('');
            $('#address').val('');
            $('#bed_category').val('');
            $('#bed_category').removeAttr('data-id');
            $('#from_bed').val('');
            $('#from_bed').removeAttr('data-id');
            $('#hotel-booking').val('');
            $('#hotel-booking').removeAttr('data-id');
            $('#check_in').val('');
            $('#check_out').val('');
        }
    );



    // Update Guest Input Search
    SearchByInput(
        'hotel/users/guests/get', 

        function ($input) {
            return {
                guest: $input.val(),
            };
        }, 

        '#updateGuest', 

        '#update-guest',

        '#update-guest tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
            $('#updateTitle').val(item.attr('data-title'));
            $('#updateName').val(item.attr('data-name'));
            $('#updatePhone').val(item.attr('data-phone'));
            $('#updateEmail').val(item.attr('data-email'));
            $('#updateAddress').val(item.attr('data-address'));
            $('#updateBed_category').val(item.attr('data-category-name'));
            $('#updateBed_category').attr('data-id',item.attr('data-category-id'));
            $('#updateFrom_bed').val(item.attr('data-list-name'));
            $('#updateFrom_bed').attr('data-id',item.attr('data-list-id'));
            $('#updateHotel-booking').val(item.attr('data-booking'));
            $('#updateHotel-booking').attr('data-id',item.attr('data-booking'));
            $('#updateCheck_in').val(item.attr('data-checkin'));
            $('#updateCheck_out').val(item.attr('data-checkout'));
        },

        function (targetInput) {
            $('#updateTitle').val('');
            $('#updateName').val('');
            $('#updatePhone').val('');
            $('#updateEmail').val('');
            $('#updateAddress').val('');
            $('#updateBed_category').val('');
            $('#updateBed_category').removeAttr('data-id');
            $('#updateFrom_bed').val('');
            $('#updateFrom_bed').removeAttr('data-id');
            $('#updateHotel-booking').val('');
            $('#updateHotel-booking').removeAttr('data-id');
            $('#updateCheck_in').val('');
            $('#updateCheck_out').val('');
        }
    );
    
    
    
    /////////////// ------------------ Search All Guests And add value to input ajax part start ---------------- /////////////////////////////
    // All Guest Input Search
    SearchByInput(
        'hotel/users/guests/getall',  

        function ($input) {
            return {
                guest: $input.val(),
            };
        }, 

        '#guest-all', 

        '#guest-all-list',

        '#guest-all-list tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
            $('#title').val(item.attr('data-title'));
            $('#name').val(item.attr('data-name'));
            $('#phone').val(item.attr('data-phone'));
            $('#email').val(item.attr('data-email'));
            $('#gender').val(item.attr('data-gender'));
            $('#religion').val(item.attr('data-religion'));
            $('#nationality').val(item.attr('data-nationality'));
            $('#nid').val(item.attr('data-nid'));
            $('#passport').val(item.attr('data-passport'));
            $('#driving_license').val(item.attr('data-driving_license'));
            $('#address').val(item.attr('data-address'));
        },

        function (targetInput) {
            $('#title').val('');
            $('#name').val('');
            $('#phone').val('');
            $('#email').val('');
            $('#gender').val('');
            $('#religion').val('');
            $('#nationality').val('');
            $('#nid').val('');
            $('#passport').val('');
            $('#driving_license').val('');
            $('#address').val('');
        }
    );



    // Update Guest Input Search
    SearchByInput(
        'hotel/users/guests/get', 

        function ($input) {
            return {
                guest: $input.val(),
            };
        }, 

        '#updateGuest-all', 

        '#update-guest-all',

        '#update-guest-all tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
            $('#updateTitle').val(item.attr('data-title'));
            $('#updateName').val(item.attr('data-name'));
            $('#updatePhone').val(item.attr('data-phone'));
            $('#updateEmail').val(item.attr('data-email'));
            $('#updateGender').val(item.attr('data-gender'));
            $('#updateReligion').val(item.attr('data-religion'));
            $('#updateNationality').val(item.attr('data-nationality'));
            $('#updateNid').val(item.attr('data-nid'));
            $('#updatePassport').val(item.attr('data-passport'));
            $('#updateDriving_license').val(item.attr('data-driving_license'));
            $('#updateAddress').val(item.attr('data-address'));
        },

        function (targetInput) {
            $('#updateTitle').val('');
            $('#updateName').val('');
            $('#updatePhone').val('');
            $('#updateEmail').val('');
            $('#updateGender').val('');
            $('#updateReligion').val('');
            $('#updateNationality').val('');
            $('#updateNid').val(item.attr('data-nid'));
            $('#updatePassport').val(item.attr('data-passport'));
            $('#updateDriving_license').val(item.attr('data-driving_license'));
            $('#updateAddress').val('');
        }
    );





    /////////////// ------------------ Search Booking Id And add value to input ajax part start ---------------- /////////////////////////////
    // Booking Id Input Search
    SearchByInput(
        'hotel/booking/get',  

        function ($input) {
            return {
                booking_id: $input.val(),
                user_id: $('#guest').attr('data-id'),
            };
        }, 

        '#hotel-booking', 

        '#hotel-booking-list',

        '#hotel-booking-list li',

        undefined, 

        "",

        function (targetInput, item) {
            // $(targetInput).val(item.find('td:first').text());
            $('#check_in').val(item.attr('data-checkin'));
            $('#check_out').val(item.attr('data-checkout'));
            $('#bed_category').val(item.attr('data-category-name'));
            $('#bed_category').attr('data-id',item.attr('data-category-id'));
            $('#from_bed').val(item.attr('data-list-name'));
            $('#from_bed').attr('data-id',item.attr('data-list-id'));
        },

        function (targetInput) {
            $('#check_in').val('');
            $('#check_out').val('');
            $('#bed_category').val('');
            $('#bed_category').removeAttr('data-id');
            $('#from_bed').val('');
            $('#from_bed').removeAttr('data-id');
        }
    );


    
    // Update Booking Id Input Search
    SearchByInput(
        'hotel/booking/get', 

        function ($input) {
            return {
                booking_id: $input.val(),
                user_id: $('#updateGuest').attr('data-id'),
            };
        }, 

        '#updateHotel-booking', 

        '#update-hotel-booking',

        '#update-hotel-booking li',

        undefined, 

        "",

        function (targetInput, item) {
            // $(targetInput).val(item.find('td:first').text());
            $('#updateCheck_in').val(item.attr('data-checkin'));
            $('#updateCheck_out').val(item.attr('data-checkout'));
            $('#updateBed_category').val(item.attr('data-category-name'));
            $('#updateBed_category').attr('data-id',item.attr('data-category-id'));
            $('#updateFrom_bed').val(item.attr('data-list-name'));
            $('#updateFrom_bed').attr('data-id',item.attr('data-list-id'));
        },

        function (targetInput) {
            $('#updateCheck_in').val('');
            $('#updateCheck_out').val('');
            $('#updateBed_category').val('');
            $('#updateBed_category').removeAttr('data-id');
            $('#updateFrom_bed').val('');
            $('#updateFrom_bed').removeAttr('data-id');
        }
    );
});