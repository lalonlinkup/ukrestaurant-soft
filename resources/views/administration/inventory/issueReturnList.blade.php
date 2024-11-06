@extends('master')
@section('title', 'Issue Return List')
@section('breadcrumb_title', 'Issue Return List')
@push('style')
<style scoped>
    .v-select .dropdown-toggle {
        padding: 0px;
        height: 30px !important;
    }

    .v-select .dropdown-menu {
        width: 350px !important;
        overflow-y: auto !important;
    }

    table>thead>tr>th {
        text-align: center;
    }
</style>
@endpush
@section('content')
<div id="issueList">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Search Issue Return List</legend>
            <div class="control-group">
                <form @submit.prevent="getIssue">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeType" style="width: 100%;" v-model="filter.searchType">
                                <option value="">All</option>
                                <option value="table">By Table</option>
                                <option value="quantity">By Quantity</option>
                                <option value="user">By User</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'table'" style="display: none;" :style="{display: filter.searchType == 'table' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="tables" v-model="selectedTable" label="display_name" @search="onSearchTable"></v-select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'user'" style="display: none;" :style="{display: filter.searchType == 'user' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="users" v-model="selectedUser" label="name"></v-select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'quantity'" style="display: none;" :style="{display: filter.searchType == 'quantity' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="assets" v-model="selectedAsset" label="display_name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 no-padding" v-if="filter.searchType != 'quantity'" style="display: none;" :style="{display: filter.searchType != 'quantity' ? '' : 'none'}">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">RecordType</label>
                            <select class="form-select no-padding" @change="onChangeType" style="width: 100%;" v-model="filter.recordType">
                                <option value="with">With Details</option>
                                <option value="without">Without Details</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateFrom">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateTo">
                        </div>
                    </div>

                    <div class="col-md-1 col-xs-12">
                        <div class="form-group">
                            <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>

    <div class="row" style="display: flex;justify-content:space-between;">
        <div class="col-md-3" v-if="issues2.length > 0" style="display:none;" :style="{display: issues2.length > 0 ? '' : 'none'}">
            <input type="search" @input="filterArray($event)" placeholder="Search..." class="form-control">
        </div>
        <div class="col-md-9 text-right">
            <a v-if="issues.length > 0" style="display:none;" :style="{display: issues.length > 0 ? '' : 'none'}" href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
    </div>
    <div class="row" v-if="issues.length > 0 && showReport" style="display:none;" :style="{display: issues.length > 0 && showReport ? '' : 'none'}">
        <div class="col-md-12">
            <div class="table-responsive" id="reportTable">
                <table class="table table-bordered record-table table-condensed" v-if="filter.searchType != 'quantity' && filter.recordType == 'with'" style="display:none;" :style="{display: filter.searchType != 'quantity' && filter.recordType == 'with'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Date</th>
                            <th>Table No</th>
                            <th>Asset Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th style="text-align: right;">Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(issue, index) in issues">
                            <tr>
                                <td>@{{ index + 1 }}</td>
                                <td>@{{ issue.date | dateFormat("DD-MM-YYYY") }}</td>
                                <td>@{{issue.table.name }}</td>
                                <td>@{{ issue.issue_return_details[0].asset.name }}</td>
                                <td style="text-align:center;">@{{ issue.issue_return_details[0].price | decimal }}</td>
                                <td style="text-align:center;">@{{ issue.issue_return_details[0].quantity | decimal }}</td>
                                <td>@{{ issue.issue_return_details[0].asset.disposal_status }}</td>
                                <td style="text-align:right;">@{{ issue.issue_return_details[0].total | decimal }}</td>
                                <td style="text-align:center;">
                                    <a href="" title="Issue return Invoice" v-bind:href="`/issue-return-invoice-print/${issue.id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                    {{-- @if(userAction('u'))
                                    <a href="" title="Edit Order" @click.prevent="issueEdit(issue)"><i class="fa fa-edit"></i></a>
                                    @endif --}}
                                    @if(userAction('d'))
                                    <a href="" title="Delete Issue Return" @click.prevent="deleteIssue(issue)"><i class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                            <tr v-for="(item, sl) in issue.issue_return_details.slice(1)">
                                <td colspan="3" :rowspan="issue.issue_return_details.length - 1" v-if="sl == 0"></td>
                                <td>@{{ item.asset.name }}</td>
                                <td style="text-align:center;">@{{ item.price | decimal }}</td>
                                <td style="text-align:center;">@{{ item.quantity | decimal }}</td>
                                <td></td>
                                <td style="text-align:right;">@{{ item.total | decimal }}</td>
                                <td></td>
                            </tr>
                            <tr style="font-weight:bold;">
                                <td colspan="5" style="font-weight:normal;text-align:left;"><strong>Note: </strong>@{{ issue.note }}</td>
                                <td style="text-align:center;">Total Quantity<br>@{{ issue.issue_return_details.reduce((prev, curr) => {return prev + parseFloat(curr.quantity)}, 0) | decimal }}</td>
                                <td></td>
                                <td style="text-align:right;">
                                    Total: @{{ issue.total | decimal }}
                                </td>
                                <td></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <table class="table table-bordered record-table table-condensed" v-if="filter.searchType != 'quantity' && filter.recordType == 'without'" style="display:none;" :style="{display: filter.searchType != 'quantity' && filter.recordType == 'without'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Date</th>
                            <th>Table Code</th>
                            <th>Table No.</th>
                            <th>Total</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(issue, index) in issues">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ issue.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ issue.table.code }}</td>
                            <td>@{{ issue.table.name }}</td>
                            <td style="text-align:right;">@{{ issue.total | decimal }}</td>
                            <td style="text-align:left;">@{{ issue.note }}</td>
                            <td style="text-align:center;">
                                <a href="" title="Issue Return Invoice" v-bind:href="`/issue-return-invoice-print/${issue.id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                {{-- @if(userAction('u'))
                                <a href="" title="Edit Order" @click.prevent="issueEdit(issue)"><i class="fa fa-edit"></i></a>
                                @endif --}}
                                @if(userAction('d'))
                                <a href="" title="Delete Issue Return" @click.prevent="deleteIssue(issue)"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="4" style="text-align:right;">Total</td>
                            <td style="text-align:right;">@{{ issues.reduce((prev, curr)=>{return prev + parseFloat(curr.total)}, 0) | decimal }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>

                </table>
                <table class="table table-bordered record-table table-condensed" v-if="filter.searchType == 'quantity'" style="display:none;" :style="{display: filter.searchType == 'quantity'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Date</th>
                            <th>Table No.</th>
                            <th>Asset Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(issue, index) in issues">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ issue.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ issue.table_name }}</td>
                            <td>@{{ issue.name }}</td>
                            <td style="text-align:right;">@{{ issue.price }}</td>
                            <td style="text-align:right;">@{{ issue.quantity }}</td>
                            <td>@{{ issue.disposal_status }}</td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="5" style="text-align:right;">Total Quantity</td>
                            <td style="text-align:right;">@{{ issues.reduce((prev, curr) => { return prev + parseFloat(curr.quantity)}, 0) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div style="display:none;" v-bind:style="{display: showReport == false ? '' : 'none'}">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="{{asset('loading.gif')}}" style="width: 90px;"> Loading..
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#issueList',
        data() {
            return {
                filter: {
                    searchType: "",
                    recordType: "without",
                    status: 'a',
                    dateFrom: moment().format("YYYY-MM-DD"),
                    dateTo: moment().format("YYYY-MM-DD"),
                },
                issues: [],
                issues2: [],

                tables: [],
                selectedTable: null,
                assets: [],
                selectedAsset: null,
                users: [],
                selectedUser: null,
                onProgress: false,
                showReport: null,
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

        methods: {
            // async issueEdit(row) {
            //     location.href = "/issue/" + row.id
            // },

            getUser() {
                axios.post("/get-user").then(res => {
                    this.users = res.data.users;
                })
            },

            getAsset() {
                axios.get("/get-asset").then(res => {
                    let r = res.data;
                    this.assets = r.filter(item => item.status == 'a').map((item, index) => {
                        item.display_name = `${item.name} - ${item.code}`
                        return item;
                    });
                })
            },

            getTables() {
                axios.get("/get-table").then(res => {
                    let r = res.data;
                    this.tables = r.map((item, index) => {
                        item.display_name = `${item.code} - ${item.name} `
                        return item;
                    });
                })
            },

            onChangeType(event) {
                this.issues = [];
                this.issues2 = [];
                this.selectedTable = null;
                this.selectedAsset = null;
                this.selectedUser = null;
                this.filter.tableId = "";
                this.filter.assetId = "";
                this.filter.userId = "";
                if (event.target.value == 'table') {
                    this.getTables();
                } else if (event.target.value == 'quantity') {
                    this.getAsset();
                } else if (event.target.value == 'user') {
                    this.getUser();
                }
            },

            getIssue() {
                if (this.filter.searchType == 'table') {
                    this.filter.tableId = this.selectedTable != null ? this.selectedTable.id : ""
                }
                if (this.filter.searchType == 'quantity') {
                    var url = '/get-issue-return-details';
                    this.filter.assetId = this.selectedAsset != null ? this.selectedAsset.id : ""
                } else {
                    var url = "/get-issue-return";
                    this.filter.userId = this.selectedUser != null ? this.selectedUser.id : ""
                }
                this.onProgress = true
                this.showReport = false
                axios.post(url, this.filter)
                    .then(res => {
                        let issues = res.data;
                        this.issues = issues;
                        this.issues2 = this.issues
                        this.onProgress = false
                        this.showReport = true
                    })
                    .catch(err => {
                        this.showReport = null
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

            async deleteIssue(row) {
                let formdata = {
                    id: row.id
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-issue-return", formdata)
                        .then(res => {
                            toastr.success(res.data.message)
                            this.getIssue();
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

            //search method here
            async onSearchTable(val, loading) {
                if (val.length > 2) {
                    loading(true)
                    await axios.post("/get-table", {
                        name: val
                    }).then(res => {
                        let r = res.data;
                        this.getTables = r.map((item, index) => {
                            item.display_name = `${item.code} - ${item.name}`
                            return item;
                        });
                        loading(false)
                    })
                } else {
                    loading(false)
                    await this.getTables();
                }
            },

            // print method hre
            async print() {
                let dateText = '';
                if (this.dateFrom != '' && this.dateTo != '') {
                    dateText = `Statement from <strong>${moment(this.filter.dateFrom).format('DD-MM-YYYY')}</strong> to <strong>${moment(this.filter.dateTo).format('DD-MM-YYYY')}</strong>`;
                }

                let userText = '';
                if (this.selectedUser != null && this.selectedUser.username != '' && this.filter.searchType == 'user') {
                    userText = `<strong>Sold by: </strong> ${this.selectedUser.username}`;
                }

                let tableText = '';
                if (this.selectedTable != null && this.selectedTable.id != '' && this.filter.searchType == 'table') {
                    tableText = `<strong>Table: </strong> ${this.selectedTable.name}<br>`;
                }

                let assetText = '';
                if (this.selectedAsset != null && this.selectedAsset.id != '' && this.filter.searchType == 'quantity') {
                    assetText = `<strong>Asset: </strong> ${this.selectedAsset.name}`;
                }

                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Issue Return Record</h4>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-6">
								${userText} ${tableText} ${assetText} 
							</div>
							<div class="col-xs-6 text-right">
								${dateText}
							</div>
						</div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportTable').innerHTML}
							</div>
						</div>
					</div>
				`;

                var mywindow = window.open('', '', `width=${screen.width}, height=${screen.height}`);
                mywindow.document.write(`
                    @include('administration/reports/reportHeader')
				`);
                mywindow.document.body.innerHTML += reportContent;

                if (this.filter.searchType != 'quantity') {
                    let rows = mywindow.document.querySelectorAll('.record-table tr');
                    rows.forEach(row => {
                        row.lastChild.remove();
                    })
                }

                mywindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                mywindow.print();
                mywindow.close();
            },

            // filter issuerecord
            filterArray(event) {
                this.issues = this.issues2.filter(issue => {
                    return issue.invoice.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
                        issue.date.toLowerCase().startsWith(event.target.value.toLowerCase());
                })
            },
        },
    })
</script>
@endpush