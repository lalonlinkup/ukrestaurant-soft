@extends('master')
@section('title', 'Material Purchase List')
@section('breadcrumb_title', 'Material Purchase List')
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
<div id="purchaseList">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Search Material Purchase List</legend>
            <div class="control-group">
                <form @submit.prevent="getPurchase">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeType" style="width: 100%;" v-model="filter.searchType">
                                <option value="">All</option>
                                <option value="supplier">By Supplier</option>
                                <option value="employee">By Employee</option>
                                <option value="quantity">By Quantity</option>
                                <option value="user">By User</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'supplier'" style="display: none;" :style="{display: filter.searchType == 'supplier' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="suppliers" v-model="selectedSupplier" label="display_name" @search="onSearchSupplier"></v-select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'employee'" style="display: none;" :style="{display: filter.searchType == 'employee' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="employees" v-model="selectedEmployee" label="name"></v-select>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'user'" style="display: none;" :style="{display: filter.searchType == 'user' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="users" v-model="selectedUser" label="name"></v-select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'quantity'" style="display: none;" :style="{display: filter.searchType == 'quantity' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="materials" v-model="selectedMaterial" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 no-padding" v-if="filter.searchType != 'quantity'" style="display: none;" :style="{display: filter.searchType != 'quantity' ? '' : 'none'}">
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
        <div class="col-md-3" v-if="purchases2.length > 0" style="display:none;" :style="{display: purchases2.length > 0 ? '' : 'none'}">
            <input type="search" @input="filterArray($event)" placeholder="Search..." class="form-control">
        </div>
        <div class="col-md-9 text-right">
            <a v-if="purchases.length > 0" style="display:none;" :style="{display: purchases.length > 0 ? '' : 'none'}" href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
    </div>
    <div class="row" v-if="purchases.length > 0 && showReport" style="display:none;" :style="{display: purchases.length > 0 && showReport ? '' : 'none'}">
        <div class="col-md-12">
            <div class="table-responsive" id="reportTable">
                <table class="table table-bordered record-table table-condensed" v-if="filter.searchType != 'quantity' && filter.recordType == 'with'" style="display:none;" :style="{display: filter.searchType != 'quantity' && filter.recordType == 'with'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Invoice No.</th>
                            <th>Date</th>
                            <th>Supplier Name</th>
                            <th>Material Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th style="text-align: right;">Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(purchase, index) in purchases">
                            <tr>
                                <td>@{{ index + 1 }}</td>
                                <td>@{{ purchase.invoice }}</td>
                                <td>@{{ purchase.date | dateFormat("DD-MM-YYYY") }}</td>
                                <td>@{{purchase.supplier.name }}</td>
                                <td>@{{ purchase.material_purchase_details[0].material.name }}</td>
                                <td style="text-align:center;">@{{ purchase.material_purchase_details[0].price | decimal }}</td>
                                <td style="text-align:center;">@{{ purchase.material_purchase_details[0].quantity | decimal }}</td>
                                <td style="text-align:right;">@{{ purchase.material_purchase_details[0].total | decimal }}</td>
                                <td style="text-align:center;">
                                    <a href="" title="Order Invoice" v-bind:href="`/material-purchase-invoice-print/${purchase.id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                    @if(userAction('u'))
                                    <a href="" title="Edit Order" @click.prevent="purchaseEdit(purchase)"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if(userAction('d'))
                                    <a href="" title="Delete Order" @click.prevent="deletePurchase(purchase)"><i class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                            <tr v-for="(item, sl) in purchase.material_purchase_details.slice(1)">
                                <td colspan="4" :rowspan="purchase.material_purchase_details.length - 1" v-if="sl == 0"></td>
                                <td>@{{ item.material.name }}</td>
                                <td style="text-align:center;">@{{ item.price | decimal }}</td>
                                <td style="text-align:center;">@{{ item.quantity | decimal }}</td>
                                <td style="text-align:right;">@{{ item.total | decimal }}</td>
                                <td></td>
                            </tr>
                            <tr style="font-weight:bold;">
                                <td colspan="6" style="font-weight:normal;text-align:left;"><strong>Note: </strong>@{{ purchase.note }}</td>
                                <td style="text-align:center;">Total Quantity<br>@{{ purchase.material_purchase_details.reduce((prev, curr) => {return prev + parseFloat(curr.quantity)}, 0) | decimal }}</td>
                                <td style="text-align:right;">
                                    Total: @{{ purchase.total | decimal }}<br>
                                    Paid: @{{ purchase.paid | decimal }}<br>
                                    Due: @{{ purchase.due | decimal }}
                                </td>
                                <td></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <table class="table table-bordered record-table table-condensed" v-if="filter.searchType != 'quantity' && filter.recordType == 'without'" style="display:none;" :style="{display: filter.searchType != 'quantity' && filter.recordType == 'without'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Inv No.</th>
                            <th>Date</th>
                            <th>Supplier Name</th>
                            <th>Sub Total</th>
                            <th>VAT</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(purchase, index) in purchases">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ purchase.invoice }}</td>
                            <td>@{{ purchase.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ purchase.supplier.name }}</td>
                            <td style="text-align:right;">@{{ purchase.subtotal | decimal }}</td>
                            <td style="text-align:right;">@{{ purchase.vat | decimal }}</td>
                            <td style="text-align:right;">@{{ purchase.discount | decimal }}</td>
                            <td style="text-align:right;">@{{ purchase.total | decimal }}</td>
                            <td style="text-align:right;">@{{ purchase.paid | decimal }}</td>
                            <td style="text-align:right;">@{{ purchase.due | decimal }}</td>
                            <td style="text-align:left;">@{{ purchase.note }}</td>
                            <td style="text-align:center;">
                                <a href="" title="Order Invoice" v-bind:href="`/material-purchase-invoice-print/${purchase.id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                @if(userAction('u'))
                                <a href="" title="Edit Order" @click.prevent="purchaseEdit(purchase)"><i class="fa fa-edit"></i></a>
                                @endif
                                @if(userAction('d'))
                                <a href="" title="Delete Order" @click.prevent="deletePurchase(purchase)"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="4" style="text-align:right;">Total</td>
                            <td style="text-align:right;">@{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.subtotal)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.vat)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.discount)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.total)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.paid)}, 0) | decimal }}</td>
                            <td style="text-align:right;">@{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.due)}, 0) | decimal }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>

                </table>
                <table class="table table-bordered record-table table-condensed" v-if="filter.searchType == 'quantity'" style="display:none;" :style="{display: filter.searchType == 'quantity'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Invoice No.</th>
                            <th>Date</th>
                            <th>Supplier Name</th>
                            <th>Material Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(purchase, index) in purchases">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ purchase.invoice }}</td>
                            <td>@{{ purchase.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ purchase.supplier_name }}</td>
                            <td>@{{ purchase.name }}</td>
                            <td style="text-align:right;">@{{ purchase.price }}</td>
                            <td style="text-align:right;">@{{ purchase.quantity }}</td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="6" style="text-align:right;">Total Quantity</td>
                            <td style="text-align:right;">@{{ purchases.reduce((prev, curr) => { return prev + parseFloat(curr.quantity)}, 0) }}</td>
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
        el: '#purchaseList',
        data() {
            return {
                filter: {
                    searchType: "",
                    recordType: "without",
                    status: 'a',
                    dateFrom: moment().format("YYYY-MM-DD"),
                    dateTo: moment().format("YYYY-MM-DD"),
                },
                purchases: [],
                purchases2: [],

                suppliers: [],
                selectedSupplier: null,
                employees: [],
                selectedEmployee: null,
                materials: [],
                selectedMaterial: null,
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
            async purchaseEdit(row) {
                location.href = "/materialPurchase/" + row.id
            },

            getUser() {
                axios.post("/get-user")
                    .then(res => {
                        this.users = res.data.users;
                    })
            },

            getMaterial() {
                axios.get("/get-material")
                    .then(res => {
                        this.materials = res.data;
                    })
            },

            getSupplier() {
                axios.get("/get-supplier")
                    .then(res => {
                        let r = res.data;
                        this.suppliers = r.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code}`
                            return item;
                        });
                    })
            },

            getEmployee() {
                axios.get('/get-employee')
                .then(res => {
                    this.employees = res.data;
                })
            },

            onChangeType(event) {
                this.purchases = [];
                this.purchases2 = [];
                this.selectedSupplier = null;
                this.selectedMaterial = null;
                this.selectedUser = null;
                this.filter.supplierId = "";
                this.filter.materialId = "";
                this.filter.userId = "";
                if (event.target.value == 'supplier') {
                    this.getSupplier();
                } else if(event.target.value == 'employee') {
                    this.getEmployee();
                } else if (event.target.value == 'quantity') {
                    this.getMaterial();
                } else if (event.target.value == 'user') {
                    this.getUser();
                }
            },
            
            getPurchase() {
                if (this.filter.searchType == 'supplier') {
                    this.filter.supplierId = this.selectedSupplier != null ? this.selectedSupplier.id : ""
                }
                if (this.filter.searchType == 'employee') {
                    this.filter.employeeId = this.selectedEmployee != null ? this.selectedEmployee.id : ""
                }
                if (this.filter.searchType == 'quantity') {
                    var url = '/get-material-purchase-details';
                    this.filter.materialId = this.selectedMaterial != null ? this.selectedMaterial.id : ""
                } else {
                    var url = "/get-material-purchase";
                    this.filter.userId = this.selectedUser != null ? this.selectedUser.id : ""
                }
                this.onProgress = true
                this.showReport = false
                axios.post(url, this.filter)
                    .then(res => {
                        let purchases = res.data;
                        this.purchases = purchases;
                        this.purchases2 = this.purchases
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

            async deletePurchase(row) {
                let formdata = {
                    id: row.id
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-material-purchase", formdata)
                        .then(res => {
                            toastr.success(res.data.message)
                            this.getPurchase();
                        })
                        .catch(err => {
                            var r = JSON.parse(err.request.response);
                            if (r.errors != undefined) {
                                console.log(r.errors);
                            }
                            toastr.error(r.message);
                        })
                }
            },

            //search method here
            async onSearchSupplier(val, loading) {
                if (val.length > 2) {
                    loading(true)
                    await axios.post("/get-supplier", {
                            name: val
                        })
                        .then(res => {
                            let r = res.data;
                            this.suppliers = r.map((item, index) => {
                                item.display_name = `${item.name} - ${item.code}`
                                return item;
                            });
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getSupplier();
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

                let supplierText = '';
                if (this.selectedSupplier != null && this.selectedSupplier.id != '' && this.filter.searchType == 'supplier') {
                    supplierText = `<strong>Supplier: </strong> ${this.selectedSupplier.name}<br>`;
                }

                let materialText = '';
                if (this.selectedMaterial != null && this.selectedMaterial.id != '' && this.filter.searchType == 'quantity') {
                    materialText = `<strong>Material: </strong> ${this.selectedMaterial.name}`;
                }

                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">purchases Record</h4 style="text-align:center">
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-6">
								${userText} ${supplierText} ${materialText} 
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

                if (this.filter.searchType != 'quantity') {
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

            // filter purchaserecord
            filterArray(event) {
                this.purchases = this.purchases2.filter(purchase => {
                    return purchase.invoice.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
                        purchase.date.toLowerCase().startsWith(event.target.value.toLowerCase());
                })
            },
        },
    })
</script>
@endpush