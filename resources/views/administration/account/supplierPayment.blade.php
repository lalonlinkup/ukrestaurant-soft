@extends('master')
@section('title', 'Supplier Payment')
@section('breadcrumb_title', 'Supplier Payment')
@push('style')
<style scoped>
    .v-select .dropdown-menu {
        width: 450px !important;
    }
</style>
@endpush
@section('content')
<div id="SupplierPayment">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <strong><i class="fa fa-money"></i> Supplier Payment Form</strong>
                </div>

                <div class="card-body">
                    <form @submit.prevent="saveSupplierPayment">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Transaction Type</label>
                                    <div class="col-md-8 col-xs-12">
                                        <select class="form-control" v-model="payment.type">
                                            <option value=""></option>
                                            <option value="CR">Receive</option>
                                            <option value="CP">Payment</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Payment Type</label>
                                    <div class="col-md-8 col-xs-12">
                                        <select class="form-control" v-model="payment.method">
                                            <option value="cash">Cash</option>
                                            <option value="bank">Bank</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" v-if="payment.method == 'bank'" style="display:none;" :style="{display: payment.method == 'bank' ? '' : 'none'}">
                                    <label class="col-md-4 col-xs-12 control-label">Bank Account</label>
                                    <div class="col-md-8 col-xs-12">
                                        <v-select v-bind:options="filteredAccounts" v-model="selectedAccount" label="display_name" placeholder="Select account"></v-select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Supplier</label>
                                    <div class="col-md-8 col-xs-12">
                                        <v-select v-bind:options="suppliers" v-model="selectedSupplier" label="display_name" @search="onSearchSupplier" @input="getSupplierDue"></v-select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Due Amount</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" v-model="previous_due" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Payment Date</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="date" class="form-control" v-model="payment.date" @change="getSupplierPayments" v-bind:disabled="userType == 'Superadmin' || userType == 'admin' ? false : true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Description</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" v-model="payment.note">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Amount</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="number" class="form-control" v-model="payment.amount">
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
                <datatable :columns="columns" :data="payments" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.invoice }}</td>
                            <td>@{{ row.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td :title="row.supplier.status == 'd' ? 'Deleted Supplier' : ''" :style="{color: row.supplier.status == 'd' ? 'red' : ''}">@{{ row.supplier ? row.supplier.name : 'n/a' }}</td>
                            <td style="text-transform: Capitalize;">
                                @{{ row.method }}
                                <span v-if="row.method == 'bank'"> - @{{row.bank_account ? row.bank_account.name:'n/a'}} - @{{row.bank_account ? row.bank_account.number:'n/a'}}</span>
                            </td>
                            <td>@{{ (row.type == 'CR' ? row.amount : 0) | decimal }}</td>
                            <td>@{{ (row.type == 'CP' ? row.amount : 0) | decimal }}</td>
                            <td>@{{ row.note }}</td>
                            <td>@{{ row.add_by ?row.add_by.name:'n/a' }}</td>
                            <td>
                                <a title="Supplier Payment Invoice" v-bind:href="`/payment-invoice/supplier/${row.id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                @if(userAction('u'))
                                <i @click="editPayment(row)" class="fa fa-pencil"></i>
                                @endif
                                @if(userAction('d'))
                                <i @click="deletePayment(row.id)" class="fa fa-trash"></i>
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
    var SupplierPayment = new Vue({
        el: "#SupplierPayment",

        data() {
            return {
                payment: {
                    id: 0,
                    date: moment().format('YYYY-MM-DD'),
                    supplier_id: null,
                    type: 'CP',
                    method: 'cash',
                    bank_account_id: null,
                    amount: '',
                    note: ''
                },

                previous_due: 0,
                payments: [],
                suppliers: [],
                selectedSupplier: {
                    id: null,
                    display_name: 'Select Supplier',
                },
                accounts: [],
                selectedAccount: null,
                userType: '{{ Auth::user()->role }}',

                columns: [{
                        label: 'Transaction Id',
                        field: 'invoice',
                        align: 'center'
                    },
                    {
                        label: 'Date',
                        field: 'date',
                        align: 'center'
                    },
                    {
                        label: 'Supplier',
                        field: 'supplier',
                        align: 'center'
                    },
                    {
                        label: 'Payment by',
                        field: 'method',
                        align: 'center'
                    },
                    {
                        label: 'In Amount',
                        field: 'amount',
                        align: 'center'
                    },
                    {
                        label: 'Out Amount',
                        field: 'amount',
                        align: 'center'
                    },
                    {
                        label: 'Description',
                        field: 'note',
                        align: 'center'
                    },
                    {
                        label: 'Added By',
                        field: 'add_by',
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
                fixed: 2,

                onProgress: false,
                btnText: "Save"
            }
        },

        computed: {
            filteredAccounts() {
                let accounts = this.accounts.filter(account => account.status == 'a');
                return accounts.map(account => {
                    account.display_name = `${account.name} - ${account.number} (${account.bank_name})`;
                    return account;
                })
            },
        },

        filters: {
            decimal(value) {
                return value == null ? parseFloat(0).toFixed(2) : parseFloat(value).toFixed(2);
            },

            dateFormat(dt, format){
                return moment(dt).format(format);
            }
        },

        async created() {
            await this.getSuppliers();
            this.getAccounts();
            this.getSupplierPayments();
        },

        methods: {
            getSuppliers() {
                let filter = {
                    forSearch: 'yes'
                }
                axios.post("/get-supplier", filter)
                    .then(res => {
                        let r = res.data;
                        this.suppliers = r.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code} - ${item.phone}`
                            return item;
                        });
                    })
            },

            async onSearchSupplier(val, loading) {
                if (val.length > 2) {
                    loading(true);
                    await axios.post("/get-supplier", {
                            name: val
                        })
                        .then(res => {
                            let r = res.data;
                            this.suppliers = r.map((item, index) => {
                                item.display_name = `${item.name} - ${item.code} - ${item.phone}`
                                return item;
                            });
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getSuppliers();
                }
            },

            getSupplierPayments() {
                let data = {
                    dateFrom: this.payment.date,
                    dateTo: this.payment.date
                }
                axios.post('/get-supplier-payments', data).then(res => {
                    this.payments = res.data;
                })
            },

            getSupplierDue() {
                if (this.selectedSupplier.id == undefined) {
                    return;
                }

                axios.post('/get-supplier-due', {
                    supplierId: this.selectedSupplier.id
                }).then(res => {
                    this.previous_due = parseFloat(res.data[0].due).toFixed(this.fixed);
                })
            },

            getAccounts() {
                axios.get('/get-bank-accounts')
                    .then(res => {
                        this.accounts = res.data.data;
                    })
            },

            saveSupplierPayment() {
                if (this.payment.method == 'bank') {
                    if (this.selectedAccount == null) {
                        toastr.error('Select an account');
                        return;
                    } else {
                        this.payment.bank_account_id = this.selectedAccount.id;
                    }
                } else {
                    this.payment.bank_account_id = null;
                }

                if (this.selectedSupplier.id == null || this.selectedSupplier.id == undefined) {
                    toastr.error('Select an Supplier');
                    return;
                }

                this.payment.supplier_id = this.selectedSupplier.id;

                let url = '/add-supplier-payment';
                if (this.payment.id != 0) {
                    url = '/update-supplier-payment';
                }

                this.onProgress = true
                axios.post(url, this.payment)
                    .then(res => {
                        let r = res.data;
                        toastr.success(r.message);
                        this.clearForm();
                        this.getSupplierPayments();
                        this.btnText = "Save";
                        this.onProgress = false;
                        let invoiceConfirm = confirm('Do you want to view invoice?');
                        if (invoiceConfirm == true) {
                            window.open('/payment-invoice/supplier/' + r.data.paymentId, '_blank');
                        }
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

            editPayment(payment) {
                this.btnText = 'Update';
                let keys = Object.keys(this.payment);
                keys.forEach(key => {
                    this.payment[key] = payment[key];
                })

                this.selectedSupplier = {
                    id: payment.supplier_id,
                    name: payment.name,
                    display_name: `${payment.supplier.code} - ${payment.supplier.name}`
                }

                if (payment.method == 'bank') {
                    this.selectedAccount = {
                        id: payment.bank_account_id,
                        name: payment.bank_account.name,
                        number: payment.bank_account.number,
                        bank_name: payment.bank_account.bank_name,
                        display_name: `${payment.bank_account.name} - ${payment.bank_account.number} (${payment.bank_account.bank_name})`
                    }
                }
            },

            deletePayment(paymentId) {
                if (confirm("Are you sure !!")) {
                    axios.post('/delete-supplier-payment', {
                            id: paymentId
                        })
                        .then(res => {
                            toastr.success(res.data.message)
                            this.getSupplierPayments();
                        })
                        .catch(err => {
                            var r = JSON.parse(err.request.response);
                            toastr.error(r.message);
                        })
                }
            },

            clearForm() {
                this.payment = {
                        id: 0,
                        date: moment().format('YYYY-MM-DD'),
                        supplier_id: null,
                        type: 'CR',
                        method: 'cash',
                        bank_account_id: null,
                        amount: '',
                        note: ''
                    },

                    this.previous_due = 0;
                this.selectedSupplier = {
                    id: null,
                    display_name: 'Select Supplier'
                }

                this.selectedAccount = null;
            }
        }
    })
</script>
@endpush