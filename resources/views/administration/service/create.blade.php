@extends('master')
@section('title', 'Service Entry')
@section('breadcrumb_title', 'Service Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }
</style>
@endpush
@section('content')
    <div id="Service">
        <form @submit.prevent="saveService">
            <div class="row" style="margin:0;">
                <div class="col-md-12 col-xs-12" style="padding: 0;">
                    <fieldset class="scheduler-border bg-of-skyblue">
                        <legend class="scheduler-border">Service Entry Form</legend>
                        <div class="control-group">
                            <div class="col-md-6" style="padding: 0;">
                                <div class="form-group">
                                    <label class="control-label col-xs-4 col-md-4"> Service Date <sup class="text-danger">*</sup></label>
                                    <div class="col-xs-8 col-md-7">
                                        <input class="form-control" id="date" type="date" @change="getCustomer" v-model="service.date" :disabled="userType == 'user' || userType == 'manager' ? true : false" />
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Service Invoice <sup class="text-danger">*</sup></label>
                                    <div class=" col-xs-8 col-md-7">
                                        <input type="text" class="form-control" name="invoice" v-model="service.invoice" readonly>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Select Table <sup class="text-danger">*</sup></label>
                                    <div class="col-xs-8 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                        <div style="width: 88%;">
                                            <v-select :options="tables" style="margin: 0;" v-model="selectedTable" label="name" @input="getCustomer"></v-select>
                                        </div>
                                        <div style="width: 11%;">
                                            <a href="/table" target="_blank" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix" style="display: none;" :style="{display: selectedCustomer.id != null ? '' : 'none'}">
                                    <label class="control-label col-xs-4 col-md-4">Service Customer</label>
                                    <div class=" col-xs-8 col-md-7">
                                        <input type="text" class="form-control" name="customer" v-model="selectedCustomer.name" readonly>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Service Head <sup class="text-danger">*</sup></label>
                                    <div class="col-xs-8 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                        <div style="width: 88%;">
                                            <v-select :options="heads" style="margin: 0;" v-model="selectedHead" label="display_name" @input="onChangeHead"></v-select>
                                        </div>
                                        <div style="width: 11%;">
                                            <a href="/service-head" target="_blank" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-md-6" style="padding: 0;">
                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Service Amount <sup class="text-danger">*</sup> </label>
                                    <div class="col-xs-8 col-md-7 no-padding-right">
                                        <input type="number" min="0" step="any" id="amount" class="form-control"
                                            name="amount" v-model="service.amount">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Description </label>
                                    <div class="col-xs-8 col-md-7 no-padding-right">
                                        <textarea class="form-control" name="description" id="description" cols="2" rows="2" v-model="service.description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="col-md-4"></label>
                                    <div class="col-md-7 text-right no-padding-right">
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
                    <datatable :columns="columns" :data="services" :filter-by="filter"
                        style="margin-bottom: 5px;">
                        <template scope="{ row }">
                            <tr>
                                <td>@{{ row.sl }}</td>
                                <td>@{{ row.invoice }}</td>
                                <td>@{{ row.date }}</td>
                                <td>@{{ row.table_name }}</td>
                                <td>@{{ row.head_name }}</td>
                                <td>@{{ row.amount }}</td>
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
            el: '#Service',
            data() {
                return {
                    columns: [{
                            label: 'Sl',
                            field: 'sl',
                            align: 'center',
                            filterable: false
                        },
                        {
                            label: 'Invoice',
                            field: 'invoice',
                            align: 'center'
                        },
                        {
                            label: 'Date',
                            field: 'date',
                            align: 'center'
                        },
                        {
                            label: 'Table',
                            field: 'table_name',
                            align: 'center'
                        },
                        {
                            label: 'Service Head',
                            field: 'head_name',
                            align: 'center'
                        },
                        {
                            label: 'Amount',
                            field: 'amount',
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

                    service: {
                        id: "",
                        invoice: "{{ invoiceGenerate('Service', 'S') }}",
                        date: moment().format("YYYY-MM-DD"),
                        table_id: null,
                        customer_id: null,
                        service_head_id: null,
                        amount: 0,
                        description: ''
                    },
                    services: [],
                    tables: [],
                    selectedTable: null,
                    heads: [],
                    selectedHead: null,
                    selectedCustomer: {
                        id: null,
                        code: '',
                        name: '',
                        phone: '',
                        address: ''
                    },
                    onProgress: false,
                    btnText: "Save",
                    userType: "{{ Auth::user()->role }}"
                }
            },

    
            created() {
                this.getService();
                this.getTables();
                this.getServiceHead();
            },

            methods: {
                getTables() {
                    axios.get('/get-table').then(res => {
                        this.tables = res.data;
                    })
                },

                getServiceHead() {
                    axios.get('/get-service-head').then(res => {
                        this.heads = res.data.map(item => {
                            item.display_name = `${ item.code } - ${ item.name }`;
                            return item;
                        })
                    })
                },

                getCustomer() {
                    if(this.selectedTable == null) {
                        return;
                    }
                    axios.post('/get_checkin_customer', {
                        tableId: this.selectedTable.id,
                        date: this.service.date
                    }).then(res => {
                        this.selectedCustomer = res.data;
                    })
                },

                onChangeHead() {
                    if(this.selectedHead == null) {
                        return;
                    }
                    if(this.service.id == '') {
                        this.service.amount = this.selectedHead.amount;
                        document.querySelector("#amount").focus();
                    }
                },

                getService() {
                    axios.get("/get-service")
                        .then(res => {
                            let r = res.data;
                            this.services = r.map((item, index) => {
                                item.sl = index + 1
                                return item;
                            });
                        })
                },

                saveService(event) {
                    var url;
                    if (this.service.id == '') {
                        url = '/service';
                    } else {
                        url = '/update-service';
                    }
                    this.service.table_id = this.selectedTable != null ? this.selectedTable.id : null;
                    this.service.customer_id = this.selectedCustomer.id != null ? this.selectedCustomer.id : null;
                    this.service.booking_id = this.selectedCustomer.id != null ? this.selectedCustomer.booking_id : null;
                    this.service.service_head_id = this.selectedHead != null ? this.selectedHead.id : null;
                    this.onProgress = true
                    axios.post(url, this.service)
                        .then(res => {
                            toastr.success(res.data.message);
                            this.getService();
                            this.clearForm();
                            this.btnText = "Save";
                            this.onProgress = false
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
                    let keys = Object.keys(this.service);
                    keys.forEach(key => {
                        this.service[key] = row[key];
                    });

                    if(row.table_id != null) {
                        this.selectedTable = {
                            id: row.table_id,
                            name: row.table_name
                        }
                    }
                    if(row.customer_id != null) {
                        this.selectedCustomer = {
                            id: row.customer_id,
                            code: row.customer_code,
                            phone: row.customer_phone,
                            name: row.customer_name,
                            address: row.customer_address
                        }
                    }
                    if(row.service_head_id != null) {
                        this.selectedHead = {
                            id: row.service_head_id,
                            display_name: `${row.head_code} - ${row.head_name}`
                        }
                    }
                },

                deleteData(rowId) {
                    let formdata = {
                        id: rowId
                    }
                    if (confirm("Are you sure !!")) {
                        axios.post("/delete-service", formdata)
                            .then(res => {
                                toastr.success(res.data)
                                this.getService();
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
                    this.service = {
                        id: "",
                        invoice: "{{ invoiceGenerate('Service', 'S') }}",
                        date: moment().format("YYYY-MM-DD"),
                        table_id: null,
                        customer_id: null,
                        service_head_id: null,
                        amount: 0,
                        description: ''
                    }

                    this.selectedTable = null;
                    this.selectedHead = null;
                    this.selectedCustomer = {
                        id: null,
                        code: '',
                        name: '',
                        phone: '',
                        address: ''
                    }
                },
            }
        })
    </script>
@endpush
