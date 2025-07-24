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
                {{-- type --}}
                @if ($name != "Admin" && $name != "Super Admin" && $name != "Sales Representative" && $name != "Marketing Head")
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="type">{{ $name }} Type <span class="required" title="Required">*</span></label>
                            <select name="type" id="type">
                                {{-- options will be display dynamically --}}
                            </select>
                            <span class="error" id="type_error"></span>
                        </div>
                    </div>
                @endif
                {{-- name --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="name">{{ $name }} Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="name" class="form-input" id="name">
                        <span class="error" id="name_error"></span>
                    </div>
                </div>
                {{-- email  --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="email">Email <span class="required" title="Required">*</span></label>
                        <input type="text" name="email" class="form-input" id="email">
                        <span class="error" id="email_error"></span>
                    </div>
                </div>
                {{-- phone --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="phone">Phone <span class="required" title="Required">*</span></label>
                        <input type="text" name="phone" class="form-input" id="phone">
                        <span class="error" id="phone_error"></span>
                    </div>
                </div>

                @if ($name != "Super Admin" && $name != "Admin")
                    {{-- gender --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="gender">Gender <span class="required" title="Required">*</span></label>
                            <select name="gender" id="gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                            </select>
                            <span class="error" id="gender_error"></span>
                        </div>
                    </div>
                    {{-- division --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="division">Division <span class="required" title="Required">*</span></label>
                            <select name="division" id="division">
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
                            <span class="error" id="division_error"></span>
                        </div>
                    </div>
                    {{-- location --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="location">Location <span class="required" title="Required">*</span></label>
                            <input type="text" name="location" class="form-input" id="location" autocomplete="off"><hr>
                            <div id="location-list"></div>
                            <span class="error" id="location_error"></span>
                        </div>
                    </div>
                    {{-- address  --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-input" id="address">
                            <span class="error" id="address_error"></span>
                        </div>
                    </div>
                @endif

                @if ($name != "Client" && $name != "Supplier" && $name != "Sales Representative" && $name != "Marketing Head")
                    {{-- password  --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for = "password">Password <span class="required" title="Required">*</span></label>
                            <input type="password" name="password" id="password" class="form-input">
                            <span class="error" id="password_error"></span>
                        </div>
                    </div>
                    {{-- confirm Password  --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for = "password_confirmation">Confirm Password <span class="required" title="Required">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
                            <span class="error" id="password_confirmation_error"></span>
                        </div>
                    </div>
                @endif
                {{-- image --}}
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-input">
                        <span class="error" id="image_error"></span>
                        <img src="/images/male.png" alt="Selected Image" id="previewImage"
                            style="width:150px; height:150px;">
                    </div>
                </div>

                @if ($name == "Admin") 
                    {{-- store --}}
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="store">Store <span class="required" title="Required">*</span></label>
                            <select name="store" id="store">

                            </select>
                            <span class="error" id="store_error"></span>
                        </div>
                    </div>
                @endif
                
                @if ($name == "Admin")
                    {{-- company --}}
                    @if (auth()->user()->user_role == 1)
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="company">Company <span class="required" title="Required">*</span></label>
                                <input type="text" name="company" class="form-input" id="company" autocomplete="off"><hr>
                                <div id="company-list"></div>
                                <span class="error" id="company_error"></span>
                            </div>
                        </div>
                    @else
                        <div class="c-4">
                            <input type="text" name="company" class="form-input" id="company" data-id="{{auth()->user()->company_id}}" style="display: none">
                        </div>
                    @endif
                @endif
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>