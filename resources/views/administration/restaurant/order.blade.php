@extends('master')
@section('title', 'Table Booking Entry')
@section('breadcrumb_title', 'Table Booking Entry')
@push('style')
<link rel="stylesheet" href="{{asset('backend')}}/css/booking.css" />
<link rel="stylesheet" href="{{asset('backend')}}/css/fullcalendar.css" />
<style scoped>
    .v-select .dropdown-menu {
        width: 450px !important;
    }

    .booking .control-label {
        padding: 0 !important;
    }

    .v-select .selected-tag {
        margin: 8px 2px !important;
        white-space: nowrap;
        position: absolute;
        left: 0px;
        top: 0;
        line-height: 0px !important;
    }

    .table>tbody>tr>td {
        padding: 5px;
    }

    .membersection {
        overflow-y: auto;
    }

    .membersection::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    .membersection::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 5px;
    }

    /* Handle */
    .membersection::-webkit-scrollbar-thumb {
        background: #8726269e;
        border-radius: 5px;
    }

    .sidebar-nav {
        margin: 5px 0px;
        width: 100%;
    }

    .sidebar-nav ul li {
        width: 100%;
        background: #8BC34A;
        margin: 2px 0px;
        border-radius: 3px;
        cursor: pointer;
    }

    .sidebar-nav .active {
        background: #FF5722;
        border-radius: 3px;
    }

    .active a {
        color: #fff;
    }

    .sidebar-nav ul li a {
        padding: 5px;
        font-weight: 600;
        justify-content: center;
        transition: .3s ease-in-out;
    }

    .sidebar-nav ul li a:hover {
        background: #FF5722;
        border-radius: 3px;
        color: #fff;
    }

    .menu-image {
        width: 22%;
        margin: 5px;
        cursor: pointer;
    }

    .menu-image img {
        width: 100%;
        height: 80px;
        overflow: hidden;
    }

    .menu-image p {
        margin: 0;
        height: 25px;
        overflow: hidden;
        background: #2e6c6e;
        color: #fff;
        padding: 3px 5px;
        font-size: 11px;
        text-align: center;
    }

    .menu_div {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="row" id="orderBookingForm">
    <div class="col-md-12 col-xs-12">
        <div class="tab-content" style="border: none;padding: 0px">
            <div id="tab1" class="tab-pane fade in active" style="padding: 10px">
                <div class="row" style="border-bottom: 1px solid gray;">
                    <div class="col-md-12 col-xs-12 border-radius" style="display:flex;align-items:center;padding:0 !important;background:#aee2ff;border: 1px groove #848f95 !important;padding:5px 0;">
                        <div class="col-md-4">
                            <div class="date" style="display:flex;align-items:center;gap:5px;">
                                <label for="" style="width: 25%;">Table Type</label>
                                <div style="width: 75%;">
                                    <select class="form-control" v-model="filter.typeId" style="border-radius:5px;margin:0;height:30px;">
                                        <option value="">All</option>
                                        <option v-for="tabletype in tabletypes" :value="tabletype.id">@{{tabletype.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="date" style="display:flex;align-items:center;gap:5px;">
                                <label for="" style="width: 30%;">Incharge</label>
                                <div style="width: 70%;">
                                    <select class="form-control" v-model="filter.inchargeId" style="border-radius:5px;margin:0;height:30px;">
                                        <option value="">All</option>
                                        <option v-for="incharge in incharges" :value="incharge.id">@{{incharge.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-xs-12" style="float:right">
                            <button type="button" @click="getTables" style="cursor:pointer;font-size:18px;border:1px groove #848f95;padding:0px 10px;border-radius:5px;background:white;">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;padding:0;display:none;" v-if="floors.length > 0 && showReport" :style="{display: floors.length > 0 && showReport ? '' : 'none'}">
                    <div class="col-md-12 col-xs-12" v-for="floor in floors" style="padding:0;" v-if="floor.tables.length > 0">
                        <h3 style="border-bottom: 1px double rgb(232, 97, 0); text-align: left; background: #224079; padding: 5px;">@{{floor.name}}</h3>
                        <form action="">
                            <div class="col-md-12 col-xs-12 about-table" style="padding-left:12px !important;">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 no-padding" style="display:flex;flex-wrap: wrap;">
                                        <div class="content" v-for="tableItem in floor.tables">
                                            <label :for="'table-'+tableItem.id">
                                                <div class="booking-card" :style="{background: tableItem.color}">
                                                    <div class="card-image text-center">
                                                        <!-- <i class="bi bi-house fa-4x" alt="House Image" style=" color:white;width: 100%; height: 100%; object-fit: cover;"></i> -->
                                                        <div class="overlay">
                                                            <p>@{{tableItem.name}}</p>
                                                        </div>
                                                        <div class="top-right-text">
                                                            <div class="col-xs-6 no-padding" style="text-align: left;">
                                                                <input v-if="tableItem.color == '#aee2ff'" :style="{visibility: tableItem.color == '#aee2ff' ? '' : 'hidden'}" @change="addToTableCart($event)" type="checkbox" :value="tableItem.id" v-model="tableItem.checkStatus" :id="'table-'+tableItem.id">
                                                            </div>
                                                            <div class="col-xs-6 no-padding" style="display: flex; justify-content: end;">
                                                                <button type="button" class="icon-container" @click="showTableInfo(tableItem.id)">
                                                                    <i class="bi bi-info"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-button">@{{tableItem.color == '#aee2ff' ? 'Available' : tableItem.color == '#ff0000ab' ? 'Check In' : 'Booked'}}</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 col-xs-12 no-padding">
                        <a v-if="tableCart.length > 0" data-toggle="tab" href="#tab2">
                            <button type="button" class="btn btn-next" style="float:right; margin-top:10px; background:#BC2649 !important;">
                                Next <i class="bi bi-arrow-right"></i>
                            </button>
                        </a>
                        <a v-else @click="errorMsg">
                            <button type="button" class="btn btn-next" style="float:right; margin-top:10px; background:#BC2649 !important;">
                                Next <i class="bi bi-arrow-right"></i>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="row" style="display:none;" v-bind:style="{display: showReport == false ? '' : 'none'}">
                    <div class="col-md-12 text-center">
                        <img src="{{asset('loading.gif')}}" style="width: 90px;"> Loading..
                    </div>
                </div>
            </div>
            <div id="tab2" class="tab-pane fade">
                <div class="row" style="margin:0;">
                    <div class="col-md-12">
                        <fieldset class="scheduler-border bg-of-skyblue">
                            <legend class="scheduler-border">Order Information</legend>
                            <div class="control-group">
                                <div class="row" style="margin:0;">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding"> Guest </label>
                                        <div class="col-sm-3">
                                            <select id="customerType" v-model="customerType" class="form-control" @change="onChangeType" style="border-radius: 5px; margin: 0;">
                                                <option value="cash">Cash Guest</option>
                                                <option value="new">New Guest</option>
                                                <option value="existing">Existing Guest</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding"> Invoice no </label>
                                        <div class="col-sm-3">
                                            <input type="text" id="invoiceNo" class="form-control" v-model="order.invoice" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding"> Order Date </label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="date" type="date" v-model="order.date"
                                                :disabled="userType == 'user' || userType == 'manager' ? true : false" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding">@{{ label != '' ? label : 'Name' }} </label>
                                        <div class="col-sm-3">
                                            <input type="text" v-if=" customerType == 'cash' || customerType == 'new'" style="display: none;" :style="{display: customerType == 'cash' || customerType == 'new' ? '' : 'none' }" id="customerName" placeholder="Customer Name" class="form-control" v-model="selectedCustomer.name"
                                                v-bind:disabled="customerType == 'cash' || customerType == 'new' ? false : true" />

                                            <v-select style="display: none;" :style="{display: customerType == 'existing' ? '' : 'none' }" :options="customers" v-model="selectedCustomer" id="customer" label="display_name"></v-select>
                                        </div>
                                    </div>

                                    <div class="form-group" class="form-group" v-if=" customerType == 'existing'" style="display: none;" :style="{display:  customerType == 'existing' ? '' : 'none' }">
                                        <label class="col-sm-1 control-label no-padding"> Name </label>
                                        <div class="col-sm-3">
                                            <input type="text" id="cusName" placeholder="Name" class="form-control" v-model="selectedCustomer.name" disabled autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding"> Mobile No </label>
                                        <div class="col-sm-3">
                                            <input type="text" id="mobileNo" placeholder="Mobile No" class="form-control"
                                                v-model="selectedCustomer.phone"
                                                v-bind:disabled="customerType == 'cash' || customerType == 'new' ? false : true"
                                                autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="form-group" v-if=" customerType == 'cash' || customerType == 'new'" style="display: none;" :style="{display: customerType == 'cash' || customerType == 'new' ? '' : 'none' }">
                                        <label class="col-sm-1 control-label no-padding">Address </label>
                                        <div class="col-sm-3">
                                            <input type="text" id="Address" placeholder="Address" class="form-control"
                                                v-model="selectedCustomer.address"
                                                v-bind:disabled="customerType == 'cash' || customerType == 'new' ? false : true" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row" style="margin:0;">
                    <div class="col-md-12">
                        <fieldset class="scheduler-border bg-of-skyblue">
                            <legend class="scheduler-border">Table Booking Information</legend>
                            <div class="control-group">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Table</th>
                                            <th>Type</th>
                                            <th>Incharge</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, sl) in tableCart">
                                            <td>@{{sl + 1}}</td>
                                            <td>@{{item.name}}</td>
                                            <td>@{{item.typeName}}</td>
                                            <td>@{{item.inchargeName}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row" style="margin:0;">
                    <div class="col-md-2">
                        <fieldset class="scheduler-border bg-of-skyblue" style="height: 300px;" :style="{overflowY: categories.length > 8 ? 'scroll' : 'auto' }">
                            <legend class="scheduler-border">Category</legend>
                            <div class="control-group">
                                <div class="sidebar-nav">
                                    <ul class="nav navbar-nav" style="display: none"
                                        :style="{ display: categories.length > 0 ? '' : 'none' }">
                                        <li :class="{ active: selectedCategory == null }"><a type="button"
                                                @click="categoryOnChange()">All Category</a></li>
                                        <li v-for="item in categories" :class="{ active: item.id == selectedCategory }"><a
                                                type="button" @click="categoryOnChange(item.id)">@{{ item.name }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-5">
                        <fieldset class="scheduler-border bg-of-skyblue" style="height: 300px;" :style="{overflowY: filterMenus.length > 8 ? 'scroll' : 'auto' }">
                            <legend class="scheduler-border">Menu List</legend>
                            <div class="control-group">
                                <div class="col-md-12" style="padding: 0;">
                                    <div class="form-group clearfix">
                                        <input type="text" class="form-control" name="search" v-model="search"
                                            v-on:input="searchMenu" placeholder="search">
                                    </div>

                                    <div class="menu_div">
                                        <div class="menu-image" v-for="menu in filterMenus" @click.prevent="chooseMenu(menu)">
                                            <img :src="menu.image ? '/' + menu.image : '/noImage.gif'" :alt="menu.name"
                                                class="img-responsive">
                                            <p>@{{ menu.name }}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-5">
                        <fieldset class="scheduler-border bg-of-skyblue" style="height: 300px;">
                            <legend class="scheduler-border">Cart Information</legend>
                            <div class="control-group">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="">
                                            <th>Sl</th>
                                            <th>Name</th>
                                            <th>Rate</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
                                        <tr v-for="(product, sl) in cart">
                                            <td width="5%">@{{ sl + 1 }}</td>
                                            <td width="35%">@{{ product.name }}</td>
                                            <td width="20%">
                                                <input class="form-control" min="0" style="height: 20px" type="number"
                                                    step="0.01" v-model="product.price" v-on:input="menuTotal(product)">
                                            </td>
                                            <td width="15%">
                                                <input class="form-control" min="1" style="height: 20px" type="number"
                                                    v-model="product.quantity" v-on:input="menuTotal(product)">
                                            </td>
                                            <td width="20%">@{{ product.total }}</td>
                                            <td width="5%"><a href="" v-on:click.prevent="removeFromCart(sl)"><i
                                                        class="fa fa-trash"></i></a></td>
                                        </tr>

                                        <tr style="font-weight: bold;">
                                            <td colspan="4">Note</td>
                                            <td colspan="2">Total</td>
                                        </tr>

                                        <tr>
                                            <td colspan="4">
                                                <textarea style="width: 100%;font-size:13px;" placeholder="Note" v-model="order.note"></textarea>
                                            </td>
                                            <td colspan="2" style="padding-top: 15px;font-size:18px;">@{{ order.total }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row" style="margin:0;">
                    <div class="col-md-12">
                        <fieldset class="scheduler-border bg-of-skyblue">
                            <legend class="scheduler-border">Payment Information</legend>
                            <div class="control-group">
                                <div class="col-xs-12 col-sm-4 no-padding">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right"> Sub Total </label>
                                        <div class="col-sm-9 no-padding-right">
                                            <input type="number" id="subTotal" class="form-control" v-model="order.sub_total"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right"> VAT</label>
                                        <div class="col-sm-3 no-padding-right">
                                            <input type="number" min="0" id="vatPercent" class="form-control"
                                                v-model="vatPercent" v-on:input="calculateTotal" />
                                        </div>
                                        <label class="col-sm-1 control-label"> %</label>
                                        <div class="col-sm-5 no-padding-right">
                                            <input type="number" id="vat" class="form-control" v-model="order.vat"
                                                v-on:input="calculateTotal" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right"> Discount</label>
                                        <div class="col-sm-3 no-padding-right">
                                            <input type="number" min="0" id="discountPercent" class="form-control"
                                                v-model="discountPercent" v-on:input="calculateTotal" />
                                        </div>
                                        <label class="col-sm-1 control-label"> %</label>
                                        <div class="col-sm-5 no-padding-right">
                                            <input type="number" id="discount" class="form-control" v-model="order.discount"
                                                v-on:input="calculateTotal" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 no-padding-right">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right">Total </label>
                                        <div class="col-sm-9">
                                            <input type="number" id="total" class="form-control" v-model="order.total"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right"> Cash Paid</label>
                                        <div class="col-sm-9">
                                            <input type="number" min="0" id="cashPaid" class="form-control"
                                                v-model="order.cashPaid" v-on:input="paidCalculate" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right"> Bank Paid</label>
                                        <div class="col-sm-9">
                                            <input type="number" min="0" id="bankPaid" class="form-control"
                                                v-model="order.bankPaid" v-on:input="paidCalculate" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group" v-if="order.bankPaid > 0" style="display:none;"
                                        :style="{ display: order.bankPaid > 0 ? '' : 'none' }">
                                        <label class="col-sm-3 control-label no-padding-right"> Bank </label>
                                        <div class="col-sm-9 no-padding-right">
                                            <v-select :options="banks" v-model="selectedBank"
                                                label="display_name"></v-select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right"> Due</label>
                                        <div class="col-sm-9 no-padding-right">
                                            <input type="number" id="due" class="form-control"
                                                v-model="order.due" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right"> Return</label>
                                        <div class="col-sm-9 no-padding-right">
                                            <input type="number" id="returnAmount" class="form-control"
                                                v-model="order.returnAmount" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 no-padding-right text-right" style="margin-top: 5px;">
                                            <a data-toggle="tab" href="#tab1" class="btn btn-danger btn-reset" style="font-size:11px;padding:0px 30px !important"><i class="bi bi-arrow-left"></i> Previous</a>
                                            <input :disabled="onProgress" type="button" @click="saveOrder" class="btn btn-warning btn-padding" value="Draft">
                                            <input :disabled="onProgress" type="button" @click="saveOrder" class="btn btn-primary btn-padding" :value="btnText">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal for table view -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" style="border-radius:20px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title" style="text-align:left;font-weight:bold;color:#000;">Table: @{{tableInfo.name}}</h3>
                </div>
                <div class="modal-body" style="margin-bottom:15px">
                    <div class="row" style="margin: 10px;  box-shadow: 0px 2px 5px 0px #c2bfbf;border-radius:10px;padding-top:10px;padding-bottom:15px">
                        <div class="col-md-12 col-xs-12" style="text-align: justify;margin-top:10px">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('backend')}}/js/fullcalendar.min.js"></script>
<script>
    new Vue({
        el: '#orderBookingForm',
        data() {
            return {
                filter: {
                    floorId: '',
                    typeId: '',
                    inchargeId: '',
                    searchType: '',
                },
                order: {
                    id: parseInt('{{$id}}'),
                    invoice: "{{ $invoice }}",
                    date: moment().format("YYYY-MM-DD"),
                    customer_id: '',
                    sub_total: 0,
                    discount: 0,
                    vat: 0,
                    total: 0,
                    cashPaid: 0,
                    bankPaid: 0,
                    returnAmount: 0,
                    paid: 0,
                    due: 0,
                    note: ''
                },
                floors: [],
                tabletypes: [],
                incharges: [],
                customers: [],
                selectedCustomer: {
                    id: '',
                    code: '',
                    name: 'Cash Customer',
                    display_name: 'Cash Customer',
                    phone: '',
                    address: '',
                    type: 'G'
                },
                categories: [],
                selectedCategory: null,
                menus: [],
                filterMenus: [],
                selectedMenu: null,
                menu: {
                    id: '',
                    code: '',
                    name: '',
                    sale_rate: 0,
                    vat: 0,
                    quantity: 0,
                    total: 0
                },
                cart: [],
                search: '',
                label: '',
                userType: "{{ Auth::user()->role }}",
                banks: [],
                selectedBank: null,

                tableCart: [],
                selectedCart: null,
                members: [],
                discountPercent: 0,
                vatPercent: 0,

                tableInfo: {},
                onProgress: false,
                showReport: null,
                customerType: 'cash',
                btnText: "Save",
            }
        },
        created() {
            this.getTableType();
            this.getIncharge();
            this.getCustomer();
            this.getTables();
            this.getCategory();
            this.getMenu();
            this.getBankAccounts();
            if (this.order.id != 0) {
                $("#tab1").removeClass('in active');
                $("#tab2").addClass('in active');
                this.getOrder();
            }
        },
        methods: {
            onChangeType(event) {
                this.label = '';
                if (this.customerType == 'new') {
                    this.selectedCustomer = {
                        id: '',
                        code: '',
                        name: '',
                        display_name: 'New Guest',
                        phone: '',
                        address: '',
                        type: 'N'
                    }
                    document.querySelector("#customerName").focus();
                } else if (this.customerType == 'existing') {
                    this.label = 'Customer';
                    this.getCustomers();
                    document.querySelector("#customer [type='search']").focus();
                } else {
                    this.selectedCustomer = {
                        id: '',
                        code: "",
                        name: 'Cash Customer',
                        display_name: 'Cash Customer',
                        phone: '',
                        address: '',
                        type: 'G'
                    }
                }

                if (this.customerType != 'cash') {
                    this.order.cashPaid = 0;
                    this.order.due = this.order.total;
                }
            },
            getCustomer() {
                axios.get("/get-customer").then(res => {
                    this.customers = res.data.map(item => {
                        item.display_name = `${item.name} - ${item.phone}`;
                        return item;
                    });
                    this.customers.unshift({
                        id: '',
                        name: '',
                        email: '',
                        phone: '',
                        nid: '',
                        address: '',
                        display_name: 'New Guest'
                    });
                })
            },
            async getCustomers() {
                await axios.get('/get-customer').then(res => {
                    this.customers = res.data.map(item => {
                        item.display_name = `${item.code} - ${item.name}`;
                        return item;
                    })
                })
            },
            getIncharge() {
                axios.get("/get-employee").then(res => {
                    this.incharges = res.data;
                })
            },
            getCategory() {
                axios.get("/get-menu-category").then(res => {
                    this.categories = res.data
                })
            },
            getMenu() {
                axios.post('/get-menu', {
                    categoryId: this.selectedCategory
                }).then(res => {
                    let menu = res.data.filter(item => item.status == 'a');
                    this.menus = menu;
                    this.filterMenus = menu;
                })
            },
            getBankAccounts() {
                axios.get('/get-bank-accounts').then(res => {
                    this.banks = res.data.map(item => {
                        item.display_name =
                            `${item.number} - ${item.number} - ${item.bank_name}`;
                        return item;
                    });
                })
            },
            categoryOnChange(id) {
                this.selectedCategory = id;
                this.getMenu()
            },
            clearMenu() {
                this.menu = {
                    id: '',
                    code: '',
                    name: '',
                    sale_rate: 0,
                    vat: 0,
                    quantity: 0,
                    total: 0
                }
            },
            searchMenu() {
                let search = this.search.toLowerCase();
                if (search !== '') {
                    this.filterMenus = this.menus.filter(m => {
                        let name = m.name.toLowerCase();
                        if (name.search(search) > -1) {
                            return m;
                        }
                    })
                } else {
                    this.filterMenus = this.menus;
                }
            },
            async saveOrder() {
                if (this.customerType == 'existing' && this.selectedCustomer.id == '') {
                    toastr.error("Select Customer.!");
                    return;
                }
                if (this.cart.length == 0) {
                    toastr.error("Cart is empty.!");
                    return;
                }
                if (this.order.bankPaid > 0) {
                    this.order.bank_account_id = this.selectedBank != null ? this.selectedBank.id : "";
                } else {
                    this.order.bank_account_id = '';
                }
                if (this.order.id == 0 && this.selectedCustomer.id != '') {
                    this.selectedCustomer.type = 'retail';
                }
                if (this.order.id == 0) {
                    var url = '/add-order';
                } else {
                    var url = '/update-order';
                }
                let data = {
                    order: this.order,
                    carts: this.cart,
                    tableCart: this.tableCart,
                    customer: this.selectedCustomer
                }
                this.onProgress = true
                await axios.post(url, data).then(async res => {
                    let r = res.data;
                    console.log(r);
                    toastr.success(r.message);
                    this.clearForm();
                    this.onProgress = false
                    if (r.status) {
                        let conf = confirm('Order success, Do you want to view invoice?');
                        if (conf) {
                            window.open('/order-invoice-print/' + r.id, '_blank');
                            await new Promise(r => setTimeout(r, 1000));
                            window.location = '/order';
                        } else {
                            window.location = '/order';
                        }
                    }
                }).catch(err => {
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

            clearForm() {
                this.order = {
                    id: "{{ $id }}",
                    invoice: "{{ $invoice }}",
                    date: moment().format("YYYY-MM-DD"),
                    customer_id: '',
                    sub_total: 0,
                    discount: 0,
                    vat: 0,
                    total: 0,
                    cashPaid: 0,
                    bankPaid: 0,
                    returnAmount: 0,
                    paid: 0,
                    due: 0,
                    note: '',
                };

                this.vatPercent = 0;
                this.discountPercent = 0;
                this.selectedBank = null;
                this.cart = [];
                this.customerType = 'cash';
                this.selectedCustomer = {
                    id: "",
                    name: "Cash Customer",
                    phone: "",
                    address: "",
                    display_name: "Cash Customer",
                    type: "G",
                }
            },

            chooseMenu(menu) {
                this.selectedMenu = menu;
                this.selectedMenu.quantity = 1;
                this.selectedMenu.total = menu.sale_rate;

                this.addToMenuCart();
            },
            addToMenuCart() {
                let menu = {
                    menu_id: this.selectedMenu.id,
                    code: this.selectedMenu.code,
                    name: this.selectedMenu.name,
                    price: this.selectedMenu.sale_rate,
                    vat: this.selectedMenu.vat,
                    quantity: this.selectedMenu.quantity,
                    total: this.selectedMenu.total
                }

                if (menu.menu_id == '') {
                    toastr.error("Select Menu");
                    return;
                }

                if (menu.quantity == 0 || menu.quantity == '') {
                    toastr.error("Enter quantity");
                    return;
                }

                let cartInd = this.cart.findIndex(m => m.menu_id == menu.menu_id);
                if (cartInd > -1) {
                    this.cart[cartInd].quantity += +menu.quantity;
                    this.cart[cartInd].total = parseFloat(+this.cart[cartInd].quantity * +this.cart[cartInd]
                        .price).toFixed(2);
                } else {
                    this.cart.unshift(menu);
                }

                this.clearMenu();
                this.calculateTotal();
            },
            removeFromCart(ind) {
                this.cart.splice(ind, 1);
                this.calculateTotal();
            },
            paidCalculate() {
                const cashPaid = this.order.cashPaid ? parseFloat(this.order.cashPaid) : 0;
                const bankPaid = this.order.bankPaid ? parseFloat(this.order.bankPaid) : 0;
                this.order.paid = (cashPaid + bankPaid).toFixed(this.fixed);
                this.calculateTotal();
            },

            menuTotal(menu) {
                menu.total = (parseFloat(menu.quantity) * parseFloat(menu.price)).toFixed(2);
                this.calculateTotal();
            },

            getTableType() {
                axios.get("/get-tabletype").then(res => {
                    this.tabletypes = res.data;
                })
            },

            getTables() {
                this.tableCart = [];
                this.showReport = false;
                axios.post("/get-table-list", this.filter).then(res => {
                    this.floors = res.data.map(floor => {
                        floor.tables = floor.tables.map(item => {
                            item.checkStatus = false;
                            return item;
                        })
                        return floor;
                    });
                    this.showReport = true;
                })
            },

            async addToTableCart(event) {
                if (event.target.checked) {
                    let avaiable = await axios.post('/get-available-table', {
                        id: event.target.value
                    }).then(res => {
                        return res.data;
                    })

                    if (avaiable.status == false) {
                        event.target.checked = false;
                        toastr.error(`This table not available on this date: ${avaiable.date}`);
                        return;
                    }

                    let table = await axios.post('/get-table', {
                        tableId: event.target.value
                    }).then(res => {
                        return res.data[0];
                    })

                    let cart = {
                        table_id: table.id,
                        name: table.name,
                        typeName: table.tabletype_name,
                        inchargeId: table.incharge_id,
                        inchargeName: table.incharge_name,
                    }
                    this.tableCart.push(cart);
                } else {
                    let findIndex = this.tableCart.findIndex(item => item.table_id == event.target.value);
                    this.tableCart.splice(findIndex, 1);
                }

                this.calculateTotal();
            },
            async editCart(item) {
                let today = moment().format("YYYY-MM-DD");
                if (this.booking.id == 0 && today > item.checkin_date) {
                    toastr.error('Checkin date less then today.!');
                    item.checkin_date = today;
                    return;
                }
                let filter = {
                    id: item.table_id,
                    checkin_date: item.checkin_date,
                    checkout_date: item.checkout_date
                }
                if (this.booking.id > 0) {
                    filter.booking_id = this.booking.id;
                }
                let avaiable = await axios.post('/get-available-table', filter).then(res => {
                    return res.data;
                })

                if (avaiable.status == false) {
                    toastr.error(`This table not available on this date: ${avaiable.date}`);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                    return;
                }
                let checkTime = moment(item.checkin_date).format("HH:mm:ss")
                if (checkTime > "12:00:00") {
                    item.checkin_date = moment(item.checkin_date).format("YYYY-MM-DD") + " 12:00:00";
                }
                let checkin_date = moment(item.checkin_date);
                let checkout_date = moment(item.checkout_date).format("YYYY-MM-DD") + " 12:00:00";
                checkout_date = moment(checkout_date);
                let totalDays = checkout_date.diff(checkin_date, 'days');

                item.days = totalDays;
                item.total = totalDays * item.unit_price;
                this.calculateTotal();
            },
            calculateTotal() {
                this.order.sub_total = this.cart.reduce((prev, curr) => {
                    return prev + parseFloat(curr.total)
                }, 0).toFixed(2);

                if (event.target.id == 'vatPercent') {
                    this.order.vat = ((parseFloat(this.order.sub_total) * parseFloat(this.vatPercent)) / 100).toFixed(2);
                } else {
                    this.vatPercent = (parseFloat(this.order.vat) / parseFloat(this.order.sub_total) * 100).toFixed(2);
                }

                if (event.target.id == 'discountPercent') {
                    this.order.discount = ((parseFloat(this.order.sub_total) * parseFloat(this.discountPercent)) / 100).toFixed(2);
                } else {
                    this.discountPercent = (parseFloat(this.order.discount) / parseFloat(this.order.sub_total) * 100).toFixed(2);
                }

                this.order.total = ((parseFloat(this.order.sub_total) + parseFloat(this.order.vat)) -
                    parseFloat(this.order.discount)).toFixed(2);

                if (event.target.id == 'cashPaid' || event.target.id == 'bankPaid') {
                    this.order.returnAmount = 0;
                    let returnAmount = parseFloat(this.order.total) - parseFloat(this.order.paid);

                    if (returnAmount <= 0) {
                        this.order.returnAmount = parseFloat(String(returnAmount).replace('-', '')).toFixed(2);
                    }
                } else {
                    if (this.customerType == 'cash') {
                        this.order.cashPaid = parseFloat(this.order.total).toFixed(2);
                        this.order.paid = this.order.cashPaid;
                    } else {
                        this.order.paid = parseFloat(0).toFixed(2);
                        this.order.due = parseFloat(this.order.total).toFixed(2);
                    }
                    this.order.returnAmount = parseFloat(0).toFixed(2);
                }
            },
            async showTableInfo(id) {
                let tableInfo = await axios.post('/get-table', {
                    tableId: id
                }).then(res => {
                    return res.data[0];
                })
                setTimeout(() => {
                    this.tableCalendar(id);
                }, 500)
                this.tableInfo = tableInfo;
                $("#myModal").modal("show");
            },
            errorMsg() {
                toastr.error("Cart is empty");
            },
            getOrder() {
                this.btnText = 'Update';
                axios.post("/get-order", {
                    id: this.order.id
                }).then(res => {
                    let order = res.data[0];
                    let keys = Object.keys(this.order);
                    keys.forEach(key => {
                        this.order[key] = order[key];
                    });

                    var customerId = order.customer_id;
                    if (customerId != null) {
                        this.customerType = 'existing';
                    }

                    this.selectedCustomer = {
                        id: customerId == null ? null : order.customer_id,
                        name: customerId == null ? order.customer_name : order.customer ? order.customer.name : 'n/a',
                        phone: customerId == null ? order.customer_phone : order.customer ? order.customer.phone : 'n/a',
                        address: customerId == null ? order.customer_address : order.customer ? order.customer.address : 'n/a',
                        display_name: customerId == null ? "Cash Customer" : `${order.customer ? order.customer.code : 'n/a'} - ${order.customer ? order.customer.name : 'n/a'}`,
                        type: customerId == null ? 'G' : 'retail'
                    }

                    if (order.bankPaid > 0) {
                        this.selectedBank = {
                            id: order.bank_account_id,
                            name: order.bank != null ? order.bank.name : "",
                            display_name: order.bank != null ?
                                `${order.bank.name}-${order.bank.number}-${order.bank.bank_name}` : ""
                        }
                    }

                    order.order_tables.forEach(item => {
                        let tdetail = {
                            table_id: item.table_id,
                            name: item.table_name,
                            typeName: item.type_name,
                            inchargeId: item.incharge_id,
                            inchargeName: item.incharge_name,
                        }
                        this.tableCart.push(tdetail);
                    })

                    order.order_details.forEach(detail => {
                        let menu = {
                            menu_id: detail.menu_id,
                            code: detail.menu.code,
                            name: detail.menu.name,
                            quantity: detail.quantity,
                            price: parseFloat(detail.price).toFixed(this.fixed),
                            vat: detail.vat,
                            total: detail.total
                        }
                        this.cart.push(menu);
                    })

                    this.calculateTotal();
                })
            },
            getBooking() {
                axios.post("/get-booking", {
                    id: this.booking.id
                }).then(res => {
                    let booking = res.data[0];
                    let keys = Object.keys(this.booking);
                    keys.forEach(key => {
                        this.booking[key] = booking[key];
                    });
                    this.booking.is_other = booking.is_other == 'true' ? true : false;
                    this.booking.booking_status = booking.booking_details[0].booking_status

                    this.selectedCustomer = {
                        id: booking.customer_id,
                        name: booking.customer_name,
                        phone: booking.customer_phone,
                        nid: booking.customer_nid,
                        address: booking.customer_address,
                        display_name: `${booking.customer_name} - ${booking.customer_phone}`
                    }

                    this.members = booking.othercustomer;
                    booking.booking_details.forEach(item => {
                        let detail = {
                            table_id: item.table_id,
                            name: item.table_name,
                            typeName: item.type_name,
                            inchargeName: item.incharge_name,
                            days: item.days,
                            unit_price: parseFloat(item.unit_price).toFixed(2),
                            total: parseFloat(item.unit_price * item.days).toFixed(2),
                            checkin_date: moment(item.checkin_date).format('YYYY-MM-DD'),
                            checkout_date: moment(item.checkout_date).format('YYYY-MM-DD'),
                        }
                        this.tableCart.push(detail);
                    })
                    this.calculateTotal();
                })
            },

            tableCalendar(tableId) {
                $.ajax({
                    url: "/get-tablecalendar",
                    method: 'post',
                    data: {
                        tableId: tableId
                    },
                    success: res => {
                        $('#calendar').fullCalendar('destroy');
                        $('#calendar').fullCalendar({
                            height: 150,
                            contentHeight: 150,
                            left: 'title',
                            center: '',
                            right: 'prev,next',
                            events: res
                        });
                    }
                })
            }
        },
    })
</script>
@endpush