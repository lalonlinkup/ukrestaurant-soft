@extends('master')
@section('title', 'Reference Entry')
@section('breadcrumb_title', 'Reference Entry')
@push('style')
<style>
    .table {
        margin-bottom: 5px;
    }
</style>
@endpush
@section('content')
<div id="Reference">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <fieldset class="scheduler-border bg-of-skyblue">
                <legend class="scheduler-border">Reference Entry Form</legend>
                <div class="control-group">
                    <form @submit.prevent="saveReference">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 no-padding-right">Ref. ID <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="reference.code" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 no-padding-right">Name <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="reference.name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 no-padding-right">Phone <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="reference.phone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 no-padding-right">E-mail</label>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" v-model="reference.email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 no-padding-right">Address</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="reference.address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 no-padding-right">Note</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" v-model="reference.note" cols="1" rows="1"></textarea>
                                    </div>
                                </div>
                                @if(userAction('e'))
                                <div class="form-group">
                                    <div class="col-md-12" style="text-align: right">
                                        <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-sm-12 co-xs-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12 co-xs-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="references" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.sl }}</td>
                            <td>@{{ row.code }}</td>
                            <td>@{{ row.name }}</td>
                            <td>@{{ row.phone }}</td>
                            <td>@{{ row.email }}</td>
                            <td>@{{ row.address }}</td>
                            <td>@{{ row.note }}</td>
                            <td>
                                @if(userAction('u'))
                                <i @click="editReference(row)" class="fa fa-pencil"></i>
                                @endif
                                @if(userAction('d'))
                                <i @click="deleteReference(row.id)" class="fa fa-trash"></i>
                                @endif
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    var Reference = new Vue({
        el: "#Reference",

        data() {
            return {
                reference: {
                    id: null,
                    code: "{{ $code }}",
                    name: '',
                    email: '',
                    phone: '',
                    address: ''
                },
                references: [],

                onProgress: false,
                btnText: "Save",

                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Ref. ID',
                        field: 'code',
                        align: 'center'
                    },
                    {
                        label: 'Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Phone',
                        field: 'phone',
                        align: 'center'
                    },
                    {
                        label: 'E-mail',
                        field: 'email',
                        align: 'center'
                    },
                    {
                        label: 'Address',
                        field: 'address',
                        align: 'center'
                    },
                    {
                        label: 'Note',
                        field: 'note',
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
            }
        },

        created() {
            this.getReference();
        },

        methods: {
            getReference() {
                axios.get("/get-reference")
                    .then(res => {
                        this.references = res.data.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                    })
            },

            saveReference() {
                var url = '/add-reference';
                if (this.reference.id != null) {
                    url = '/update-reference';
                }

                this.onProgress = true
                axios.post(url, this.reference)
                    .then(res => {
                        toastr.success(res.data.message);
                        this.getReference();
                        this.clearForm();
                        this.reference.code = res.data.code;
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

            clearForm() {
                this.reference = {
                    id: null,
                    code: "{{ $code }}",
                    name: '',
                    phone: '',
                    email: '',
                    address: ''
                }
            },

            editReference(row) {
                this.btnText = "Update";
                let keys = Object.keys(this.reference);
                keys.forEach(key => {
                    this.reference[key] = row[key];
                });
            },

            deleteReference(id) {
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-reference", {
                            id: id
                        })
                        .then(res => {
                            toastr.success(res.data)
                            this.getReference();
                        })
                        .catch(err => {
                            var r = JSON.parse(err.request.response);
                            if (r.errors != undefined) {
                                console.log(r.errors);
                            }
                            toastr.error(r.message);
                        })
                }
            }
        }
    })
</script>
@endpush