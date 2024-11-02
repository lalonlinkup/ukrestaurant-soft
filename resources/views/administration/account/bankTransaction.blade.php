@extends('master')
@section('title', 'Bank Transaction Entry')
@section('breadcrumb_title', 'Bank Transaction Entry')

@push('style')
<style scoped>
    .balance-card {
        box-shadow: 0px 1px 2px #fff;
        background: #fff;
        padding: 20px 0px;
        margin-top: 25px;
        border-radius: 3px;
    }

    .v-select .dropdown-menu {
        width: 450px !important;
    }
</style>
@endpush

@section('content')
<div id="BankTransaction">
    <div class="row">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Bank Transaction Entry Form</legend>
            <div class="control-group">
                <div class="col-md-8 col-xs-12 col-md-offset-2">
                    <div class="row">
                        <div class="col-md-8 col-xs-12">
                            <form @submit.prevent="saveTransaction">
                                <div class="form-group">
                                    <label for="date" class="control-label col-md-4">Transaction Date</label>
                                    <div class="col-md-8">
                                        <input type="date" id="date" class="form-control" v-model="transaction.date" @change="getTransactions" {{Auth::user()->role == 'user' ? 'disabled' : ''}}>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="account" class="control-label col-md-4">Account</label>
                                    <div class="col-md-8">
                                        <v-select v-bind:options="filteredAccounts" id="account" v-model="selectedAccount" label="display_name" @input="getBankBalance"></v-select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="type" class="control-label col-md-4">Transaction Type</label>
                                    <div class="col-md-8">
                                        <select class="form-control" id="type" v-model="transaction.type" style="padding:0px;">
                                            <option value="">-- Select Type --</option>
                                            <option value="deposit">Deposit</option>
                                            <option value="withdraw">Withdraw</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="amount" class="control-label col-md-4">Amount</label>
                                    <div class="col-md-8">
                                        <input type="number" id="amount" class="form-control" v-model="transaction.amount">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="note" class="control-label col-md-4">Note</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" id="note" v-model="transaction.note"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12" style="text-align: right;">
                                        @if(userAction('e'))
                                        <input type="button" class="btn btn-danger btn-reset" value="Reset" @click="clearForm">
                                        <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-3 col-xs-12" style="display:none;" v-bind:style="{display: selectedAccount == null || selectedAccount.id == undefined ? 'none' : ''}">
                            <div class="balance-card text-center">
                                <i class="fa fa-dollar fa-2x"></i>
                                <h5 style="margin-bottom: 0px;">Current Balance</h5>
                                <h3 style="color: green; margin-top: 10px;">@{{ accountBalance | decimal }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
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
                <datatable :columns="columns" :data="transactions" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr v-bind:class="[row.transaction_type == 'deposit' ? 'transaction-deposit' : 'transaction-withdraw']">
                            <td>@{{ row.sl }}</td>
                            <td>@{{ row.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ row.bank_account.name }}</td>
                            <td>@{{ row.bank_account.number }}</td>
                            <td>@{{ row.bank_account.bank_name }}</td>
                            <td>@{{ row.type }}</td>
                            <td>@{{ row.note }}</td>
                            <td>@{{ row.amount | decimal }}</td>
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
</div>
@endsection

@push('script')
<script>
    var BankTransaction = new Vue({
        el: "#BankTransaction",

        data() {
            return {
                transaction: {
                    id: 0,
                    bank_account_id: null,
                    date: moment().format('YYYY-MM-DD'),
                    type: '',
                    amount: '',
                    note: ''
                },

                transactions: [],
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center'
                    },
                    {
                        label: 'Transaction Date',
                        field: 'date',
                        align: 'center'
                    },
                    {
                        label: 'Account Name',
                        field: 'bank_account.name',
                        align: 'center'
                    },
                    {
                        label: 'Account Number',
                        field: 'bank_account.number',
                        align: 'center'
                    },
                    {
                        label: 'Bank Name',
                        field: 'bank_account.bank_name',
                        align: 'center'
                    },
                    {
                        label: 'Transaction Type',
                        field: 'type',
                        align: 'center'
                    },
                    {
                        label: 'Note',
                        field: 'note',
                        align: 'center'
                    },
                    {
                        label: 'Amount',
                        field: 'amount',
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
                accounts: [],
                selectedAccount: null,
                accountBalance: 0,

                onProgress: false,
                btnText: 'Save'
            }
        },

        computed: {
            filteredAccounts() {
                let accounts = this.accounts.filter(account => account.status == 'a');
                return accounts.map(account => {
                    account.display_name =
                        `${account.number} - ${account.name}`;
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

        created() {
            this.getAccounts();
            this.getTransactions();
        },

        methods: {
            getAccounts() {
                axios.get('/get-bank-accounts')
                    .then(res => {
                        this.accounts = res.data;
                    })
            },

            getTransactions() {
                let data = {
                    dateFrom: this.transaction.date,
                    dateTo: this.transaction.date
                }
                axios.post('/get-bank-transactions', data)
                    .then(res => {
                        this.transactions = res.data.map((item, index) => {
                            item.sl = index + 1;
                            return item;
                        });
                    })
            },

            saveTransaction() {

                this.transaction.bank_account_id = this.selectedAccount != null ? this.selectedAccount.id : '';

                let url = '/add-bank-transaction';
                if (this.transaction.id != 0) {
                    url = '/update-bank-transaction';
                }

                this.onProgress = true;
                axios.post(url, this.transaction)
                    .then(res => {
                        toastr.success(res.data);
                        this.getTransactions();
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

            editTransaction(transaction) {
                this.btnText = 'Update';
                let keys = Object.keys(this.transaction);
                keys.forEach(key => this.transaction[key] = transaction[key]);
                this.selectedAccount = {
                    id: transaction.bank_account_id,
                    name: transaction.bank_account.name,
                    number: transaction.bank_account.number,
                    bank_name: transaction.bank_account.bank_name,
                    display_name: `${transaction.bank_account.number} - ${transaction.bank_account.name}`
                }
            },

            deleteTransaction(transactionId) {
                if (confirm("Are you sure !!")) {
                    axios.post('/delete-bank-transaction', {
                            id: transactionId
                        })
                        .then(res => {
                            toastr.success(res.data)
                            this.getTransactions();
                        })
                        .catch(err => {
                            var r = JSON.parse(err.request.response);
                            toastr.error(r.message);
                        })
                }
            },

            getBankBalance() {
                if (this.selectedAccount == null || this.selectedAccount.id == undefined) {
                    return;
                }

                axios.post('/bank-transaction-summary', {
                    bankId: this.selectedAccount.id
                }).then(res => {
                    this.accountBalance = res.data[0].balance;
                })
            },

            clearForm() {
                this.transaction = {
                    id: 0,
                    bank_account_id: null,
                    date: moment().format('YYYY-MM-DD'),
                    type: '',
                    amount: '',
                    note: ''
                }

                this.selectedAccount = null;
                this.accountBalance = 0;
            }
        }
    })
</script>
@endpush