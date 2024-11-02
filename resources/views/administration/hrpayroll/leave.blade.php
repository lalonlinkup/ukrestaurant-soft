@extends('master')
@section('title', 'Leave Entry')
@section('breadcrumb_title', 'Leave Entry')
@push('style')
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }
</style>
@endpush
@section('content')
    <div id="Leave">
        <form @submit.prevent="saveLeave">
            <div class="row" style="margin:0;">
                <div class="col-md-12 col-xs-12" style="padding: 0;">
                    <fieldset class="scheduler-border bg-of-skyblue">
                        <legend class="scheduler-border">Leave Entry Form</legend>
                        <div class="control-group">
                            <div class="col-md-6" style="padding: 0;">
                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Date <sup
                                            class="text-danger">*</sup></label>
                                    <div class=" col-xs-8 col-md-7">
                                        <input type="date" class="form-control" name="date" v-model="leave.date"
                                            :disabled="userType == 'user' || userType == 'manager' ? true : false">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Employee <sup class="text-danger">*</sup>
                                    </label>
                                    <div class="col-xs-7 col-md-7"
                                        style="display: flex;align-items:center;margin-bottom:5px;">
                                        <div style="width: 100%;">
                                            <v-select :options="employees" style="margin: 0;" v-model="selectedEmployee"
                                                label="display_text"></v-select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Leave Type <sup
                                            class="text-danger">*</sup> </label>
                                    <div class="col-xs-7 col-md-7"
                                        style="display: flex;align-items:center;margin-bottom:5px;">
                                        <div style="width: 100%;">
                                            <v-select :options="leaveTypes" style="margin: 0;" v-model="selectedLeaveType"
                                                label="name"></v-select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">From Date <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-xs-8 col-md-7">
                                        <input type="date" class="form-control" name="from_date"
                                            v-model="leave.from_date" autocomplete="off" @change="dataOnchange" />
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">To Date <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-xs-8 col-md-7">
                                        <input type="date" class="form-control" name="to_date" v-model="leave.to_date"
                                            autocomplete="off" @change="dataOnchange" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="padding: 0;">
                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Total Day <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-xs-8 col-md-7">
                                        <input type="number" min="0" step="any" class="form-control"
                                            name="day" v-model="leave.days" readonly>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label col-xs-4 col-md-4">Reason </label>
                                    <div class="col-xs-8 col-md-7">
                                        <textarea name="reason" class="form-control" id="reason" cols="4" rows="4" v-model="leave.reason"></textarea>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="col-md-4"></label>
                                    <div class="col-md-7 text-right">
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
                    <datatable :columns="columns" :data="leaves" :filter-by="filter"
                        style="margin-bottom: 5px;">
                        <template scope="{ row }">
                            <tr :style="{ background: row.status == 'p' ? '#ffdb9a' : '' }"
                                :title="row.status == 'p' ? 'Inactive' : ''">
                                <td>@{{ row.sl }}</td>
                                <td>@{{ row.date }}</td>
                                <td>@{{ row.employee?.name }}</td>
                                <td>@{{ row.employee.designation ? row.employee.designation.name : '' }}</td>
                                <td>@{{ row.leave_type?.name }}</td>
                                <td>@{{ row.from_date }}</td>
                                <td>@{{ row.to_date }}</td>
                                <td>@{{ row.days }}</td>
                                <td>@{{ row.reason | textLimit }}</td>
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
            el: '#Leave',
            data() {
                return {
                    columns: [{
                            label: 'Sl',
                            field: 'sl',
                            align: 'center',
                            filterable: false
                        },
                        {
                            label: 'Date',
                            field: 'date',
                            align: 'center'
                        },
                        {
                            label: 'Employee Name',
                            field: 'employee.name',
                            align: 'center'
                        },
                        {
                            label: 'Designation',
                            field: 'employee.designation.name',
                            align: 'center'
                        },
                        {
                            label: 'Leave Type',
                            field: 'leave_type.name',
                            align: 'center'
                        },
                        {
                            label: 'Date From',
                            field: 'from_date',
                            align: 'center'
                        },
                        {
                            label: 'Date To',
                            field: 'to_date',
                            align: 'center'
                        },
                        {
                            label: 'Total Day',
                            field: 'days',
                            align: 'center'
                        },
                        {
                            label: 'Reason',
                            field: 'reason',
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

                    leave: {
                        id: "",
                        date: moment().format("YYYY-MM-DD"),
                        employee_id: null,
                        leave_type_id: null,
                        from_date: moment().add(1, 'days').format("YYYY-MM-DD"),
                        to_date: moment().add(1, 'days').format("YYYY-MM-DD"),
                        days: 0,
                        reason: "",
                    },
                    leaves: [],
                    employees: [],
                    selectedEmployee: null,
                    leaveTypes: [],
                    selectedLeaveType: null,
                    onProgress: false,
                    btnText: "Save",
                    userType: "{{ Auth::user()->role }}"
                }
            },

            filters: {
                textLimit(value) {
                    if (!value) return '';
                    if (value.length <= 30) {
                        return value;
                    }
                    return value.substring(0, 30) + '...';
                }
            },

            created() {
                this.getEmployee();
                this.getLeaveType();
                this.getLeave();
                this.dataOnchange();
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

                getLeave() {
                    axios.get("/get-leaves")
                        .then(res => {
                            let r = res.data;
                            this.leaves = r.map((item, index) => {
                                item.sl = index + 1
                                return item;
                            });
                        })
                },

                dataOnchange() {
                    let fromDate = moment(this.leave.from_date);
                    let toDate = moment(this.leave.to_date);
                    let totalDays = toDate.diff(fromDate, 'days') + 1;
                    this.leave.days = totalDays;
                },

                saveLeave(event) {
                    if (this.selectedEmployee == null) {
                        toastr.error('Select Employee.!');
                        return;
                    } else {
                        this.leave.employee_id = this.selectedEmployee.id;
                    }
                    if (this.selectedLeaveType == null) {
                        toastr.error('Select Leave Type.!');
                        return;
                    } else {
                        this.leave.leave_type_id = this.selectedLeaveType.id;
                    }
                    var url;
                    if (this.leave.id == '') {
                        url = '/leave';
                    } else {
                        url = '/update-leave';
                    }
                    this.onProgress = true
                    axios.post(url, this.leave)
                        .then(res => {
                            toastr.success(res.data.message);
                            this.getLeave();
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
                    let keys = Object.keys(this.leave);
                    keys.forEach(key => {
                        this.leave[key] = row[key];
                    });

                    if (row.employee_id != null) {
                        this.selectedEmployee = {
                            id: row.employee_id,
                            display_text: `${row.employee.code} - ${row.employee.name} - ${row.employee.phone}`
                        }
                    }

                    if(row.leave_type_id != null) {
                        this.selectedLeaveType = {
                            id: row.leave_type_id,
                            name: row.leave_type.name
                        }
                    }
                },

                deleteData(rowId) {
                    let formdata = {
                        id: rowId
                    }
                    if (confirm("Are you sure !!")) {
                        axios.post("/delete-leave", formdata)
                            .then(res => {
                                toastr.success(res.data)
                                this.getLeave();
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
                    this.leave = {
                        id: "",
                        date: moment().format("YYYY-MM-DD"),
                        employee_id: null,
                        leave_type_id: null,
                        from_date: moment().add(1, 'days').format("YYYY-MM-DD"),
                        to_date: moment().add(1, 'days').format("YYYY-MM-DD"),
                        days: 0,
                        reason: 0
                    }
                    this.selectedEmployee = null;
                    this.selectedLeaveType = null;
                    this.dataOnchange();
                },
            }
        })
    </script>
@endpush
