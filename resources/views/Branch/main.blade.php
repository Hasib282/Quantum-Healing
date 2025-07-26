@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')

{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows">
        <div class="c-3">
            <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }}</button>
        </div>
        <div class="c-3">
            <select name="selectOption" id="selectOption">
                <option value="0">All</option>
                <option value="1">Branch</option>
                <option value="2">Short</option>
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
    <table class="data-table" id="branch-data-table">
        <caption>{{ $name }} Details</caption>
        <thead>
            <th>Sl</th>
            <th>Branch</th>
            <th>Short</th>
            <th>Added At</th>
            <th>Action</th>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
    <div id="paginate"></div>
</div>

{{-- Modals --}}
@include('branch.add')
@include('branch.edit')
@include('common_modals.delete')

<script src="{{ asset('js/ajax/branch.js') }}"></script>
@endsection
