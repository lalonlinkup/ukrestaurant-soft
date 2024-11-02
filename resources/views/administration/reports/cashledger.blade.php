@extends('master')
@section('title', 'Cash Ledger')
@section('breadcrumb_title', 'Cash Ledger')
@push('style')
<style scoped>
    table>thead>tr>th {
        text-align: center;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
        height: 30px !important;
    }

    .v-select .dropdown-menu {
        width: 350px !important;
        overflow-y: auto !important;
    }
</style>
@endpush
@section('content')
<div id="cashLedger">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue text-center">
            <legend class="scheduler-border">Cash Ledger Report</legend>
            <div class="control-group">
                <form @submit.prevent="getCashLedger">
                    <div class="row col-md-6 col-xs-12">
                        <div class="col-md-6 col-xs-12 no-padding-right">
                            <div class="form-group" style="display: flex;align-items:center;">
                                <label for="" style="width:150px;">Select Date</label>
                                <input type="date" style="height: 30px;" class="form-control" v-model="dateFrom" />
                            </div>
                        </div>
                        <div class="col-md-1 no-padding">
                            <div class="form-group">
                                <label for="" style="margin: 0;margin-top: 4px;">To</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12 no-padding-left">
                            <div class="form-group">
                                <input type="date" style="height: 30px;" class="form-control" v-model="dateTo" />
                            </div>
                        </div>
                        <div class="col-md-1 col-xs-12">
                            <div class="form-group">
                                <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Show Report</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>

    <div class="row" v-if="showReport" style="display: none;" :style="{display: showReport ? '': 'none'}">
        <div class="col-md-12 col-xs-12">
            <a href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>
            <div class="table-responsive" id="reportTable">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align:center">Date</th>
                            <th style="text-align:center">Description</th>
                            <th style="text-align:center">Cash In</th>
                            <th style="text-align:center">Cash Out</th>
                            <th style="text-align:center">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td style="text-align:left;">Previous Balance</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ parseFloat(previousBalance) | decimal }}</td>
                        </tr>
                        <tr v-for="item in ledgers">
                            <td>@{{ item.date | dateFormat('DD-MM-YYYY') }}</td>
                            <td style="text-align:left;">@{{ item.description }}</td>
                            <td style="text-align:right;">@{{ parseFloat(item.in_amount) | decimal }}</td>
                            <td style="text-align:right;">@{{ parseFloat(item.out_amount) | decimal }}</td>
                            <td style="text-align:right;">@{{ parseFloat(item.balance) | decimal }}</td>
                        </tr>
                    </tbody>
                    <tbody v-if="ledgers.length == 0">
                        <tr>
                            <td colspan="5">No records found</td>
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
    new Vue({
        el: '#cashLedger',
        data() {
            return {
                dateFrom: moment().format('YYYY-MM-DD'),
                dateTo: moment().format('YYYY-MM-DD'),

                ledgers: [],
                previousBalance: 0,

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
        methods: {
            getCashLedger() {
                let filter = {
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-cash-ledger", filter)
                    .then(res => {
                        let r = res.data;
                        this.previousBalance = r.previousBalance
                        this.ledgers = r.ledgers
                        this.onProgress = false
                        this.showReport = true
                    })
                    .catch(err => {
                        this.onProgress = false
                        this.showReport = null
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

            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Cash Ledger</h4 style="text-align:center">
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