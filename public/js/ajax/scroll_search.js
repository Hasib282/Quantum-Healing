function FixedScrollSearch(link, getData, inputId, divId, rowId, tableData = undefined, targetTable="", AdditionalEvent = undefined, RemoveData = undefined) {
    let keyDownProcessed = false;
    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;

    // Input Box Keydown Event Start
    $(document).off('keydown', inputId).on('keydown', inputId, function (e) {
        keyDownProcessed = true;
        setTimeout(() => {
            currentPage = 1;
            hasMore = true;
            KeyDown(e);
            // $(targetTable).html('');
        }, 0);
    }); // Input Box Keydown Event End



    // Input Box Focus Event Start
    $(document).off('focus', inputId).on('focus', inputId, function (e) {
        currentPage = 1;
        hasMore = true;

        let id = $(this).attr('data-id');
        if(id == undefined) {
            FetchData(true);
        }
        else{
            if (typeof tableData === "function") {
                tableData(id);
            }
        }
    }); // Input Box Focus Event End



    // // Input Box Focus Out Event Start
    // $(document).off('focusout').on('focusout', function (e) {
    //     let id = $(this).attr('data-id');
    //     if(id == undefined){
    //         setTimeout(() => {
    //             const activeEl = document.activeElement;
    //             if (!$(activeEl).attr('tabindex')) {
    //                 $(divId).html('');
    //             }
    //         }, 10);
    //     }
    // }); // Input Box Focus Out Event End



    // Infinite scroll
    $(divId).off('scroll').on('scroll', function (e) {
        if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight - 5) {
            FetchData();
        }
    });



    // RowId Keyup Keypdown Event Start
    $(document).off('keydown', rowId).on('keydown', rowId, function (e) {
        e.preventDefault();
        let key = e.key;
        let list = $(`${rowId}`);
        let focused = $(`${rowId}:focus`);
        let nextIndex, prevIndex;

        if (keyDownProcessed) {       // Skip the list keyup event if input keydown was processed
            keyDownProcessed = false; // Reset the flag
            return;
        }

        if (key === 'ArrowDown') {
            nextIndex = (focused.index() + 1) % list.length;
            UpdateInput(list, nextIndex);
        } 
        else if (key === 'ArrowUp') {
            prevIndex = (focused.index() - 1) % list.length;
            UpdateInput(list, prevIndex);
        }
        else if (key === 'Enter') {
            $(divId).html('');
            $(inputId).focus();
        }
    }); // RowId Keyup Keypdown Event Start



    // Company List Click Event
    // $(document).off('click', rowId).on('click', rowId, function () {
    //     let value = $(this).text();
    //     let id = $(this).data('id');
        
    //     // $(inputId).val(value);
    //     $(inputId).attr('data-id', id);
    //     $(divId).html('');

    //     // Additional Events If Needed
    //     if (typeof AdditionalEvent === "function") {
    //         AdditionalEvent(inputId, $(this));
    //     }
        
    //     $(inputId).focus();
    // });


    
    // Keydown Event Function Start
    function KeyDown(e){
        let key = e.key;
        let list = $(`${rowId}`);
        
        if (key === 'Enter') { // Enter Key
            e.preventDefault();
        }
        else if (key === 'Tab') { // Tab key
            $(divId).html('');
        }
        else if ((key.length === 1 && key.match(/^[a-zA-Z0-9]$/)) || key === "Backspace" || key === 'Space'){
            $(inputId).removeAttr('data-id');

            // Remove Input Data Events If Needed
            if (typeof RemoveData === "function") {
                RemoveData(inputId);
            }
            
            if (timeoutId) {
                clearTimeout(timeoutId);
            }

            // Set a new timeout for the GetInputList call
            timeoutId = setTimeout(() => {
                FetchData(true);
            }, 800);
        }
        if (list.length > 0) {
            if (key === 'ArrowDown') {
                e.preventDefault();
                UpdateInput(list, 0);
            } 
            else if (key === 'ArrowUp') {
                e.preventDefault();
                UpdateInput(list, list.length - 1);
            }
        }
    } // Keydown Event Function End


    // Update The Input Value When Focusing on Lists
    function UpdateInput(list, index) {
        let item = list.eq(index);
        item.focus();

        // $(inputId).val(item.text());
        // $(inputId).attr("data-id", item.data('id'));
        
        // Additional Events If Needed
        if (typeof AdditionalEvent === "function") {
            AdditionalEvent(inputId, item);
        }
    } // End UpdateInput Function



    // Fetch Data From Api
    function FetchData(reset = false) {
        if (isLoading || !hasMore) return;
        isLoading = true;
        
        if (reset) {
            $(divId).html('');
            currentPage = 1;
            hasMore = true;
        }
        
        const data = getData(currentPage);
        
        console.log(data);
        $.ajax({
            url: `${apiUrl}/${link}`,
            method: 'GET',
            data: data,
            success: function (res) {
                $(divId).append(res.list);

                hasMore = res.hasMore;
                if (hasMore) currentPage++;
                
            },
            complete: function () {
                isLoading = false;
                console.log(currentPage);
            }
        });
    } // End FetchData Function
}

let timeoutId = null;

function ScrollSearchByInput(link, getData, inputId, divId, rowId, tableData = undefined, targetTable="", AdditionalEvent = undefined, RemoveData = undefined){
    let keyDownProcessed = false;
    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;

    // Input Box Keydown Event Start
    $(document).off('keydown', inputId).on('keydown', inputId, function (e) {
        keyDownProcessed = true;
        setTimeout(() => {
            currentPage = 1;
            hasMore = true;
            KeyDown(e);
            // $(targetTable).html('');
        }, 0);
    }); // Input Box Keydown Event End



    // Input Box Focus Event Start
    $(document).off('focus', inputId).on('focus', inputId, function (e) {
        currentPage = 1;
        hasMore = true;

        let id = $(this).attr('data-id');
        if(id == undefined) {
            FetchData(true);
        }
        else{
            if (typeof tableData === "function") {
                tableData(id);
            }
        }
    }); // Input Box Focus Event End



    // Input Box Focus Out Event Start
    $(document).off('focusout').on('focusout', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            setTimeout(() => {
                const activeEl = document.activeElement;
                if (!$(activeEl).attr('tabindex')) {
                    $(divId).html('');
                }
            }, 10);
        }
    }); // Input Box Focus Out Event End



    // Infinite scroll
    $(divId).off('scroll').on('scroll', function (e) {
        
        if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight - 5) {
            console.log(currentPage);
            FetchData();
        }
    });



    // RowId Keyup Keypdown Event Start
    $(document).off('keydown', rowId).on('keydown', rowId, function (e) {
        e.preventDefault();
        let key = e.key;
        let list = $(`${rowId}`);
        let focused = $(`${rowId}:focus`);
        let nextIndex, prevIndex;

        if (keyDownProcessed) {       // Skip the list keyup event if input keydown was processed
            keyDownProcessed = false; // Reset the flag
            return;
        }

        if (key === 'ArrowDown') {
            nextIndex = (focused.index() + 1) % list.length;
            UpdateInput(list, nextIndex);
        } 
        else if (key === 'ArrowUp') {
            prevIndex = (focused.index() - 1) % list.length;
            UpdateInput(list, prevIndex);
        }
        else if (key === 'Enter') {
            $(divId).html('');
            $(inputId).focus();
        }
    }); // RowId Keyup Keypdown Event Start



    // Row List Click Event
    $(document).off('click', rowId).on('click', rowId, function () {
        let value = $(this).text();
        let id = $(this).data('id');
        
        $(inputId).val(value);
        $(inputId).attr('data-id', id);
        $(divId).html('');

        // Additional Events If Needed
        if (typeof AdditionalEvent === "function") {
            AdditionalEvent(inputId, $(this));
        }
        
        $(inputId).focus();
    });


    
    // Keydown Event Function Start
    function KeyDown(e){
        let key = e.key;
        let list = $(`${rowId}`);
        
        if (key === 'Enter') { // Enter Key
            e.preventDefault();
        }
        else if (key === 'Tab') { // Tab key
            $(divId).html('');
        }
        else if ((key.length === 1 && key.match(/^[a-zA-Z0-9]$/)) || key === "Backspace" || key === 'Space'){
            $(inputId).removeAttr('data-id');

            // Remove Input Data Events If Needed
            if (typeof RemoveData === "function") {
                RemoveData(inputId);
            }
            
            if (timeoutId) {
                clearTimeout(timeoutId);
            }

            // Set a new timeout for the GetInputList call
            timeoutId = setTimeout(() => {
                FetchData(true);
            }, 800);
        }
        if (list.length > 0) {
            if (key === 'ArrowDown') {
                e.preventDefault();
                UpdateInput(list, 0);
            } 
            else if (key === 'ArrowUp') {
                e.preventDefault();
                UpdateInput(list, list.length - 1);
            }
        }
    } // Keydown Event Function End


    // Update The Input Value When Focusing on Lists
    function UpdateInput(list, index) {
        let item = list.eq(index);
        item.focus();

        $(inputId).val(item.text());
        $(inputId).attr("data-id", item.data('id'));
        
        // Additional Events If Needed
        if (typeof AdditionalEvent === "function") {
            AdditionalEvent(inputId, item);
        }
    } // End UpdateInput Function



    // Fetch Data From Api
    function FetchData(reset = false) {
        if (isLoading || !hasMore) return;
        isLoading = true;
        
        if (reset) {
            $(divId).html('');
            currentPage = 1;
            hasMore = true;
        }
        
        const data = getData(currentPage);
        
        $.ajax({
            url: `${apiUrl}/${link}`,
            method: 'GET',
            data: data,
            success: function (res) {
                $(divId).append(res.list);

                hasMore = res.hasMore;
                if (hasMore) currentPage++;
                
            },
            complete: function () {
                isLoading = false;
            }
        });
    } // End FetchData Function
}





$(document).ready(function () {
    /////////////// ------------------ Search Branch by name and add value to input ajax part start ---------------- /////////////////////////////
    // Branch Scroll Input Search
    ScrollSearchByInput(
        'admin/branches/get', 

        function (currentPage) {
            return {
                search: $('#branch').val(),
                page: currentPage
            };
        }, 

        '#branch', 

        '#branch-list',

        '#branch-list li',
    );



    // Update Branch Scroll Input Search
    ScrollSearchByInput(
        'admin/branches/get', 

        function (currentPage) {
            return {
                search: $('#updateBranch').val(),
                page: currentPage
            };
        }, 

        '#updateBranch', 

        '#update-branch',

        '#update-branch li',
    );
});






// let currentPage = 1;
// let isLoading = false;
// let hasMore = true;
// let search = '';

// function FetchData(reset = false) {
//     if (isLoading || !hasMore) return;
//     isLoading = true;

//     $.ajax({
//         url: '/user_info/get/participants',
//         method: 'GET',
//         data: {
//             search: search,
//             page: currentPage
//         },
//         success: function (res) {
//             if (reset) {
//                 $('#user-list').html('');
//                 currentPage = 1;
//                 hasMore = true;
//             }

//             $('#user-list').append(res.list);

//             hasMore = res.hasMore;
//             if (hasMore) currentPage++;
//             // $('#user-list').show();
//         },
//         complete: function () {
//             isLoading = false;
//         }
//     });
// }



// $(document).ready(function () {
//     ScrollSearch('/user_info/get/participants','#search', '#user-list')
    // // On input focus or keyup
    // $(document).on('focus keyup','#search', function (e) {
    //     search = $(this).val().trim();
    //     currentPage = 1;
    //     hasMore = true;
    //     fetchUsers(true); // reset previous
    // });


    // // Infinite scroll
    // $(document).on('scroll','#user-list', function (e) {
    //     if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight - 5) {
    //         fetchUsers(); // fetch next page
    //     }
    // });

    // // Optional: Click to select
    // $(document).on('click', '.user-item', function () {
    //     const name = $(this).text();
    //     const userId = $(this).data('id');
    //     $('#user-search').val(name);
    //     $('#user-dropdown').hide();
    //     console.log('Selected User ID:', userId);
    // });

    // // Hide dropdown on outside click
    // $(document).on('click', function (e) {
    //     if (!$(e.target).closest('#user-search, #user-dropdown').length) {
    //         $('#user-dropdown').hide();
    //     }
    // });
// });