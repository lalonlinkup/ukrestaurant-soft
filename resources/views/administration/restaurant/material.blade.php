@extends('master')
@section('title', 'Material Entry')
@section('breadcrumb_title', 'Material Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .material {
        padding-left: 0;
    }

    .materialImage {
        padding-right: 0;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .material {
            padding: 0;
        }

        .materialImage {
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
<div id="material">
    <form @submit.prevent="saveMaterial">
        <div class="row" style="margin:0;">
            <div class="col-md-10 material">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 155px;">
                    <legend class="scheduler-border">Material Entry Form</legend>
                    <div class="control-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-3">Name</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" autocomplete="off" v-model="material.name">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-3">Unit</label>
                                <div class="col-md-9" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 90%;">
                                        <v-select :options="units" style="margin: 0;" v-model="selectedUnit" label="name"></v-select>
                                    </div>
                                    <div style="width: 9%;">
                                        <button type="button" @click="openModal('/unit', 'Unit Entry')" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-3">Price</label>
                                <div class="col-md-9">
                                    <input type="number" step="any" min="0" class="form-control" name="price" autocomplete="off" v-model="material.price">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-md-4"></label>
                                <div class="col-md-8 text-right">
                                    @if(userAction('e'))
                                    <input type="button" class="btn btn-danger btn-reset" value="Reset" @click="clearForm">
                                    <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                </fieldset>
            </div>
            <div class="col-md-2 materialImage">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 155px;">
                    <legend class="scheduler-border">Image Upload</legend>
                    <div class="control-group">
                        <div class="form-group ImageBackground clearfix">
                            <span class="text-danger">(1400 X 800) PX</span>
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
                <datatable :columns="columns" :data="materials" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.sl }}</td>
                            <td>@{{ row.name }}</td>
                            <td>@{{ row.price }}</td>
                            <td>@{{ row.unit_name }}</td>
                            <td>
                                <img :src="`/${row.image ? row.image : 'noImage.gif'}`" style="width: 40px; border: 1px solid gray; border-radius: 4px; padding: 1px;">
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
        el: '#material',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    
                    {
                        label: 'Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Price',
                        field: 'price',
                        align: 'center'
                    },
                    {
                        label: 'Unit Name',
                        field: 'unit_name',
                        align: 'center'
                    },
                    {
                        label: 'Image',
                        field: 'image',
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

                material: {
                    id: "",
                    name: "",
                    price: 0,
                    unit_id: null,
                    image: "",
                },
                materials: [],
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
            this.getUnits();
            this.getMaterial();
        },

        methods: {
            getUnits() {
                axios.get("/get-unit")
                    .then(res => {
                        this.units = res.data
                    })
            },

            getMaterial() {
                axios.get("/get-material")
                    .then(res => {
                        let r = res.data;
                        this.materials = r.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                    })
            },

            saveMaterial(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.material.id);
                formdata.append('unit_id', this.selectedUnit != null ? this.selectedUnit.id : null);
                formdata.append('image', this.material.image);
                var url;
                if (this.material.id == '') {
                    url = '/material';
                } else {
                    url = '/update-material';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data);
                        this.clearForm();
                        this.getMaterial();
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
                let keys = Object.keys(this.material);
                keys.forEach(key => {
                    this.material[key] = row[key];
                });
                this.selectedUnit = {
                    id: row.unit_id,
                    name: row.unit_name
                }
                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-material", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getMaterial();
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
                this.material = {
                    id: "",
                    name: "",
                    price: 0,
                    unit_id: null,
                    image: "",
                }
                this.selectedUnit = null;
                this.imageSrc = "/noImage.gif"
            },

            imageUrl(event) {
                const WIDTH = 200;
                const HEIGHT = 200;
                const allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];

                if (event.target.files[0]) {
                    const file = event.target.files[0];
                    
                    if (!allowedMimes.includes(file.type)) {
                        toastr.error('Invalid file type. Please select an image with one of the following types: jpeg, png, jpg, gif, svg.');
                        event.target.value = '';
                        return;
                    }

                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = (ev) => {
                        let img = new Image();
                        img.src = ev.target.result;
                        img.onload = async e => {
                            let canvas = document.createElement('canvas');
                            canvas.width = WIDTH;
                            canvas.height = HEIGHT;
                            const context = canvas.getContext("2d");
                            context.drawImage(img, 0, 0, canvas.width, canvas.height);
                            let new_img_url = context.canvas.toDataURL(file.type);
                            this.imageSrc = new_img_url;
                            const resizedImage = await new Promise(rs => canvas.toBlob(rs, 'image/jpeg', 1));
                            this.material.image = new File([resizedImage], file.name, {
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
            }
        },
    })
</script>
@endpush