@extends('master')
@section('title', 'Cash Transaction Entry')
@section('breadcrumb_title', 'Cash Transaction Entry')
@push('style')
<style scoped>
    .v-select .dropdown-menu {
        width: 400px !important;
    }
</style>
@endpush
@section('content')
<div id="CashTransaction">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">CashTransaction Entry Form</legend>
            <div class="control-group">
                <div class="col-md-12 col-xs-12" style="padding: 0;">
                    <form @submit.prevent="addTransaction">
                        <div class="col-md-6 col-xs-12" style="padding: 0;">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Transaction Id</label>
                                <label class="col-md-1">:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="transaction.code" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Transaction Type</label>
                                <label class="col-md-1">:</label>
                                <div class="col-md-7">
                                    <select class="form-control" v-model="transaction.type" @change="onChangeTransactionType">
                                        <option value="">-- select type --</option>
                                        <option value="In Cash">Cash Receive</option>
                                        <option value="Out Cash">Cash Payment</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Account</label>
                                <label class="col-md-1">:</label>
                                <div class="col-xs-7 col-md-7" style="display: flex;align-items:center;margin-bottom:5px;">
                                    <div style="width: 88%;">
                                        <v-select :options="accounts" style="margin: 0;" v-model="selectedAccount" label="display_text"></v-select>
                                    </div>
                                    <div style="width: 11%;">
                                        <button type="button" @click="openModal('/add-account', 'Account Entry')" class="btn btn-xs btn-danger" style="width: 100%;height: 24px;border: 0px;margin-left: 2px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12" style="padding: 0;">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Date</label>
                                <label class="col-md-1">:</label>
                                <div class="col-md-7">
                                    <input type="date" class="form-control" v-model="transaction.date" @change="getTransactions" v-bind:disabled="userType != 'user' ? false : true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Description</label>
                                <label class="col-md-1">:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="transaction.description" id="description" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Amount</label>
                                <label class="col-md-1">:</label>
                                <div class="col-md-7">
                                    <input type="number" class="form-control" step="0.01" v-model="transaction.in_amount" style="display:none;" v-if="transaction.type == 'In Cash'" v-bind:style="{display: transaction.type == 'In Cash' ? '' : 'none'}">
                                    <input type="number" class="form-control" step="0.01" v-model="transaction.out_amount" v-if="transaction.type == 'Out Cash' || transaction.type == ''" v-bind:style="{display: transaction.type == 'Out Cash' || transaction.type == '' ? '' : 'none'}">
                                </div>
                            </div>

                            @if(userAction('e'))
                            <div class="form-group" style="margin-top: 5px; text-align: right;">
                                <div class="col-md-12">
                                    <hr style="margin: 2px 0px; padding-bottom: 3px;">
                                    <input type="button" class="btn btn-danger btn-padding" value="Cancel" @click="clearForm">
                                    <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="row">
        <div class="col-md-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="transactions" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.code }}</td>
                            <td>@{{ row.account ? row.account.name : 'n/a' }}</td>
                            <td>@{{ row.date | dateFormat("DD-MM-YYYY")}}</td>
                            <td>@{{ row.description }}</td>
                            <td>@{{ row.in_amount | decimal }}</td>
                            <td>@{{ row.out_amount | decimal }}</td>
                            <td>@{{ row.add_by.name }}</td>
                            <td>
                                @if(userAction('u'))
                                <i @click="editTransaction(row)" class="fa fa-pencil"></i>
                                @endif
                                @if(userAction('d'))
                                <i @click="deleteTransaction(row.id)" class="fa fa-trash"></i>
                                @endif
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page" style="margin-bottom: 50px;"></datatable-pager>
            </div>
        </div>
    </div>
    @include('administration.settings.modal.common')
</div>
@endsection
@push('script')
<script>
    var CashTransaction = new Vue({
        el: "#CashTransaction",

        data() {
            return {
                transaction: {
                    id: 0,
                    code: "{{ $code }}",
                    date: moment().format('YYYY-MM-DD'),
                    type: '',
                    account_id: null,
                    description: '',
                    in_amount: 0,
                    out_amount: 0
                },
                transactions: [],
                accounts: [],
                selectedAccount: {
                    id: null,
                    display_text: 'select account'
                },
                userType: "{{ Auth::user()->role }}",

                columns: [{
                        label: 'Transaction Id',
                        field: 'code',
                        align: 'center'
                    },
                    {
                        label: 'Account Name',
                        field: 'account.name',
                        align: 'center'
                    },
                    {
                        label: 'Date',
                        field: 'date',
                        align: 'center'
                    },
                    {
                        label: 'Description',
                        field: 'description',
                        align: 'center'
                    },
                    {
                        label: 'Received Amount',
                        field: 'in_amount',
                        align: 'center'
                    },
                    {
                        label: 'Paid Amount',
                        field: 'out_amount',
                        align: 'center'
                    },
                    {
                        label: 'Saved By',
                        field: 'add_by.name',
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

                onProgress: false,
                btnText: 'Save',

                modalHead: "",
                modalData: {
                    id: null,
                    name: ''
                },
                url: '',
            }
        },

        filters: {
            decimal(value) {
                return value == null ? parseFloat(0).toFixed(2) : parseFloat(value).toFixed(2);
            },

            dateFormat(dt, format) {
                return moment(dt).format(format);
            }
        },

        created() {
            this.getAccounts();
            this.getTransactions();
        },

        methods: {
            getAccounts() {
                axios.get('/get-accounts').then(res => {
                    this.accounts = res.data.map(item => {
                        item.display_text = `${item.name} - ${item.code}`;
                        return item;
                    });
                })
            },

            onChangeTransactionType() {
                this.transaction.in_amount = 0;
                this.transaction.out_amount = 0;

            },

            getTransactions() {
                let data = {
                    dateFrom: this.transaction.date,
                    dateTo: this.transaction.date
                }

                axios.post('/get-cash-transactions', data).then(res => {
                    this.transactions = res.data;
                })
            },

            addTransaction() {

                if (this.transaction.type == 'In Cash' && (this.transaction.in_amount == 0 || this.transaction.in_amount == '') || this.transaction.type == 'Out Cash' && (this.transaction.out_amount == 0 || this.transaction.out_amount == '')) {
                    toastr.error('Please Enter Amount!');
                    return;
                }

                this.transaction.account_id = this.selectedAccount.id;

                let url = '/add-cash-transaction';
                if (this.transaction.id != 0) {
                    url = '/update-cash-transaction';
                }

                this.onProgress = true;
                axios.post(url, this.transaction).then(res => {
                    toastr.success(res.data.message);
                    this.getTransactions();
                    this.clearForm();
                    this.transaction.code = res.data.code;
                    this.btnText = "Save";
                    this.onProgress = false;
                }).catch(err => {
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

            editTransaction(transaction) {
                this.btnText = 'Update';
                let keys = Object.keys(this.transaction);
                keys.forEach(key => {
                    this.transaction[key] = transaction[key];
                })

                this.selectedAccount = {
                    id: transaction.account_id,
                    display_text: `${transaction.account?.name} - ${transaction.account?.code}`
                }
            },

            deleteTransaction(transactionId) {
                if (confirm("Are you sure !!")) {
                    axios.post('/delete-cash-transaction', {
                        id: transactionId
                    }).then(res => {
                        toastr.success(res.data)
                        this.getTransactions();
                    }).catch(err => {
                        var r = JSON.parse(err.request.response);
                        if (r.errors != undefined) {
                            console.log(r.errors);
                        }
                        toastr.error(r.message);
                    })
                }
            },

            clearForm() {
                this.transaction = {
                    id: 0,
                    code: "{{ $code }}",
                    date: moment().format('YYYY-MM-DD'),
                    type: '',
                    account_id: null,
                    description: '',
                    in_amount: 0,
                    out_amount: 0
                }

                this.selectedAccount = {
                    id: null,
                    display_text: 'select account'
                }
            },

            openModal(url, txt) {
                this.modalHead = txt;
                this.url = url;
                $('#commonModal').modal('show');
            },
            resetModal() {
                this.modalHead = '';
                this.modalData = {
                        id: null,
                        name: ''
                    },
                    this.url = '';
            },
            addData() {
                axios.post(this.url, this.modalData).then(res => {
                    toastr.success(res.data.message);
                    this.getAccounts();
                    this.resetModal();
                    $('#commonModal').modal('hide');
                }).catch(err => {
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
        }
    })
</script>
@endpush