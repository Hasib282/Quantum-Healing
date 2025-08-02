function ShowEventUsers(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name',{ type:'multi-data', key:'users' }],
        actions: (row) => {
            return `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
            `;
        }
    });
}

$(document).ready(function () {
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Event Name', key: 'name' },
        { label: 'Participants', key: '' },
        { label: 'Action', type: 'button' }
    ]);

    ReloadData('admin/event_users', ShowEventUsers);

    EditAjaxCall('admin/event_users', EditFormInputValue, function () {
        localStorage.removeItem('participants');
        $('#all-participants tbody').html("");
        $('#participants-list').html("");
    });

    UpdateAjax('admin/event_users', {
        all_participants: () => JSON.stringify(JSON.parse(localStorage.getItem('participants') || '[]'))
    }, function () {
        $("#branch").focus();
        localStorage.removeItem('participants');
        $('#all-participants tbody').html("");
        $('#participants-list').html("");
    });

    function EditFormInputValue(item) {
        $('#id').val(item.data[0]?.event_id);
        $('#events').val(item.data[0]?.event_id);
        $('#participants').focus();

        let participants = [];

        item.data.forEach(item => {
            participants.push({
                id: item.id,
                name: item.participants[0]?.name || '',
                phone: item.participants[0]?.phone || '',
                reg_no: item.participants[0]?.reg_no || '',
                gender: item.participants[0]?.gender || '',
            });
        });

        localStorage.setItem('participants', JSON.stringify(participants));
        gridShow();
    }

    GetSelectInputList('admin/events/get', function (res) {
        CreateSelectOptions('#events', "Select Events", res.data, 'name');
        CreateSelectOptions('#updateEvents', "Select Events", res.data, 'name');
        CreateSelectOptions('#eventDataDropdown', "-- Select Event --", res.data, 'name');
    });

    $(document).off("click", '.remove-participant').on("click", '.remove-participant', function (e) {
        e.preventDefault();
        let index = $(this).attr('data-index');
        let participants = JSON.parse(localStorage.getItem('participants')) || [];

        participants.splice(index, 1);
        localStorage.setItem('participants', JSON.stringify(participants));
        gridShow();
    });

    $(document).off("change", '#events').on("change", '#events', function () {
        let id = $(this).val();
        localStorage.removeItem('participants');
        $.ajax({
            url: `${apiUrl}/admin/event_users/get`,
            data: { id },
            success: function (res) {
                let participants = [];

                res.data.forEach(item => {
                    participants.push({
                        id: item.id,
                        name: item.participants[0]?.name || '',
                        phone: item.participants[0]?.phone || '',
                        reg_no: item.participants[0]?.reg_no || '',
                        gender: item.participants[0]?.gender || '',
                    });
                });

                localStorage.setItem('participants', JSON.stringify(participants));
                gridShow();
            }
        });
    });

    // New Feature: Load Participants From dropdown
    $(document).on("change", "#eventDataDropdown", function () {
        const id = $(this).val();
        const $list = $('#participants-list');
        $list.empty();
      
        if (!id) return;
      
        const isAll = id === 'all';
        const label = isAll ? 'All Members' : $(this).find('option:selected').text();
      
        if (isAll) {
          // Infinite scroll setup for All Members
          let page = 1;
          let loading = false;
          let hasMore = true;
      
          $list.html(`
            <h4>Participants from: ${label}</h4>
            <div id="scroll-container" style="max-height: 300px; overflow-y: auto; border: 1px solid #ccc;">
              <table class="table table-bordered">
                <thead class="table-success">
                  <tr>
                    <th>SL</th>
                    <th>Reg No</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Gender</th>
                  </tr>
                </thead>
                <tbody id="all-members-tbody"></tbody>
              </table>
              <div id="loading-indicator" style="padding: 10px; text-align: center; display: none;">Loading...</div>
            </div>
          `);
      
          const $scrollContainer = $list.find('#scroll-container');
          const $tbody = $list.find('#all-members-tbody');
          const $loadingIndicator = $list.find('#loading-indicator');
      
          function loadMore() {
            if (loading || !hasMore) return;
            loading = true;
            $loadingIndicator.show();
      
            $.get(`${apiUrl}/admin/users/user_info/get/participants`, { search: '', page })
              .done(res => {
                if (res.list) {
                  const html = $(res.list).find("tr").map((i, row) => row.outerHTML).get().join('');
                  $tbody.append(html);
                  hasMore = res.hasMore;
                  page += 1;
                }
              })
              .always(() => {
                loading = false;
                $loadingIndicator.hide();
              });
          }
      
          // Initial load
          loadMore();
      
          // Attach scroll listener
          $scrollContainer.on('scroll', function () {
            const nearBottom = $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight() + 30;
            if (nearBottom) loadMore();
          });
      
        } else {
          // For specific event participants
          $.get(`${apiUrl}/admin/event_users/get`, { id })
            .done(res => {
              if (Array.isArray(res.data)) {
                let rows = res.data.map((item, idx) => {
                  const user = item.participants?.[0];
                  if (!user) return '';
                  return `
                    <tr class="addData" data-id="${item.id}" data-name="${user.name}"
                        data-phone="${user.phone}" data-reg_no="${user.reg_no}" data-gender="${user.gender}">
                      <td>${idx + 1}</td>
                      <td>${user.reg_no}</td>
                      <td>${user.name}</td>
                      <td>${user.phone}</td>
                      <td>${user.gender}</td>
                    </tr>`;
                }).join('');
      
                $list.html(`
                  <h4>Participants from: ${label}</h4>
                  <div style="max-height:300px; overflow-y:auto;">
                    <table class="table table-bordered">
                      <thead class="table-success">
                        <tr>
                          <th>SL</th>
                          <th>Reg No</th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Gender</th>
                        </tr>
                      </thead>
                      <tbody>
                        ${rows}
                      </tbody>
                    </table>
                  </div>
                `);
              } else {
                $list.html(`<p>No participants found.</p>`);
              }
            })
            .fail(err => {
              console.error("Error fetching event participants", err);
              $list.html(`<p>Error loading data.</p>`);
            });
        }
      });
      

    // Row click adds to participants
    $(document).off('click', '#participants-list table tbody tr').on('click', '#participants-list table tbody tr', function () {
        const row = $(this);
        const id = row.data('id');
        const name = row.data('name');
        const phone = row.data('phone');
        const reg_no = row.data('reg_no');
        const gender = row.data('gender');

        let participants = JSON.parse(localStorage.getItem('participants')) || [];
        if (participants.find(p => p.id == id)) return;

        participants.push({ id, name, phone, reg_no, gender });
        localStorage.setItem('participants', JSON.stringify(participants));
        gridShow();
    });

    // Select All Button
    $('#selectAllParticipants').on('click', function () {
        $('#participants-list table tbody tr').each(function () {
            const row = $(this);
            const id = row.data('id');
            const name = row.data('name');
            const phone = row.data('phone');
            const reg_no = row.data('reg_no');
            const gender = row.data('gender');

            let participants = JSON.parse(localStorage.getItem('participants')) || [];
            if (!participants.find(p => p.id == id)) {
                participants.push({ id, name, phone, reg_no, gender });
            }
            localStorage.setItem('participants', JSON.stringify(participants));
        });
        gridShow();
    });

    // Initial right-side scroll + search
    FixedScrollSearch(
        'admin/users/user_info/get/participants',
        function (currentPage) {
            let data = JSON.parse(localStorage.getItem('participants')) || [];
            let reg_no = data.map(p => p.reg_no);
            return {
                search: $('#participants').val(),
                page: currentPage,
                reg_no: reg_no
            };
        },
        '#participants',
        '#participants-list',
        '#participants-list tbody tr'
    );
});

function gridShow() {
    let data = JSON.parse(localStorage.getItem('participants')) || [];
    $('#all-participants tbody').html("");

    data.forEach((item, index) => {
        $('#all-participants tbody').append(`
            <tr>
                <td>${index + 1}</td>
                <td>${item.reg_no}</td>
                <td>${item.name}</td>
                <td>${item.phone}</td>
                <td>${item.gender}</td>
                <td><div class="center"><button class="remove remove-participant"  data-index="${index}"><i class="fas fa-trash"></i></button></div></td>
            </tr>
        `);
    });
}
