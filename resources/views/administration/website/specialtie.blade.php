@extends('master')
@section('title', 'Specialtie Entry')
@section('breadcrumb_title', 'Specialtie Entry')
@push('style')
<style>
    .charCount {
        font-size: 12px;
        color: #555;
        float: right;
    }
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .slider {
        padding-left: 0;
    }

    .sliderImage {
        padding-right: 0;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .slider {
            padding: 0;
        }

        .sliderImage {
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
    .ImageBackground .bannerImageShow {
        display: block;
        height: 75px;
        width: 100%;
        border: 1px solid #cccccc;
        box-sizing: border-box;
        margin-bottom: 5px;
    }
</style>
@endpush
@section('content')
<div id="specialtie">
    
        <div class="row" style="margin:0;">
            <form @submit.prevent="saveSpecialtie">
                <div class="col-md-9 slider">
                    <fieldset class="scheduler-border bg-of-skyblue" style="height: 155px;">
                        <legend class="scheduler-border">Specialtie Entry Form</legend>
                        <div class="control-group">
                            <div class="col-md-2 sliderImage">
                                <div class="form-group ImageBackground clearfix">
                                    <span class="text-danger">(275 X 280) PX</span>
                                    <img :src="imageSrc" class="imageShow" />
                                    <label for="image">Upload Image</label>
                                    <input type="file" id="image" class="form-control shadow-none" @change="imageUrl" />
                                </div>
                            </div>
                            <div class="col-md-4" style="padding: 0;margin-top: 20px;">
                                <div class="form-group clearfix">
                                    <label class="control-label col-md-3">Title</label>
                                    <div class="col-md-9">
                                        <input name="title" class="form-control" id="title" v-model="specialtie.title">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-md-3">Price</label>
                                    <div class="col-md-9">
                                        <input name="price" class="form-control" id="price" v-model="specialtie.price">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-6" style="padding: 0;margin-top: 20px;">
                                <div class="form-group clearfix">
                                    <label class="control-label col-md-3">Description</label>
                                    <div class="col-md-9">
                                        <textarea name="description" class="form-control" @input=" " id="description" cols="2" rows="2" v-model="specialtie.description"></textarea>
                                        <p class="charCount">@{{ charsRemaining }} characters remaining</p>
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
                    </fieldset>
                </div>
            </form>

            <form @submit.prevent="updateSpecialtieBanner">
                <div class="col-md-3 sliderImage">
                    <fieldset class="scheduler-border bg-of-skyblue" style="height: 155px;">
                        <legend class="scheduler-border">Banner Image Upload</legend>
                        <div class="control-group">
                            <div class="form-group ImageBackground clearfix">
                                <span class="text-danger">(1600 X 670) PX</span>
                                <img :src="bannerImageSrc" class="bannerImageShow" />
                                <div style="display:flex; justify-content: space-between
                                ; width:100%;">
                                    <div class="image-upload-btn">
                                        <label style="display: inline-block" for="bannerimage">Upload Image</label>
                                        <input type="file" id="bannerimage"  class="form-control shadow-none" @change="bannerImageUrl" />
                                    </div>
                                    <div class="image-submit-button">
                                        <button :disabled="onProgress" style="display: inline-block" type="submit" class="btn btn-primary btn-padding">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>
   

    <div class="row">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="specialties" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.sl }}</td>
                            <td>
                                <img :src="`/${row.image ? row.image : 'noImage.gif'}`" style="width: 40px; border: 1px solid gray; border-radius: 4px; padding: 1px;">
                            </td>
                            <td>@{{ row.title }}</td>
                            <td>@{{ row.price }}</td>
                            <td>@{{ row.description }}</td>
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
        el: '#specialtie',
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
                        label: 'Price',
                        field: 'price',
                        align: 'center'
                    },
                    {
                        label: 'Description',
                        field: 'description',
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

                specialtie: {
                    id: "",
                    title: "",
                    price: "",
                    description: "",
                    image: "",
                },
                specialties: [],

                imageSrc: "/noImage.gif",
                bannerImageSrc: "/noImage.gif",
                onProgress: false,
                btnText: "Save",
                maxChars: 120, 

                specialtieBanner : {
                    image: "",
                }
            }
        },


        created() {
            this.getSpecialtie();
        },

        computed: {
            charsRemaining() {
                return this.maxChars - this.specialtie.description.length;
            },
        },

        methods: {
            getSpecialtie() {
                axios.get("/get-specialties")
                    .then(res => {
                        let r = res.data.specialtie;
                        let b = res.data.banner;
                        this.specialties = r.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                        this.bannerImageSrc = b.image != null ? "/" + b.image : "/noImage.gif";
                    })
            },

            updateSpecialtieBanner(event) {
                let formdata = new FormData(event.target);
                formdata.append('image', this.specialtieBanner.image);

                var url = '/update-banner-specialties';

                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data);
                        this.clearForm();
                        this.getSpecialtie();
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

            saveSpecialtie(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.specialtie.id);
                formdata.append('image', this.specialtie.image);
                var url;
                if (this.specialtie.id == '') {
                    url = '/store-specialties';
                } else {
                    url = '/update-specialties';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data);
                        this.clearForm();
                        this.getSpecialtie();
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
                let keys = Object.keys(this.specialtie);
                keys.forEach(key => {
                    this.specialtie[key] = row[key];
                });
                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-specialties", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getSpecialtie();
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
                this.specialtie = {
                    id: "",
                    title: "",
                    price: "",
                    description: "",
                    image: "",
                }
                this.imageSrc = "/noImage.gif"
            },

            imageUrl(event) {
                const WIDTH = 275;
                const HEIGHT = 280;
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
                            this.specialtie.image = new File([resizedImage], file.name, {
                                type: resizedImage.type
                            });
                        }
                    }
                } else {
                    event.target.value = '';
                }
            },

            bannerImageUrl(event) {
                const WIDTH = 1600;
                const HEIGHT = 670;
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
                            this.bannerImageSrc = new_img_url;
                            const resizedImage = await new Promise(rs => canvas.toBlob(rs, 'image/jpeg', 1));
                            this.specialtieBanner.image = new File([resizedImage], file.name, {
                                type: resizedImage.type
                            });
                        }
                    }
                } else {
                    event.target.value = '';
                }
            },

            characterCheck() {
                if (this.specialtie.description.length > this.maxChars) {
                    this.specialtie.description = this.specialtie.description.substring(0, this.maxChars);
                }
            },

        },
    })
</script>
@endpush