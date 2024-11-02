@extends('master')
@section('title', 'Bank Account Entry')
@section('breadcrumb_title', 'Bank Account Entry')
@push('style')
<style scoped>
    .inactive {
        background-color: #7bb1e0;
    }
</style>
@endpush
@section('content')
<div id="BankAccounts">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <fieldset class="scheduler-border bg-of-skyblue">
                <legend class="scheduler-border">Bank Acount Entry Form</legend>
                <div class="control-group">
                    <form @submit.prevent="saveAccount">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="" class="control-label col-md-4 co-xs-12">Account Name</label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="text" class="form-control" v-model="account.name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="control-label col-md-4 co-xs-12">Account No.</label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="text" class="form-control" v-model="account.number">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="control-label col-md-4 co-xs-12">Account Type</label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="text" class="form-control" v-model="account.type">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="control-label col-md-4 co-xs-12">Bank Name</label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="text" class="form-control" v-model="account.bank_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="" class="control-label col-md-4 co-xs-12">Branch Name</label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="text" class="form-control" v-model="account.branch_name">
                                    </div>
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label for="" class="control-label col-md-4 co-xs-12">Initial Balance</label>
                                    <div class="col-md-8 co-xs-12">
                                        <input type="number" class="form-control" v-model="account.initial_balance">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="control-label col-md-4 co-xs-12">Description</label>
                                    <div class="col-md-8 co-xs-12">
                                        <textarea class="form-control" v-model="account.description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 co-xs-12 text-right">
                                        @if(userAction('e'))
                                        <input type="button" class="btn btn-danger btn-reset" value="Reset" @click="clearForm">
                                        <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                                        @endif
                                    </div>
                                </div>
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
                <datatable :columns="columns" :data="accounts" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr v-bind:class="[row.transaction_type == 'deposit' ? 'transaction-deposit' : 'transaction-withdraw']">
                            <td>@{{ row.name }}</td>
                            <td>@{{ row.number }}</td>
                            <td>@{{ row.type }}</td>
                            <td>@{{ row.bank_name }}</td>
                            <td>@{{ row.branch_name }}</td>
                            <td>
                                <span v-if="row.status == 'a'" class="badge badge-success">Active</span>
                                <span v-else class="badge badge-danger">Inactive</span>
                            </td>
                            <td>
                                @if(userAction('u'))
                                <i @click="editAccount(row)" class="fa fa-pencil"></i>
                                @endif
                                @if(userAction('d'))
                                <i v-bind:class="{ inactive: row.status == 'd' }" @click="changeStatus(row.id)" class="fa fa-trash"></i>
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
    var BankAccounts = new Vue({
        el: "#BankAccounts",

        data() {
            return {
                account: {
                    id: 0,
                    name: '',
                    number: '',
                    type: '',
                    bank_name: '',
                    branch_name: '',
                    initial_balance: 0.00,
                    description: ''
                },
                accounts: [],
                columns: [{
                        label: 'Account Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Account Number',
                        field: 'number',
                        align: 'center'
                    },
                    {
                        label: 'Account Type',
                        field: 'type',
                        align: 'center'
                    },
                    {
                        label: 'Bank Name',
                        field: 'bank_name',
                        align: 'center'
                    },
                    {
                        label: 'Branch Name',
                        field: 'branch_name',
                        align: 'center'
                    },
                    {
                        label: 'Status',
                        field: 'status',
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
                btnText: 'Save'
            }
        },

        created() {
            this.getAccounts();
        },

        methods: {
            getAccounts() {
                axios.get('/get-bank-accounts')
                    .then(res => {
                        this.accounts = res.data.map((item, sl) => {
                            item.sl = sl + 1;
                            return item;
                        });
                    })
            },

            saveAccount() {
                let url = '/add-bank-account';
                if (this.account.id != 0) {
                    url = '/update-bank-account';
                }

                this.onProgress = true;
                axios.post(url, this.account)
                    .then(res => {
                        toastr.success(res.data.message);
                        this.getAccounts();
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

            editAccount(account) {
                this.btnText = 'Udpate';
                Object.keys(this.account).forEach(key => {
                    this.account[key] = account[key];
                })
            },

            changeStatus(accountId) {
                if (confirm("Are you sure !!")) {
                    axios.post("/change-account-status", {
                            id: accountId
                        })
                        .then(res => {
                            toastr.success(res.data.message)
                            this.getAccounts();
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
                this.account = {
                    id: 0,
                    name: '',
                    number: '',
                    type: '',
                    bank_name: '',
                    branch_name: '',
                    initial_balance: 0.00,
                    description: ''
                }
            }
        }
    })
</script>
@endpush