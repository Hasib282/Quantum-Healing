<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
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

        {{-- ID --}}
        <input type="hidden" name="id" id="id">
        <div class="rows">
            {{-- Registration No --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateReg_no">Registration No <span class="required">*</span></label>
                    <input type="text" name="reg_no" id="updateReg_no" class="form-input">
                    <span class="error" id="update_reg_no_error"></span>
                </div>
            </div>
            {{-- Name --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateName">Name <span class="required">*</span></label>
                    <input type="text" name="name" id="updateName" class="form-input">
                    <span class="error" id="update_name_error"></span>
                </div>
            </div>
            {{-- Phone --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updatePhone">Phone <span class="required">*</span></label>
                    <input type="text" name="phone" id="updatePhone" class="form-input">
                    <span class="error" id="update_phone_error"></span>
                </div>
            </div>
            {{-- Gender --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateGender">Gender <span class="required">*</span></label>
                    <select name="gender" id="updateGender" class="form-input">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <span class="error" id="update_gender_error"></span>
                </div>
            </div>
            {{-- Age --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateAge">Age <span class="required">*</span></label>
                    <input type="number" name="age" id="updateAge" class="form-input">
                    <span class="error" id="update_age_error"></span>
                </div>
            </div>
            {{-- Dob --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateDob">DOB <span class="required">*</span></label>
                    <input type="date" name="dob" id="updateDob" class="form-input">
                    <span class="error" id="update_dob_error"></span>
                </div>
            </div>
            {{-- QT Status --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateQt_Status">QT Status <span class="required">*</span></label>
                    <select name="qt_status" id="updateQt_Status" class="form-input">
                        <option value="">Select Status</option>
                        <option value="Graduate">Graduate</option>
                        <option value="Pro-master">Pro-master</option>
                    </select>
                    <span class="error" id="update_qt_status_error"></span>
                </div>
            </div>
            {{-- Branch --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateBranch">Branch <span class="required">*</span></label>
                    <input type="text" name="branch" id="updateBranch" class="form-input" autocomplete="off"><hr>
                    <div id="update-branch"></div>
                    <span class="error" id="update_branch_error"></span>
                </div>
            </div>
            {{-- Call --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateCall">Call</label>
                    <select name="call" id="updateCall" class="form-input">
                        <option value="">Select Call</option>
                        <option value="Call">Call</option>
                        <option value="Not to call">Not to call</option>
                    </select>
                    <span class="error" id="update_call_error"></span>
                </div>
            </div>
            {{-- Color --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateColor">Color</label>
                    <select name="color" id="updateColor" class="form-input">
                        <option value="">Select Color</option>
                        <option value="Red">Red</option>
                        <option value="Green">Green</option>
                        <option value="Yellow">Yellow</option>
                    </select>
                    <span class="error" id="update_color_error"></span>
                </div>
            </div>
            {{-- Occupation --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateOccupation">Occupation</label>
                    <input type="text" name="occupation" id="updateOccupation" class="form-input">
                    <span class="error" id="update_occupation_error"></span>
                </div>
            </div>
            
            {{-- Group --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateGroup">Group</label>
                    <input type="text" name="group" id="updateGroup" class="form-input">
                    <span class="error" id="update_group_error"></span>
                </div>
            </div>
            {{-- QR URL --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateQr_url">QR URL</label>
                    <input type="text" name="qr_url" id="updateQr_url" class="form-input">
                    <span class="error" id="update_qr_url_error"></span>
                </div>
            </div>
            {{-- New Barcode --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateNew_barcode">New Barcode</label>
                    <input type="text" name="new_barcode" id="updateNew_barcode" class="form-input">
                    <span class="error" id="update_new_barcode_error"></span>
                </div>
            </div>
            {{-- New Barcode SL --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateNew_barcode_sl">New Barcode SL</label>
                    <input type="text" name="new_barcode_sl" id="updateNew_barcode_sl" class="form-input">
                    <span class="error" id="update_new_barcode_sl_error"></span>
                </div>
            </div>
            {{-- UID --}}
            <div class="c-3">
                <div class="form-input-group">
                    <label for="updateU_id">UID</label>
                    <input type="text" name="u_id" id="updateU_id" class="form-input">
                    <span class="error" id="update_u_id_error"></span>
                </div>
            </div>
            {{-- Achivements --}}
            <div class="c-12">
                <label>User Achievements</label>
                <div class="rows">
                    {{-- Job Status --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateJob_status"><input type="checkbox" name="job_status" id="updateJob_status">Job Status</label>
                        </div>
                    </div>
                    {{-- Quantum --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateQuantum"><input type="checkbox" name="quantum" id="updateQuantum">Quantum</label>
                        </div>
                    </div>
                    {{-- Quantier --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateQuantier"><input type="checkbox" name="quantier" id="updateQuantier">Quantier</label>
                        </div>
                    </div>
                    {{-- Ardentier --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateArdentier"><input type="checkbox" name="ardentier" id="updateArdentier">Ardentier</label>
                        </div>
                    </div>
                    {{-- Psyche Certificate --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updatePsyche_certificate"><input type="checkbox" name="psyche_certificate" id="updatePsyche_certificate">Psyche Certificate</label>
                        </div>
                    </div>
                    {{-- Spacial Program --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateSp"><input type="checkbox" name="sp" id="updateSp">Spacial Program</label>
                        </div>
                    </div>
                    {{-- SMS --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateSms"><input type="checkbox" name="sms" id="updateSms">SMS</label>
                        </div>
                    </div>
                    {{-- Barcode --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateBarcode"><input type="checkbox" name="barcode" id="updateBarcode">Barcode Ready</label>
                        </div>
                    </div>
                    {{-- Duplicate --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateDuplicate"><input type="checkbox" name="duplicate" id="updateDuplicate">Duplicate</label>
                        </div>
                    </div>
                    {{-- Barcode Delivery --}}
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="updateBarcode_delivery"><input type="checkbox" name="barcode_delivery" id="updateBarcode_delivery">Barcode Delivery</label>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Image --}}
            <div class="c-4">
                <div class="form-input-group">
                    <label for="updateImage">Image</label>
                    <input type="file" name="image" id="updateImage" class="form-input">
                    <span class="error" id="update_image_error"></span>
                    <img src="/images/male.png" alt="Preview" id="updatePreviewImage" style="width: 150px; height: 150px; margin-top: 5px;">
                </div>
            </div>
        </div>
  
        <div class="center">
          <button type="submit" class="btn-blue" id="Update">Update</button>
        </div>
      </form>
    </div>
  </div>
  