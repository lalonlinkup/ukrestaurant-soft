@extends('master')
@section('title', 'Employee Salary')
@section('breadcrumb_title', 'Employee Salary')
@push('style')
<style scoped>
	table th {
		font-size: 12px;
	}

	td,
	td input {
		font-size: 10px !important;
	}
</style>
@endpush
@section('content')
<div id="EmployeeSalary">
	<div class="row" style="margin:0;">
		<fieldset class="scheduler-border bg-of-skyblue">
			<legend class="scheduler-border">Employee Salary Payment</legend>
			<div class="control-group">
				<form @submit.prevent="getEmployees">
					<div class="col-md-3 col-xs-12">
						<div class="form-group" style="display: flex;align-items:center;">
							<label class="col-xs-3 control-label no-padding-right" for="bdaymonth"> Month </label>
							<div class="col-xs-9 no-padding">
								<input type="month" style="height: 30px;" class="form-control" @change="changeMonth" id="bdaymonth" v-model="salary.month">
							</div>
						</div>
					</div>

					<div class="col-md-1 col-xs-12">
						<div class="form-group">
							<button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Show</button>
						</div>
					</div>
				</form>
			</div>
		</fieldset>
	</div>

	<div class="row" style="display: flex;justify-content:space-between;" v-if="filterEmployees.length > 0">
		<div class="col-md-3" v-if="filterEmployees.length > 0" style="display:none;" :style="{display: filterEmployees.length > 0 ? '' : 'none'}">
			<input type="search" @input="filterArray($event)" placeholder="Search..." class="form-control">
		</div>
		<div class="col-md-9 text-right">
			<label>Salary Date: </label>
			<input style="height: 25px;" name="date" type="date" v-model="salary.date">
		</div>
	</div>

	<div class="row" style="display: none" :style="{ display: employees.length > 0 ? '' : 'none' }">
		<div class="col-md-12">

			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>SL</th>
							<th>Employee Id</th>
							<th>Name</th>
							<th>Department</th>
							<th>Designation</th>
							<th>Salary</th>
							<th>Ovetime / Other Benefit</th>
							<th>Deduction</th>
							<th>Net Payable</th>
							<th>Paid</th>
							<th>Comment</th>
						</tr>
					</thead>
					<tbody>
						<template v-if="payment == false">
							<tr v-for="(employee, i) in employees" v-bind:style="{background: employee.net_payable != employee.payment ? 'orange' : ''}">
								<td>@{{ ++i }}</td>
								<td>@{{ employee.code }}</td>
								<td>@{{ employee.name }}</td>
								<td>@{{ employee.department.name }}</td>
								<td>@{{ employee.designation.name }}</td>
								<td style="text-align: center;">@{{ employee.salary | decimal }}</td>
								<td><input style="width: 100px;height: 20px; text-align:center;" type="number" v-model="employee.benefit" v-on:input="calculateNetPayable(employee)"></td>
								<td><input style="width: 100px;height: 20px; text-align:center;" type="number" v-model="employee.deduction" v-on:input="calculateNetPayable(employee)"></td>
								<td style="text-align: center;">@{{employee.net_payable | decimal}}</td>
								<td><input style="width: 100px;height: 20px; text-align:center;" type="number" v-model="employee.payment" v-on:input="checkPayment(employee)"></td>
								<td><textarea style="height: 23px;" cols="" rows="1" v-model="employee.comment"></textarea></td>
							</tr>
						</template>
						<template v-else>
							<tr v-for="(item, i) in employees" v-bind:style="{background: item.net_payable != item.payment ? 'orange' : ''}">
								<td>@{{ ++i }}</td>
								<td>@{{ item.employee.code }}</td>
								<td>@{{ item.employee.name }}</td>
								<td>@{{ item.employee.department.name }}</td>
								<td>@{{ item.employee.designation.name }}</td>
								<td style="text-align: center;">@{{ item.salary | decimal }}</td>
								<td><input style="width: 100px;height: 20px; text-align:center;" type="number" v-model="item.benefit" v-on:input="calculateNetPayable(item)"></td>
								<td><input style="width: 100px;height: 20px; text-align:center;" type="number" v-model="item.deduction" v-on:input="calculateNetPayable(item)"></td>
								<td style="text-align: center;">@{{item.net_payable | decimal}}</td>
								<td><input style="width: 100px;height: 20px; text-align:center;" type="number" v-model="item.payment" v-on:input="checkPayment(item)"></td>
								<td><textarea style="height: 23px;" cols="" rows="1" v-model="item.comment"></textarea></td>
							</tr>
						</template>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="9" style="text-align: right;">Total=</td>
							<td>@{{ employees.reduce((prev, curr)=>{ return prev + parseFloat(curr.payment) }, 0) | decimal }}</td>
							<td></td>
						</tr>
						<tr>
							<td colspan="11">
								@if(userAction('u') || userAction('e'))
								<button type="button" @click="SaveSalaryPayment" name="btnSubmit" class="btn btn-sm btn-success pull-right">
									@{{ btnText }}
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>
								@endif
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@push('script')
<script>
	var employeeSalary = new Vue({
		el: "#EmployeeSalary",

		data() {
			return {
				salary: {
					id: null,
					date: moment().format("YYYY-MM-DD"),
					month: moment().format("YYYY-MM"),
				},

				employees: [],
				filterEmployees: [],
				payment: false,
				onProgress: false,
				btnText: "Save",
			}
		},

		filters: {
			decimal(value) {
				return value == null ? parseFloat(0).toFixed(2) : parseFloat(value).toFixed(2);
			}
		},

		methods: {

			checkPayment(employee) {
				if (parseFloat(employee.payment) > parseFloat(employee.net_payable)) {
					alert("Can not paid greater than net payable");
					employee.payment = employee.net_payable;
				}
			},

			calculateNetPayable(employee) {
				let payable = ((parseFloat(employee.salary) + parseFloat(employee.benefit)) - parseFloat(employee.deduction)).toFixed(2);

				employee.net_payable = payable;
				employee.payment = payable;
			},

			async getEmployees() {
				if (this.salary.month == '') {
					alert("Please Choose Month");
					return;
				}
				var month = this.salary.month;

				await axios.post('/check-payment-month', {
						month
					})
					.then(res => {
						this.payment = false;
						if (res.data.success) {
							this.payment = true;
						}
					})

				if (this.payment) {
					this.btnText = 'Update';
					await axios.post('/get-payments', {
						month: month,
						details: true
					}).then(res => {
						let payment = res.data[0];
						this.salary.id = payment.id;
						this.salary.date = payment.date;
						this.salary.month = payment.month;
						this.employees = payment.details;
						this.filterEmployees = payment.details;
					})
				} else {
					this.btnText = 'Save';
					await axios.get('/get-employee').then(res => {
						let employees = res.data;

						employees.map(employee => {
							employee.salary = employee.salary;
							employee.benefit = 0;
							employee.deduction = 0;
							employee.net_payable = employee.salary;
							employee.payment = employee.salary;
							employee.comment = '';
							return employee;
						});

						this.employees = employees;
						this.filterEmployees = employees;
						this.salary.date = moment().format("YYYY-MM-DD");
					})
				}
			},

			SaveSalaryPayment() {
				let data = {
					payment: this.salary,
					employees: this.employees,
				}
				this.onProgress = true;
				let url = '/add-salary-payment';
				if (this.payment) {
					url = '/update-salary-payment';
				}

				axios.post(url, data)
					.then(res => {
						let r = res.data;
						toastr.success(r);
						this.clearForm();
						this.onProgress = false;
					})
			},

			clearForm() {
				this.salary = {
					id: null,
					date: moment().format("YYYY-MM-DD"),
					month: moment().format("YYYY-MM"),
				}
				this.changeMonth();
				this.btnText = 'Save';
			},

			changeMonth() {
				this.employees = [];
				this.filterEmployees = [];
			},

			// filter salerecord
			filterArray(event) {
				if (this.payment) {
					this.employees = this.filterEmployees.filter(emp => {
						return emp.employee.code.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
							emp.employee.name.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
							emp.employee.department.name.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
							emp.employee.designation.name.toLowerCase().startsWith(event.target.value.toLowerCase());
					})
				} else {
					this.employees = this.filterEmployees.filter(emp => {
						return emp.code.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
							emp.name.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
							emp.department.name.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
							emp.designation.name.toLowerCase().startsWith(event.target.value.toLowerCase());
					})
				}
			},
		}
	})
</script>
@endpush