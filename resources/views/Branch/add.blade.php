<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="BranchAddForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            {{-- Branch Name --}}
            <div class="form-input-group">
                <label for="branch">Branch Name <span class="required" title="Required">*</span></label>
                <input type="text" name="branch" class="form-input" id="branch">
                <span class="error" id="branch_error"></span>
            </div>

            {{-- Short Code --}}
            <div class="form-input-group">
                <label for="short">Short Code <span class="required" title="Required">*</span></label>
                <input type="text" name="short" class="form-input" id="short">
                <span class="error" id="short_error"></span>
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>
