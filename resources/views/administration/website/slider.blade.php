@extends('master')
@section('title', 'Slider Entry')
@section('breadcrumb_title', 'Slider Entry')
@push('style')
<style>
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
</style>
@endpush
@section('content')
<div id="slider">
    <form @submit.prevent="saveSlider">
        <div class="row" style="margin:0;">
            <div class="col-md-10 slider">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 155px;">
                    <legend class="scheduler-border">Slider Entry Form</legend>
                    <div class="control-group">
                        <div class="col-md-6" style="padding: 0;margin-top: 20px;">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-3">Title</label>
                                <div class="col-md-9">
                                    <textarea name="title" class="form-control" required id="title" cols="2" rows="2" v-model="slider.title"></textarea>
                                </div>
                            </div>
                            {{-- <div class="form-group clearfix">
                                <label class="control-label col-md-3">Sub Title</label>
                                <div class="col-md-9">
                                    <textarea name="sub_title" class="form-control" required id="sub_title" cols="2" rows="2" v-model="slider.sub_title"></textarea>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md-6" style="padding: 0;margin-top: 20px;">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-3">Button Text</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required name="btn_text" autocomplete="off" v-model="slider.btn_text">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-3">Button Url</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required name="btn_url" autocomplete="off" v-model="slider.btn_url">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-md-4"></label>
                                <div class="col-md-8 text-right">
                                    @if(userAction('e'))
                                    <input type="button" required class="btn btn-danger btn-reset" value="Reset" @click="clearForm">
                                    <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                </fieldset>
            </div>
            <div class="col-md-2 sliderImage">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 155px;">
                    <legend class="scheduler-border">Image Upload</legend>
                    <div class="control-group">
                        <div class="form-group ImageBackground clearfix">
                            <span class="text-danger">(1600 X 590) PX</span>
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
                <datatable :columns="columns" :data="sliders" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.sl }}</td>
                            <td>
                                <img :src="`/${row.image ? row.image : 'noImage.gif'}`" style="width: 40px; border: 1px solid gray; border-radius: 4px; padding: 1px;">
                            </td>
                            <td>@{{ row.title }}</td>
                            {{-- <td>@{{ row.sub_title }}</td> --}}
                            <td>@{{ row.btn_text }}</td>
                            <td>@{{ row.btn_url }}</td>
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
        el: '#slider',
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
                    // {
                    //     label: 'Sub Title',
                    //     field: 'sub_title',
                    //     align: 'center'
                    // },
                    {
                        label: 'Button Text',
                        field: 'btn_text',
                        align: 'center'
                    },
                    {
                        label: 'Button URL',
                        field: 'btn_url',
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

                slider: {
                    id: "",
                    title: "",
                    sub_title: "",
                    btn_text: "",
                    btn_url: "",
                    image: "",
                },
                sliders: [],

                imageSrc: "/noImage.gif",
                onProgress: false,
                btnText: "Save",
            }
        },

        created() {
            this.getSlider();
        },

        methods: {
            getSlider() {
                axios.get("/get-slider")
                    .then(res => {
                        let r = res.data;
                        this.sliders = r.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                    })
            },

            saveSlider(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.slider.id);
                formdata.append('image', this.slider.image);
                var url;
                if (this.slider.id == '') {
                    url = '/slider';
                } else {
                    url = '/update-slider';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data);
                        this.clearForm();
                        this.getSlider();
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
                let keys = Object.keys(this.slider);
                keys.forEach(key => {
                    this.slider[key] = row[key];
                });
                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-slider", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getSlider();
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
                this.slider = {
                    id: "",
                    title: "",
                    sub_title: "",
                    btn_text: "",
                    btn_url: "",
                    image: "",
                }
                this.imageSrc = "/noImage.gif"
            },

            imageUrl(event) {
                const WIDTH = 1600;
                const HEIGHT = 590;
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
                            this.slider.image = new File([resizedImage], file.name, {
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