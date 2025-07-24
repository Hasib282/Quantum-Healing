<header>
    <div class="company-details">
        <div class="company-logo">
            {{-- <img src="/images/male.png" alt=""> --}}
            <img src="{{ auth()->user()->company?->logo ? rtrim(env('API_URL'), '/api') . '/storage/' . auth()->user()->company->logo : '/images/tsbd.png' }}" alt="">
        </div>
        <div class="company-name">
            <h1>{{ auth()->user()->company ? auth()->user()->company->company_name : 'Team-Solutions-Bangladesh' }}</h1>
        </div>
    </div>
    @if (session('message'))
        <h6 style="text-align:center; margin-top:5px; color:#dc3545;">
            {{ session('message') }}
        </h6>
    @endif
    
    <!-- Navbar -->
    <div class="navbar-menu">
        @include('layouts.navbar')
    </div>
</header>