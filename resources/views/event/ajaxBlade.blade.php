@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows">
        <div class="c-3">
            {{-- @if(auth()->user()->hasPermission(284)) --}}
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name ?? 'Event' }} </button>
            {{-- @endif --}}
        </div>
        <div class="c-3">
            <select name="selectOption" id="selectOption">
                <option value="0">All</option>
                <option value="1">Name</option>
            </select>
        </div>
        <div class="c-3">
            <input type="text" id="search" placeholder="Search...">
        </div>
        <div class="c-3" style="padding: 0;"></div>
    </div>
</div>

{{-- Datatable Part --}}
<div class="load-data">
    <table class="data-table" id="event-data-table">
        <caption>{{ $name ?? 'Event' }} Details</caption>
        <thead>
            <tr>
                <th>Sl</th>
                <th>Name</th>
                <th>Added At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div id="paginate"></div>
</div>

{{-- Modals --}}
@include('event.add')
@include('event.edit')
@include('common_modals.delete')
{{-- @include('common_modals.deleteStatus') --}}

<!-- AJAX Logic -->
<script src="{{ asset('js/ajax/event.js') }}"></script>
{{-- <script src="{{ asset('js/ajax/search_by_input.js') }}"></script> --}}
