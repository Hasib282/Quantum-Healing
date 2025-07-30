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

            {{-- Events  --}}
            <div class="form-input-group">
                <label for="updateEvents">Select Events</label>
                <select name="events" id="updateEvents" class="select-small">
                    <option value="">Select Events</option>
                    {{-- options will be import dynamically --}}
                </select>
                <span class="error" id="update_events_error"></span>
            </div>
            {{-- Date --}}
            <div class="form-input-group">
                <label for="updateDate">Date<span class="required" title="Required">*</span></label>
                <input type="date" name="date" class="input-small" id="updateDate" value="{{ date('Y-m-d') }}">
                <span class="error" id="update_date_error"></span>
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>
