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
        background: #2c8101;
        color: #fff;
        border-radius: 4px;
    }
</style>
@endpush
@section('content')
<div id="bookingRecord">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">CheckIn Page</legend>
            <div class="control-group">
                <form @submit.prevent="getBooking">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeType" style="width: 100%;" v-model="filter.searchType">
                                <option value="">All</option>
                                <option value="customer">By Customer</option>
                                <option value="user">By User</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'customer'" style="display: none;" :style="{display: filter.searchType == 'customer' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="customers" v-model="selectedCustomer" label="display_name" @search="onSearchcustomer"></v-select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'user'" style="display: none;" :style="{display: filter.searchType == 'user' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="users" v-model="selectedUser" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateFrom">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateTo">
                        </div>
                    </div>

                    <div class="col-md-1 col-xs-12">
                        <div class="form-group">
                            <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>

    <div class="row" style="display: flex;justify-content:space-between;">
        <div class="col-md-3" v-if="bookings2.length > 0" style="display:none;" :style="{display: bookings2.length > 0 ? '' : 'none'}">
            <input type="search" @input="filterArray($event)" placeholder="Search..." class="form-control">
        </div>
        <div class="col-md-9 text-right">
            <a v-if="bookings.length > 0" style="display:none;" :style="{display: bookings.length > 0 ? '' : 'none'}" href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
    </div>
    <div class="row" v-if="bookings.length > 0 && showReport" style="display:none;" :style="{display: bookings.length > 0 && showReport ? '' : 'none'}">
        <div class="col-md-12">
            <div class="table-responsive" id="reportTable">
                <table class="table table-bordered record-table table-condensed" v-if="filter.recordType == 'with'" style="display:none;" :style="{display: filter.recordType == 'with'? '': 'none'}">
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
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(booking, index) in bookings">
                            <tr>
                                <td>
                                    <input type="checkbox" @change="onChangeCheck($event, index)" v-model="booking.groupCheck" />
                                </td>
                                <td>@{{ index + 1 }}</td>
                                <td>@{{ booking.invoice }}</td>
                                <td>@{{ booking.date | dateFormat("DD-MM-YYYY") }}</td>
                                <td>@{{ booking.customer_name }}</td>
                                <td>
                                    <input type="checkbox" @change="singleCheck(index)" v-model="booking.booking_details[0].checkStatus" />
                                </td>
                                <td>@{{ booking.booking_details[0].room_name }}</td>
                                <td style="text-align:center;">@{{ booking.booking_details[0].unit_price | decimal }}</td>
                                <td style="text-align:center;">@{{ booking.booking_details[0].days }}</td>
                                <td style="text-align:right;">@{{ booking.booking_details[0].total | decimal }}</td>
                            </tr>
                            <tr v-for="(product, sl) in booking.booking_details.slice(1)">
                                <td colspan="5" :rowspan="booking.booking_details.length - 1" v-if="sl == 0"></td>
                                <td>
                                    <input type="checkbox" @change="singleCheck(index)" v-model="product.checkStatus" />
                                </td>
                                <td>@{{ product.room_name }}</td>
                                <td style="text-align:center;">@{{ product.unit_price | decimal }}</td>
                                <td style="text-align:center;">@{{ product.days }}</td>
                                <td style="text-align:right;">@{{ product.total | decimal }}</td>
                            </tr>
                            <tr>
                                <td colspan="10" style="text-align: right;">
                                    <button v-if="booking.booking_details.filter(item => item.checkStatus == true).length > 0" @click="checkIn(booking.booking_details)" type="button" class="btnSave">CheckIn</button>
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
                <img src="{{asset('loading.gif')}}" style="width: 90px;"> Loading..
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
                    dateFrom: moment().format("YYYY-MM-DD"),
                    dateTo: moment().format("YYYY-MM-DD"),
                },
                bookings: [],
                bookings2: [],

                customers: [],
                selectedCustomer: null,
                users: [],
                selectedUser: null,
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

            checkIn(details) {
                let detail = details.filter(item => item.checkStatus == true);
                axios.post("/save-checkin", {
                        detail: detail
                    })
                    .then(res => {
                        toastr.success(res.data);
                        this.getBooking();
                    })
            },


            getBooking() {
                if (this.filter.searchType == 'customer') {
                    this.filter.customerId = this.selectedCustomer != null ? this.selectedCustomer.id : ""
                } else {
                    var url = "/get-booking";
                    this.filter.userId = this.selectedUser != null ? this.selectedUser.id : ""
                }
                this.onProgress = true
                this.showReport = false
                axios.post(url, this.filter)
                    .then(res => {
                        let r = res.data;
                        this.bookings = r.map(booking => {
                            booking.groupCheck = false;
                            booking.booking_details = booking.booking_details.filter(item => item.booking_status == 'booked').map(item => {
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
                let dateText = '';
                if (this.dateFrom != '' && this.dateTo != '') {
                    dateText = `Statement from <strong>${moment(this.filter.dateFrom).format('DD-MM-YYYY')}</strong> to <strong>${moment(this.filter.dateTo).format('DD-MM-YYYY')}</strong>`;
                }

                let userText = '';
                if (this.selectedUser != null && this.selectedUser.username != '' && this.filter.searchType == 'user') {
                    userText = `<strong>Sold by: </strong> ${this.selectedUser.username}`;
                }

                let customerText = '';
                if (this.selectedCustomer != null && this.selectedCustomer.id != '' && this.filter.searchType == 'customer') {
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
								${dateText}
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

                if (this.filter.searchType != 'category' && this.filter.searchType != 'quantity' && this.filter.searchType != 'summery') {
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