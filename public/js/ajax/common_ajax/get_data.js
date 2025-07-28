// // Fetch Data From Api
// function FetchListData(link, getData, divId, variable, reset = false) {
//     console.log(variable);
    
//     if (isLoading || !hasMore) return;
//     isLoading = true;
    
//     if (reset) {
//         $(divId).html('');
//         currentPage = 1;
//         hasMore = true;
//     }
    
//     const data = getData(currentPage);
    
//     console.log(data);
//     $.ajax({
//         url: `${apiUrl}/${link}`,
//         method: 'GET',
//         data: data,
//         success: function (res) {
//             $(divId).append(res.list);

//             // hasMore = res.hasMore;
//             // if (hasMore) currentPage++;
            
//         },
//         complete: function () {
//             // isLoading = false;
//             // console.log(currentPage);
//         }
//     });
// } // End FetchData Function





// Get Input List Data 
function GetInputList(link, data = {}, targetList) {
    $.ajax({
        url: `${apiUrl}/${link}`,
        data: data,
        success: function (res) {
            $(targetList).html(res);
        }
    });
}


// Get Select Input Data 
function GetSelectInputList(link, selectInput, data = {}) {
    $.ajax({
        url: `${apiUrl}/${link}`,
        data: data,
        success: function (res) {
            if(typeof selectInput === 'function'){
                selectInput(res);
            }
        }
    });
}


// Get Transaction With
function GetTransactionWith(type, method, user = null, AdditionalEvent= null) {
    $.ajax({
        url: `${apiUrl}/admin/tranwith/get`,
        method: 'GET',
        data: { type, method, user },
        success: function (res) {
            if (res.status) {
                if(AdditionalEvent == 'Ok'){
                    CreateSelectOptions('#type', 'Select User Type', res.data, 'tran_with_name');
                    CreateSelectOptions('#updateType', 'Select User Type', res.data, 'tran_with_name');
                }
                else{
                    $("#within").html('');
                    $.each(res.data, function (key, item) {
                        $("#within").append(`<input type="checkbox" class="with-checkbox" name="with" value="${item.id}" checked>`);
                    });
                }
            }
        }
    });
}



// Get Transaction Groupe Select Options
function GetTransactionGroupe(type = null, method = null, AdditionalEvent = null) {
    $.ajax({
        url: `${apiUrl}/admin/trangroupes/get`,
        method: 'GET',
        data: { type, method },
        success: function (res) {
            if (res.status) {
                if(AdditionalEvent == 'Ok'){
                    CreateSelectOptions('#groupe', 'Select Groupe', res.data, 'tran_groupe_name')
                    CreateSelectOptions('#updateGroupe', 'Select Groupe', res.data, 'tran_groupe_name')
                }
                else{
                    let groupein = "";
                    let updategroupein = "";

                    // Groupin chedckbox
                    $.each(res.data, function(key, groupe) {
                        groupein += `<input type="checkbox" name="groupe" class="groupe-checkbox" value="${groupe.id}" checked>`
                    });
                    $('#groupein').html(groupein);


                    // Update Groupin chedckbox
                    $.each(res.data, function(key, groupe) {
                        updategroupein += `<input type="checkbox" name="groupe" class="updategroupe-checkbox"
                            value="${groupe.id}" checked>`
                    });
                    $('#updategroupein').html(updategroupein);
                }
            }
        }
    });
}











// Get Due Payment list by User Id
function getDueListByUserId(id, grid) {
    let tableRows = '';
    $.ajax({
        url: `${apiUrl}/transaction/party/get/due`,
        method: 'GET',
        data: { id:id },
        success: function (res) {
            if(res.status){
                $.each(res.data, function(key, item) {
                    tableRows += `
                    <tr>
                        <td>${key + 1}</td>
                        <td>${item.tran_id}</td>
                        <td style="text-align: right">${item.bill_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.</td>
                        <td style="text-align: right">${item.due.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.</td>
                    </tr>`
                });

                $(grid).html(tableRows);



                let transactions = res.data ?? [];

                // Calculate total amount or show a message if no transactions
                let totalAmount = transactions.length > 0 ? transactions.reduce((sum, transaction) => sum + transaction.due, 0) : null;

                $('.due-grid tfoot').html(`
                    <tr>
                        <td colspan="4" style="text-align:${totalAmount !== null ? 'right' : 'center'};">
                            ${totalAmount !== null ? `Total Due: ${totalAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.` : 'No transactions due'}
                        </td>
                    </tr>`
                );
            }
        }
    });
}




//Get Payroll By User Id
function getPayrollByUserId(id, grid) {
    let tableRows = '';
    $.ajax({
        url: `${apiUrl}/hr/payroll/get`,
        method: 'GET',
        data: { id },
        success: function (res) {
            if(res.status){
                $.each(res.data, function(key, item) {
                    tableRows += `
                    <tr>
                        <td>${key+1}</td>
                        <td>${item.head.tran_head_name}</td>
                        <td>${item.amount}</td>
                        ${
                            item.date ? `
                            <td>${String(new Date(item.date).getMonth() + 1).padStart(2, '0')}</td>
                            <td>${new Date(item.date).getFullYear()}</td>`
                            :
                            `<td></td>
                            <td></td>`
                        }
                    </tr>`
                });

                $(grid).html(tableRows);
            }
        }
    });
}





