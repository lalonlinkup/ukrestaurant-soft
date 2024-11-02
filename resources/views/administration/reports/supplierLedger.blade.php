@extends('master')
@section('title', 'Supplier Ledger')
@section('breadcrumb_title', 'Supplier Ledger')
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
<div id="getSupplierLedgerlist">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Supplier Ledger</legend>
            <div class="control-group">
                <form @submit.prevent="getSupplierLedger">
                    <div class="col-md-4 col-xs-12">
                    <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:100px;">Supplier</label>
                            <v-select :options="suppliers" style="width: 100%;" v-model="selectedSupplier" label="display_name" @search="onSearchSupplier"></v-select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="dateFrom" />
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="dateTo" />
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
                            <th style="text-align:center">Bill</th>
                            <th style="text-align:center">Paid</th>
                            <th style="text-align:center">Inv.Due</th>
                            <th style="text-align:center">Retruned</th>
                            <th style="text-align:center">Received</th>
                            <th style="text-align:center">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td style="text-align:left;">Previous Balance</td>
                            <td colspan="5"></td>
                            <td style="text-align:right;">@{{ parseFloat(previousBalance) | decimal }}</td>
                        </tr>
                        <tr v-for="payment in payments">
                            <td>@{{ payment.date }}</td>
                            <td style="text-align:left;">@{{ payment.description }}</td>
                            <td style="text-align:right;">@{{ parseFloat(payment.bill) | decimal }}</td>
                            <td style="text-align:right;">@{{ parseFloat(payment.paid) | decimal }}</td>
                            <td style="text-align:right;">@{{ parseFloat(payment.due) | decimal }}</td>
                            <td style="text-align:right;">@{{ parseFloat(payment.returned) | decimal }}</td>
                            <td style="text-align:right;">@{{ parseFloat(payment.cash_received) | decimal }}</td>
                            <td style="text-align:right;">@{{ parseFloat(payment.balance) | decimal }}</td>
                        </tr>
                    </tbody>
                    <tbody v-if="payments.length == 0">
                        <tr>
                            <td colspan="8">No records found</td>
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
        el: '#getSupplierLedgerlist',
        data() {
            return {
                dateFrom: moment().format('YYYY-MM-DD'),
                dateTo: moment().format('YYYY-MM-DD'),

                payments: [],
                previousBalance: 0,
                suppliers: [],
                selectedSupplier: null,

                onProgress: false,
                showReport: null,
            }
        },

        filters: {
            decimal(value) {
                let fixed = "{{session('organization')->fixed}}";
                return value == null ? parseFloat(0).toFixed(fixed) : parseFloat(value).toFixed(fixed);
            }
        },

        created() {
            this.getSupplier();
        },

        methods: {
            getSupplier() {
                let filter = {
                    forSearch: 'yes'
                }
                axios.post("/get-supplier", filter)
                    .then(res => {
                        let r = res.data.data;
                        this.suppliers = r.suppliers.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code}`
                            return item;
                        });
                    })
            },
            async onSearchSupplier(val, loading) {
                if (val.length > 2) {
                    loading(true)
                    await axios.post("/get-supplier", {
                            name: val
                        })
                        .then(res => {
                            let r = res.data.data;
                            this.suppliers = r.suppliers.map((item, index) => {
                                item.display_name = `${item.name} - ${item.code}`
                                return item;
                            });
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getSupplier();
                }
            },
            onChangeSearchType() {
                this.dues = [];
                this.selectedSupplier = null
                if (this.searchType == 'supplier') {
                    this.getSupplier();
                }
            },
            getSupplierLedger() {
                let filter = {
                    supplierId: this.selectedSupplier != null ? this.selectedSupplier.id : '',
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-supplier-ledger", filter)
                    .then(res => {
                        let r = res.data;
                        this.previousBalance = r.previousBalance
                        this.payments = r.payments
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
                                <h4 style="text-align:center">Supplier Payment List</h4 style="text-align:center">
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