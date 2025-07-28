<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 100%;margin:0;">
        <div class="modal-heading">
            <div class="center">
                {{-- <h3>Add {{ $name }}</h3> --}}
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        
        <div class="rows">
            <div class="c-3"></div>
            <div class="c-3">
                {{-- Events  --}}
                <div class="form-input-group">
                    <label for="events">Select Events</label>
                    <select name="events" id="events" class="select-small">
                        <option value="">Select Events</option>
                        {{-- options will be import dynamically --}}
                    </select>
                    <span class="error" id="events_error"></span>
                </div>
            </div>
            <div class="c-3">
                {{-- Date --}}
                <div class="form-input-group">
                    <label for="date">Date<span class="required" title="Required">*</span></label>
                    <input type="date" name="date" class="input-small" id="date">
                    <span class="error" id="date_error"></span>
                </div>
            </div>
            <div class="c-3"></div>
            <div class="c-6">
                <form id="AddForm" method="POST" enctype="multipart/form-data" style="border: none;">
                    @csrf
                    @method('POST')
                    {{-- QR Url --}}
                    <div class="form-input-group">
                        <label for="qr_url">QR Url <span class="required" title="Required">*</span></label>
                        <input type="text" name="qr_url" class="form-input" id="qr_url">
                        <span class="error" id="qr_url_error"></span>
                    </div>
                    <div id="all-participants" style="max-height: 330px;overflow-y: scroll;">
                        <table>
                            <thead>
                                <th>Sl</th>
                                <th>Reg No</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Action</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="center">
                        <button type="submit" class="btn-blue" id="Insert">Submit</button>
                    </div>
                </form>
            </div>
            <div class="c-6">
                {{-- <iframe src="#" title="description" id="profileShow"></iframe> --}}
            </div>
        </div>
    </div>
</div>
