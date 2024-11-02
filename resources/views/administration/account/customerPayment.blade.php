@extends('master')
@section('title', 'Guest Payment')
@section('breadcrumb_title', 'Guest Payment')
@push('style')
<style scoped>
    .v-select .dropdown-menu {
        width: 450px !important;
    }
</style>
@endpush
@section('content')
<div id="CustomerPayment">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Guest Payment Form</legend>
            <div class="control-group">
                <div class="col-md-12 col-xs-12">
                    <form @submit.prevent="saveCustomerPayment">
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
                                    <label class="col-md-4 col-xs-12 control-label">Guest</label>
                                    <div class="col-md-8 col-xs-12">
                                        <v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name" @search="onSearchCustomer" @input="getCustomerDue"></v-select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Invoice</label>
                                    <div class="col-md-8 col-xs-12">
                                        <v-select v-bind:options="invoices" v-model="selectedInvoice" label="invoice" @input="onChangeInvoice"></v-select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Due Amount</label>
                                    <div class="col-md-5 col-xs-12">
                                        <input type="text" class="form-control" v-model="payment.previous_due" disabled>
                                    </div>
                                    <div class="col-md-3 col-xs-12">
                                        <input type="text" class="form-control" v-model="invoiceDue" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Payment Date</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="date" class="form-control" v-model="payment.date" @change="getCustomerPayments" v-bind:disabled="userType != 'user' ? false : true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Description</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" v-model="payment.note">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Discount</label>
                                    <div class="col-md-3 col-xs-5" style="display: flex;align-items:center;">
                                        <div>
                                            <input type="number" class="form-control" id="discount" v-model="payment.discount" @input="discountTotal($event)">
                                        </div>
                                        <div style="margin-bottom: 4px;">%</div>
                                    </div>
                                    <div class="col-md-5 col-xs-7">
                                        <input type="number" class="form-control" id="discountAmount" v-model="payment.discountAmount" @input="discountTotal($event)">
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
        </fieldset>
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
                <datatable :columns="columns" :data="payments" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.invoice }}</td>
                            <td>@{{ row.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td :title="row.customer.status == 'd' ? 'Deleted Guest' : ''" :style="{color: row.customer.status == 'd' ? 'red' : ''}">@{{ row.customer ? row.customer.name:'n/a' }}</td>
                            <td style="text-transform: Capitalize;">
                                @{{ row.method }}
                                <span v-if="row.method == 'bank'"> - @{{row.bank_account ? row.bank_account.name:'n/a'}} - @{{row.bank_account ? row.bank_account.number:'n/a'}}</span>
                            </td>
                            <td>@{{ row.discountAmount }}</td>
                            <td>@{{ (row.type == 'CR' ? row.amount : 0) | decimal }}</td>
                            <td>@{{ (row.type == 'CP' ? row.amount : 0) | decimal }}</td>
                            <td>@{{ row.note }}</td>
                            <td>@{{ row.add_by ? row.add_by.name:'n/a' }}</td>
                            <td>
                                <a title="Billing Invoice" v-bind:href="`/billing-invoice-print/${row.booking_id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                <!-- <a title="Guest Payment Invoice" v-bind:href="`/payment-invoice/customer/${row.id}`" target="_blank"><i class="fa fa-file-text"></i></a> -->
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
    var CustomerPayment = new Vue({
        el: "#CustomerPayment",

        data() {
            return {
                customerId: parseInt("{{$id}}"),
                payment: {
                    id: 0,
                    date: moment().format('YYYY-MM-DD'),
                    customer_id: null,
                    booking_id: '',
                    type: 'CR',
                    method: 'cash',
                    bank_account_id: null,
                    discount: 0,
                    discountAmount: 0,
                    amount: '',
                    previous_due: 0,
                    note: '',
                    sms: true,
                },
                payments: [],
                invoices: [],
                selectedInvoice: null,
                invoiceDue: 0,
                customers: [],
                selectedCustomer: {
                    id: null,
                    display_name: 'Select Guest',
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
                        label: 'Guest',
                        field: 'customer',
                        align: 'center'
                    },
                    {
                        label: 'Payment by',
                        field: 'method',
                        align: 'center'
                    },
                    {
                        label: 'Discount',
                        field: 'discountAmount',
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
                    account.display_name = `${account.number} - ${account.name}`;
                    return account;
                })
            },
        },

        filters: {
            decimal(value) {
                return value == null ? parseFloat(0).toFixed(2) : parseFloat(value).toFixed(2);
            },

            dateFormat(dt, format) {
                return moment(dt).format(format);
            }
        },

        async created() {
            await this.getCustomers();
            this.getAccounts();
            this.getCustomerPayments();
        },

        methods: {
            getCustomers() {
                let filter = {
                    forSearch: 'yes'
                }
                axios.post("/get-customer", filter)
                    .then(res => {
                        let r = res.data;
                        this.customers = r.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code} - ${item.phone}`
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
                            let r = res.data;
                            this.customers = r.map((item, index) => {
                                item.display_name = `${item.name} - ${item.code} - ${item.phone}`
                                return item;
                            });
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getCustomers();
                }
            },

            getCustomerPayments() {
                let data = {
                    dateFrom: this.payment.date,
                    dateTo: this.payment.date
                }
                axios.post('/get-customer-payments', data).then(res => {
                    this.payments = res.data;
                })
            },

            getCustomerDue() {
                if (this.selectedCustomer.id == null || this.selectedCustomer.id == undefined) {
                    return;
                }

                axios.post('/get-customer-due', {
                    customerId: this.selectedCustomer.id
                }).then(res => {
                    // this.payment.previous_due = parseFloat(res.data[0].due).toFixed(this.fixed);
                    this.invoices = res.data.filter(item => item.dueAmount > 0);
                    this.payment.previous_due = res.data.reduce((prev, curr) => {
                        return prev + parseFloat(curr.dueAmount)
                    }, 0).toFixed(2);
                })


            },

            onChangeInvoice() {
                if (this.selectedInvoice == null) {
                    return;
                }
                this.invoiceDue = this.selectedInvoice.dueAmount;
            },

            getAccounts() {
                axios.get('/get-bank-accounts')
                    .then(res => {
                        this.accounts = res.data.data;
                    })
            },

            discountTotal(event){
                if(this.selectedInvoice == null){
                    return;
                }

                if (event.target.id == 'discount') {
                    this.payment.discountAmount = parseFloat((parseFloat(this.invoiceDue) * parseFloat(this.payment.discount)) / 100).toFixed(2);
                }
                if (event.target.id == 'discountAmount') {
                    this.payment.discount = parseFloat((parseFloat(this.payment.discountAmount) * 100) / parseFloat(this.invoiceDue)).toFixed(2);
                }
            },

            saveCustomerPayment() {
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

                if (this.selectedCustomer.id == null || this.selectedCustomer.id == undefined) {
                    toastr.error('Select an Guest');
                    return;
                }

                this.payment.customer_id = this.selectedCustomer.id;
                this.payment.booking_id = this.selectedInvoice ? this.selectedInvoice.id : '';

                let url = '/add-customer-payment';
                if (this.payment.id != 0) {
                    url = '/update-customer-payment';
                }

                this.onProgress = true
                axios.post(url, this.payment)
                    .then(res => {
                        let r = res.data;
                        toastr.success(r.message);
                        this.clearForm();
                        this.getCustomerPayments();
                        this.btnText = "Save";
                        this.onProgress = false;
                        let invoiceConfirm = confirm('Do you want to view invoice?');
                        if (invoiceConfirm == true) {
                            window.open('/payment-invoice/customer/' + r.data.paymentId, '_blank');
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

                this.selectedCustomer = {
                    id: payment.customer_id,
                    name: payment.name,
                    display_name: `${payment.customer.code} - ${payment.customer.name}`
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
                    axios.post('/delete-customer-payment', {
                            id: paymentId
                        })
                        .then(res => {
                            toastr.success(res.data)
                            this.getCustomerPayments();
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
                        customer_id: null,
                        type: 'CR',
                        method: 'cash',
                        bank_account_id: null,
                        amount: '',
                        previous_due: 0,
                        note: '',
                        sms: true,
                    },
                    this.selectedInvoice = null;
                this.invoiceDue = 0;

                this.selectedCustomer = {
                    id: null,
                    display_name: 'Select Guest'
                }

                this.selectedAccount = null;
            }
        }
    })
</script>
@endpush