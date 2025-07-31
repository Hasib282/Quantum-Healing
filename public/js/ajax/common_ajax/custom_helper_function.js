//////////////////// -------------------- Format Numbers Into comma-separated value -------------------- ////////////////////
function formatNumber(value, locale = 'en-US', minimumFractionDigits = 0, maximumFractionDigits = 0) {
    const formatter = new Intl.NumberFormat(locale, {
        minimumFractionDigits: minimumFractionDigits,
        maximumFractionDigits: maximumFractionDigits,
    });
    return formatter.format(value);
}


//////////////////// -------------------- Get the Query Parameters From the Current URL -------------------- ////////////////////
function GetQueryParams() {
    let urlParams = new URLSearchParams(window.location.search);
    let queryParams = Object.fromEntries(urlParams.entries());
    return queryParams;
}; // End Function





//////////////////// -------------------- Get the Page Number From the Current URL -------------------- ////////////////////
function GetCurrentPageFromURL() {
    const params = new URLSearchParams(window.location.search);
    return params.get('page') ? parseInt(params.get('page')) : 1;
}; // End Function





//////////////////// -------------------- Check If The Current Page is The Last Page -------------------- ////////////////////
function CheckIfLastPage(callback) {
    let baseURL =  location.href.replace(/^(http[s]?:\/\/[^/]+)/, apiUrl);
    $.ajax({
        url: baseURL,
        method: 'GET',
        success: function (response) {
            if(response.data && response.data.current_page && response.data.last_page){
                callback(response.data.current_page > response.data.last_page);
            }
            else {
                callback(false);
            }
        },
        error: function () {
            callback(false);
        }
    });
}; // End Function





//////////////////// -------------------- Update URL With Query Parameters -------------------- ////////////////////
// function UpdateUrl(url, queryParams) {
//     let baseURL = url.replace(/^(http[s]?:\/\/[^/]+)(\/api)/, window.location.origin);
//     let separator = baseURL.includes('?') ? '&' : '?';
//     let newUrl = (!$.isEmptyObject(queryParams) && queryParams != undefined ) ? `${baseURL}${separator}${$.param(queryParams)}` : baseURL;
//     history.pushState(null, '', newUrl);

//     // Update the Print Button href
//     if($('#print').length){
//         let urlObj = new URL(newUrl);

        
//         urlObj.searchParams.delete('page'); // remove 'page' query parameter

//         let pathname = urlObj.pathname;
//         // Check if the pathname ends with '/search'
//         if (pathname.endsWith('/search')) {
//             pathname = pathname.replace(/\/search$/, '/print'); // Replace '/search' with '/print'
//         } else {
//             pathname = pathname.replace(/\/$/, '') + '/print'; // Append '/print' to the pathname
//         }

//         // Update #print href
//         $('#print').attr('href', `${urlObj.origin}/api${pathname}${urlObj.search}`);
//     }
// }; // End Function

function UpdateUrl(url, queryParams) {
    let newUrl = `${url}?${$.param(queryParams)}`;
    let urlObj = new URL(newUrl, window.location.origin);
    console.log('hello');
    
    // Update #print href
    $('#print').attr('href', `${urlObj}`);
}; // End Function



//////////////////// -------------------- Create Select Options Dynamically -------------------- ////////////////////
// Helper function to get nested property like 'event.name'
function getNestedValue(obj, path) {
    return path.split('.').reduce((o, key) => (o ? o[key] : ''), obj);
}



//////////////////// -------------------- Create Select Options Dynamically -------------------- ////////////////////
// For Creating Select Options Dynamically
function CreateSelectOptions(id, defaultText, data, fieldName, Value = null) {
    let selectElement = $(id);
    selectElement.empty();
    selectElement.append(`<option value="">${defaultText}</option>`);
    data.forEach(function(item) {
        let value = Value ? getNestedValue(item, Value) : item.id;
        let text = getNestedValue(item, fieldName);
        selectElement.append(`<option value="${value}">${text}</option>`);
        // selectElement.append(`<option value="${item.id}" >${item[fieldName]}</option>`);
    });
}; // End Method




//////////////////// -------------------- Calculate Age From Date of Birth -------------------- ////////////////////
// For Calculating Age From Date Of Birth
function calculateAge(date) {
    const dob = new Date(date);
    const today = new Date();

    let years = today.getFullYear() - dob.getFullYear();
    let months = today.getMonth() - dob.getMonth();
    let days = today.getDate() - dob.getDate();

    // Adjust if days are negative
    if (days < 0) {
        months--;
        const prevMonth = new Date(today.getFullYear(), today.getMonth(), 0);
        days += prevMonth.getDate();
    }

    // Adjust if months are negative
    if (months < 0) {
        years--;
        months += 12;
    }

    return { years, months, days };
}
