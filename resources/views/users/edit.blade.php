<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="rows">
                {{-- id  --}}
                <input type="hidden" name="id" id="id">
                @if ($name != "Admin" && $name != "Super Admin" && $name != "Sales Representative" && $name != "SR")
                    {{-- type --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateType">{{ $name }} Type <span class="required" title="Required">*</span></label>
                            <select name="type" id="updateType">
                                {{-- options will be display dynamically --}}
                            </select>
                            <span class="error" id="update_type_error"></span>
                        </div>
                    </div>
                @endif
                {{-- name --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateName">{{ $name }} Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="name" class="form-input" id="updateName">
                        <span class="error" id="update_name_error"></span>
                    </div>
                </div>
                {{-- email  --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateEmail">Email <span class="required" title="Required">*</span></label>
                        <input type="text" name="email" class="form-input" id="updateEmail">
                        <span class="error" id="update_email_error"></span>
                    </div>
                </div>
                {{-- phone  --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updatePhone">Phone <span class="required" title="Required">*</span></label>
                        <input type="text" name="phone" class="form-input" id="updatePhone">
                        <span class="error" id="update_phone_error"></span>
                    </div>
                </div>

                @if ($name != "Super Admin" && $name != "Admin")
                    {{-- gender --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateGender">Gender <span class="required" title="Required">*</span></label>
                            <select name="gender" id="updateGender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                            </select>
                            <span class="error" id="update_gender_error"></span>
                        </div>
                    </div>
                    {{-- division --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateDivision">Division <span class="required" title="Required">*</span></label>
                            <select name="division" id="updateDivision">
                                <option value="">Select Division</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Chittagong">Chittagong</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Barisal">Barisal</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Mymensingh">Mymensingh</option>
                            </select>
                            <span class="error" id="update_division_error"></span>
                        </div>
                    </div>
                    {{-- location --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateLocation">Location <span class="required" title="Required">*</span></label>
                            <input type="text" name="location" class="form-input" id="updateLocation" autocomplete="off"><hr>
                            <div id="update-location"></div>
                            <span class="error" id="update_location_error"></span>
                        </div>
                    </div>
                    {{-- address  --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateAddress">Address</label>
                            <input type="text" name="address" class="form-input" id="updateAddress">
                            <span class="error" id="update_address_error"></span>
                        </div>
                    </div>
                @endif
                {{-- image --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateImage">Image</label>
                        <input type="file" name="image" class="form-input" id="updateImage">
                        <span class="error" id="update_image_error"></span>
                        <img src="/images/male.png" alt="Selected Image" id="updatePreviewImage"
                            style="width:200px; height:200px;">
                    </div>
                </div>
            </div>
            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>