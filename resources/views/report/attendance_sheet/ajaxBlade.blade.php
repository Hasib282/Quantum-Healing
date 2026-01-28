{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows" style="align-items:center;">
        <div class="c-1"></div>
        <div class="c-2">
            <label for="events">Events</label>
            <select name="events" id="events">
                <option value="">Select Events</option>
                {{-- options will be import dynamically --}}
            </select>
        </div>
        <div class="c-3">
            <label for="from">Start Date</label>
            <input type="date" name="from" id="from" class="form-input" value="{{ date('Y-m-d') }}">
            <span class="error" id="from_error"></span>
        </div>
        <div class="c-3">
            <label for="to">End Date</label>
            <input type="date" name="to" id="to" class="form-input" value="{{ date('Y-m-d') }}">
            <span class="error" id="to_error"></span>
        </div>
        <div class="c-1"></div>
        <div class="c-1">
            <a class="btn-blue" id="print"><i class="fa-solid fa-print"></i> Print</a>
        </div>
        <div class="c-1"></div>
    </div>
</div>

{{-- Datatable Part --}}
<div class="load-data">
    <table class="data-table" id="data-table">
        <caption>Attendance Sheet</caption>
        <thead>
            <th>Sl</th>
            <th>Reg. No</th>
            <th>Name</th>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div id="paginate"></div>
</div>


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax').'/'. $js .'.js' }}"></script>