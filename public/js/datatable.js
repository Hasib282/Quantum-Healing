let tableInstance = null;
class GenerateTable {
    constructor({tableId , data, tbody, actions, balance=0,rowsPerPage = 15}) {
        this.table = document.querySelector(tableId); // Select Table
        this.data = data; // Original Data
        this.filteredData = [...data]; // Copy of Original data
        this.currentPage = 1;
        this.rowsPerPage = rowsPerPage;
        this.sortKey = null;
        this.sortOrder = 'asc';
        this.tbody = tbody;
        this.actions = actions;
        this.balance = balance;
        this.currBalance = 0;
        this.init();
    }


    init() {
        this.renderTableBody();
        this.bindEvents();
    }


    // Bind Events Related To the Genarated Tables
    bindEvents() {
        // Global Search Event
        const globalSearch = document.getElementById('globalSearch');
        if (globalSearch) {
            globalSearch.addEventListener('keyup', (e) => this.globalSearch(e.target.value));
        }
    

        // Column Filter
        const colFilters = document.querySelectorAll('.col-filter');
        colFilters.forEach(input => {
            input.addEventListener('keyup', () => this.columnSearch());
            input.addEventListener('change', () => this.columnSearch());
        });
    

        // Pagination Event Binding
        document.addEventListener('click', (e) => {
            if (e.target.matches('a.page-link') && e.target.dataset.page) {
                e.preventDefault();
                this.currentPage = +e.target.dataset.page;
                this.renderTableBody();
            }
        });

        // $(document).off('click', 'a.page-link').on('click', 'a.page-link', (e) => {
        //     e.preventDefault();
        //     this.currentPage = +e.target.dataset.page;
        //     this.renderTableBody();
        // });



        // const tableHeaders = this.table.querySelectorAll('thead th[data-key]');
        // tableHeaders.forEach(th => {
        //     th.addEventListener('click', (e) => {
        //         const key = e.currentTarget.dataset.key;
        //         this.sortData(key);
        //     });
        // });
    
        const exportBtn = document.getElementById('exportCSV');
        if (exportBtn) {
            exportBtn.addEventListener('click', () => this.exportCSV());
        }


        const perPage = document.getElementById('rowsPerPage');
        if (perPage) {
            perPage.addEventListener('change', (e) => {
                this.currentPage = 1;
                this.rowsPerPage = +e.target.value;

                this.renderTableBody();
            });
        }
    
        // const selectAll = document.getElementById('selectAll');
        // if (selectAll) {
        //     selectAll.addEventListener('change', (e) => {
        //     const isChecked = e.target.checked;
        //     const checkboxes = this.table.querySelectorAll('tbody input[type="checkbox"]');
        //     checkboxes.forEach(cb => cb.checked = isChecked);
        //     });
        // }
    }


    // Global Search Method
    globalSearch(query) {
        this.filteredData = this.data.filter(rows =>
            Object.values(rows).some(val =>
                (val ?? '').toString().toLowerCase().includes(query.toLowerCase())
            )
        );

        this.currentPage = 1;
        
        this.renderTableBody();
    }


    // Column Search Method
    columnSearch() {
        let filters = {};

        document.querySelectorAll('.col-filter').forEach(input => {
            filters[input.dataset.key] = input.value.toLowerCase(); // store the filter keys
        });

        this.filteredData = this.data.filter(row => {
            return Object.keys(filters).every(key => {
                let value = key.split('.').reduce((obj, k) => obj?.[k], row);
                // Special case: user_name / bank.name based on tran_bank
                if (key === 'user.user_name') {
                    value = row.tran_bank ? row.bank?.name : row.user?.user_name;
                }
                return (value ?? '').toString().toLowerCase().includes((filters[key] ?? '').toLowerCase());
            });
        });

        this.currentPage = 1;

        this.renderTableBody();
    }


    // Sort Data Column Wise
    // sortData(key) {
    //     console.log(key);
        
    //   this.sortOrder = (this.sortKey === key && this.sortOrder === 'asc') ? 'desc' : 'asc';
    //   this.sortKey = key;
    //   this.filteredData.sort((a, b) => {
    //     const valA = a[key].toString();
    //     const valB = b[key].toString();
    //     return this.sortOrder === 'asc'
    //       ? valA.localeCompare(valB)
    //       : valB.localeCompare(valA);
    //   });
    //   this.renderTableBody();
    // }


    // Export To CSV File
    exportCSV() {
        if (!this.filteredData.length) return;

        const escapeCSV = (value) => {
            const str = value == null ? '' : value.toString();
            return `"${str.replace(/"/g, '""')}"`;
        };


        const headers = Object.keys(this.filteredData[0]);
        let csv = headers.join(',') + '\n';

        this.filteredData.forEach(row => {
            csv += headers.map(h => escapeCSV(row[h])).join(',') + '\n';
        });
        
        // Create csv File and Download It
        const blob = new Blob([csv], { type: 'text/csv' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'data.csv';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }


    
    // Create the tbody Rows 
    renderTableBody() {
        const tbody = this.table.querySelector('tbody');
        const pagination = document.getElementById('paginate');
        const startIndex = (this.currentPage - 1) * this.rowsPerPage;
        const datas = this.filteredData.slice(startIndex, startIndex + this.rowsPerPage);

        tbody.innerHTML = '';
        pagination.innerHTML = '';

        // Assigning Opening Balance into Current Balanace
        this.currBalance = this.balance;

        if (datas.length === 0) {
            this.renderTableFooter([]);
            tbody.innerHTML = '<tr><td colspan="15" style="text-align:center;">No Data Found</td></tr>';
            return;
        }

        // let lastTranId = null;
        // let lastGroupeId = null;

        // Extracting the Rows one By one and create colums
        tbody.innerHTML = datas.map((row, i) => { 
            const columns = this.tbody.filter(col => !(typeof col === 'object' && col.grid === true)).map(col => { // Create Colums acording to tbody values
                const data = typeof col === 'string' ? { key: col, type: 'text' } : col;
                let value = data.key.split('.').reduce((obj, key) => obj?.[key], row);
                const type = data.type || 'text';

                // Special case: user_name / bank.name based on tran_bank
                if (data.key === 'user.user_name') {
                    value = row.tran_type == 4 ? row.bank?.name : row.user?.user_name;
                }
                
                // Conditional logic for tran_id
                // if (data.key === 'tran_id' && row.tran_id === lastTranId) return `<td></td>`;
                // if (data.key === 'tran_date' && row.tran_id === lastTranId) return `<td></td>`;
                
                switch (type) {
                    case 'number':
                        return `<td style="text-align:right;">${Number(value).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>`;
                    
                    case 'calculate':
                        let calcValue = this.evaluateExpression(data.expration, row);
                        // calculate the balance 
                        if(data.key === 'balance') {
                            calcValue = this.currBalance + calcValue; 
                            this.currBalance = calcValue;
                        }
                        return `<td style="text-align:right;">${Number(calcValue).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>`;
    
                    case 'image':
                        return `<td><img src="${apiUrl.replace('/api', '')}/storage/${value ? value : 'male.png'}?${new Date().getTime()}" alt="Image" height="30px" width="30px"></td>`
    
                    case 'date':
                        if (!value) return `<td></td>`;
                        const date = new Date(value);
                        return `<td style="text-align:center;">${date.toLocaleDateString('en-US', { day:'numeric', month: 'short', year: 'numeric' })}</td>`;
                    
                    case 'month':
                        if (!value) return `<td></td>`;
                        const month = new Date(value);
                        return `<td>${month.toLocaleDateString('en-US', { month: 'long' })}</td>`;
                    
                    case 'year':
                        if (!value) return `<td></td>`;
                        const year = new Date(value);
                        return `<td>${year.toLocaleDateString('en-US', { year: 'numeric' })}</td>`;
        
                    case 'status':
                        const checked = value ? 'checked' : '';
                        return `<td>
                            <label class="switch">
                                <input type="checkbox" ${checked} data-id="${row.id}" class="status-toggle">
                                <span class="slider round"></span>
                            </label>
                        </td>`;

                    case 'status-show':
                        const status = data.options.find(option => option.id == value);
                        return `<td><strong>${status ? status.name : 'Available'}</strong></td>`;
                    
                    case 'multi-data':
                        let permissionNames = '';
            
                        value.map((item, i) => { 
                            permissionNames += item.name+',' ;
                        });
                        return `<td class="truncate-text">${permissionNames}</td>`;

                    // case 'conditional':
                    //     // let permissionNames = '';
            
                    //     // value.map((item, i) => { 
                    //     //     permissionNames += item.name+',' ;
                    //     // });
                    //     return `<td>${permissionNames}</td>`;

                    default:
                        return `<td>${value ?? ''}</td>`;
                }
            }).join('');
            
            // lastTranId = row.tran_id;
            // lastGroupeId = row.tran_groupe_id;

            const hasGrid = this.tbody.some(col => typeof col === 'object' && col.grid === true);
            
            return `
                <tr style="${row.status == 0 ? 'background:#f916168a' : ''}">
                    <td>${startIndex + i + 1}</td>
                    ${columns}
                    ${this.renderActions(row)}
                </tr>
                ${hasGrid ? `<tr id="grid${row.user_id}" style="display:none"></tr>` : ""}
            `;
        }).join('');

        this.renderTableFooter(datas);
        this.renderPagination();
    }



    // Render Action Buttons
    renderActions(row) {
        return typeof this.actions === 'function' ? `<td width="10%"><div id="actions">${this.actions(row)}</div></td>` : "";
    }



    // Create the tfoot Rows 
    renderTableFooter(datas) {
        const tfoot = this.table.querySelector('tfoot');
        tfoot.innerHTML = '';
    
        if (!datas || datas.length === 0) return;

        // Find first index of column with a footer type
        const firstFooterIndex = this.tbody.findIndex(col => {
            const data = typeof col === 'string' ? { key: col, type: 'text' } : col;
            return ['sum', 'avg', 'custom'].includes(data.footerType);
        });

        const colSpan = firstFooterIndex + 1;
        let hasBalance = false;

        // If no footer columns are found, exit
        if (firstFooterIndex === -1 || colSpan >= this.tbody.length + 1) return;
    
        const footerCells = this.tbody.map((col, index) => {
            if (index < firstFooterIndex) return ''; // skip printing <td> before first footer

            const data = typeof col === 'string' ? { key: col, type: 'text' } : col;
            const key = data.key;
            const footerType = data.footerType;
    
            if (!footerType || (data.type !== 'number' && data.type !== 'calculate' && footerType !== 'custom')) {
                return '<td></td>';
            }
    
            // Handle 'custom' type
            if (footerType === 'custom' && typeof data.footerRender === 'function') {
                return `<td style="text-align:right; font-weight:bold;">${data.footerRender(datas)}</td>`;
            }
    
            // Aggregate numeric or calculated values
            let total = 0;
            datas.forEach(row => {
                let value = 0;
                if (data.type === 'calculate' && data.expration) {
                    value = this.evaluateExpression(data.expration, row);
                } else {
                    value = key.split('.').reduce((obj, k) => obj?.[k], row);
                }
                total += Number(value) || 0;
            });
    
            if (footerType === 'sum') {
                // calculate the balance 
                if (data.key === 'balance') {
                    hasBalance = true;
                    total = this.currBalance;
                }
                return `<td style="text-align:right; font-weight:bold;">${total.toLocaleString('en-US')}</td>`;
            }
    
            if (footerType === 'avg') {
                const avg = total / (datas.length || 1);
                return `<td style="text-align:right; font-weight:bold;">${avg.toLocaleString('en-US', { maximumFractionDigits: 2 })}</td>`;
            }
        }).join('');
    
        const footerHtml = `
            <tr>
                <td style="font-weight:bold;" colspan="${colSpan}">${hasBalance ? 'Closing Balance' : 'Total'}</td>
                ${footerCells}
            </tr>
        `;
    
        tfoot.innerHTML = footerHtml;
    }



    // Create the Pagination 
    renderPagination() {
        const pagination = document.getElementById('paginate');
        let totalPages = Math.ceil(this.filteredData.length / this.rowsPerPage);
        let currentPage = this.currentPage;

        // Arrow Function For creating page numbers 
        const CreatePageItem = (i, isActive) => `
            <li class="page-item ${isActive ? 'active' : ''}">
                ${isActive ? `<span class="page-link">${i}</span>` : `<a class="page-link" data-page="${i}">${i}</a>`}
            </li>
        `;
    
        // Arrow Function For Add Elipsis
        const AddElipsis = () => `
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">...</span>
            </li>
        `;

        if(totalPages > 1){
            let paginationHtml = `<nav style="display:flex;align-items:center;gap:10px;"><ul class="pagination">`;
            
            // Create Previous Link
            paginationHtml += currentPage != 1 ? `
                <li class="page-item">
                    <a class="page-link" data-page="${currentPage - 1}">&#60</a>
                </li>
            ` : `
                <li class="page-item disabled">
                    <span class="page-link">&#60;</span>
                </li>
            `;


            // Create Page Links
            if (totalPages <= 10) {
                for (let i = 1; i <= totalPages; i++) paginationHtml += CreatePageItem(i, i === currentPage);
            } 
            else {
                if (currentPage < 8) {
                    for (let i = 1; i <= 10; i++) paginationHtml += CreatePageItem(i, i === currentPage);
                    paginationHtml += AddElipsis() + CreatePageItem(totalPages - 1) + CreatePageItem(totalPages);
                } 
                else if (currentPage <= totalPages - 7) {
                    paginationHtml += CreatePageItem(1) + CreatePageItem(2) + AddElipsis();
                    for (let i = currentPage - 3; i <= currentPage + 3; i++) paginationHtml += CreatePageItem(i, i === currentPage);
                    paginationHtml += AddElipsis() + CreatePageItem(totalPages - 1) + CreatePageItem(totalPages);
                } 
                else {
                    paginationHtml += CreatePageItem(1) + CreatePageItem(2) + AddElipsis();
                    for (let i = totalPages - 9; i <= totalPages; i++) paginationHtml += CreatePageItem(i, i === currentPage);
                }
            }


            // Create Next Link
            paginationHtml += currentPage != totalPages ? `
                <li class="page-item">
                    <a class="page-link" data-page="${currentPage + 1}">&#62</a>
                </li>
            ` : `
                <li class="page-item disabled">
                    <span class="page-link">&#62;</span>
                </li>
            `;

            paginationHtml += `</ul></nav>`;
            
            pagination.innerHTML = '';
            pagination.innerHTML = paginationHtml;
        } 
        else{
            pagination.innerHTML = "";
        }
    } // End Render Pagination



    // Calculate Expressions like {qty * cp}
    evaluateExpression(expr, data) {
        return new Function(...Object.keys(data), `return ${expr};`)(...Object.values(data));
    }
    // evaluateExpression(expr, data) {
    //     try {
    //         // Use Function constructor to create a scoped evaluator with Math functions allowed
    //         return new Function(...Object.keys(data), 'Math', `return ${expr};`)
    //                (...Object.values(data), Math);
    //     } catch (error) {
    //         console.error('Expression Error:', expr, error.message);
    //         return 0;
    //     }
    // }



    // Add Row After Inserting into Database
    addRow(data) {
        this.data.push(data);
        this.filteredData.push(data);
        this.renderTableBody();
    }



    // Update Row After Updating in Database
    updateRow(id, updatedData) {
        this.data = this.data.map(item => item.id == id ? { ...item, ...updatedData } : item);
        this.filteredData = this.filteredData.map(item => item.id == id ? { ...item, ...updatedData } : item);
        this.renderTableBody();
    }



    // Delete Row After Delete From Database
    deleteRow(id) {
        this.data = this.data.filter(item => item.id != id);
        this.filteredData = this.filteredData.filter(item => item.id != id);
        this.renderTableBody();
    }
}


// Create the thead Rows 
function renderTableHead(thead, tableId ='#data-table') {
    const head = document.querySelector(`${tableId} thead`);
    const row1 = thead.map(h => `<th>${h.label}</th>`).join('');

    const row2 = thead.map(h => {
        if (h.type === 'date') { // Rowper page
            return `<th><input class="col-filter" data-key="${h.key}" type="date" style="width:90px;font-size:10px;padding:2px;"></th>`;
        }
        else if (h.type === 'rowsPerPage') { // Rowper page
            const opts = h.options.map(option => `<option value="${option}">${option}</option>`).join('');
            return `<th style="width:50px;"><select id="rowsPerPage">${opts}</select></th>`;
        }
        else if (h.type === 'select') {
            if (h.method === 'custom') {
                const opts = [`<option value="">-- Select --</option>`]
                .concat(h.options.map(option => (typeof option === 'object' && option !== null) ? `<option value="${option.val}">${option.text}</option>` : `<option value="${option}">${option}</option>`))
                .join('');
                return `<th><select class="col-filter" data-key="${h.key}">${opts}</select></th>`;
            } 
            else if (h.method === 'fetch') {
                setTimeout(() => {
                    GetSelectInputList(h.link, function (res) {
                        const opts = [`<option value="">-- Select --</option>`]
                        .concat(res.data.map(item => `<option value="${item.id}">${item[h.name]}</option>`))
                        .join('');
                        document.getElementById(h.key).innerHTML = opts;
                    }, h.data);
                }, 0);
                return `<th><select class="col-filter" data-key="${h.key}" id="${h.key}" style="font-size:10px;"><option value="">Loading...</option></select></th>`;
            }
        }
        else if (Array.isArray(h.status)) {
            const opts = [`<option value="">-- Select --</option>`]
            .concat(h.status.map(item => `<option value="${item.key}">${item.label}</option>`))
            .join('');
        
            return `<th  style="width:60px;"><select class="col-filter" data-key="status" style="width:60px;font-size:10px;">${opts}</select></th>`;
        }
        else if (h.type === 'button') { // Action Button
            return `<th><button id="exportCSV"><i class="fa-regular fa-file-excel"></i></button></th>`;
        }
        else if (h.key) { // Col-Fielter Input
            return `<th><input type="text" class="col-filter" data-key="${h.key}" /></th>`;
        }
        else {
            return `<th></th>`;
        }
    }).join('');

    head.innerHTML = `
        <tr>${row1}</tr>
        <tr>${row2}</tr>
    `;
} // End Render thead Rows