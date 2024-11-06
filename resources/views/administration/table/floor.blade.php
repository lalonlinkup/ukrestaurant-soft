@extends('master')
@section('title', 'Floor Entry')
@section('breadcrumb_title', 'Floor Entry')
@push('style')
<style>
    .floor{
        padding: 0;
    }
</style>
@endpush
@section('content')
<div id="floor">
    <div class="row" style="margin: 0;">
        <div class="col-md-12 floor">
            <form @submit.prevent="saveFloor">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Floor Entry Form</legend>
                    <div class="control-group">
                        <div class="col-xs-12 col-md-6 col-md-offset-3">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Floor Name:</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name" v-model="floor.name" autocomplete="off"/>
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
                    </div>
                </fieldset>
            </form>
        </div>
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
                <datatable :columns="columns" :data="floors" :filter-by="filter" style="margin-bottom: 5px;">
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
    new Vue({
        el: '#floor',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Floor Name',
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

                floor: {
                    id: "",
                    name: "",
                },
                floors: [],

                onProgress: false,
                btnText: "Save"
            }
        },

        created() {
            this.getFloor();
        },

        methods: {
            getFloor() {
                axios.post("/get-floor", {fromIndex: 'yes'})
                    .then(res => {
                        this.floors = res.data.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                    })
            },

            saveFloor(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.floor.id);

                var url;
                if (this.floor.id == '') {
                    url = '/floor';
                } else {
                    url = '/update-floor';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data.message);
                        this.getFloor();
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
                let keys = Object.keys(this.floor);
                keys.forEach(key => {
                    this.floor[key] = row[key];
                });
            },

            async deleteData(rowId) {
                let productCheck = await axios.post("/get-table", {
                        floorId: rowId
                    })
                    .then(res => {
                        return res.data.products
                    })
                if (productCheck.length > 0) {
                    toastr.error("Table found on this type, You can not delete");
                    return
                }
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-floor", formdata)
                        .then(res => {
                            toastr.success(res.data.message)
                            this.getFloor();
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
                this.floor = {
                    id: "",
                    name: "",
                }
            },
        },
    })
</script>
@endpush