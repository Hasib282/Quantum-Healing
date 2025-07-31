<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
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
            <div class="rows">
                {{-- Registration No --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="reg_no">Registration No <span class="required">*</span></label>
                        <input type="text" name="reg_no" id="reg_no" class="form-input">
                        <span class="error" id="reg_no_error"></span>
                    </div>
                </div>
                {{-- Name --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="name">Name <span class="required">*</span></label>
                        <input type="text" name="name" id="name" class="form-input">
                        <span class="error" id="name_error"></span>
                    </div>
                </div>
                {{-- Phone --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="phone">Phone <span class="required">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-input">
                        <span class="error" id="phone_error"></span>
                    </div>
                </div>
                {{-- Gender --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="gender">Gender <span class="required">*</span></label>
                        <select name="gender" id="gender" class="form-input">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <span class="error" id="gender_error"></span>
                    </div>
                </div>
                {{-- Age --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="age">Age <span class="required">*</span></label>
                        <input type="number" name="age" id="age" class="form-input">
                        <span class="error" id="age_error"></span>
                    </div>
                </div>
                {{-- Dob --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="dob">DOB <span class="required">*</span></label>
                        <input type="date" name="dob" id="dob" class="form-input">
                        <span class="error" id="dob_error"></span>
                    </div>
                </div>
                {{-- QT Status --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="qt_status">QT Status <span class="required">*</span></label>
                        <select name="qt_status" id="qt_status" class="form-input">
                            <option value="">Select Status</option>
                            <option value="Graduate">Graduate</option>
                            <option value="Pro-master">Pro-master</option>
                        </select>
                        <span class="error" id="qt_status_error"></span>
                    </div>
                </div>
                {{-- Branch --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="branch">Branch <span class="required">*</span></label>
                        <input type="text" name="branch" id="branch" class="form-input" autocomplete="off"><hr>
                        <div id="branch-list"></div>
                        <span class="error" id="branch_error"></span>
                    </div>
                </div>
                {{-- Call --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="call">Call</label>
                        <select name="call" id="call" class="form-input">
                            <option value="">Select Call</option>
                            <option value="Call">Call</option>
                            <option value="Not to call">Not to call</option>
                        </select>
                        <span class="error" id="call_error"></span>
                    </div>
                </div>
                {{-- Color --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="color">Color</label>
                        <select name="color" id="color" class="form-input">
                            <option value="">Select Color</option>
                            <option value="Red">Red</option>
                            <option value="Green">Green</option>
                            <option value="Yellow">Yellow</option>
                        </select>
                        <span class="error" id="color_error"></span>
                    </div>
                </div>
                {{-- Occupation --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="occupation">Occupation</label>
                        <input type="text" name="occupation" id="occupation" class="form-input">
                        <span class="error" id="occupation_error"></span>
                    </div>
                </div>
                
                {{-- Group --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="group">Group</label>
                        <input type="text" name="group" id="group" class="form-input">
                        <span class="error" id="group_error"></span>
                    </div>
                </div>
                {{-- QR URL --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="qr_url">QR URL</label>
                        <input type="text" name="qr_url" id="qr_url" class="form-input">
                        <span class="error" id="qr_url_error"></span>
                    </div>
                </div>
                {{-- New Barcode --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="new_barcode">New Barcode</label>
                        <input type="text" name="new_barcode" id="new_barcode" class="form-input">
                        <span class="error" id="new_barcode_error"></span>
                    </div>
                </div>
                {{-- New Barcode SL --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="new_barcode_sl">New Barcode SL</label>
                        <input type="text" name="new_barcode_sl" id="new_barcode_sl" class="form-input">
                        <span class="error" id="new_barcode_sl_error"></span>
                    </div>
                </div>
                {{-- UID --}}
                <div class="c-3">
                    <div class="form-input-group">
                        <label for="u_id">UID</label>
                        <input type="text" name="u_id" id="u_id" class="form-input">
                        <span class="error" id="u_id_error"></span>
                    </div>
                </div>
                {{-- Achivements --}}
                <div class="c-12">
                    <label>User Achievements</label>
                    <div class="rows">
                        {{-- Job Status --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="job_status"><input type="checkbox" name="job_status" id="job_status">Job Status</label>
                            </div>
                        </div>
                        {{-- Quantum --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="quantum"><input type="checkbox" name="quantum" id="quantum">Quantum</label>
                            </div>
                        </div>
                        {{-- Quantier --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="quantier"><input type="checkbox" name="quantier" id="quantier">Quantier</label>
                            </div>
                        </div>
                        {{-- Ardentier --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="ardentier"><input type="checkbox" name="ardentier" id="ardentier">Ardentier</label>
                            </div>
                        </div>
                        {{-- Psyche Certificate --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="psyche_certificate"><input type="checkbox" name="psyche_certificate" id="psyche_certificate">Psyche Certificate</label>
                            </div>
                        </div>
                        {{-- Spacial Program --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="sp"><input type="checkbox" name="sp" id="sp">Spacial Program</label>
                            </div>
                        </div>
                        {{-- SMS --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="sms"><input type="checkbox" name="sms" id="sms">SMS</label>
                            </div>
                        </div>
                        {{-- Barcode --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="barcode"><input type="checkbox" name="barcode" id="barcode">Barcode Ready</label>
                            </div>
                        </div>
                        {{-- Duplicate --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="duplicate"><input type="checkbox" name="duplicate" id="duplicate">Duplicate</label>
                            </div>
                        </div>
                        {{-- Barcode Delivery --}}
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="barcode_delivery"><input type="checkbox" name="barcode_delivery" id="barcode_delivery">Barcode Delivery</label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Image --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-input">
                        <span class="error" id="image_error"></span>
                        <img src="/images/male.png" alt="Preview" id="previewImage" style="width: 150px; height: 150px; margin-top: 5px;">
                    </div>
                </div>
            </div>
        
            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
        
    </div>
</div>
