<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name ?? 'Event' }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EventAddForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            {{-- name --}}
            <div class="form-input-group">
                <label for="name">Event Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="name" required>
                <span class="error" id="name_error"></span>
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>
