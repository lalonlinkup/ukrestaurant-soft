@extends('master')
@section('title', 'Department Entry')
@section('breadcrumb_title', 'Department Entry')

@section('content')
<div id="department">
    <form @submit.prevent="saveDepartment">
        <div class="row" style="margin: 0;">
            <fieldset class="scheduler-border bg-of-skyblue">
                <legend class="scheduler-border">Department Entry</legend>
                <div class="control-group">
                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                        <div class="form-group clearfix">
                            <label class="control-label col-md-4">Department Name:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name" v-model="department.name">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-md-4"></label>
                            <div class="col-md-8 text-right">
                                @if(userAction('e'))
                                <button type="button" @click="clearForm" class="btn btn-danger btn-reset">Reset</button>
                                <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
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
                <datatable :columns="columns" :data="departments" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.sl }}</td>
                            <td>@{{ row.name }}</td>
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
    var cateogry = new Vue({
        el: '#department',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Department Name',
                        field: 'name',
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

                department: {
                    id: "",
                    name: "",
                },
                departments: [],

                onProgress: false,
                btnText: "Save"
            }
        },

        created() {
            this.getDepartment();
        },

        methods: {
            getDepartment() {
                axios.get("/get-department")
                    .then(res => {
                        this.departments = res.data.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                    })
            },

            saveDepartment() {
                var url;
                if (this.department.id == '') {
                    url = '/department';
                } else {
                    url = '/update-department';
                }
                this.onProgress = true
                axios.post(url, this.department)
                    .then(res => {
                        toastr.success(res.data);
                        this.getDepartment();
                        this.clearForm();
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
                let keys = Object.keys(this.department);
                keys.forEach(key => {
                    this.department[key] = row[key];
                });
            },

            deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-department", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getDepartment();
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
                this.department = {
                    id: "",
                    name: "",
                }
            },
        },
    })
</script>
@endpush