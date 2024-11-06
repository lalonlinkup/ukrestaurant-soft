@extends('master')
@section('title', 'User Activity List')
@section('breadcrumb_title', 'User Activity List')
@push('style')
<style scoped>
    .v-select .dropdown-toggle {
        padding: 0px;
        height: 30px !important;
    }

    .v-select .dropdown-menu {
        width: 350px !important;
        overflow-y: auto !important;
    }
</style>
@endpush
@section('content')
<div id="productList">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">User Activity List</legend>
            <div class="control-group">
                <form @submit.prevent="getActivities">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group">
                            <v-select :options="users" v-model="selectedUser" label="display_name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-1 col-xs-12">
                        <div class="form-group">
                            <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>
    <div style="display:none;" v-bind:style="{display: activities.length > 0 && showReport ? '' : 'none'}">
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="" v-on:click.prevent="print">
                    <i class="fa fa-print"></i> Print
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" id="reportTable">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>
                                    <label for="allCheck"><input type="checkbox" id="allCheck" @change="checkAll" /> All</label>
                                </th>
                                <th>User Name</th>
                                <th>User Phone</th>
                                <th>User Type</th>
                                <th>Login Time</th>
                                <th>Logout Time</th>
                                <th>IP Address</th>
                                <th>Last Visited Page Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in activities">
                                <td style="text-align:center;">@{{ sl + 1 }}</td>
                                <td>
                                    <input type="checkbox" v-model="item.checkStatus" @change="singleCheck">
                                </td>
                                <td>@{{ item.user ? item.user.name: '--' }}</td>
                                <td>@{{ item.user ? item.user.phone: '--' }}</td>
                                <td>
                                    <span class="badge badge-success text-capitalize" v-html="item.user ? item.user.role: '--'"></span>
                                </td>
                                <td>@{{ item.login_time }}</td>
                                <td>@{{ item.logout_time }}</td>
                                <td>@{{ item.ip_address }}</td>
                                <td>@{{ item.page_name }}</td>
                            </tr>
                        </tbody>
                        <tfoot v-if="activities.filter(item => item.checkStatus == true).length > 0">
                            <tr>
                                <td colspan="9">
                                    <div class="form-group text-right">
                                        @if(Auth::user()->id == 1)
                                        <button type="button" @click="deleteActivity('soft')" class="btn btn-padding btn-info">SoftDelete</button>
                                        @endif
                                        <button type="button" @click="deleteActivity('hard')" class="btn btn-padding btn-danger">Delete Log</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div style="display:none;" v-bind:style="{display: showReport == false ? '' : 'none'}">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="{{asset('loading.gif')}}" style="width: 90px;"> Loading..
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#productList',
        data() {
            return {
                searchType: '',
                activities: [],
                users: [],
                selectedUser: null,

                onProgress: false,
                showReport: null,
            }
        },

        async created() {
            await this.getUser();
        },

        methods: {
            async getUser() {
                let filter = {};
                await axios.post('/get-user', filter)
                    .then(res => {
                        this.users = res.data.users.map(item => {
                            item.display_name = `${item.name} - ${item.code}`
                            return item;
                        })
                    })
            },
            getActivities() {
                let filter = {
                    userId: this.selectedUser != null ? this.selectedUser.id : ''
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-user-activity", filter)
                    .then(res => {
                        let r = res.data;
                        this.activities = r.map(item => {
                            item.checkStatus = false
                            return item;
                        })
                        this.onProgress = false
                        this.showReport = true
                    })
                    .catch(err => {
                        this.showReport = null
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

            deleteActivity(deleteStatus) {
                let data = this.activities.filter(item => item.checkStatus == true);
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-user-activity", {
                            activities: data,
                            deleteStatus: deleteStatus
                        })
                        .then(res => {
                            toastr.success(res.data)
                            this.getActivities();
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

            checkAll() {
                if (event.target.checked) {
                    this.activities = this.activities.map(item => {
                        item.checkStatus = true;
                        return item;
                    });
                } else {
                    this.activities = this.activities.map(item => {
                        item.checkStatus = false;
                        return item;
                    });
                }
            },

            singleCheck() {
                let checked = this.activities.filter(item => item.checkStatus == true).length;
                let unchecked = this.activities.length;
                if (checked == unchecked) {
                    $("#allCheck").prop('checked', true)
                } else {
                    $("#allCheck").prop('checked', false)
                }
            },

            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">User Activity List</h4>
                            </div>
                        </div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportTable').innerHTML}
							</div>
						</div>
					</div>
				`;

                var mywindow = window.open('', '', `width=${screen.width}, height=${screen.height}`);
                mywindow.document.write(`
                    @include('administration/reports/reportHeader')
				`);

                mywindow.document.body.innerHTML += reportContent;

                mywindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                mywindow.print();
                mywindow.close();
            }
        },
    })
</script>
@endpush