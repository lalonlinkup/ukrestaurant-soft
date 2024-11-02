@extends('master')
@section('title', 'Balance Sheet')
@section('breadcrumb_title', 'Balance Sheet')
@push('style')
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
@endpush
@section('content')
<div id="balanceSheet">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Balance Sheet</legend>
            <div class="control-group">
                <form action="" class="form-inline" @submit.prevent="getStatements">
                    <div class="form-group">
                        <label for="">Select Date</label>
                        <input type="date" class="form-control" v-model="date">
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
        <div class="row">
            <div id="printContent">
                <div class="col-xs-6">
                    <table class="balancesheet-table">
                        <thead>
                            <tr>
                                <td colspan="2">
                                    <h3>Asset</h3>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Cash</th>
                                <td style="text-align:right;">@{{cash_balance | decimal}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <table style="width: 100%;">
                                        <tr>
                                            <th colspan="2">Bank:-</th>
                                        </tr>
                                        <tr v-for="account in bank_accounts">
                                            <td>@{{account.name}}, @{{account.number}}-@{{account.bank_name}}</td>
                                            <td>@{{account.balance | decimal}}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="text-align:right;">@{{bank_balance | decimal}}</td>
                            </tr>
                            <tr>
                                <th>Guest Due</th>
                                <td style="text-align:right;">@{{customer_due | decimal}}</td>
                            </tr>

                            <tr>
                                <th>Bad Debt</th>
                                <td style="text-align:right;">@{{bad_debt | decimal}}</td>
                            </tr>

                            <tr :style="{display: supplier_prev_due != 0 ? '' : 'none'}">
                                <th>Supplier Previous Due Adjustment</th>
                                <td style="text-align:right;">@{{supplier_prev_due | decimal}}</td>
                            </tr>


                            <tr :style="{display: loss != 0 ? '' : 'none'}">
                                <th>Loss</th>
                                <td style="text-align:right;">@{{loss | decimal}}</td>
                            </tr>

                            <tr style="display: none;" v-bind:style="{ display: mis_ad_left > 0 ? '' : 'none' }">
                                <th>Miscellaneous Adjustment</th>
                                <td style="text-align:right;">@{{mis_ad_left | decimal}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="text-align:right;">Total Asset</th>
                                <td style="text-align:right;">@{{totalAsset | decimal}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-xs-6">
                    <table class="balancesheet-table">
                        <thead>
                            <tr>
                                <td colspan="2">
                                    <h3>Liability</h3>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <table style="width: 100%;">
                                        <tr>
                                            <th colspan="2">Investment:-</th>
                                        </tr>
                                        <tr v-for="account in invest_accounts">
                                            <td>@{{account.name}} (@{{account.code}})</td>
                                            <td>@{{account.balance | decimal}}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="text-align:right;">@{{invest_balance | decimal}}</td>
                            </tr>

                            <tr>
                                <td>
                                    <table style="width: 100%;">
                                        <tr>
                                            <th colspan="2">Loan:-</th>
                                        </tr>
                                        <tr v-for="account in loan_accounts">
                                            <td>@{{account.name}}, @{{account.bank_name}} @{{account.number}}</td>
                                            <td>@{{account.balance | decimal}}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="text-align:right;">@{{loan_balance | decimal}}</td>
                            </tr>
                            <tr>
                                <th>Supplier Due</th>
                                <td style="text-align:right;">@{{supplier_due | decimal}}</td>
                            </tr>

                            <tr :style="{display: customer_prev_due != 0 ? '' : 'none'}">
                                <th>Guest Previous Due Adjustment</th>
                                <td style="text-align:right;">@{{customer_prev_due | decimal}}</td>
                            </tr>

                            <tr :style="{display: net_profit != 0 ? '' : 'none'}">
                                <th>Profit</th>
                                <td style="text-align:right;">@{{net_profit | decimal}}</td>
                            </tr>

                            <tr style="display: none;" v-bind:style="{ display: mis_ad_right > 0 ? '' : 'none' }">
                                <th>Miscellaneous Adjustment</th>
                                <td style="text-align:right;">@{{mis_ad_right | decimal}}</td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="text-align:right;">Total Liability</th>
                                <td style="text-align:right;">@{{totalLiability | decimal}}</td>
                            </tr>
                        </tfoot>
                    </table>
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
                date: moment().format('YYYY-MM-DD'),
                cash_balance: 0.00,
                bank_balance: 0.00,
                bank_accounts: [],
                customer_due: 0.00,
                bad_debt: 0.00,
                supplier_prev_due: 0.00,
                customer_prev_due: 0.00,
                invest_balance: 0.00,
                invest_accounts: [],
                loan_balance: 0.00,
                loan_accounts: [],
                supplier_due: 0.00,
                net_profit: 0.00,
                loss: 0.00,
                totalAsset: 0.00,
                totalLiability: 0.00,
                mis_ad_left: 0.00,
                mis_ad_right: 0.00,
                showReport: null
            }
        },
        filters: {
            decimal(value) {
                return value == null ? 0.00 : parseFloat(value).toFixed(2);
            }
        },
        methods: {
            async getStatements() {
                this.showReport = false;
                await axios.post('/get-balance-sheet', {
                        date: this.date
                    })
                    .then(async res => {
                        if (res.data.net_profit) {
                            if (res.data.net_profit >= 0) {
                                this.net_profit = res.data.net_profit;
                                this.loss = 0.00;
                            } else {
                                this.loss = Math.abs(res.data.net_profit);
                                this.net_profit = 0.00;
                            }
                        } else {
                            this.net_profit = 0.00;
                            this.loss = 0.00;
                        }

                        this.cash_balance = res.data.cash_balance ?? 0;
                        this.bank_accounts = res.data.bank_accounts;
                        this.customer_due = res.data.customer_dues ?? 0;
                        this.bad_debt = res.data.bad_debts ?? 0;
                        this.supplier_prev_due = res.data.supplier_prev_due ?? 0;
                        this.customer_prev_due = res.data.customer_prev_due ?? 0;
                        this.invest_accounts = res.data.invest_accounts;
                        this.loan_accounts = res.data.loan_accounts;
                        this.supplier_due = res.data.supplier_dues ?? 0;
                        this.bank_balance = this.bank_accounts.reduce((prev, curr) => {
                            return prev + parseFloat(curr.balance);
                        }, 0).toFixed(2);

                        this.invest_balance = this.invest_accounts.reduce((prev, curr) => {
                            return prev + parseFloat(curr.balance);
                        }, 0).toFixed(2);

                        this.loan_balance = this.loan_accounts.reduce((prev, curr) => {
                            return prev + parseFloat(curr.balance);
                        }, 0).toFixed(2);


                        let totalAsset = parseFloat(this.cash_balance) +
                            parseFloat(this.bank_balance) +
                            parseFloat(this.customer_due) +
                            parseFloat(this.bad_debt) +
                            parseFloat(this.supplier_prev_due) +
                            parseFloat(this.loss);

                        let totalLiability = parseFloat(this.invest_balance) +
                            parseFloat(this.loan_balance) +
                            parseFloat(this.net_profit) +
                            parseFloat(this.customer_prev_due) +
                            parseFloat(this.supplier_due);

                        if (totalAsset > totalLiability) {
                            this.mis_ad_right = totalAsset - totalLiability;
                            this.mis_ad_left = 0.00;

                        } else if (totalAsset < totalLiability) {
                            this.mis_ad_left = totalLiability - totalAsset;
                            this.mis_ad_right = 0.00;
                        } else {
                            this.mis_ad_left = 0.00;
                            this.mis_ad_right = 0.00;
                        }

                        this.totalAsset = totalAsset + this.mis_ad_left;
                        this.totalLiability = totalLiability + this.mis_ad_right;

                        this.showReport = true;
                    })
                    .catch(err => {
                        this.showReport = null;
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
                    });
            },

            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Balance Sheet</h4 style="text-align:center">
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