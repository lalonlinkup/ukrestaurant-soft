@extends('master')
@section('title', 'User Entry')
@section('breadcrumb_title', 'User Entry')
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

    .fa-users {
        color: #6FB3E0;
        border: 1px solid gray;
        padding: 0 1px;
        border-radius: 4px;
    }

    .badge {
        padding: 0 5px !important;
    }

    .user, .userImage>fieldset {
        height: 188px;
    }
    .userImage{
        padding-right: 0;
    }
    
    @media (min-width: 320px) and (max-width: 620px) {
        .user, .userImage>fieldset {
            height: auto;
        }
        .userImage{
            padding: 0;
        }
    }
</style>
@endpush
@section('content')
<div id="user">
    <form @submit.prevent="saveUser">
        <div class="row" style="margin: 0;">
            <div class="col-md-10 col-xs-12" style="padding: 0;">
                <fieldset class="scheduler-border bg-of-skyblue user">
                    <legend class="scheduler-border">User Entry Form</legend>
                    <div class="control-group">
                        <div class="col-md-6 col-xs-12" style="padding: 0;">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4 col-xs-12 no-padding-right">User ID</label>
                                <div class="col-md-8 co-xs-12 no-padding-right">
                                    <input type="text" class="form-control" name="code" v-model="user.code" readonly>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4 col-xs-12 no-padding-right">Name</label>
                                <div class="col-md-8 co-xs-12 no-padding-right">
                                    <input type="text" class="form-control" name="name" v-model="user.name" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4 col-xs-12 no-padding-right">Phone</label>
                                <div class="col-md-8 co-xs-12 no-padding-right">
                                    <input type="text" class="form-control" name="phone" v-model="user.phone" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4 col-xs-12 no-padding-right">Email</label>
                                <div class="col-md-8 co-xs-12 no-padding-right">
                                    <input type="email" class="form-control" name="email" v-model="user.email" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12" style="padding: 0;">    
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4 col-xs-12 no-padding-right">Role</label>
                                <div class="col-md-8 co-xs-12 no-padding-right">
                                    <select name="role" id="role" v-model="user.role" style="border-radius:4px; height: 26px;margin-bottom: 5px;" class="form-select">
                                        <option value="">Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="manager">Manager</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group clearfix" style="margin-bottom: 5px;">
                                <label class="control-label col-md-4 col-xs-12 no-padding-right">User Name</label>
                                <div class="col-md-8 co-xs-12 no-padding-right">
                                    <input type="text" style="margin-bottom:1px;" class="form-control" id="username" @input="checkUser" name="username" v-model="user.username" autocomplete="off">
                                    <i><small v-if="statusTxt != ''" v-html="statusTxt" :style="{color: color}"></small></i>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4 col-xs-12 no-padding-right">Password</label>
                                <div class="col-md-8 co-xs-12 no-padding-right">
                                    <input type="password" class="form-control" name="password" v-model="user.password" autocomplete="off">
                                </div>
                            </div>
                            @if(userAction('e'))
                            <div class="form-group clearfix">
                                <div class="col-md-12 co-xs-12 text-right no-padding-right">
                                    <hr style="margin: 0px;">
                                    <button type="submit" class="btn btn-danger btn-padding" style="margin-top: 5px;">Cancel</button>
                                    <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" style="margin-top: 5px;" v-html="btnText"></button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-2 col-xs-12 userImage">
                <fieldset class="scheduler-border bg-of-skyblue">
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
                <datatable :columns="columns" :data="users" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr @dblclick="statusChange(row)" :style="{background: row.status == 'p' ? '#ffc4419c' : ''}">
                            <td>@{{ row.code }}</td>
                            <td>@{{ row.name }}</td>
                            <td>@{{ row.username }}</td>
                            <td>@{{ row.phone }}</td>
                            <td>@{{ row.email }}</td>
                            <td>
                                <span :style="{background: colorPick(row)}" class="badge text-capitalize">@{{row.role}}</span>
                            </td>
                            <td>
                                <span v-if="row.status == 'a'">
                                    <span v-if="row.role != 'Superadmin' && row.role != 'admin'">
                                        @if(userAction('u'))
                                        <a v-if="row.role != 'Superadmin' && row.role != 'admin'" :href="`/user-access/${row.id}`"><i class="fa fa-users"></i></a>
                                        @endif
                                        @if(userAction('u'))
                                        <i @click="editData(row)" class="fa fa-pencil"></i>
                                        @endif
                                        @if(userAction('d'))
                                        <i @click="deleteData(row.id)" class="fa fa-trash"></i>
                                        @endif
                                    </span>
                                    @if(Auth::user()->id == 1)
                                    <span v-if="row.role == 'admin'">
                                        @if(userAction('u'))
                                        <i @click="editData(row)" class="fa fa-pencil"></i>
                                        @endif
                                        @if(userAction('d'))
                                        <i @click="deleteData(row.id)" class="fa fa-trash"></i>
                                        @endif
                                    </span>
                                    @endif
                                </span>
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
        el: "#user",

        data() {
            return {
                filterdata: {},
                user: {
                    id: "",
                    code: "",
                    name: "",
                    username: "",
                    email: "",
                    password: "",
                    phone: "",
                    role: "",
                    image: ''
                },
                users: [],

                columns: [{
                        label: 'Sl',
                        field: 'code',
                        align: 'center'
                    },
                    {
                        label: 'Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Username',
                        field: 'username',
                        align: 'center'
                    },
                    {
                        label: 'Phone',
                        field: 'phone',
                        align: 'center'
                    },
                    {
                        label: 'Email',
                        field: 'email',
                        align: 'center'
                    },
                    {
                        label: 'Role',
                        field: 'role',
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

                imageSrc: "/noImage.gif",
                onProgress: false,
                btnText: 'Save',
                statusTxt: '',
                color: '',
            }
        },

        async created() {
            await this.getUser();
        },

        methods: {
            colorPick(user) {
                var bg;
                if (user.role == 'admin') {
                    bg = '#20bd6c';
                } else if (user.role == 'manager') {
                    bg = 'orange';
                } else if (user.role == 'user') {
                    bg = '#bd2093';
                } else if (user.role == 'Superadmin') {
                    bg = '#4287f5';
                }
                return bg;
            },
            getUser() {
                this.clearForm();
                this.filterdata.code = 'yes';
                axios.post('/get-user', this.filterdata)
                    .then(res => {
                        this.users = res.data.users;
                        this.user.code = res.data.code;
                    })
            },

            saveUser(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.user.id);
                formdata.append('image', this.user.image);

                let url = '/add-user';
                if (this.user.id != "") {
                    url = '/update-user';
                }

                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data.message);
                        this.getUser();
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
                let keys = Object.keys(this.user);
                keys.forEach(key => {
                    this.user[key] = row[key];
                });
                this.imageSrc = row.image != null ? row.image : '/noImage.gif';
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-user", formdata)
                        .then(res => {
                            toastr.success(res.data.message)
                            this.getUser();
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
            statusChange(row) {
                if(row.role == 'admin' || row.role == 'Superadmin'){
                    return;
                }
                let formdata = {
                    id: row.id,
                    status: row.status == 'a' ? 'p' : 'a'
                }
                let msg = row.status == 'a' ? "Are you sure want deactive this user ??" :"Are you sure want active this user ??";
                if (confirm(msg)) {
                    axios.post("/status-change", formdata)
                        .then(res => {
                            toastr.success(res.data.message)
                            this.getUser();
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
                this.user = {
                    id: "",
                    code: "",
                    name: "",
                    username: "",
                    email: "",
                    password: "",
                    phone: "",
                    role: "",
                    image: ''
                }
                this.imageSrc = '/noImage.gif'
                this.btnText = "Save";
                this.statusTxt = '';
                this.color = '';
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

            checkUser() {
                this.statusTxt = '';
                this.color = '';
                axios.post('/check-user', {
                        username: this.user.username
                    })
                    .then(res => {
                        if (this.user.username.trim() == '') {
                            return
                        }
                        if (res.data.status == 'false') {
                            this.statusTxt = 'Available';
                            this.color = 'green';
                        } else {
                            this.statusTxt = 'Unavaileable';
                            this.color = 'red';
                        }
                    })
            },
        }
    })
</script>
@endpush