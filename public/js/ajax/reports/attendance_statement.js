// function ShowDetailsReports(data, startIndex) {
//     let opening = formatNumber(data.opening.total_receive - data.opening.total_payment);
//     $('#opening').text(opening)

//     let tableRows = '';
//     let grandReceive = 0;
//     let grandPayment = 0;

//     if(!$.isEmptyObject(data)){
//         $.each(data, function(title, datas) {
//             if(title != "opening" && title != "status"){
//                 if (Array.isArray(datas) && datas.length > 0) {
//                     let totalReceive = 0;
//                     let totalPayment = 0;
                    
//                     tableRows += `
//                     <tr>
//                         <td colspan="3">
//                             <table class="show-table" style="margin:20px 0;">
//                                 <thead>
//                                     <caption class="sub-caption">${title} Transaction</caption>
//                                     <tr>
//                                         <th style="width: 5%;">SL:</th>
//                                         <th style="width: 10%;">Tran Id</th>
//                                         <th style="text-align: center; width:20%;">Groupe</th>
//                                         <th style="text-align: center; width:40%;">Product/Service</th>
//                                         <th style="text-align: center; width:12%;">Receive</th>
//                                         <th style="text-align: center; width:12%;">Payment</th>
//                                     </tr>
//                                 </thead>
//                                 <tbody>`;

//                                     $.each(datas, function(key, item) {
//                                         let lastGroupeId = null;
//                                         let lastTranId = null;
//                                         totalReceive += item.receive;
//                                         totalPayment += item.payment;

                                        

//                                         tableRows += `
//                                         <tr>
//                                             <td>${key +1}</td>
//                                             ${item.tran_id != lastTranId ? 
//                                                 `<td>${item.tran_id}</td>
//                                                 <td>${item.groupe.tran_groupe_name}</td>` 
//                                                 :   
//                                                 `<td></td>
//                                                 ${item.tran_groupe_id != lastGroupeId ? 
//                                                     `<td>${item.groupe.tran_groupe_name}</td>` 
//                                                     : 
//                                                     `<td></td>`
//                                                 }`
//                                             }
                                            
//                                             <td>${item.head.tran_head_name}</td>
//                                             <td style="text-align: right">${formatNumber(item.receive)}</td>
//                                             <td style="text-align: right">${formatNumber(item.payment)}</td>
//                                         </tr>`;

//                                         lastTranId = item.tran_id;
//                                         lastGroupeId = item.tran_groupe_id;
//                                     });

//                                     grandReceive += totalReceive;
//                                     grandPayment += totalPayment;

//                                 tableRows += `
//                                 </tbody>
//                                 <tfoot>
//                                     <tr>
//                                         <td colspan="4" style="text-align: right">Sub Total:</td>
//                                         <td style="text-align: right;">${formatNumber(totalReceive)}</td>
//                                         <td style="text-align: right;">${formatNumber(totalPayment)}</td>
//                                     </tr>     
//                                 </tfoot> 
//                             </table>
//                         </td>
//                     </tr>`;
//                 }
//             }
//         });

//         $('#grandReceive').text(formatNumber(grandReceive));
//         $('#grandPayment').text(formatNumber(grandPayment));
//         $('#closing').text(formatNumber(opening + grandReceive - grandPayment));

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         // $('.load-data .show-table tfoot').html('')
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         // $('.load-data .show-table tfoot').html('<tr><td colspan="5" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowDetailsReports(res) {
    // let opening = Number(res.data.opening.total_receive - res.data.opening.total_payment);

    // let tableRows = '';
    // let grandReceive = 0;
    // let grandPayment = 0;
    // let balance = opening;
    // console.log(opening);
    
    // if ($('#data-table thead #opening-row').length === 0) {
    //     $('#data-table thead').append(`<tr id="opening-row">
    //                                     <th style="text-align: right;" colspan="5">Opening Balance</th>
    //                                     <th></th>
    //                                     <th></th>
    //                                     <th style="text-align: right; width:10%;" id="opening">${formatNumber(opening)}</th>
    //                                 </tr>`);
    // }
    // else{
    //     $('#opening').html(formatNumber(opening))
    // }

    // if(!$.isEmptyObject(res.data)){
    //     $.each(res.data, function(title, datas) {
    //         if(title != "opening" && title != "status"){
    //             if (Array.isArray(datas) && datas.length > 0) {
    //                 let totalReceive = 0;
    //                 let totalPayment = 0;
    //                 let lastGroupeId = null;
    //                 let lastTranId = null;
                    
    //                 tableRows += `
    //                 <tr>
    //                     <td colspan="13" style="font-size:18px;padding: 8px 0 8px 4px;">
    //                         <strong>${title} Transaction </strong>
    //                     </td>    
    //                 <tr>`;

    //                 $.each(datas, function(key, item) {
                        
    //                     totalReceive += item.receive;
    //                     totalPayment += item.payment;
    //                     balance += item.receive;
    //                     balance -= item.payment;
                        

    //                     tableRows += `
    //                     <tr>
    //                         ${item.tran_id != lastTranId ? 
    //                             `<td>${item.tran_id}</td>
    //                             <td>${new Date(item.tran_date).toLocaleDateString('en-US', { day:'numeric', month: 'short', year: 'numeric' })}</td> 
    //                             <td>${item.tran_bank ? item.bank?.name: item.user?.user_name}</td> 
    //                             <td>${item.groupe?.tran_groupe_name}</td>` 
    //                             // <td>${item.groupe.tran_groupe_name}</td>` 
    //                             :  
    //                             `<td></td>
    //                             <td></td>
    //                             <td></td>
    //                             ${item.tran_groupe_id != lastGroupeId ? 
    //                                 `<td>${item.groupe?.tran_groupe_name}</td>` 
    //                                 // `<td>${item.groupe.tran_groupe_name}</td>` 
    //                                 : 
    //                                 `<td></td>`
    //                             }`
    //                         }
                            
    //                         <td>${item.head?.tran_head_name}</td>
    //                         <td style="text-align: right">${formatNumber(item.receive)}</td>
    //                         <td style="text-align: right">${formatNumber(item.payment)}</td>
    //                         <td style="text-align: right">${formatNumber(balance)}</td>
    //                     </tr>`;

    //                     lastTranId = item.tran_id;
    //                     lastGroupeId = item.tran_groupe_id;
    //                 });

    //                 grandReceive += totalReceive;
    //                 grandPayment += totalPayment;

    //                 tableRows += `
    //                 <tr>
    //                     <td colspan="5">Sub Total:</td>
    //                     <td style="text-align: right;">${formatNumber(totalReceive)}</td>
    //                     <td style="text-align: right;">${formatNumber(totalPayment)}</td>
    //                     <td style="text-align: right;">${formatNumber(balance)}</td>
    //                 </tr>`;

    //             }
    //         }
    //     });
    //     $('#data-table tbody').html(tableRows);
    // }

    // $('#data-table tfoot').html(
    //     `<tr>
    //         <td style="text-align: right;" colspan="5">Grand Total:</td>
    //         <td style="text-align: right;width:10%;">${formatNumber(Number(grandReceive))}</td>
    //         <td style="text-align: right;width:10%;">${formatNumber(Number(grandPayment))}</td>
    //         <td style="width:10%;"></td>
    //     </tr>
    //     <tr>
    //         <td style="text-align: right;" colspan="5">Closing Balance</td>
    //         <td></td>
    //         <td></td>
    //         <td style="text-align: right;">${formatNumber(Number(opening + grandReceive - grandPayment))}</td>
    //     </tr>`
    // );
    

    
}

$(document).ready(function () {
    UpdateUrl('/api/reports/attendance_statement/print', { date: $("#eventDate").val(), events: $('#events').val(), qt_status: $('#qt_status').val(), gender: $('#gender').val() });
    
    // Render The Table Heads
    // renderTableHead([
    //     { label: 'Sl' },
    //     { label: 'Gender' },
    //     { label: 'Qt Status' },
    //     { label: 'Reg No' },
    //     { label: 'Name' },
    //     { label: 'Branch' },
    //     { label: 'Phone' },
    //     { label: 'Date' },
    // ]);


    // // Load Data on Hard Reload
    // ReloadData('report/account/details', ShowDetailsReports);


    // // Search By Date
    // SearchByDateAjax('report/account/details/search', ShowDetailsReports, {type: $("#typeOption").val()});


    // // Search by Type
    // SearchBySelect('report/account/details/search', ShowDetailsReports, "#typeOption", {type: $("#typeOption").val()});


    // Get Trantype
    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'name')
    });


    // Events Change 
    $(document).off('change','#events').on('change','#events', function (e) {
        e.preventDefault();
        let search = $(this).val();
        $.ajax({
            url: `${apiUrl}/admin/event_schedule/get/date`,
            data: {search},
            success: function (res) {
                CreateSelectOptions('#eventDate', "Select Event Date", res.data, 'date', 'date');
            }
        });
    })
    
    
    
    // Events Change 
    $(document).off('change','#eventDate, #gender, #qt_status, #events').on('change','#eventDate, #gender, #qt_status, #events', function (e) {
        e.preventDefault();
        let date = $("#eventDate").val();
        let events = $('#events').val();
        let texts = $('#events option:selected').text();
        let gender = $('#gender').val();
        let qt_status = $('#qt_status').val();
        let lastGender = null;
        let lastQtStatus = null;
        let groupCount = 0;
        let table = "";

        requestMethod = 'POST';

        $("#attend").html(`Attendence on `);
        $("#name").html(`Event `);

        $.ajax({
            url: `${apiUrl}/reports/attendance_statement`,
            method: 'POST',
            data: {events, date, gender, qt_status},
            success: function (res) {
                $("#attend").html(`Attendence on ${date}`);
                $("#name").html(`Event ${texts}`);

                UpdateUrl('/api/reports/attendance_statement/print', { date: $("#eventDate").val(), events: $('#events').val(), qt_status: $('#qt_status').val(), gender: $('#gender').val() });
                
                if(res.data){
                    res.data.map((item, key) => { 
                        const p = item.participants[0];

                        
                        if((p.gender !== lastGender) || (p.qt_status !== lastQtStatus)){
                            if (key !== 0) {
                                table += `</tbody></table><br>`; // Close previous table
                            }


                            table += `
                                <table class="data-table" style="border-collapse: collapse;width: 100%;overflow-x: auto;">
                                    <caption style="background: #f2f2f25e;color:black;border: 1px solid #80808080;"><strong>${p.gender} ( ${p.qt_status} )</strong></caption>
                                    <thead>
                                        <tr style="background:none;">
                                            <th>Sl</th>
                                            <th>Reg No</th>
                                            <th>Name</th>
                                            <th>Branch</th>
                                            <th>Phone</th>
                                            <th style="text-align: center;">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            `;
                            
                            groupCount = 0;
                        }

                        groupCount ++

                        table += `<tr>
                                    <td>${ groupCount }</td>
                                    <td>${ p.reg_no }</td>
                                    <td>${ p.name }</td>
                                    <td>${ p.branchs.short }</td>
                                    <td>${ p.phone }</td>
                                    <td style="text-align: center;">${ item.date }</td>
                                </tr>`;

                        
                        lastGender = p.gender;
                        lastQtStatus = p.qt_status;
                    });

                    $('#tables').html(table)
                }
                else{
                    $('#tables').html('')
                }
                
                
            }
        });
    })
});