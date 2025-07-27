@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows">
        <div class="c-3">
            <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
        </div>
        <div class="c-6">

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
    </table>
    <div id="paginate"></div>
</div>

{{-- Modals --}}
@include('setup.event_user.add')

@include('setup.event_user.edit')

@include('common_modals.delete')

<!-- AJAX Script -->
<script src="{{ asset('js/ajax').'/'. $js . '.js' }}"></script>
{{-- <script src="{{ asset('js/ajax/search_by_input.js') }}"></script> --}}
