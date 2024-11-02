@extends('master')
@section('title', 'Account Entry')
@section('breadcrumb_title', 'Account Entry')
@section('content')
<div id="Accounts">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Account Entry Form</legend>
            <div class="control-group">
                <div class="col-md-6 col-xs-12 col-md-offset-3 no-padding">
                    <form @submit.prevent="saveAccount">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Account Id</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" v-model="account.code" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4">Account Name</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" v-model="account.name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Description</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" v-model="account.description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12" style="text-align: right">
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
            </div>
        </fieldset>
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
                <datatable :columns="columns" :data="accounts" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.code }}</td>
                            <td>@{{ row.name }}</td>
                            <td>@{{ row.description }}</td>
                            <td>
                                @if(userAction('u'))
                                <i @click="editAccount(row)" class="fa fa-pencil"></i>
                                @endif
                                @if(userAction('d'))
                                <i @click="deleteAccount(row.id)" class="fa fa-trash"></i>
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
    var Accounts = new Vue({
        el: '#Accounts',

        data() {
            return {
                account: {
                    id: null,
                    code: "{{ $code }}",
                    type: '',
                    name: '',
                    description: ''
                },
                accounts: [],


                columns: [{
                        label: 'Account Id',
                        field: 'code',
                        align: 'center'
                    },
                    {
                        label: 'Account Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Description',
                        field: 'description',
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
                btnText: "Save"
            }
        },

        created() {
            this.getAccounts();
        },

        methods: {
            getAccounts() {
                axios.get('/get-accounts')
                    .then(res => {
                        this.accounts = res.data.map((item, sl) => {
                            item.sl = sl + 1;
                            return item;
                        });
                    })
            },

            saveAccount() {
                let url = '/add-account';
                if (this.account.id != null) {
                    url = '/update-account';
                }
                this.onProgress = true;
                axios.post(url, this.account)
                    .then(res => {
                        toastr.success(res.data.message);
                        this.getAccounts();
                        this.clearForm();
                        this.account.code = res.data.data.code;
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
                this.btnText = 'Update';
                Object.keys(this.account).forEach(key => {
                    this.account[key] = account[key];
                })
            },

            deleteAccount(accountId) {
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-account", {
                            id: accountId
                        })
                        .then(res => {
                            toastr.success(res.data)
                            this.getAccounts();
                        })
                        .catch(err => {
                            var r = JSON.parse(err.request.response);
                            toastr.error(r.message);
                        })
                }
            },

            clearForm() {
                this.account = {
                    id: null,
                    code: "{{ $code }}",
                    type: '',
                    name: '',
                    description: ''
                }
            }
        }
    });
</script>
@endpush