<aside id="mySidenav" class="sidenav">
    {{-- <a href="{{ route('show.profile', auth()->user()->id) }}"> --}}
        <div class="user-details">
            <div class="user-image">
                <img src="{{ rtrim(config('app.api_url'), '/api') }}/storage/{{ auth()->user()->image != null ? auth()->user()->image : (auth()->user()->gender == 'female' ? 'female.png' : 'male.png') }}" alt="">
            </div>

            <div class="user-name">
                <strong>{{ auth()->user()->name }}</strong> <br>
                {{-- <strong style="color:#00aaffcf;">{{ auth()->user()->role->name }}</strong> --}}
             </div> 
        </div>
    {{-- </a> --}}
    <hr>
    <!-- Sidebar menue starts -->
    <ul class="sidebar-menu">
        {{-- @if(auth()->user()->hasPermissionMainHead('1')) --}}
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'admin' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-house"></i>
                        ADMINISTRATOR
                    </p>
                    <i class="fas fa-angle-right {{ Request::segment(1) == 'admin' ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'admin' ? 'show':''}}">
                    {{-- Users Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users"></i>
                                Users
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users') ? 'show':''}}">
                          @if(auth()->check() && auth()->user()->role == 1)
                                <li class="sub-menu1-item" data-url="{{ route('show.roles') }}">
                                    <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'roles') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-dice-six"></i>
                                            Roles
                                        </p>
                                    </div>
                                </li>
                            
                                <li class="sub-menu1-item" data-url="{{route('show.superAdmins')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'superadmins') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-secret"></i>
                                            Super Admin
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            {{-- @if(auth()->user()->hasPermission(1)) --}}
                                <li class="sub-menu1-item" data-url="{{route('show.admins')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'admins') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-tie"></i>
                                            Admin 
                                        </p>
                                    </div>
                                </li>
                            {{-- @endif --}}

                            <li class="sub-menu1-item" data-url="{{route('show.users')}}">
                                <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'user_info') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-user-tie"></i>
                                        User Informations
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Events Menu -->
                    <li class="sub-menu-item" data-url="{{route('show.event')}}">
                        <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'events') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-calendar-days"></i>
                                Events
                            </p>
                        </div>
                    </li>

                    <!-- Branches Menu -->
                    <li class="sub-menu-item" data-url="{{route('show.branch')}}">
                        <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'branches') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-code-branch"></i>
                                Branches
                            </p>
                        </div>
                    </li>
                    
                    <!-- Branches Menu -->
                    <li class="sub-menu-item" data-url="{{route('show.eventUsers')}}">
                        <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'event_users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-code-branch"></i>
                                Event Users Setup
                            </p>
                        </div>
                    </li>

                    <li class="sub-menu-item" data-url="{{ route('show.practiceEventUsers') }}">
                        <div class="menu-title {{ (Request::segment(2) == 'practice_event_users') ? 'active':'' }}">
                            <p>
                                <i class="fa-solid fa-code-branch"></i>
                                Practice Event Users Setup
                            </p>
                        </div>
                    </li>
                    


                     <!-- attendence  -->
                    <li class="sub-menu-item" data-url="{{route('show.attendance')}}" >
                        <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'attendance') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-code-branch"></i>
                                Attendance
                            </p>
                        </div>
                    </li>
                </ul>
            </li>
            <hr>
        {{-- @endif --}}
    </ul>
</aside>