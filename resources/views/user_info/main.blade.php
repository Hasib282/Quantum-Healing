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
                <button class="open-modal" data-modal-id="addModal" id="add">
                    <i class="fa-solid fa-plus"></i> Add {{ $name }}
                </button>
            </div>
            <div class="c-6">
                {{-- Reserved for future filters if needed --}}
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
            <thead>
                <tr>
                    <th>ID</th>
                    <th>SL</th>
                    <th>QR URL</th>
                    <th>UID</th>
                    <th>Registration No</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Duplicate</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Date of Birth</th>
                    <th>Occupation</th>
                    <th>QT Status</th>
                    <th>Quantum</th>
                    <th>Quantier</th>
                    <th>Ardentier</th>
                    <th>Branch</th>
                    <th>Job Status</th>
                    <th>Psyche Certificate</th>
                    <th>SP</th>
                    <th>Group</th>
                    <th>Call</th>
                    <th>SMS</th>
                    <th>Color</th>
                    <th>Barcode</th>
                    <th>New Barcode</th>
                    <th>New Barcode SL</th>
                    <th>Barcode Delivery</th>
                    <th>First Attend</th>
                    <th>Last Attend</th>
                    <th>Status</th>
                    <th>Added At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>            
            
            <tbody></tbody>
            <tfoot></tfoot>
        </table>

        <div id="paginate"></div>
    </div>

    {{-- Include Modals --}}
    @include('user_info.add')
    @include('user_info.edit')
    @include('common_modals.detailsModal')
    @include('common_modals.delete')
    @include('common_modals.deleteStatus')

    {{-- AJAX Scripts --}}
    {{-- <script src="{{ asset('js/ajax/' . (Request::segment(1) == 'admin' ? 'admin_setup' : Request::segment(1)) . '/users/' . $js . '.js') }}"></script> --}}
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
    <script src="{{ asset('js/ajax/admin_setup/users/user_info.js') }}"></script>


@endsection
