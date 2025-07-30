<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 100%;margin:0;">
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

            <div class="rows">
                <div class="c-6">
                    {{-- Event List --}}
                    <div class="form-input-group">
                        <label for="events">Select Events</label>
                        <select name="events" id="events" class="form-input" disabled>
                            <option value="">Select Events</option>
                            {{-- options will be import dynamically --}}
                        </select>
                        <span class="error" id="events_error"></span>
                    </div>
                    {{-- Participants --}}
                    <div class="form-input-group">
                        <label for="participants">Participants <span class="required" title="Required">*</span></label>
                        <input type="text" name="participants" class="form-input" id="participants" autocomplete="off">
                        <div id="all-participants" style="max-height: 200px;">
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
                        <span class="error" id="participants_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div id="participants-list" style="position: initial;max-height:320px;"></div>
                </div>
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>
