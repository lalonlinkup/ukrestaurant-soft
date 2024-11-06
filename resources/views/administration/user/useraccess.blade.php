@extends('master')
@section('title', 'User Entry')
@section('breadcrumb_title', 'User Entry')
@push('style')
<style scoped>
    ul {
        list-style: none;
    }

    label {
        margin-left: 4px;
        cursor: pointer;
    }

    input[type='checkbox'] {
        cursor: pointer;
    }
</style>
@endpush
@section('content')
<div id="userAccessPage">
    <form @submit.prevent="addUserAccess">
        <div class="row" style="margin-bottom: 5px;">
            <div class="col-md-12">
                <div class="card" style="padding: 5px;">
                    <div class="card-body" style="display: flex;justify-content:space-between;align-items:center;">
                        <div>
                            <p style="margin: 0;"><b>Username:</b> <span class="badge badge-success">{{$user->name}}</span></p>
                        </div>
                        <div>
                            <h4 style="margin:0;margin-bottom:5px; border-bottom:1px solid gray;">Take Action Button</h4>
                            <div style="margin: 0;display:flex;align-items:center;gap:10px;">
                                @php
                                $useractionbtn = explode(",", $user->action);
                                @endphp
                                <p>
                                    <input type="checkbox" name="action[]" id="e" value="e" {{in_array('e', $useractionbtn) ? 'checked': ''}}>
                                    <label for="e" style="margin: 0;">Entry</label>
                                </p>
                                <p>
                                    <input type="checkbox" name="action[]" id="u" value="u" {{in_array('u', $useractionbtn) ? 'checked': ''}}>
                                    <label for="u" style="margin: 0;">Update</label>
                                </p>
                                <p>
                                    <input type="checkbox" name="action[]" id="d" value="d" {{in_array('d', $useractionbtn) ? 'checked': ''}}>
                                    <label for="d" style="margin: 0;">Delete</label>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">User Access</legend>
            <div class="control-group">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-12">
                        <input type="checkbox" @click="checkAll" id="selectAll"> <label for="selectAll"><strong style="font-size: 16px;">Select All</strong></label>
                    </div>
                </div>
                <div class="row" id="accessRow">
                    <div class="col-md-3">
                        <div class="group">
                            <input type="checkbox" id="bookings" class="group-head" @click="onClickGroupHeads"> <label for="bookings"><strong>Booking</strong></label>
                            <ul class="bookings">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookings" value="booking" id="booking"> <label for="booking">Booking Entry</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookings" value="checkout" id="checkout"> <label for="checkout">Checkout</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookings" value="bookingRecord" id="bookingRecord"> <label for="bookingRecord">Booking Record</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookings" value="checkinRecord" id="checkinRecord"> <label for="checkinRecord">Checkin Record</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookings" value="billingRecord" id="billingRecord"> <label for="billingRecord">Billing Record</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookings" value="checkinList" id="checkinList"> <label for="checkinList">Checkin List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookings" value="billingInvoice" id="billingInvoice"> <label for="billingInvoice">Billing Invoice</label></li>
                            </ul>
                        </div>

                        <div class="group">
                            <input type="checkbox" id="accounts" class="group-head" @click="onClickGroupHeads"> <label for="accounts"><strong>Accounts</strong></label>
                            <ul class="accounts">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="cashTransaction" id="cashTransaction"><label for="cashTransaction"> Cash Transactions</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="bankTransaction" id="bankTransaction"><label for="bankTransaction"> Bank Transactions</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="customerPayment" id="customerPayment"><label for="customerPayment"> Guest Payment</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="supplierPayment" id="supplierPayment"><label for="supplierPayment"> Supplier Payment</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="cashView" id="cashView"><label for="cashView"> Cash View</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="account" id="account"><label for="account"> Transaction Accounts</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="bankAccounts" id="bankAccounts"><label for="bankAccounts"> Bank Accounts</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="chequeEntry" id="chequeEntry"><label for="chequeEntry"> New Cheque Entry</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="chequeList" id="chequeList"><label for="chequeList"> Cheque List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="chequeReminderList" id="chequeReminderList"><label for="chequeReminderList"> Reminder Cheque List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="chequePendingList" id="chequePendingList"><label for="chequePendingList"> Pending Cheque List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="chequeDishoneredList" id="chequeDishoneredList"><label for="chequeDishoneredList"> Dishonered Cheque List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accounts" value="chequePaidList" id="chequePaidList"><label for="chequePaidList"> Paid Cheque List</label></li>
                            </ul>
                        </div>

                        <!-- Issue -->
                        <div class="group">
                            <input type="checkbox" id="issues" class="group-head" @click="onClickGroupHeads"> <label for="issues"><strong>Issue Module</strong></label>
                            <ul class="issues">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="issues" value="issue" id="issue"><label for="issue"> Issue Entry</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="issues" value="issueList" id="issueList"><label for="issueList"> Issue List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="issues" value="issueInvoice" id="issueInvoice"><label for="issueInvoice"> Issue Invoice </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="issues" value="asset" id="asset"><label for="asset"> Asset Entry </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="issues" value="assetList" id="assetList"><label for="assetList"> Asset List </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="issues" value="brand" id="brand"><label for="brand"> Brand Entry </label></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="group">
                            <input type="checkbox" id="bookingReports" class="group-head" @click="onClickGroupHeads"> <label for="bookingReports"><strong>Booking Reports</strong></label>
                            <ul class="bookingReports">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookingReports" value="customerDue" id="customerDue"><label for="customerDue"> Guest Due List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookingReports" value="customerPaymentReport" id="customerPaymentReport"><label for="customerPaymentReport"> Guest Payment Report</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookingReports" value="customerPaymentHistory" id="customerPaymentHistory"><label for="customerPaymentHistory"> Guest Payment History</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookingReports" value="customerList" id="customerList"><label for="customerList"> Guest List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookingReports" value="priceList" id="priceList"><label for="priceList"> Product Price List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="bookingReports" value="quotationRecord" id="quotationRecord"><label for="quotationRecord"> Quotation Record</label></li>
                            </ul>
                        </div>

                        <div class="group">
                            <input type="checkbox" id="accountsReports" class="group-head" @click="onClickGroupHeads"><label for="accountsReports"><strong>Accounts Reports</strong></label>
                            <ul class="accountsReports">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accountsReports" value="TransactionReport" id="TransactionReport"> <label for="TransactionReport"> Cash Transaction Report</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accountsReports" value="bankTransactionReport" id="bankTransactionReport"> <label for="bankTransactionReport"> Bank Transaction Report</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accountsReports" value="cashLedger" id="cashLedger"> <label for="cashLedger"> Cash Ledger</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accountsReports" value="bankLedger" id="bankLedger"> <label for="bankLedger"> Bank Ledger</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accountsReports" value="cashStatement" id="cashStatement"> <label for="cashStatement"> Cash Statement</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accountsReports" value="balanceSheet" id="balanceSheet"> <label for="balanceSheet"> Balance Sheet</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accountsReports" value="balanceInOut" id="balanceInOut"> <label for="balanceInOut"> Balance InOut</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="accountsReports" value="dayBook" id="dayBook"> <label for="dayBook"> Day Book</label></li>
                            </ul>
                        </div>
                        <div class="group">
                            <input type="checkbox" id="loan" class="group-head" @click="onClickGroupHeads"> <label for="loan"><strong>Loan</strong></label>
                            <ul class="loan">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="loan" value="loanTransactions" id="loanTransactions"><label for="loanTransactions"> Loan Transection</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="loan" value="loanView" id="loanView"><label for="loanView"> Loan View</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="loan" value="loanTransactionReport" id="loanTransactionReport"><label for="loanTransactionReport"> Loan Transaction Report</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="loan" value="loanLedger" id="loanLedger"><label for="loanLedger"> Loan Ledger</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="loan" value="loanAccounts" id="loanAccounts"><label for="loanAccounts"> Loan Account</label></li>
                            </ul>
                        </div>

                        <div class="group">
                            <input type="checkbox" id="investment" class="group-head" @click="onClickGroupHeads"> <label for="investment"><strong>Investment</strong></label>
                            <ul class="investment">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="investment" value="investmentTransactions" id="investmentTransactions"><label for="investmentTransactions"> Investment Transection</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="investment" value="investmentView" id="investmentView"><label for="investmentView"> Investment View</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="investment" value="investmentTransactionReport" id="investmentTransactionReport"><label for="investmentTransactionReport"> Investment Transaction Report</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="investment" value="investmentLedger" id="investmentLedger"><label for="investmentLedger"> Investment Ledger</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="investment" value="investmentAccounts" id="investmentAccounts"><label for="investmentAccounts"> Investment Account</label></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="group">
                            <input type="checkbox" id="purchases" class="group-head" @click="onClickGroupHeads"> <label for="purchases"><strong>Purchase</strong></label>
                            <ul class="purchases">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="purchases" value="purchase" id="purchase"><label for="purchase"> Purchase Entry</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="purchases" value="purchaseRecord" id="purchaseRecord"><label for="purchaseRecord"> Purchase Record</label></li>
                            </ul>
                        </div>
                        <div class="group">
                            <input type="checkbox" id="services" class="group-head" @click="onClickGroupHeads"> <label for="services"><strong>Service</strong></label>
                            <ul class="services">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="services" value="serviceHead" id="serviceHead"><label for="serviceHead"> Service Head</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="services" value="service" id="service"><label for="service"> Service Entry</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="services" value="serviceList" id="serviceList"><label for="serviceList"> Service List</label></li>
                            </ul>
                        </div>
                        <div class="group">
                            <input type="checkbox" id="orders" class="group-head" @click="onClickGroupHeads"> <label for="orders"><strong>Order</strong></label>
                            <ul class="orders">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="order" id="order"><label for="order"> Order Entry</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="payFirst" id="payFirst"><label for="payFirst"> Pay First</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="orderList" id="orderList"><label for="orderList"> Order List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="pendingOrder" id="pendingOrder"><label for="pendingOrder"> Pending Order</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="orderInvoice" id="orderInvoice"><label for="orderInvoice"> Order Invoice</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="menu" id="menu"><label for="menu"> Menu Entry</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="menuList" id="menuList"><label for="menuList"> Menu List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="menuCategory" id="menuCategory"><label for="menuCategory"> Menu Category</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="material" id="material"><label for="material"> Material Entry</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="productionList" id="productionList"><label for="productionList"> Production List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="materialStock" id="materialStock"><label for="materialStock"> Material Stock</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="materialPurchaseList" id="materialPurchaseList"><label for="materialPurchaseList"> Material Purchase List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="materialPurchase" id="materialPurchase"><label for="materialPurchase"> Material Purchase</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="orders" value="materialPurchaseInvoice" id="materialPurchaseInvoice"><label for="materialPurchaseInvoice"> Material Purchase Invoice</label></li>
                            </ul>
                        </div>
                        <div class="group">
                            <input type="checkbox" id="hrPayroll" class="group-head" @click="onClickGroupHeads"> <label for="hrPayroll"><strong>HR & Payroll</strong></label>
                            <ul class="hrPayroll">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="hrPayroll" value="salaryPayment" id="salaryPayment"><label for="salaryPayment"> Salary Payment</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="hrPayroll" value="employee" id="employee"><label for="employee"> Add Employee</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="hrPayroll" value="employeeList" id="employeeList"><label for="employeeList"> All Employee List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="hrPayroll" value="activeEmployee" id="activeEmployee"><label for="activeEmployee"> Active Employee List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="hrPayroll" value="deactiveEmployee" id="deactiveEmployee"><label for="deactiveEmployee"> Deactive Employee List</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="hrPayroll" value="designation" id="designation"><label for="designation"> Add Designation</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="hrPayroll" value="department" id="department"><label for="department"> Add Department</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="hrPayroll" value="salaryPaymentReport" id="salaryPaymentReport"><label for="salaryPaymentReport"> Salary Payment Report</label></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="group">
                            <input type="checkbox" id="purchaseReports" class="group-head" @click="onClickGroupHeads"> <label for="purchaseReports"><strong>Purchase Reports</strong></label>
                            <ul class="purchaseReports">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="purchaseReports" value="supplierDue" id="supplierDue"><label for="supplierDue"> Supplier Due </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="purchaseReports" value="supplierPaymentReport" id="supplierPaymentReport"><label for="supplierPaymentReport"> Supplier Payment Report </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="purchaseReports" value="supplierList" id="supplierList"><label for="supplierList"> Supplier List </label></li>
                            </ul>
                        </div>
                        <div class="group">
                            <input type="checkbox" id="administrator" class="group-head" @click="onClickGroupHeads"> <label for="administrator"><strong>Administrator</strong></label>
                            <ul class="administrator">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="sms" id="sms"><label for="sms"> Send SMS </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="productList" id="productList"><label for="productList"> Product List </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="productLedger" id="productLedger"><label for="productLedger"> Product Ledger </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="customer" id="customer"><label for="customer"> Guest Entry </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="supplier" id="supplier"><label for="supplier"> Supplier Entry </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="category" id="category"><label for="category"> Category Entry </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="unit" id="unit"><label for="unit"> Unit Entry </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="district" id="district"><label for="district"> Area Entry </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="user" id="user"><label for="user"> Create User </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="userAccess" id="userAccess"><label for="userAccess"> User Access </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="companyProfile" id="companyProfile"><label for="companyProfile"> companyProfile </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="administrator" value="graph" id="graph"><label for="graph"> Business Monitor </label></li>
                            </ul>
                        </div>

                        <!-- Issue -->
                        <div class="group">
                            <input type="checkbox" id="websites" class="group-head" @click="onClickGroupHeads"> <label for="websites"><strong>Website Module</strong></label>
                            <ul class="websites">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="websites" value="slider" id="slider"><label for="slider"> Slider Entry</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="websites" value="management" id="management"><label for="management"> Management Entry</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="websites" value="gallery" id="gallery"><label for="gallery"> Gallery Entry </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="websites" value="offer" id="offer"><label for="offer"> Offer Entry </label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="websites" value="about" id="about"><label for="about"> About Page </label></li>
                            </ul>
                        </div>

                        <!-- invoices -->
                        <div class="group">
                            <input type="checkbox" id="invoices" class="group-head" @click="onClickGroupHeads"> <label for="invoices"><strong>Invoices</strong></label>
                            <ul class="invoices">
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="invoices" value="purchaseInvoice" id="purchaseInvoice"><label for="purchaseInvoice"> Purchase Invoice</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="invoices" value="supplierpaymentInvoice" id="supplierpaymentInvoice"><label for="supplierpaymentInvoice"> Supplier Payment Invoice</label></li>
                                <li><input type="checkbox" name='access[]' @click="singleCheck" class="invoices" value="customerpaymentInvoice" id="customerpaymentInvoice"><label for="customerpaymentInvoice"> Guest Payment Invoice </label></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <hr style="margin: 5px 0;" />
                    @if(userAction('e') || userAction('u'))
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success btn-padding">Save</button>
                    </div>
                    @endif
                </div>
            </div>
        </fieldset>
    </form>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: "#userAccessPage",
        data() {
            return {
                user_id: "{{$user->id}}",
                access: [],

                onProgress: false,
                btnText: 'Save',
            }
        },

        async created() {
            await this.getUserAccess();
            this.access.forEach(item => {
                let id = document.getElementById(item);
                id.setAttribute('checked', true);
                this.checkSingle(id.getAttribute('class'));
            })
        },

        methods: {
            async getUserAccess() {
                await axios.post('/get-user-access', {
                        userId: this.user_id
                    })
                    .then(res => {
                        this.access = res.data.access == undefined ? [] : JSON.parse(res.data.access);
                    })
            },
            checkSingle(id) {
                let unCheckInp = $("input." + id).length;
                let checkInp = $("input." + id + ":checked").length;
                if (checkInp == unCheckInp) {
                    $("#" + id).prop('checked', true);
                } else {
                    $("#" + id).prop('checked', false);
                }
                // all checked input
                let allUnCheckInp = $("#accessRow").find("input[type='checkbox']").length;
                let allCheckInp = $("#accessRow").find("input[type='checkbox']:checked").length;
                if (allCheckInp == allUnCheckInp) {
                    $("#selectAll").prop('checked', true)
                } else {
                    $("#selectAll").prop('checked', false)
                }
            },
            checkAll() {
                if (event.target.checked) {
                    $("#accessRow").find("input[type='checkbox']").prop("checked", true)
                } else {
                    $("#accessRow").find("input[type='checkbox']").prop("checked", false)
                }
            },

            onClickGroupHeads() {
                if (event.target.checked) {
                    $("." + event.target.id + " input[type='checkbox']").prop("checked", true);
                } else {
                    $("." + event.target.id + " input[type='checkbox']").prop("checked", false);
                }
                this.checkSingle(event.target.id);
            },

            singleCheck() {
                if (event.target.checked) {
                    this.checkSingle(event.target._prevClass);
                } else {
                    this.checkSingle(event.target._prevClass);
                }
            },

            addUserAccess(event) {
                let formdata = new FormData(event.target)
                formdata.append('user_id', this.user_id)
                axios.post('/add-user-access', formdata)
                    .then(res => {
                        toastr.success(res.data);
                        this.onProgress = false
                        setTimeout(() => {
                            location.href = '/user'
                        }, 1000)
                    })
                    .catch(err => {
                        this.onProgress = false
                        var r = JSON.parse(err.request.response);
                        if (err.request.status == '422' && r.errors != undefined && typeof r.errors == 'object') {
                            $.each(r.errors, (index, value) => {
                                $.each(value, (ind, val) => {
                                    toastr.error(val)
                                })
                            })
                        } else {
                            if (r.errors != undefined) {
                                console.log(r.errors);
                            }
                            toastr.error(r.message);
                        }
                    })
            },
        }
    })
</script>
@endpush