{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows" style="align-items:center;">
        <div class="c-4"></div>
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
        <div class="c-2"></div>
        <div class="c-1">
            <a class="btn-blue" id="print"><i class="fa-solid fa-print"></i> Print</a>
        </div>
        <div class="c-1"></div>
        <div class="c-12 center-col">
            <span class="error" id="date_error"></span>
            <span class="error" id="events_error"></span>
        </div>
    </div>
</div>

{{-- Datatable Part --}}
<div class="load-data">
    <table class="data-table" id="data-table">
        <caption style="background: #f2f2f25e;color:black;border: 1px solid #80808080;">Event <span id="name"></span>
            <br> Attendence on <span id="attend"></span></caption>
        <thead></thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div id="paginate"></div>
</div>


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax').'/'. $js .'.js' }}"></script>