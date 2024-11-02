@extends('master')
@section('title', 'Employee Salary Record')
@section('breadcrumb_title', 'Employee Salary Record')
@push('style')
<style scoped>
    .v-select .dropdown-toggle {
        padding: 0px;
        height: 30px !important;
    }

    .v-select .dropdown-menu {
        width: 300px !important;
        overflow-y: auto !important;
    }
</style>
@endpush
@section('content')
<div id="salaryRecord">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Salary Payment Record</legend>
            <div class="control-group">
                <form id="searchForm" @submit.prevent="getSearchResult">
                    <div class="col-md-3 col-xs-12 no-padding-right">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label style="width: 150px;margin:0;">Search Type</label>
                            <select class="form-select" v-model="searchType" @change="onChangeSearchType">
                                <option value="">All</option>
                                <option value="month">By Month</option>
                                <option value="employee">By Employee</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-12" style="display:none;" v-bind:style="{display: searchType == 'employee' ? '' : 'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="employees" v-model="selectedEmployee" label="name" placeholder="Select Employee"></v-select>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-12" style="display:none;" v-bind:style="{display: searchType == 'month' ? '' : 'none'}">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label style="width: 80px;">Month</label>
                            <input type="month" style="height: 30px;" class="form-control" id="bdaymonth" v-model="selectedMonth">
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-12 no-padding-right" v-bind:style="{display: searchTypesForRecord.includes(searchType) ? '' : 'none'}">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label class="col-xs-5 control-label no-padding-right" style="margin: 0;"> Record Type </label>
                            <div class="col-xs-7 no-padding-left">
                                <select class="form-select" v-model="recordType" @change="payments = []">
                                    <option value="without_details">Without Details</option>
                                    <option value="with_details">With Details</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12 no-padding-right" style="display: none;" :style="{display: searchType == 'month' ? 'none' : ''}">
                        <div class="form-group">
                            <input type="month" style="height: 30px;" class="form-control" v-model="monthFrom">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 no-padding-right" style="display: none;" :style="{display: searchType == 'month' ? 'none' : ''}">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width: 30px;">To</label>
                            <input type="month" style="height: 30px;" class="form-control" v-model="monthTo">
                        </div>
                    </div>

                    <div class="col-md-1 col-xs-12">
                        <div class="form-group">
                            <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 8px;">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>

    <div class="row" style="display: flex;justify-content:space-between;">
        <div class="col-md-3" v-if="filterPayments.length > 0" style="display:none;" :style="{display: filterPayments.length > 0 ? '' : 'none'}">
            <input type="search" @input="filterArray($event)" placeholder="Search..." class="form-control">
        </div>
        <div class="col-md-9 text-right">
            <a v-if="payments.length > 0" style="display:none;" :style="{display: payments.length > 0 ? '' : 'none'}" href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
    </div>

    <div class="row" style="display:none;" v-bind:style="{display: payments.length > 0 && showReport ? '' : 'none'}">
        <div class="col-md-12">
            <div class="table-responsive" id="reportContent">
                <table class="record-table" v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'with_details'" style="display:none" v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'with_details' ? '' : 'none'}">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Salary</th>
                            <th>Overtime / benefit</th>
                            <th>Deduction</th>
                            <th>Net Payable</th>
                            <th>Payment</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="payment in payments">
                            <tr>
                                <td colspan="8" style="font-size:13px;text-align:center; background: orange;"> <strong>Month:</strong> @{{ payment.month | formatDateTime('MMMM YYYY') }} || <strong>Payment Date:</strong> @{{ payment.date }} || <strong>Payment By:</strong> @{{ payment.add_by.name }} || <strong>Total Amount:</strong> @{{ payment.amount }}</td>
                            </tr>

                            <tr v-for="(detail, sl) in payment.details">
                                <td>@{{ detail.employee.code }}</td>
                                <td>@{{ detail.employee.name }}</td>
                                <td style="text-align:right;">@{{ detail.salary | decimal }}</td>
                                <td style="text-align:right;">@{{ detail.benefit | decimal }}</td>
                                <td style="text-align:right;">@{{ detail.deduction | decimal }}</td>
                                <td style="text-align:right;">@{{ detail.net_payable  | decimal}}</td>
                                <td style="text-align:right;">@{{ detail.payment | decimal }}</td>
                                <td>@{{ detail.comment }}</td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <table class="record-table" v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'without_details'" style="display:none" v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'without_details' ? '' : 'none'}">
                    <thead>
                        <tr>
                            <th>Salary Id</th>
                            <th>Month</th>
                            <th>Payment Date</th>
                            <th>Payment By</th>
                            <th>Total Employee</th>
                            <th>Salary Amount</th>
                            <th>Overtime/Benefit</th>
                            <th>Deduction Amount</th>
                            <th>Paid Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="payment in payments">
                            <td>@{{ payment.code }}</td>
                            <td>@{{ payment.month | formatDateTime('MMMM YYYY') }}</td>
                            <td>@{{ payment.date | formatDateTime('DD-MM-YYYY') }}</td>
                            <td>@{{ payment.add_by.name }}</td>
                            <td style="text-align: center">@{{ payment.total_employee }}</td>
                            <td style="text-align:right;">@{{ payment.details.reduce((prev, curr)=>{return prev + parseFloat(curr.salary)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ payment.details.reduce((prev, curr)=>{return prev + parseFloat(curr.benefit)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ payment.details.reduce((prev, curr)=>{return prev + parseFloat(curr.deduction)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ payment.amount | decimal }}</td>
                            <td style="text-align:center;">
                                <a href="" title="Salary Sheet" v-bind:href="`/salary-sheet-print/${payment.id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                @if(userAction('d'))
                                <a href="" title="Delete Payment" @click.prevent="deletePayment(payment.id)"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="5" style="text-align:right;">Total:</td>
                            <td style="text-align:right;">@{{ payments.reduce((prev, curr)=>{return prev + curr.details.reduce( (pre, cur) => {return pre + parseFloat(cur.salary)}, 0)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ payments.reduce((prev, curr)=>{return prev + curr.details.reduce( (pre, cur) => {return pre + parseFloat(cur.benefit)}, 0)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ payments.reduce((prev, curr)=>{return prev + curr.details.reduce( (pre, cur) => {return pre + parseFloat(cur.deduction)}, 0)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ payments.reduce((prev, curr)=>{return prev + parseFloat(curr.amount)}, 0) | decimal }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <template v-if="searchTypesForDetails.includes(searchType)" style="display:none;" v-bind:style="{display: searchTypesForDetails.includes(searchType) ? '' : 'none'}">
                    <div class="row" style="margin: unset;margin-bottom: 10px;">
                        <div class="col-sm-6">
                            <table style="float: left" class="custom_table">
                                <tr>
                                    <th>Employee ID</th>
                                    <th>:</th>
                                    <th>@{{payments.length > 0 ? payments[0].employee.code : ''}}</th>
                                </tr>
                                <tr>
                                    <th>Employee Name</td>
                                    <th>:</th>
                                    <th>@{{payments.length > 0 ? payments[0].employee.name : ''}}</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table style="float: right" class="custom_table">
                                <tr>
                                    <th>Department</th>
                                    <th>:</th>
                                    <th>@{{payments.length > 0 ? payments[0].employee.department.name : ''}}</th>
                                </tr>
                                <tr>
                                    <th>Designation</th>
                                    <th>:</th>
                                    <th>@{{payments.length > 0 ? payments[0].employee.designation.name : ''}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <table class="record-table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Payment Date</th>
                                <th>Salary</th>
                                <th>Ovetime / Other Benefit</th>
                                <th>Deduction</th>
                                <th>Net Payable</th>
                                <th>Payment</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="payment in payments">
                                <td>@{{ payment.employee_payment.month | formatDateTime('MMMM YYYY') }}</td>
                                <td>@{{ payment.employee_payment.date }}</td>
                                <td style="text-align:right;">@{{ payment.salary | decimal }}</td>
                                <td style="text-align:right;">@{{ payment.benefit | decimal }}</td>
                                <td style="text-align:right;">@{{ payment.deduction | decimal }}</td>
                                <td style="text-align:right;">@{{ payment.net_payable | decimal }}</td>
                                <td style="text-align:right;">@{{ payment.payment | decimal }}</td>
                                <td>@{{ payment.comment }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight:bold;">
                                <td colspan="2" style="text-align:right;">Total:</td>
                                <td style="text-align:right;">@{{ payments.reduce((prev, curr) => { return prev + parseFloat(curr.salary)}, 0) | decimal }}</td>
                                <td style="text-align:right;">@{{ payments.reduce((prev, curr) => { return prev + parseFloat(curr.benefit)}, 0) | decimal }}</td>
                                <td style="text-align:right;">@{{ payments.reduce((prev, curr) => { return prev + parseFloat(curr.deduction)}, 0) | decimal }}</td>
                                <td style="text-align:right;">@{{ payments.reduce((prev, curr) => { return prev + parseFloat(curr.net_payable)}, 0) | decimal }}</td>
                                <td style="text-align:right;">@{{ payments.reduce((prev, curr) => { return prev + parseFloat(curr.payment)}, 0) | decimal }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </template>
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
    var salaryRecord = new Vue({
        el: "#salaryRecord",

        data() {
            return {
                searchType: '',
                recordType: 'without_details',
                employees: [],
                selectedEmployee: null,
                selectedMonth: '',
                payments: [],
                filterPayments: [],
                searchTypesForRecord: ['', 'month'],
                searchTypesForDetails: ['employee'],
                onProgress: false,
                showReport: null,
                monthFrom: '',
                monthTo: moment().format("YYYY-MM"),
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
            this.monthFrom = moment().format("YYYY-01");
        },

        methods: {
            onChangeSearchType() {
                this.payments = [];
                this.filterPayments = [];
                if (this.searchType == 'employee') {
                    this.getEmployees();
                }
                if (this.searchType == 'month') {
                    this.monthFrom = '';
                    this.monthTo = '';
                }
            },

            getEmployees() {
                axios.get('/get-employee').then(res => {
                    this.employees = res.data;
                })
            },

            getSearchResult() {
                if (this.searchType == '') {
                    this.selectedMonth = '';
                }

                if (this.searchType != 'employee') {
                    this.selectedEmployee = null;
                }

                if (this.searchTypesForRecord.includes(this.searchType)) {
                    this.getPaymentsRecord();
                } else {
                    this.getPaymentDetails();
                }
            },

            getPaymentsRecord() {
                if (this.searchType == 'month' && this.selectedMonth == '') {
                    alert('Select Month');
                    return;
                }

                let filter = {
                    month: this.selectedMonth == '' ? '' : this.selectedMonth,
                    monthFrom: this.monthFrom,
                    monthTo: this.monthTo,
                }

                filter.details = true;

                let url = '/get-payments';

                this.onProgress = true
                this.showReport = false
                axios.post(url, filter)
                    .then(res => {
                        this.payments = res.data;
                        this.filterPayments = res.data;
                        this.onProgress = false
                        this.showReport = true
                    })
            },

            getPaymentDetails() {
                if (this.selectedEmployee == null) {
                    alert('Select Employee');
                    return;
                }
                let filter = {
                    month: this.selectedMonth == '' ? '' : this.selectedMonth,
                    employeeId: this.selectedEmployee.id,
                    monthFrom: this.monthFrom,
                    monthTo: this.monthTo,
                }

                this.onProgress = true
                this.showReport = false
                axios.post('/get-salary-details', filter)
                    .then(res => {
                        this.payments = res.data;
                        this.filterPayments = res.data;
                        this.onProgress = false
                        this.showReport = true
                    })
            },

            deletePayment(paymentId) {
                let deleteConf = confirm('Are you sure?');
                if (deleteConf == false) {
                    return;
                }
                axios.post('/delete-salary-payment', {
                        paymentId
                    })
                    .then(res => {
                        toastr.success(res.data)
                        this.getSearchResult();
                    })
                    .catch(err => {
                        var r = JSON.parse(err.request.response);
                        toastr.error(r.message);
                    })
            },

            // filter salerecord
            filterArray(event) {
                this.payments = this.filterPayments.filter(pay => {
                    return pay.month.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
                        pay.date.toLowerCase().startsWith(event.target.value.toLowerCase());
                })
            },

            async print() {
                let reportContent = `
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <h3>Employee Salary Payment Record</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    ${document.querySelector('#reportContent').innerHTML}
                                </div>
                            </div>
                        </div>
                    `;

                var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
                reportWindow.document.write(`
                        @include('administration/reports/reportHeader')
                    `);

                reportWindow.document.head.innerHTML += `
                        <style>
                            .record-table{
                                width: 100%;
                                border-collapse: collapse;
                            }
                            .record-table thead{
                                background-color: #0097df;
                                color:white;
                            }
                            .record-table th, .record-table td{
                                padding: 3px;
                                border: 1px solid #454545;
                            }
                            .record-table th{
                                text-align: center;
                            }
                            .custom_table th{
                                padding: 5px;
                            }
                        </style>
                    `;
                reportWindow.document.body.innerHTML += reportContent;

                if (this.searchType == '' && this.searchType == 'month' && this.recordType == 'without_details') {
                    let rows = reportWindow.document.querySelectorAll('.record-table tr');
                    rows.forEach(row => {
                        row.lastChild.remove();
                    })
                }


                reportWindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                reportWindow.print();
                reportWindow.close();
            }
        }
    })
</script>
@endpush