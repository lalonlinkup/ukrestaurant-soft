@extends('master')
@section('title', 'Table Entry')
@section('breadcrumb_title', 'Table Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .tableImage {
        padding-right: 0;
    }

    .fa-barcode {
        border: 1px solid gray;
        border-radius: 3px;
        padding: 0px 3px;
        font-weight: 600;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .tableImage {
            padding: 0;
        }
    }

    .ImageBackground .imageShow {
        display: block;
        height: 90px;
        width: 100px;
        border: 1px solid #cccccc;
        box-sizing: border-box;
        margin-bottom: 5px;
    }
</style>
@endpush
@section('content')
<div id="tableForm">
    <form @submit.prevent="saveTable">
        <div class="row" style="margin:0;">
            <div class="col-md-10 col-xs-12" style="padding: 0;">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Table Entry Form</legend>
                    <div class="control-group">
                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Table Code:</label>
                                <div class=" col-xs-8 col-md-7">
                                    <input type="text" class="form-control" name="code" v-model="table.code">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Floor:<sup class="text-danger">*</sup> </label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="floors" style="margin: 0;" v-model="selectedFloor" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal('/floor', 'Floor Entry')" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Table Type:<sup class="text-danger">*</sup> </label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="tabletypes" style="margin: 0;" v-model="selectedTableType" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal('/tabletype', 'Table Type Entry')" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Table Name:<sup class="text-danger">*</sup></label>
                                <div class="col-xs-8 col-md-7">
                                    <input type="text" class="form-control" name="name" v-model="table.name" autocomplete="off" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Incharge:<sup class="text-danger">*</sup> </label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="incharges" style="margin: 0;" v-model="selectedIncharge" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <a href="/employee" title="Add New Incharge" class="btn btn-xs btn-danger" style="width: 100%;height: 23px;border: 0px;border-radius: 3px;" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Capacity:<sup class="text-danger">*</sup></label>
                                <div class="col-xs-8 col-md-7">
                                    <input type="number" min="1" class="form-control" name="capacity" v-model="table.capacity">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Location:</label>
                                <div class="col-xs-8 col-md-7">
                                    <input type="text" class="form-control" name="location" v-model="table.location">
                                </div>
                            </div>
                            <div class="form-group clearfix" style="margin-bottom:5px;">
                                <div class="col-md-4 text-right no-padding-right">
                                </div>
                                <div class="col-md-3" style="display: flex;align-items: center;gap: 5px;">
                                    <input type="checkbox" id="status" name="status" v-model="table.status" true-value="a" false-value="p" style="width: 15px; height: 15px;margin: 3px 0px;">
                                    <label for="status" style="margin: 0;cursor:pointer;" class="control-label">Is Active</label>
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
            <div class="col-md-2 col-xs-12 tableImage">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 170px;">
                    <legend class="scheduler-border">Image Upload</legend>
                    <div class="control-group">
                        <div class="form-group ImageBackground clearfix">
                            <span class="text-danger">(600 X 600)PX</span>
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
                <datatable :columns="columns" :data="tables" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr :style="{background: row.status == 'p' ? '#ffdb9a' : ''}" :title="row.status == 'p' ? 'Inactive' : ''">
                            <td>@{{ row.sl }}</td>
                            <td>@{{ row.code }}</td>
                            <td style="text-align: left;">@{{ row.name }}</td>
                            <td>@{{ row.floor_name }}</td>
                            <td>@{{ row.incharge_name }}</td>
                            <td>@{{ row.tabletype_name }}</td>
                            <td>@{{ row.capacity }}</td>
                            <td>@{{ row.location }}</td>
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
        el: '#tableForm',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Table Code',
                        field: 'code',
                        align: 'center'
                    },
                    {
                        label: 'Table Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Floor Name',
                        field: 'floor_name',
                        align: 'center'
                    },
                    {
                        label: 'Incharge',
                        field: 'incharge_name',
                        align: 'center'
                    },
                    {
                        label: 'Type',
                        field: 'tabletype_name',
                        align: 'center'
                    },
                    {
                        label: 'Capacity',
                        field: 'capacity',
                        align: 'center'
                    },
                    {
                        label: 'Location',
                        field: 'location',
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

                table: {
                    id: "",
                    code: "{{generateCode('Table', 'T')}}",
                    name: "",
                    floor_id: "",
                    incharge_id: "",
                    table_type_id: "",
                    capacity: "",
                    location: "",
                    status: "a",
                    image: "",
                },
                tables: [],

                floors: [],
                selectedFloor: null,
                incharges: [],
                selectedIncharge: null,
                tabletypes: [],
                selectedTableType: null,

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
            this.getFloor();
            this.getIncharges();
            this.getTableType();
            this.getTables();
        },

        methods: {
            getFloor() {
                axios.get("/get-floor").then(res => {
                    this.floors = res.data
                })
            },
            getIncharges() {
                axios.get("/get-employee").then(res => {
                    this.incharges = res.data
                })
            },
            getTableType() {
                axios.get("/get-tabletype").then(res => {
                    this.tabletypes = res.data
                })
            },
            getTables() {
                axios.get("/get-table").then(res => {
                    let r = res.data;
                    this.tables = r.map((item, index) => {
                        item.sl = index + 1
                        return item;
                    });
                })
            },
            saveTable(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.table.id);
                formdata.append('status', this.table.status);
                formdata.append('floor_id', this.selectedFloor != null ? this.selectedFloor.id : '');
                formdata.append('incharge_id', this.selectedIncharge != null ? this.selectedIncharge.id : '');
                formdata.append('table_type_id', this.selectedTableType != null ? this.selectedTableType.id : '');
                formdata.append('image', this.table.image);
                var url;
                if (this.table.id == '') {
                    url = '/table';
                } else {
                    url = '/update-table';
                }
                this.onProgress = true
                axios.post(url, formdata).then(res => {
                    toastr.success(res.data.message);
                    this.getTables();
                    this.clearForm();
                    this.table.code = res.data.code;
                    this.btnText = "Save";
                    this.onProgress = false
                }).catch(err => {
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
                let keys = Object.keys(this.table);
                keys.forEach(key => {
                    this.table[key] = row[key];
                });
                if (row.floor_id != null) {
                    this.selectedFloor = {
                        id: row.floor_id,
                        name: row.floor_name
                    }
                }
                if (row.incharge_id != null) {
                    this.selectedIncharge = {
                        id: row.incharge_id,
                        name: row.incharge_name
                    }
                }
                if (row.table_type_id != null) {
                    this.selectedTableType = {
                        id: row.table_type_id,
                        name: row.tabletype_name
                    }
                }

                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },
            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-table", formdata).then(res => {
                        toastr.success(res.data)
                        this.getTables();
                    }).catch(err => {
                        var r = JSON.parse(err.request.response);
                        if (r.errors != undefined) {
                            console.log(r.errors);
                        }
                        toastr.error(r.message);
                    })
                }
            },
            clearForm() {
                this.table = {
                    id: "",
                    code: "{{generateCode('Table', 'T')}}",
                    name: "",
                    floor_id: "",
                    incharge_id: "",
                    table_type_id: "",
                    capacity: "",
                    location: "",
                    status: "a",
                    image: "",
                }
                this.imageSrc = "/noImage.gif"
            },
            imageUrl(event) {
                const WIDTH = 600;
                const HEIGHT = 600;
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
                            this.table.image = new File([resizedImage], event.target.files[0].name, {
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
                };
                this.url = '';
            },
            addData() {
                axios.post(this.url, this.modalData).then(res => {
                    toastr.success(res.data.message);
                    if (this.url == '/floor') {
                        this.getFloor();
                    }
                    if (this.url == '/tabletype') {
                        this.getTableType();
                    }
                    this.resetModal();
                    $('#commonModal').modal('hide');
                }).catch(err => {
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
        }
    })
</script>
@endpush