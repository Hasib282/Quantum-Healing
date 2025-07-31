{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows">
        <div class="c-3">
            <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
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
        <div class="c-2">
            <label for="search">Start Date</label>
            <input type="text" name="search" id="search" class="form-input">
        </div>
        <div class="c-3" style="padding: 0;">
            <input type="text" id="globalSearch" placeholder="Search..." />
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
@include('setup.attendance.add')

@include('setup.attendance.edit')

@include('common_modals.delete')

<!-- AJAX Script -->
<script src="{{ asset('js/ajax').'/'. $js . '.js' }}"></script>
