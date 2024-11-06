@extends('master')
@section('title')
{{$id != 0 ? 'Issue Update' : 'Issue Entry'}}
@endsection
@section('breadcrumb_title')
{{$id != 0 ? 'Issue Update' : 'Issue Entry'}}
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
<div class="row" id="Issue">
    <div class="col-xs-12 col-md-12">
        <div class="widget-head-box bg-of-orange">
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-md-1 control-label no-padding-right"> Invoice no </label>
                    <div class="col-md-2 col-xs-8">
                        <input type="text" id="invoice" class="form-control" name="invoice" v-model="issue.invoice" readonly />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-4 col-md-2 control-label no-padding-right"> Issue Date </label>
                    <div class="col-md-3 col-xs-8">
                        <input class="form-control" id="date" name="date" type="date" v-model="issue.date" {{Auth::user()->role == 'user' ? 'disabled' : ''}} />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-4 col-md-1 control-label no-padding-right"> Issue By </label>
                    <div class="col-md-3 col-xs-8">
                        <input type="text" id="issueby" class="form-control" name="issueby" v-model="issueBy" readonly />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-9">

        <div class="row">
            <div class="col-xs-12 col-md-5">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 149px;">
                    <legend class="scheduler-border">Table Information</legend>
                    <div class="control-group">
                        <div class="form-group">
                            <label class="col-xs-3 control-label" style="padding-left: 0;"> Issue To </label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" v-model="issue.issue_to" placeholder="Issue To" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" style="padding-left: 0;"> Table </label>
                            <div class="col-xs-9" style="display: flex;align-items:center;margin-bottom:4px;">
                                <div style="width: 89%;">
                                    <v-select v-bind:options="tables" style="margin: 0;" v-model="selectedTable" @search="onSearchTable" label="display_name"></v-select>
                                </div>
                                <div style="width: 11%;margin-left:2px;">
                                    <a href="/table" title="Add New Table" class="btn btn-xs btn-danger" style="width: 100%;height: 23px;border: 0px;border-radius: 3px;" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label" style="padding-left: 0;"> Name </label>
                            <div class="col-xs-9">
                                <input type="text" placeholder="Table Name" class="form-control" v-model="selectedTable.name" disabled />
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="col-xs-12 col-md-5">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Asset Information</legend>
                    <div class="control-group">
                        <form @submit.prevent="addToCart">
                            <div class="form-group">
                                <label class="col-xs-3 control-label" style="padding-left: 0;"> Asset </label>
                                <div class="col-xs-9" style="display: flex;align-items:center;margin-bottom:4px;">
                                    <div style="width: 89%;">
                                        <v-select v-bind:options="assets" style="margin: 0;" id="asset" v-model="selectedAsset" label="display_name" @input="onChangeAsset" @search="onSearchAsset"></v-select>
                                    </div>
                                    <div style="width: 11%;margin-left:2px;">
                                        <a href="/asset" title="Add New Asset" class="btn btn-xs btn-danger" style="width: 100%;height: 23px;border: 0px;border-radius: 3px;" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 col-md-3 control-label" style="padding-left: 0;" for="price"> Price </label>
                                <div class="col-xs-4 col-md-4" style="padding-right: 0;">
                                    <input type="number" step="0.001" min="0" id="price" name="price" class="form-control" v-model="selectedAsset.price" @input="assetTotal" required />
                                </div>

                                <label class="col-xs-1 control-label" style="padding-right: 0;"> Qty </label>
                                <div class="col-xs-4 col-md-4">
                                    <input type="number" step="0.001" min="0" id="quantity" name="quantity" class="form-control" v-model="selectedAsset.quantity" @input="assetTotal" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label" style="padding-left: 0;"> Amount </label>
                                <div class="col-xs-9">
                                    <input type="text" id="assetTotal" class="form-control" readonly v-model="selectedAsset.total" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label no-padding-right"> </label>
                                <div class="col-xs-9">
                                    <button type="submit" class="add-cart-btn pull-right">Add Cart</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>

            <div class="col-xs-12 col-md-2">
                <div class="form-group col-xs-12 col-md-12 no-padding-left">
                    <div style="height: 80px; margin-top: 15px;">
                        <div>
                            <div class="text-center" style="display:none; font-size:12px" v-bind:style="{color: assetStock > 0 ? 'green' : 'red', display: selectedAsset.id == '' ? 'none' : ''}">
                                @{{ assetStockText }}
                            </div>
                            <input type="text" id="assetStock" v-model="assetStock" readonly style="border:none;font-size:15px;width:100%;text-align:center; border-radius: 0px !important; padding:0px;" :style="{color: assetStock > 0 ? 'green':'red'}"><br>
                            <input type="text" id="stockUnit" v-model="selectedAsset.unit_name" readonly style="border:none;font-size:12px;width:100%;text-align: center;border-radius: 0px !important;height: 20px;"><br>
                            <input type="password" ref="assetPrice" v-model="selectedAsset.price" v-on:mousedown="toggleAssetPrice" v-on:mouseup="toggleAssetPrice" readonly title="Purchase rate (click & hold)" style="font-size:12px;width:100%;text-align: center;border:none;border-radius: 0px !important;height: 20px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                        <thead>
                            <tr>
                                <th style="width:5%;">SL</th>
                                <th style="width:30%;">Asset Name</th>
                                <th style="width:15%;">Brand</th>
                                <th style="width:15%;">Price</th>
                                <th style="width:10%;">Quantity</th>
                                <th style="width:15%;">Total</th>
                                <th style="width:10%;">Action</th>
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
                                    <input type="number" style="margin: 0;" step="0.01" min="0" :disabled="issue.id != 0" @input="editQtyPrice(asset)" class="form-control" v-model="asset.quantity">
                                </td>
                                <td>@{{ asset.total }}</td>
                                <td>
                                    <a v-if="issue.id == 0" href="" @click.prevent="editCart(asset)"><i class="fa fa-edit"></i></a>
                                    <a href="" @click.prevent="removeCart(asset)"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="8"></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td colspan="4">Note</td>
                                <td colspan="3">Total</td>
                            </tr>
                            <tr>
                                <td colspan="4"><textarea style="width: 100%;font-size:13px;" placeholder="Description" v-model="issue.description"></textarea></td>
                                <td colspan="3" style="padding-top: 15px;font-size:18px;">@{{ issue.total }}</td>
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
                                                <input type="number" step="0.001" id="subtotal" name="subtotal" class="form-control" v-model="issue.subtotal" readonly />
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="display: none;">
                                    <td>
                                        <div class="form-group">
                                            <label class="col-xs-12 control-label no-padding-right"> Discount </label>
                                            <div class="col-xs-6" style="display:flex;align-items:center;">
                                                <input type="number" step="0.001" min="0" class="form-control" id="issueDiscount" name="discount" v-model="issue.discount" @input="calculateTotal($event)" />
                                                <label>%</label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="number" step="0.001" min="0" class="form-control" id="issuediscountAmount" name="discountAmount" v-model="issue.discountAmount" @input="calculateTotal($event)" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="col-xs-12 control-label no-padding-right"> Vat </label>
                                            <div class="col-xs-6" style="display:flex;align-items:center;">
                                                <input type="number" step="0.001" min="0" class="form-control" id="vat" name="vat" v-model="issue.vat" @input="calculateTotal($event)" />
                                                <label>%</label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="number" step="0.001" min="0" class="form-control" id="vatAmount" name="vatAmount" v-model="issue.vatAmount" @input="calculateTotal($event)" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="col-xs-12 control-label no-padding-right">Total</label>
                                            <div class="col-xs-12">
                                                <input type="number" step="0.001" id="total" class="form-control" v-model="issue.total" readonly />
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                @if(userAction('u') || userAction('e'))
                                <tr>
                                    <td>
                                        <div class="form-group mt-1">
                                            <div class="col-xs-6">
                                                <input type="button" class="btn btn-success" value="Issue" @click="saveIssue" :disabled="onProgress ? true : false" style="background:#000;color:#fff;padding:3px;width:100%;">
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="button" class="btn btn-info" onclick="window.location = '/issue'" value="New Issue" style="background:#000;color:#fff;padding:3px;width:100%;">
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
        el: '#Issue',
        data() {
            return {
                issue: {
                    id: "{{$id}}",
                    invoice: "{{$invoice}}",
                    date: moment().format("YYYY-MM-DD"),
                    issue_to: '',
                    table_id: null,
                    subtotal: 0,
                    discount: 0,
                    discountAmount: 0,
                    vat: 0,
                    vatAmount: 0,
                    total: 0,
                    description: "",
                },
                carts: [],
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
                },
                issueBy: "{{ Auth::user()->name }}",

                assetStock: "",
                assetStockText: "",
                onProgress: false,
                fixed: 2,
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
            this.getTables();
            if (this.issue.id != 0) {
                this.getIssue();
            }
        },

        methods: {
            getTables() {
                let filter = {
                    forSearch: 'yes'
                }
                axios.post("/get-table", filter).then(res => {
                    let r = res.data;
                    this.tables = r.map((item, index) => {
                        item.display_name = `${item.code} - ${item.name}`
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
                            item.display_name = `${item.code} - ${item.name}`
                            return item;
                        });
                    })
            },
            async onSearchTable(val, loading) {
                if (val.length > 2) {
                    loading(true)
                    await axios.post("/get-table", {
                        name: val
                    }).then(res => {
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
            async onChangeAsset() {
                if (this.selectedAsset == null) {
                    this.selectedAsset = {
                        id: "",
                        name: "",
                        display_name: "",
                        price: 0,
                        quantity: 0
                    }

                    this.assetStockText = '';
                    this.assetStock = '';
                    return
                }

                if (this.selectedAsset.id != "") {
                    document.querySelector("#quantity").focus();
                    this.assetStock = await axios.post('/get-asset-stock', {
                            assetId: this.selectedAsset.id
                        })
                        .then(res => {
                            return res.data[0].current_quantity;
                        })

                    this.assetStockText = this.assetStock > 0 ? "Available" : "Unavailable";
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
            toggleAssetPrice() {
                this.$refs.assetPrice.type = this.$refs.assetPrice.type == 'text' ? 'password' : 'text';
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
                if (parseFloat(asset.quantity) > parseFloat(this.assetStock)) {
                    toastr.error("Stock Unavailable");
                    return;
                }
                this.carts.unshift(asset)
                this.clearAsset();
                if (this.issue.id != 0) {
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
                if (parseFloat(assetStock) < parseFloat(asset.quantity) && this.issue.id != 0) {
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
                    price: 0,
                    quantity: 0
                }
                this.assetStock = "";
                this.assetStockText = "";
            },
            calculateTotal() {
                this.issue.subtotal = parseFloat(this.carts.reduce((pre, cur) => {
                    return pre + parseFloat(cur.total)
                }, 0)).toFixed(this.fixed)

                if (event.target.id == 'issueDiscount') {
                    this.issue.discountAmount = parseFloat((parseFloat(this.issue.subtotal) * parseFloat(this.issue.discount)) / 100).toFixed(this.fixed);
                }
                if (event.target.id == 'issuediscountAmount') {
                    this.issue.discount = parseFloat((parseFloat(this.issue.discountAmount) * 100) / parseFloat(this.issue.subtotal)).toFixed(this.fixed);
                }
                this.issue.total = parseFloat(parseFloat(this.issue.subtotal) - parseFloat(this.issue.discountAmount)).toFixed(this.fixed)
                if (event.target.id == 'vat') {
                    this.issue.vatAmount = parseFloat((parseFloat(this.issue.total) * parseFloat(this.issue.vat)) / 100).toFixed(this.fixed);
                }
                if (event.target.id == 'vatAmount') {
                    this.issue.vat = parseFloat((parseFloat(this.issue.vatAmount) * 100) / parseFloat(this.issue.total)).toFixed(this.fixed);
                }
                this.issue.total = parseFloat((parseFloat(this.issue.subtotal) + +parseFloat(this.issue.vatAmount)) - parseFloat(this.issue.discountAmount)).toFixed(this.fixed)
            },
            async saveIssue() {
                this.issue.table_id = this.selectedTable.id != "" ? this.selectedTable.id : "";
                if (this.issue.id == 0) {
                    var url = '/add-issue';
                } else {
                    var url = '/update-issue';
                }
                let data = {
                    issue: this.issue,
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
                            let conf = confirm('Issue success, Do you want to view invoice?');
                            if (conf) {
                                window.open('/issue-invoice-print/' + r.id, '_blank');
                                await new Promise(r => setTimeout(r, 1000));
                                window.location = '/issue';
                            } else {
                                window.location = '/issue';
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
                this.issue = {
                    id: "{{$id}}",
                    invoice: "{{$invoice}}",
                    date: moment().format("YYYY-MM-DD"),
                    subtotal: 0,
                    discount: 0,
                    discountAmount: 0,
                    vat: 0,
                    vatAmount: 0,
                    total: 0,
                    description: ""
                }
                this.carts = [];
                this.selectedTable = {
                    id: "",
                    name: "Select Table",
                    code: "",
                    display_name: "Select Table"
                };
            },

            getIssue() {
                axios.post("/get-issue", {
                        id: this.issue.id
                    })
                    .then(res => {
                        let issue = res.data[0];
                        let keys = Object.keys(this.issue);
                        keys.forEach(key => {
                            this.issue[key] = issue[key];
                        });


                        this.selectedTable = {
                            id: issue.table_id,
                            name: issue.table ? issue.table.name : 'n/a',
                            code: issue.table ? issue.table.code : 'n/a',
                            display_name: `${issue.table ? issue.table.code : 'n/a'} - ${issue.table ? issue.table.name : 'n/a'}`
                        }

                        issue.issue_details.forEach(async detail => {
                            let asset = {
                                asset_id: detail.asset_id,
                                code: detail.asset ? detail.asset.code : 'n/a',
                                name: detail.asset ? detail.asset.name : 'n/a',
                                brandName: detail.asset.brand.name,
                                quantity: detail.quantity,
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