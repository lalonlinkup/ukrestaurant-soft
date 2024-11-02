@extends('master')
@section('title', 'Investment Transaction Report')
@section('breadcrumb_title', 'Investment Transaction Report')
@push('style')
<style scoped>
    .v-select .dropdown-toggle {
        padding: 0px;
        height: 30px !important;
    }

    .v-select .dropdown-menu {
        width: 350px !important;
    }

    table>thead>tr>th {
        text-align: center;
    }
</style>
@endpush
@section('content')
<div id="transactionReport">
    <div class="row" style="margin: 0px;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Investment Transaction Report</legend>
            <div class="control-group">
                <form @submit.prevent="getTransactions">
                    <div class="col-md-1 col-xs-12 no-padding-right">
                        <div class="form-group">
                            <label for="">Account</label>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <v-select :options="computedAccounts" v-model="selectedAccount" label="display_name" @input="resetData"></v-select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12 no-padding">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Trans. Type</label>
                            <select class="form-select no-padding" style="width: 100%;" v-model="filter.type" @change="resetData">
                                <option value="">All</option>
                                <option value="Receive">Receive</option>
                                <option value="Profit">Profit</option>
                                <option value="Payment">Payment</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateFrom" @change="resetData">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateTo" @change="resetData">
                        </div>
                    </div>

                    <div class="col-md-1 col-xs-12">
                        <div class="form-group">
                            <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>

    <div class="row" style="display:none;" v-bind:style="{display: transactions.length > 0 && showReport ? '' : 'none'}">
        <div class="col-md-12 text-right">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="reportContent">
                <table class="table table-bordered table-condensed" id="transactionsTable">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Transaction ID</th>
                            <th>Transaction Date</th>
                            <th>Account Name</th>
                            <th>Transaction Type </th>
                            <th>Note</th>
                            <th style="text-align:right">In Amount</th>
                            <th style="text-align:right">Out Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(transaction, sl) in transactions">
                            <td style="text-align:right">@{{ sl + 1 }}</td>
                            <td>@{{transaction.invoice}}</td>
                            <td>@{{ transaction.date | formatDateTime('DD-MM-YYYY') }}</td>
                            <td style="text-align: left;">@{{ transaction.investment_account.name }} - @{{ transaction.investment_account.code }}</td>
                            <td>@{{ transaction.type }}</td>
                            <td>@{{ transaction.note }}</td>
                            <td style="text-align:right">@{{ transaction.type == "Receive" || transaction.type == "Profit" ? transaction.amount : 0 | decimal }}</td>
                            <td style="text-align:right">@{{ transaction.type == "Payment" ? transaction.amount : 0 | decimal }}</td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="6" style="text-align:right;">Total &nbsp;</td>
                            <td style="text-align:right;">
                                @{{ transactions.reduce((prev, curr) => {
                                        return prev + parseFloat(curr.type == 'Receive' || curr.type == 'Profit' ? curr.amount : 0)
                                    }, 0) | decimal }}
                            </td>
                            <td style="text-align:right;">
                                @{{ transactions.reduce((prev, curr) => {
                                        return prev + parseFloat(curr.type == 'Payment' ? curr.amount : 0)
                                    }, 0) | decimal }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
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
    var transactionReport = new Vue({
        el: "#transactionReport",

        data() {
            return {
                accounts: [],
                selectedAccount: null,
                transactions: [],
                filter: {
                    accountId: null,
                    type: '',
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD')
                },

                onProgress: false,
                showReport: null,
            }
        },

        computed: {
            computedAccounts() {
                let accounts = this.accounts.filter(account => account.status == 'a');
                return accounts.map(account => {
                    account.display_name = `${account.name} - ${account.code}`;
                    return account;
                })
            }
        },

        filters: {
            decimal(value) {
                return value == null ? parseFloat(0).toFixed(2) : parseFloat(value).toFixed(2);
            },
            formatDateTime(dt, format) {
                return dt == '' || dt == null ? '' : moment(dt).format(format);
            }
        },

        created() {
            this.getAccounts();
        },

        methods: {
            getAccounts() {
                axios.get('/get-investment-accounts')
                    .then(res => {
                        let r = res.data;
                        this.accounts = r;
                    })
            },

            getTransactions() {
                if (this.selectedAccount != null) {
                    this.filter.accountId = this.selectedAccount.id;
                } else {
                    this.filter.accountId = null;
                }

                this.showReport = false
                this.onProgress = true
                axios.post('/get-investment-transactions', this.filter)
                    .then(res => {
                        let r = res.data;
                        this.transactions = r;
                        this.onProgress = false
                        this.showReport = true
                    })
                    .catch(err => {
                        this.showReport = null
                        this.onProgress = false
                        var r = JSON.parse(err.request.response);
                        if (err.request.status == '422' && r.errors != undefined && typeof r.errors ==
                            'object') {
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

            resetData() {
                this.transactions = [];
            },

            async print() {
                let accountText = '';
                if (this.selectedAccount != null) {
                    accountText = `<strong>Account: </strong> ${this.selectedAccount.name} - ${this.selectedAccount.code}<br />`;
                }

                typeText = '';
                if (this.filter.type != '') {
                    typeText = `<strong>Transaction Type: </strong> ${this.filter.type}`;
                }

                dateText = '';
                if (this.filter.dateFrom != '' && this.filter.dateTo != '') {
                    dateText =
                        `Statement from <strong>${this.filter.dateFrom}</strong> to <strong>${this.filter.dateTo}</strong>`;
                }
                let reportContent = `
                        <div class="container">
                            <h4 style="text-align:center">Investment Transaction Report</h4 style="text-align:center">
                            <div class="row">
                                <div class="col-xs-6">${accountText} ${typeText}</div>
                                <div class="col-xs-6 text-right">${dateText}</div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    ${document.querySelector('#reportContent').innerHTML}
                                </div>
                            </div>
                        </div>
                    `;

                var printWindow = window.open('', 'PRINT',
                    `width=${screen.width}, height=${screen.height}`);
                printWindow.document.write(`
                        @include('administration/reports/reportHeader')
                    `);

                printWindow.document.head.innerHTML += `
                        <style>
                            #transactionsTable th{
                                text-align: center;
                            }
                        </style>
                    `;
                printWindow.document.body.innerHTML += reportContent;

                printWindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                printWindow.print();
                printWindow.close();
            }
        }
    })
</script>
@endpush