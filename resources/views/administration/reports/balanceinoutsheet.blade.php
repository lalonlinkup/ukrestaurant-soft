@extends('master')
@section('title', 'Balance In Out')
@section('breadcrumb_title', 'Balance In Out')
@push('style')
<style scoped>
    #balanceSheet .buttons {
        margin-top: -5px;
    }

    .balancesheet-table {
        width: 100%;
        border-collapse: collapse;
    }

    .balancesheet-table thead {
        text-align: center;
    }

    .balancesheet-table tfoot {
        font-weight: bold;
        background-color: #eaf3fd;
    }

    .balancesheet-table td,
    .balancesheet-table th {
        border: 1px solid #ccc;
        padding: 5px;
    }
</style>
@endpush
@section('content')
<div id="balanceSheet">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Balance In Out</legend>
            <div class="control-group">
                <form action="" class="form-inline" @submit.prevent="getStatements">
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

    <div style="display:none;" v-bind:style="{display: showReport ? '' : 'none'}">
        <div class="row">
            <div class="col-xs-12 text-right">
                <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>

        <div id="reportTable">
            <div class="row">
                <div class="col-xs-6">
                    <table class="balancesheet-table">
                        <thead>
                            <tr>
                                <td colspan="2">
                                    <h3>Cash In</h3>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Sales</td>
                                <td style="text-align:right;">@{{ totalSales | decimal }}</td>
                            </tr>
                            <tr>
                                <td>Guest Payment Received</td>
                                <td style="text-align:right;">@{{ totalReceivedFromCustomers | decimal }}</td>
                            </tr>
                            <tr>
                                <td>Cash Received</td>
                                <td style="text-align:right;">@{{ totalCashReceived | decimal }}</td>
                            </tr>
                            <tr>
                                <td>Withdraw from Bank</td>
                                <td style="text-align:right;">@{{ totalBankWithdraw | decimal }}</td>
                            </tr>

                            <tr>
                                <td>Loan Received</td>
                                <td style="text-align:right;">@{{ totalLoanReceived | decimal }}</td>
                            </tr>

                            <tr>
                                <td>Invest Received</td>
                                <td style="text-align:right;">@{{ totalInvestReceived | decimal }}</td>
                            </tr>
                            <tr>
                                <td>Supplier Payment Received</td>
                                <td style="text-align:right;">@{{ totalReceivedFromSuppliers | decimal }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align:right;">Total Cash In</td>
                                <td style="text-align:right;">@{{ totalCashIn | decimal }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-xs-6">
                    <table class="balancesheet-table">
                        <thead>
                            <tr>
                                <td colspan="2">
                                    <h3>Cash Out</h3>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Purchase</td>
                                <td style="text-align:right;">@{{ totalPurchase | decimal }}</td>
                            </tr>
                            <tr>
                                <td>Supplier Payment Paid</td>
                                <td style="text-align:right;">@{{ totalPaidToSuppliers | decimal }}</td>
                            </tr>
                            <tr>
                                <td>Cash Paid</td>
                                <td style="text-align:right;">@{{ totalCashPaid | decimal }}</td>
                            </tr>
                            <tr>
                                <td>Deposit to Bank</td>
                                <td style="text-align:right;">@{{ totalBankDeposit | decimal }}</td>
                            </tr>

                            <tr>
                                <td>Loan Payment</td>
                                <td style="text-align:right;">@{{ totalLoanPayment | decimal }}</td>
                            </tr>

                            <tr>
                                <td>Invest Payment</td>
                                <td style="text-align:right;">@{{ totalInvestPayment | decimal }}</td>
                            </tr>
                            <tr>
                                <td>Employee Payment</td>
                                <td style="text-align:right;">@{{ totalEmployeePayments | decimal }}</td>
                            </tr>
                            <tr>
                                <td>Guest Payment Paid</td>
                                <td style="text-align:right;">@{{ totalPaidToCustomers | decimal }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align:right;">Total Cash Out</td>
                                <td style="text-align:right;">@{{ totalCashOut | decimal }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row" style="margin-top: 15px;">
                <div class="col-xs-12">
                    <div style="padding:5px;background-color:#e27a07;text-align:center;color:white;">
                        <h4>Cash Balance: @{{ cashBalance | decimal }}</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div style="display:none;" v-bind:style="{display: showReport == false ? '' : 'none'}">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="{{asset('loading.gif')}}" style="width: 90px;"> Loading..
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#balanceSheet',
        data() {
            return {
                filter: {
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD')
                },
                bookings: [],
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
                loanInitial: 0.00,
                totalAssetsCost: 0.00,
                totalAssetsSales: 0.00,
                loanPayments: [],
                investReceives: [],
                investPayments: [],
                employeePayments: [],
                showReport: null,
                fixed: 2
            }
        },
        filters: {
            decimal(value) {
                return value == null ? parseFloat(0).toFixed(2) : parseFloat(value).toFixed(2);
            }
        },
        computed: {
            totalSales() {
                return this.bookings.reduce((prev, curr) => {
                    return prev + parseFloat(curr.paid)
                }, 0).toFixed(this.fixed);
            },
            totalPurchase() {
                return this.purchases.reduce((prev, curr) => {
                    return prev + parseFloat(curr.paid)
                }, 0).toFixed(this.fixed);
            },
            totalReceivedFromCustomers() {
                return this.receivedFromCustomers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(this.fixed);
            },
            totalPaidToCustomers() {
                return this.paidToCustomers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(this.fixed);
            },
            totalReceivedFromSuppliers() {
                return this.receivedFromSuppliers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(this.fixed);
            },
            totalPaidToSuppliers() {
                return this.paidToSuppliers.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(this.fixed);
            },
            totalCashReceived() {
                return this.cashReceived.reduce((prev, curr) => {
                    return prev + parseFloat(curr.in_amount)
                }, 0).toFixed(this.fixed);
            },
            totalCashPaid() {
                return this.cashPaid.reduce((prev, curr) => {
                    return prev + parseFloat(curr.out_amount)
                }, 0).toFixed(this.fixed);
            },
            totalBankDeposit() {
                return this.bankDeposits.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(this.fixed);
            },
            totalBankWithdraw() {
                return this.bankWithdraws.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(this.fixed);
            },
            totalLoanReceived() {
                return (this.loanReceives.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0) + +this.loanInitial).toFixed(this.fixed);
            },
            totalLoanPayment() {
                return this.loanPayments.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(this.fixed);
            },

            totalInvestReceived() {
                return this.investReceives.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(this.fixed);
            },
            totalInvestPayment() {
                return this.investPayments.reduce((prev, curr) => {
                    return prev + parseFloat(curr.amount)
                }, 0).toFixed(this.fixed);
            },
            totalEmployeePayments() {
                return this.employeePayments.reduce((prev, curr) => {
                    return prev + parseFloat(curr.total_payment_amount)
                }, 0).toFixed(this.fixed);
            },
            totalCashIn() {
                return parseFloat(this.totalSales) +
                    parseFloat(this.totalReceivedFromCustomers) +
                    parseFloat(this.totalReceivedFromSuppliers) +
                    parseFloat(this.totalCashReceived) +
                    parseFloat(this.totalLoanReceived) +
                    parseFloat(this.totalInvestReceived) +
                    parseFloat(this.totalAssetsSales) +
                    parseFloat(this.totalBankWithdraw);
            },
            totalCashOut() {
                return parseFloat(this.totalPurchase) +
                    parseFloat(this.totalPaidToCustomers) +
                    parseFloat(this.totalPaidToSuppliers) +
                    parseFloat(this.totalCashPaid) +
                    parseFloat(this.totalBankDeposit) +
                    parseFloat(this.totalLoanPayment) +
                    parseFloat(this.totalInvestPayment) +
                    parseFloat(this.totalAssetsCost) +
                    parseFloat(this.totalEmployeePayments);
            },
            cashBalance() {
                return parseFloat(this.totalCashIn) - parseFloat(this.totalCashOut);
            }
        },
        methods: {
            async getStatements() {
                this.showReport = false;
                await this.getSales();
                await this.getPurchases();
                await this.getReceivedFromCustomers();
                await this.getPaidToCustomers();
                await this.getPaidToSuppliers();
                await this.getReceivedFromSuppliers();
                await this.getCashReceived();
                await this.getCashPaid();
                await this.getBankDeposits();
                await this.getBankWithdraws();
                await this.getLoanReceives();
                await this.getLoanPayments();
                await this.getInvestReceives();
                await this.getInvestPayments();
                await this.getEmployeePayments();
                this.showReport = true;
            },

            async getSales() {
                await axios.post('/get-booking', this.filter)
                    .then(res => {
                        this.bookings = res.data.map(item => {
                            item.paid = parseFloat(item.advance)
                            return item;
                        });
                    })
            },

            async getPurchases() {
                await axios.post('/get-purchase', this.filter)
                    .then(res => {
                        this.purchases = res.data;
                    })

                await axios.post('/get-material-purchase', this.filter)
                    .then(res => {
                        let purchases = res.data.map(purchase => {
                            return {
                                invoice: purchase.invoice,
                                date: purchase.date,
                                supplier_name: purchase.supplier_name,
                                paid: purchase.paid
                            }
                        })

                        this.purchases = [...this.purchases, ...purchases];
                    })
            },

            async getReceivedFromCustomers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CR'
                }
                await axios.post('/get-customer-payments', filter)
                    .then(res => {
                        this.receivedFromCustomers = res.data.filter(p => p.method != 'bank');
                    })
            },

            async getPaidToCustomers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CP'
                }
                await axios.post('/get-customer-payments', filter)
                    .then(res => {
                        this.paidToCustomers = res.data.filter(p => p.method != 'bank');
                    })
            },

            async getPaidToSuppliers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CP'
                }
                await axios.post('/get-supplier-payments', filter)
                    .then(res => {
                        this.paidToSuppliers = res.data.filter(p => p.method != 'bank');
                    })
            },

            async getReceivedFromSuppliers() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'CR'
                }
                await axios.post('/get-supplier-payments', filter)
                    .then(res => {
                        this.receivedFromSuppliers = res.data.filter(p => p.method != 'bank');
                    })
            },

            async getCashReceived() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'In Cash'
                }
                await axios.post('/get-cash-transactions', filter)
                    .then(res => {
                        this.cashReceived = res.data;
                    })
            },

            async getCashPaid() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Out Cash'
                }
                await axios.post('/get-cash-transactions', filter)
                    .then(res => {
                        this.cashPaid = res.data;
                    })
            },

            async getBankDeposits() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'deposit'
                }
                await axios.post('/get-bank-transactions', filter)
                    .then(res => {
                        this.bankDeposits = res.data;
                    })
            },

            async getBankWithdraws() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'withdraw'
                }
                await axios.post('/get-bank-transactions', filter)
                    .then(res => {
                        this.bankWithdraws = res.data;
                    })
            },

            async getLoanReceives() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Receive'
                }
                await axios.post('/get-loan-transactions', filter).then(res => {
                    this.loanReceives = res.data;
                })

                await axios.post('/get-loan-accounts', this.filter).then(res => {
                    this.loanInitial = res.data.reduce((prev, curr) => {
                        return prev + +parseFloat(curr.initial_balance)
                    }, 0);
                })
            },

            async getLoanPayments() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Payment'
                }
                await axios.post('/get-loan-transactions', filter).then(res => {
                    this.loanPayments = res.data;
                })
            },

            async getInvestReceives() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Receive'
                }
                await axios.post('/get-investment-transactions', filter).then(res => {
                    this.investReceives = res.data;
                })
            },

            async getInvestPayments() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'Payment'
                }
                await axios.post('/get-investment-transactions', filter).then(res => {
                    this.investPayments = res.data;
                })
            },

            async getEmployeePayments() {
                await axios.post('/get-payments', this.filter)
                    .then(res => {
                        this.employeePayments = res.data;
                    })
            },

            async getAssetsCost() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'buy'
                }

                await axios.post('/get-asset', filter)
                    .then(res => {
                        this.totalAssetsCost = res.data.reduce((prev, curr) => {
                            return prev + +parseFloat(curr.amount)
                        }, 0);
                    })
            },

            async getAssetsSales() {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    type: 'sale'
                }

                await axios.post('/get-asset', filter)
                    .then(res => {
                        this.totalAssetsSales = res.data.reduce((prev, curr) => {
                            return prev + +parseFloat(curr.amount)
                        }, 0);
                    })
            },

            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Balance In-Out Sheet</h4 style="text-align:center">
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
                    <style>
                        #balanceSheet .buttons {
                            margin-top: -5px;
                        }

                        .balancesheet-table {
                            width: 100%;
                            border-collapse: collapse;
                        }

                        .balancesheet-table thead {
                            text-align: center;
                        }

                        .balancesheet-table tfoot {
                            font-weight: bold;
                            background-color: #eaf3fd;
                        }

                        .balancesheet-table td,
                        .balancesheet-table th {
                            border: 1px solid #ccc;
                            padding: 5px;
                        }
                    </style>
                    @include('administration/reports/reportHeader')
				`);

                mywindow.document.body.innerHTML += reportContent;

                mywindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                mywindow.print();
                mywindow.close();
            }
        }
    })
</script>
@endpush