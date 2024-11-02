@extends('master')
@section('title')
{{$id != 0 ? 'Purchase Update' : 'Purchase Entry'}}
@endsection
@section('breadcrumb_title')
{{$id != 0 ? 'Purchase Update' : 'Purchase Entry'}}
@endsection
@push('style')
<style scoped>
    .v-select .dropdown-menu {
        width: 400px !important;
    }
    .v-select .selected-tag {
        margin: 8px 2px !important;
        white-space: nowrap;
        position: absolute;
        left: 0px;
        top: 0;
        line-height: 0px !important;
    }
</style>
@endpush
@section('content')
<div class="row" id="purchase">
    <div class="col-xs-12 col-md-12">
        <div class="widget-head-box bg-of-orange">
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-md-1 control-label no-padding-right"> Invoice no </label>
                    <div class="col-md-2 col-xs-8">
                        <input type="text" id="invoice" class="form-control" name="invoice" v-model="purchase.invoice" readonly />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-4 col-md-1 control-label no-padding-right"> Employee </label>
                    <div class="col-md-3 col-xs-8">
                        <v-select :options="employees" v-model="selectedEmployee" label="display_name"></v-select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-4 col-md-2 control-label no-padding-right"> Purchase Date </label>
                    <div class="col-md-3 col-xs-8">
                        <input class="form-control" id="date" name="date" type="date" v-model="purchase.date" {{Auth::user()->role == 'user' ? 'disabled' : ''}} />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-9">

        <div class="row">
            <div class="col-xs-12 col-md-6">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Supplier Information</legend>
                    <div class="control-group">
                        <div class="form-group">
                            <label class="col-xs-4 control-label" style="padding-left: 0;"> Supplier </label>
                            <div class="col-xs-8" style="display: flex;align-items:center;margin-bottom:4px;">
                                <div style="width: 89%;">
                                    <v-select v-bind:options="suppliers" style="margin: 0;" v-model="selectedSupplier" @search="onSearchSupplier" @input="onChangeSupplier" label="display_name"></v-select>
                                </div>
                                <div style="width: 11%;margin-left:2px;">
                                    <a href="/supplier" title="Add New Supplier" class="btn btn-xs btn-danger" style="width: 100%;height: 23px;border: 0px;border-radius: 3px;" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-4 control-label" style="padding-left: 0;"> Name </label>
                            <div class="col-xs-8">
                                <input type="text" placeholder="Supplier Name" class="form-control" v-model="selectedSupplier.name" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-4 control-label" style="padding-left: 0;"> Mobile No </label>
                            <div class="col-xs-8">
                                <input type="text" placeholder="Mobile No" class="form-control" v-model="selectedSupplier.phone" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-4 control-label" style="padding-left: 0;"> Address </label>
                            <div class="col-xs-8">
                                <textarea class="form-control" v-model="selectedSupplier.address" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="col-xs-12 col-md-6">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Asset Information</legend>
                    <div class="control-group">
                        <form @submit.prevent="addToCart">
                            <div class="form-group">
                                <label class="col-xs-4 control-label" style="padding-left: 0;"> Asset </label>
                                <div class="col-xs-8" style="display: flex;align-items:center;margin-bottom:4px;">
                                    <div style="width: 89%;">
                                        <v-select v-bind:options="assets" style="margin: 0;" id="asset" v-model="selectedAsset" label="display_name" @input="onChangeAsset" @search="onSearchAsset"></v-select>
                                    </div>
                                    <div style="width: 11%;margin-left:2px;">
                                        <a href="/asset" title="Add New Asset" class="btn btn-xs btn-danger" style="width: 100%;height: 23px;border: 0px;border-radius: 3px;" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-4 col-md-4 control-label" style="padding-left: 0;" for="price"> Price </label>
                                <div class="col-xs-3 col-md-4" style="padding-right: 0;">
                                    <input type="number" step="0.001" min="0" id="price" name="price" class="form-control" v-model="selectedAsset.price" @input="assetTotal" required />
                                </div>

                                <label class="col-xs-1 control-label" style="padding-right: 0;"> Qty </label>
                                <div class="col-xs-4 col-md-3">
                                    <input type="number" step="0.001" min="0" id="quantity" name="quantity" class="form-control" v-model="selectedAsset.quantity" @input="assetTotal" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-4 control-label" style="padding-left: 0;"> Warranty </label>
                                <div class="col-xs-8">
                                    <input type="number" step="any" min="0" id="warranty" name="warranty" class="form-control" v-model="selectedAsset.warranty" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-4 control-label" style="padding-left: 0;"> Amount </label>
                                <div class="col-xs-8">
                                    <input type="text" id="assetTotal" class="form-control" readonly v-model="selectedAsset.total" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-4 control-label no-padding-right"> </label>
                                <div class="col-xs-8">
                                    <button type="submit" class="add-cart-btn pull-right">Add Cart</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>

            <div class="col-xs-12 col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                        <thead>
                            <tr>
                                <th style="width:5%;">SL</th>
                                <th style="width:25%;">Asset Name</th>
                                <th style="width:13%;">Brand</th>
                                <th style="width:12%;">Price</th>
                                <th style="width:10%;">Quantity</th>
                                <th style="width:15%;">Total</th>
                                <th style="width:10%;">Warranty</th>
                                <th style="width:20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-of-cyan" style="display:none;" v-bind:style="{display: carts.length > 0 ? '' : 'none'}">
                            <tr v-for="(asset, sl) in carts">
                                <td>@{{ sl + 1}}</td>
                                <td>@{{ asset.name }}</td>
                                <td>@{{ asset.brandName }}</td>
                                <td>
                                    <input type="number" style="margin: 0;" step="0.001" min="0" @input="editQtyPrice(asset)" class="form-control" v-model="asset.price">
                                </td>
                                <td>
                                    <input type="number" style="margin: 0;" step="0.01" min="0" :disabled="purchase.id != 0" @input="editQtyPrice(asset)" class="form-control" v-model="asset.quantity">
                                </td>
                                <td>@{{ asset.total }}</td>
                                <td>@{{ asset.warranty }}</td>
                                <td>
                                    <a v-if="purchase.id == 0" href="" @click.prevent="editCart(asset)"><i class="fa fa-edit"></i></a>
                                    <a href="" @click.prevent="removeCart(asset)"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="8"></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td colspan="4">Note</td>
                                <td colspan="4">Total</td>
                            </tr>
                            <tr>
                                <td colspan="4"><textarea style="width: 100%;font-size:13px;" placeholder="Description" v-model="purchase.description"></textarea></td>
                                <td colspan="4" style="padding-top: 15px;font-size:18px;">@{{ purchase.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <div class="col-xs-12 col-md-3 col-lg-3">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Amount Details</legend>
            <div class="control-group">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-responsive">
                            <table style="color:#000;margin-bottom: 0px;">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="col-xs-12 control-label no-padding-right">SubTotal</label>
                                            <div class="col-xs-12">
                                                <input type="number" step="0.001" id="sub_total" name="sub_total" class="form-control" v-model="purchase.sub_total" readonly />
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="col-xs-12 control-label no-padding-right"> Discount </label>
                                            <div class="col-xs-6" style="display:flex;align-items:center;">
                                                <input type="number" step="0.001" min="0" class="form-control" id="purchaseDiscount" name="discount" v-model="purchase.discount" @input="calculateTotal($event)" />
                                                <label>%</label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="number" step="0.001" min="0" class="form-control" id="purchasediscountAmount" name="discountAmount" v-model="purchase.discountAmount" @input="calculateTotal($event)" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="col-xs-12 control-label no-padding-right"> Vat </label>
                                            <div class="col-xs-6" style="display:flex;align-items:center;">
                                                <input type="number" step="0.001" min="0" class="form-control" id="vat" name="vat" v-model="purchase.vat" @input="calculateTotal($event)" />
                                                <label>%</label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="number" step="0.001" min="0" class="form-control" id="vatAmount" name="vatAmount" v-model="purchase.vatAmount" @input="calculateTotal($event)" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="col-xs-12 control-label no-padding-right">Transport / Labour Cost</label>
                                            <div class="col-xs-12">
                                                <input type="number" step="0.001" min="0" id="transport" name="transport" class="form-control" v-model="purchase.transport" @input="calculateTotal($event)" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="col-xs-12 control-label no-padding-right">Total</label>
                                            <div class="col-xs-12">
                                                <input type="number" step="0.001" id="total" class="form-control" v-model="purchase.total" readonly />
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="col-xs-12 control-label no-padding-right">Paid</label>
                                            <div class="col-xs-12">
                                                <input type="number" step="0.001" min="0" id="paid" class="form-control" v-model="purchase.paid" @input="calculateTotal($event)" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="col-xs-6 control-label no-padding-right">Due</label>
                                            <label class="col-xs-6 control-label no-padding-right">Previous Due</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="col-xs-6">
                                                <input type="number" step="0.001" id="due" name="due" class="form-control" v-model="purchase.due" readonly />
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="number" step="0.001" id="previous_due" name="previous_due" class="form-control" v-model="purchase.previous_due" readonly style="color:red;" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                @if(userAction('u') || userAction('e'))
                                <tr>
                                    <td>
                                        <div class="form-group mt-1">
                                            <div class="col-xs-6">
                                                <input type="button" class="btn btn-success" value="Purchase" @click="savePurchase" :disabled="onProgress ? true : false" style="background:#000;color:#fff;padding:3px;width:100%;">
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="button" class="btn btn-info" onclick="window.location = '/purchase'" value="New Purch.." style="background:#000;color:#fff;padding:3px;width:100%;">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#purchase',
        data() {
            return {
                purchase: {
                    id: "{{$id}}",
                    invoice: "{{$invoice}}",
                    date: moment().format("YYYY-MM-DD"),
                    employee_id: null,
                    supplier_id: null,
                    sub_total: 0,
                    discount: 0,
                    discountAmount: 0,
                    vat: 0,
                    vatAmount: 0,
                    transport: 0,
                    total: 0,
                    paid: 0,
                    due: 0,
                    previous_due: 0,
                    description: "",
                },
                carts: [],
                suppliers: [],
                selectedSupplier: {
                    id: "",
                    name: "Select Supplier",
                    phone: "",
                    address: "",
                    display_name: "Select Supplier"
                },

                assets: [],
                selectedAsset: {
                    id: "",
                    name: "",
                    display_name: "",
                    price: 0,
                    quantity: 0,
                    warranty: 0,
                },

                employees: [],
                selectedEmployee: null,

                onProgress: false,
                fixed: 2,
                oldPreviousDue: 0,
                addToCartNew: '',
            }
        },
        filters: {
            decimal(value) {
                let fixed = 2;
                return value == null ? parseFloat(0).toFixed(fixed) : parseFloat(value).toFixed(fixed);
            }
        },

        created() {
            this.getAsset();
            this.getSupplier();
            this.getEmployee();
            if (this.purchase.id != 0) {
                this.getPurchase();
            }
        },

        methods: {
            getEmployee() {
                axios.get("/get-employee")
                    .then(res => {
                        this.employees = res.data.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code}`
                            return item;
                        })
                    })
            },
            getSupplier() {
                let filter = {
                    forSearch: 'yes'
                }
                axios.post("/get-supplier", filter)
                    .then(res => {
                        let r = res.data;
                        this.suppliers = r.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code} - ${item.phone}`
                            return item;
                        });
                    })
            },
            getAsset() {
                axios.post("/get-asset", {
                        forSearch: 'yes'
                    })
                    .then(res => {
                        let r = res.data;
                        this.assets = r.filter(item => item.is_active == true).map((item, index) => {
                            item.display_name = `${item.name} - ${item.code}`
                            return item;
                        });
                    })
            },
            async onSearchSupplier(val, loading) {
                if (val.length > 2) {
                    loading(true)
                    await axios.post("/get-supplier", {
                            name: val
                        })
                        .then(res => {
                            let r = res.data.data;
                            this.suppliers = r.suppliers.map((item, index) => {
                                item.display_name = `${item.name} - ${item.code} - ${item.phone}`
                                return item;
                            });
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getSupplier();
                }
            },
            async onChangeSupplier() {
                if (this.selectedSupplier == null) {
                    this.selectedSupplier = {
                        id: "",
                        name: "",
                        phone: "",
                        address: "",
                        display_name: ""
                    }
                    return
                }
                if (this.selectedSupplier.id != "") {
                    let due = await axios.post('/get-supplier-due', {
                        supplierId: this.selectedSupplier.id
                    }).then(res => {
                        return res.data[0].due;
                    })
                    this.purchase.previous_due = parseFloat(due).toFixed(this.fixed);

                    this.calculateTotal();
                } else {
                    this.purchase.previous_due = 0;
                }
            },
            async onSearchAsset(val, loading) {
                if (val.length > 2) {
                    loading(true);
                    await axios.post("/get-asset", {
                            name: val,
                        })
                        .then(res => {
                            let r = res.data;
                            this.assets = r.filter(item => item.is_active == true).map((item, index) => {
                                item.display_name = `${item.name} - ${item.code}`
                                return item;
                            });
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getAsset();
                }
            },
            onChangeAsset() {
                if (this.selectedAsset == null) {
                    this.selectedAsset = {
                        id: "",
                        name: "",
                        display_name: "",
                        price: 0,
                        quantity: 0,
                        warranty: 0
                    }
                    return
                }
                if (this.selectedAsset.id != "") {
                    document.querySelector("#quantity").focus();
                }
            },
            assetTotal() {
                if (event.target.id == 'discount') {
                    this.selectedAsset.discountAmount = parseFloat((parseFloat(this.selectedAsset.price) * parseFloat(this.selectedAsset.discount)) / 100).toFixed(this.fixed);
                }
                if (event.target.id == 'discountAmount') {
                    this.selectedAsset.discount = parseFloat((parseFloat(this.selectedAsset.discountAmount) * 100) / parseFloat(this.selectedAsset.price)).toFixed(this.fixed);
                }
                let total = parseFloat(this.selectedAsset.quantity) * parseFloat(this.selectedAsset.price);
                let discountTotal = this.selectedAsset.discountAmount == undefined ? 0 : parseFloat(this.selectedAsset.discountAmount) * this.selectedAsset.quantity;
                this.selectedAsset.total = parseFloat(total - discountTotal).toFixed(this.fixed);
                if (this.isDiscount == 'true') {
                    document.querySelector("#discountTotal").value = parseFloat(discountTotal).toFixed(this.fixed);
                }
            },
            addToCart() {
                if (this.selectedAsset.id == '') {
                    toastr.error("Asset name is required")
                    document.querySelector("#asset [type='search']").focus();
                    return
                }
                if (this.selectedAsset.quantity == '') {
                    document.querySelector("#quantity").focus();
                    return
                }
                if (this.selectedAsset.price == '') {
                    document.querySelector("#price").focus();
                    return
                }
                let asset = {
                    asset_id: this.selectedAsset.id,
                    code: this.selectedAsset.code,
                    name: this.selectedAsset.name,
                    brandName: this.selectedAsset.brand_name,
                    quantity: this.selectedAsset.quantity,
                    warranty: this.selectedAsset.warranty ?? 0,
                    price: parseFloat(this.selectedAsset.price).toFixed(this.fixed),
                    total: this.selectedAsset.total
                }
                let cartIndex = this.carts.findIndex(cart => cart.asset_id == asset.asset_id)
                if (cartIndex > -1) {
                    let oldqty = this.carts[cartIndex].quantity;
                    asset.quantity = parseFloat(oldqty) + +parseFloat(asset.quantity);
                    asset.total = parseFloat(asset.price * asset.quantity).toFixed(this.fixed);
                    this.carts.splice(cartIndex, 1)
                }
                this.carts.unshift(asset)
                this.clearAsset();
                if (this.purchase.id != 0) {
                    this.addToCartNew = 'yes';
                }
                this.calculateTotal();
                // document.querySelector("#asset [type='search']").focus();
            },
            async editQtyPrice(asset) {
                asset.total = parseFloat(asset.quantity * asset.price).toFixed(this.fixed)
                this.calculateTotal();
            },
            editCart(asset) {
                console.log(asset);
                this.selectedAsset = {
                    id: asset.asset_id,
                    code: asset.code,
                    name: asset.name,
                    display_name: `${asset.name} - ${asset.code}`,
                    brand_name: asset.brandName,
                    quantity: asset.quantity,
                    warranty: asset.warranty,
                    price: parseFloat(asset.price).toFixed(this.fixed),
                    total: asset.total
                }

            },
            async removeCart(asset) {
                var assetStock = await axios.post('/current-stock', {
                        assetId: asset.asset_id
                    })
                    .then(res => {
                        return res.data.current_quantity;
                    })
                if (parseFloat(assetStock) < parseFloat(asset.quantity) && this.purchase.id != 0) {
                    toastr.error("Stock Unavailable! You can not delete asset");
                    return;
                }
                let findIndex = this.carts.findIndex(prod => prod.asset == asset.asset);
                this.carts.splice(findIndex, 1);
                this.calculateTotal();
            },
            clearAsset() {
                this.selectedAsset = {
                    id: "",
                    name: "",
                    display_name: "",
                    price: "",
                }

            },
            calculateTotal() {
                this.purchase.sub_total = parseFloat(this.carts.reduce((pre, cur) => {
                    return pre + parseFloat(cur.total)
                }, 0)).toFixed(this.fixed)

                if (event.target.id == 'purchaseDiscount') {
                    this.purchase.discountAmount = parseFloat((parseFloat(this.purchase.sub_total) * parseFloat(this.purchase.discount)) / 100).toFixed(this.fixed);
                }
                if (event.target.id == 'purchasediscountAmount') {
                    this.purchase.discount = parseFloat((parseFloat(this.purchase.discountAmount) * 100) / parseFloat(this.purchase.sub_total)).toFixed(this.fixed);
                }
                this.purchase.total = parseFloat(parseFloat(this.purchase.sub_total) - parseFloat(this.purchase.discountAmount)).toFixed(this.fixed)
                if (event.target.id == 'vat') {
                    this.purchase.vatAmount = parseFloat((parseFloat(this.purchase.total) * parseFloat(this.purchase.vat)) / 100).toFixed(this.fixed);
                }
                if (event.target.id == 'vatAmount') {
                    this.purchase.vat = parseFloat((parseFloat(this.purchase.vatAmount) * 100) / parseFloat(this.purchase.total)).toFixed(this.fixed);
                }
                this.purchase.total = parseFloat((parseFloat(this.purchase.sub_total) + +parseFloat(this.purchase.vatAmount) + +parseFloat(this.purchase.transport)) - parseFloat(this.purchase.discountAmount)).toFixed(this.fixed)

                if (event.target.id == 'paid') {
                    this.purchase.due = parseFloat(parseFloat(this.purchase.total) - parseFloat(this.purchase.paid)).toFixed(this.fixed);
                } else {
                    if (this.purchase.id == 0) {
                        this.purchase.due = 0
                        this.purchase.paid = this.purchase.total
                    } else {
                        if (this.purchase.id != 0 && this.selectedSupplier.previous_due == undefined) {
                            this.purchase.previous_due = this.oldPreviousDue;
                        }
                        if (this.addToCartNew != '') {
                            this.purchase.due = 0
                            this.purchase.paid = this.purchase.total
                        }
                    }

                }
            },
            async savePurchase() {
                this.purchase.employee_id = this.selectedEmployee != null ? this.selectedEmployee.id : "";
                this.purchase.supplier_id = this.selectedSupplier.id != "" ? this.selectedSupplier.id : "";
                if (this.purchase.id == 0) {
                    var url = '/add-purchase';
                } else {
                    var url = '/update-purchase';
                }
                let data = {
                    purchase: this.purchase,
                    carts: this.carts
                }
                this.onProgress = true
                await axios.post(url, data)
                    .then(async res => {
                        let r = res.data;
                        toastr.success(r.message);
                        this.clearForm();
                        this.onProgress = false
                        if (r.status) {
                            let conf = confirm('Purchase success, Do you want to view invoice?');
                            if (conf) {
                                window.open('/purchase-invoice-print/' + r.id, '_blank');
                                await new Promise(r => setTimeout(r, 1000));
                                window.location = '/purchase';
                            } else {
                                window.location = '/purchase';
                            }
                        }
                    })
                    .catch(err => {
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

            clearForm() {
                this.purchase = {
                    id: "{{$id}}",
                    invoice: "{{$invoice}}",
                    date: moment().format("YYYY-MM-DD"),
                    sub_total: 0,
                    discount: 0,
                    discountAmount: 0,
                    vat: 0,
                    vatAmount: 0,
                    transport: 0,
                    total: 0,
                    paid: 0,
                    due: 0,
                    previous_due: 0,
                    description: "",
                    employee_id: ""
                }
                this.carts = [];
                this.selectedSupplier = {
                    id: "",
                    name: "Select Supplier",
                    phone: "",
                    address: "",
                    display_name: "Select Supplier"
                }
                this.selectedEmployee = null;
            },

            getPurchase() {
                axios.post("/get-purchase", {
                        id: this.purchase.id
                    })
                    .then(res => {
                        let purchase = res.data[0];
                        let keys = Object.keys(this.purchase);
                        keys.forEach(key => {
                            this.purchase[key] = purchase[key];
                        });

                        this.oldPreviousDue = purchase.previous_due;

                        this.selectedSupplier = {
                            id: purchase.supplier_id,
                            name: purchase.supplier ? purchase.supplier.name : 'n/a',
                            phone: purchase.supplier ? purchase.supplier.phone : 'n/a',
                            address: purchase.supplier ? purchase.supplier.address : 'n/a',
                            display_name: `${purchase.supplier ? purchase.supplier.code : 'n/a'} - ${purchase.supplier ? purchase.supplier.name : 'n/a'} - ${purchase.supplier ? purchase.supplier.phone : 'n/a'}`
                        }
                        
                        if(purchase.employee_id != null) {
                            this.selectedEmployee = {
                                id: purchase.employee_id,
                                name: purchase.employee != null ? purchase.employee.name : "",
                                display_name: purchase.employee != null ? `${purchase.employee.code}-${purchase.employee.name}` : ""
                            }
                        }

                        purchase.purchase_details.forEach(async detail => {
                            let asset = {
                                asset_id: detail.asset_id,
                                code: detail.asset ? detail.asset.code : 'n/a',
                                name: detail.asset ? detail.asset.name : 'n/a',
                                brandName: detail.asset.brand.name,
                                quantity: detail.quantity,
                                warranty: detail.warranty,
                                price: parseFloat(detail.price).toFixed(this.fixed),
                                total: detail.total
                            }
                            this.carts.push(asset);
                        })

                        this.calculateTotal();
                    })
            },
        },
    })
</script>
@endpush