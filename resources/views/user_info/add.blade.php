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
        
                {{-- ID (Hidden, auto-handled) --}}
                <input type="hidden" name="id" id="id">
        
                {{-- SL --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="sl">Serial (SL) <span class="required">*</span></label>
                        <input type="number" name="sl" id="sl" class="form-input">
                        <span class="error" id="sl_error"></span>
                    </div>
                </div>
        
                {{-- QR URL --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="qr_url">QR URL</label>
                        <input type="text" name="qr_url" id="qr_url" class="form-input">
                        <span class="error" id="qr_url_error"></span>
                    </div>
                </div>
        
                {{-- UID --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="u_id">UID</label>
                        <input type="text" name="u_id" id="u_id" class="form-input">
                        <span class="error" id="u_id_error"></span>
                    </div>
                </div>
        
                {{-- Registration No --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="reg_no">Registration No <span class="required">*</span></label>
                        <input type="text" name="reg_no" id="reg_no" class="form-input">
                        <span class="error" id="reg_no_error"></span>
                    </div>
                </div>
        
                {{-- Name --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="name">Name <span class="required">*</span></label>
                        <input type="text" name="name" id="name" class="form-input">
                        <span class="error" id="name_error"></span>
                    </div>
                </div>
        
                {{-- Phone --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-input">
                        <span class="error" id="phone_error"></span>
                    </div>
                </div>
        
                {{-- Duplicate --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="duplicate">Duplicate</label>
                        <input type="text" name="duplicate" id="duplicate" class="form-input">
                        <span class="error" id="duplicate_error"></span>
                    </div>
                </div>
        
                {{-- Gender --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="gender">Gender <span class="required">*</span></label>
                        <select name="gender" id="gender" class="form-input">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                        <span class="error" id="gender_error"></span>
                    </div>
                </div>
        
                {{-- Age --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" class="form-input">
                        <span class="error" id="age_error"></span>
                    </div>
                </div>
        
                {{-- Date of Birth --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" id="dob" class="form-input">
                        <span class="error" id="dob_error"></span>
                    </div>
                </div>
        
                {{-- Occupation --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="occupation">Occupation</label>
                        <input type="text" name="occupation" id="occupation" class="form-input">
                        <span class="error" id="occupation_error"></span>
                    </div>
                </div>
        
                {{-- QT Status --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="qt_status">QT Status <span class="required">*</span></label>
                        <select name="qt_status" id="qt_status" class="form-input">
                            <option value="">Select Status</option>
                            <option value="graduate">Graduate</option>
                            <option value="pro-master">Pro-Master</option>
                        </select>
                        <span class="error" id="qt_status_error"></span>
                    </div>
                </div>
        
                {{-- Quantum --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="quantum">Quantum</label>
                        <input type="text" name="quantum" id="quantum" class="form-input">
                        <span class="error" id="quantum_error"></span>
                    </div>
                </div>
        
                {{-- Quantier --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="quantier">Quantier</label>
                        <input type="text" name="quantier" id="quantier" class="form-input">
                        <span class="error" id="quantier_error"></span>
                    </div>
                </div>
        
                {{-- Ardentier --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="ardentier">Ardentier</label>
                        <input type="text" name="ardentier" id="ardentier" class="form-input">
                        <span class="error" id="ardentier_error"></span>
                    </div>
                </div>
        
                {{-- Branch --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="branch">Branch</label>
                        <select name="branch" id="branch" class="form-input">
                            <option value="">Select Branch</option>
                            {{-- Dynamic options --}}
                        </select>
                        <span class="error" id="branch_error"></span>
                    </div>
                </div>
        
                {{-- Job Status --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="job_status">Job Status</label>
                        <input type="text" name="job_status" id="job_status" class="form-input">
                        <span class="error" id="job_status_error"></span>
                    </div>
                </div>
        
                {{-- Psyche Certificate --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="psyche_certificate">Psyche Certificate</label>
                        <input type="text" name="psyche_certificate" id="psyche_certificate" class="form-input">
                        <span class="error" id="psyche_certificate_error"></span>
                    </div>
                </div>
        
                {{-- SP --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="sp">SP</label>
                        <input type="text" name="sp" id="sp" class="form-input">
                        <span class="error" id="sp_error"></span>
                    </div>
                </div>
        
                {{-- Group --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="group">Group</label>
                        <input type="text" name="group" id="group" class="form-input">
                        <span class="error" id="group_error"></span>
                    </div>
                </div>
        
                {{-- Call --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="call">Call</label>
                        <input type="text" name="call" id="call" class="form-input">
                        <span class="error" id="call_error"></span>
                    </div>
                </div>
        
                {{-- SMS --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="sms">SMS</label>
                        <input type="text" name="sms" id="sms" class="form-input">
                        <span class="error" id="sms_error"></span>
                    </div>
                </div>
        
                {{-- Color --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="color">Color</label>
                        <input type="text" name="color" id="color" class="form-input">
                        <span class="error" id="color_error"></span>
                    </div>
                </div>
        
                {{-- Barcode --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="barcode">Barcode</label>
                        <input type="text" name="barcode" id="barcode" class="form-input">
                        <span class="error" id="barcode_error"></span>
                    </div>
                </div>
        
                {{-- New Barcode --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="new_barcode">New Barcode</label>
                        <input type="text" name="new_barcode" id="new_barcode" class="form-input">
                        <span class="error" id="new_barcode_error"></span>
                    </div>
                </div>
        
                {{-- New Barcode SL --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="new_barcode_sl">New Barcode SL</label>
                        <input type="text" name="new_barcode_sl" id="new_barcode_sl" class="form-input">
                        <span class="error" id="new_barcode_sl_error"></span>
                    </div>
                </div>
        
                {{-- Barcode Delivery --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="barcode_delivery">Barcode Delivery</label>
                        <input type="date" name="barcode_delivery" id="barcode_delivery" class="form-input">
                        <span class="error" id="barcode_delivery_error"></span>
                    </div>
                </div>
        
                {{-- First Attend --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="first_attend">First Attend</label>
                        <input type="date" name="first_attend" id="first_attend" class="form-input">
                        <span class="error" id="first_attend_error"></span>
                    </div>
                </div>
        
                {{-- Last Attend --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="last_attend">Last Attend</label>
                        <input type="date" name="last_attend" id="last_attend" class="form-input">
                        <span class="error" id="last_attend_error"></span>
                    </div>
                </div>
        
                {{-- Status --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-input">
                            <option value="">Select</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <span class="error" id="status_error"></span>
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
