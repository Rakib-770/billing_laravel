<div class="row mySidebarClass">
    <div class="col-2">
        <div class="sidenav">
            <div class="dropdown-btn">
                <a class="" href="{{ route('home') }}">
                    <img class="my-icon" src="/images/dashboard.png" alt="">&nbsp;&nbsp; Dashboard
                </a>
            </div>
            <button class="dropdown-btn" >
                <img class="my-icon" src="/images/acc-management.png" alt="">&nbsp;&nbsp; Account Management
            </button>
            <div class="dropdown-container">
                <a onclick="someOnClick()" class="" href="{{ route('client-list') }}">Client List</a>
                <a onclick="someOnClick()" class="" href="{{ route('client-configuration') }}">Client Configuration</a>
            </div>

            <button class="dropdown-btn">
                <img class="my-icon" src="/images/services.png" alt="">&nbsp;&nbsp; Service Management
            </button>

            <div class="dropdown-container">
                <a class="" href="{{ route('service-name') }}">Service List</a>
                <a class="" href="{{ route('client-management') }}">Service Configuration</a>
                <a class="" href="{{ route('package-service-configuration') }}">Package Service Config</a>
                <a class="" href="{{ route('view-service-management') }}">View Configuration</a>
            </div>

            <button class="dropdown-btn">
                <img class="my-icon" src="/images/billing.png" alt="">&nbsp;&nbsp; Billing
            </button>

            <div class="dropdown-container" id="myDropdown">
                <a class="" href="{{ route('invoice-generation') }}">Invoice Generation</a>
                <a class="" href="{{ route('adhoc-invoice-generation') }}">Adhoc Inv Generation</a>
                <a class="" href="{{ route('invoice-index') }}">Invoice Index</a>
            </div>

            <button class="dropdown-btn">
                <img class="my-icon" src="/images/report.png" alt="">&nbsp;&nbsp; Reports
            </button>

            <div class="dropdown-container" id="myDropdown">
                <a class="" href="{{ route('invoice-details-mcloud') }}">Invoice Details</a>
            </div>
        </div>
    </div>

    <main class="col-6" style="margin-right: 30px">
        @yield('maincontent')
    </main>

</div>