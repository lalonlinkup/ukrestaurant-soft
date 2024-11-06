<style scoped>
    ul {
        list-style: none;
        margin: 0;
        margin-left: 15px;
    }

    ul li {
        cursor: pointer;
    }

    ul label {
        cursor: pointer;
    }
</style>
<!-- Modal -->
<div id="shortcutMenuModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 10px; background: #224079; color: #fff;">
                <button type="button" style="color: #ff1d0c; font-size: 25px;" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Shortcut Menu</h4>
            </div>
            <div class="modal-body">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <div class="control-group">
                        <div class="row" id="accessRow">
                            <div class="col-md-3">
                                <div class="group">
                                    <label for="bookings"><strong>Booking</strong></label>
                                    <ul class="bookings">
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="bookings" value="booking, Booking Entry" id="booking"> <label for="booking">Booking Entry</label></li>
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="bookings" value="checkout, Checkout" id="checkout"> <label for="checkout">Checkout</label></li>
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="bookings" value="checkin-list, Checkin List" id="checkin-list"> <label for="checkin-list">Checkin List</label></li>
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="bookings" value="booking-record, Booking Record" id="booking-record"> <label for="booking-record">Booking Record</label></li>
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="bookings" value="booking-invoice, Booking Invoice" id="booking-invoice"> <label for="booking-invoice">Booking Invoice</label></li>
                                    </ul>
                                </div>

                                <div class="group">
                                    <input type="checkbox" id="accounts" class="group-head" onclick="onClickGroupHeads(event)"> <label for="accounts"><strong>Accounts</strong></label>
                                    <ul class="accounts">
                                        <li><input type="checkbox" class="accounts" value="cashTransaction" id="cashTransaction"><label for="cashTransaction"> Cash Transactions</label></li>
                                        <li><input type="checkbox" class="accounts" value="bankTransaction" id="bankTransaction"><label for="bankTransaction"> Bank Transactions</label></li>
                                        <li><input type="checkbox" class="accounts" value="customerPayment" id="customerPayment"><label for="customerPayment"> Guest Payment</label></li>
                                        <li><input type="checkbox" class="accounts" value="supplierPayment" id="supplierPayment"><label for="supplierPayment"> Supplier Payment</label></li>
                                        <li><input type="checkbox" class="accounts" value="cashView" id="cashView"><label for="cashView"> Cash View</label></li>
                                        <li><input type="checkbox" class="accounts" value="account" id="account"><label for="account"> Transaction Accounts</label></li>
                                        <li><input type="checkbox" class="accounts" value="bankAccounts" id="bankAccounts"><label for="bankAccounts"> Bank Accounts</label></li>
                                        <li><input type="checkbox" class="accounts" value="chequeEntry" id="chequeEntry"><label for="chequeEntry"> New Cheque Entry</label></li>
                                        <li><input type="checkbox" class="accounts" value="chequeList" id="chequeList"><label for="chequeList"> Cheque List</label></li>
                                        <li><input type="checkbox" class="accounts" value="chequeReminderList" id="chequeReminderList"><label for="chequeReminderList"> Reminder Cheque List</label></li>
                                        <li><input type="checkbox" class="accounts" value="chequePendingList" id="chequePendingList"><label for="chequePendingList"> Pending Cheque List</label></li>
                                        <li><input type="checkbox" class="accounts" value="chequeDishoneredList" id="chequeDishoneredList"><label for="chequeDishoneredList"> Dishonered Cheque List</label></li>
                                        <li><input type="checkbox" class="accounts" value="chequePaidList" id="chequePaidList"><label for="chequePaidList"> Paid Cheque List</label></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="group">
                                    <label for="restaurant"><strong>Restaurant</strong></label>
                                    <ul class="restaurant">
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="restaurant" value="order, Order Entry" id="order"><label for="order"> Order Entry </label></li>
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="restaurant" value="payFirst, Pay First" id="payFirst"><label for="payFirst"> Pay First </label></li>
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="restaurant" value="pendingOrder, Pending Order" id="pendingOrder"><label for="pendingOrder"> Pending Order </label></li>
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="restaurant" value="orderList, Order List" id="orderList"><label for="orderList"> Order List </label></li>
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="restaurant" value="menu, Menu Entry" id="menu"><label for="menu"> Menu Entry </label></li>
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="restaurant" value="menuList, Menu List" id="menuList"><label for="menuList"> Menu List </label></li>
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="restaurant" value="menu-category, Menu Category" id="menu-category"><label for="menu-category"> Menu Category </label></li>
                                        <li><input type="checkbox" onclick="singleCheck(event)" class="restaurant" value="unit, Unit Entry" id="unit"><label for="unit"> Unit Entry </label></li>
                                    </ul>
                                </div>

                                <div class="group">
                                    <input type="checkbox" id="accountsReports" class="group-head" onclick="onClickGroupHeads(event)"><label for="accountsReports"><strong>Accounts Reports</strong></label>
                                    <ul class="accountsReports">
                                        <li><input type="checkbox" class="accountsReports" value="TransactionReport" id="TransactionReport"> <label for="TransactionReport"> Cash Transaction Report</label></li>
                                        <li><input type="checkbox" class="accountsReports" value="bankTransactionReport" id="bankTransactionReport"> <label for="bankTransactionReport"> Bank Transaction Report</label></li>
                                        <li><input type="checkbox" class="accountsReports" value="cashLedger" id="cashLedger"> <label for="cashLedger"> Cash Ledger</label></li>
                                        <li><input type="checkbox" class="accountsReports" value="bankLedger" id="bankLedger"> <label for="bankLedger"> Bank Ledger</label></li>
                                        <li><input type="checkbox" class="accountsReports" value="cashStatement" id="cashStatement"> <label for="cashStatement"> Cash Statement</label></li>
                                        <li><input type="checkbox" class="accountsReports" value="balanceSheet" id="balanceSheet"> <label for="balanceSheet"> Balance Sheet</label></li>
                                        <li><input type="checkbox" class="accountsReports" value="balanceInOut" id="balanceInOut"> <label for="balanceInOut"> Balance InOut</label></li>
                                        <li><input type="checkbox" class="accountsReports" value="profitLoss" id="profitLoss"> <label for="profitLoss"> Profit/Loss Report</label></li>
                                        <li><input type="checkbox" class="accountsReports" value="dayBook" id="dayBook"> <label for="dayBook"> Day Book</label></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="group">
                                    <input type="checkbox" id="purchases" class="group-head" onclick="onClickGroupHeads(event)"> <label for="purchases"><strong>Purchase</strong></label>
                                    <ul class="purchases">
                                        <li><input type="checkbox" class="purchases" value="purchase" id="purchase"><label for="purchase"> Purchase Entry</label></li>
                                        <li><input type="checkbox" class="purchases" value="purchaseReturn" id="purchaseReturn"><label for="purchaseReturn"> Purchase Return</label></li>
                                        <li><input type="checkbox" class="purchases" value="purchaseReturnList" id="purchaseReturnList"><label for="purchaseReturnList"> Purchase ReturnList</label></li>
                                        <li><input type="checkbox" class="purchases" value="purchaseRecord" id="purchaseRecord"><label for="purchaseRecord"> Purchase Record</label></li>
                                        <li><input type="checkbox" class="purchases" value="assetEntry" id="assetEntry"><label for="assetEntry"> Assets Entry</label></li>
                                        <li><input type="checkbox" class="purchases" value="assetsReport" id="assetsReport"><label for="assetsReport"> Assets Report</label></li>
                                    </ul>
                                </div>
                                <div class="group">
                                    <label for="hrPayroll"><strong>HR & Payroll</strong></label>
                                    <ul class="hrPayroll">
                                        <li><input type="checkbox" class="hrPayroll" onclick="singleCheck(event)" value="employee-salary, Salary Payment" id="employee-salary"><label for="employee-salary"> Salary Payment </label></li>
                                        <li><input type="checkbox" class="hrPayroll" onclick="singleCheck(event)" value="salaryRecord, Salary Record" id="salaryRecord"><label for="salaryRecord"> Salary Record </label></li>
                                        <li><input type="checkbox" class="hrPayroll" onclick="singleCheck(event)" value="employee, Add Employee" id="employee"><label for="employee"> Add Employee </label></li>
                                        <li><input type="checkbox" class="hrPayroll" onclick="singleCheck(event)" value="employee-list, Employee List" id="employee-list"><label for="employee-list"> Employee List </label></li>
                                        <li><input type="checkbox" class="hrPayroll" onclick="singleCheck(event)" value="designation, Designation Entry" id="designation"><label for="designation"> Designation Entry </label></li>
                                        <li><input type="checkbox" class="hrPayroll" onclick="singleCheck(event)" value="department, Department Entry" id="department"><label for="department"> Department Entry </label></li>
                                    </ul>
                                </div>

                                <div class="group">
                                    <input type="checkbox" id="loan" class="group-head" onclick="onClickGroupHeads(event)"> <label for="loan"><strong>Loan</strong></label>
                                    <ul class="loan">
                                        <li><input type="checkbox" class="loan" value="loanTransactions" id="loanTransactions"><label for="loanTransactions"> Loan Transection</label></li>
                                        <li><input type="checkbox" class="loan" value="loanView" id="loanView"><label for="loanView"> Loan View</label></li>
                                        <li><input type="checkbox" class="loan" value="loanTransactionReport" id="loanTransactionReport"><label for="loanTransactionReport"> Loan Transaction Report</label></li>
                                        <li><input type="checkbox" class="loan" value="loanLedger" id="loanLedger"><label for="loanLedger"> Loan Ledger</label></li>
                                        <li><input type="checkbox" class="loan" value="loanAccounts" id="loanAccounts"><label for="loanAccounts"> Loan Account</label></li>
                                    </ul>
                                </div>

                                <div class="group">
                                    <label for="investment"><strong>Investment</strong></label>
                                    <ul class="investment">
                                        <li><input type="checkbox" class="investment" value="investmentTransactions" id="investmentTransactions"><label for="investmentTransactions"> Investment Transection</label></li>
                                        <li><input type="checkbox" class="investment" value="investmentView" id="investmentView"><label for="investmentView"> Investment View</label></li>
                                        <li><input type="checkbox" class="investment" value="investmentTransactionReport" id="investmentTransactionReport"><label for="investmentTransactionReport"> Investment Transaction Report</label></li>
                                        <li><input type="checkbox" class="investment" value="investmentLedger" id="investmentLedger"><label for="investmentLedger"> Investment Ledger</label></li>
                                        <li><input type="checkbox" class="investment" value="investmentAccounts" id="investmentAccounts"><label for="investmentAccounts"> Investment Account</label></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="group">
                                    <label for="administrator"><strong>Administrator</strong></label>
                                    <ul class="administrator">
                                        <li><input type="checkbox" class="administrator" onclick="singleCheck(event)" value="send-sms, Send SMS" id="send-sms"><label for="send-sms"> Send SMS </label></li>
                                        <li><input type="checkbox" class="administrator" onclick="singleCheck(event)" value="district, Area Entry" id="district"><label for="district"> Area Entry </label></li>
                                        <li><input type="checkbox" class="administrator" onclick="singleCheck(event)" value="company-profile, Company Profile" id="company-profile"><label for="company-profile"> Company Profile </label></li>
                                        <li><input type="checkbox" class="administrator" onclick="singleCheck(event)" value="user, User Entry" id="user"><label for="user"> User Entry </label></li>
                                        <li><input type="checkbox" class="administrator" onclick="singleCheck(event)" value="supplier, Supplier Entry" id="supplier"><label for="supplier"> Supplier Entry </label></li>
                                        <li><input type="checkbox" class="administrator" onclick="singleCheck(event)" value="customer, Guest Entry" id="customer"><label for="customer"> Guest Entry </label></li>
                                        <li><input type="checkbox" class="administrator" onclick="singleCheck(event)" value="reference, Reference Entry" id="reference"><label for="reference"> Reference Entry </label></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>