const orderInvoice = Vue.component("order-invoice", {
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
                            Order Invoice
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-7">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:90px;"><strong>Name</strong></td>
                                <td style="font-weight:900;">:</td>
                                <td>{{ order.customer_id == null ? order.customer_name : order.customer.name }}</td>
                            </tr>
                            <tr>
                                <td style="width:90px;"><strong>Address</strong></td>
                                <td style="font-weight:900;">:</td>
                                <td>{{ order.customer_id == null ? order.customer_address != null ? order.customer_address : 'n/a' : order.customer.address }}</td>
                            </tr>
                            <tr>
                                <td style="width:90px;"><strong>Mobile</strong></td>
                                <td style="font-weight:900;">:</td>
                                <td>{{ order.customer_id == null ? order.customer_phone != null ? order.customer_phone : 'n/a' : order.customer.phone }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-5 text-right">
                        <strong>Order By:</strong> {{ order.user ?order.user.name : 'Regular Guest' }}<br>
                        <strong>Invoice No.:</strong> {{ order.invoice }}<br>
                        <strong>Order Date:</strong> {{ order.date | formatDateTime('DD-MM-YYYY') }} {{ order.created_at | formatDateTime('h:mm a') }}
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
                                    <td>Quantity</td>
                                    <td>Unit</td>
                                    <td>Rate</td>
                                    <td align="right">Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, sl) in cart">
                                    <td>{{ sl + 1 }}</td>
                                    <td style="text-align:left;">
                                        {{ item.menu ? item.menu.name : 'n/a' }} - {{ item.menu ? item.menu.code : 'n/a' }}
                                    </td>
                                    <td>{{ parseFloat(item.quantity).toFixed(2) }}</td>
                                    <td>{{ item.menu.unit.name }}</td>
                                    <td>{{ parseFloat(item.price).toFixed(2) }}</td>
                                    <td align="right">{{ parseFloat(item.total).toFixed(2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5">Total</td>
                                    <td><strong>{{cart.reduce((prev, curr) => {return prev + parseFloat(curr.quantity)}, 0)}}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">

                    </div>
                    <div class="col-xs-6">
                        <table _t92sadbc2>
                            <tr>
                                <td><strong>Sub Total:</strong></td>
                                <td style="text-align:right"><strong>{{ parseFloat(order.sub_total).toFixed(2) }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Discount:</strong></td>
                                <td style="text-align:right"><strong>{{ parseFloat(order.discount).toFixed(2) }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>VAT:</strong></td>
                                <td style="text-align:right"><strong>{{ parseFloat(order.vat).toFixed(2) }}</strong></td>
                            </tr>
                            <tr><td colspan="2" style="border-bottom: 1px solid #ccc"></td></tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td style="text-align:right"><strong>{{ parseFloat(order.total).toFixed(2) }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Paid:</strong></td>
                                <td style="text-align:right"><strong>{{ parseFloat(order.paid).toFixed(2) }}</strong></td>
                            </tr>
                            <tr><td colspan="2" style="border-bottom: 1px solid #ccc"></td></tr>
                            <tr>
                                <td><strong>{{ order.returnAmount > 0 ? 'Return' : 'Due' }}:</strong></td>
                                <td style="text-align:right"><strong>{{  order.returnAmount > 0 ? parseFloat(order.returnAmount).toFixed(2) : parseFloat(order.due).toFixed(2) }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <strong>In Word: </strong> {{ withDecimal(order.total) }}<br><br>
                        <strong>Note: </strong>
                        <p style="white-space: pre-line">{{ order.note }}</p>
                    </div>
                </div>
            </div>
        </div>
    `,
    props: ["order_id"],
    data() {
        return {
            order: {
                customer: {},
                user: {},
            },
            cart: [],
            company: {},
            style: null
        };
    },
    filters: {
        formatDateTime(dt, format) {
            return dt == "" || dt == null ? "" : moment(dt).format(format);
        },
    },
    created() {
        this.setStyle();
        this.getCompany();
        this.getOrder();
    },
    methods: {
        getCompany() {
            axios.get("/get-company").then((res) => {
                this.company = res.data;
            });
        },
        getOrder() {
            axios.post("/get-order", { id: this.order_id }).then((res) => {
                let order = res.data[0];
                this.order = order;
                this.cart = order.order_details;
            });
        },

        setStyle() {
            this.style = document.createElement("style");
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
                table[_t92sadbc2]{
                    width: 100%;
                }
                table[_t92sadbc2] td{
                    padding: 2px;
                }
            `;
            document.head.appendChild(this.style);
        },
        withDecimal(n) {
            n = n == undefined ? 0 : parseFloat(n).toFixed(2);
            var nums = n.toString().split('.')
            var whole = this.convertNumberToWords(nums[0])
            if (nums.length == 2 && nums[1] > 0) {
                var fraction = this.convertNumberToWords(nums[1])
                return whole + '& ' + fraction + " only";
            } else {
                return whole + " only";
            }
        },
        convertNumberToWords(amount) {
            var words = new Array();
            words[0] = '';
            words[1] = 'One';
            words[2] = 'Two';
            words[3] = 'Three';
            words[4] = 'Four';
            words[5] = 'Five';
            words[6] = 'Six';
            words[7] = 'Seven';
            words[8] = 'Eight';
            words[9] = 'Nine';
            words[10] = 'Ten';
            words[11] = 'Eleven';
            words[12] = 'Twelve';
            words[13] = 'Thirteen';
            words[14] = 'Fourteen';
            words[15] = 'Fifteen';
            words[16] = 'Sixteen';
            words[17] = 'Seventeen';
            words[18] = 'Eighteen';
            words[19] = 'Nineteen';
            words[20] = 'Twenty';
            words[30] = 'Thirty';
            words[40] = 'Forty';
            words[50] = 'Fifty';
            words[60] = 'Sixty';
            words[70] = 'Seventy';
            words[80] = 'Eighty';
            words[90] = 'Ninety';
            amount = amount.toString();
            var atemp = amount.split(".");
            var number = atemp[0].split(",").join("");
            var n_length = number.length;
            var words_string = "";
            if (n_length <= 9) {
                var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
                var received_n_array = new Array();
                for (var i = 0; i < n_length; i++) {
                    received_n_array[i] = number.substr(i, 1);
                }
                for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                    n_array[i] = received_n_array[j];
                }
                for (var i = 0, j = 1; i < 9; i++, j++) {
                    if (i == 0 || i == 2 || i == 4 || i == 7) {
                        if (n_array[i] == 1) {
                            n_array[j] = 10 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        }
                    }
                }
                value = "";
                for (var i = 0; i < 9; i++) {
                    if (i == 0 || i == 2 || i == 4 || i == 7) {
                        value = n_array[i] * 10;
                    } else {
                        value = n_array[i];
                    }
                    if (value != 0) {
                        words_string += words[value] + " ";
                    }
                    if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Crores ";
                    }
                    if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Lakhs ";
                    }
                    if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Thousand ";
                    }
                    if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                        words_string += "Hundred and ";
                    } else if (i == 6 && value != 0) {
                        words_string += "Hundred ";
                    }
                }
                words_string = words_string.split("  ").join(" ");
            }
            return words_string;
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
                        <link rel="stylesheet" href="../backend/css/bootstrap.min.css">
                        <style>
                            body, table{
                                font-size: 13px;
                            }
                        </style>
                    </head>
                    <body>
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
                        <div class="container" style="${
                            this.cart.length > 15
                                ? "margin-top:50px;"
                                : "position:fixed;bottom:15px;width:100%;"
                        }">
                            <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:5px;padding-bottom:6px;">
                                <div class="col-xs-6">
                                    <span style="text-decoration:overline;">Received by</span>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <span style="text-decoration:overline;">Authorized Signature</span>
                                </div>
                            </div>
    
                            <div class="row" style="font-size:12px;">
                                <div class="col-xs-6">
                                    Print Date: ${moment().format(
                                        "DD-MM-YYYY h:mm a"
                                    )}, Printed by: ${this.order.user?.name}
                                </div>
                                <div class="col-xs-6 text-right">
                                    contract info
                                </div>
                            </div>
                        </div>
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