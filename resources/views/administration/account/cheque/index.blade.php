@extends('master')
@section('title', 'Cheque Entry')
@section('breadcrumb_title', 'Cheque Entry')
@push('style')
<style scoped>
    .v-select .dropdown-menu {
        width: 343px !important;
        overflow-y: auto !important;
    }
</style>
@endpush
@section('content')
<div id="ChequeEntry">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <strong><i class="fa fa-file-text-o"></i> &nbsp;Cheque Entry Information</strong>
                </div>
                <div class="card-body">
                    <form @submit.prevent="saveCheque">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="customer" class="control-label col-md-4 co-xs-12">Select Guest <span class="text-danger">*</span></label>
                                    <div class="col-md-8 co-xs-12">
                                        <v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name" @search="onSearchCustomer"></v-select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bank" class="control-label col-md-4 co-xs-12">Bank Name <span class="text-danger">*</span></label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="text" id="bank" class="form-control" v-model="cheque.bank_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="branch" class="control-label col-md-4 co-xs-12">Branch Name <span class="text-danger">*</span></label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="text" id="branch" class="form-control" v-model="cheque.branch">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="no" class="control-label col-md-4 co-xs-12">Cheque No <span class="text-danger">*</span></label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="text" id="no" class="form-control" v-model="cheque.cheque_no">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="amount" class="control-label col-md-4 co-xs-12">Cheque Amount <span class="text-danger">*</span></label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="text" id="amount" class="form-control" v-model="cheque.amount">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="control-label col-md-4 co-xs-12">Cheque Status <span class="text-danger">*</span></label>
                                    <div class="col-md-8 co-xs-12">
                                        <select id="status" class="form-control" v-model="cheque.cheque_status">
                                            <option value="">--select one--</option>
                                            <option value="pe">Pending</option>
                                            <option value="pa">Paid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="date" class="control-label col-md-4 co-xs-12">Entry Date <span class="text-danger">*</span></label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="date" id="date" class="form-control" v-model="cheque.date">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="chequeDate" class="control-label col-md-4 co-xs-12">Cheque Date <span class="text-danger">*</span></label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="date" id="chequeDate" class="form-control" v-model="cheque.cheque_date">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="remDate" class="control-label col-md-4 co-xs-12">Reminder Date <span class="text-danger">*</span></label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="date" id="remDate" class="form-control" v-model="cheque.reminder_date">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="subDate" class="control-label col-md-4 co-xs-12">Submit Date <span class="text-danger">*</span></label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="date" class="form-control" id="subDate" v-model="cheque.submit_date">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="des" class="control-label col-md-4 co-xs-12">Description</label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="text" class="form-control" id="des" v-model="cheque.note" placeholder="Description">
                                    </div>
                                </div>
                                @if(userAction('e'))
                                <div class="form-group" style="margin-top: 5px; text-align: right;">
                                    <div class="col-md-12 col-xs-12">
                                        <hr style="margin: 2px 0px; padding-bottom: 3px;">
                                        <input type="button" class="btn btn-danger btn-reset" value="Reset" @click="clearForm">
                                        <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="cheques" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.sl }}</td>
                            <td>@{{ row.customer.name }}</td>
                            <td>@{{ row.bank_name }}</td>
                            <td>@{{ row.branch }}</td>
                            <td>@{{ row.cheque_date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ row.cheque_no }}</td>
                            <td>@{{ row.amount | decimal }}</td>
                            <td>
                                <span v-if="row.cheque_status == 'pa'" class="badge badge-success">Paid</span>
                                <span v-else class="badge badge-danger">Pending</span>
                            </td>
                            <td>
                                @if(userAction('u'))
                                <i @click="editCheque(row)" class="fa fa-pencil"></i>
                                @endif
                                @if(userAction('d'))
                                <i @click="deleteCheque(row.id)" class="fa fa-trash"></i>
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
    var ChequeEntry = new Vue({
        el: "#ChequeEntry",

        data() {
            return {
                cheque: {
                    id: 0,
                    customer_id: null,
                    bank_name: '',
                    branch: '',
                    cheque_no: '',
                    amount: '',
                    cheque_status: 'pe',
                    date: moment().format('YYYY-MM-DD'),
                    cheque_date: moment().format('YYYY-MM-DD'),
                    reminder_date: moment().format('YYYY-MM-DD'),
                    submit_date: moment().format('YYYY-MM-DD'),
                    note: '',
                },

                cheques: [],

                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center'
                    },
                    {
                        label: 'Guest Name',
                        field: 'customer.name',
                        align: 'center'
                    },
                    {
                        label: 'Bank Name',
                        field: 'bank_name',
                        align: 'center'
                    },
                    {
                        label: 'Branch',
                        field: 'branch',
                        align: 'center'
                    },
                    {
                        label: 'Cheque Date',
                        field: 'cheque_date',
                        align: 'center'
                    },
                    {
                        label: 'Cheque No',
                        field: 'cheque_no',
                        align: 'center'
                    },
                    {
                        label: 'Amount',
                        field: 'amount',
                        align: 'center'
                    },
                    {
                        label: 'Cheque Status',
                        field: 'cheque_status',
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

                customers: [],
                selectedCustomer: null,
                btnText: 'Save',
                onProgress: false
            }
        },

        filters: {
            decimal(value) {
                let fixed = "{{ session('organization')->fixed }}";
                return value == null ? parseFloat(0).toFixed(fixed) : parseFloat(value).toFixed(fixed);
            },

            dateFormat(dt, format) {
                return moment(dt).format(format);
            }
        },

        created() {
            this.getCustomers();
            this.getCheque();
        },

        methods: {
            getCustomers() {
                let filter = {
                    forSearch: 'yes'
                }
                axios.post("/get-customer", filter)
                    .then(res => {
                        let r = res.data.data;
                        this.customers = r.customers.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code}`
                            return item;
                        });
                    })
            },

            async onSearchCustomer(val, loading) {
                if (val.length > 2) {
                    loading(true);
                    await axios.post("/get-customer", {
                            name: val
                        })
                        .then(res => {
                            let r = res.data.data;
                            this.customers = r.customers.map((item, index) => {
                                item.display_name = `${item.code} - ${item.name}`
                                return item;
                            });
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getCustomers();
                }
            },

            getCheque() {
                axios.get('/get-cheques')
                    .then(res => {
                        let r = res.data.data;
                        this.cheques = r.cheques.map((item, sl) => {
                            item.sl = sl + 1;
                            return item;
                        });
                    })
            },

            saveCheque() {
                if (this.selectedCustomer == null || this.selectedCustomer == undefined) {
                    toastr.error('Please Select Guest!');
                    return;
                }

                let url = '/add-cheque';
                if (this.cheque.id != 0) {
                    url = '/update-cheque';
                }

                this.cheque.customer_id = this.selectedCustomer.id;
                this.onProgress = true;
                axios.post(url, this.cheque)
                    .then(res => {
                        toastr.success(res.data.message);
                        this.getCheque();
                        this.clearForm();
                        this.btnText = "Save";
                        this.onProgress = false;
                    })
                    .catch(err => {
                        this.onProgress = false;
                        var r = JSON.parse(err.request.response);
                        if (r.errors) {
                            $.each(r.errors, (index, value) => {
                                $.each(value, (ind, val) => {
                                    toastr.error(val)
                                })
                            })
                        } else {
                            toastr.error(r.message);
                        }
                    })
            },

            editCheque(cheque) {
                this.btnText = 'Update';
                let keys = Object.keys(this.cheque);
                keys.forEach(key => {
                    this.cheque[key] = cheque[key];
                })

                this.selectedCustomer = {
                    id: cheque.customer_id,
                    display_name: cheque.customer.code + ' - ' + cheque.customer.name
                }
            },

            deleteCheque(chequeId) {
                if (confirm("Are you sure !!")) {
                    axios.post('/delete-cheque', {
                            id: chequeId
                        })
                        .then(res => {
                            toastr.success(res.data.message)
                            this.getCheque();
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
                this.cheque = {
                    id: 0,
                    customer_id: null,
                    bank_name: '',
                    branch: '',
                    cheque_no: '',
                    amount: '',
                    cheque_status: 'pe',
                    date: moment().format('YYYY-MM-DD'),
                    cheque_date: moment().format('YYYY-MM-DD'),
                    reminder_date: moment().format('YYYY-MM-DD'),
                    submit_date: moment().format('YYYY-MM-DD'),
                    note: '',
                }

                this.selectedCustomer = null;
            }
        },
    })
</script>
@endpush