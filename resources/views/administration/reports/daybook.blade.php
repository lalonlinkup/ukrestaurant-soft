@extends('master')
@section('title', 'Day Book')
@section('breadcrumb_title', 'Day Book')
@push('style')
<style scoped>
    #dayBook .buttons {
        margin-top: -5px;
    }

    .day-book-table {
        width: 100%;
        margin-bottom: 50px;
    }

    .day-book-table thead {
        background: #ebebeb;
        border-bottom: 1px solid black;
    }

    .day-book-table th {
        padding: 5px 10px;
        text-align: left;
    }

    .day-book-table td {
        padding: 0px 30px;
    }

    .day-book-table tr td:last-child {
        text-align: right;
        padding-right: 50px;
    }

    .day-book-table .main-heading {
        padding-left: 10px;
        font-weight: bold;
    }

    .day-book-table .sub-heading {
        padding-left: 20px;
        font-weight: bold;
    }

    .day-book-table .sub-value {
        padding-right: 10px !important;
        font-weight: bold;
    }
</style>
@endpush
@section('content')
<div id="dayBook">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Day Book Report</legend>
            <div class="control-group">
                <form action="" class="form-inline" @submit.prevent="getDayBookData">
                    <div class="form-group">
                        <label for="">Date from</label>
                        <input type="date" class="form-control" v-model="filter.dateFrom">
                    </div>

                    <div class="form-group">
                        <label for="">to</label>
                        <input type="date" class="form-control" v-model="filter.dateTo">
                    </div>

                    <div class="form-group buttons">
                        <input type="submit" value="Show Report">
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

    <div id="printContent">
        <div class="row">
            <div class="col-md-12">
                <div style="display:flex;">
                    <div style="width:50%;border:1px solid black;position:relative;">
                        <table class="day-book-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="main-heading">Opening Balance</td>
                                    <td></td>
                                </tr>
                                <template v-if="openingBalance.cashBalance != null">
                                    <tr>
                                        <td class="sub-heading">Cash in Hand</td>
                                        <td class="sub-value">@{{ openingBalance.cashBalance.cash_balance | decimal }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cash</td>
                                        <td>@{{ openingBalance.cashBalance.cash_balance | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="openingBalance.bankBalance.length > 0">
                                    <tr>
                                        <td class="sub-heading">Bank Accounts</td>
                                        <td class="sub-value">@{{ totalBankOpeningBalance }}</td>
                                    </tr>
                                    <template>
                                        <tr v-for="bankAccount in openingBalance.bankBalance">
                                            <td>@{{ bankAccount.bank_name }} @{{ bankAccount.name }} @{{ bankAccount.number }}</td>
                                            <td>@{{ bankAccount.balance | decimal }}</td>
                                        </tr>
                                    </template>
                                </template>
                                <tr>
                                    <td class="main-heading">Receipt</td>
                                    <td></td>
                                </tr>
                                <template v-if="orders.length > 0">
                                    <tr>
                                        <td class="sub-heading">Orders</td>
                                        <td class="sub-value">@{{ totalOrders }}</td>
                                    </tr>
                                    <tr v-for="order in orders">
                                        <td>@{{ order.customer_id == null ? order.customer_name : order.customer.name }} - @{{ order.customer_id == null ? order.customer_phone : order.customer.phone }}</td>
                                        <td>@{{ order.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="asset_sales.length > 0">
                                    <tr>
                                        <td class="sub-heading">Asset Sales</td>
                                        <td class="sub-value">@{{ totalAssetSales }}</td>
                                    </tr>
                                    <tr v-for="asale in asset_sales">
                                        <td>@{{ asale.name }}</td>
                                        <td>@{{ asale.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="receivedFromCustomers.length > 0">
                                    <tr>
                                        <td class="sub-heading">Customer Payment</td>
                                        <td class="sub-value">@{{ totalReceivedFromCustomers }}</td>
                                    </tr>
                                    <tr v-for="payment in receivedFromCustomers">
                                        <td>@{{ payment.customer ? payment.customer.name : 'n/a' }}-@{{ payment.customer ? payment.customer.phone : 'n/a' }}</td>
                                        <td>@{{ payment.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="cashReceived.length > 0">
                                    <tr>
                                        <td class="sub-heading">Cash Received</td>
                                        <td class="sub-value">@{{ totalCashReceived }}</td>
                                    </tr>
                                    <tr v-for="transaction in cashReceived">
                                        <td>@{{ transaction.account ? transaction.account.name : 'n/a' }}-@{{ transaction.account ? transaction.account.code : 'n/a' }}</td>
                                        <td>@{{ transaction.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="receivedFromSuppliers.length > 0">
                                    <tr>
                                        <td class="sub-heading">Received from Suppliers</td>
                                        <td class="sub-value">@{{ totalReceivedFromSuppliers }}</td>
                                    </tr>
                                    <tr v-for="payment in receivedFromSuppliers">
                                        <td>@{{ payment.supplier ? payment.supplier.name : 'n/a' }}-@{{ payment.supplier ? payment.supplier.phone : 'n/a' }}</td>
                                        <td>@{{ payment.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="loanInitials.length > 0">
                                    <tr>
                                        <td class="sub-heading">Loan Initial Balance</span></td>
                                        <td class="sub-value">@{{ totalInitialLoan }}</td>
                                    </tr>
                                    <tr v-for="transaction in loanInitials">
                                        <td>@{{ transaction.bank_name }} @{{ transaction.name }} @{{ transaction.number }}</td>
                                        <td>@{{ transaction.initial_balance | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="loanReceives.length > 0">
                                    <tr>
                                        <td class="sub-heading">Loan Receives</span></td>
                                        <td class="sub-value">@{{ totalLoanReceived }}</td>
                                    </tr>
                                    <tr v-for="transaction in loanReceives">
                                        <td>@{{ transaction.bank_name }} @{{ transaction.account_name }} @{{ transaction.account_number }}</td>
                                        <td>@{{ transaction.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="investReceives.length > 0">
                                    <tr>
                                        <td class="sub-heading">Invest Receives</span></td>
                                        <td class="sub-value">@{{ totalInvestReceived }}</td>
                                    </tr>
                                    <tr v-for="transaction in investReceives">
                                        <td>@{{ transaction.investment_account ? transaction.investment_account.name : 'n/a' }}-@{{ transaction.investment_account ? transaction.investment_account.code : 'n/a' }}</td>
                                        <td>@{{ transaction.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="bankWithdraws.length > 0">
                                    <tr>
                                        <td class="sub-heading">Bank Withdraws <span style="color:red;">(Not Calculated)</span></td>
                                        <td class="sub-value">@{{ totalBankWithdraw }}</td>
                                    </tr>
                                    <tr v-for="transaction in bankWithdraws">
                                        <td>@{{ transaction.bank_account ? transaction.bank_account.bank_name : 'n/a' }} @{{ transaction.bank_account ? transaction.bank_account.name:'n/a' }} @{{ transaction.bank_account ? transaction.bank_account.number : 'n/a' }}</td>
                                        <td>@{{ transaction.totalAmount | decimal }}</td>
                                    </tr>
                                </template>


                                <template v-if="bankDeposits.length > 0">
                                    <tr>
                                        <td class="sub-heading">Bank Deposits <span style="color:red;">(Not Calculated)</span></td>
                                        <td class="sub-value">@{{ totalBankDeposit }}</td>
                                    </tr>
                                    <tr v-for="transaction in bankDeposits">
                                        <td>@{{ transaction.bank_account ? transaction.bank_account.bank_name : 'n/a' }} @{{ transaction.bank_account ? transaction.bank_account.name:'n/a' }} @{{ transaction.bank_account ? transaction.bank_account.number : 'n/a' }}</td>
                                        <td>@{{ transaction.totalAmount | decimal }}</td>
                                    </tr>
                                </template>

                            </tbody>
                        </table>
                        <div style="position:absolute;bottom:0px;left:0px;padding:5px 10px;display:none;width:100%;border-top:1px solid black;font-weight:bold;" v-bind:style="{display: _.isNumber(totalIn) ? 'flex' : 'none' }">
                            <div style="width:50%;">Total</div>
                            <div style="width:50%;text-align:right;">@{{ totalIn | decimal }}</div>
                        </div>
                    </div>
                    <div style="width:50%;border:1px solid black;border-left:none;position:relative;">
                        <table class="day-book-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="main-heading">Payment</td>
                                    <td></td>
                                </tr>
                                <template v-if="purchases.length > 0">
                                    <tr>
                                        <td class="sub-heading">Purchases</td>
                                        <td class="sub-value">@{{ totalPurchase }}</td>
                                    </tr>
                                    <tr v-for="purchase in purchases">
                                        <td>@{{ purchase.supplier ? purchase.supplier.name : '--' }}-@{{ purchase.supplier ? purchase.supplier.phone : '--' }}</td>
                                        <td>@{{ purchase.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="materialPurchases.length > 0">
                                    <tr>
                                        <td class="sub-heading">Material Purchases</td>
                                        <td class="sub-value">@{{ totalMaterialPurchase }}</td>
                                    </tr>
                                    <tr v-for="purchase in materialPurchases">
                                        <td>@{{ purchase.supplier ? purchase.supplier.name : '--' }}-@{{ purchase.supplier ? purchase.supplier.phone : '--' }}</td>
                                        <td>@{{ purchase.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="asset_purchases.length > 0">
                                    <tr>
                                        <td class="sub-heading">Asset Purchases</td>
                                        <td class="sub-value">@{{ totalAssetPurchases }}</td>
                                    </tr>
                                    <tr v-for="sale in asset_purchases">
                                        <td>@{{ sale.name }}</td>
                                        <td>@{{ sale.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="paidToSuppliers.length > 0">
                                    <tr>
                                        <td class="sub-heading">Supplier Payment</td>
                                        <td class="sub-value">@{{ totalPaidToSuppliers }}</td>
                                    </tr>
                                    <tr v-for="payment in paidToSuppliers">
                                        <td>@{{ payment.supplier ? payment.supplier.name : '--' }}-@{{ payment.supplier ? payment.supplier.phone : '--' }}</td>
                                        <td>@{{ payment.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="cashPaid.length > 0">
                                    <tr>
                                        <td class="sub-heading">Cash Paid</td>
                                        <td class="sub-value">@{{ totalCashPaid }}</td>
                                    </tr>
                                    <tr v-for="transaction in cashPaid">
                                        <td>@{{ transaction.account ? transaction.account.name : 'n/a' }}-@{{ transaction.account ? transaction.account.code : 'n/a' }}</td>
                                        <td>@{{ transaction.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="paidToCustomers.length > 0">
                                    <tr>
                                        <td class="sub-heading">Paid to Customers</td>
                                        <td class="sub-value">@{{ totalPaidToCustomers }}</td>
                                    </tr>
                                    <tr v-for="payment in paidToCustomers">
                                        <td>@{{ payment.customer ? payment.customer.name : 'n/a' }}-@{{ payment.customer ? payment.customer.phone : '--' }}</td>
                                        <td>@{{ payment.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="employeePayments.length > 0">
                                    <tr>
                                        <td class="sub-heading">Employee Payments</td>
                                        <td class="sub-value">@{{ totalEmployeePayments }}</td>
                                    </tr>
                                    <tr v-for="payment in employeePayments">
                                        <td>@{{ payment.employee ? payment.employee.name : 'n/a' }}</td>
                                        <td>@{{ payment.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="loanPayments.length > 0">
                                    <tr>
                                        <td class="sub-heading">Loan Payments</span></td>
                                        <td class="sub-value">@{{ totalLoanPayment }}</td>
                                    </tr>
                                    <tr v-for="transaction in loanPayments">
                                        <td>@{{ transaction.loan_account ? transaction.loan_account.bank_name:'n/a' }} @{{ transaction.loan_account ? transaction.loan_account.name:'n/a' }} @{{ transaction.loan_account ? transaction.loan_account.number:'n/a' }}</td>
                                        <td>@{{ transaction.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <template v-if="investPayments.length > 0">
                                    <tr>
                                        <td class="sub-heading">Invest Payments</span></td>
                                        <td class="sub-value">@{{ totalInvestPayment }}</td>
                                    </tr>
                                    <tr v-for="transaction in investPayments">
                                        <td>@{{ transaction.investment_account ? transaction.investment_account.name:'n/a' }}-@{{ transaction.investment_account ? transaction.investment_account.code:'n/a' }}</td>
                                        <td>@{{ transaction.totalAmount | decimal }}</td>
                                    </tr>
                                </template>
                                <tr>
                                    <td class="main-heading">Closing Balance</td>
                                    <td></td>
                                </tr>
                                <template v-if="closingBalance.bankBalance.length > 0">
                                    <tr>
                                        <td class="sub-heading">Bank Accounts</td>
                                        <td class="sub-value">@{{ totalBankClosingBalance }}</td>
                                    </tr>
                                    <template>
                                        <tr v-for="bankAccount in closingBalance.bankBalance">
                                            <td>@{{ bankAccount.bank_name }} @{{ bankAccount.name }} @{{ bankAccount.number }}</td>
                                            <td>@{{ bankAccount.balance | decimal }}</td>
                                        </tr>
                                    </template>
                                </template>
                                <template v-if="closingBalance.cashBalance != null">
                                    <tr>
                                        <td class="sub-heading">Cash in Hand</td>
                                        <td class="sub-value">@{{ closingBalance.cashBalance.cash_balance | decimal }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cash</td>
                                        <td>@{{ closingBalance.cashBalance.cash_balance | decimal }}</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div style="position:absolute;bottom:0px;left:0px;padding:5px 10px;display:none;width:100%;border-top:1px solid black;font-weight:bold;" v-bind:style="{display: _.isNumber(totalOut) ? 'flex' : 'none' }">
                            <div style="width:50%;">Total</div>
                            <div style="width:50%;text-align:right;">@{{ totalOut | decimal }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#dayBook',
        data() {
            return {
                filter: {
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD')
                },
                openingBalance: {
                    bankBalance: [],
                    cashBalance: 0.00
                },
                closingBalance: {
                    bankBalance: [],
                    cashBalance: 0.00
                },
                orders: [],
                asset_sales: [],
                asset_purchases: [],
                purchases: [],
                materialPurchases: [],
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
                loanInitials: [],
                investReceives: [],
                investPayments: [],
                employeePayments: []
            }
        },
        filters: {
            decimal(value) {
                return value == null ? 0.00 : parseFloat(value).toFixed(2);
            }
        },
        computed: {
            totalBankOpeningBalance() {
                return this.openingBalance.bankBalance.reduce((prev, curr) => {
                    return prev + parseFloat(curr.balance)
                }, 0).toFixed(2);
            },
            totalBankClosingBalance() {
                return this.closingBalance.bankBalance.reduce((prev, curr) => {
                    return prev + parseFloat(curr.balance)
                }, 0).toFixed(2);
            },
            totalOrders() {
                return this.orders.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalAssetSales() {
                return this.asset_sales.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalAssetPurchases() {
                return this.asset_purchases.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalPurchase() {
                return this.purchases.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalMaterialPurchase() {
                return this.materialPurchases.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalReceivedFromCustomers() {
                return this.receivedFromCustomers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalPaidToCustomers() {
                return this.paidToCustomers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalReceivedFromSuppliers() {
                return this.receivedFromSuppliers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalPaidToSuppliers() {
                return this.paidToSuppliers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalCashReceived() {
                return this.cashReceived.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalCashPaid() {
                return this.cashPaid.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalBankDeposit() {
                return this.bankDeposits.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalLoanPayment() {
                return this.loanPayments.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalInvestPayment() {
                return this.investPayments.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalBankWithdraw() {
                return this.bankWithdraws.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalLoanReceived() {
                return this.loanReceives.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalInvestReceived() {
                return this.investReceives.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalEmployeePayments() {
                return this.employeePayments.reduce((prev, curr) => {
                    return prev + parseFloat(curr.totalAmount)
                }, 0).toFixed(2);
            },
            totalInitialLoan() {
                return this.loanInitials.reduce((prev, curr) => {
                    return prev + parseFloat(curr.initial_balance)
                }, 0).toFixed(2);
            },
            totalIn() {
                return parseFloat(this.openingBalance.cashBalance.cash_balance) +
                    parseFloat(this.totalBankOpeningBalance) +
                    parseFloat(this.totalOrders) +
                    parseFloat(this.totalLoanReceived) +
                    parseFloat(this.totalInvestReceived) +
                    parseFloat(this.totalAssetSales) +
                    parseFloat(this.totalInitialLoan) +
                    parseFloat(this.totalReceivedFromCustomers) +
                    parseFloat(this.totalReceivedFromSuppliers) +
                    parseFloat(this.totalCashReceived);
            },
            totalOut() {
                return parseFloat(this.totalPurchase) +
                    parseFloat(this.totalMaterialPurchase) +
                    parseFloat(this.totalPaidToCustomers) +
                    parseFloat(this.totalPaidToSuppliers) +
                    parseFloat(this.totalCashPaid) +
                    parseFloat(this.totalLoanPayment) +
                    parseFloat(this.totalInvestPayment) +
                    parseFloat(this.totalAssetPurchases) +
                    parseFloat(this.totalEmployeePayments) +
                    parseFloat(this.closingBalance.cashBalance.cash_balance) +
                    parseFloat(this.totalBankClosingBalance);
            },
            cashBalance() {
                return parseFloat(this.totalIn) - parseFloat(this.totalOut);
            }
        },
        created() {
            this.getDayBookData();
        },
        methods: {
            getDayBookData() {
                this.getOpeningBalance();
                this.getClosingBalance();
                this.getOrders();
                this.getAssetSales();
                this.getAssetPurchases();
                this.getPurchases();
                this.getMaterialPurchases();
                this.getReceivedFromCustomers();
                this.getPaidToCustomers();
                this.getPaidToSuppliers();
                this.getReceivedFromSuppliers();
                this.getCashReceived();
                this.getCashPaid();
                this.getBankDeposits();
                this.getLoanPayments();
                this.getInvestPayments();
                this.getBankWithdraws();
                this.getLoanReceived();
                this.getInvestReceived();
                this.getEmployeePayments();
            },

            getOpeningBalance() {
                axios.post('/get-cashandbank-balance', {
                    date: this.filter.dateFrom
                }).then(res => {
                    this.openingBalance = res.data;
                })
            },

            getClosingBalance() {
                axios.post('/get-cashandbank-balance', {
                    date: moment(this.filter.dateTo).add(1, 'days').format('YYYY-MM-DD')
                }).then(res => {
                    this.closingBalance = res.data;
                })
            },

            getOrders() {
                axios.post('/get-order', this.filter).then(res => {
                    let orders = res.data.filter(order => order.paid > 0);
                    orders = _.groupBy(orders, 'customer_id');
                    orders = _.toArray(orders);
                    orders = orders.map(order => {
                        order[0].totalAmount = order.reduce((p, c) => {
                            return p + parseFloat(c.paid)
                        }, 0);
                        return order[0];
                    })
                    this.orders = orders;
                })
            },
            getAssetSales() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'sale'
                }

                axios.post('/get-asset', filter).then(res => {
                    let asset_sales = res.data.data.filter(sale => sale.amount > 0);
                    asset_sales = _.groupBy(asset_sales, 'name');
                    asset_sales = _.toArray(asset_sales);
                    asset_sales = asset_sales.map(sale => {
                        sale[0].totalAmount = sale.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return sale[0];
                    })
                    this.asset_sales = asset_sales;

                })
            },
            getAssetPurchases() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'buy'
                }

                axios.post('/get-asset', filter).then(res => {
                    let asset_sales = res.data.data.filter(sale => sale.amount > 0);
                    asset_sales = _.groupBy(asset_sales, 'name');
                    asset_sales = _.toArray(asset_sales);
                    asset_sales = asset_sales.map(sale => {
                        sale[0].totalAmount = sale.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return sale[0];
                    })
                    this.asset_purchases = asset_sales;

                })
            },
            getPurchases() {
                axios.post('/get-purchase', this.filter).then(res => {
                    let purchases = res.data.data.purchases.filter(purchase => purchase.paid > 0);
                    purchases = _.groupBy(purchases, 'supplier_id');
                    purchases = _.toArray(purchases);
                    purchases = purchases.map(purchase => {
                        purchase[0].totalAmount = purchase.reduce((p, c) => {
                            return p + parseFloat(c.paid)
                        }, 0);
                        return purchase[0];
                    })
                    this.purchases = purchases;
                })
            },

            getMaterialPurchases() {
                axios.post('/get-materialpurchase', this.filter).then(res => {
                    let purchases = res.data.data.materialpurchases.filter(purchase => purchase.paid > 0);
                    purchases = _.groupBy(purchases, 'supplier_id');
                    purchases = _.toArray(purchases);
                    purchases = purchases.map(purchase => {
                        purchase[0].totalAmount = purchase.reduce((p, c) => {
                            return p + parseFloat(c.paid)
                        }, 0);
                        return purchase[0];
                    })
                    this.materialPurchases = purchases;
                })
            },

            getReceivedFromCustomers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CR'
                }
                axios.post('/get-customer-payments', filter).then(res => {
                    let payments = res.data.data;
                    payments = _.groupBy(payments, 'customer_id');
                    payments = _.toArray(payments);
                    payments = payments.map(payment => {
                        payment[0].totalAmount = payment.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return payment[0];
                    })
                    this.receivedFromCustomers = payments;
                })
            },

            getPaidToCustomers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CP'
                }
                axios.post('/get-customer-payments', filter).then(res => {
                    let payments = res.data.data;
                    payments = _.groupBy(payments, 'customer_id');
                    payments = _.toArray(payments);
                    payments = payments.map(payment => {
                        payment[0].totalAmount = payment.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return payment[0];
                    })
                    this.paidToCustomers = payments;
                })
            },

            getPaidToSuppliers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CP'
                }
                axios.post('/get-supplier-payments', filter).then(res => {
                    let payments = res.data.data;
                    payments = _.groupBy(payments, 'supplier_id');
                    payments = _.toArray(payments);
                    payments = payments.map(payment => {
                        payment[0].totalAmount = payment.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return payment[0];
                    })
                    this.paidToSuppliers = payments;
                })
            },

            getReceivedFromSuppliers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CR'
                }
                axios.post('/get-supplier-payments', filter).then(res => {
                    let payments = res.data.data;
                    payments = _.groupBy(payments, 'supplier_id');
                    payments = _.toArray(payments);
                    payments = payments.map(payment => {
                        payment[0].totalAmount = payment.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return payment[0];
                    })
                    this.receivedFromSuppliers = payments;
                })
            },

            getCashReceived() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'In Cash'
                }
                axios.post('/get-cash-transactions', filter).then(res => {
                    let transactions = res.data.data;
                    transactions = _.groupBy(transactions, 'account_id');
                    transactions = _.toArray(transactions);
                    transactions = transactions.map(transaction => {
                        transaction[0].totalAmount = transaction.reduce((p, c) => {
                            return p + parseFloat(c.in_amount)
                        }, 0);
                        return transaction[0];
                    })
                    this.cashReceived = transactions;
                })
            },

            getCashPaid() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Out Cash'
                }
                axios.post('/get-cash-transactions', filter).then(res => {
                    let transactions = res.data.data;
                    transactions = _.groupBy(transactions, 'account_id');
                    transactions = _.toArray(transactions);
                    transactions = transactions.map(transaction => {
                        transaction[0].totalAmount = transaction.reduce((p, c) => {
                            return p + parseFloat(c.out_amount)
                        }, 0);
                        return transaction[0];
                    })
                    this.cashPaid = transactions;
                })
            },

            getBankDeposits() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'deposit'
                }
                axios.post('/get-bank-transactions', filter).then(res => {
                    let transactions = res.data.data;
                    transactions = _.groupBy(transactions, 'bank_account_id');
                    transactions = _.toArray(transactions);
                    transactions = transactions.map(transaction => {
                        transaction[0].totalAmount = transaction.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return transaction[0];
                    })
                    this.bankDeposits = transactions;
                })
            },
            getLoanPayments() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Payment'
                }
                axios.post('/get-loan-transactions', filter).then(res => {
                    let transactions = res.data.data;
                    transactions = _.groupBy(transactions, 'loan_account_id');
                    transactions = _.toArray(transactions);
                    transactions = transactions.map(transaction => {
                        transaction[0].totalAmount = transaction.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return transaction[0];
                    })
                    this.loanPayments = transactions;
                })
            },

            getInvestPayments() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Payment'
                }
                axios.post('/get-investment-transactions', filter).then(res => {
                    let transactions = res.data.data;
                    transactions = _.groupBy(transactions, 'investment_account_id');
                    transactions = _.toArray(transactions);
                    transactions = transactions.map(transaction => {
                        transaction[0].totalAmount = transaction.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return transaction[0];
                    })
                    this.investPayments = transactions;
                })
            },

            getBankWithdraws() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'withdraw'
                }
                axios.post('/get-bank-transactions', filter).then(res => {
                    let transactions = res.data.data;
                    transactions = _.groupBy(transactions, 'bank_account_id');
                    transactions = _.toArray(transactions);
                    transactions = transactions.map(transaction => {
                        transaction[0].totalAmount = transaction.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return transaction[0];
                    })
                    this.bankWithdraws = transactions;
                })
            },
            getLoanReceived() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Receive'
                }
                axios.post('/get-loan-transactions', filter).then(res => {
                    let transactions = res.data.data;
                    transactions = _.groupBy(transactions, 'account_id');
                    transactions = _.toArray(transactions);
                    transactions = transactions.map(transaction => {
                        transaction[0].totalAmount = transaction.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return transaction[0];
                    })
                    this.loanReceives = transactions;
                })

                axios.post('/get-loan-accounts', this.filter).then(res => {
                    this.loanInitials = res.data.data;
                })
            },
            getInvestReceived() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Receive'
                }
                axios.post('/get-investment-transactions', filter).then(res => {
                    let transactions = res.data.data;
                    transactions = _.groupBy(transactions, 'investment_account_id');
                    transactions = _.toArray(transactions);
                    transactions = transactions.map(transaction => {
                        transaction[0].totalAmount = transaction.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return transaction[0];
                    })
                    this.investReceives = transactions;
                })
            },

            getEmployeePayments() {
                return
                axios.post('/get-salary-details', this.filter).then(res => {
                    let payments = res.data.data;
                    payments = _.groupBy(payments, 'employee_id');
                    payments = _.toArray(payments);
                    payments = payments.map(payment => {
                        payment[0].totalAmount = payment.reduce((p, c) => {
                            return p + parseFloat(c.amount)
                        }, 0);
                        return payment[0];
                    })
                    this.employeePayments = payments;

                })
            },

            async print() {
                let printContent = `
					<div class="container">
						<h4 style="text-align:center">Receipt and Payment</h4>
						<div class="row">
							<div class="col-xs-12 text-center">
								<strong>Statement from</strong> ${this.filter.dateFrom} <strong>to</strong> ${this.filter.dateTo}
							</div>
						</div>
					</div>
					<div class="container">
						${document.querySelector('#printContent').innerHTML}
					</div>
				`;

                var printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
                printWindow.document.write(`
                    @include('administration/reports/reportHeader')
				`);

                printWindow.document.body.innerHTML += printContent;
                printWindow.document.head.innerHTML += `
					<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
					<style>
						.day-book-table {
							width: 100%;
							margin-bottom: 50px;
						}
						.day-book-table thead {
							background: #ebebeb;
							border-bottom: 1px solid black;
						}
						.day-book-table th {
							padding: 5px 10px;
							text-align: left;
						}
						.day-book-table td {
							padding: 0px 30px;
						}
						.day-book-table tr td:last-child {
							text-align: right;
							padding-right: 50px;
						}
						.day-book-table .main-heading {
							padding-left: 10px;
							font-weight: bold;
						}
						.day-book-table .sub-heading {
							padding-left: 20px;
							font-weight: bold;
						}
						.day-book-table .sub-value {
							padding-right: 10px!important;
							font-weight: bold;
						}
					</style>
				`;

                printWindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1500));
                printWindow.print();
                printWindow.close();
            }
        }
    })
</script>
@endpush