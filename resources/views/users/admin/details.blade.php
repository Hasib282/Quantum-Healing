
<ul>
    {{-- General Info Part Starts --}}
    <li data-id="1">General Information</li>
    <div class="general">
        <div class="details-head">
            <div class="image-round">
                <img src="http://localhost:8001/storage/profiles/{{$admin->image !== null ? $admin->image : ($admin->gender == 'female' ? 'female.png' : 'male.png') }}" alt="" height="100px" width="100px">
            </div> 
            <div class="highlight">
                <span class="name"> {{$admin->user_name}} </span><br>
                {{-- <span class="designation"> {{$admin->designation->designation}} </span> --}}
            </div>   
        </div>
        <div class="details-table" style="">
            <div class="rows each-row"> 
                <div class="c-2 bold">Name</div>
                <div class="c-10">{{$admin->user_name}}</div>
            </div>
            <div class="rows each-row">
                <div class="c-2 bold">Email</div>
                <div class="c-10">{{$admin->user_email}}</div>
            </div>
            <div class="rows each-row">
                <div class="c-2 bold">Phone No</div>
                <div class="c-10">{{$admin->user_phone}}</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Gender</div>
                <div class="c-10">{{$admin->gender}}</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Location</div>
                <div class="c-10">{{$admin->loc_id ? $admin->location->upazila .', '. $admin->location->district .', '. $admin->location->division : ""}}</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Address</div>
                <div class="c-10">{{$admin->address}}</div>
            </div>
        </div>
    </div>
</ul>