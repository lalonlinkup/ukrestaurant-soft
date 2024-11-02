@extends('master')
@section('title', 'Guest Entry')
@section('breadcrumb_title', 'Guest Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .customer {
        padding-left: 0;
    }

    .customerImage {
        padding-right: 0;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .customer {
            padding: 0;
        }

        .customerImage {
            padding: 0;
        }
    }
</style>
@endpush
@section('content')
<div id="customer">
    <form @submit.prevent="saveCustomer">
        <div class="row" style="margin: 0;">
            <div class="col-md-10 customer">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Guest Entry Form</legend>
                    <div class="control-group">
                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Guest Code:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="code" v-model="customer.code" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Guest Name:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="name" v-model="customer.name" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Address:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="address" v-model="customer.address" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4 col-xs-12">Select Area:</label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="districts" style="margin: 0;" v-model="selectedDistrict" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 2px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4 col-xs-12">Reference:</label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 100%;">
                                        <v-select :options="references" style="margin: 0;" v-model="selectedReference" label="name"></v-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Gender:</label>
                                <div class="col-md-7">
                                    <select name="gender" class="form-control" style="border-radius: 4px;" id="gender" v-model="customer.gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Mobile:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="phone" v-model="customer.phone" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">E-mail:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="email" v-model="customer.email" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">NID:</label>
                                <div class="col-md-7">
                                    <input type="number" class="form-control" name="nid" v-model="customer.nid" autocomplete="off">
                                </div>
                            </div>


                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Previous Due:</label>
                                <div class="col-md-7">
                                    <input type="number" min="0" step="0.001" class="form-control" name="previous_due" v-model="customer.previous_due">
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
            <div class="col-md-2 customerImage">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 177px;">
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
                <datatable :columns="columns" :data="customers" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.sl }}</td>
                            <td>@{{ row.code }}</td>
                            <td>@{{ row.name }}</td>
                            <td>@{{ row.phone }}</td>
                            <td>@{{ row.nid }}</td>
                            <td style="text-transform: capitalize;">@{{ row.gender }}</td>
                            <td>@{{ row.reference ? row.reference?.name: '--' }}</td>
                            <td>@{{ row.district ? row.district?.name: '--' }}</td>
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
        el: '#customer',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Guest Code',
                        field: 'code',
                        align: 'center'
                    },
                    {
                        label: 'Guest Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Phone',
                        field: 'phone',
                        align: 'center'
                    },
                    {
                        label: 'NID',
                        field: 'nid',
                        align: 'center'
                    },
                    {
                        label: 'Gender',
                        field: 'gender',
                        align: 'center'
                    },
                    {
                        label: 'Reference',
                        field: 'reference.name',
                        align: 'center'
                    },
                    {
                        label: 'Area',
                        field: 'district',
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

                customer: {
                    id: "",
                    code: "",
                    name: "",
                    phone: "",
                    email: "",
                    nid: "",
                    gender: "",
                    address: "",
                    previous_due: 0,
                    district_id: "",
                    image: "",
                },
                customers: [],

                districts: [],
                selectedDistrict: null,
                references: [],
                selectedReference: null,

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
            this.getReference();
            this.getDistrict();
            this.getCustomer();
        },

        methods: {
            getReference() {
                axios.get("/get-reference")
                    .then(res => {
                        this.references = res.data;
                    })
            },
            getDistrict() {
                axios.get("/get-district")
                    .then(res => {
                        this.districts = res.data;
                    })
            },
            getCustomer() {
                axios.get("/get-customer")
                    .then(res => {
                        let r = res.data;
                        this.customers = r.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                        this.customer.code = "{{generateCode('Customer', 'C')}}";
                    })
            },

            saveCustomer(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.customer.id);
                formdata.append('district_id', this.selectedDistrict != null ? this.selectedDistrict.id : '');
                formdata.append('reference_id', this.selectedReference != null ? this.selectedReference.id : '');
                formdata.append('image', this.customer.image);
                var url;
                if (this.customer.id == '') {
                    url = '/customer';
                } else {
                    url = '/update-customer';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data);
                        this.clearForm();
                        this.getCustomer();
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
                let keys = Object.keys(this.customer);
                keys.forEach(key => {
                    this.customer[key] = row[key];
                });
                this.customer.owner_name = row.owner_name;
                this.customer.credit_limit = row.credit_limit;

                this.selectedDistrict = {
                    id: row.district_id,
                    name: row.district != null ? row.district.name : ''
                }
                this.selectedReference = {
                    id: row.reference_id,
                    name: row.reference != null ? row.reference.name : ''
                }
                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-customer", formdata)
                        .then(res => {
                            toastr.success(res.data.message)
                            this.getCustomer();
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
                this.customer = {
                    id: "",
                    code: "{{generateCode('Customer', 'C')}}",
                    name: "",
                    phone: "",
                    email: "",
                    nid: "",
                    gender: "",
                    address: "",
                    previous_due: 0,
                    district_id: "",
                    image: "",
                }
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
                            this.customer.image = new File([resizedImage], event.target.files[0].name, {
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