const billingInvoice = Vue.component("billing-invoice", {
    template: `
        <div>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <div id="invoiceContent">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <div _h098asdh>
                            Invoice
                        </div>
                    </div>
                </div>
                <div class="row" style="border: 1px solid gray; border-radius: 8px; margin: 0; padding: 4px 0;">
                    <div class="col-xs-7">
                        <table style="width:100%;">
                            <tr>
                                <td style="width: 130px;"><strong>Guest ID</strong></td>
                                <td style="font-weight:900;">:</td>
                                <td>{{ booking?.customer_code }}</td>
                            </tr>
                            <tr>
                                <td style="width: 130px;"><strong>Name</strong></td>
                                <td style="font-weight:900;">:</td>
                                <td>{{ booking?.customer_name }}</td>
                            </tr>
                            <tr>
                                <td style="width: 130px;"><strong>Address</strong></td>
                                <td style="font-weight:900;">:</td>
                                <td>{{ booking?.customer_address }}</td>
                            </tr>
                            <tr>
                                <td style="width: 130px;"><strong>Mobile</strong></td>
                                <td style="font-weight:900;">:</td>
                                <td>{{ booking.customer_phone }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-5 text-right">
                        <strong>Invoice No.:</strong> {{ booking.invoice }}<br>
                        <strong>Save By:</strong> {{ booking.addBy }}<br>
                        <strong>Date:</strong> {{ booking.date | dateFormat('DD-MM-YYYY') }} {{ booking.created_at | dateFormat('h:mm a') }}
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-xs-12">
                        <table _a584de>
                            <thead>
                                <tr>
                                    <td style="border-bottom: 1px solid gray;">SL</td>
                                    <td style="width:50%;border-bottom: 1px solid gray;">Description</td>
                                    <td style="border-bottom: 1px solid gray;">Unit</td>
                                    <td style="border-bottom: 1px solid gray;">Rate</td>
                                    <td style="border-bottom: 1px solid gray;border-left:1px solid gray;">Amount</td>
                                    <td style="border-bottom: 1px solid gray;border-left: 1px solid gray;">Total Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4">
                                        <h5 class="title-table">Table Bills</h5>
                                    </td>
                                    <td style="border-left: 1px solid gray;"></td>
                                    <td style="border-left: 1px solid gray;"></td>
                                </tr>
                                <tr v-for="(item, sl) in carts">
                                    <td style="text-align: center;">{{ sl + 1 }}</td>
                                    <td style="text-align:left;">
                                        {{ item.table_name }} - {{ item.table_code }}
                                    </td>
                                    <td style="text-align: center;">{{ item.days }} days</td>
                                    <td style="text-align: right;">{{ parseFloat(item.unit_price).toFixed(2) }}</td>
                                    <td style="text-align: right;border-left:1px solid gray;">{{ parseFloat(item.total).toFixed(2) }}</td>
                                    <td v-if="sl == 0" style="border-left: 1px solid gray; text-align:right;" :rowspan="carts.length">
                                        <strong>{{billingTotal}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <h5 class="title-table">Service Bills</h5>
                                    </td>
                                    <td style="border-left: 1px solid gray;"></td>
                                    <td style="border-left: 1px solid gray;"></td>
                                </tr>
                                <tr v-for="(item, sl) in serviceCarts">
                                    <td style="text-align: center;">{{ sl + 1 }}</td>
                                    <td style="text-align:left;">
                                        {{ item.head_name }} - {{item.head_code}}
                                    </td>
                                    <td style="text-align: center;">1</td>
                                    <td style="text-align: right;">{{ parseFloat(item.amount).toFixed(2) }}</td>
                                    <td style="text-align: right;border-left:1px solid gray;">{{ parseFloat(item.amount).toFixed(2) }}</td>
                                    <td v-if="sl == 0" style="border-left: 1px solid gray; text-align:right;" :rowspan="serviceCarts.length">
                                        <strong>{{serviceTotal}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <h5 class="title-table">Restaurant Bills</h5>
                                    </td>
                                    <td style="border-left: 1px solid gray;"></td>
                                    <td style="border-left: 1px solid gray;"></td>
                                </tr>
                                <tr v-for="(item, sl) in restaurantCarts">
                                    <td style="text-align: center;">{{ sl + 1 }}</td>
                                    <td style="text-align:left;">
                                        {{ item.table?.name }} - {{item.table?.code}}
                                    </td>
                                    <td style="text-align: center;">--</td>
                                    <td style="text-align: right;">{{ parseFloat(item.total).toFixed(2) }}</td>
                                    <td style="text-align: right;border-left:1px solid gray;">{{ parseFloat(item.total).toFixed(2) }}</td>
                                    <td v-if="sl == 0" style="border-left: 1px solid gray; text-align:right;" :rowspan="restaurantCarts.length">
                                        <strong>{{restaurantTotal}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="border-top: 1px solid gray;text-align:right;">
                                        <strong>Total</strong>
                                    </td>
                                    <td style="border-left: 1px solid gray; text-align:right;border-top:1px solid gray;">
                                        <strong>{{parseFloat(+billingTotal + +serviceTotal + +restaurantTotal).toFixed(2)}}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h5 class="title-table" style="margin-top: 15px;">Payment Information</h5>
                        <table _a584de>
                            <thead>
                                <tr>
                                    <td style="border-bottom: 1px solid gray;text-align: left;">Date</td>
                                    <td style="border-bottom: 1px solid gray;width:50%;">Description</td>
                                    <td style="border-bottom: 1px solid gray;">Discount</td>
                                    <td style="border-bottom: 1px solid gray;">Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="booking.advance > 0">
                                    <td>{{ booking.date | dateFormat("DD-MM-YYYY") }}</td>
                                    <td>
                                        <!-- {{ booking.note }} -->
                                        Advance payment
                                    </td>
                                    <td style="text-align:right;">{{parseFloat(0).toFixed(2)}}</td>
                                    <td style="text-align: right;">{{ parseFloat(booking.advance).toFixed(2) }}</td>
                                </tr>
                                <tr v-for="(item, sl) in payments">
                                    <td>{{ item.date | dateFormat("DD-MM-YYYY") }}</td>
                                    <td style="text-align:left;">
                                        {{ item.note }}
                                    </td>
                                    <td style="text-align:right;">{{item.discountAmount}}</td>
                                    <td style="text-align: right;">{{ parseFloat(item.amount).toFixed(2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-weight: 800;text-align:right;border-top:1px solid gray;">Total</td>
                                    <td style="text-align: right;border-top:1px solid gray;border-left:1px solid gray;"><strong>{{payments.reduce((prev, curr) => {return prev + parseFloat(curr.discountAmount)}, 0).toFixed(2)}}</strong></td>
                                    <td style="text-align: right;border-top:1px solid gray;border-left:1px solid gray;"><strong>{{paymentAmount}}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-6 col-md-7"></div>
                    <div class="col-md-5 col-xs-6" style="margin: 10px 0;">
                        <table _a584de style="width: 100%;">
                            <tr>
                                <td><strong>Bill</strong></td>
                                <td style="text-align: center;"><strong>:</strong></td>
                                <td style="text-align: right;"><strong>{{parseFloat(billTotal).toFixed(2)}}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Discount (-)</strong></td>
                                <td style="text-align: center;"><strong>:</strong></td>
                                <td style="text-align: right;"><strong>{{parseFloat(discountAmount).toFixed(2)}}</strong></td>
                            </tr>
                            <tr>
                                <td style="border-top:1px solid gray;"><strong>Total</strong></td>
                                <td style="text-align: center;border-top:1px solid gray;"><strong>:</strong></td>
                                <td style="text-align: right;border-top:1px solid gray;"><strong>{{parseFloat(billTotal - discountAmount).toFixed(2)}}</strong></td>
                            </tr>
                            <tr>
                                <td style="border-bottom:1px solid gray;"><strong>Paid</strong></td>
                                <td style="text-align: center;border-bottom:1px solid gray;"><strong>:</strong></td>
                                <td style="text-align: right;border-bottom:1px solid gray;"><strong>{{parseFloat(paymentAmount).toFixed(2)}}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Due</strong></td>
                                <td style="text-align: center;"><strong>:</strong></td>
                                <td style="text-align: right;"><strong>{{parseFloat(billTotal - (+paymentAmount + +discountAmount)).toFixed(2)}}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    `,
    props: ["billing_id"],
    data() {
        return {
            booking: {
                id: "{{$id}}"
            },
            carts: [],
            serviceCarts: [],
            restaurantCarts: [],
            payments: [],

            billingTotal: 0,
            serviceTotal: 0,
            restaurantTotal: 0,
            billTotal: 0,
            discountAmount: 0,
            paymentAmount: 0,
            company: {},
            style: null
        };
    },
    filters: {
        dateFormat(dt, format) {
            return dt == "" || dt == null ? "" : moment(dt).format(format);
        },
    },
    created() {
        this.setStyle();
        this.getCompany();
        this.getBooking();
        this.getRestaurant();
        this.getCustomerPayment();
        this.getService();
    },
    methods: {
        getCompany() {
            axios.get("/get-company").then((res) => {
                this.company = res.data;
            });
        },
        getBooking() {
            axios.post('/get-booking', {
                    id: this.billing_id
                })
                .then(res => {
                    this.booking = res.data[0];
                    this.carts = res.data[0].booking_details;
                    this.billingTotal = this.carts.reduce((prev, curr) => {
                        return prev + parseFloat(curr.total)
                    }, 0).toFixed(2)
                })
        },

        getService() {
            axios.post('/get-service', {
                    bookingId: this.billing_id
                })
                .then(res => {
                    this.serviceCarts = res.data;
                    this.serviceTotal = this.serviceCarts.reduce((prev, curr) => {
                        return prev + parseFloat(curr.amount)
                    }, 0).toFixed(2)
                })
        },

        getRestaurant() {
            axios.post('/get-order', {
                    bookingId: this.billing_id
                })
                .then(res => {
                    this.restaurantCarts = res.data;
                    this.restaurantTotal = this.restaurantCarts.reduce((prev, curr) => {
                        return prev + parseFloat(curr.total)
                    }, 0).toFixed(2)
                })
        },
        async getCustomerPayment() {
            await axios.post('/get-customer-payments', {
                    bookingId: this.billing_id
                })
                .then(res => {
                    this.payments = res.data;
                    this.discountAmount = this.payments.reduce((prev, curr) => {return prev + parseFloat(curr.discountAmount)}, 0).toFixed(2)
                })

            await this.calculateTotal();
        },

        async calculateTotal(){
            let payment = this.payments.reduce((prev, curr) => {return prev + parseFloat(curr.amount)}, 0);
            this.billTotal = parseFloat(+this.serviceTotal + +this.billingTotal + +this.restaurantTotal).toFixed(2);
            this.paymentAmount = parseFloat(+payment+ +this.booking.advance).toFixed(2);
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
                    padding-bottom:5px;
                    border-bottom: 1px solid #ccc;
                    margin-bottom: 15px;
                }
                
                [_a584de] {
                    border-collapse: separate;
                    border-spacing: 0;
                    width: 100%;
                    border: 1px solid gray;
                    border-radius: 10px;
                    overflow: hidden;
                }
                [_a584de] th,
                [_a584de] td {
                    padding: 3px 8px !important;
                    text-align: left;
                }
                [_a584de] thead th {
                    background-color: #f2f2f2;
                }
                [_a584de]>thead>tr>td {
                    font-weight:700;
                    text-align:center;
                }

                .footerTable td{
                    padding: 3px;
                    border: 1px solid #ccc;
                }

                .title-table{
                    margin: 0px;
                    font-style: italic;
                    font-weight: 700;
                    border-bottom: 1px solid black;
                    margin-bottom: 3px;
                    display: inline-block;
                    padding-bottom: 2px;
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
                        <title>Billing Invoice</title>
                        <link rel="stylesheet" href="../backend/css/bootstrap.min.css">
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
                                                <div class="col-xs-2"><img src="${ this.company.logo ? this.company.logo : '/noImage.gif' }" alt="Logo" style="height:80px;border: 1px solid gray; border-radius: 5px;" /></div>
                                                <div class="col-xs-10" style="padding-top:5px;">
                                                    <strong style="font-size:18px;">${ this.company.title }</strong><br>
                                                    <p style="white-space: pre-line;">${ this.company.address}</p>
                                                    <p style="white-space: pre-line;">${ this.company.phone }</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                                                </div>
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
            let invoiceStyle = printWindow.document.createElement("style");
            invoiceStyle.innerHTML = this.style.innerHTML;
            printWindow.document.head.appendChild(invoiceStyle);
            printWindow.moveTo(0, 0);

            printWindow.focus();
            await new Promise((resolve) => setTimeout(resolve, 1000));
            printWindow.print();
            printWindow.close();
        },
    },
});
