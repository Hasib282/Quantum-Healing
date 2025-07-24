<ul>
    {{-- Personal Details Part Starts --}}
    <li data-id="1.1">Personal Details</li>
    @foreach($personaldetail as $item)
        <div class="personal">
            <div class="details-head">
                <div class="image-round">
                    <img src="/storage/{{ $item->image !== null ? $item->image : ($item->gender == 'female' ? 'female.png' : 'male.png') }}" alt="" height="100px" width="100px">
                </div> 
                <div class="highlight">
                    <span class="name"> {{$item->name}} </span><br>
                </div>   
            </div>
            
            <div class="details-table">
                <div class="rows each-row">
                    <div class="c-2 bold">Name</div> 
                    <div class="c-4">{{ $item->name }}</div>
                    <div class="c-2 bold">Father's Name</div> 
                    <div class="c-4">@isset($item->fathers_name)
                                        {{ $item->fathers_name }}
                                    @else
                                        Father's Name unavailable
                                    @endisset</div>
                </div>
                <div class="rows each-row">
                    <div class="c-2 bold">Mother's Name</div> 
                    <div class="c-4">@isset($item->mothers_name)
                                        {{ $item->mothers_name }}
                                    @else
                                        Mother's Name unavailable
                                    @endisset</div>
                    <div class="c-2 bold">Date of Birth</div> 
                    <div class="c-4">{{ $item->date_of_birth }}</div>
                </div>
                <div class="rows each-row">
                    <div class="c-2 bold">Gender</div> 
                    <div class="c-4">{{ $item->gender }}</div>
                    <div class="c-2 bold">Religion</div> 
                    <div class="c-4">{{ $item->religion }}</div>
                </div>
                <div class="rows each-row">
                    <div class="c-2 bold">Marital Status</div> 
                    <div class="c-4">{{ $item->marital_status }}</div>
                    <div class="c-2 bold">Nationality</div> 
                    <div class="c-4">@isset($item->nationality)
                                        {{ $item->nationality }}
                                    @else
                                        Nationality unavailable
                                    @endisset</div>
                </div>
                <div class="rows each-row">
                <div class="c-2 bold">Nid No.</div> 
                    <div class="c-4">@isset($item->nid_no)
                                        {{ $item->nid_no }}
                                    @else
                                        Nid No. unavailable
                                    @endisset</div>
                    <div class="c-2 bold">Phone Number</div> 
                    <div class="c-4">{{ $item->phn_no }}</div>
                </div>
                <div class="rows each-row">
                    <div class="c-2 bold">Blood Group</div> 
                    <div class="c-4">@isset($item->blood_group)
                                        {{ $item->blood_group }}
                                    @else
                                        Blood Group unavailable
                                    @endisset</div>
                    <div class="c-2 bold">Email</div> 
                    <div class="c-4">{{ $item->email }}</div>
                </div>
                <div class="rows each-row">
                <div class="c-2 bold">Work Location</div> 
                    <div class="c-4">{{ $item->Location->upazila }}</div>
                    <div class="c-2 bold">Address</div> 
                    <div class="c-4">{{ $item->address }}</div>
                </div>
            </div>
        </div>
    @endforeach 


    {{-- Education Details part starts --}}
    
    @if($education != null)
        <li data-id="1.2">Education Details</li>
        @if($education->isNotEmpty())
            @foreach($education as $employees)
                <div class="education">
                    <div class="details-table">
                        <div class="rows each-row">
                            <div class="c-2 bold">Degree Title</div> 
                            <div class="c-4">{{ $employees->degree }}</div>
                            <div class="c-2 bold">Institution Name</div> 
                            <div class="c-4">{{ $employees->institution }}</div>
                        </div>
                        <div class="rows each-row">
                            <div class="c-2 bold">Group</div> 
                            <div class="c-4">
                                @isset($employees->group)
                                    {{ $employees->group }}
                                @else
                                    Group unavailable
                                @endisset
                            </div>
                            <div class="c-2 bold">Result</div> 
                            <div class="c-4">{{ $employees->result }}</div>
                        </div>
                        @if($employees->scale !== null)
                            <div class="rows each-row">
                                @if($employees->scale !== null)
                                    <div class="c-2 bold">Scale</div>
                                    <div class="c-4">{{ $employees->scale }}</div>
                                @endif
                                @if($employees->cgpa !== null)
                                    <div class="c-2 bold">CGPA</div>
                                    <div class="c-4">{{ $employees->cgpa }}</div>
                                @endif
                            </div>
                        @endif
                        <div class="rows each-row">
                            @if($employees->marks !== null)
                                <div class="c-2 bold">Marks</div>
                                <div class="c-4">{{ $employees->marks }}</div>
                            @endif
                            <div class="c-2 bold">Batch</div> 
                            <div class="c-4">{{ $employees->batch }}</div>         
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="education">
                <div class="details-table">
                    <div class="rows each-row"> 
                        <div>No Education Details Available!</div>
                    </div>
                </div>
            </div>
        @endif
    @endif


    {{-- Training Details part starts --}}
    
    @if($training != null)
        <li data-id="1.3">Training Details</li>
        @if($training->isNotEmpty())
            @foreach($training as $employees)
                <div class="training">
                    <div class="details-table">
                        <div class="rows each-row"> 
                            <div class="c-2 bold">Training Title</div>
                            <div class="c-4">{{$employees->training_title}}</div>
                            <div class="c-2 bold">Country</div>
                            <div class="c-4">@isset($employees->country)
                                                    {{ $employees->country }}
                                                @else
                                                    Country unavailable
                                                @endisset</div>
                        </div>
                        <div class="rows each-row"> 
                            <div class="c-2 bold">Topic</div>
                            <div class="c-4">{{$employees->topic}}</div>
                            <div class="c-2 bold">Institution Name</div>
                            <div class="c-4">{{$employees->institution_name}}</div>
                        </div>
                        <div class="rows each-row"> 
                            <div class="c-2 bold">Start Date</div>
                            <div class="c-4">@isset($employees->start_date)
                                                    {{ $employees->start_date }}
                                                @else
                                                    Start date unavailable
                                                @endisset</div>
                            <div class="c-2 bold">End Date</div>
                            <div class="c-4">@isset($employees->end_date)
                                                    {{ $employees->end_date }}
                                                @else
                                                    End date unavailable
                                                @endisset</div>
                        </div>
                        <div class="rows each-row"> 
                            <div class="c-2 bold">Training Year</div>
                            <div class="c-4">{{$employees->training_year}}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="training">
                <div class="details-table">
                    <div class="rows each-row"> 
                        <div>No Training Details Available!</div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    
    {{-- Experience Details part starts --}}
    
    @if($experience != null)
        <li data-id="1.4">Experience Details</li>
        @if($experience->isNotEmpty())
            @foreach($experience as $employees)
                <div class="experience">
                    <div class="details-table">
                        <div class="rows each-row"> 
                            <div class="c-2 bold">Company Name</div>
                            <div class="c-4">{{$employees->company_name}}</div>
                            <div class="c-2 bold">Designation</div>
                            <div class="c-4">{{$employees->designation}}</div>
                        </div>
                        <div class="rows each-row"> 
                            <div class="c-2 bold">Start Date</div>
                            <div class="c-4">@isset($employees->start_date)
                                                {{ $employees->start_date }}
                                            @else
                                                Start date unavailable
                                            @endisset</div>
                            <div class="c-2 bold">End Date</div>
                            <div class="c-4">@isset($employees->end_date)
                                                {{ $employees->end_date }}
                                            @else
                                                End date unavailable
                                            @endisset</div>
                        </div>
                        <div class="rows each-row"> 
                            <div class="c-2 bold">Department</div>
                            <div class="c-4">{{$employees->department}}</div>
                            <div class="c-2 bold">Company Location</div>
                            <div class="c-4">{{$employees->company_location}}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="experience">
                <div class="details-table">
                    <div class="rows each-row"> 
                        <div>No Experience Details Available!</div>
                    </div>
                </div>
            </div>
        @endif
    @endif


    {{-- Organization Details part starts --}}
    
    @if($organization != null)
        <li data-id="1.5">Organization Details</li>
        @if($organization->isNotEmpty())
            @foreach($organization as $item)
                <div class="organization">
                    <div class="details-table">
                        <div class="rows each-row">
                            <div class="c-2 bold">Joining Date</div> 
                            <div class="c-4">{{ $item->joining_date }}</div>
                            <div class="c-2 bold">Joining Location</div> 
                            <div class="c-4">{{ $item->Location->upazila }}</div>
                        </div>
                        <div class="rows each-row">
                            <div class="c-2 bold">Department</div> 
                            <div class="c-4">{{ $item->Department->name }}</div>
                            <div class="c-2 bold">Designation</div> 
                            <div class="c-4">{{ $item->Designation->designation }}</div>
                        </div>
                    </div>
                </div>    
            @endforeach
        @else
            <div class="organization">
                <div class="details-table">
                    <div class="rows each-row"> 
                        <div>No Organization Details Available!</div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    {{-- Payroll details part starts --}}
    @if($payroll != null)
        <li data-id="1.6">Payroll Details</li>
        @if($payroll->isNotEmpty())
            <div class="payroll">
                <table class="show-table">
                    <thead>
                        <tr>
                            <th>Income Description</th>
                            <th>Income Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payroll as $pay)
                            <tr>
                                <td>{{ $pay->Head->tran_head_name }}</td>
                                <td>{{ $pay->amount }} Tk.</td>
                            </tr>   
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="payroll">
                <div class="details-table">
                    <div class="rows each-row"> 
                        <div>No Payroll Details Available!</div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</ul>