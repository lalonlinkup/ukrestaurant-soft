@extends('master')
@section('title')
{{$id != 0 ? 'Material Purchase Update' : 'Material Purchase Entry'}}
@endsection
@section('breadcrumb_title')
{{$id != 0 ? 'Material Purchase Update' : 'Material Purchase Entry'}}
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
                    <legend class="scheduler-border">Material Information</legend>
                    <div class="control-group">
                        <form @submit.prevent="addToCart">
                            <div class="form-group">
                                <label class="col-xs-4 control-label" style="padding-left: 0;"> Material </label>
                                <div class="col-xs-8" style="display: flex;align-items:center;margin-bottom:4px;">
                                    <div style="width: 89%;">
                                        <v-select v-bind:options="materials" style="margin: 0;" id="material" v-model="selectedMaterial" label="name" @input="onChangeMaterial" @search="onSearchMaterial"></v-select>
                                    </div>
                                    <div style="width: 11%;margin-left:2px;">
                                        <a href="/material" title="Add New Material" class="btn btn-xs btn-danger" style="width: 100%;height: 23px;border: 0px;border-radius: 3px;" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-4 col-md-4 control-label" style="padding-left: 0;" for="price"> Price </label>
                                <div class="col-xs-3 col-md-4" style="padding-right: 0;">
                                    <input type="number" step="0.001" min="0" id="price" name="price" class="form-control" v-model="selectedMaterial.price" @input="materialTotal" required />
                                </div>

                                <label class="col-xs-1 control-label" style="padding-right: 0;"> Qty </label>
                                <div class="col-xs-4 col-md-3">
                                    <input type="number" step="0.001" min="0" id="quantity" name="quantity" class="form-control" v-model="selectedMaterial.quantity" @input="materialTotal" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-4 control-label" style="padding-left: 0;"> Note </label>
                                <div class="col-xs-8">
                                    <input type="text" id="note" name="note" class="form-control" v-model="selectedMaterial.note" placeholder="Note..."/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-4 control-label" style="padding-left: 0;"> Amount </label>
                                <div class="col-xs-8">
                                    <input type="text" id="materialTotal" class="form-control" readonly v-model="selectedMaterial.total" />
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
                                <th style="width:25%;">Material Name</th>
                                <th style="width:13%;">Brand</th>
                                <th style="width:12%;">Price</th>
                                <th style="width:10%;">Quantity</th>
                                <th style="width:15%;">Total</th>
                                <th style="width:10%;">Note</th>
                                <th style="width:20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-of-cyan" style="display:none;" v-bind:style="{display: carts.length > 0 ? '' : 'none'}">
                            <tr v-for="(material, sl) in carts">
                                <td>@{{ sl + 1}}</td>
                                <td>@{{ material.name }}</td>
                                <td>@{{ material.unitName }}</td>
                                <td>
                                    <input type="number" style="margin: 0;" step="0.001" min="0" @input="editQtyPrice(material)" class="form-control" v-model="material.price">
                                </td>
                                <td>
                                    <input type="number" style="margin: 0;" step="0.01" min="0" :disabled="purchase.id != 0" @input="editQtyPrice(material)" class="form-control" v-model="material.quantity">
                                </td>
                                <td>@{{ material.total }}</td>
                                <td>@{{ material.note }}</td>
                                <td>
                                    <a v-if="purchase.id == 0" href="" @click.prevent="editCart(material)"><i class="fa fa-edit"></i></a>
                                    <a href="" @click.prevent="removeCart(material)"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="8"></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td colspan="4">Description</td>
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
                                                <input type="number" step="0.001" id="subtotal" name="subtotal" class="form-control" v-model="purchase.subtotal" readonly />
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
                    subtotal: 0,
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

                materials: [],
                selectedMaterial: {
                    id: "",
                    name: "",
                    price: 0,
                    quantity: 0,
                    note: "",
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
            this.getMaterial();
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
            getMaterial() {
                axios.post("/get-material", {
                        forSearch: 'yes'
                    })
                    .then(res => {
                        this.materials = res.data;
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
            async onSearchMaterial(val, loading) {
                if (val.length > 2) {
                    loading(true);
                    await axios.post("/get-material", {
                            name: val,
                        })
                        .then(res => {
                            let r = res.data;
                            this.materials = r.filter(item => item.is_active == true).map((item, index) => {
                                item.display_name = `${item.name} - ${item.code}`
                                return item;
                            });
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getMaterial();
                }
            },
            onChangeMaterial() {
                if (this.selectedMaterial == null) {
                    this.selectedMaterial = {
                        id: "",
                        name: "",
                        price: 0,
                        quantity: 0,
                        note: ""
                    }
                    return
                }
                if (this.selectedMaterial.id != "") {
                    document.querySelector("#quantity").focus();
                }
            },
            materialTotal() {
                if (event.target.id == 'discount') {
                    this.selectedMaterial.discountAmount = parseFloat((parseFloat(this.selectedMaterial.price) * parseFloat(this.selectedMaterial.discount)) / 100).toFixed(this.fixed);
                }
                if (event.target.id == 'discountAmount') {
                    this.selectedMaterial.discount = parseFloat((parseFloat(this.selectedMaterial.discountAmount) * 100) / parseFloat(this.selectedMaterial.price)).toFixed(this.fixed);
                }
                let total = parseFloat(this.selectedMaterial.quantity) * parseFloat(this.selectedMaterial.price);
                let discountTotal = this.selectedMaterial.discountAmount == undefined ? 0 : parseFloat(this.selectedMaterial.discountAmount) * this.selectedMaterial.quantity;
                this.selectedMaterial.total = parseFloat(total - discountTotal).toFixed(this.fixed);
                if (this.isDiscount == 'true') {
                    document.querySelector("#discountTotal").value = parseFloat(discountTotal).toFixed(this.fixed);
                }
            },
            addToCart() {
                if (this.selectedMaterial.id == '') {
                    toastr.error("Material name is required")
                    document.querySelector("#material [type='search']").focus();
                    return
                }
                if (this.selectedMaterial.quantity == '') {
                    document.querySelector("#quantity").focus();
                    return
                }
                if (this.selectedMaterial.price == '') {
                    document.querySelector("#price").focus();
                    return
                }
                let material = {
                    material_id: this.selectedMaterial.id,
                    name: this.selectedMaterial.name,
                    unitName: this.selectedMaterial.unit_name,
                    quantity: this.selectedMaterial.quantity,
                    note: this.selectedMaterial.note ?? 'n/a',
                    price: parseFloat(this.selectedMaterial.price).toFixed(this.fixed),
                    total: this.selectedMaterial.total
                }
                let cartIndex = this.carts.findIndex(cart => cart.material_id == material.material_id)
                if (cartIndex > -1) {
                    let oldqty = this.carts[cartIndex].quantity;
                    material.quantity = parseFloat(oldqty) + +parseFloat(material.quantity);
                    material.total = parseFloat(material.price * material.quantity).toFixed(this.fixed);
                    this.carts.splice(cartIndex, 1)
                }
                this.carts.unshift(material)
                this.clearMaterial();
                if (this.purchase.id != 0) {
                    this.addToCartNew = 'yes';
                }
                this.calculateTotal();
                // document.querySelector("#material [type='search']").focus();
            },
            async editQtyPrice(material) {
                material.total = parseFloat(material.quantity * material.price).toFixed(this.fixed)
                this.calculateTotal();
            },
            editCart(material) {
                console.log(material);
                this.selectedMaterial = {
                    id: material.material_id,
                    name: material.name,
                    unit_name: material.unitName,
                    quantity: material.quantity,
                    note: material.note,
                    price: parseFloat(material.price).toFixed(this.fixed),
                    total: material.total
                }

            },
            async removeCart(material) {
                let findIndex = this.carts.findIndex(prod => prod.material == material.material);
                this.carts.splice(findIndex, 1);
                this.calculateTotal();
            },
            clearMaterial() {
                this.selectedMaterial = {
                    id: "",
                    name: "",
                    price: 0,
                    quantity: 0,
                    note: ""
                }

            },
            calculateTotal() {
                this.purchase.subtotal = parseFloat(this.carts.reduce((pre, cur) => {
                    return pre + parseFloat(cur.total)
                }, 0)).toFixed(this.fixed)

                if (event.target.id == 'purchaseDiscount') {
                    this.purchase.discountAmount = parseFloat((parseFloat(this.purchase.subtotal) * parseFloat(this.purchase.discount)) / 100).toFixed(this.fixed);
                }
                if (event.target.id == 'purchasediscountAmount') {
                    this.purchase.discount = parseFloat((parseFloat(this.purchase.discountAmount) * 100) / parseFloat(this.purchase.subtotal)).toFixed(this.fixed);
                }
                this.purchase.total = parseFloat(parseFloat(this.purchase.subtotal) - parseFloat(this.purchase.discountAmount)).toFixed(this.fixed)
                if (event.target.id == 'vat') {
                    this.purchase.vatAmount = parseFloat((parseFloat(this.purchase.total) * parseFloat(this.purchase.vat)) / 100).toFixed(this.fixed);
                }
                if (event.target.id == 'vatAmount') {
                    this.purchase.vat = parseFloat((parseFloat(this.purchase.vatAmount) * 100) / parseFloat(this.purchase.total)).toFixed(this.fixed);
                }
                this.purchase.total = parseFloat((parseFloat(this.purchase.subtotal) + +parseFloat(this.purchase.vatAmount) + +parseFloat(this.purchase.transport)) - parseFloat(this.purchase.discountAmount)).toFixed(this.fixed)

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
                    var url = '/add-material-purchase';
                } else {
                    var url = '/update-material-purchase';
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
                            let conf = confirm('Material Purchase success, Do you want to view invoice?');
                            if (conf) {
                                window.open('/material-purchase-invoice-print/' + r.id, '_blank');
                                await new Promise(r => setTimeout(r, 1000));
                                window.location = '/materialPurchase';
                            } else {
                                window.location = '/materialPurchase';
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
                    subtotal: 0,
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
                axios.post("/get-material-purchase", {
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

                        purchase.material_purchase_details.forEach(async detail => {
                            let material = {
                                material_id: detail.material_id,
                                name: detail.material ? detail.material.name : 'n/a',
                                unitName: detail.material.unit.name,
                                quantity: detail.quantity,
                                note: detail.note,
                                price: parseFloat(detail.price).toFixed(this.fixed),
                                total: detail.total
                            }
                            this.carts.push(material);
                        })

                        this.calculateTotal();
                    })
            },
        },
    })
</script>
@endpush