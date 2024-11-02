@extends('master')
@section('title', 'Management Entry')
@section('breadcrumb_title', 'Management Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .management {
        padding-left: 0;
    }

    .managementImage {
        padding-right: 0;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .management {
            padding: 0;
        }

        .managementImage {
            padding: 0;
        }
    }

    .ImageBackground .imageShow {
        display: block;
        height: 75px;
        width: 85px;
        border: 1px solid #cccccc;
        box-sizing: border-box;
        margin-bottom: 5px;
    }
</style>
@endpush
@section('content')
<div id="management">
    <form @submit.prevent="saveManagement">
        <div class="row" style="margin:0;">
            <div class="col-md-10 management">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Management Entry Form</legend>
                    <div class="control-group">
                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Code:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="code" autocomplete="off" v-model="management.code">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Name:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="name" autocomplete="off" v-model="management.name">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Address:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="address" autocomplete="off" v-model="management.address">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4 col-xs-12">Designation:</label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="designations" style="margin: 0;" v-model="selectedDesignation" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Phone:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="phone" autocomplete="off" v-model="management.phone">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Email:</label>
                                <div class="col-md-7">
                                    <input type="email" class="form-control" name="email" autocomplete="off" v-model="management.email">
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
            <div class="col-md-2 managementImage">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 146px;">
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
                <datatable :columns="columns" :data="managements" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.sl }}</td>
                            <td>
                                <img :src="`/${row.image ? row.image : 'noImage.gif'}`" style="width: 40px; border: 1px solid gray; border-radius: 4px; padding: 1px;">
                            </td>
                            <td>@{{ row.code }}</td>
                            <td>@{{ row.name }}</td>
                            <td>@{{ row.phone }}</td>
                            <td>@{{ row.designation ? row.designation.name : '--' }}</td>
                            <td>@{{ row.address }}</td>
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
        el: '#management',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Image',
                        field: 'image',
                        align: 'center'
                    },
                    {
                        label: 'Code',
                        field: 'code',
                        align: 'center'
                    },
                    {
                        label: 'Management Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Phone',
                        field: 'phone',
                        align: 'center'
                    },
                    {
                        label: 'Designation',
                        field: 'designation.name',
                        align: 'center'
                    },
                    {
                        label: 'Address',
                        field: 'address',
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

                management: {
                    id: "",
                    code: "{{generateCode('Manage', 'M')}}",
                    name: "",
                    phone: "",
                    email: "",
                    address: "",
                    designation_id: "",
                    image: "",
                },
                managements: [],

                designations: [],
                selectedDesignation: null,

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
            this.getDesignation();
            this.getManagement();
        },

        methods: {
            getDesignation() {
                axios.get("/get-designation")
                    .then(res => {
                        this.designations = res.data;
                    })
            },
            getManagement() {
                axios.get("/get-management")
                    .then(res => {
                        let r = res.data;
                        this.managements = r.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                        this.management.code = "{{generateCode('manage', 'M')}}";
                    })
            },

            saveManagement(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.management.id);
                formdata.append('designation_id', this.selectedDesignation != null ? this.selectedDesignation.id : '');
                formdata.append('image', this.management.image);
                var url;
                if (this.management.id == '') {
                    url = '/management';
                } else {
                    url = '/update-management';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data);
                        this.clearForm();
                        this.getManagement();
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
                let keys = Object.keys(this.management);
                keys.forEach(key => {
                    this.management[key] = row[key];
                });

                this.selectedDesignation = {
                    id: row.designation_id,
                    name: row.designation != null ? row.designation.name : ''
                }
                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-management", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getManagement();
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
                this.management = {
                    id: "",
                    code: "{{generateCode('Manage', 'M')}}",
                    name: "",
                    phone: "",
                    email: "",
                    address: "",
                    designation_id: "",
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
                            this.management.image = new File([resizedImage], event.target.files[0].name, {
                                type: resizedImage.type
                            });
                        }
                    }
                } else {
                    event.target.value = '';
                }
            },

            openModal() {
                this.modalHead = 'Designation Entry';
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
                url = '/designation';
                axios.post(url, this.modalData)
                    .then(res => {
                        toastr.success(res.data);
                        this.getDesignation();
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