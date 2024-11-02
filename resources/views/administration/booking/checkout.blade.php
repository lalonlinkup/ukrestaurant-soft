@extends('master')
@section('title', 'Booking Record')
@section('breadcrumb_title', 'Booking Record')
@push('style')
    <style scoped>
        .v-select .dropdown-toggle {
            padding: 0px;
            height: 30px !important;
        }

        .v-select .dropdown-menu {
            width: 350px !important;
            overflow-y: auto !important;
        }

        table>thead>tr>th {
            text-align: center;
        }

        .btnSave {
            padding: 6px 7px;
            border: none;
            background: red;
            color: #fff;
            border-radius: 4px;
        }
    </style>
@endpush
@section('content')
    <div id="bookingRecord">
        <div class="row" style="margin:0;">
            <fieldset class="scheduler-border bg-of-skyblue">
                <legend class="scheduler-border">Checkout Page</legend>
                <div class="control-group">
                    <form @submit.prevent="getBooking">
                        <div class="col-md-3 col-xs-12">
                            <div class="form-group" style="display: flex;align-items:center;">
                                <label for="" style="width:150px;">Search Type</label>
                                <select class="form-select no-padding" @change="onChangeType" style="width: 100%;"
                                    v-model="filter.searchType">
                                    <option value="">All</option>
                                    <option value="customer">By Customer</option>
                                    <option value="user">By User</option>
                                    <option value="date">By Date</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'customer'" style="display: none;"
                            :style="{ display: filter.searchType == 'customer' ? '' : 'none' }">
                            <div class="form-group">
                                <v-select :options="customers" v-model="selectedCustomer" label="display_name"
                                    @search="onSearchcustomer"></v-select>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'user'" style="display: none;"
                            :style="{ display: filter.searchType == 'user' ? '' : 'none' }">
                            <div class="form-group">
                                <v-select :options="users" v-model="selectedUser" label="name"></v-select>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'date'" style="display: none;"
                            :style="{ display: filter.searchType == 'date' ? '' : 'none' }">
                            <div class="form-group">
                                <input type="date" style="height: 30px;" class="form-control" v-model="filter.checkoutDate">
                            </div>
                        </div>
                        {{-- <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateFrom">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateTo">
                        </div>
                    </div> --}}

                        <div class="col-md-1 col-xs-12">
                            <div class="form-group">
                                <button :disabled="onProgress" type="submit" class="btn btn-primary"
                                    style="padding: 0 6px;">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>

        <div class="row" style="display: flex;justify-content:space-between;">
            <div class="col-md-3" v-if="bookings2.length > 0" style="display:none;"
                :style="{ display: bookings2.length > 0 ? '' : 'none' }">
                <input type="search" @input="filterArray($event)" placeholder="Search..." class="form-control">
            </div>
            <div class="col-md-9 text-right">
                <a v-if="bookings.length > 0" style="display:none;" :style="{ display: bookings.length > 0 ? '' : 'none' }"
                    href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                    <i class="fa fa-print"></i> Print
                </a>
            </div>
        </div>
        <div class="row" v-if="bookings.length > 0 && showReport" style="display:none;"
            :style="{ display: bookings.length > 0 && showReport ? '' : 'none' }">
            <div class="col-md-12">
                <div class="table-responsive" id="reportTable">
                    <table class="table table-bordered record-table table-condensed" v-if="filter.recordType == 'with'"
                        style="display:none;" :style="{ display: filter.recordType == 'with' ? '' : 'none' }">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sl.</th>
                                <th>Invoice No.</th>
                                <th>Date</th>
                                <th>Guest Name</th>
                                <th></th>
                                <th>Room Name</th>
                                <th>Price</th>
                                <th>Days</th>
                                <th>Checkout Date</th>
                                <th style="text-align: right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(booking, index) in bookings">
                                <tr :style="getRowStyle(booking.booking_details[0].checkout_date)">
                                    <td>
                                        <input type="checkbox" @change="onChangeCheck($event, index)"
                                            v-model="booking.groupCheck" />
                                    </td>
                                    <td>@{{ index + 1 }}</td>
                                    <td>@{{ booking.invoice }}</td>
                                    <td>@{{ booking.date | dateFormat("DD-MM-YYYY") }}</td>
                                    <td>@{{ booking.customer_name }}</td>
                                    <td>
                                        <input type="checkbox" @change="singleCheck(index)"
                                            v-model="booking.booking_details[0].checkStatus" />
                                    </td>
                                    <td>@{{ booking.booking_details[0].room_name }}</td>
                                    <td style="text-align:center;">@{{ booking.booking_details[0].unit_price | decimal }}</td>
                                    <td style="text-align:center;">@{{ booking.booking_details[0].days }}</td>
                                    <td style="text-align:center;">@{{ booking.booking_details[0].checkout_date | dateFormat("DD-MM-YYYY") }}</td>
                                    <td style="text-align:right;">@{{ booking.booking_details[0].total | decimal }}</td>
                                </tr>
                                <tr v-for="(product, sl) in booking.booking_details.slice(1)" :style="getRowStyle(product.checkout_date)">
                                    <td colspan="5" :rowspan="booking.booking_details.length - 1" v-if="sl == 0"></td>
                                    <td>
                                        <input type="checkbox" @change="singleCheck(index)" v-model="product.checkStatus" />
                                    </td>
                                    <td>@{{ product.room_name }}</td>
                                    <td style="text-align:center;">@{{ product.unit_price | decimal }}</td>
                                    <td style="text-align:center;">@{{ product.days }}</td>
                                    <td style="text-align:center;">@{{ product.checkout_date | dateFormat("DD-MM-YYYY") }}</td>
                                    <td style="text-align:right;">@{{ product.total | decimal }}</td>
                                </tr>
                                <tr>
                                    <td colspan="10" style="text-align: right;">
                                        <button
                                            v-if="booking.booking_details.filter(item => item.checkStatus == true).length > 0"
                                            @click="checkOutModal(booking.booking_details, booking.groupCheck)"
                                            type="button" class="btnSave">Checkout</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div style="display:none;" v-bind:style="{display: showReport == false ? '' : 'none'}">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="{{ asset('loading.gif') }}" style="width: 90px;"> Loading..
                </div>
            </div>
        </div>

        <div class="modal fade myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header"
                        style="display: flex;align-items:center;justify-content:space-between;width:100%;padding: 10px;background: #d90000;box-shadow: 0px 2px 5px 0px #d17a7a;">
                        <h5 class="modal-title"
                            style="width: 60%; padding-left: 3px; color: rgb(255, 255, 255); font-weight: 800; font-size: 15px; font-style: italic;">
                            Checkout Modal Form</h5>
                        <button type="button" style="width: 40%;padding-right: 12px;text-align: right;" class="close"
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Checkout Date</label>
                                    <input type="date" v-model="checkout_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            style="background: #abbac3 !important;border: 3px solid #949595;"
                            data-dismiss="modal">Close</button>
                        <button type="button" @click="checkOut" class="btn btn-info"
                            style="background: #d72929 !important;border: 3px solid #949595;">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- checkout with payment --}}
        <div class="modal fade paymentModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header"
                        style="display: flex;align-items:center;justify-content:space-between;width:100%;padding: 10px;background: #d90000;box-shadow: 0px 2px 5px 0px #d17a7a;">
                        <h5 class="modal-title"
                            style="width: 60%; padding-left: 3px; color: rgb(255, 255, 255); font-weight: 800; font-size: 15px; font-style: italic;">
                            Checkout Modal Form</h5>
                        <button type="button" style="width: 40%;padding-right: 12px;text-align: right;" class="close"
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" style="display: none;"
                                :style="{ display: detail.length > 0 ? '' : 'none' }">
                                <table class="table table-borderd">
                                    <tr class="bg-warning">
                                        <th colspan="3" style="font-size: 16px; padding: 5px;"> Bill No. @{{ payment.invoice }} </th>
                                    </tr>
                                    <tr v-for="dtl in detail">
                                        <td style="text-align: left;">
                                            <div class="form-group">
                                                <label for="">Room</label>
                                                <input type="text" style="height: 22px;" v-model="dtl.room_name" class="form-control" readonly>
                                            </div>
                                        </td>
                                        <td style="text-align: left;">
                                            <div class="form-group">
                                                <label for="">Checkin Date</label>
                                                <input type="datetime-local" style="height: 22px;" v-model="dtl.checkin_date" class="form-control" readonly>
                                            </div>
                                        </td>
                                        <td style="text-align: left;" width="33%">
                                            <div class="form-group">
                                                <label for="">Checkout Date</label>
                                                <input type="date" style="height: 22px;" v-model="checkout_date" class="form-control" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: left;">Room Bill:</th>
                                        <th style="text-align: right;">@{{ payment.billTotal }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: left;">Service Bill:</th>
                                        <th style="text-align: right;">@{{ payment.serviceTotal }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: left;">Restaurant Bill:</th>
                                        <th style="text-align: right;">@{{ payment.restaurantTotal }}</th>
                                    </tr>
                                    <tr class="bg-info">
                                        <th colspan="2" style="text-align: left;">Subtotal:</th>
                                        <th style="text-align: right;">@{{ payment.total }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: left; color: green;">Paid Amount:</th>
                                        <th style="text-align: right;color: green;">@{{ payment.paid }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: left; color:#d72929;">Due Amount:</th>
                                        <th style="text-align: right;color:#d72929;">@{{ payment.due }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: left; padding-top: 6px;">Discount:</th>
                                        <th width="33%">
                                            <div style="display: flex; justify-content: space-between;">
                                                <input type="number" id="discountPercent" class="form-control" style="height: 22px; width: 35%; margin-bottom: 0;" step="any" min="0" v-model="payment.discount" v-on:input="calculateTotal">
                                                <input type="number" class="form-control" style="height: 22px; width: 60%;margin-bottom: 0; text-align:right;" step="any" min="0" v-model="payment.discountAmount" v-on:input="calculateTotal">
                                            </div>
                                        </th>
                                    </tr>
                                    <tr class="bg-danger">
                                        <th colspan="2" style="text-align: left; padding:5px 3px;">Payment Amount:</th>
                                        <th style="text-align: right; padding: 5px 3px;">
                                           @{{ payment.amount }}
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            style="background: #abbac3 !important;border: 3px solid #949595;"
                            data-dismiss="modal">Close</button>
                        <button type="button" @click="checkOut" class="btn btn-info"
                            style="background: #d72929 !important;border: 3px solid #949595;">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        new Vue({
            el: '#bookingRecord',
            data() {
                return {
                    filter: {
                        searchType: "",
                        recordType: "with",
                        // dateFrom: moment().format("YYYY-MM-DD"),
                        // dateTo: moment().format("YYYY-MM-DD"),
                        checkoutDate: "",
                    },
                    checkout_date: moment().format("YYYY-MM-DD"),
                    detail: [],
                    bookings: [],
                    bookings2: [],
                    payment: {
                        id: '',
                        customer_id: '',
                        invoice: '',
                        booking_id: '',
                        billTotal: 0,
                        serviceTotal: 0,
                        restaurantTotal: 0,
                        total: 0,
                        paid: 0,
                        due: 0,
                        discount: 0,
                        discountAmount: 0,
                        amount: 0,
                        note: ''
                    },
                    withPayment: false,

                    customers: [],
                    selectedCustomer: null,
                    users: [],
                    selectedUser: null,
                    onProgress: false,
                    showReport: null,
                    currentDate: new Date(),
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
                onChangeCheck(event, sl) {
                    if (event.target.checked) {
                        this.bookings[sl].booking_details = this.bookings[sl].booking_details.map(item => {
                            item.checkStatus = true;
                            return item;
                        })
                    } else {
                        this.bookings[sl].booking_details = this.bookings[sl].booking_details.map(item => {
                            item.checkStatus = false;
                            return item;
                        })
                    }
                },
                singleCheck(sl) {
                    let unselect = this.bookings[sl].booking_details.length
                    let select = this.bookings[sl].booking_details.filter(item => item.checkStatus == true).length
                    if (unselect == select) {
                        this.bookings[sl].groupCheck = true;
                    } else {
                        this.bookings[sl].groupCheck = false;
                    }
                },
                getUser() {
                    axios.post("/get-user")
                        .then(res => {
                            this.users = res.data.users;
                        })
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

                onChangeType(event) {
                    this.bookings = [];
                    this.bookings2 = [];
                    this.selectedCustomer = null;
                    this.selectedUser = null;
                    this.filter.customerId = "";
                    this.filter.userId = "";
                    if (event.target.value == 'customer') {
                        this.getCustomer();
                    } else if (event.target.value == 'user') {
                        this.getUser();
                    }
                },

                checkOutModal(details, groupCheck) {
                    this.detail = details.filter(item => item.checkStatus == true);
                    if (groupCheck == true) {
                        axios.post('/get-customer-due', {
                            bookingId: details[0].booking_id
                        }).then(res => {
                            let r = res.data[0];
                            this.payment = {
                                customer_id: r.customer_id,
                                invoice: r.invoice,
                                booking_id: r.id,
                                billTotal: r.total,
                                serviceTotal: r.serviceAmount,
                                restaurantTotal: r.orderAmount,
                                total: r.billAmount,
                                paid: r.paymentAmount,
                                due: r.dueAmount,
                                discount: 0,
                                discountAmount: 0,
                                amount: r.dueAmount
                            }
                        })
                        this.withPayment = true;
                        $(".paymentModal").modal("show");
                    } else {
                        $(".myModal").modal("show");
                    }
                },

                calculateTotal() { 
                    if (event.target.id == 'discountPercent') {
                        this.payment.discountAmount = ((parseFloat(this.payment.total) * parseFloat(this.payment.discount)) / 100).toFixed(2);
                    } else {
                        this.payment.discount = (parseFloat(this.payment.discountAmount) / parseFloat(this.payment.total) * 100).toFixed(2);
                    }

                    this.payment.amount = (parseFloat(this.payment.due) - parseFloat(this.payment.discountAmount)).toFixed(2);
                },

                checkOut(details) {
                    let checkout = {
                        checkout_date: this.checkout_date,
                        detail: this.detail
                    }
                    if(this.withPayment == true) {
                        checkout.payment = this.payment;
                    }
                    axios.post("/save-checkout", checkout)
                        .then(res => {
                            toastr.success(res.data);
                            $(".myModal").modal("hide");
                            $(".paymentModal").modal("hide");
                            this.withPayment == false;
                            this.getBooking();
                        })
                },


                getBooking() {
                    var url = "/get-booking";
                    if (this.filter.searchType != 'date') {
                        this.filter.checkoutDate = "";
                    }
                    if (this.filter.searchType == 'customer') {
                        this.filter.customerId = this.selectedCustomer != null ? this.selectedCustomer.id : ""
                    } else {
                        this.filter.userId = this.selectedUser != null ? this.selectedUser.id : ""
                    }
                    this.onProgress = true
                    this.showReport = false
                    axios.post(url, this.filter)
                        .then(res => {
                            let r = res.data;
                            this.bookings = r.map(booking => {
                                booking.groupCheck = false;
                                booking.booking_details = booking.booking_details.filter(item => item
                                    .booking_status == 'checkin').map(item => {
                                    item.checkStatus = false;
                                    return item;
                                })
                                return booking;
                            }).filter(item => item.booking_details.length > 0);
                            this.bookings2 = r;
                            this.onProgress = false
                            this.showReport = true
                        })
                        .catch(err => {
                            this.showReport = null
                            this.onProgress = false
                            var r = JSON.parse(err.request.response);
                            if (err.request.status == '422' && r.errors != undefined && typeof r.errors ==
                                'object') {
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

                getRowStyle(checkout_date) {
                    const checkoutDate = new Date(checkout_date);
                    return this.isAfterToday(checkoutDate) ? { background: '#ff7859' } : {};
                },

                isAfterToday(date) {
                    const today = new Date(this.currentDate.toDateString());
                    return today > date;
                },

                //search method here
                async onSearchcustomer(val, loading) {
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

                // print method hre

                async print() {
                    // let dateText = '';
                    // if (this.dateFrom != '' && this.dateTo != '') {
                    //     dateText = `Statement from <strong>${moment(this.filter.dateFrom).format('DD-MM-YYYY')}</strong> to <strong>${moment(this.filter.dateTo).format('DD-MM-YYYY')}</strong>`;
                    // }

                    let userText = '';
                    if (this.selectedUser != null && this.selectedUser.username != '' && this.filter
                        .searchType == 'user') {
                        userText = `<strong>Sold by: </strong> ${this.selectedUser.username}`;
                    }

                    let customerText = '';
                    if (this.selectedCustomer != null && this.selectedCustomer.id != '' && this.filter
                        .searchType == 'customer') {
                        customerText = `<strong>Guest: </strong> ${this.selectedCustomer.name}<br>`;
                    }

                    let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">bookings Record</h4 style="text-align:center">
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-6">
								${userText} ${customerText}
							</div>
							<div class="col-xs-6 text-right">
								
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

                    if (this.filter.searchType != 'category' && this.filter.searchType != 'quantity' && this
                        .filter.searchType != 'summery') {
                        let rows = mywindow.document.querySelectorAll('.record-table tr');
                        rows.forEach(row => {
                            row.lastChild.remove();
                        })
                    }

                    mywindow.focus();
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    mywindow.print();
                    mywindow.close();
                },

                // filter bookingRecord
                filterArray(event) {
                    this.bookings = this.bookings2.filter(sale => {
                        return sale.invoice.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
                            sale.date.toLowerCase().startsWith(event.target.value.toLowerCase());
                    })
                },
            },
        })
    </script>
@endpush
