@extends('master')
@section('title', 'Service List')
@section('breadcrumb_title', 'Service List')
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
        width: 100% !important;
    }
    .icon-size {
        font-size: 16px;
    }
</style>
@endpush
@section('content')
<div id="serviceList">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Service List Search</legend>
            <div class="control-group">
                <form @submit.prevent="getService">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeSearchType" style="width: 100%;" v-model="searchType">
                                <option value="">All</option>
                                <option value="room">By Room</option>
                                <option value="customer">By Customer</option>
                                <option value="head">By Service Head</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'room'" style="display: none;" :style="{display: searchType == 'room' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="rooms" id="room" v-model="selectedRoom" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'customer'" style="display: none;" :style="{display: searchType == 'customer' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="customers" id="customer" v-model="selectedCustomer" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'head'" style="display: none;" :style="{display: searchType == 'head' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="heads" id="head" v-model="selectedHead" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="dateFrom">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="dateTo">
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
    <div style="display:none;" v-bind:style="{display: services.length > 0 && showReport ? '' : 'none'}">
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="" v-on:click.prevent="print">
                    <i class="fa fa-print"></i> Print
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" id="reportTable">
                    <table class="table table-bordered table-condensed record-table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Room Number</th>
                                <th>Service Head</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in services">
                                <td style="text-align:center;">@{{ sl + 1 }}</td>
                                <td>@{{ item.date }}</td>
                                <td>@{{ item.invoice }}</td>
                                <td>@{{ item.room_name }}</td>
                                <td>@{{ item.head_name }}</td>
                                <td style="text-align: left;">@{{ item.description }}</td>
                                <td style="text-align: right;">@{{ item.amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
        el: '#serviceList',
        data() {
            return {
                searchType: '',
                dateFrom: moment().format("YYYY-MM-DD"),
                dateTo: moment().format("YYYY-MM-DD"),
                services: [],

                rooms: [],
                selectedRoom: null,
                customers: [],
                selectedCustomer: null,
                heads: [],
                selectedHead: null,

                onProgress: false,
                showReport: null,
            }
        },

        methods: {
            getRoom() {
                axios.get("/get-room")
                    .then(res => {
                        this.rooms = res.data
                    })
            },

            getCustomer() {
                axios.get("/get-customer")
                    .then(res => {
                        this.customers = res.data
                    })
            },

            getServiceHead() {
                axios.get("/get-service-head")
                    .then(res => {
                        this.heads = res.data
                    })
            },

            onChangeSearchType() {
                this.rooms = [];
                this.selectedRoom = null;
                this.heads = [];
                this.selectedHead = null;
                this.customers = [];
                this.selectedCustomer = null;
                if (this.searchType == 'room') {
                    this.getRoom();
                }
                if (this.searchType == 'customer') {
                    this.getCustomer();
                }
                if (this.searchType == 'head') {
                    this.getServiceHead();
                }
            },

            getService() {
                let filter = {
                    roomId: this.selectedRoom != null ? this.selectedRoom.id : '',
                    headId: this.selectedHead != null ? this.selectedHead.id : '',
                    customerId: this.selectedCustomer != null ? this.selectedCustomer.id : '',
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-service", filter)
                    .then(res => {
                        let r = res.data;
                        this.services = r.filter(item => item.status != 'd')
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
                                <h4 style="text-align:center">Service List</h4 style="text-align:center">
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