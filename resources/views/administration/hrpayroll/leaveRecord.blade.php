@extends('master')
@section('title', 'Leave Record')
@section('breadcrumb_title', 'Leave Record')
@push('style')
<style scoped>
    table>thead>tr>th {
        text-align: center;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
        height: 30px !important;
    }

    .v-select .dropdown-menu {
        width: 100% !important;
    }
    .icon-size {
        font-size: 16px;
    }
</style>
@endpush
@section('content')
<div id="leaveRecord">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Leave Record Search</legend>
            <div class="control-group">
                <form @submit.prevent="getLeave">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeSearchType" style="width: 100%;" v-model="searchType">
                                <option value="">All</option>
                                <option value="employee">By Employee</option>
                                <option value="type">By Leave Type</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'employee'" style="display: none;" :style="{display: searchType == 'employee' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="employees" id="employee" v-model="selectedEmployee" label="display_text"></v-select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'type'" style="display: none;" :style="{display: searchType == 'type' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="leaveTypes" id="type" v-model="selectedLeaveType" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="dateFrom">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="dateTo">
                        </div>
                    </div>
                    <div class="col-md-1 col-xs-12">
                        <div class="form-group">
                            <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Show Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>
    <div style="display:none;" v-bind:style="{display: leaves.length > 0 && showReport ? '' : 'none'}">
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="" v-on:click.prevent="print">
                    <i class="fa fa-print"></i> Print
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" id="reportTable">
                    <table class="table table-bordered table-condensed record-table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Employee Name</th>
                                <th>Employee Phone</th>
                                <th>Designation</th>
                                <th>Leave Type</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Total Day</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in leaves">
                                <td style="text-align:center;">@{{ sl + 1 }}</td>
                                <td>@{{ item.date }}</td>
                                <td>@{{ item.employee?.name }}</td>
                                <td>@{{ item.employee?.phone }}</td>
                                <td>@{{ item.employee.designation ? item.employee.designation.name : '' }}</td>
                                <td>@{{ item.leave_type?.name }}</td>
                                <td>@{{ item.from_date }}</td>
                                <td>@{{ item.to_date }}</td>
                                <td>@{{ item.days }}</td>
                                <td>@{{ item.reason }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
        el: '#leaveRecord',
        data() {
            return {
                searchType: '',
                dateFrom: moment().format("YYYY-MM-DD"),
                dateTo: moment().format("YYYY-MM-DD"),
                leaves: [],

                employees: [],
                selectedEmployee: null,
                leaveTypes: [],
                selectedLeaveType: null,

                onProgress: false,
                showReport: null,
            }
        },

        methods: {
            getEmployee() {
                axios.get("/get-employee")
                    .then(res => {
                        let employee = res.data;
                        this.employees = employee.map(item => {
                            item.display_text = `${item.code} - ${item.name} - ${item.phone}`;
                            return item;
                        });
                    })
            },

            getLeaveType() {
                axios.get("/get-leave-type")
                    .then(res => {
                        this.leaveTypes = res.data;
                    })
            },

            onChangeSearchType() {
                this.selectedEmployee = null;
                this.categories = [];
                this.selectedLeaveType = null;
                this.leaveTypes = [];
                if (this.searchType == 'employee') {
                    this.getEmployee();
                }
                if (this.searchType == 'type') {
                    this.getLeaveType();
                }
            },

            getLeave() {
                let filter = {
                    employeeId: this.selectedEmployee != null ? this.selectedEmployee.id : '',
                    typeId: this.selectedLeaveType != null ? this.selectedLeaveType.id : '',
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-leaves", filter)
                    .then(res => {
                        let r = res.data;
                        this.leaves = r.filter(item => item.status != 'd')
                        this.onProgress = false
                        this.showReport = true
                    })
                    .catch(err => {
                        this.onProgress = false
                        this.showReport = null
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

            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Leave Record</h4 style="text-align:center">
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

                mywindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                mywindow.print();
                mywindow.close();
            }
        },
    })
</script>
@endpush