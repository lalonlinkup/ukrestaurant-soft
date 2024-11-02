@extends('master')
@section('title', 'Employee Salary Sheet')
@section('breadcrumb_title', 'Employee Salary Sheet')
@push('style')
<style scoped>
    
</style>
@endpush
@section('content')
<div id="salaryInvoice">
    <div class="row">
        <div class="col-md-12">
            <a href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="reportContent">
                <template>
                    <div class="row" style="margin: unset;margin-bottom: 10px;">
                        <div class="col-sm-6 no-padding-left">
                            <table style="float: left" class="custom_table custom-left">
                                <tr>
                                    <th>Salary Id</th>
                                    <th>:</th>
                                    <th>&nbsp; @{{ payments.code }}</th>
                                </tr>
                                <tr>
                                    <th>Salary Month</th>
                                    <th>:</th>
                                    <th>&nbsp; @{{ payments.month | formatDateTime('MMMM YYYY') }}</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6 no-padding-right">
                            <table style="float: right" class="custom_table custom-right">
                                <tr>
                                    <th>Salary Date</th>
                                    <th>:</th>
                                    <th>&nbsp; @{{ payments.date | formatDateTime('DD-MM-YYYY') }}</th>
                                </tr>
                                <tr>
                                    <th>Salary By</td>
                                    <th>:</th>
                                    <th>&nbsp; @{{ payments.add_by ? payments.add_by.name : '' }}</th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <table class="record-table">
                        <thead>
                            <tr>
                                <th>SL</th>
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
                            <tr v-for="(payment, sl) in details">
                                <td>@{{ sl + 1 }}</td>
                                <td>@{{ payment.employee.code }}</td>
                                <td>@{{ payment.employee.name }}</td>
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
                                <td colspan="3" style="text-align:right;">Total:</td>
                                <td style="text-align:right;">@{{ details.reduce((prev, curr) => { return prev + parseFloat(curr.salary)}, 0) | decimal }}</td>
                                <td style="text-align:right;">@{{ details.reduce((prev, curr) => { return prev + parseFloat(curr.benefit)}, 0) | decimal }}</td>
                                <td style="text-align:right;">@{{ details.reduce((prev, curr) => { return prev + parseFloat(curr.deduction)}, 0) | decimal }}</td>
                                <td style="text-align:right;">@{{ details.reduce((prev, curr) => { return prev + parseFloat(curr.net_payable)}, 0) | decimal }}</td>
                                <td style="text-align:right;">@{{ details.reduce((prev, curr) => { return prev + parseFloat(curr.payment)}, 0) | decimal }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        var salaryInvoice = new Vue({
            el: "#salaryInvoice",

            data() {
                return {
                    paymentId: "{{ $id }}",
                    payments: [],
                    details: []
                }
            },

            filters: {
                decimal(value) {
                    let fixed = "{{ session('organization')->fixed }}";
                    return value == null ? parseFloat(0).toFixed(fixed) : parseFloat(value).toFixed(fixed);
                },

                formatDateTime(dt, format) {
                    return dt == '' || dt == null ? '' : moment(dt).format(format);
                }
            },

            created() {
                this.getPayment();
            },

            methods: {
                getPayment() {
                    let filter = {
                        paymentId: this.paymentId,
                        details: true
                    }
                    axios.post('/get-payments', filter)
                    .then(res => {
                        this.payments = res.data.data[0];
                        this.details = res.data.data[0].details;
                    })
                },

                async print() {
                    let reportContent = `
                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <h3>Employee Salary Sheet</h3>
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
                                .custom-left th{
                                    text-align: left;
                                }
                                .custom-right th{
                                    text-align: right;
                                }
                                .no-padding-left {
                                    padding-left: 0px !important;
                                }
                                .no-padding-right {
                                    padding-right: 0px !important;
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
            },
        })
    </script>
@endpush