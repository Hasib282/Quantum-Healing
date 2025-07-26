<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id">

            {{-- Branch Name --}}
            <div class="form-input-group">
                <label for="updateBranch">Branch Name <span class="required" title="Required">*</span></label>
                <input type="text" name="branch" class="form-input" id="updateBranch">
                <span class="error" id="update_branch_error"></span>
            </div>

            {{-- Short Code --}}
            <div class="form-input-group">
                <label for="updateShort">Short Code <span class="required" title="Required">*</span></label>
                <input type="text" name="short" class="form-input" id="updateShort">
                <span class="error" id="update_short_error"></span>
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>
