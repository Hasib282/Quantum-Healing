@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows">
        <div class="c-3">
            {{-- Optionally add a button to open the edit modal --}}
            <button class="btn-blue open-modal" data-modal-id="editModal">Add New</button>
        </div>
        <div class="c-6">
            {{-- Optional search dropdown or filters can go here --}}
        </div>
        <div class="c-3" style="padding: 0;">
            <input type="text" id="globalSearch" placeholder="Search..." />
        </div>
    </div>
</div>

{{-- Datatable Part --}}
<div class="load-data">
    <table class="data-table" id="data-table">
        <caption>Practice {{ $name }} Details</caption>
        <thead>
            <tr>
                <th>Sl</th>
                <th>Event</th>
                <th>Participants</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- Rows will be populated by AJAX --}}
        </tbody>
    </table>
    <div id="paginate"></div>
</div>

{{-- Edit Modal --}}
@include('setup.event_user_practice.edit')

{{-- AJAX Script --}}
<script src="{{ asset('js/ajax/' . $js . '.js') }}"></script>
