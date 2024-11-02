@extends('master')
@section('title', 'Room Entry')
@section('breadcrumb_title', 'Room Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .roomImage {
        padding-right: 0;
    }

    .fa-barcode {
        border: 1px solid gray;
        border-radius: 3px;
        padding: 0px 3px;
        font-weight: 600;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .roomImage {
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
<div id="room">
    <form @submit.prevent="saveRoom">
        <div class="row" style="margin:0;">
            <div class="col-md-10 col-xs-12" style="padding: 0;">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Room Entry Form</legend>
                    <div class="control-group">
                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Room Code:</label>
                                <div class=" col-xs-8 col-md-7">
                                    <input type="text" class="form-control" name="code" v-model="room.code">
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
                                <label class="control-label col-xs-4 col-md-4">Category:<sup class="text-danger">*</sup> </label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="categories" style="margin: 0;" v-model="selectedCategory" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal('/category', 'Category Entry')" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">RoomType:<sup class="text-danger">*</sup> </label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="roomtypes" style="margin: 0;" v-model="selectedRoomType" label="name"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal('/roomtype', 'RoomType Entry')" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Room Name:<sup class="text-danger">*</sup></label>
                                <div class="col-xs-8 col-md-7">
                                    <input type="text" class="form-control" name="name" v-model="room.name" autocomplete="off" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Bed:<sup class="text-danger">*</sup></label>
                                <div class="col-xs-8 col-md-7">
                                    <input type="number" min="0" step="any" class="form-control" name="bed" v-model="room.bed">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">bath:<sup class="text-danger">*</sup></label>
                                <div class="col-xs-8 col-md-7">
                                    <input type="number" min="0" step="any" class="form-control" name="bath" v-model="room.bath">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-xs-4 col-md-4">Price:<sup class="text-danger">*</sup></label>
                                <div class="col-xs-8 col-md-7">
                                    <input type="number" min="0" step="any" class="form-control" name="price" v-model="room.price">
                                </div>
                            </div>
                            <div class="form-group clearfix" style="margin-bottom:5px;">
                                <div class="col-md-4 text-right no-padding-right">
                                </div>
                                <div class="col-md-3" style="display: flex;align-items: center;gap: 5px;">
                                    <input type="checkbox" id="status" name="status" v-model="room.status" true-value="a" false-value="p" style="width: 15px; height: 15px;margin: 3px 0px;">
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
            <div class="col-md-2 col-xs-12 roomImage">
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
                <datatable :columns="columns" :data="rooms" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr :style="{background: row.status == 'p' ? '#ffdb9a' : ''}" :title="row.status == 'p' ? 'Inactive' : ''">
                            <td>@{{ row.sl }}</td>
                            <td>@{{ row.code }}</td>
                            <td style="text-align: left;">@{{ row.name }}</td>
                            <td>@{{ row.floor_name }}</td>
                            <td>@{{ row.category_name }}</td>
                            <td>@{{ row.roomtype_name }}</td>
                            <td>@{{ row.bed }}</td>
                            <td>@{{ row.bath }}</td>
                            <td>@{{ row.price }}</td>
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
        el: '#room',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Room Code',
                        field: 'code',
                        align: 'center'
                    },
                    {
                        label: 'Room Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Floor Name',
                        field: 'floor_name',
                        align: 'center'
                    },
                    {
                        label: 'Category',
                        field: 'category_name',
                        align: 'center'
                    },
                    {
                        label: 'Type',
                        field: 'roomtype_name',
                        align: 'center'
                    },
                    {
                        label: 'Bed',
                        field: 'bed',
                        align: 'center'
                    },
                    {
                        label: 'Bath',
                        field: 'bath',
                        align: 'center'
                    },
                    {
                        label: 'Price',
                        field: 'price',
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

                room: {
                    id: "",
                    code: "{{generateCode('Room', 'R')}}",
                    name: "",
                    floor_id: "",
                    room_type_id: "",
                    bed: 0,
                    bath: 0,
                    price: 0,
                    status: "a",
                    image: "",
                },
                rooms: [],

                floors: [],
                selectedFloor: null,
                categories: [],
                selectedCategory: null,
                roomtypes: [],
                selectedRoomType: null,

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
            this.getCategory();
            this.getRoomType();
            this.getRoom();
        },

        methods: {
            getFloor() {
                axios.get("/get-floor")
                    .then(res => {
                        this.floors = res.data
                    })
            },
            getCategory() {
                axios.get("/get-category")
                    .then(res => {
                        this.categories = res.data
                    })
            },
            getRoomType() {
                axios.get("/get-roomtype")
                    .then(res => {
                        this.roomtypes = res.data
                    })
            },
            getRoom() {
                axios.get("/get-room")
                    .then(res => {
                        let r = res.data;
                        this.rooms = r.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                    })
            },

            saveRoom(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.room.id);
                formdata.append('status', this.room.status);
                formdata.append('floor_id', this.selectedFloor != null ? this.selectedFloor.id : '');
                formdata.append('category_id', this.selectedCategory != null ? this.selectedCategory.id : '');
                formdata.append('room_type_id', this.selectedRoomType != null ? this.selectedRoomType.id : '');
                formdata.append('image', this.room.image);
                var url;
                if (this.room.id == '') {
                    url = '/room';
                } else {
                    url = '/update-room';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data.message);
                        this.getRoom();
                        this.clearForm();
                        this.room.code = res.data.code;
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
                let keys = Object.keys(this.room);
                keys.forEach(key => {
                    this.room[key] = row[key];
                });
                if (row.floor_id != null) {
                    this.selectedFloor = {
                        id: row.floor_id,
                        name: row.floor_name
                    }
                }
                if (row.category_id != null) {
                    this.selectedCategory = {
                        id: row.category_id,
                        name: row.category_name
                    }
                }
                if (row.room_type_id != null) {
                    this.selectedRoomType = {
                        id: row.room_type_id,
                        name: row.roomtype_name
                    }
                }

                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-room", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getRoom();
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
                this.room = {
                    id: "",
                    code: "{{generateCode('Room', 'R')}}",
                    name: "",
                    floor_id: "",
                    room_type_id: "",
                    bed: 0,
                    bath: 0,
                    price: 0,
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
                            this.room.image = new File([resizedImage], event.target.files[0].name, {
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
                        if (this.url == '/floor') {
                            this.getFloor();
                        }
                        if (this.url == '/roomtype') {
                            this.getRoomType();
                        }
                        if (this.url == '/category') {
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