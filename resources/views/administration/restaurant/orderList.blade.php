@extends('master')
@section('title', 'Order Record')
@section('breadcrumb_title', 'Order Record')
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
<div id="orderRecord">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Search Orders Record</legend>
            <div class="control-group">
                <form @submit.prevent="getOrder">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeType" style="width: 100%;" v-model="filter.searchType">
                                <option value="">All</option>
                                <option value="customer">By Customer</option>
                                <option value="table">By Table</option>
                                <option value="category">By Category</option>
                                <option value="quantity">By Quantity</option>
                                <option value="user">By User</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'customer'" style="display: none;" :style="{display: filter.searchType == 'customer' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="customers" v-model="selectedCustomer" label="display_name" @search="onSearchcustomer"></v-select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'table'" style="display: none;" :style="{display: filter.searchType == 'table' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="tables" v-model="selectedTable" label="name"></v-select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'user'" style="display: none;" :style="{display: filter.searchType == 'user' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="users" v-model="selectedUser" label="name"></v-select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'category'" style="display: none;" :style="{display: filter.searchType == 'category' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="categories" v-model="selectedCategory" label="name"></v-select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'quantity'" style="display: none;" :style="{display: filter.searchType == 'quantity' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="menus" v-model="selectedMenu" label="display_name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 no-padding" v-if="filter.searchType != 'quantity' && filter.searchType != 'category'" style="display: none;" :style="{display: filter.searchType != 'quantity' && filter.searchType != 'category' ? '' : 'none'}">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">RecordType</label>
                            <select class="form-select no-padding" @change="onChangeType" style="width: 100%;" v-model="filter.recordType">
                                <option value="with">With Details</option>
                                <option value="without">Without Details</option>
                            </select>
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
        <div class="col-md-3" v-if="orders2.length > 0" style="display:none;" :style="{display: orders2.length > 0 ? '' : 'none'}">
            <input type="search" @input="filterArray($event)" placeholder="Search..." class="form-control">
        </div>
        <div class="col-md-9 text-right">
            <a v-if="orders.length > 0" style="display:none;" :style="{display: orders.length > 0 ? '' : 'none'}" href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
    </div>
    <div class="row" v-if="orders.length > 0 && showReport" style="display:none;" :style="{display: orders.length > 0 && showReport ? '' : 'none'}">
        <div class="col-md-12">
            <div class="table-responsive" id="reportTable">
                <table class="table table-bordered record-table table-condensed" v-if="filter.searchType !='category' && filter.searchType != 'quantity' && filter.recordType == 'with'" style="display:none;" :style="{display: filter.searchType !='category' && filter.searchType != 'quantity' && filter.recordType == 'with'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Invoice No.</th>
                            <th>Date</th>
                            <th>Guest Name</th>
                            <th>Menu Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th style="text-align: right;">Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(order, index) in orders">
                            <tr>
                                <td>@{{ index + 1 }}</td>
                                <td>@{{ order.invoice }}</td>
                                <td>@{{ order.date | dateFormat("DD-MM-YYYY") }}</td>
                                <td>@{{ order.customer_id == null ? order.customer_name : order.customer.name }}</td>
                                <td>@{{ order.order_details[0].menu.name }}</td>
                                <td style="text-align:center;">@{{ order.order_details[0].price | decimal }}</td>
                                <td style="text-align:center;">@{{ order.order_details[0].quantity | decimal }}</td>
                                <td style="text-align:right;">@{{ order.order_details[0].total | decimal }}</td>
                                <td style="text-align:center;">
                                    <a href="" title="Order Invoice" v-bind:href="`/order-invoice-print/${order.id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                    @if(userAction('u'))
                                    <a href="" title="Edit Order" @click.prevent="orderEdit(order)"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if(userAction('d'))
                                    <a href="" title="Delete Order" @click.prevent="deleteOrder(order)"><i class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                            <tr v-for="(item, sl) in order.order_details.slice(1)">
                                <td colspan="4" :rowspan="order.order_details.length - 1" v-if="sl == 0"></td>
                                <td>@{{ item.menu.name }}</td>
                                <td style="text-align:center;">@{{ item.price | decimal }}</td>
                                <td style="text-align:center;">@{{ item.quantity | decimal }}</td>
                                <td style="text-align:right;">@{{ item.total | decimal }}</td>
                                <td></td>
                            </tr>
                            <tr style="font-weight:bold;">
                                <td colspan="6" style="font-weight:normal;text-align:left;"><strong>Note: </strong>@{{ order.note }}</td>
                                <td style="text-align:center;">Total Quantity<br>@{{ order.order_details.reduce((prev, curr) => {return prev + parseFloat(curr.quantity)}, 0) | decimal }}</td>
                                <td style="text-align:right;">
                                    Total: @{{ order.total | decimal }}<br>
                                    Paid: @{{ order.paid | decimal }}<br>
                                    Due: @{{ order.due | decimal }}
                                </td>
                                <td></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <table class="table table-bordered record-table table-condensed" v-if="filter.searchType !='category' && filter.searchType != 'quantity' && filter.recordType == 'without'" style="display:none;" :style="{display: filter.searchType !='category' && filter.searchType != 'quantity' && filter.recordType == 'without'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Inv No.</th>
                            <th>Date</th>
                            <th>Guest Name</th>
                            <th>Sub Total</th>
                            <th>VAT</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Note</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in orders">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ order.invoice }}</td>
                            <td>@{{ order.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ order.customer_id == null ? order.customer_name : order.customer.name }}</td>
                            <td style="text-align:right;">@{{ order.sub_total | decimal }}</td>
                            <td style="text-align:right;">@{{ order.vat | decimal }}</td>
                            <td style="text-align:right;">@{{ order.discount | decimal }}</td>
                            <td style="text-align:right;">@{{ order.total | decimal }}</td>
                            <td style="text-align:right;">@{{ order.paid | decimal }}</td>
                            <td style="text-align:right;">@{{ order.due | decimal }}</td>
                            <td style="text-align:left;">@{{ order.note }}</td>
                            <td style="text-align:left;">@{{ order.order_type }}</td>
                            <td style="text-align:center;">
                                <span v-if="order.status == 'p'" style="color: orange">Draft</span>
                                <span v-else style="color: green">Billed</span>
                            </td>
                            <td style="text-align:center;">
                                <a href="" title="Order Invoice" v-bind:href="`/order-invoice-print/${order.id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                @if(userAction('u'))
                                <a href="" title="Edit Order" @click.prevent="orderEdit(order)"><i class="fa fa-edit"></i></a>
                                @endif
                                @if(userAction('d'))
                                <a href="" title="Delete Order" @click.prevent="deleteOrder(order)"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="4" style="text-align:right;">Total</td>
                            <td style="text-align:right;">@{{ orders.reduce((prev, curr)=>{return prev + parseFloat(curr.sub_total)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ orders.reduce((prev, curr)=>{return prev + parseFloat(curr.vat)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ orders.reduce((prev, curr)=>{return prev + parseFloat(curr.discount)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ orders.reduce((prev, curr)=>{return prev + parseFloat(curr.total)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ orders.reduce((prev, curr)=>{return prev + parseFloat(curr.paid)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ orders.reduce((prev, curr)=>{return prev + parseFloat(curr.due)}, 0) | decimal }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>

                </table>
                <table class="table table-bordered record-table table-condensed" v-if="filter.searchType =='category' || filter.searchType == 'quantity'" style="display:none;" :style="{display: filter.searchType =='category' || filter.searchType == 'quantity'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Invoice No.</th>
                            <th>Date</th>
                            <th>Guest Name</th>
                            <th>Menu Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in orders">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ order.invoice }}</td>
                            <td>@{{ order.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ order.customer_name }}</td>
                            <td>@{{ order.name }}</td>
                            <td style="text-align:right;">@{{ order.price }}</td>
                            <td style="text-align:right;">@{{ order.quantity }}</td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="6" style="text-align:right;">Total Quantity</td>
                            <td style="text-align:right;">@{{ orders.reduce((prev, curr) => { return prev + parseFloat(curr.quantity)}, 0) }}</td>
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
        el: '#orderRecord',
        data() {
            return {
                filter: {
                    searchType: "",
                    recordType: "without",
                    // status: 'a',
                    dateFrom: moment().format("YYYY-MM-DD"),
                    dateTo: moment().format("YYYY-MM-DD"),
                },
                orders: [],
                orders2: [],

                customers: [],
                selectedCustomer: null,
                tables: [],
                selectedTable: null,
                categories: [],
                selectedCategory: null,
                menus: [],
                selectedMenu: null,
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
            async orderEdit(row) {
                if (row.order_type == 'PayFirst') {
                    location.href = "/payFirst/" + row.id
                } else {
                    location.href = "/order/" + row.id
                }
            },

            getCategory() {
                axios.get("/get-menu-category").then(res => {
                    this.categories = res.data;
                })
            },

            getUser() {
                axios.post("/get-user").then(res => {
                    this.users = res.data.users;
                })
            },

            getMenu() {
                axios.get("/get-menu").then(res => {
                    let r = res.data;
                    this.menus = r.filter(item => item.status == 'a').map((item, index) => {
                        item.display_name = `${item.name} - ${item.code}`
                        return item;
                    });
                })
            },

            getCustomer() {
                axios.get("/get-customer").then(res => {
                    let r = res.data;
                    this.customers = r.map((item, index) => {
                        item.display_name = `${item.name} - ${item.code}`
                        return item;
                    });
                })
            },

            getTables() {
                axios.get('/get-table').then(res => {
                    this.tables = res.data;
                })
            },

            onChangeType(event) {
                this.orders = [];
                this.orders2 = [];
                this.selectedCustomer = null;
                this.selectedCategory = null;
                this.selectedMenu = null;
                this.selectedUser = null;
                this.filter.customerId = "";
                this.filter.categoryId = "";
                this.filter.menuId = "";
                this.filter.userId = "";
                if (event.target.value == 'customer') {
                    this.getCustomer();
                } else if (event.target.value == 'table') {
                    this.getTables();
                } else if (event.target.value == 'quantity') {
                    this.getMenu();
                } else if (event.target.value == 'category') {
                    this.getCategory();
                } else if (event.target.value == 'user') {
                    this.getUser();
                }
            },

            getOrder() {
                if (this.filter.searchType == 'customer') {
                    this.filter.customerId = this.selectedCustomer != null ? this.selectedCustomer.id : ""
                }
                if (this.filter.searchType == 'table') {
                    this.filter.tableId = this.selectedTable != null ? this.selectedTable.id : ""
                }
                if (this.filter.searchType == 'quantity' || this.filter.searchType == 'category') {
                    var url = '/get-order-details';
                    this.filter.menuId = this.selectedMenu != null ? this.selectedMenu.id : ""
                    this.filter.categoryId = this.selectedCategory != null ? this.selectedCategory.id : ""
                } else {
                    var url = "/get-order";
                    this.filter.userId = this.selectedUser != null ? this.selectedUser.id : ""
                }
                this.onProgress = true
                this.showReport = false
                axios.post(url, this.filter).then(res => {
                    let orders = res.data;
                    this.orders = orders.map(item => {
                        item.paid = parseFloat(parseFloat(item.paid) - parseFloat(item.returnAmount)).toFixed(this.fixed)
                        return item;
                    })
                    this.orders2 = this.orders
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

            async deleteOrder(row) {
                let formdata = {
                    id: row.id
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-order", formdata).then(res => {
                        toastr.success(res.data.message)
                        this.getOrder();
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
                                <h4 style="text-align:center">orders Record</h4>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-6">
								${userText} ${customerText} ${menuText} ${categoryText}
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

                if (this.filter.searchType != 'category' && this.filter.searchType != 'quantity') {
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

            // filter orderrecord
            filterArray(event) {
                this.orders = this.orders2.filter(order => {
                    return order.invoice.toLowerCase().startsWith(event.target.value.toLowerCase()) || order.date.toLowerCase().startsWith(event.target.value.toLowerCase());
                })
            },
        },
    })
</script>
@endpush