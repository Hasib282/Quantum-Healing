<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="AddForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            {{-- Events  --}}
            <div class="form-input-group">
                <label for="events">Select Events</label>
                <select name="events" id="events" class="form-input">
                    <option value="">Select Events</option>
                    {{-- options will be import dynamically --}}
                </select>
                <span class="error" id="events_error"></span>
            </div>

            {{-- Date --}}
            <div class="form-input-group">
                <label for="date">Date<span class="required" title="Required">*</span></label>
                <input type="date" name="date" class="form-input" id="date">
                <span class="error" id="date_error"></span>
            </div>

            {{-- QR Url --}}
            <div class="form-input-group">
                <label for="qr_url">QR Url <span class="required" title="Required">*</span></label>
                <input type="text" name="qr_url" class="form-input" id="qr_url">
                <span class="error" id="qr_url_error"></span>
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>
