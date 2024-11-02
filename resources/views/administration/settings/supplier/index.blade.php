@extends('master')
@section('title', 'Supplier Entry')
@section('breadcrumb_title', 'Supplier Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .supplier {
        padding-left: 0;
    }

    .supplierImage {
        padding-right: 0;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .supplier {
            padding: 0;
        }

        .supplierImage {
            padding: 0;
        }
    }
</style>
@endpush
@section('content')
<div id="supplier">
    <form @submit.prevent="saveSupplier">
        <div class="row" style="margin:0;">
            <div class="col-md-10 supplier">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Supplier Entry Form</legend>
                    <div class="control-group">
                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Supplier Code:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="code" v-model="supplier.code">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Supplier Name:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="name" v-model="supplier.name">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Owner Name:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="owner_name" v-model="supplier.owner_name">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Address:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="address" v-model="supplier.address">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4 col-xs-12">Select Area:</label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="districts" style="margin: 0;" v-model="selectedDistrict" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Phone:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="phone" v-model="supplier.phone">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Mobile:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="office_phone" v-model="supplier.office_phone">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Contact Person:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="contact_person" v-model="supplier.contact_person">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Email:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="email" v-model="supplier.email">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Previous Due:</label>
                                <div class="col-md-7">
                                    <input type="number" min="0" step="0.001" class="form-control" name="previous_due" v-model="supplier.previous_due">
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
            <div class="col-md-2 supplierImage">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 202px;">
                    <legend class="scheduler-border">Image Upload</legend>
                    <div class="control-group">
                        <div class="form-group ImageBackground clearfix">
                            <span class="text-danger">(150 X 150)PX</span>
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
                <datatable :columns="columns" :data="suppliers" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.sl }}</td>
                            <td>@{{ row.code }}</td>
                            <td>@{{ row.name }}</td>
                            <td>@{{ row.owner_name }}</td>
                            <td>@{{ row.phone }}</td>
                            <td>@{{ row.district ? row.district.name : '--' }}</td>
                            <td>@{{ row.address }}</td>
                            <td>@{{ row.office_phone }}</td>
                            <td>@{{ row.email }}</td>
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
        el: '#supplier',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Supplier Code',
                        field: 'code',
                        align: 'center'
                    },
                    {
                        label: 'Supplier Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Owner Name',
                        field: 'owner_name',
                        align: 'center'
                    },
                    {
                        label: 'Phone',
                        field: 'phone',
                        align: 'center'
                    },
                    {
                        label: 'Area',
                        field: 'district',
                        align: 'center'
                    },
                    {
                        label: 'Address',
                        field: 'address',
                        align: 'center'
                    },
                    {
                        label: 'OfficePhone',
                        field: 'office_phone',
                        align: 'center'
                    },
                    {
                        label: 'Email',
                        field: 'email',
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

                supplier: {
                    id: "",
                    code: "",
                    name: "",
                    owner_name: "",
                    phone: "",
                    email: "",
                    office_phone: "",
                    contact_person: "",
                    address: "",
                    previous_due: 0,
                    district_id: "",
                    image: "",
                },
                suppliers: [],

                districts: [],
                selectedDistrict: null,

                imageSrc: "/noImage.gif",
                onProgress: false,
                btnText: "Save",

                modalHead: "",
                modalData: {
                    id: null,
                    name: ''
                }
            }
        },

        created() {
            this.getDistrict();
            this.getSupplier();
        },

        methods: {
            getDistrict() {
                axios.get("/get-district")
                    .then(res => {
                        this.districts = res.data;
                    })
            },
            getSupplier() {
                axios.get("/get-supplier")
                    .then(res => {
                        let r = res.data;
                        this.suppliers = r.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                        this.supplier.code = "{{generateCode('Supplier', 'S')}}";
                    })
            },

            saveSupplier(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.supplier.id);
                formdata.append('district_id', this.selectedDistrict != null ? this.selectedDistrict.id : '');
                formdata.append('image', this.supplier.image);
                var url;
                if (this.supplier.id == '') {
                    url = '/supplier';
                } else {
                    url = '/update-supplier';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data);
                        this.clearForm();
                        this.getSupplier();
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
                let keys = Object.keys(this.supplier);
                keys.forEach(key => {
                    this.supplier[key] = row[key];
                });

                this.selectedDistrict = {
                    id: row.district_id,
                    name: row.district != null ? row.district.name : ''
                }
                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-supplier", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getSupplier();
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
                this.supplier = {
                    id: "",
                    code: "{{generateCode('Supplier', 'S')}}",
                    name: "",
                    owner_name: "",
                    phone: "",
                    email: "",
                    office_phone: "",
                    contact_person: "",
                    address: "",
                    previous_due: 0,
                    district_id: "",
                    image: "",
                }
                this.selectedDistrict = null;
                this.imageSrc = "/noImage.gif"
            },

            imageUrl(event) {
                const WIDTH = 150;
                const HEIGHT = 150;
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
                            this.supplier.image = new File([resizedImage], event.target.files[0].name, {
                                type: resizedImage.type
                            });
                        }
                    }
                } else {
                    event.target.value = '';
                }
            },

            openModal() {
                this.modalHead = 'District Entry';
                $('#commonModal').modal('show');
            },
            resetModal() {
                this.modalHead = '';
                this.modalData = {
                    id: null,
                    name: ''
                }
            },
            addData() {
                url = '/district';
                axios.post(url, this.modalData)
                    .then(res => {
                        toastr.success(res.data);
                        this.getDistrict();
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