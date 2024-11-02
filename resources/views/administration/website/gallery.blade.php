@extends('master')
@section('title', 'Gallery Entry')
@section('breadcrumb_title', 'Gallery Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .gallery {
        padding-left: 0;
    }

    .galleryImage {
        padding-right: 0;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .gallery {
            padding: 0;
        }

        .galleryImage {
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
<div id="gallery">
    <form @submit.prevent="saveGallery">
        <div class="row" style="margin:0;">
            <div class="col-md-10 gallery">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 155px;">
                    <legend class="scheduler-border">Gallery Entry Form</legend>
                    <div class="control-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-8" style="padding: 0;margin-top: 30px;">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Title:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="title" autocomplete="off" v-model="gallery.title">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Image Type:</label>
                                <div class="col-md-7">
                                    <label for="small"><input id="small" type="radio" name="type" autocomplete="off" v-model="gallery.type" value="small"> Small</label> 
                                    &nbsp; <label for="big"><input id="big" type="radio" name="type" autocomplete="off" v-model="gallery.type" value="big"> Big</label> 
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
                        <div class="col-md-2"></div>
                </fieldset>
            </div>
            <div class="col-md-2 galleryImage">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 155px;">
                    <legend class="scheduler-border">Image Upload</legend>
                    <div class="control-group">
                        <div class="form-group ImageBackground clearfix">
                            <span class="text-danger">@{{ gallery.type == 'small' ? '(370 X 215)' : '(370 X 460)' }}PX</span>
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
                <datatable :columns="columns" :data="gallerys" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.sl }}</td>
                            <td>
                                <img :src="`/${row.image ? row.image : 'noImage.gif'}`" style="width: 40px; border: 1px solid gray; border-radius: 4px; padding: 1px;">
                            </td>
                            <td>@{{ row.title }}</td>
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
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#gallery',
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
                        label: 'Title',
                        field: 'title',
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

                gallery: {
                    id: "",
                    title: "",
                    type: "small",
                    image: "",
                },
                gallerys: [],

                imageSrc: "/noImage.gif",
                onProgress: false,
                btnText: "Save",
            }
        },

        created() {
            this.getGallery();
        },

        methods: {
            getGallery() {
                axios.get("/get-gallery")
                    .then(res => {
                        let r = res.data;
                        this.gallerys = r.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                    })
            },

            saveGallery(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.gallery.id);
                formdata.append('image', this.gallery.image);
                var url;
                if (this.gallery.id == '') {
                    url = '/gallery';
                } else {
                    url = '/update-gallery';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data);
                        this.clearForm();
                        this.getGallery();
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
                let keys = Object.keys(this.gallery);
                keys.forEach(key => {
                    this.gallery[key] = row[key];
                });
                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-gallery", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getGallery();
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
                this.gallery = {
                    id: "",
                    title: "",
                    type: "small",
                    image: "",
                }
                this.imageSrc = "/noImage.gif"
            },

            imageUrl(event) {
                var WIDTH = '';
                var HEIGHT = '';
                if(this.gallery.type == 'small') {
                    WIDTH = 370;
                    HEIGHT = 215;
                } else {
                    WIDTH = 370;
                    HEIGHT = 460;
                }
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
                            this.gallery.image = new File([resizedImage], event.target.files[0].name, {
                                type: resizedImage.type
                            });
                        }
                    }
                } else {
                    event.target.value = '';
                }
            }
        },
    })
</script>
@endpush