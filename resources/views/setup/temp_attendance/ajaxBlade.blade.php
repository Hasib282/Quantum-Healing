{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows">
        <div class="c-3">
            <button class="open-modal" data-modal-id="uploadModal"><i class="fa-solid fa-plus"></i> Upload Excel </button>
        </div>
        <div class="c-2">
            <label for="searchEvents">Events</label>
            <select name="searchEvents" id="searchEvents">
                <option value="">Select Events</option>
                {{-- options will be import dynamically --}}
            </select>
        </div>
        <div class="c-2">
            <label for="searchDates">Date</label>
            <input type="date" name="searchDates" id="searchDates" class="form-input" value="{{date('Y-m-d')}}">
        </div>
        <div class="c-5">
            <label for="search">Start Date</label>
            <input type="text" name="search" id="search" class="form-input">
        </div>
    </div>
</div>

{{-- Datatable Part --}}
<div class="load-data">
    <table class="data-table" id="data-table">
        <caption>{{ $name }} Details</caption>
        <thead></thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
    <div id="paginate"></div>
</div>

{{-- Modals --}}
@include('setup.temp_attendance.edit')

@include('setup.temp_attendance.upload')

@include('common_modals.delete')

<!-- AJAX Script -->
<script src="{{ asset('js/ajax').'/'. $js . '.js' }}"></script>
