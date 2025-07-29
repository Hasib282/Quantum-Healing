<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 100%;margin:0;padding:0;height:100%;background:lavenderblush;">
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
                    <input type="date" name="date" class="input-small" id="date" value="{{ date('Y-m-d') }}">
                    <span class="error" id="date_error"></span>
                </div>
            </div>
            <div class="c-3"></div>
            <div class="c-3"></div>
            <div class="c-6">
                <form id="AddForm" method="POST" enctype="multipart/form-data" style="border: none;">
                    @csrf
                    @method('POST')
                    {{-- QR Url --}}
                    <div class="form-input-group">
                        <label for="qr_url">QR Url <span class="required" title="Required" autofocus >*</span></label>
                        <input type="text" name="qr_url" class="form-input" id="qr_url">
                        <span class="error" id="qr_url_error"></span>
                    </div>
                    <div class="center">
                        <button type="submit" class="btn-blue" id="Insert">Submit</button>
                    </div>
                </form>
            </div>
            <div class="c-3"></div>
            <div class="c-12 center-col" id="userData">
                {{-- <iframe src="#" title="description" id="profileShow"></iframe> --}}
            </div>
        </div>
    </div>
</div>
