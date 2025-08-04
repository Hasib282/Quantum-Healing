<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 60%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Update {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="AddForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id">
            <div class="rows">
                <div class="c-6">
                    {{-- Events  --}}
                    <div class="form-input-group">
                        <label for="events">Select Events</label>
                        <select name="events" id="events" class="form-input" disabled>
                            <option value="">Select Events</option>
                            {{-- options will be import dynamically --}}
                        </select>
                        <span class="error" id="events_error"></span>
                    </div>

                    {{-- Date --}}
                    <div class="form-input-group">
                        <label for="date">Date<span class="required" title="Required">*</span></label>
                        <input type="date" name="date" class="form-input" id="date" disabled>
                        <span class="error" id="date_error"></span>
                    </div>

                    {{-- QR Url --}}
                    <div class="form-input-group">
                        <label for="qr_url">QR Url <span class="required" title="Required">*</span></label>
                        <input type="text" name="qr_url" class="form-input" id="qr_url" readonly>
                        <span class="error" id="qr_url_error"></span>
                    </div>
                    
                    {{-- Reg_no --}}
                    <div class="form-input-group">
                        <label for="reg_no">Reg no <span class="required" title="Required">*</span></label>
                        <input type="text" name="reg_no" class="form-input" id="reg_no">
                        <span class="error" id="reg_no_error"></span>
                    </div>

                    <div class="center">
                        <button type="submit" class="btn-blue" id="Insert">Update</button>
                    </div>
                </div>
                <div class="c-6">
                    <div id="userData"></div>
                </div>
            </div>
            
        </form>
    </div>
</div>
