@extends('master')
@section('title', 'Booking Invoice')
@section('breadcrumb_title', 'Booking Invoice')
@section('content')
<div id="bookingInvoice" class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <div class="col-xs-12 text-right">
                <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
        <div id="invoiceContent">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <div _h098asdh>
                        Booking Invoice
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-7">
                    <table style="width:100%;">
                        <tr>
                            <td style="width: 130px;"><strong>Guest ID</strong></td>
                            <td style="font-weight:900;">:</td>
                            <td>@{{ booking?.customer_code }}</td>
                        </tr>
                        <tr>
                            <td style="width: 130px;"><strong>Name</strong></td>
                            <td style="font-weight:900;">:</td>
                            <td>@{{ booking?.customer_name }}</td>
                        </tr>
                        <tr>
                            <td style="width: 130px;"><strong>Address</strong></td>
                            <td style="font-weight:900;">:</td>
                            <td>@{{ booking?.customer_address }}</td>
                        </tr>
                        <tr>
                            <td style="width: 130px;"><strong>Mobile</strong></td>
                            <td style="font-weight:900;">:</td>
                            <td>@{{ booking.customer_phone }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-5 text-right">
                    <strong>Invoice No.:</strong> @{{ booking.invoice }}<br>
                    <strong>Saved By:</strong> @{{ booking.addBy }}<br>
                    <strong>Date:</strong> @{{ booking.date | dateFormat('DD-MM-YYYY') }} @{{ booking.created_at | dateFormat('h:mm a') }}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div _d9283dsc></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table _a584de>
                        <thead>
                            <tr>
                                <td>SL</td>
                                <td style="width:50%;">Description</td>
                                <td>Unit</td>
                                <td>Checkin Date</td>
                                <td>Checkout Date</td>
                                <td>Unit Price</td>
                                <td align="right">Total</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in carts">
                                <td>@{{ sl + 1 }}</td>
                                <td style="text-align:left;">
                                    @{{ item.table_name }} - @{{ item.table_code }}
                                </td>
                                <td>@{{ item.days }} days</td>
                                <td>@{{ item.checkin_date | dateFormat("DD-MM-YYYY") }}</td>
                                <td>@{{ item.checkout_date | dateFormat("DD-MM-YYYY") }}</td>
                                <td>@{{ parseFloat(item.unit_price).toFixed(2) }}</td>
                                <td style="text-align:right;">@{{ parseFloat(item.total).toFixed(2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight: 800;">Total</td>
                                <td><strong>@{{carts.reduce((prev, curr) => {return prev + parseFloat(curr.days)}, 0)}}</strong></td>
                                <td colspan="3"></td>
                                <td style="text-align: right;"><strong>@{{carts.reduce((prev, curr) => {return prev + parseFloat(curr.total)}, 0).toFixed(2)}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    new Vue({
        el: '#bookingInvoice',
        data() {
            return {
                booking: {
                    id: "{{$id}}"
                },
                carts: [],
            }
        },

        filters: {
            dateFormat(dt, format) {
                return dt == "" || dt == null ? "" : moment(dt).format(format);
            },
        },

        created() {
            this.setStyle();
            this.getBooking();
        },
        methods: {
            getBooking() {
                axios.post('/get-booking', {
                        id: this.booking.id
                    })
                    .then(res => {
                        this.booking = res.data[0];
                        this.carts = res.data[0].booking_details;
                    })
            },

            setStyle() {
                this.style = document.createElement('style');
                this.style.innerHTML = `
					div[_h098asdh]{
						/*background-color:#e0e0e0;*/
						font-weight: bold;
						font-size:15px;
						margin-bottom:15px;
						padding: 5px;
						border-top: 1px dotted #454545;
						border-bottom: 1px dotted #454545;
					}
					div[_d9283dsc]{
						padding-bottom:25px;
						border-bottom: 1px solid #ccc;
						margin-bottom: 15px;
					}
					table[_a584de]{
						width: 100%;
						text-align:center;
					}
					table[_a584de] thead{
						font-weight:bold;
					}
					table[_a584de] td{
						padding: 3px;
						border: 1px solid #ccc;
					}
				`;
                document.head.appendChild(this.style);
            },

            async print() {
                let invoiceContent =
                    document.querySelector("#invoiceContent").innerHTML;
                let printWindow = window.open(
                    "",
                    "PRINT",
                    `width=${screen.width}, height=${screen.height}, left=0, top=0`
                );

                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>Order Invoice</title>
                        <link rel="stylesheet" href="{{asset('backend')}}/css/bootstrap.min.css">
                        <style>
                            body, table{
                                font-size: 13px;
                            }

                            @media print{
                                .totalColor{
                                    background-color: gainsboro !important;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="container">
                                            <div class="row">
                                                @include('administration/reports/reportHeader')
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">${invoiceContent}</div>
                                            </div>
                                        </div> 
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="height:90px;">
                                <tr>
                                    <td>
                                        <div class="container" style="position:fixed;left:0;bottom:0;width:100%;">
                                            <div class="row" style="margin-bottom:5px;padding-bottom:6px;">
                                                <div class="col-xs-6">
                                                    <span style="text-decoration:overline;">Received by</span>
                                                </div>
                                                <div class="col-xs-6 text-right">
                                                    <span style="text-decoration:overline;">Authorized Signature</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </body>
                    </html>
				`);
                let invoiceStyle = printWindow.document.createElement('style');
                invoiceStyle.innerHTML = this.style.innerHTML;
                printWindow.document.head.appendChild(invoiceStyle);
                printWindow.moveTo(0, 0);

                printWindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                printWindow.print();
                printWindow.close();
            },
        },
    })
</script>
@endpush