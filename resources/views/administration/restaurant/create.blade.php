@extends('master')
@section('title', 'Menu Entry')
@section('breadcrumb_title', 'Menu Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .menuImage {
        padding-right: 0;
    }

    .fa-barcode {
        border: 1px solid gray;
        border-radius: 3px;
        padding: 0px 3px;
        font-weight: 600;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .menuImage {
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

    .information {
		/* border: 1px solid #89AED8; */
		background-color: #EEEEEE;
		border-radius: 3px;
		margin: 7px 13px;
	}
	.recipe_heading {
		background: #DDDDDD;
		padding: 5px;
		font-size: 12px;
		color: #323A89;
	}
	.btn-add {
		padding: 3px 7px;
		background: #B74635 !important;
		border: none !important;
		border-radius: 3px;
        font-size: 11px;
		float: right;
	}
	.btn-add-cart {
		padding: 2px 7px;
		background: #B74635 !important;
		border: none !important;
		border-radius: 3px;
        font-size: 13px;
		float: right;
	}
</style>
@endpush
@section('content')
<div id="Menu">
    <form @submit.prevent="saveMenu">
        <div class="row" style="margin:0;">
            <div class="col-md-10 col-xs-12" style="padding: 0;">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Menu Entry Form</legend>
                    <div class="control-group">
                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Menu Code </label>
                                <div class=" col-xs-8 col-md-7">
                                    <input type="text" class="form-control" name="code" v-model="menu.code">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Category <sup class="text-danger">*</sup> </label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="categories" style="margin: 0;" v-model="selectedCategory" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal('/menu-category', 'Category Entry')" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Menu Name <sup class="text-danger">*</sup></label>
                                <div class="col-xs-8 col-md-7">
                                    <input type="text" class="form-control" name="name" v-model="menu.name" autocomplete="off" />
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Unit <sup class="text-danger">*</sup> </label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="units" style="margin: 0;" v-model="selectedUnit" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal('/unit', 'Unit Entry')" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">vat</sup></label>
                                <div class="col-xs-8 col-md-7">
                                    <input type="number" min="0" step="any" class="form-control" name="vat" v-model="menu.vat">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Sale Rate <sup class="text-danger">*</sup></label>
                                <div class="col-xs-8 col-md-7">
                                    <input type="number" min="0" step="any" class="form-control" name="sale_rate" v-model="menu.sale_rate">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <div class="information">
                                        <div class="col-sm-12 recipe_heading"> <strong> Recipe Entry</strong> <button class="btn btn-add" type="button" data-toggle="modal" data-target="#myModal"> +Add</button></div>
                                        <div class="table-responsive" style="padding: 5px 3px 0px 3px;">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Material</th>
                                                        <th>Price</th>
                                                        <th>Qnty</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="materil in carts">
                                                        <td>@{{ materil.name }}</td>
                                                        <td>@{{ materil.price }}</td>
                                                        <td>@{{ materil.quantity }}</td>
                                                        <td>@{{ materil.total }}</td>
                                                        <td><a href="" @click.prevent="removeCart(materil)"><i class="fa fa-trash"></i></a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
            <div class="col-md-2 col-xs-12 menuImage">
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
                <datatable :columns="columns" :data="menus" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr :style="{background: row.status == 'p' ? '#ffdb9a' : ''}" :title="row.status == 'p' ? 'Inactive' : 'Active'">
                            <td>@{{ row.sl }}</td>
                            <td>@{{ row.code }}</td>
                            <td style="text-align: left;">@{{ row.name }}</td>
                            <td>@{{ row.category_name }}</td>
                            <td>@{{ row.unit_name }}</td>
                            <td>@{{ row.vat }}</td>
                            <td>@{{ row.sale_rate }}</td>
                            <td>
                                <span class="badge badge-success" v-if="row.status == 'a'">Active</span>
                                <span class="badge badge-danger" v-else>Inactive</span>
                            </td>
                            <td>
                                @if(userAction('u'))
                                <i @click="editData(row)" class="fa fa-pencil"></i>
                                @endif
                                <i @click="updateStatus(row.id)" class="icon-size" :style="{color: row.status == 'a' ? 'green' : 'red'}" :class="row.status == 'a' ? 'bi bi-toggle-on' : 'bi bi-toggle-off'"></i>
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

    <!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered modal-sm">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" style="padding: 5px 15px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Recipes</h4>
				</div>
				<form @submit.prevent="addToCart">
				<div class="modal-body">
					<div class="row">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="examination"> Material</label>
							<div class="col-sm-9">
								<select class="form-control" v-if="materials.length == 0"></select>
								<v-select v-bind:options="materials" id="material" v-model="selectedMaterial" label="name" v-if="materials.length > 0" @input="onChangeMaterial" ></v-select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="examination"> Quantity</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="quantity" step="any" min="0" v-model="selectedMaterial.quantity" @input="materialTotal">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="examination"> Price</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" id="price" step="any" min="0" v-model="selectedMaterial.price" @input="materialTotal">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="examination"> Total</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" step="any" min="0" v-model="selectedMaterial.total" readonly>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer" style="padding-top: 8px; padding-bottom: 8px;">
					<button type="submit" class="btn btn-add-cart">Add To Cart</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#Menu',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Menu Code',
                        field: 'code',
                        align: 'center'
                    },
                    {
                        label: 'Menu Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Category',
                        field: 'category_name',
                        align: 'center'
                    },
                    {
                        label: 'Unit Name',
                        field: 'unit_name',
                        align: 'center'
                    },
                    {
                        label: 'Vat',
                        field: 'vat',
                        align: 'center'
                    },
                    {
                        label: 'Sale Rate',
                        field: 'sale_rate',
                        align: 'center'
                    },
                    {
                        label: 'Status',
                        field: 'status',
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

                menu: {
                    id: "",
                    code: "{{ generateCode('Menu', 'M') }}",
                    name: "",
                    menu_category_id: "",
                    unit_id: "",
                    vat: 0,
                    sale_rate: 0,
                    image: "",
                },
                menus: [],
                categories: [],
                selectedCategory: null,
                units: [],
                selectedUnit: null,
                materials: [],
                selectedMaterial: {
                    id: '',
                    name: '',
                    price: 0,
                    total: 0
                },
                carts: [],

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
            this.getCategory();
            this.getUnits();
            this.getMaterials();
            this.getMenu();
        },

        methods: {
            getCategory() {
                axios.get("/get-menu-category")
                    .then(res => {
                        this.categories = res.data
                    })
            },
            getUnits() {
                axios.get("/get-unit")
                    .then(res => {
                        this.units = res.data
                    })
            },

            getMaterials() {
                axios.get('/get-material')
                .then(res => {
                    this.materials = res.data;
                })
            },

            onChangeMaterial() {
                if (this.selectedMaterial == null) {
                    this.selectedMaterial = {
                        id: '',
                        name: '',
                        price: 0,
                        total: 0
                    }
                    return;
                }
                if (this.selectedMaterial.id != "") {
                    document.querySelector("#quantity").focus();
                }
            },

            materialTotal() {
                if (this.selectedMaterial == null) {
                    return;
                }
                let total = parseFloat(this.selectedMaterial.quantity) * parseFloat(this.selectedMaterial.price);
                this.selectedMaterial.total = parseFloat(total);
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
                    quantity: this.selectedMaterial.quantity,
                    price: parseFloat(this.selectedMaterial.price).toFixed(2),
                    total: this.selectedMaterial.total
                }
                let cartIndex = this.carts.findIndex(cart => cart.material_id == material.material_id)
                if (cartIndex > -1) {
                    let oldqty = this.carts[cartIndex].quantity;
                    material.quantity = parseFloat(oldqty) + +parseFloat(material.quantity);
                    material.total = parseFloat(material.price * material.quantity).toFixed(2);
                    this.carts.splice(cartIndex, 1)
                }

                this.carts.unshift(material)
                this.clearMaterial();
            },

            removeCart(material) {
                let findIndex = this.carts.findIndex(prod => prod.material == material.material);
                this.carts.splice(findIndex, 1);
            },

            clearMaterial() {
                this.selectedMaterial = {
                    id: '',
                    name: '',
                    price: 0,
                    total: 0
                }
            },

            getMenu() {
                axios.get("/get-menu")
                    .then(res => {
                        let r = res.data;
                        this.menus = r.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                    })
            },

            saveMenu(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.menu.id);
                formdata.append('menu_category_id', this.selectedCategory != null ? this.selectedCategory.id : '');
                formdata.append('unit_id', this.selectedUnit != null ? this.selectedUnit.id : '');
                formdata.append('image', this.menu.image);
                formdata.append('materials', JSON.stringify(this.carts));
                var url;
                if (this.menu.id == '') {
                    url = '/menu';
                } else {
                    url = '/update-menu';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data.message);
                        this.getMenu();
                        this.clearForm();
                        this.menu.code = res.data.code;
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
                this.carts = [];
                this.btnText = "Update";
                let keys = Object.keys(this.menu);
                keys.forEach(key => {
                    this.menu[key] = row[key];
                });
                
                if (row.menu_category_id != null) {
                    this.selectedCategory = {
                        id: row.menu_category_id,
                        name: row.category_name
                    }
                }
                if (row.unit_id != null) {
                    this.selectedUnit = {
                        id: row.unit_id,
                        name: row.unit_name
                    }
                }

                if(row.recipes.length > 0) {
                    row.recipes.forEach(item => {
                        let material = {
                            material_id: item.material_id,
                            name: item.material_name,
                            price: item.price,
                            quantity: item.quantity,
                            total: item.total
                        }
                        this.carts.push(material);
                    });
                }


                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-menu", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getMenu();
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

            updateStatus(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/update-status", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getMenu();
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
                this.menu = {
                    id: "",
                    code: "{{ generateCode('Menu', 'M') }}",
                    name: "",
                    menu_category_id: "",
                    unit_id: "",
                    vat: 0,
                    sale_rate: 0,
                    image: ""
                }
                this.selectedCategory = null;
                this.selectedUnit = null;
                this.imageSrc = "/noImage.gif";
                this.carts = [];
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
                            this.menu.image = new File([resizedImage], event.target.files[0].name, {
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
                        if (this.url == '/menu-category') {
                            this.getCategory();
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