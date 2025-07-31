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
        <div class="c-2">
            <label for="eventDate">Date</label>
            <select name="eventDate" id="eventDate">
                <option value="">Select Event Date</option>
                {{-- options will be import dynamically --}}
            </select>
        </div>
        <div class="c-2">
            <label for="qt_status">QT Status</label>
            <select name="qt_status" id="qt_status" class="form-input">
                <option value="">Select QT Status</option>
                <option value="Graduate">Graduate</option>
                <option value="Pro-master">Pro-master</option>
            </select>
        </div>
        <div class="c-2">
            <label for="gender">Gender <span class="required">*</span></label>
            <select name="gender" id="gender" class="form-input">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="c-1"></div>
        <div class="c-1">
            <a class="btn-blue" id="print"><i class="fa-solid fa-print"></i> Print</a>
        </div>
        <div class="c-1"></div>
        <div class="c-12 center">
            <span class="error" id="date_error"></span>
            <span class="error" id="events_error"></span>
        </div>
    </div>
</div>

{{-- Datatable Part --}}
<div class="load-data">
    {{-- <table class="data-table" id="data-table">
        <caption>{{ $name }} Details</caption>
        <thead></thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table> --}}
    <hr>
    <div style="text-align: center; width: 100%; margin: 0 auto;">
        <p>
            <strong id="name" style="font-size: 20px;"> Event</strong> <br>
        </p>
        <p>
            <strong id="attend" style="font-size: 18px;">Attendence on </strong> <br>
        </p>
    </div>
    <div id="tables">
        
    </div>

    <div id="paginate"></div>
</div>


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax').'/'. $js .'.js' }}"></script>