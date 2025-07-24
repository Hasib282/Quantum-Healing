<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 500px;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="AddForm" method="post">
            @csrf
            {{-- name --}}
            <div class="form-input-group">
                <label for="name">{{ $name }} Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="name">
                <span class="error" id="name_error"></span>
            </div>

            {{-- company --}}
            @if ( auth()->user()->user_role == 1 && (Request::segment(1) == 'pharmacy' || Request::segment(1) == 'inventory') )
                <div class="form-input-group">
                    <label for="company">Company <span class="required" title="Required">*</span></label>
                    <input type="text" name="company" class="form-input" id="company" autocomplete="off"><hr>
                    <div id="company-list"></div>
                    <span class="error" id="company_error"></span>
                </div>
            @elseif(Request::segment(1) == 'pharmacy' || Request::segment(1) == 'inventory')
                <input type="text" name="company" class="form-input" id="company" data-id="{{auth()->user()->company_id}}" style="display: none">
            @endif

            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>