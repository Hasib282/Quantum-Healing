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

        <div class="rows">
  
          {{-- ID --}}
          <input type="hidden" name="id" id="id">
  
          {{-- SL --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_sl">Serial (SL) <span class="required">*</span></label>
            <input type="number" name="update_sl" id="update_sl" class="form-input">
            <span class="error" id="update_sl_error"></span>
          </div></div>
  
          {{-- QR URL --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_qr_url">QR URL</label>
            <input type="text" name="update_qr_url" id="update_qr_url" class="form-input">
            <span class="error" id="update_qr_url_error"></span>
          </div></div>
  
          {{-- UID --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_u_id">UID</label>
            <input type="text" name="update_u_id" id="update_u_id" class="form-input">
            <span class="error" id="update_u_id_error"></span>
          </div></div>
  
          {{-- Registration No --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_reg_no">Registration No <span class="required">*</span></label>
            <input type="text" name="update_reg_no" id="update_reg_no" class="form-input">
            <span class="error" id="update_reg_no_error"></span>
          </div></div>
  
          {{-- Name --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_name">Name <span class="required">*</span></label>
            <input type="text" name="update_name" id="update_name" class="form-input">
            <span class="error" id="update_name_error"></span>
          </div></div>
  
          {{-- Phone --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_phone">Phone</label>
            <input type="text" name="update_phone" id="update_phone" class="form-input">
            <span class="error" id="update_phone_error"></span>
          </div></div>
  
          {{-- Duplicate --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_duplicate">Duplicate</label>
            <input type="text" name="update_duplicate" id="update_duplicate" class="form-input">
            <span class="error" id="update_duplicate_error"></span>
          </div></div>
  
          {{-- Gender --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_gender">Gender <span class="required">*</span></label>
            <select name="update_gender" id="update_gender" class="form-input">
              <option value="">Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Others">Others</option>
            </select>
            <span class="error" id="update_gender_error"></span>
          </div></div>
  
          {{-- Age --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_age">Age</label>
            <input type="number" name="update_age" id="update_age" class="form-input">
            <span class="error" id="update_age_error"></span>
          </div></div>
  
          {{-- Date of Birth --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_dob">Date of Birth</label>
            <input type="date" name="update_dob" id="update_dob" class="form-input">
            <span class="error" id="update_dob_error"></span>
          </div></div>
  
          {{-- Occupation --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_occupation">Occupation</label>
            <input type="text" name="update_occupation" id="update_occupation" class="form-input">
            <span class="error" id="update_occupation_error"></span>
          </div></div>
  
          {{-- QT Status --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_qt_status">QT Status <span class="required">*</span></label>
            <select name="update_qt_status" id="update_qt_status" class="form-input">
              <option value="">Select Status</option>
              <option value="graduate">Graduate</option>
              <option value="pro-master">Pro‑Master</option>
            </select>
            <span class="error" id="update_qt_status_error"></span>
          </div></div>
  
          {{-- Quantum --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_quantum">Quantum</label>
            <input type="text" name="update_quantum" id="update_quantum" class="form-input">
            <span class="error" id="update_quantum_error"></span>
          </div></div>
  
          {{-- Quantier --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_quantier">Quantier</label>
            <input type="text" name="update_quantier" id="update_quantier" class="form-input">
            <span class="error" id="update_quantier_error"></span>
          </div></div>
  
          {{-- Ardentier --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_ardentier">Ardentier</label>
            <input type="text" name="update_ardentier" id="update_ardentier" class="form-input">
            <span class="error" id="update_ardentier_error"></span>
          </div></div>
  
          {{-- Branch --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_branch">Branch</label>
            <select name="update_branch" id="update_branch" class="form-input">
              <option value="">Select Branch</option>
            </select>
            <span class="update_branch_error" id="update_branch_error"></span>
          </div></div>
  
          {{-- Job Status --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_job_status">Job Status</label>
            <input type="text" name="update_job_status" id="update_job_status" class="form-input">
            <span class="error" id="update_job_status_error"></span>
          </div></div>
  
          {{-- Psyche Certificate --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_psyche_certificate">Psyche Certificate</label>
            <input type="text" name="update_psyche_certificate" id="update_psyche_certificate" class="form-input">
            <span class="error" id="update_psyche_certificate_error"></span>
          </div></div>
  
          {{-- SP --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_sp">SP</label>
            <input type="text" name="update_sp" id="update_sp" class="form-input">
            <span class="error" id="update_sp_error"></span>
          </div></div>
  
          {{-- Group --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_group">Group</label>
            <input type="text" name="update_group" id="update_group" class="form-input">
            <span class="error" id="update_group_error"></span>
          </div></div>
  
          {{-- Call --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_call">Call</label>
            <input type="text" name="update_call" id="update_call" class="form-input">
            <span class="error" id="update_call_error"></span>
          </div></div>
  
          {{-- SMS --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_sms">SMS</label>
            <input type="text" name="update_sms" id="update_sms" class="form-input">
            <span class="error" id="update_sms_error"></span>
          </div></div>
  
          {{-- Color --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_color">Color</label>
            <input type="text" name="update_color" id="update_color" class="form-input">
            <span class="error" id="update_color_error"></span>
          </div></div>
  
          {{-- Barcode --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_barcode">Barcode</label>
            <input type="text" name="update_barcode" id="update_barcode" class="form-input">
            <span class="error" id="update_barcode_error"></span>
          </div></div>
  
          {{-- New Barcode --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_new_barcode">New Barcode</label>
            <input type="text" name="new_barcode" id="update_new_barcode" class="form-input">
            <span class="error" id="update_new_barcode_error"></span>
          </div></div>
  
          {{-- New Barcode SL --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_new_barcode_sl">New Barcode SL</label>
            <input type="text" name="update_new_barcode_sl" id="update_new_barcode_sl" class="form-input">
            <span class="error" id="update_new_barcode_sl_error"></span>
          </div></div>
  
          {{-- Barcode Delivery --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_barcode_delivery">Barcode Delivery</label>
            <input type="date" name="update_barcode_delivery" id="update_barcode_delivery" class="form-input">
            <span class="error" id="update_barcode_delivery_error"></span>
          </div></div>
  
          {{-- First Attend --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_first_attend">First Attend</label>
            <input type="date" name="update_first_attend" id="update_first_attend" class="form-input">
            <span class="error" id="update_first_attend_error"></span>
          </div></div>
  
          {{-- Last Attend --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_last_attend">Last Attend</label>
            <input type="date" name="update_last_attend" id="update_last_attend" class="form-input">
            <span class="error" id="update_last_attend_error"></span>
          </div></div>
  
          {{-- Status --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_status">Status</label>
            <select name="update_status" id="update_status" class="form-input">
              <option value="">Select</option>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
            <span class="error" id="update_status_error"></span>
          </div></div>
  
          {{-- Image --}}
          <div class="c-4"><div class="form-input-group">
            <label for="update_image">Image</label>
            <input type="file" name="update_image" id="update_image" class="form-input">
            <span class="error" id="update_image_error"></span>
            <img src="/images/male.png" id="updatePreviewImage" alt="Preview" style="width:150px;height:150px;margin-top:5px;">
          </div></div>
  
        </div>
  
        <div class="center">
          <button type="submit" class="btn-blue" id="Update">Update</button>
        </div>
      </form>
    </div>
  </div>
  