@extends('master')
@section('title', 'Service Head Entry')
@section('breadcrumb_title', 'Service Head Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }
</style>
@endpush
@section('content')
    <div id="ServiceHead">
        <form @submit.prevent="saveServiceHead">
            <div class="row" style="margin:0;">
                <div class="col-md-12 col-xs-12" style="padding: 0;">
                    <fieldset class="scheduler-border bg-of-skyblue">
                        <legend class="scheduler-border">Service Head Entry Form</legend>
                        <div class="control-group">
                            <div class="col-md-6" style="padding: 0;">
                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Head Code <sup
                                            class="text-danger">*</sup></label>
                                    <div class=" col-xs-8 col-md-7">
                                        <input type="text" class="form-control" name="code" v-model="head.code" readonly>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Head Name <sup class="text-danger">*</sup></label>
                                    <div class="col-xs-8 col-md-7">
                                        <input type="text" class="form-control" name="name" v-model="head.name" autocomplete="off" />
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-md-6" style="padding: 0;">
                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Amount </label>
                                    <div class="col-xs-8 col-md-7">
                                        <input type="number" min="0" step="any" class="form-control"
                                            name="amount" v-model="head.amount">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Vat(%) </label>
                                    <div class="col-xs-8 col-md-7">
                                        <input type="number" min="0" step="any" class="form-control"
                                            name="vat" v-model="head.vat">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="col-md-4"></label>
                                    <div class="col-md-7 text-right">
                                        @if (userAction('e'))
                                            <input type="button" class="btn btn-danger btn-reset" value="Reset"
                                                @click="clearForm">
                                            <button :disabled="onProgress" type="submit"
                                                class="btn btn-primary btn-padding" v-html="btnText"></button>
                                        @endif
                                    </div>
                                </div>
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
                    <datatable :columns="columns" :data="heads" :filter-by="filter"
                        style="margin-bottom: 5px;">
                        <template scope="{ row }">
                            <tr>
                                <td>@{{ row.sl }}</td>
                                <td>@{{ row.code }}</td>
                                <td>@{{ row.name }}</td>
                                <td>@{{ row.amount }}</td>
                                <td>@{{ row.vat }}</td>
                                <td>
                                    @if (userAction('u'))
                                        <i @click="editData(row)" class="fa fa-pencil"></i>
                                    @endif
                                    @if (userAction('d'))
                                        <i @click="deleteData(row.id)" class="fa fa-trash"></i>
                                    @endif
                                </td>
                            </tr>
                        </template>
                    </datatable>
                    <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"
                        style="margin-bottom: 50px;"></datatable-pager>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        new Vue({
            el: '#ServiceHead',
            data() {
                return {
                    columns: [{
                            label: 'Sl',
                            field: 'sl',
                            align: 'center',
                            filterable: false
                        },
                        {
                            label: 'Code',
                            field: 'code',
                            align: 'center'
                        },
                        {
                            label: 'Name',
                            field: 'name',
                            align: 'center'
                        },
                        {
                            label: 'Amount',
                            field: 'amount',
                            align: 'center'
                        },
                        {
                            label: 'Vat(%)',
                            field: 'vat',
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

                    head: {
                        id: "",
                        code: "{{ generateCode('ServiceHead', 'SH') }}",
                        name: "",
                        amount: 0,
                        vat: 0,
                    },
                    heads: [],
                    onProgress: false,
                    btnText: "Save",
                    userType: "{{ Auth::user()->role }}"
                }
            },

    
            created() {
                this.getServiceHead();
            },

            methods: {
                getServiceHead() {
                    axios.get("/get-service-head")
                        .then(res => {
                            let r = res.data;
                            this.heads = r.map((item, index) => {
                                item.sl = index + 1
                                return item;
                            });
                        })
                },

                saveServiceHead(event) {
                    var url;
                    if (this.head.id == '') {
                        url = '/service-head';
                    } else {
                        url = '/update-service-head';
                    }
                    this.onProgress = true
                    axios.post(url, this.head)
                        .then(res => {
                            toastr.success(res.data.message);
                            this.getServiceHead();
                            this.clearForm();
                            this.btnText = "Save";
                            this.onProgress = false;
                            this.head.code = res.data.code;
                        })
                        .catch(err => {
                            this.onProgress = false
                            var r = JSON.parse(err.request.response);
                            if (err.request.status == '422' && r.errors != undefined && typeof r.errors ==
                                'object') {
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
                    let keys = Object.keys(this.head);
                    keys.forEach(key => {
                        this.head[key] = row[key];
                    });
                },

                deleteData(rowId) {
                    let formdata = {
                        id: rowId
                    }
                    if (confirm("Are you sure !!")) {
                        axios.post("/delete-service-head", formdata)
                            .then(res => {
                                toastr.success(res.data)
                                this.getServiceHead();
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
                    this.head = {
                        id: "",
                        code: "{{ generateCode('ServiceHead', 'SH') }}",
                        name: "",
                        amount: 0,
                        vat: 0,
                    }
                },
            }
        })
    </script>
@endpush
