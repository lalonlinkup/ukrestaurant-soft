@extends('master')
@section('title', 'Bank Transaction Report')
@section('breadcrumb_title', 'Bank Transaction Report')
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
<div id="bankTransactionReport">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Bank Transaction Report</legend>
            <div class="control-group">
                <form @submit.prevent="getTransactions">
                    <div class="col-md-1 col-xs-12 no-padding-right">
                        <div class="form-group">
                            <label for="">Account</label>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <v-select :options="accounts" v-model="selectedAccount" label="display_name" @input="onChangeAccount" placeholder="Select Account"></v-select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 no-padding">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Trans. Type</label>
                            <select class="form-select no-padding" style="width: 100%;" v-model="filter.type">
                                <option value="">All</option>
                                <option value="deposit">Deposit</option>
                                <option value="withdraw">Withdraw</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateFrom">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateTo">
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

    <div class="row" style="display:none;" v-bind:style="{display: transactions.length > 0 && showReport ? '' : 'none'}">
        <div class="col-md-12 text-right">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="printContent">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Transaction Date</th>
                            <th>Discription</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Bank Name</th>
                            <th>Note</th>
                            <th>Diposit</th>
                            <th>Withdraw</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(transaction, sl) in transactions">
                            <td>@{{ sl + 1 }}</td>
                            <td>@{{ transaction.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td style="text-align: left;">@{{ transaction.description }}</td>
                            <td>@{{ transaction.name }}</td>
                            <td>@{{ transaction.number }}</td>
                            <td>@{{ transaction.bank_name }}</td>
                            <td>@{{ transaction.note }}</td>
                            <td style="text-align:right;">@{{ transaction.deposit | decimal }}</td>
                            <td style="text-align:right;">@{{ transaction.withdraw | decimal }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" style="text-align:right;font-weight:bold;">Total</td>
                            <td style="text-align:right;font-weight:bold;">@{{ transactions.reduce((p, c) => { return p + parseFloat(c.deposit) }, 0) | decimal }}</td>
                            <td style="text-align:right;font-weight:bold;">@{{ transactions.reduce((p, c) => { return p + parseFloat(c.withdraw) }, 0) | decimal }}</td>
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
    var bankTransactionReport = new Vue({
        el: "#bankTransactionReport",

        data() {
            return {
                filter: {
                    type: '',
                    bankId: null,
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD'),
                    for: 'report'
                },
                accounts: [],
                selectedAccount: null,
                transactions: [],
                onProgress: false,
                showReport: null,
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

        created() {
            this.getAccounts();
        },

        methods: {
            getAccounts() {
                axios.get('/get-bank-accounts').then(res => {
                    this.accounts = res.data.map(item => {
                        item.display_name = `${item.name} - ${item.number}`;
                        return item;
                    });
                })
            },

            onChangeAccount() {
                if (this.selectedAccount == null || this.selectedAccount.id == undefined) {
                    this.filter.bankId = null;
                    return;
                }
                this.filter.bankId = this.selectedAccount.id;
            },

            getTransactions() {
                this.onProgress = true;
                this.showReport = false;
                axios.post('/get-bank-ledger', this.filter).then(res => {
                    let r = res.data;
                    this.transactions = r;
                    this.onProgress = false;
                    this.showReport = true;
                }).catch(err => {
                    this.onProgress = false;
                    this.showReport = null;
                    var r = JSON.parse(err.request.response);
                    if (r.errors) {
                        $.each(r.errors, (index, value) => {
                            $.each(value, (ind, val) => {
                                toastr.error(val)
                            })
                        })
                    } else {
                        toastr.error(r.message);
                    }
                })
            },

            async print() {
                let dateText = "";
                if (this.filter.dateFrom != null && this.filter.dateTo != null) {
                    dateText = `Statement from <strong>${this.filter.dateFrom}</strong>  to <strong>${this.filter.dateTo}</strong>`;
                }
                let printContent = `
                    <div class="container">
                        <h4 style="text-align:center">Bank Transaction Report</h4>
                        <div class="row">
                            <div class="col-xs-6 col-xs-offset-6 text-right">
                                ${dateText}
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                ${document.querySelector('#printContent').innerHTML}
                            </div>
                        </div>
                    </div>
                `;

                let printWindow = window.open('', '', `width=${screen.width}, height=${screen.height}`);
                printWindow.document.write(`
                    @include('administration/reports/reportHeader');
                `);

                printWindow.document.body.innerHTML += printContent;
                printWindow.focus();
                await new Promise(r => setTimeout(r, 1000));
                printWindow.print();
                printWindow.close();
            }
        },
    })
</script>
@endpush