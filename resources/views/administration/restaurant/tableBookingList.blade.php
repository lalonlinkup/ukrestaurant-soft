@extends('master')
@section('title', 'Table Booking List')
@section('breadcrumb_title', 'Table Booking List')
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
</style>
@endpush
@section('content')
<div id="tableBookingList">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Search Table Booking List</legend>
            <div class="control-group">
                <form @submit.prevent="getTableBookings">
                    <div class="col-md-2 col-xs-12 no-padding">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">From</label>
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateFrom">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 no-padding">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px; text-align: center;">To</label>
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
                <table class="table table-bordered record-table table-condensed">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Booking No</th>
                            <th>Date</th>
                            <th>Customer Name</th>
                            <th>Customer Phone</th>
                            <th>Customer Email</th>
                            <th>Booking Date</th>
                            <th>Booking Time</th>
                            <th>Persons</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(booking, index) in bookings">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ booking.invoice }}</td>
                            <td>@{{ booking.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ booking.name }}</td>
                            <td>@{{ booking.phone }}</td>
                            <td>@{{ booking.email }}</td>
                            <td>@{{ booking.booking_date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ booking.booking_time }}</td>
                            <td>@{{ booking.persons }}</td>
                            <td>@{{ booking.note }}</td>
                            <td style="text-align:center;">
                                <span v-if="booking.status == 'p'" style="color: orange">Pending</span>
                                <span v-else-if="booking.status == 'c'" style="color: red">Cancel</span>
                                <span v-else style="color: green">Approved</span>
                            </td>
                            <td style="text-align:center;">
                                @if(userAction('e'))
                                    <a href="" title="Approve Table Booking" v-if="booking.status == 'p'" @click.prevent="approveBooking(booking)"><i class="fa fa-check"></i></a>
                                    <a href="" title="Cancel Table Booking" v-if="booking.status == 'p'" @click.prevent="cancelBooking(booking)"><i class="fa fa-times"></i></a>
                                @endif
                                @if(userAction('d'))
                                    <a href="" title="Delete Table Booking" @click.prevent="deleteBooking(booking)"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
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
        el: '#tableBookingList',
        data() {
            return {
                filter: {
                    dateFrom: moment().format("YYYY-MM-DD"),
                    dateTo: moment().format("YYYY-MM-DD"),
                },
                bookings: [],
                bookings2: [],
                onProgress: false,
                showReport: null
            }
        },

        filters: {
            decimal(value) {
                return value == null ? parseFloat(0).toFixed(2) : parseFloat(value).toFixed(2);
            },

            dateFormat(dt, format) {
                return moment(dt).format(format);
            },

            formatTime(timeString) {
                return moment(timeString).format('H:m');
            }
        },

        methods: {
            getTableBookings() {
                this.onProgress = true
                this.showReport = false
                var url = "/get-table-bookings";

                axios.post(url, this.filter).then(res => {
                    let bookings = res.data;
                    this.bookings = bookings
                    this.bookings2 = this.bookings
                    this.onProgress = false
                    this.showReport = true
                }).catch(err => {
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
            async deleteBooking(row) {
                let formdata = {
                    id: row.id
                }
                if (confirm("Are you sure!")) {
                    axios.post("/delete-table-booking", formdata).then(res => {
                        toastr.success(res.data.message)
                        this.getTableBookings();
                    }).catch(err => {
                        var r = JSON.parse(err.request.response);
                        if (r.errors != undefined) {
                            console.log(r.errors);
                        }
                        toastr.error(r.message);
                    })
                }
            },
            async approveBooking(row) {
                let formdata = {
                    id: row.id
                }
                if (confirm("Are you sure!")) {
                    axios.post("/approve-table-booking", formdata).then(res => {
                        toastr.success(res.data.message)
                        this.getTableBookings();
                    }).catch(err => {
                        var r = JSON.parse(err.request.response);
                        if (r.errors != undefined) {
                            console.log(r.errors);
                        }
                        toastr.error(r.message);
                    })
                }
            },
            async cancelBooking(row) {
                let formdata = {
                    id: row.id
                }
                if (confirm("Are you sure!")) {
                    axios.post("/cancel-table-booking", formdata).then(res => {
                        toastr.success(res.data.message)
                        this.getTableBookings();
                    }).catch(err => {
                        var r = JSON.parse(err.request.response);
                        if (r.errors != undefined) {
                            console.log(r.errors);
                        }
                        toastr.error(r.message);
                    })
                }
            },
            //search method here
            async onSearchcustomer(val, loading) {
                if (val.length > 2) {
                    loading(true)
                    await axios.post("/get-customer", {
                        name: val
                    }).then(res => {
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

                let menuText = '';
                if (this.selectedMenu != null && this.selectedMenu.id != '' && this.filter.searchType == 'quantity') {
                    menuText = `<strong>Menu: </strong> ${this.selectedMenu.name}`;
                }

                let categoryText = '';
                if (this.selectedCategory != null && this.selectedCategory.id != '' && this.filter.searchType == 'category') {
                    categoryText = `<strong>Category: </strong> ${this.selectedCategory.name}`;
                }
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Table Booking List</h4>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-12 text-center">
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

                let rows = mywindow.document.querySelectorAll('.record-table tr');
                rows.forEach(row => {
                    row.lastChild.remove();
                })

                mywindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                mywindow.print();
                mywindow.close();
            },
            filterArray(event) {
                this.bookings = this.bookings2.filter(booking => {
                    return booking.invoice.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
                        booking.customer_name.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
                        booking.customer_phone.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
                        booking.customer_email.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
                        booking.date.toLowerCase().startsWith(event.target.value.toLowerCase());
                })
            },
        },
    })
</script>
@endpush