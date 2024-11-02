@extends('master')
@section('title', 'Company Profile')
@section('breadcrumb_title', 'Company Profile')

@push('style')
    <style>
        .card .card-header {
            padding: 10px 15px;
        }
    </style>
@endpush

@section('content')
    <div id="companyProfile">
        <form @submit.prevent="updateProfile($event)">
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group ImageBackground clearfix">
                                <span class="text-danger">(150 X 150)PX</span>
                                <img :src="logoSrc" class="imageShow" />
                                <label for="logo">Upload Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control shadow-none"
                                    @change="logoUrl" />
                            </div>
                            <div class="form-group ImageBackground clearfix"
                                style="border-top: 2px solid gray;margin: 3px 0;">
                                <span class="text-danger">(100 X 100)PX</span>
                                <img :src="faviconSrc" class="imageShow" />
                                <label for="favicon">Upload Fav</label>
                                <input type="file" name="favicon" id="favicon" class="form-control shadow-none"
                                    @change="faviconUrl" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="header-title" style="margin: 0;">Company Profile Update</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-4" for="">Name:</label>
                                <div class="col-md-8">
                                    <input type="text" name="name" v-model="company.name" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="">Title:</label>
                                <div class="col-md-8">
                                    <input type="text" name="title" v-model="company.title" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="">Phone:</label>
                                <div class="col-md-8">
                                    <input type="text" name="phone" v-model="company.phone" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="">Email:</label>
                                <div class="col-md-8">
                                    <input type="text" name="email" v-model="company.email" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="">Address:</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" name="address" v-model="company.address"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="">Map Link:</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="map_link" v-model="company.map_link">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="">Facebook</label>
                                <div class="col-md-8">
                                    <input type="url" class="form-control" name="facebook" id="facebook" v-model="company.facebook">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="">Instagram</label>
                                <div class="col-md-8">
                                    <input type="url" class="form-control" name="instagram" id="instagram" v-model="company.instagram">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="">Twitter</label>
                                <div class="col-md-8">
                                    <input type="url" class="form-control" name="twitter" id="twitter" v-model="company.twitter">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="">Youtube</label>
                                <div class="col-md-8">
                                    <input type="url" class="form-control" name="youtube" id="youtube" v-model="company.youtube">
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary btn-padding">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        new Vue({
            el: '#companyProfile',
            data() {
                return {
                    company: {},
                    logoSrc: '/noImage.gif',
                    faviconSrc: '/noImage.gif'
                }
            },

            created() {
                this.getCompany();
            },

            methods: {
                getCompany() {
                    axios.get('/get-company')
                        .then(res => {
                            this.company = res.data;
                            this.logoSrc = this.company.logo ? '/' + this.company.logo : '/noImage.gif'
                            this.faviconSrc = this.company.favicon ? '/' + this.company.favicon : '/noImage.gif'
                        })
                },

                updateProfile(event) {
                    let formdata = new FormData(event.target);
                    axios.post("/update-company", formdata)
                        .then(res => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                            }
                        })
                },

                logoUrl(event) {
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
                                this.logoSrc = new_img_url;
                                const resizedImage = await new Promise(rs => canvas.toBlob(rs,
                                    'image/jpeg', 1))
                                this.company.logo = new File([resizedImage], event.target.files[0]
                                .name, {
                                    type: resizedImage.type
                                });
                            }
                        }
                    } else {
                        event.target.value = '';
                    }
                },
                faviconUrl(event) {
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
                                this.faviconSrc = new_img_url;
                                const resizedImage = await new Promise(rs => canvas.toBlob(rs,
                                    'image/jpeg', 1))
                                this.company.favicon = new File([resizedImage], event.target.files[0]
                                    .name, {
                                        type: resizedImage.type
                                    });
                            }
                        }
                    } else {
                        event.target.value = '';
                    }
                },
            },
        });
    </script>
@endpush
