@extends('master')
@section('title', 'Customer Payment Report')
@section('breadcrumb_title', 'Customer Payment Report')
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
<div id="customerPaymentHistory">
    <fieldset class="scheduler-border bg-of-skyblue">
        <legend class="scheduler-border">Customer Payment Report</legend>
        <div class="control-group">
            <div class="row" style="margin: 0;">
                <form @submit.prevent="getCustomerPaymentHistory">
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:100px;">Customer</label>
                            <v-select :options="customers" style="width: 100%;" v-model="selectedCustomer" label="display_name" @search="onSearchCustomer"></v-select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <select class="form-control" style="height: 30px;" v-model="type">
                                <option value="">All</option>
                                <option value="CR">Received</option>
                                <option value="CP">Paid</option>
                            </select>
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
        </div>
    </fieldset>

    <div class="row" v-if="showReport" style="display: none;" :style="{display: showReport ? '': 'none'}">
        <div class="col-md-12 col-xs-12 text-right">
            <a href="" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>
            <div class="table-responsive" id="reportTable">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Transation ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Payment Type</th>
                            <th>PaymentBy</th>
                            <th>In Amount</th>
                            <th>Out Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(payment, sl) in payments">
                            <td>@{{ sl + 1 }}</td>
                            <td>@{{ payment.invoice }}</td>
                            <td>@{{ payment.date | dateFormat('DD-MM-YYYY') }}</td>
                            <td style="text-align:left;">@{{ payment.customer?.name }} - @{{ payment.customer?.code }}</td>
                            <td style="text-align:center;">@{{ payment.type == 'CR' ? 'Received' : 'Paid' }}</td>
                            <td style="text-align:left;">@{{ payment.method == 'cash' ? payment.method : payment.method+' - '+payment.bank_account?.name+' - '+payment.bank_account?.number+' - '+payment.bank_account.bank_name }}</td>
                            <td>@{{ paymentAmount(payment, 'CR') }}</td>
                            <td>@{{ paymentAmount(payment, 'CP')}}</td>
                        </tr>
                        <tr>
                            <th colspan="6">Total</th>
                            <th>
                                @{{payments.reduce((prev, curr) => {return prev + parseFloat(curr.type == 'CR' ? curr.amount : 0)}, 0) | decimal}}
                            </th>
                            <th>
                                @{{payments.reduce((prev, curr) => {return prev + parseFloat(curr.type == 'CP' ? curr.amount : 0)}, 0) | decimal}}
                            </th>
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
        el: '#customerPaymentHistory',
        data() {
            return {
                dateFrom: moment().format('YYYY-MM-DD'),
                dateTo: moment().format('YYYY-MM-DD'),
                type: '',
                payments: [],

                customers: [],
                selectedCustomer: null,

                onProgress: false,
                showReport: null,
                fixed: 2
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
            this.getCustomer();
        },

        methods: {
            paymentAmount(payment, type) {
                if (type == payment.type) {
                    return parseFloat(payment.amount).toFixed(this.fixed);
                }
                if (type == payment.type) {
                    return parseFloat(payment.amount).toFixed(this.fixed);
                }

                return '';
            },
            getCustomer() {
                let filter = {
                    forSearch: 'yes'
                }
                axios.post("/get-customer", filter)
                    .then(res => {
                        let r = res.data;
                        this.customers = r.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code}`
                            return item;
                        });
                    })
            },
            async onSearchCustomer(val, loading) {
                if (val.length > 2) {
                    loading(true)
                    await axios.post("/get-customer", {
                            name: val
                        })
                        .then(res => {
                            let r = res.data;
                            this.customers = r.map((item, index) => {
                                item.display_name = `${item.name} - ${item.code}`
                                return item;
                            });
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getCustomer();
                }
            },
            onChangeSearchType() {
                this.dues = [];
                this.selectedCustomer = null
                if (this.searchType == 'customer') {
                    this.getCustomer();
                }
            },
            getCustomerPaymentHistory() {
                let filter = {
                    customerId: this.selectedCustomer != null ? this.selectedCustomer.id : '',
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo,
                    type: this.type
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-customer-payments", filter)
                    .then(res => {
                        let r = res.data;
                        this.payments = r
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
                let dateText = '';
                if (this.dateFrom != '' && this.dateTo != '') {
                    dateText = `Statement from <strong>${moment(this.dateFrom).format('DD-MM-YYYY')}</strong> to <strong>${moment(this.dateTo).format('DD-MM-YYYY')}</strong>`;
                }

                let customerText = '';
                if (this.selectedCustomer != null && this.selectedCustomer.id != '') {
                    customerText = `<strong>Customer ID: </strong> ${this.selectedCustomer.code}<br>
                                    <strong>Name: </strong> ${this.selectedCustomer.name}<br>
                                    <strong>Phone: </strong> ${this.selectedCustomer.phone}
                    `;
                }
                let reportContent = `
                    <style>
                    .table>tbody>tr>td{
                        padding:0px 5px !important;
                    }
                    .table>thead:first-child>tr:first-child>th {
                        padding: 0px 5px !important;
                    }
                    </style>
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Customer Payment Report</h4 style="text-align:center">
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-6">
								${customerText} 
							</div>
							<div class="col-xs-6 text-right">
								${dateText} <br />
                                <strong>Print Date: </strong> ${moment().format("DD-MM-YYYY")}
							</div>
						</div>
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