@extends('master')
@section('title', 'Cash Statement')
@section('breadcrumb_title', 'Cash Statement')
@push('style')
<style scoped>
    #cashStatement .buttons {
        margin-top: -5px;
    }

    .account-section {
        display: flex;
        border: none;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .account-section h3 {
        margin: 10px 0;
        padding: 0;
    }

    .account-section h4 {
        margin: 0;
        margin-top: 3px;
    }

    .account-section .col1 {
        background-color: #82a253;
        color: white;
        flex: 1;
        text-align: center;
        padding: 10px;
    }

    .account-section .col2 {
        background-color: #edf3e2;
        flex: 2;
        padding: 10px;
        align-items: center;
        text-align: center;
    }
</style>
@endpush
@section('content')
<div id="cashStatement">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Cash Statement</legend>
            <div class="control-group">
                <form action="" class="form-inline" @submit.prevent="getStatements">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Date from</label>
                            <input type="date" class="form-control" v-model="filter.dateFrom">
                        </div>

                        <div class="form-group">
                            <label for="">to</label>
                            <input type="date" class="form-control" v-model="filter.dateTo">
                        </div>

                        <div class="form-group buttons">
                            <input type="submit" value="Search">
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div id="reportTable">
        <div class="row" style="margin-top: 15px;">
            <div class="col-md-4 col-xs-4">
                <div class="account-section">
                    <div class="col1">
                        <i class="fa fa-sign-in fa-2x"></i><br>
                        <h4>Cash In</h4>
                    </div>
                    <div class="col2">
                        <h3 v-if="totalCashIn == 0">{{$company->currency}} 0.00</h3>
                        <h3 style="display:none;" v-bind:style="{display: totalCashIn > 0 ? '' : 'none'}">{{$company->currency}} @{{ totalCashIn | decimal }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-4">
                <div class="account-section">
                    <div class="col1">
                        <i class="fa fa-sign-out fa-2x"></i><br>
                        <h4>Cash Out</h4>
                    </div>
                    <div class="col2">
                        <h3 v-if="totalCashOut == 0">{{$company->currency}} 0.00</h3>
                        <h3 style="display:none;" v-bind:style="{display: totalCashOut > 0 ? '' : 'none'}">{{$company->currency}} @{{ totalCashOut | decimal }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-4">
                <div class="account-section">
                    <div class="col1">
                        <i class="fa fa-money fa-2x"></i><br>
                        <h4>Balance</h4>
                    </div>
                    <div class="col2">
                        <h3 v-if="cashBalance == 0">{{$company->currency}} 0.00</h3>
                        <h3 style="display:none;" v-bind:style="{display: cashBalance == 0 ? 'none' : ''}">{{$company->currency}} @{{ cashBalance | decimal }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="padding-top:10px;">
            <div class="col-md-6">
                <!-- Sales -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="4">Orders</th>
                        </tr>
                        <tr>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Received</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: orders.length > 0 ? '' : 'none'}">
                        <tr v-for="order in orders">
                            <td>@{{ order.invoice }}</td>
                            <td>@{{ order.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td style="text-align:left;">@{{ order.customer_id == null ? order.customer_name : order.customer.name }}</td>
                            <td style="text-align:right;">@{{ order.cashPaid | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="3" style="text-align:right;">Total</td>
                            <td style="text-align:right;">
                                <span v-if="orders.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: orders.length > 0 ? '' : 'none'}">@{{ totalOrders | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Received from Customers -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="4">Received from Customers</th>
                        </tr>
                        <tr>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Received</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: receivedFromCustomers.length > 0 ? '' : 'none'}">
                        <tr v-for="payment in receivedFromCustomers">
                            <td>@{{ payment.invoice }}</td>
                            <td>@{{ payment.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td style="text-align:left;" :title="payment.customer.status == 'd' ? 'Deleted customer' : ''" :style="{color: payment.customer.status == 'd' ? 'red' : ''}">@{{ payment.customer ? payment.customer.name : 'n/a' }}</td>
                            <td style="text-align:right;">@{{ payment.amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="3" style="text-align:right;">Total</td>
                            <td style="text-align:right;">
                                <span v-if="receivedFromCustomers.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: receivedFromCustomers.length > 0 ? '' : 'none'}">@{{ totalReceivedFromCustomers | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Received from Suppliers -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="4">Received from Suppliers</th>
                        </tr>
                        <tr>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Received</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: receivedFromSuppliers.length > 0 ? '' : 'none'}">
                        <tr v-for="payment in receivedFromSuppliers">
                            <td>@{{ payment.invoice }}</td>
                            <td>@{{ payment.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td style="text-align:left;" :title="payment.supplier.status == 'd' ? 'Deleted Supplier' : ''" :style="{color: payment.supplier.status == 'd' ? 'red' : ''}">@{{ payment.supplier ? payment.supplier.name : 'n/a' }}</td>
                            <td style="text-align:right;">@{{ payment.amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="3" style="text-align:right">Total</td>
                            <td style="text-align:right;">
                                <span v-if="receivedFromSuppliers.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: receivedFromSuppliers.length > 0 ? '' : 'none'}">@{{ totalReceivedFromSuppliers | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Cash Received -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="4">Cash Received</th>
                        </tr>
                        <tr>
                            <th>Transaction Id</th>
                            <th>Date</th>
                            <th>Account Name</th>
                            <th>Received</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: cashReceived.length > 0 ? '' : 'none'}">
                        <tr v-for="(transaction, sl) in cashReceived">
                            <td>@{{ sl + 1 }}</td>
                            <td>@{{ transaction.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td style="text-align:center;">@{{ transaction.account ? transaction.account.name : 'n/a' }}</td>
                            <td style="text-align:right;">@{{ transaction.in_amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="3" style="text-align:right">Total</td>
                            <td style="text-align:right;">
                                <span v-if="cashReceived.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: cashReceived.length > 0 ? '' : 'none'}">@{{ totalCashReceived | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Bank Withdraws -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="6">Bank Withdraws</th>
                        </tr>
                        <tr>
                            <th>Sl</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Bank Name</th>
                            <th>Date</th>
                            <th>Withdraw</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: bankWithdraws.length > 0 ? '' : 'none'}">
                        <tr v-for="(transaction, sl) in bankWithdraws">
                            <td>@{{ sl + 1 }}</td>
                            <td>@{{ transaction.bank_account ? transaction.bank_account.name : 'n/a' }}</td>
                            <td>@{{ transaction.bank_account ? transaction.bank_account.number : 'n/a' }}</td>
                            <td>@{{ transaction.bank_account ? transaction.bank_account.bank_name : 'n/a' }}</td>
                            <td>@{{ transaction.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td style="text-align:right;">@{{ transaction.amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="5" style="text-align:right">Total</td>
                            <td style="text-align:right;">
                                <span v-if="bankWithdraws.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: bankWithdraws.length > 0 ? '' : 'none'}">@{{ totalBankWithdraw | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Initial Loan -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="6">Initial Loan</th>
                        </tr>
                        <tr>
                            <th>Sl</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Bank Name</th>
                            <th>Date</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: loanInitials.length > 0 ? '' : 'none'}">
                        <tr v-for="(transaction, sl) in loanInitials">
                            <td>@{{ sl + 1 }}</td>
                            <td>@{{ transaction.name }}</td>
                            <td>@{{ transaction.number }}</td>
                            <td>@{{ transaction.bank_name }}</td>
                            <td>@{{ transaction.created_at | dateFormat('DD-MM-YYYY') }}</td>
                            <td style="text-align:right;">@{{ transaction.initial_balance | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="5" style="text-align:right">Total</td>
                            <td style="text-align:right;">
                                <span v-if="loanInitials.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: loanInitials.length > 0 ? '' : 'none'}">@{{ totalInitialLoan | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Loan Received -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="6">Loan Received</th>
                        </tr>
                        <tr>
                            <th>Sl</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Bank Name</th>
                            <th>Date</th>
                            <th>Received</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: loanReceives.length > 0 ? '' : 'none'}">
                        <tr v-for="(transaction, sl) in loanReceives">
                            <td>@{{ sl + 1 }}</td>
                            <td>@{{ transaction.loan_account ? transaction.loan_account.name : 'n/a' }}</td>
                            <td>@{{ transaction.loan_account ? transaction.loan_account.number : 'n/a' }}</td>
                            <td>@{{ transaction.loan_account ? transaction.loan_account.bank_name : 'n/a' }}</td>
                            <td>@{{ transaction.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td style="text-align:right;">@{{ transaction.amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="5" style="text-align:right">Total</td>
                            <td style="text-align:right;">
                                <span v-if="loanReceives.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: loanReceives.length > 0 ? '' : 'none'}">@{{ totalLoanReceived | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Invest Received -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="5">Invest Received</th>
                        </tr>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Account Code</th>
                            <th>Account Name</th>
                            <th>Received</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: investReceives.length > 0 ? '' : 'none'}">
                        <tr v-for="transaction in investReceives">
                            <td>@{{ transaction.invoice }}</td>
                            <td>@{{ transaction.date | dateFormat('DD-MM-YYYY') }}</td>
                            <td>@{{ transaction.investment_account ? transaction.investment_account.name : 'n/a' }}</td>
                            <td>@{{ transaction.investment_account ? transaction.investment_account.code : 'n/a'  }}</td>
                            <td style="text-align:right;">@{{ transaction.amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="4" style="text-align:right">Total</td>
                            <td style="text-align:right;">
                                <span v-if="investReceives.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: investReceives.length > 0 ? '' : 'none'}">@{{ totalInvestReceived | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-6">
                <!-- Purchase -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="4">Purchases</th>
                        </tr>
                        <tr>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Paid</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: purchases.length > 0 ? '' : 'none'}">
                        <tr v-for="purchase in purchases">
                            <td>@{{ purchase.invoice }}</td>
                            <td>@{{ purchase.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td style="text-align:left;" :title="purchase.supplier ? purchase.supplier.status == 'd' ? 'Deleted supplier' : '' : ''" :style="{color: purchase.supplier ? purchase.supplier.status == 'd' ? 'red' : '' : ''}">@{{ purchase.supplierName }}</td>
                            <td style="text-align:right;">@{{ purchase.paid | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="3" style="text-align:right;">Total</td>
                            <td style="text-align:right;">
                                <span v-if="purchases.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: purchases.length > 0 ? '' : 'none'}">@{{ totalPurchase | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>

                </table>

                <!-- Paid to Suppliers -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="4">Paid to Suppliers</th>
                        </tr>
                        <tr>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Paid</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: paidToSuppliers.length > 0 ? '' : 'none'}">
                        <tr v-for="payment in paidToSuppliers">
                            <td>@{{ payment.invoice }}</td>
                            <td>@{{ payment.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td style="text-align:left;" :title="payment.supplier.status == 'd' ? 'Deleted Supplier' : ''" :style="{color: payment.supplier.status == 'd' ? 'red' : ''}">@{{ payment.supplier ? payment.supplier.name: 'n/a' }}</td>
                            <td style="text-align:right;">@{{ payment.amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="3" style="text-align:right;">Total</td>
                            <td style="text-align:right;">
                                <span v-if="paidToSuppliers.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: paidToSuppliers.length > 0 ? '' : 'none'}">@{{ totalPaidToSuppliers | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Paid to Customers -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="4">Paid to Customers</th>
                        </tr>
                        <tr>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Paid</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: paidToCustomers.length > 0 ? '' : 'none'}">
                        <tr v-for="payment in paidToCustomers">
                            <td>@{{ payment.invoice }}</td>
                            <td>@{{ payment.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td style="text-align:left;" :title="payment.customer.status == 'd' ? 'Deleted customer' : ''" :style="{color: payment.customer.status == 'd' ? 'red' : ''}">@{{ payment.customer ? payment.customer.name:'n/a' }}</td>
                            <td style="text-align:right;">@{{ payment.amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="3" style="text-align:right;">Total</td>
                            <td style="text-align:right;">
                                <span v-if="paidToCustomers.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: paidToCustomers.length > 0 ? '' : 'none'}">@{{ totalPaidToCustomers | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Cash Paid -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="4">Cash Paid</th>
                        </tr>
                        <tr>
                            <th>Transaction Id</th>
                            <th>Date</th>
                            <th>Account Name</th>
                            <th>Paid</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: cashPaid.length > 0 ? '' : 'none'}">
                        <tr v-for="(transaction, sl) in cashPaid">
                            <td>@{{ sl + 1 }}</td>
                            <td>@{{ transaction.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td>@{{ transaction.account ? transaction.account.name:'n/a' }}</td>
                            <td style="text-align:right;">@{{ transaction.out_amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="3" style="text-align:right">Total</td>
                            <td style="text-align:right;">
                                <span v-if="cashPaid.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: cashPaid.length > 0 ? '' : 'none'}">@{{ totalCashPaid | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Bank Deposits -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="6">Bank Deposits</th>
                        </tr>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Bank Name</th>
                            <th>Deposit</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: bankDeposits.length > 0 ? '' : 'none'}">
                        <tr v-for="(transaction, sl) in bankDeposits">
                            <td>@{{ sl + 1 }}</td>
                            <td>@{{ transaction.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td>@{{ transaction.bank_account ? transaction.bank_account.name:'n/a' }}</td>
                            <td>@{{ transaction.bank_account ? transaction.bank_account.number:'n/a' }}</td>
                            <td>@{{ transaction.bank_account ? transaction.bank_account.bank_name:'n/a' }}</td>
                            <td style="text-align:right;">@{{ transaction.amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="5" style="text-align:right">Total</td>
                            <td style="text-align:right;">
                                <span v-if="bankDeposits.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: bankDeposits.length > 0 ? '' : 'none'}">@{{ totalBankDeposit | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Loan Payment -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="6">Loan Payment</th>
                        </tr>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Bank Name</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: loanPayments.length > 0 ? '' : 'none'}">
                        <tr v-for="(transaction, sl) in loanPayments">
                            <td>@{{ sl + 1 }}</td>
                            <td>@{{ transaction.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td>@{{ transaction.loan_account ? transaction.loan_account.name : 'n/a' }}</td>
                            <td>@{{ transaction.loan_account ? transaction.loan_account.number : 'n/a' }}</td>
                            <td>@{{ transaction.loan_account ? transaction.loan_account.bank_name : 'n/a' }}</td>
                            <td style="text-align:right;">@{{ transaction.amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="5" style="text-align:right">Total</td>
                            <td style="text-align:right;">
                                <span v-if="loanPayments.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: loanPayments.length > 0 ? '' : 'none'}">@{{ totalLoanPayment | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Invest Payment -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="5">Invest Payment</th>
                        </tr>
                        <tr>
                            <th>Inv.</th>
                            <th>Date</th>
                            <th>Account Code</th>
                            <th>Account Name</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: investPayments.length > 0 ? '' : 'none'}">
                        <tr v-for="transaction in investPayments">
                            <td>@{{ transaction.invoice }}</td>
                            <td>@{{ transaction.date | dateFormat('DD-MM-YYYY')}}</td>
                            <td>@{{ transaction.investment_account ? transaction.investment_account.code : 'n/a' }}</td>
                            <td>@{{ transaction.investment_account ? transaction.investment_account.name : 'n/a' }}</td>
                            <td style="text-align:right;">@{{ transaction.amount | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="4" style="text-align:right">Total</td>
                            <td style="text-align:right;">
                                <span v-if="investPayments.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: investPayments.length > 0 ? '' : 'none'}">@{{ totalInvestPayment | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Employee Payments -->
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr style="background: #dee4dc;color:#707070;">
                            <th colspan="5">Employee Payments</th>
                        </tr>
                        <tr>
                            <th>Employee Id</th>
                            <th>Employee Name</th>
                            <th>Date</th>
                            <th>Month</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: employeePayments.length > 0 ? '' : 'none'}">
                        <template v-for="payment in employeePayments">
                            <tr v-for="detail in payment.details" v-if="detail.payment != 0">
                                <td>@{{ detail.employee ? detail.employee.code : 'n/a' }}</td>
                                <td>@{{ detail.employee ? detail.employee.name : 'n/a' }}</td>
                                <td>@{{ payment.date }}</td>
                                <td>@{{ payment.month }}</td>
                                <td style="text-align:right;">@{{ payment.amount | decimal }}</td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="4" style="text-align:right">Total</td>
                            <td style="text-align:right;">
                                <span v-if="employeePayments.length == 0">0.00</span>
                                <span style="display:none;" v-bind:style="{display: employeePayments.length > 0 ? '' : 'none'}">@{{ totalEmployeePayments | decimal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#cashStatement',
        data() {
            return {
                filter: {
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD')
                },
                orders: [],
                purchases: [],
                receivedFromCustomers: [],
                paidToCustomers: [],
                receivedFromSuppliers: [],
                paidToSuppliers: [],
                cashReceived: [],
                cashPaid: [],
                bankDeposits: [],
                bankWithdraws: [],
                loanReceives: [],
                loanPayments: [],
                investReceives: [],
                investPayments: [],
                loanInitials: [],
                employeePayments: []
            }
        },
        filters: {
            decimal(value) {
                return value == null ? parseFloat(0).toFixed(2) : parseFloat(value).toFixed(2);
            },
            dateFormat(dt, format) {
                return dt == '' || dt == null ? '' : moment(dt).format(format);
            }
        },
        computed: {
            totalOrders() {
                return this.orders.reduce((prev, curr) => {
                    return prev + parseFloat(curr.paid)
                }, 0).toFixed(2);
            },
            totalPurchase() {
                return this.purchases.reduce((prev, curr) => {
                    return prev + parseFloat(curr.paid)
                }, 0).toFixed(2);
            },
            totalReceivedFromCustomers() {
                return this.receivedFromCustomers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(2);
            },
            totalPaidToCustomers() {
                return this.paidToCustomers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(2);
            },
            totalReceivedFromSuppliers() {
                return this.receivedFromSuppliers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(2);
            },
            totalPaidToSuppliers() {
                return this.paidToSuppliers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(2);
            },
            totalCashReceived() {
                return this.cashReceived.reduce((prev, curr) => {
                    return prev + parseFloat(curr.in_amount)
                }, 0).toFixed(2);
            },
            totalCashPaid() {
                return this.cashPaid.reduce((prev, curr) => {
                    return prev + parseFloat(curr.out_amount)
                }, 0).toFixed(2);
            },
            totalBankDeposit() {
                return this.bankDeposits.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(2);
            },
            totalBankWithdraw() {
                return this.bankWithdraws.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(2);
            },

            totalLoanReceived() {
                return this.loanReceives.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(2);
            },

            totalLoanPayment() {
                return this.loanPayments.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(2);
            },

            totalInvestReceived() {
                return this.investReceives.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(2);
            },
            totalInvestPayment() {
                return this.investPayments.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(2);
            },
            totalEmployeePayments() {
                return this.employeePayments.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(2);
            },
            totalInitialLoan() {
                return this.loanInitials.reduce((prev, curr) => {
                    return prev + parseFloat(curr.initial_balance)
                }, 0).toFixed(2);
            },
            totalCashIn() {
                return parseFloat(this.totalOrders) +
                    parseFloat(this.totalReceivedFromCustomers) +
                    parseFloat(this.totalReceivedFromSuppliers) +
                    parseFloat(this.totalCashReceived) +
                    parseFloat(this.totalLoanReceived) +
                    parseFloat(this.totalInvestReceived) +
                    parseFloat(this.totalInitialLoan) +
                    parseFloat(this.totalBankWithdraw);
            },
            totalCashOut() {
                return parseFloat(this.totalPurchase) +
                    parseFloat(this.totalPaidToCustomers) +
                    parseFloat(this.totalPaidToSuppliers) +
                    parseFloat(this.totalCashPaid) +
                    parseFloat(this.totalLoanPayment) +
                    parseFloat(this.totalInvestPayment) +
                    parseFloat(this.totalBankDeposit) +
                    parseFloat(this.totalEmployeePayments);
            },
            cashBalance() {
                return parseFloat(this.totalCashIn) - parseFloat(this.totalCashOut);
            }
        },
        created() {
            this.getStatements();
        },
        methods: {
            getStatements() {
                this.getSales();
                this.getPurchases();
                this.getReceivedFromCustomers();
                this.getPaidToCustomers();
                this.getPaidToSuppliers();
                this.getReceivedFromSuppliers();
                this.getCashReceived();
                this.getCashPaid();
                this.getBankDeposits();
                this.getBankWithdraws();
                this.getLoanReceived();
                this.getLoanPayments();
                this.getInvestReceived();
                this.getInvestPayments();
                this.getEmployeePayments();
            },

            async getSales() {
                await axios.post('/get-order', this.filter).then(res => {
                    this.orders = res.data;
                })

                // await axios.post('/get-materialsale', this.filter)
                //     .then(res => {
                //         let sales = res.data.data.materialsales.map(sale => {
                //             return {
                //                 invoice: sale.invoice,
                //                 date: sale.date,
                //                 customerName: sale.customer_type == 'G' ? sale.customer_name : sale.customer ? sale.customer.name:'n/a',
                //                 cashPaid: sale.paid
                //             }
                //         })

                //         this.sales = [...this.sales, ...sales];
                //     })
            },

            async getPurchases() {
                await axios.post('/get-purchase', this.filter)
                    .then(res => {
                        this.purchases = res.data.map(item => {
                            item.supplierName = item.supplier_type == 'G' ? item.supplier_name : item.supplier ? item.supplier.name : 'n/a'
                            return item;
                        });
                    })

                await axios.post('/get-materialpurchase', this.filter)
                    .then(res => {
                        let purchases = res.data.map(purchase => {
                            return {
                                invoice: purchase.invoice,
                                date: purchase.date,
                                supplierName: purchase.supplier_type == 'G' ? purchase.supplier_name : purchase.supplier ? purchase.supplier.name : 'n/a',
                                paid: purchase.paid
                            }
                        })

                        this.purchases = [...this.purchases, ...purchases];
                    })
            },

            getReceivedFromCustomers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CR'
                }
                axios.post('/get-customer-payments', filter)
                    .then(res => {
                        this.receivedFromCustomers = res.data.filter(p => p.method != 'bank');
                    })
            },

            getPaidToCustomers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CP'
                }
                axios.post('/get-customer-payments', filter)
                    .then(res => {
                        this.paidToCustomers = res.data.filter(p => p.method != 'bank');
                    })
            },

            getPaidToSuppliers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CP'
                }
                axios.post('/get-supplier-payments', filter)
                    .then(res => {
                        this.paidToSuppliers = res.data.filter(p => p.method != 'bank');
                    })
            },

            getReceivedFromSuppliers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CR'
                }
                axios.post('/get-supplier-payments', filter)
                    .then(res => {
                        this.receivedFromSuppliers = res.data.filter(p => p.method != 'bank');
                    })
            },

            getCashReceived() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'In Cash'
                }
                axios.post('/get-cash-transactions', filter)
                    .then(res => {
                        this.cashReceived = res.data;
                    })
            },

            getCashPaid() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Out Cash'
                }
                axios.post('/get-cash-transactions', filter)
                    .then(res => {
                        this.cashPaid = res.data;
                    })
            },

            getBankDeposits() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'deposit'
                }
                axios.post('/get-bank-transactions', filter)
                    .then(res => {
                        this.bankDeposits = res.data;
                    })
            },

            getBankWithdraws() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'withdraw'
                }
                axios.post('/get-bank-transactions', filter)
                    .then(res => {
                        this.bankWithdraws = res.data;
                    })
            },

            async getLoanReceived() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Receive'
                }
                await axios.post('/get-loan-transactions', filter)
                    .then(res => {
                        this.loanReceives = res.data;
                    })

                await axios.post('/get-loan-accounts', this.filter).then(res => {
                    this.loanInitials = res.data;
                })
            },
            getLoanPayments() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Payment'
                }
                axios.post('/get-loan-transactions', filter)
                    .then(res => {
                        this.loanPayments = res.data;
                    })
            },

            getInvestReceived() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Receive'
                }
                axios.post('/get-investment-transactions', filter)
                    .then(res => {
                        this.investReceives = res.data;
                    })
            },

            getInvestPayments() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Payment'
                }
                axios.post('/get-investment-transactions', filter)
                    .then(res => {
                        this.investPayments = res.data;
                    })
            },

            getEmployeePayments() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    details: true
                }
                axios.post('/get-payments', filter)
                    .then(res => {
                        this.employeePayments = res.data;
                    })
            },

            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Cash Statement</h4>
                            </div>
                        </div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportTable').innerHTML}
							</div>
						</div>
					</div>
				`;

                var mywindow = window.open('', '', `width=${screen.width}, height=${screen.height}`);
                mywindow.document.write(`
                    @include('administration/reports/reportHeader')
				`);
                mywindow.document.head.innerHTML += `
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
                    <link rel="stylesheet" href="{{asset('backend')}}/css/bootstrap.min.css">
                    <link rel="stylesheet" href="{{asset('backend')}}/css/ace.min.css" />
					<style>
                            .account-section h3 {
                                margin: 10px 0;
                                padding: 0;
                            }

                            .account-section h4 {
                                margin: 0;
                                margin-top: 3px;
                            }

                            .account-section .col1 {
                                background-color: #82a253;
                                color: #fff !important;
                                flex: 1;
                                text-align: center;
                                padding: 10px;
                            }

                            .account-section .col2 {
                                background-color: #edf3e2;
                                flex: 2;
                                padding: 10px;
                                align-items: center;
                                text-align: center;
                            }

                            .account-section .col1 {
                                display: flex !important;
                                align-items: center !important;
                                justify-content: center !important;
                                gap: 5px !important;
                            }

                            @media print{
                                .table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>td, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>thead>tr>th {
                                    padding: 0px 3px !important;
                                }
                                h3{
                                    font-size:15px !important;
                                }
                                .account-section h3 {
                                    margin: 5px 0;
                                    padding: 0;
                                }
                                account-section h4{
                                    margin:0 !important;
                                }
                                .account-section .col1 {
                                    background-color: #82a253 !important;
                                    color: #fff !important;
                                    flex: 1;
                                    text-align: center;
                                    padding: 10px;
                                    -webkit-print-color-adjust: exact;
                                    print-color-adjust: exact; 
                                }

                                .account-section .col2 {
                                    background-color: #edf3e2 !important;
                                    flex: 2;
                                    padding: 10px;
                                    align-items: center;
                                    text-align: center;
                                    -webkit-print-color-adjust: exact;
                                    print-color-adjust: exact; 
                                }
                                .account-section .col1 {
                                    display: flex !important;
                                    align-items: center !important;
                                    justify-content: center !important;
                                    gap: 5px !important;
                                }
                            }
					</style>
				`;
                mywindow.document.body.innerHTML += reportContent;

                mywindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                mywindow.print();
                mywindow.close();
            }
        },
    })
</script>
@endpush