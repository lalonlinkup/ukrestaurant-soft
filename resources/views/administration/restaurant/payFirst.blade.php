@extends('master')
@section('title', 'Pay First')
@section('breadcrumb_title', 'Pay First')
@push('style')
<style>
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
<div id="Order">
    <div class="row" style="margin:0;">
        <div class="col-md-12">
            <fieldset class="scheduler-border bg-of-skyblue">
                <legend class="scheduler-border">Order Information</legend>
                <div class="control-group">
                    <div class="row" style="margin:0;">
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding"> Guest </label>
                            <div class="col-sm-3">
                                <select id="customerType" v-model="customerType" class="form-control" @change="onChangeType">
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
                            <label class="col-sm-3 control-label no-padding-right"> Vat</label>
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
                            <label class="col-sm-3 control-label"> </label>
                            <div class="col-sm-9 no-padding-right text-right" style="margin-top: 5px;">
                                @if (userAction('e'))
                                <input type="button" class="btn btn-danger btn-reset" value="Reset"
                                    @click="newOrder">
                                <button :disabled="onProgress" type="button" @click="saveOrder"
                                    class="btn btn-primary btn-padding" v-html="btnText"></button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: "#Order",

        data() {
            return {
                order: {
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
                },
                discountPercent: 0,
                vatPercent: 0,
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
                banks: [],
                selectedBank: null,
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
                btnText: "Save",
                userType: "{{ Auth::user()->role }}",
                onProgress: false,
                customerType: 'cash',
                label: ''
            }
        },

        created() {
            this.getCategory();
            this.getMenu();
            this.getBankAccounts();
            if (this.order.id != 0) {
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

            getBankAccounts() {
                axios.get('/get-bank-accounts').then(res => {
                    this.banks = res.data.map(item => {
                        item.display_name =
                            `${item.number} - ${item.number} - ${item.bank_name}`;
                        return item;
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

            chooseMenu(menu) {
                this.selectedMenu = menu;
                this.selectedMenu.quantity = 1;
                this.selectedMenu.total = menu.sale_rate;

                this.addToCart();
            },

            menuTotal(menu) {
                menu.total = (parseFloat(menu.quantity) * parseFloat(menu.price)).toFixed(2);
                this.calculateTotal();
            },

            addToCart() {
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

            calculateTotal() {
                this.order.sub_total = this.cart.reduce((prev, curr) => {
                    return prev + parseFloat(curr.total)
                }, 0).toFixed(2);
                if (event.target.id == 'vatPercent') {
                    this.order.vat = ((parseFloat(this.order.sub_total) * parseFloat(this.vatPercent)) / 100)
                        .toFixed(2);
                } else {
                    this.vatPercent = (parseFloat(this.order.vat) / parseFloat(this.order.sub_total) * 100)
                        .toFixed(2);
                }
                if (event.target.id == 'discountPercent') {
                    this.order.discount = ((parseFloat(this.order.sub_total) * parseFloat(this
                        .discountPercent)) / 100).toFixed(2);
                } else {
                    this.discountPercent = (parseFloat(this.order.discount) / parseFloat(this.order.sub_total) *
                        100).toFixed(2);
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

            newOrder() {
                window.location = '/payFirst';
            },

            categoryOnChange(id) {
                this.selectedCategory = id;
                this.getMenu()
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
                    var url = '/add-payFirst-order';
                } else {
                    var url = '/update-payFirst-order';
                }
                let data = {
                    order: this.order,
                    carts: this.cart,
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
                            window.location = '/payFirst';
                        } else {
                            window.location = '/payFirst';
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
            }
        }
    })
</script>
@endpush