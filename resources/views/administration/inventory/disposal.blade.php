@extends('master')
@section('title')
{{$id != 0 ? 'Disposal Update' : 'Disposal Entry'}}
@endsection
@section('breadcrumb_title')
{{$id != 0 ? 'Disposal Update' : 'Disposal Entry'}}
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
<div class="row" id="Disposal">
    <div class="col-xs-12 col-md-12">
        <div class="row">
            <div class="col-xs-12 col-md-5">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Disposal Information</legend>
                    <div class="control-group">
                        <div class="form-group">
                            <label class="col-xs-3 control-label" style="padding-left: 0;"> Date </label>
                            <div class="col-xs-9">
                                <input class="form-control" id="date" name="date" type="date" v-model="disposal.date" {{Auth::user()->role == 'user' ? 'disabled' : ''}} />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" style="padding-left: 0;"> Room </label>
                            <div class="col-xs-9" style="display: flex;align-items:center;margin-bottom:4px;">
                                <div style="width: 91%;">
                                    <v-select v-bind:options="rooms" style="margin: 0;" v-model="selectedRoom" @search="onSearchRoom" @input="onChangeRoom" label="name"></v-select>
                                </div>
                                <div style="width: 9%;margin-left:2px;">
                                    <a href="/room" title="Add New Room" class="btn btn-xs btn-danger" style="width: 100%;height: 23px;border: 0px;border-radius: 3px;" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <span style="color: #aee2ff; font-size: 1px !important;">break text</span>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" style="padding-left: 0;"> Asset </label>
                            <div class="col-xs-9" style="display: flex;align-items:center;margin-bottom:4px;">
                                <div style="width: 91%;">
                                    <v-select v-bind:options="assets" id="asset" style="margin: 0;" v-model="selectedAsset" @search="onSearchAsset" @input="onChangeAsset" label="display_name"></v-select>
                                </div>
                                <div style="width: 9%;margin-left:2px;">
                                    <a href="/asset" title="Add New Asset" class="btn btn-xs btn-danger" style="width: 100%;height: 23px;border: 0px;border-radius: 3px;" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label" style="padding-left: 0;"> Amount</label>
                            <div class="col-xs-9">
                                <input type="number" step="0.001" min="0" id="price" name="price" class="form-control" v-model="selectedAsset.price" @input="assetTotal" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label" style="padding-left: 0;"> Quantity</label>
                            <div class="col-xs-9">
                                <input type="number" step="0.001" min="0" id="quantity" name="quantity" class="form-control" v-model="selectedAsset.quantity" @input="assetTotal" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label" style="padding-left: 0;"> Status</label>
                            <div class="col-xs-9">
                                <select name="status" id="status" v-model="selectedAsset.status" class="form-control">
                                    <option value="Repairable">Repairable</option>
                                    <option value="Non Repairable">Non Repairable</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-4 control-label no-padding-right"> </label>
                            <div class="col-xs-8">
                                <button type="button" @click="addToCart" class="add-cart-btn pull-right">Add Cart</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="col-xs-12 col-md-7">
                <fieldset class="scheduler-border bg-of-skyblue" style="min-height: 255px;">
                    <legend class="scheduler-border">Disposal Asset Information</legend>
                    <div class="control-group">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                                <thead>
                                    <tr>
                                        <th style="width:5%;">SL</th>
                                        <th style="width:25%;">Asset Name</th>
                                        <th style="width:15%;">Brand</th>
                                        <th style="width:15%;">Price</th>
                                        <th style="width:10%;">Quantity</th>
                                        <th style="width:15%;">Total</th>
                                        <th style="width:15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-of-cyan" style="display:none;" v-bind:style="{display: carts.length > 0 ? '' : 'none'}">
                                    <tr v-for="(asset, sl) in carts">
                                        <td>@{{ sl + 1}}</td>
                                        <td>@{{ asset.name }}</td>
                                        <td>@{{ asset.brandName }}</td>
                                        <td>
                                           @{{ asset.price }}
                                        </td>
                                        <td>
                                            <input type="number" style="margin: 0;" step="0.01" min="0" :disabled="disposal.id != 0" @input="editQtyPrice(asset)" class="form-control" v-model="asset.quantity">
                                        </td>
                                        <td>@{{ asset.total }}</td>
                                        <td>
                                            <a v-if="disposal.id == 0" href="" @click.prevent="editCart(asset)"><i class="fa fa-edit"></i></a>
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
                                        <td colspan="4"><textarea style="width: 100%;font-size:13px;" placeholder="Description" v-model="disposal.note"></textarea></td>
                                        <td colspan="4" style="padding-top: 15px;font-size:18px;">@{{ disposal.total }}</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        @if(userAction('u') || userAction('e'))
                        <div class="form-group mt-1">
                            <div class="col-xs-9"></div>
                            <div class="col-xs-3 no-padding-right">
                                <input type="button" class="btn btn-success" value="Save Disposal" @click="saveDisposal" :disabled="onProgress ? true : false" style="background:#000;color:#fff;padding:3px;width:100%;">
                            </div>
                        </div>
                        @endif
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#Disposal',
        data() {
            return {
                disposal: {
                    id: "{{$id}}",
                    invoice: "{{$invoice}}",
                    date: moment().format("YYYY-MM-DD"),
                    room_id: null,
                    total: 0,
                    note: '',
                },
                carts: [],
                rooms: [],
                selectedRoom: null,

                assets: [],
                selectedAsset: {
                    id: "",
                    name: "",
                    display_name: "",
                    price: 0,
                    quantity: 0,
                    status: ''
                },

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
            this.getRooms();
            if (this.disposal.id != 0) {
                this.getDisposal();
            }
        },

        methods: {
            getRooms() {
                axios.get("/get-room")
                    .then(res => {
                        let r = res.data;
                        this.rooms = r.map((item, index) => {
                            item.display_name = `${item.code} - ${item.name} `
                            return item;
                        });
                    })
            },

            onChangeRoom() {
                if(this.selectedRoom == null) {
                    return;
                }
                
                this.getAsset();
            },
            
            getAsset() {
                axios.post("/get-issue-asset", {
                        roomId: this.selectedRoom.id
                    })
                    .then(res => {
                        this.assets = res.data;
                    })
            },
         
            async onSearchAsset(val, loading) {
                if (val.length > 2) {
                    loading(true);
                    await axios.post("/get-issue-asset", {
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
                        status: ''
                    }
                    return
                }
                if (this.selectedAsset.id != "") {
                    document.querySelector("#quantity").focus();
                }
            },

            assetTotal() {
                this.selectedAsset.total = parseFloat(this.selectedAsset.quantity) * parseFloat(this.selectedAsset.price);
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
                    total: this.selectedAsset.total,
                    disposal_status: this.selectedAsset.status
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
                if (this.disposal.id != 0) {
                    this.addToCartNew = 'yes';
                }
                this.calculateTotal();
                document.querySelector("#asset [type='search']").focus();
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
                    total: asset.total,
                    disposal_status: asset.disposal_status
                }

            },

            async removeCart(asset) {
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
                    quantity: 0,
                    status: ''
                }

            },

            calculateTotal() {
                this.disposal.total = parseFloat(this.carts.reduce((pre, cur) => {
                    return pre + parseFloat(cur.total)
                }, 0)).toFixed(this.fixed)
            },

            async saveDisposal() {
                this.disposal.room_id = this.selectedRoom != null ? this.selectedRoom.id : "";
                if (this.disposal.id == 0) {
                    var url = '/add-disposal';
                } else {
                    var url = '/update-disposal';
                }
                let data = {
                    disposal: this.disposal,
                    carts: this.carts
                }
                this.onProgress = true
                await axios.post(url, data)
                    .then(async res => {
                        let r = res.data;
                        toastr.success(r.message);
                        this.clearForm();
                        this.onProgress = false
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
                this.disposal = {
                    id: "{{$id}}",
                    invoice: "{{$invoice}}",
                    date: moment().format("YYYY-MM-DD"),
                    room_id: null,
                    total: 0,
                    note: '',
                }

                this.carts = [];
                this.selectedRoom = null;
            },

            //search method here
            async onSearchRoom(val, loading) {
                if (val.length > 2) {
                    loading(true)
                    await axios.post("/get-room", {
                            name: val
                        })
                        .then(res => {
                            this.rooms = res.data;
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getRooms();
                }
            },


            getDisposal() {
                axios.post("/get-disposal", {
                        id: this.disposal.id
                    })
                    .then(res => {
                        let disposal = res.data[0];
                        let keys = Object.keys(this.disposal);
                        keys.forEach(key => {
                            this.disposal[key] = disposal[key];
                        });

                        this.selectedRoom = {
                            id: disposal.room_id,
                            name: disposal.room ? disposal.room.name : 'n/a'
                        }

                        this.getAsset();
                        
                        disposal.disposal_details.forEach(async detail => {
                            let asset = {
                                asset_id: detail.asset_id,
                                code: detail.asset ? detail.asset.code : 'n/a',
                                name: detail.asset ? detail.asset.name : 'n/a',
                                brandName: detail.asset.brand.name,
                                quantity: detail.quantity,
                                price: parseFloat(detail.price).toFixed(this.fixed),
                                total: detail.total,
                                disposal_status: detail.disposal_status,
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