@extends('master')
@section('title', 'AboutPage Entry')
@section('breadcrumb_title', 'AboutPage Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .aboutpage {
        padding-left: 0;
    }

    .aboutpageImage {
        padding-right: 0;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .aboutpage {
            padding: 0;
        }

        .aboutpageImage {
            padding: 0;
        }
    }
</style>
@endpush
@section('content')
<div id="aboutpage">
    <form @submit.prevent="updateAbout">
        <div class="row" style="margin:0;">
            <div class="col-md-2 aboutpageImage">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Image Upload</legend>
                    <div class="control-group">
                        <div class="form-group ImageBackground clearfix">
                            <span class="text-danger">(600 X 400)PX</span>
                            <img :src="imageSrc" class="imageShow" />
                            <label for="image">Upload Image</label>
                            <input type="file" id="image" class="form-control shadow-none" @change="imageUrl" />
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-10">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Aboutpage Update Form</legend>
                    <div class="control-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-8" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label">Title:</label>
                                <input type="text" class="form-control" name="title" autocomplete="off" v-model="aboutpage.title">
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label">Short Description:</label>
                                <textarea class="form-control" name="short_description" v-model="aboutpage.short_description"></textarea>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label">Long Description:</label>
                                <textarea id="editor"></textarea>
                            </div>
                            <div class="form-group clearfix text-right" style="margin-top: 5px;">
                                @if(userAction('e'))
                                <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                </fieldset>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<script>
    let editor;
    $(document).ready(function() {
        ClassicEditor.create(document.querySelector('#editor'))
            .then(newEditor => {
                editor = newEditor;
            });
    });
    new Vue({
        el: '#aboutpage',
        data() {
            return {
                aboutpage: {
                    id: "",
                    title: "",
                    image: "",
                },
                aboutpages: [],

                imageSrc: "/noImage.gif",
                onProgress: false,
                btnText: "Update",
            }
        },

        created() {
            this.getAbout();
        },

        methods: {
            getAbout() {
                axios.get("/get-about")
                    .then(res => {
                        let r = res.data;
                        this.aboutpage = r;
                        this.imageSrc = r.image ? '/'+r.image : '/noImage.gif';
                        editor.setData(r.description);
                    })
            },

            updateAbout(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.aboutpage.id);
                formdata.append('image', this.aboutpage.image);
                formdata.append('short_description', this.aboutpage.short_description);
                formdata.append('description', editor.getData());
                var url = '/update-about';
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data);
                        this.getAbout();
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

            imageUrl(event) {
                const WIDTH = 600;
                const HEIGHT = 400;
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
                            this.aboutpage.image = new File([resizedImage], event.target.files[0].name, {
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