@extends('master')
@section('title', 'Asset Entry')
@section('breadcrumb_title', 'Asset Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .assetImage {
        padding-right: 0;
    }

    .fa-barcode {
        border: 1px solid gray;
        border-radius: 3px;
        padding: 0px 3px;
        font-weight: 600;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .assetImage {
            padding: 0;
        }
    }

    .ImageBackground .imageShow {
        display: block;
        height: 80px;
        width: 90px;
        border: 1px solid #cccccc;
        box-sizing: border-box;
        margin-bottom: 5px;
    }
    .icon-size {
        font-size: 16px;
    }
</style>
@endpush
@section('content')
<div id="Asset">
    <form @submit.prevent="saveAsset">
        <div class="row" style="margin:0;">
            <div class="col-md-10 col-xs-12" style="padding: 0;">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Asset Entry Form</legend>
                    <div class="control-group">
                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Asset Name <sup class="text-danger">*</sup></label>
                                <div class=" col-xs-8 col-md-7">
                                    <input type="text" class="form-control" name="name" v-model="asset.name" autocomplete="off" />
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Asset Code </label>
                                <div class=" col-xs-8 col-md-7">
                                    <input type="text" class="form-control" name="code" v-model="asset.code" autocomplete="off" />
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Select Brand <sup class="text-danger">*</sup> </label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="brands" style="margin: 0;" v-model="selectedBrand" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal('/brand', 'Brand Entry')" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Select Unit <sup class="text-danger">*</sup> </label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="units" style="margin: 0;" v-model="selectedUnit" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal('/unit', 'Unit Entry')" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Asset Origin </label>
                                <div class=" col-xs-8 col-md-7">
                                    <input type="text" class="form-control" name="origin" v-model="asset.origin" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Asset Price <sup class="text-danger">*</sup></label>
                                <div class="col-xs-8 col-md-7">
                                    <input type="number" min="0" step="any" class="form-control" name="price" v-model="asset.price">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4"></label>
                                <div class="col-xs-8 col-md-7">
                                    <label for="is_active"> <input type="checkbox" name="is_active" id="is_active" v-model="asset.is_active"> Is Active</label>
                                    &nbsp;<label for="is_serial"> <input type="checkbox" name="is_serial" id="is_serial" v-model="asset.is_serial"> Is Serial</label>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="col-md-4"></label>
                                <div class="col-md-7 text-right">
                                    @if(userAction('e'))
                                    <input type="button" class="btn btn-danger btn-reset" value="Reset" @click="clearForm">
                                    <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-2 col-xs-12 assetImage">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 150px;">
                    <legend class="scheduler-border">Image Upload</legend>
                    <div class="control-group">
                        <div class="form-group ImageBackground clearfix">
                            <small class="text-danger">(200 X 200)PX</small>
                            <img :src="imageSrc" class="imageShow" />
                            <label for="image">Upload Image</label>
                            <input type="file" id="image" class="form-control shadow-none" @change="imageUrl" />
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="assets" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr :style="{background: row.status == 'p' ? '#ffdb9a' : ''}" :title="row.status == 'p' ? 'Inactive' : 'Active'">
                            <td>@{{ row.sl }}</td>
                            <td>@{{ row.code }}</td>
                            <td style="text-align: left;">@{{ row.name }}</td>
                            <td>@{{ row.brand_name }}</td>
                            <td>@{{ row.unit_name }}</td>
                            <td>@{{ row.origin }}</td>
                            <td>@{{ row.price }}</td>
                            <td>
                                <span class="badge badge-success" v-if="row.is_active == 1">True</span>
                                <span class="badge badge-danger" v-else>False</span>
                            </td>
                            <td>
                                <span class="badge badge-success" v-if="row.is_serial == 1">True</span>
                                <span class="badge badge-danger" v-else>False</span>
                            </td>
                            <td>
                                @if(userAction('u'))
                                <i @click="editData(row)" class="fa fa-pencil"></i>
                                @endif
                                @if(userAction('d'))
                                <i @click="deleteData(row.id)" class="fa fa-trash"></i>
                                @endif
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page" style="margin-bottom: 50px;"></datatable-pager>
            </div>
        </div>
    </div>
    @include('administration.settings.modal.common')
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#Asset',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Asset Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Asset Code',
                        field: 'code',
                        align: 'center'
                    },
                    {
                        label: 'Brand',
                        field: 'brand_name',
                        align: 'center'
                    },
                    {
                        label: 'Unit Name',
                        field: 'unit_name',
                        align: 'center'
                    },
                    {
                        label: 'Origin',
                        field: 'origin',
                        align: 'center'
                    },
                    {
                        label: 'Price',
                        field: 'price',
                        align: 'center'
                    },
                    {
                        label: 'Is Active',
                        field: 'is_active',
                        align: 'center'
                    },
                    {
                        label: 'Is Serial',
                        field: 'is_serial',
                        align: 'center'
                    },
                    {
                        label: 'Action',
                        align: 'center',
                        filterable: false
                    }
                ],
                page: 1,
                per_page: 20,
                filter: '',

                asset: {
                    id: "",
                    name: "",
                    code: "",
                    brand_id: null,
                    unit_id: null,
                    origin: "",
                    price: 0,
                    is_active: true,
                    is_serial: false,
                    image: "",
                },
                assets: [],
                brands: [],
                selectedBrand: null,
                units: [],
                selectedUnit: null,

                imageSrc: "/noImage.gif",
                onProgress: false,
                btnText: "Save",

                modalHead: "",
                modalData: {
                    id: null,
                    name: ''
                },
                url: '',
            }
        },

        created() {
            this.getBrand();
            this.getUnits();
            this.getAsset();
        },

        methods: {
            getBrand() {
                axios.get("/get-brand")
                    .then(res => {
                        this.brands = res.data
                    })
            },
            getUnits() {
                axios.get("/get-unit")
                    .then(res => {
                        this.units = res.data
                    })
            },
            getAsset() {
                axios.get("/get-asset")
                    .then(res => {
                        let r = res.data;
                        this.assets = r.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                    })
            },

            saveAsset(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.asset.id);
                formdata.append('brand_id', this.selectedBrand != null ? this.selectedBrand.id : '');
                formdata.append('unit_id', this.selectedUnit != null ? this.selectedUnit.id : '');
                formdata.append('image', this.asset.image);
                var url;
                if (this.asset.id == '') {
                    url = '/asset';
                } else {
                    url = '/update-asset';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data.message);
                        this.getAsset();
                        this.clearForm();
                        this.asset.code = res.data.code;
                        this.btnText = "Save";
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

            editData(row) {
                this.btnText = "Update";
                let keys = Object.keys(this.asset);
                keys.forEach(key => {
                    this.asset[key] = row[key];
                });
                
                if (row.brand_id != null) {
                    this.selectedBrand = {
                        id: row.brand_id,
                        name: row.brand_name
                    }
                }
                if (row.unit_id != null) {
                    this.selectedUnit = {
                        id: row.unit_id,
                        name: row.unit_name
                    }
                }

                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-asset", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getAsset();
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

            clearForm() {
                this.asset = {
                    id: "",
                    name: "",
                    code: "",
                    brand_id: null,
                    unit_id: null,
                    origin: "",
                    price: 0,
                    is_active: true,
                    is_serial: false,
                    image: ""
                }
                this.selectedBrand = null;
                this.selectedUnit = null;
                this.imageSrc = "/noImage.gif"
            },

            imageUrl(event) {
                const WIDTH = 200;
                const HEIGHT = 200;
                if (event.target.files[0]) {
                    let reader = new FileReader();
                    reader.readAsDataURL(event.target.files[0]);
                    reader.onload = (ev) => {
                        let img = new Image();
                        img.src = ev.target.result;
                        img.onload = async e => {
                            let canvas = document.createElement('canvas');
                            canvas.width = WIDTH;
                            canvas.height = HEIGHT;
                            const context = canvas.getContext("2d");
                            context.drawImage(img, 0, 0, canvas.width, canvas.height);
                            let new_img_url = context.canvas.toDataURL(event.target.files[0].type);
                            this.imageSrc = new_img_url;
                            const resizedImage = await new Promise(rs => canvas.toBlob(rs, 'image/jpeg', 1))
                            this.asset.image = new File([resizedImage], event.target.files[0].name, {
                                type: resizedImage.type
                            });
                        }
                    }
                } else {
                    event.target.value = '';
                }
            },

            openModal(url, txt) {
                this.modalHead = txt;
                this.url = url;
                $('#commonModal').modal('show');
            },
            
            resetModal() {
                this.modalHead = '';
                this.modalData = {
                        id: null,
                        name: ''
                    },
                    this.url = '';
            },

            addData() {
                axios.post(this.url, this.modalData)
                    .then(res => {
                        toastr.success(res.data.message);
                        if (this.url == '/unit') {
                            this.getUnits();
                        }
                        if (this.url == '/brand') {
                            this.getBrand();
                        }
                        this.resetModal();
                        $('#commonModal').modal('hide');
                    })
                    .catch(err => {
                        var r = JSON.parse(err.request.response);
                        if (r.errors) {
                            $.each(r.errors, (index, value) => {
                                $.each(value, (ind, val) => {
                                    toastr.error(val)
                                })
                            })
                        } else {
                            toastr.error(r.message);
                        }
                    })
            },
        },
    })
</script>
@endpush