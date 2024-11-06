<style>
    .module_title {
        background-color: #00BE67 !important;
        text-align: center;
        font-size: 18px !important;
        font-weight: bold;
        font-style: italic;
        color: #fff !important;
    }

    .module_title span {
        font-size: 18px !important;
    }
</style>

@php
$module = session('module');
@endphp

@if ($module == 'dashboard' || $module == '')
<ul class="nav nav-list">
    <li class="active">
        <!-- module/dashboard -->
        <a href="{{ route('dashboard') }}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
        <b class="arrow"></b>
    </li>

    <li class="">
        <a href="{{ url('module/BookingModule') }}">
            <i class="menu-icon bi bi-bookmark-plus"></i>
            <span class="menu-text"> Booking Module </span>
        </a>
        <b class="arrow"></b>
    </li>

    <li class="">
        <a href="{{ url('module/ServiceModule') }}">
            <i class="menu-icon bi bi-person-workspace"></i>
            <span class="menu-text"> Service Module </span>
        </a>
        <b class="arrow"></b>
    </li>

    <!-- module/RestaurantModule -->
    <li class="">
        <a href="{{ url('module/RestaurantModule') }}">
            <i class="menu-icon bi bi-cup-hot"></i>
            <span class="menu-text"> Restaurant Module </span>
        </a>
        <b class="arrow"></b>
    </li>

    <li class="">
        <a href="{{ url('module/InventoryModule') }}">
            <i class="menu-icon bi bi-cart-plus" style="font-size: 20px;"></i>
            <span class="menu-text"> Inventory Module </span>
        </a>
        <b class="arrow"></b>
    </li>

    <li class="">
        <!--  -->
        <a href="{{ url('module/AccountsModule') }}">
            <i class="menu-icon fa fa-clipboard"></i>
            <span class="menu-text"> Accounts Module </span>
        </a>
        <b class="arrow"></b>
    </li>

    <li class="">
        <!-- module/HRPayroll -->
        <a href="{{ url('module/HRPayroll') }}">
            <i class="menu-icon bi bi-person-bounding-box"></i>
            <span class="menu-text"> HR & Payroll </span>
        </a>
        <b class="arrow"></b>
    </li>

    <li class="">
        <!-- module/ReportsModule -->
        <a href="{{ url('module/ReportsModule') }}">
            <i class="menu-icon bi bi-journal-bookmark"></i>
            <span class="menu-text"> Reports Module </span>
        </a>
        <b class="arrow"></b>
    </li>

    <li class="">
        <a href="{{ url('module/Administration') }}">
            <i class="menu-icon bi bi-gear"></i>
            <span class="menu-text"> Administration </span>
        </a>
        <b class="arrow"></b>
    </li>
    <li class="">
        <a href="{{ url('module/WebsiteModule') }}">
            <i class="menu-icon bi bi-globe"></i>
            <span class="menu-text"> Website Module </span>
        </a>
        <b class="arrow"></b>
    </li>

    @if (checkAccess('graph'))
    <li class="{{ Request::is('graph') ? 'active' : '' }}">
        <a href="/graph">
            <i class="menu-icon fa fa-bar-chart"></i>
            <span class="menu-text"> Business Monitor </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
</ul>
@elseif ($module == 'Administration')
@if (checkAccess('user') ||
checkAccess('customer') ||
checkAccess('supplier') ||
checkAccess('size') ||
checkAccess('color') ||
checkAccess('district') ||
checkAccess('brand') ||
checkAccess('category') ||
checkAccess('product') ||
checkAccess('sms') ||
checkAccess('productList') ||
checkAccess('productLedger') ||
checkAccess('damageEntry') ||
checkAccess('damageList'))
<ul class="nav nav-list">
    <li class="active">
        <a href="/module/dashboard">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
        <b class="arrow"></b>
    </li>
    <li>
        <a href="/module/Administration" class="module_title">
            <span>Administration</span>
        </a>
    </li>
    @if (checkAccess('sms'))
    <li class="{{ Request::is('send-sms') ? 'active' : '' }}">
        <a href="/send-sms">
            <i class="menu-icon bi bi-chat-dots-fill"></i>
            <span class="menu-text"> Send SMS </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('room') || checkAccess('roomList'))
    <li class="{{ Request::is('room') || Request::is('roomlist') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon bi bi-shop"></i>
            <span class="menu-text"> Room Info </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (checkAccess('room'))
            <li class="{{ Request::is('room') ? 'active' : '' }}">
                <a href="/room">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Room Entry
                </a>

                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('roomList'))
            <li class="{{ Request::is('roomlist') ? 'active' : '' }}">
                <a href="/roomlist">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Room List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if (checkAccess('supplier') || checkAccess('supplierList'))
    <li class="{{ Request::is('supplier') || Request::is('supplierlist') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon bi bi-person"></i>
            <span class="menu-text"> Supplier Info </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (checkAccess('supplier'))
            <li class="{{ Request::is('supplier') ? 'active' : '' }}">
                <a href="/supplier">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Supplier Entry
                </a>

                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('supplierList'))
            <li class="{{ Request::is('supplierlist') ? 'active' : '' }}">
                <a href="/supplierlist">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Supplier List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if (checkAccess('customer') || checkAccess('customerList'))
    <li class="{{ Request::is('customer') || Request::is('customerlist') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon bi bi-person"></i>
            <span class="menu-text"> Guest Info </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (checkAccess('customer'))
            <li class="{{ Request::is('customer') ? 'active' : '' }}">
                <a href="/customer">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Guest Entry
                </a>

                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('customerList'))
            <li class="{{ Request::is('customerlist') ? 'active' : '' }}">
                <a href="/customerlist">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Guest List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if (checkAccess('floor'))
    <li class="{{ Request::is('floor') ? 'active' : '' }}">
        <a href="/floor">
            <i class="menu-icon bi bi-building-add"></i>
            <span class="menu-text"> Floor Entry </span>
        </a>
    </li>
    @endif

    @if (checkAccess('roomType'))
    <li class="{{ Request::is('roomtype') ? 'active' : '' }}">
        <a href="/roomtype">
            <i class="menu-icon bi bi-shop"></i>
            <span class="menu-text"> Room Type </span>
        </a>
    </li>
    @endif

    @if (checkAccess('district'))
    <li class="{{ Request::is('district') ? 'active' : '' }}">
        <a href="/district">
            <i class="menu-icon bi bi-globe"></i>
            <span class="menu-text"> Area Entry </span>
        </a>
    </li>
    @endif

    @if (checkAccess('reference'))
    <li class="{{ Request::is('reference') ? 'active' : '' }}">
        <a href="/reference">
            <i class="menu-icon bi bi-people"></i>
            <span class="menu-text"> Reference Entry </span>
        </a>
    </li>
    @endif

    @if (checkAccess('user'))
    <li class="{{ Request::is('user') || Route::is('user.userAccess') ? 'active' : '' }}">
        <a href="/user">
            <i class="menu-icon fa fa-user-plus"></i>
            <span class="menu-text"> Create User </span>
        </a>
    </li>
    @endif
    <li class="{{ Request::is('user-activity') ? 'active' : '' }}">
        <a href="/user-activity">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> User Activity</span>
        </a>
    </li>

    @if (checkAccess('companyProfile'))
    <li class="{{ Request::is('company-profile') ? 'active' : '' }}">
        <a href="/company-profile">
            <i class="menu-icon fa fa-bank"></i>
            <span class="menu-text"> Company Profile </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
</ul>
@endif
@elseif ($module == 'WebsiteModule')
@if (checkAccess('management') ||
checkAccess('gallery'))
<ul class="nav nav-list">
    <li class="active">
        <a href="/module/dashboard">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
        <b class="arrow"></b>
    </li>
    <li>
        <a href="/module/WebsiteModule" class="module_title">
            <span>Website Module</span>
        </a>
    </li>
    @if (checkAccess('about'))
    <li class="{{ Request::is('about') ? 'active' : '' }}">
        <a href="/about">
            <i class="menu-icon bi bi-file-person"></i>
            <span class="menu-text"> About Page </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('slider'))
    <li class="{{ Request::is('slider') ? 'active' : '' }}">
        <a href="/slider">
            <i class="menu-icon fa fa-image"></i>
            <span class="menu-text"> Slider Entry </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    <li class="{{ Request::is('specialties.create') ? 'active' : '' }}">
        <a href="{{ route('specialties.create') }}">
            <i class="menu-icon fa fa-star"></i>
            <span class="menu-text"> Specialties Entry</span>
        </a>
        <b class="arrow"></b>
    </li>
    {{-- @if (checkAccess('management'))
    <li class="{{ Request::is('management') ? 'active' : '' }}">
        <a href="/management">
            <i class="menu-icon bi bi-people"></i>
            <span class="menu-text"> Management Entry </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif --}}
    @if (checkAccess('gallery'))
    <li class="{{ Request::is('gallery') ? 'active' : '' }}">
        <a href="/gallery">
            <i class="menu-icon bi bi-images"></i>
            <span class="menu-text"> Gallery Entry </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    {{-- @if (checkAccess('offer'))
    <li class="{{ Request::is('offer') ? 'active' : '' }}">
        <a href="/offer">
            <i class="menu-icon bi bi-clipboard"></i>
            <span class="menu-text"> Offer Entry </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif --}}
</ul>
@endif
@elseif($module == 'BookingModule')
@if (checkAccess('booking') ||
checkAccess('billinginvoice') ||
checkAccess('customerList') ||
checkAccess('customerPaymentHistory') ||
checkAccess('customerPaymentReport') ||
checkAccess('customerDue') ||
checkAccess('bookingRecord'))
<ul class="nav nav-list">
    <li class="active">
        <a href="/module/dashboard">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>

        <b class="arrow"></b>
    </li>
    <li>
        <a href="/module/BookingModule" class="module_title">
            <span> Booking Module </span>
        </a>
    </li>

    @if (checkAccess('booking'))
    <li class="{{ Route::is('booking.create') ? 'active' : '' }}">
        <a href="/booking">
            <i class="menu-icon bi bi-bookmarks"></i>
            <span class="menu-text"> Booking Entry </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    <!-- @if (checkAccess('checkin'))
    <li class="{{ Request::is('checkin') ? 'active' : '' }}">
        <a href="/checkin">
            <i class="menu-icon bi bi-check2-square"></i>
            <span class="menu-text"> CheckIn </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif -->

    @if (checkAccess('checkout'))
    <li class="{{ Request::is('checkout') ? 'active' : '' }}">
        <a href="/checkout">
            <i class="menu-icon bi bi-box-arrow-right"></i>
            <span class="menu-text"> Checkout </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('checkinRecord'))
    <li class="{{ Request::is('checkin-record') ? 'active' : '' }}">
        <a href="/checkin-record">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Checkin Record </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('bookingRecord'))
    <li class="{{ Request::is('booking-record') ? 'active' : '' }}">
        <a href="/booking-record">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Booking Record </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('billingRecord'))
    <li class="{{ Request::is('billing-record') ? 'active' : '' }}">
        <a href="/billing-record">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Billing Record </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('checkinList'))
    <li class="{{ Request::is('checkin-list') ? 'active' : '' }}">
        <a href="/checkin-list">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Checkin List </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('billingInvoice'))
    <li class="{{ Request::is('billing-invoice') ? 'active' : '' }}">
        <a href="/billing-invoice">
            <i class="menu-icon fa fa-file-text"></i>
            <span class="menu-text"> Billing Invoice </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    <!-- @if (
    checkAccess('customerList') ||
    checkAccess('customerPaymentHistory') ||
    checkAccess('customerPaymentReport') ||
    checkAccess('customerDue'))
    <li class="{{ Request::is('sale-invoice') || Request::is('customer-due') || Request::is('customer-ledger') || Request::is('customerlist') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon bi bi-file-text"></i>
            <span class="menu-text"> Report </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (checkAccess('saleInvoice'))
            <li class="{{ Request::is('sale-invoice') ? 'active' : '' }}">
                <a href="/sale-invoice">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Sales Invoice
                </a>
                <b class="arrow"></b>
            </li>
            @endif

            @if (checkAccess('customerDue'))
            <li class="{{ Request::is('customer-due') ? 'active' : '' }}">
                <a href="/customer-due">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Guest Due List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('customerPaymentReport'))
            <li class="{{ Request::is('customer-ledger') ? 'active' : '' }}">
                <a href="/customer-ledger">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Guest Ledger
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('customerList'))
            <li class="{{ Request::is('customerlist') ? 'active' : '' }}">
                <a href="/customerlist">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Guest List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif -->
</ul>
@endif
@elseif($module == 'PurchaseModule')
@if (checkAccess('purchase') ||
checkAccess('supplierPaymentReport') ||
checkAccess('purchaseReturnList') ||
checkAccess('purchaseReturnDetails') ||
checkAccess('reorderList') ||
checkAccess('supplierList') ||
checkAccess('purchaseInvoice') ||
checkAccess('purchaseReturn') ||
checkAccess('purchaseRecord') ||
checkAccess('assetsReport') ||
checkAccess('assetEntry') ||
checkAccess('supplierDue'))
<ul class="nav nav-list">
    <li class="active">
        <a href="/module/dashboard">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>

        <b class="arrow"></b>
    </li>
    <li>
        <a href="/module/PurchaseModule" class="module_title">
            <span> Purchase Module </span>
        </a>
    </li>
    @if (checkAccess('purchase'))
    <li class="{{ Route::is('purchase.create') ? 'active' : '' }}">
        <a href="/purchase">
            <i class="menu-icon fa fa-shopping-cart"></i>
            <span class="menu-text"> Purchase Entry </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('purchaseRecord'))
    <li class="{{ Request::is('purchase-record') ? 'active' : '' }}">
        <a href="/purchase-record">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text">Purchase Record</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('purchaseReturn'))
    <li class="{{ Route::is('purchase.purchaseReturn') ? 'active' : '' }}">
        <a href="/purchase-return">
            <i class="menu-icon fa fa-rotate-right"></i>
            <span class="menu-text"> Purchase Return </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('purchaseReturnList'))
    <li class="{{ Request::is('purchase-return-record') ? 'active' : '' }}">
        <a href="/purchase-return-record">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Return Record </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('assetEntry'))
    <li class="{{ Request::is('asset') ? 'active' : '' }}">
        <a href="/asset">
            <i class="menu-icon fa fa-shopping-cart"></i>
            <span class="menu-text"> Assets Entry </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('assetsReport') ||
    checkAccess('purchaseInvoice') ||
    checkAccess('supplierDue') ||
    checkAccess('supplierPaymentReport') ||
    checkAccess('supplierList') ||
    checkAccess('purchaseReturnDetails') ||
    checkAccess('reorderList'))
    <li class="{{ Request::is('assetlist') || Request::is('reorder-list') || Request::is('supplier-ledger') || Request::is('supplier-due') || Request::is('supplierlist') || Request::is('purchase-invoice') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Report </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (checkAccess('purchaseInvoice'))
            <li class="{{ Request::is('purchase-invoice') ? 'active' : '' }}">
                <a href="/purchase-invoice">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Purchase Invoice
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('assetsReport'))
            <li class="{{ Request::is('assetlist') ? 'active' : '' }}">
                <a href="/assetlist">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Assets Report
                </a>
                <b class="arrow"></b>
            </li>
            @endif

            @if (checkAccess('supplierDue'))
            <li class="{{ Request::is('supplier-due') ? 'active' : '' }}">
                <a href="/supplier-due">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Supplier Due Report
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('supplierPaymentReport'))
            <li class="{{ Request::is('supplier-ledger') ? 'active' : '' }}">
                <a href="/supplier-ledger">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Supplier Ledger
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('supplierList'))
            <li class="{{ Request::is('supplierlist') ? 'active' : '' }}">
                <a href="/supplierlist">
                    <i class="menu-icon fa fa-caret-right"></i>
                    <span class="menu-text"> Supplier List </span>
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('reorderList'))
            <li class="{{ Request::is('reorder-list') ? 'active' : '' }}">
                <a href="/reorder-list">
                    <i class="menu-icon fa fa-caret-right"></i>
                    <span class="menu-text"> Re-Order List </span>
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@endif
@elseif($module == 'AccountsModule')
@if (checkAccess('cashView') ||
checkAccess('TransactionReport') ||
checkAccess('dayBook') ||
checkAccess('balanceSheet') ||
checkAccess('balanceInOut') ||
checkAccess('cashStatement') ||
checkAccess('bankLedger') ||
checkAccess('bankTransactionReport') ||
checkAccess('cashLedger') ||
checkAccess('chequeEntry') ||
checkAccess('chequeList') ||
checkAccess('chequePaidList') ||
checkAccess('chequeDishoneredList') ||
checkAccess('chequeReminderList') ||
checkAccess('chequePendingList') ||
checkAccess('account') ||
checkAccess('bankAccounts') ||
checkAccess('investmentTransactions') ||
checkAccess('investmentAccounts') ||
checkAccess('investmentLedger') ||
checkAccess('investmentView') ||
checkAccess('investmentTransactionReport') ||
checkAccess('loanTransactions') ||
checkAccess('loanAccounts') ||
checkAccess('loanLedger') ||
checkAccess('loanTransactionReport') ||
checkAccess('loanView') ||
checkAccess('cashTransaction') ||
checkAccess('supplierPayment') ||
checkAccess('bankTransaction') ||
checkAccess('customerPayment'))
<ul class="nav nav-list">
    <li class="active">
        <a href="/module/dashboard">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>

        <b class="arrow"></b>
    </li>
    <li>
        <a href="/module/AccountsModule" class="module_title">
            <span> Account Module </span>
        </a>
    </li>
    @if (checkAccess('cashTransaction'))
    <li class="{{ Request::is('cash-transaction') ? 'active' : '' }}">
        <a href="{{ route('cash.transaction') }}">
            <i class="menu-icon bi bi-cash-stack"></i>
            <span class="menu-text"> Cash Transaction </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('bankTransaction'))
    <li class="{{ Request::is('bank-transaction') ? 'active' : '' }}">
        <a href="{{ route('bank.transaction') }}">
            <i class="menu-icon bi bi-bank"></i>
            <span class="menu-text"> Bank Transactions </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('customerPayment'))
    <li class="{{ Request::is('customer-payment') ? 'active' : '' }}">
        <a href="{{ route('customer.payment') }}">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text"> Guest Payment </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('supplierPayment'))
    <li class="{{ Request::is('supplier-payment') ? 'active' : '' }}">
        <a href="{{ route('supplier.payment') }}">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text"> Supplier Payment </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('cashView'))
    <li class="{{ Request::is('cash-view') ? 'active' : '' }}">
        <a href="/cash-view">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text">Cash View</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('loanTransactions') ||
    checkAccess('loanAccounts') ||
    checkAccess('loanLedger') ||
    checkAccess('loanTransactionReport') ||
    checkAccess('loanView'))
    <li class="{{ Request::is('loan-transaction') || Request::is('loan-account') || Request::is('loan-view') || Request::is('loan-transaction-report') || Request::is('loan-ledger') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Loan </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (checkAccess('loanTransactions'))
            <li class="{{ Request::is('loan-transaction') ? 'active' : '' }}">
                <a href="/loan-transaction">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Loan Transection
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('loanView'))
            <li class="{{ Request::is('loan-view') ? 'active' : '' }}">
                <a href="/loan-view">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Loan View
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if ('loanTransactionReport')
            <li class="{{ Request::is('loan-transaction-report') ? 'active' : '' }}">
                <a href="/loan-transaction-report">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Loan Transaction Report
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('loanLedger'))
            <li class="{{ Request::is('loan-ledger') ? 'active' : '' }}">
                <a href="/loan-ledger">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Loan Ledger
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('loanAccounts'))
            <li class="{{ Request::is('loan-account') ? 'active' : '' }}">
                <a href="/loan-account">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Loan Account
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif
    @if (checkAccess('investmentTransactions') ||
    checkAccess('investmentAccounts') ||
    checkAccess('investmentLedger') ||
    checkAccess('investmentView') ||
    checkAccess('investmentTransactionReport'))
    <li class="{{ Request::is('investment-account') || Request::is('investment-transaction') || Request::is('investment-ledger') || Request::is('investment-transaction-report') || Request::is('investment-view') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Investment </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (checkAccess('investmentTransactions'))
            <li class="{{ Request::is('investment-transaction') ? 'active' : '' }}">
                <a href="/investment-transaction">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Investment Transection
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('investmentView'))
            <li class="{{ Request::is('investment-view') ? 'active' : '' }}">
                <a href="/investment-view">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Investment View
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('investmentTransactionReport'))
            <li class="{{ Request::is('investment-transaction-report') ? 'active' : '' }}">
                <a href="/investment-transaction-report">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Invest. Trans. Report
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('investmentLedger'))
            <li class="{{ Request::is('investment-ledger') ? 'active' : '' }}">
                <a href="/investment-ledger">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Investment Ledger
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('investmentAccounts'))
            <li class="{{ Request::is('investment-account') ? 'active' : '' }}">
                <a href="/investment-account">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Investment Account
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif
    @if (checkAccess('account') || checkAccess('bankAccounts'))
    <li class="{{ Request::is('account') || Request::is('bank-account') ? 'open' : '' }}">
        <a href="" class="dropdown-toggle">
            <i class="menu-icon fa fa-bank"></i>
            <span class="menu-text"> Account Head </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (checkAccess('account'))
            <li class="{{ Request::is('account') ? 'active' : '' }}">
                <a href="{{ route('account.create') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Transaction Accounts
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('bankAccounts'))
            <li class="{{ Request::is('bank-account') ? 'active' : '' }}">
                <a href="{{ route('bank.account.create') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Bank Accounts
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif
    @if (checkAccess('TransactionReport') ||
    checkAccess('dayBook') ||
    checkAccess('balanceSheet') ||
    checkAccess('balanceInOut') ||
    checkAccess('cashStatement') ||
    checkAccess('bankLedger') ||
    checkAccess('bankTransactionReport') ||
    checkAccess('cashLedger'))
    <li class="{{ Request::is('cash-ledger') || Request::is('customer-payment-history') || Request::is('supplier-payment-history') || Request::is('daybook') || Request::is('cash-statement') || Request::is('balance-inout') || Request::is('balance-sheet') || Request::is('bank-ledger') || Request::is('cash-transaction-report') || Request::is('bank-transaction-record') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Reports </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (checkAccess('TransactionReport'))
            <li class="{{ Request::is('cash-transaction-report') ? 'active' : '' }}">
                <a href="{{ route('cash.transaction.report') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Cash Transaction Report
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('bankTransactionReport'))
            <li class="{{ Request::is('bank-transaction-record') ? 'active' : '' }}">
                <a href="{{ route('bank.transaction.record') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Bank Transaction Report
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('cashLedger'))
            <li class="{{ Request::is('cash-ledger') ? 'active' : '' }}">
                <a href="/cash-ledger">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Cash Ledger
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('bankLedger'))
            <li class="{{ Request::is('bank-ledger') ? 'active' : '' }}">
                <a href="/bank-ledger">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Bank Ledger
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('supplierPaymentReport'))
            <li class="{{ Request::is('supplier-payment-history') ? 'active' : '' }}">
                <a href="/supplier-payment-history">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Supplier Payment Report
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('customerPaymentReport'))
            <li class="{{ Request::is('customer-payment-history') ? 'active' : '' }}">
                <a href="/customer-payment-history">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Guest Payment Report
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('cashStatement'))
            <li class="{{ Request::is('cash-statement') ? 'active' : '' }}">
                <a href="/cash-statement">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Cash Statement
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('balanceSheet'))
            <li class="{{ Request::is('balance-sheet') ? 'active' : '' }}">
                <a href="/balance-sheet">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Balance Sheet
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('balanceInOut'))
            <li class="{{ Request::is('balance-inout') ? 'active' : '' }}">
                <a href="/balance-inout">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Balance In Out
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('dayBook'))
            <li class="{{ Request::is('daybook') ? 'active' : '' }}">
                <a href="/daybook">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Day Book
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@endif
@elseif($module == 'HRPayroll')
@if (checkAccess('employee') ||
checkAccess('designation') ||
checkAccess('department') ||
checkAccess('salaryPayment') ||
checkAccess('employeeList') ||
checkAccess('salaryRecord'))
<ul class="nav nav-list">
    <li class="active">
        <a href="/module/dashboard">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>

        <b class="arrow"></b>
    </li>
    <li>
        <a href="/module/HRPayroll" class="module_title">
            <span>HR & Payroll</span>
        </a>
    </li>
    @if (checkAccess('salaryPayment'))
    <li class="{{ Request::is('employee-salary') ? 'active' : '' }}">
        <a href="{{ route('employee.salary') }}">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text"> Salary Payment </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('salaryPaymentReport'))
    <li class="{{ Request::is('salaryRecord') ? 'active' : '' }}">
        <a href="{{ route('salary.record') }}">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text"> Payment Report </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('employee'))
    <li class="{{ Route::is('employee.create') ? 'active' : '' }}">
        <a href="{{ route('employee.create') }}">
            <i class="menu-icon fa fa-user-plus"></i>
            <span class="menu-text"> Add Employee </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('employeeList'))
    <li class="{{ Request::is('employee-list') ? 'active' : '' }}">
        <a href="{{ route('employee.list') }}">
            <i class="menu-icon fa fa-users"></i>
            <span class="menu-text"> Employee List </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('leaveType') || checkAccess('leaveEntry') || checkAccess('leaveRecord') )
    <li class="{{ Request::is('leave-type') || Request::is('leave') || Request::is('leave-record') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon bi bi-house-gear-fill"></i>
            <span class="menu-text"> Leave Info </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <b class="arrow"></b>
        <ul class="submenu">
            @if (checkAccess('leaveType'))
            <li class="{{ Request::is('leave-type') ? 'active' : '' }}">
                <a href="/leave-type">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Leave Type
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('leaveEntry'))
            <li class="{{ Request::is('leave') ? 'active' : '' }}">
                <a href="/leave">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Leave Entry
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('leaveRecord'))
            <li class="{{ Request::is('leave-record') ? 'active' : '' }}">
                <a href="/leave-record">
                    <i class="menu-icon fa fa-caret-right"></i>
                    <span class="menu-text">Leave Record</span>
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if (checkAccess('designation'))
    <li class="{{ Request::is('designation') ? 'active' : '' }}">
        <a href="/designation">
            <i class="menu-icon fa fa-binoculars"></i>
            <span class="menu-text"> Add Designation </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('department'))
    <li class="{{ Request::is('department') ? 'active' : '' }}">
        <a href="/department">
            <i class="menu-icon bi bi-building"></i>
            <span class="menu-text"> Add Department </span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
</ul>
@endif
@elseif($module == 'ReportsModule')
@if (checkAccess('purchaseReturnDetails') ||
checkAccess('purchaseReturnList') ||
checkAccess('supplierList') ||
checkAccess('supplierPaymentReport') ||
checkAccess('purchaseRecord') ||
checkAccess('purchaseInvoice') ||
checkAccess('supplierDue') ||
checkAccess('quotationRecord') ||
checkAccess('quotationInvoice') ||
checkAccess('customerList') ||
checkAccess('customerPaymentHistory') ||
checkAccess('customerPaymentReport') ||
checkAccess('customerDue') ||
checkAccess('bookingInvoice') ||
checkAccess('bookingRecord') ||
checkAccess('dayBook') ||
checkAccess('balanceSheet') ||
checkAccess('cashStatement') ||
checkAccess('bankLedger') ||
checkAccess('cashLedger') ||
checkAccess('TransactionReport') ||
checkAccess('bankTransactionReport') ||
checkAccess('employeeList') ||
checkAccess('salaryPaymentReport'))
<ul class="nav nav-list">
    <li class="active">
        <a href="/module/dashboard">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>

        <b class="arrow"></b>
    </li>
    <li>
        <a href="/module/ReportsModule" class="module_title">
            <span>Reports Module</span>
        </a>
    </li>
    @if (checkAccess('cashView'))
    <li class="{{ Request::is('cash-view') ? 'active' : '' }}">
        <a href="/cash-view">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text">Cash View</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('dayBook') ||
    checkAccess('balanceInOut') ||
    checkAccess('cashStatement') ||
    checkAccess('bankLedger') ||
    checkAccess('cashLedger') ||
    checkAccess('TransactionReport') ||
    checkAccess('bankTransactionReport'))
    <li class="{{ Request::is('cash-ledger') || Request::is('daybook') || Request::is('balance-inout') || Request::is('bank-ledger') || Request::is('cash-statement') || Request::is('cash-transaction-report') || Request::is('bank-transaction-record') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Accounts Report </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (checkAccess('TransactionReport'))
            <li class="{{ Request::is('cash-transaction-report') ? 'active' : '' }}">
                <a href="{{ route('cash.transaction.report') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Cash Transaction Report
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('bankTransactionReport'))
            <li class="{{ Request::is('bank-transaction-record') ? 'active' : '' }}">
                <a href="{{ route('bank.transaction.record') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Bank Transaction Report
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('cashLedger'))
            <li class="{{ Request::is('cash-ledger') ? 'active' : '' }}">
                <a href="/cash-ledger">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Cash Ledger
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('bankLedger'))
            <li class="{{ Request::is('bank-ledger') ? 'active' : '' }}">
                <a href="/bank-ledger">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Bank Ledger
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('cashStatement'))
            <li class="{{ Request::is('cash-statement') ? 'active' : '' }}">
                <a href="/cash-statement">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Cash Statement
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('balanceInOut'))
            <li class="{{ Request::is('balance-inout') ? 'active' : '' }}">
                <a href="/balance-inout">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Balance In Out
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('dayBook'))
            <li class="{{ Request::is('dayBook') ? 'active' : '' }}">
                <a href="/daybook">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Day Book
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif
    @if (checkAccess('employeeList') || checkAccess('salaryPaymentReport'))
    <li class="{{ Request::is('employee-list') || Request::is('salaryRecord') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Employee Report </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (checkAccess('employeeList'))
            <li class="{{ Request::is('employee-list') ? 'active' : '' }}">
                <a href="/employee-list">
                    <i class="menu-icon fa fa-caret-right"></i>
                    All Employee List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('salaryPaymentReport'))
            <li class="{{ Request::is('salaryRecord') ? 'active' : '' }}">
                <a href="/salaryRecord">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Salary Payment Report
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@endif
@elseif($module == 'RestaurantModule')
@if (checkAccess('order') || checkAccess('orderList') || checkAccess('menuCategory') || checkAccess('unit'))
<ul class="nav nav-list">
    <li class="active">
        <a href="/module/dashboard">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
        <b class="arrow"></b>
    </li>

    <li>
        <a href="/module/RestaurantModule" class="module_title">
            <span>Restaurant Module</span>
        </a>
    </li>

    @if (checkAccess('order'))
    <li class="{{ Route::is('order.create') ? 'active' : '' }}">
        <a href="/order">
            <i class="menu-icon bi bi-building-add"></i>
            <span class="menu-text">Order Entry</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('pendingOrder'))
    <li class="{{ Request::is('pendingOrder') ? 'active' : '' }}">
        <a href="/pendingOrder">
            <i class="menu-icon bi bi-card-checklist"></i>
            <span class="menu-text">Pending Order</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('orderList'))
    <li class="{{ Request::is('orderList') ? 'active' : '' }}">
        <a href="/orderList">
            <i class="menu-icon bi bi-card-checklist"></i>
            <span class="menu-text">Order List</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('menu') || checkAccess('menuList') || checkAccess('menuCategory') )
    <li class="{{ Request::is('menu') || Request::is('menuList') || Request::is('menu-category') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon bi bi-shop"></i>
            <span class="menu-text"> Menu Info </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <b class="arrow"></b>
        <ul class="submenu">
            @if (checkAccess('menu'))
            <li class="{{ Request::is('menu') ? 'active' : '' }}">
                <a href="/menu">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Menu Entry
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('menuList'))
            <li class="{{ Request::is('menuList') ? 'active' : '' }}">
                <a href="/menuList">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Menu List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('menuCategory'))
            <li class="{{ Request::is('menu-category') ? 'active' : '' }}">
                <a href="/menu-category">
                    <i class="menu-icon fa fa-caret-right"></i>
                    <span class="menu-text">Menu Category</span>
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if (checkAccess('material') || checkAccess('productionList') || checkAccess('materialPurchase') || checkAccess('materialPurchaseList') || checkAccess('materialStock'))
    <li class="{{ Request::is('material') || Request::is('productionList') || Route::is('material.purchase.create') || Request::is('materialPurchaseList') || Request::is('materialStock') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon bi bi-building-gear"></i>
            <span class="menu-text"> Production </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <b class="arrow"></b>
        <ul class="submenu">
            @if (checkAccess('productionList'))
            <li class="{{ Request::is('productionList') ? 'active' : '' }}">
                <a href="/productionList">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Production List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('materialPurchase'))
            <li class="{{ Route::is('material.purchase.create') ? 'active' : '' }}">
                <a href="/materialPurchase">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Material Purchase
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('materialPurchaseList'))
            <li class="{{ Request::is('materialPurchaseList') ? 'active' : '' }}">
                <a href="/materialPurchaseList">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Material Purchase List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('material'))
            <li class="{{ Request::is('material') ? 'active' : '' }}">
                <a href="/material">
                    <i class="menu-icon fa fa-caret-right"></i>
                    <span class="menu-text">Material Entry</span>
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('materialStock'))
            <li class="{{ Request::is('materialStock') ? 'active' : '' }}">
                <a href="/materialStock">
                    <i class="menu-icon fa fa-caret-right"></i>
                    <span class="menu-text">Material Stock</span>
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if (checkAccess('unit'))
    <li class="{{ Request::is('unit') ? 'active' : '' }}">
        <a href="/unit">
            <i class="menu-icon bi bi-unity"></i>
            <span class="menu-text">Unit Entry</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
</ul>
@endif
@elseif($module == 'InventoryModule')
@if (checkAccess('issue') || checkAccess('issueReturn') || checkAccess('issueRecord') || checkAccess('asset') || checkAccess('assetList'))
<ul class="nav nav-list">
    <li class="active">
        <a href="/module/dashboard">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
        <b class="arrow"></b>
    </li>

    <li>
        <a href="/module/InventoryModule" class="module_title">
            <span>Inventory Module</span>
        </a>
    </li>

    @if (checkAccess('issue'))
    <li class="{{ Request::is('issue') ? 'active' : '' }}">
        <a href="/issue">
            <i class="menu-icon bi bi-plus-square"></i>
            <span class="menu-text">Issue Entry</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('issueReturn'))
    <li class="{{ Request::is('issueReturn') ? 'active' : '' }}">
        <a href="/issueReturn">
            <i class="menu-icon fa fa-rotate-left"></i>
            <span class="menu-text">Issue Return</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    
    @if (checkAccess('issueList'))
    <li class="{{ Request::is('issueList') ? 'active' : '' }}">
        <a href="/issueList">
            <i class="menu-icon bi bi-card-checklist"></i>
            <span class="menu-text">Issue List</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    
    @if (checkAccess('issueReturnList'))
    <li class="{{ Request::is('issueReturnList') ? 'active' : '' }}">
        <a href="/issueReturnList">
            <i class="menu-icon bi bi-card-checklist"></i>
            <span class="menu-text">Issue Return List</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif

    @if (checkAccess('asset') || checkAccess('assetList'))
    <li class="{{ Request::is('asset') || Request::is('assetList') || Request::is('brand') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon bi bi-shop"></i>
            <span class="menu-text"> Asset Info </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <b class="arrow"></b>
        <ul class="submenu">
            @if (checkAccess('asset'))
            <li class="{{ Request::is('asset') ? 'active' : '' }}">
                <a href="/asset">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Asset Entry
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('assetList'))
            <li class="{{ Request::is('assetList') ? 'active' : '' }}">
                <a href="/assetList">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Asset List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('brand'))
            <li class="{{ Request::is('brand') ? 'active' : '' }}">
                <a href="/brand">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Brand Entry
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if (checkAccess('purchase') || checkAccess('purchaseList') || checkAccess('supplier'))
    <li class="{{ Route::is('purchase.create') || Request::is('purchaseList') || Request::is('supplier') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon bi bi-bag-plus"></i>
            <span class="menu-text"> Purchase Info </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <b class="arrow"></b>
        <ul class="submenu">
            @if (checkAccess('purchase'))
            <li class="{{ Route::is('purchase.create') ? 'active' : '' }}">
                <a href="/purchase">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Purchase Entry
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('purchaseList'))
            <li class="{{ Request::is('purchaseList') ? 'active' : '' }}">
                <a href="/purchaseList">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Purchase List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('supplier'))
            <li class="{{ Request::is('supplier') ? 'active' : '' }}">
                <a href="/supplier">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Supplier Entry
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if (checkAccess('disposal') || checkAccess('disposalList'))
    <li class="{{ Route::is('disposal.create') || Request::is('disposalList') ? 'open' : '' }}">
        <a href="/" class="dropdown-toggle">
            <i class="menu-icon bi bi-ban"></i>
            <span class="menu-text"> Disposal Info </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <b class="arrow"></b>
        <ul class="submenu">
            @if (checkAccess('disposal'))
            <li class="{{ Route::is('disposal.create') ? 'active' : '' }}">
                <a href="/disposal">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Disposal Entry
                </a>
                <b class="arrow"></b>
            </li>
            @endif
            @if (checkAccess('disposalList'))
            <li class="{{ Request::is('disposalList') ? 'active' : '' }}">
                <a href="/disposalList">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Disposal List
                </a>
                <b class="arrow"></b>
            </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@endif
@elseif($module == 'ServiceModule')
@if (checkAccess('serviceHead') || checkAccess('service') || checkAccess('serviceList'))
<ul class="nav nav-list">
    <li class="active">
        <a href="/module/dashboard">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
        <b class="arrow"></b>
    </li>

    <li>
        <a href="/module/ServiceModule" class="module_title">
            <span>Service Module</span>
        </a>
    </li>
    @if (checkAccess('serviceHead'))
    <li class="{{ Request::is('service-head') ? 'active' : '' }}">
        <a href="/service-head">
            <i class="menu-icon fa fa-server"></i>
            <span class="menu-text">Service Head</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('service'))
    <li class="{{ Request::is('service') ? 'active' : '' }}">
        <a href="/service">
            <i class="menu-icon bi bi-building-add"></i>
            <span class="menu-text">Service Entry</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
    @if (checkAccess('serviceList'))
    <li class="{{ Request::is('serviceList') ? 'active' : '' }}">
        <a href="/serviceList">
            <i class="menu-icon bi bi-card-checklist"></i>
            <span class="menu-text">Service List</span>
        </a>
        <b class="arrow"></b>
    </li>
    @endif
</ul>
@endif
@endif