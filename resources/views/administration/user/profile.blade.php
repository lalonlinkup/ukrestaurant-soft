@extends('master')
@section('title')
{{Auth::user()->name}}-Profile
@endsection
@section('breadcrumb_title')
{{Auth::user()->name}}-Profile
@endsection
@push('style')
<style scoped>
    .v-select .dropdown-toggle {
        padding: 0px;
        height: 26px !important;
    }

    .v-select .dropdown-menu {
        width: 350px !important;
        overflow-y: auto !important;
    }
</style>
@endpush
@section('content')
<div class="row" id="userProfile">
    <div class="col-xs-12">
        <div id="home" class="tab-pane in active">
            <form @submit.prevent="profileUpdate($event)">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 center">
                        <div class="form-group ImageBackground clearfix">
                            <div class="col-xs-12" style="display: flex;flex-direction:column;align-items:center;">
                                <img :src="imageSrc" class="imageShow" />
                                <label for="image">Upload Image</label>
                                <input type="file" id="image" class="form-control shadow-none" @change="imageUrl" />
                            </div>
                        </div>

                        <a class="btn btn-sm btn-block btn-success">
                            <!-- <i class="ace-icon fa fa-plus-circle bigger-120"></i> -->
                            <span class="bigger-110 text-capitalize">{{Auth::user()->name}}</span>
                        </a>

                        <a class="btn btn-sm btn-block btn-primary">
                            <i class="ace-icon fa fa-envelope-o bigger-110"></i>
                            <span class="bigger-110">Email: {{Auth::user()->email}}</span>
                        </a>
                    </div><!-- /.col -->

                    <div class="col-xs-12 col-sm-9">

                        <div class="profile-user-info">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Name </div>

                                <div class="profile-info-value">
                                    <span>{{Auth::user()->name}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Username </div>

                                <div class="profile-info-value">
                                    <span>{{Auth::user()->username}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> User Phone </div>

                                <div class="profile-info-value">
                                    <span>{{Auth::user()->phone}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> User Role </div>

                                <div class="profile-info-value">
                                    <span class="text-capitalize">{{Auth::user()->role}}</span>
                                </div>
                            </div>


                        </div>

                        <div class="hr hr-8 dotted"></div>
                        <div class="profile-user-info">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Email </div>

                                <div class="profile-info-value">
                                    <input type="email" name="email" class="form-control" value="{{Auth::user()->email}}" placeholder="Email" style="width: 30%;">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Current Password </div>

                                <div class="profile-info-value">
                                    <input type="password" name="current_password" class="form-control" placeholder="Current Password" style="width: 30%;">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> New Password </div>

                                <div class="profile-info-value">
                                    <input type="password" name="password" class="form-control" placeholder="New Password" style="width: 30%;">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Confirm Password </div>

                                <div class="profile-info-value">
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" style="width: 30%;">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> </div>

                                <div class="profile-info-value">
                                    <button type="submit" :disabled="onProgress" class="btn btn-sm btn-info" style="margin-left: 16%;">Save</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: "#userProfile",

        data() {
            return {
                filterdata: {},
                user: {
                    id: "{{Auth::user()->id}}",
                    password: "",
                    image: ''
                },

                imageSrc: "{{Auth::user()->image != null ? Auth::user()->image : '/no-userimage.png'}}",
                onProgress: false,
            }
        },

        methods: {
            profileUpdate(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.user.id);
                formdata.append('image', this.user.image);

                url = '/user-profile-update';

                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data);
                        setTimeout(() => {
                            location.reload();
                        }, 1000)
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
                            this.user.image = new File([resizedImage], event.target.files[0].name, {
                                type: resizedImage.type
                            });
                        }
                    }
                } else {
                    event.target.value = '';
                }
            },
        }
    })
</script>
@endpush