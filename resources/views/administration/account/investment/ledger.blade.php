@extends('master')
@section('title', 'Investment Ledger')
@section('breadcrumb_title', 'Investment Ledger')
@push('style')
<style scoped>
    .v-select .dropdown-toggle {
        padding: 0px;
        height: 30px !important;
    }

    .v-select .dropdown-menu {
        width: 250px !important;
        overflow-y: auto !important;
    }

    table>thead>tr>th {
        text-align: center;
    }
</style>
@endpush
@section('content')
<div id="InvestmentLedger">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Investment Ledger</legend>
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
                            <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Show Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>

    <div class="row" style="display:none;" v-bind:style="{display: transactions.length > 0 && showReport ? '' : 'none'}" v-if="transactions.length > 0 && showReport">
        <div class="col-md-12" style="margin-bottom: 10px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="reportContent">
                <table class="table table-bordered table-condensed" id="transactionsTable">
                    <thead>
                        <tr>
                            <th>Transaction Date</th>
                            <th>Description</th>
                            <th>Note</th>
                            <th>Receive</th>
                            <th>Profit</th>
                            <th>Payment</th>
                            <th>Balance</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="6" style="text-align:left;">Previous Balance</td>
                            <td style="text-align:right;">@{{ previousBalance | decimal }}</td>
                        </tr>
                        <tr v-for="(transaction, sl) in transactions">
                            <td style="text-align:left;">@{{ transaction.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td style="text-align:left;">@{{ transaction.description }}</td>
                            <td style="text-align:left;">@{{ transaction.note }}</td>
                            <td style="text-align:right">@{{ transaction.receive | decimal }}</td>
                            <td style="text-align:right">@{{ transaction.profit | decimal }}</td>
                            <td style="text-align:right">@{{ transaction.payment | decimal }}</td>
                            <td style="text-align:right">@{{ transaction.balance | decimal }}</td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="3" style="text-align:right;">Total</td>
                            <td style="text-align:right;">@{{ transactions.reduce((p, c) => { return +p + +c.receive }, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ transactions.reduce((p, c) => { return +p + +c.profit }, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ transactions.reduce((p, c) => { return +p + +c.payment }, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ transactions[transactions.length - 1].balance | decimal }}</td>
                        </tr>
                    </tbody>
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
    var InvestmentLedger = new Vue({
        el: "#InvestmentLedger",

        data() {
            return {
                accounts: [],
                selectedAccount: null,
                previousBalance: 0.00,
                transactions: [],
                filter: {
                    accountId: null,
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD'),
                },

                onProgress: false,
                showReport: null,
            }
        },

        computed: {
            computedAccounts() {
                let accounts = this.accounts.filter(account => account.status == 'a');
                return accounts.map(account => {
                    account.display_name = `${account.code} (${account.name})`;
                    return account;
                })
            }
        },

        filters: {
            decimal(value) {
                return value == null ? parseFloat(0).toFixed(2) : parseFloat(value).toFixed(2);
            },

            dateFormat(dt, format) {
                return moment(dt).format(format);
            }
        },

        watch: {
            selectedAccount(account) {
                this.filter.accountId = account?.id ?? null;
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
                if (this.selectedAccount == null) {
                    toastr.error('Select account');
                    return;
                }

                this.onProgress = true;
                this.showReport = false;
                axios.post('/get-investment-ledger', this.filter)
                    .then(res => {
                        this.previousBalance = res.data.previousBalance;
                        this.transactions = res.data.transactions;
                        this.onProgress = false;
                        this.showReport = true;
                    })
                    .catch(err => {
                        this.onProgress = false
                        this.showReport = null
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
                this.previousBalance = 0;
                this.transactions = [];
            },

            async print() {
                let accountText = '';
                if (this.selectedAccount != null) {
                    accountText = `<strong>Account: </strong> ${this.selectedAccount.number} (${this.selectedAccount.bank_name})<br>`;
                }

                dateText = '';
                if (this.filter.dateFrom != '' && this.filter.dateTo != '') {
                    dateText = `Statement from <strong>${this.filter.dateFrom}</strong> to <strong>${this.filter.dateTo}</strong>`;
                }

                let reportContent = `
                        <div class="container">
                            <h4 style="text-align:center">Investment Ledger</h4>
                            <div class="row">
                                <div class="col-xs-6">${accountText}</div>
                                <div class="col-xs-6 text-right">${dateText}</div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    ${document.querySelector('#reportContent').innerHTML}
                                </div>
                            </div>
                        </div>
                    `;

                var printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
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