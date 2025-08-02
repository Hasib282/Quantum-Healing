<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 100%;margin:0;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit Practice {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id">

            <div class="rows">
                <div class="c-6">
                    {{-- Event List --}}
                    <div class="form-input-group">
                        <label for="events">Select Events</label>
                        <select name="events" id="events" class="form-input">
                            <option value="">Select Events</option>
                            {{-- options will be loaded dynamically --}}
                        </select>
                        <span class="error" id="events_error"></span>
                    </div>

                    {{-- Left-side table --}}
                    <div class="form-input-group">
                        <label for="participants">Participants <span class="required" title="Required">*</span></label>
                        <input type="text" name="participants" class="form-input" id="participants" placeholder="Search Participants...">
                        <div id="all-participants" style="max-height: 200px; overflow-y: auto;">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Reg No</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <span class="error" id="participants_error"></span>
                    </div>
                </div>

                <div class="c-6">
                    {{-- Dropdown for right-side table --}}
                    <div class="form-input-group">
                        <label for="eventDataDropdown">Load Participants From</label>
                        <select id="eventDataDropdown" class="form-input">
                            <option value="">-- Select Event --</option>
                            {{-- Event options dynamically added --}}
                        </select>
                        
                    </div>

                    {{-- Select All Button --}}
                    <div class="form-input-group" style="margin-top: 10px;">
                        <button type="button" class="btn-blue" id="selectAllParticipants">Select All</button>
                    </div>

                    {{-- Right-side participants list --}}
                    <div id="participants-list" style="position: initial; max-height: 320px; overflow-y:auto; margin-top: 10px;"></div>
                </div>
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>
