@extends('master')
@section('title', 'Unit Entry')
@section('breadcrumb_title', 'Unit Entry')
@push('style')
<style>
    .unit{
        padding: 0;
    }
</style>
@endpush
@section('content')
<div id="Unit">
    <div class="row" style="margin: 0;">
        <div class="col-md-12 unit">
            <form @submit.prevent="saveUnit">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Unit Entry Form</legend>
                    <div class="control-group">
                        <div class="col-xs-12 col-md-6 col-md-offset-3">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Unit Name:</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name" v-model="unit.name" autocomplete="off"/>
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
                <datatable :columns="columns" :data="units" :filter-by="filter" style="margin-bottom: 5px;">
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
        el: '#Unit',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Unit Name',
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

                unit: {
                    id: "",
                    name: "",
                },
                units: [],

                onProgress: false,
                btnText: "Save"
            }
        },

        created() {
            this.getUnit();
        },

        methods: {
            getUnit() {
                axios.get("/get-unit")
                    .then(res => {
                        this.units = res.data.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                    })
            },

            saveUnit(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.unit.id);

                var url;
                if (this.unit.id == '') {
                    url = '/unit';
                } else {
                    url = '/update-unit';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data.message);
                        this.getUnit();
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
                let keys = Object.keys(this.unit);
                keys.forEach(key => {
                    this.unit[key] = row[key];
                });
            },

            async deleteData(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-unit", formdata)
                        .then(res => {
                            toastr.success(res.data.message)
                            this.getUnit();
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
                this.unit = {
                    id: "",
                    name: "",
                }
            },
        },
    })
</script>
@endpush