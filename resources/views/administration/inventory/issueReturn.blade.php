@extends('master')
@section('title', 'Issue Return')
@section('breadcrumb_title', 'Issue Return')
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
    <div class="row" id="issueReturn">
        <div class="col-xs-12 col-md-12">
            <div class="row">
                <div class="col-xs-12 col-md-5">
                    <fieldset class="scheduler-border bg-of-skyblue" style="height: 115px;">
                        <legend class="scheduler-border">Table Information</legend>
                        <div class="control-group">
                            <div class="form-group">
                                <label class="col-xs-3 control-label" style="padding-left: 0;"> Issue To </label>
                                <div class="col-xs-9">
                                    <input type="date" class="form-control" v-model="issueReturn.date" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label" style="padding-left: 0;"> Select Table </label>
                                <div class="col-xs-9" style="display: flex;align-items:center;margin-bottom:4px;">
                                    <div style="width: 89%;">
                                        <v-select v-bind:options="tables" style="margin: 0;" v-model="selectedTable"
                                            @input="onChangeTable" @search="onSearchTable" label="display_name"></v-select>
                                    </div>
                                    <div style="width: 11%;margin-left:2px;">
                                        <a href="/table" title="Add New Table" class="btn btn-xs btn-danger"
                                            style="width: 100%;height: 23px;border: 0px;border-radius: 3px;"
                                            target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label" style="padding-left: 0;"> Table Name </label>
                                <div class="col-xs-9">
                                    <input type="text" placeholder="Table Name" class="form-control"
                                        v-model="selectedTable.name" disabled />
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="col-xs-12 col-md-7">
                    <fieldset class="scheduler-border bg-of-skyblue" style="height: 115px;">
                        <legend class="scheduler-border">Asset Information</legend>
                        <div class="control-group">
                            <form @submit.prevent="addToCart">
                                <div class="form-group">
                                    <label class="col-xs-1 control-label" style="padding-left: 0;"> Asset </label>
                                    <div class="col-xs-6" style="display: flex;align-items:center;margin-bottom:4px;">
                                        <div style="width: 89%;">
                                            <v-select v-bind:options="assets" style="margin: 0;" id="asset"
                                                v-model="selectedAsset" label="display_name" @input="onChangeAsset"
                                                @search="onSearchAsset"></v-select>
                                        </div>
                                        <div style="width: 11%;margin-left:2px;">
                                            <a href="/asset" title="Add New Asset" class="btn btn-xs btn-danger"
                                                style="width: 100%;height: 23px;border: 0px;border-radius: 3px;"
                                                target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                        </div>
                                    </div>

                                    <label class="col-xs-1 col-md-1 control-label" style="padding-left: 0;" for="price">
                                        Value </label>
                                    <div class="col-xs-5 col-md-4" style="padding-right: 0;">
                                        <input type="number" step="0.001" min="0" id="price" name="price"
                                            class="form-control" v-model="selectedAsset.price" readonly />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-1 col-md-1 control-label" style="padding-left: 0;" for="quantity">
                                        Quantity </label>
                                    <div class="col-xs-4 col-md-4" style="padding-right: 0;">
                                        <input type="number" step="0.001" min="0" id="quantity" name="quantity"
                                            class="form-control" v-model="selectedAsset.quantity" @input="assetTotal" />
                                    </div>
                                    <label class="col-xs-1 col-md-1 control-label" style="padding-right: 0;" for="quantity">
                                        status </label>
                                    <div class="col-xs-4 col-md-4" style="padding-right: 0;">
                                        <select name="disposal_status" id="disposal_status" class="form-control"
                                            v-model="selectedAsset.disposal_status">
                                            <option value="Regular Stock">Regular Stock</option>
                                            <option value="Out of order">Out of order</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-2 text-right">
                                        <button type="submit" class="">Add Cart</button>
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
                                    <th style="width:12%;">Brand</th>
                                    <th style="width:13%;">Price</th>
                                    <th style="width:10%;">Quantity</th>
                                    <th style="width:10%;">Status</th>
                                    <th style="width:15%;">Total</th>
                                    <th style="width:10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-of-cyan" style="display:none;"
                                v-bind:style="{display: carts.length > 0 ? '' : 'none'}">
                                <tr v-for="(asset, sl) in carts">
                                    <td>@{{ sl + 1 }}</td>
                                    <td>@{{ asset.name }}</td>
                                    <td>@{{ asset.brandName }}</td>
                                    <td>
                                        <input type="number" style="margin: 0;text-align:center;" step="0.001"
                                            min="0" @input="editQtyPrice(asset)" class="form-control"
                                            v-model="asset.price">
                                    </td>
                                    <td>
                                        <input type="number" style="margin: 0; text-align:center;" step="0.01"
                                            min="0" :disabled="issueReturn.id != 0" @input="editQtyPrice(asset)"
                                            class="form-control" v-model="asset.quantity">
                                    </td>
                                    <td>@{{ asset.disposal_status }}</td>
                                    <td>@{{ asset.total }}</td>
                                    <td>
                                        <a href="" @click.prevent="removeCart(asset)"><i
                                                class="fa fa-trash"></i></a>
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
                                    <td colspan="4">
                                        <textarea style="width: 100%;font-size:13px;" placeholder="Description" v-model="issueReturn.description"></textarea>
                                    </td>
                                    <td colspan="4" style="padding-top: 15px;font-size:18px;">@{{ issueReturn.total }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-success" value="Save"
                                            @click="saveIssueReturn" :disabled="onProgress ? true : false"
                                            style="background:#000;color:#fff;padding:3px;width:100%;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        new Vue({
            el: '#issueReturn',

            data() {
                return {
                    issueReturn: {
                        id: '',
                        table_id: null,
                        date: moment().format("YYYY-MM-DD"),
                        total: 0.00,
                        description: ''
                    },
                    tables: [],
                    selectedTable: {
                        id: "",
                        name: "Select Table",
                        code: "",
                        display_name: "Select Table"
                    },

                    assets: [],
                    selectedAsset: {
                        id: "",
                        name: "",
                        display_name: "",
                        price: 0,
                        quantity: 0,
                        disposal_status: 'Regular Stock'
                    },

                    carts: [],
                    onProgress: false,
                    fixed: 2
                }
            },

            filters: {
                decimal(value) {
                    let fixed = 2;
                    return value == null ? parseFloat(0).toFixed(fixed) : parseFloat(value).toFixed(fixed);
                }
            },

            created() {
                this.getTables();
            },

            methods: {
                getTables() {
                    let filter = {
                        forSearch: 'yes'
                    }
                    axios.post("/get-table", filter)
                        .then(res => {
                            let r = res.data;
                            this.tables = r.map((item, index) => {
                                item.display_name = `${item.code} - ${item.name}`
                                return item;
                            });
                        })
                },

                getAsset() {
                    axios.post("/get-asset-for-return", {
                            tableId: this.selectedTable.id
                        })
                        .then(res => {
                            this.assets = res.data.map((item, index) => {
                                item.display_name = `${item.code} - ${item.name}`
                                return item;
                            });
                        })
                },

                async onChangeTable() {
                    if (this.selectedTable.id == '') {
                        return;
                    }
                    await this.getAsset();
                },

                async onChangeAsset() {
                    if (this.selectedAsset == null) {
                        this.selectedAsset = {
                            id: "",
                            name: "",
                            display_name: "",
                            price: 0,
                            quantity: 0,
                            disposal_status: 'Regular Stock',
                        }
                        return;
                    }

                    if (this.selectedAsset.id != "") {
                        document.querySelector("#quantity").focus();
                    }
                },

                assetTotal() {
                    this.selectedAsset.quantity = this.selectedAsset.quantity == null || this.selectedAsset
                        .quantity == '' ? 0 : this.selectedAsset.quantity,
                        this.selectedAsset.total = (parseFloat(this.selectedAsset.quantity) * parseFloat(this
                            .selectedAsset.price)).toFixed(2);
                },

                addToCart() {
                    if (this.selectedAsset.id == '') {
                        toastr.error("Asset name is required")
                        document.querySelector("#asset [type='search']").focus();
                        return;
                    }
                    if (this.selectedAsset.quantity == '') {
                        document.querySelector("#quantity").focus();
                        return;
                    }

                    if (this.selectedAsset.disposal_status == undefined || this.selectedAsset.disposal_status == '') {
                        toastr.error("Status is required");
                        return;
                    }

                    let asset = {
                        asset_id: this.selectedAsset.id,
                        code: this.selectedAsset.code,
                        name: this.selectedAsset.name,
                        brandName: this.selectedAsset.brand_name,
                        quantity: this.selectedAsset.quantity,
                        price: parseFloat(this.selectedAsset.price).toFixed(this.fixed),
                        disposal_status: this.selectedAsset.disposal_status,
                        total: this.selectedAsset.total
                    }
                    let cartIndex = this.carts.findIndex(cart => cart.asset_id == asset.asset_id)
                    if (cartIndex > -1) {
                        let oldqty = this.carts[cartIndex].quantity;
                        asset.quantity = parseFloat(oldqty) + +parseFloat(asset.quantity);
                        asset.total = parseFloat(asset.price * asset.quantity).toFixed(this.fixed);
                        this.carts.splice(cartIndex, 1)
                    }
                    if (parseFloat(asset.quantity) > parseFloat(this.assetStock)) {
                        toastr.error("Stock Unavailable");
                        return;
                    }
                    this.carts.unshift(asset)
                    
                    this.clearAsset();
                    this.calculateTotal();
                    document.querySelector("#asset [type='search']").focus();
                },

                clearAsset() {
                    this.selectedAsset = {
                        id: "",
                        name: "",
                        display_name: "",
                        price: 0,
                        quantity: 0,
                        disposal_status: 'Regular Stock'
                    }
                    this.assetStock = "";
                    this.assetStockText = "";
                },

                async editQtyPrice(asset) {
                    asset.total = parseFloat(asset.quantity * asset.price).toFixed(this.fixed)
                    this.calculateTotal();
                },

                async removeCart(asset) {
                    let findIndex = this.carts.findIndex(prod => prod.asset == asset.asset);
                    this.carts.splice(findIndex, 1);
                    this.calculateTotal();
                },

                async onSearchTable(val, loading) {
                    if (val.length > 2) {
                        loading(true)
                        await axios.post("/get-table", {
                                name: val
                            })
                            .then(res => {
                                let r = res.data.data;
                                this.tables = r.tables.map((item, index) => {
                                    item.display_name = `${item.name} - ${item.code}`
                                    return item;
                                });
                                loading(false)
                            })
                    } else {
                        loading(false)
                        await this.getTables();
                    }
                },

                calculateTotal() {
                    this.issueReturn.total = this.carts.reduce((prev, curr) => {
                        return prev + parseFloat(curr.total)
                    }, 0).toFixed(2);
                },

                async onSearchAsset(val, loading) {
                    if (val.length > 2) {
                        loading(true);
                        await axios.post("/get-asset", {
                                name: val,
                            })
                            .then(res => {
                                let r = res.data;
                                this.assets = r.filter(item => item.is_active == true).map((item,
                                    index) => {
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

                async saveIssueReturn() {
                    this.issueReturn.table_id = this.selectedTable.id != "" ? this.selectedTable.id : "";
                    let data = {
                        issueReturn: this.issueReturn,
                        carts: this.carts
                    }
                    this.onProgress = true
                    await axios.post('/add-asset-return', data)
                        .then(async res => {
                            let r = res.data;
                            toastr.success(r.message);
                            this.clearForm();
                            this.onProgress = false
                            if (r.status) {
                                let conf = confirm(
                                'Issue Return success, Do you want to view invoice?');
                                if (conf) {
                                    window.open('/issue-return-invoice-print/' + r.id, '_blank');
                                    await new Promise(r => setTimeout(r, 1000));
                                    window.location = '/issueReturn';
                                } else {
                                    window.location = '/issueReturn';
                                }
                            }
                        })
                        .catch(err => {
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
                    this.issueReturn = {
                        id: '',
                        table_id: null,
                        date: moment().format("YYYY-MM-DD"),
                        total: 0.00,
                        description: ''
                    }
                    this.carts = [];
                    this.selectedTable = {
                        id: "",
                        name: "Select Table",
                        code: "",
                        display_name: "Select Table"
                    }
                }
            }
        })
    </script>
@endpush
