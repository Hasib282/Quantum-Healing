<div id="uploadModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;padding:0;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Upload {{ $name }}</h3>
                <span class="close-modal" data-modal-id="uploadModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="CsvForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            {{-- Event List --}}
            <div class="form-input-group">
                <label for="allevents">Select Events</label>
                <select name="events" id="allevents" class="form-input">
                    <option value="">Select Events</option>
                    {{-- options will be import dynamically --}}
                </select>
                <span class="error" id="events_error"></span>
            </div>
            {{-- Event List --}}
            <div class="form-input-group">
                <label for="event_date">Select Events</label>
                <input type="date" name="event_date" class="form-input" id="event_date">
                <span class="error" id="event_date_error"></span>
            </div>
            {{-- Upload Excel --}}
            <div class="form-input-group">
                <label for="file">Upload Excel File<span class="required">*</span></label>
                <input type="file" name="file" class="form-input" id="file">
                <span class="error" id="file_error"></span><br>
                <span class="green" id="message"></span>
            </div>
            
            <div class="center">
                <button type="submit" class="btn-blue" id="Upload">Upload</button>
            </div>
        </form>
    </div>
</div>
