@extends('master')
@section('title', 'Employee List')
@section('breadcrumb_title', 'Employee List')
@push('style')
<style scoped>
	.v-select .dropdown-toggle {
		padding: 0px;
		height: 30px !important;
	}

	.v-select .dropdown-menu {
		width: auto !important;
		overflow-y: auto !important;
	}

	.emp-image {
		height: 40px;
		width: 40px;
		border: 1px solid #ada7a7;
		border-radius: 2px;
	}
</style>
@endpush
@section('content')
<div id="EmployeeList">
	<div class="row" style="margin: 0;">
		<fieldset class="scheduler-border bg-of-skyblue">
			<legend class="scheduler-border">Employee List</legend>
			<div class="control-group">
				<form @submit.prevent="getSearchResult">
					<div class="col-md-3 col-xs-12">
						<div class="form-group" style="display: flex;align-items:center;">
							<label for="" style="width:150px;margin:0;">Search Type</label>
							<select class="form-select" style="width: 100%;" v-model="searchType" @change="onChangeSearchType">
								<option value="">All</option>
								<option value="department">By Department</option>
								<option value="designation">By Designation</option>
							</select>
						</div>
					</div>
					<div class="col-md-2 col-xs-12" style="display:none;" :style="{display: searchType == 'department' && departments.length > 0 ? '' : 'none'}">
						<div class="form-group">
							<v-select :options="departments" v-model="selectedDepartment" label="name"></v-select>
						</div>
					</div>
					<div class="col-md-2 col-xs-12" style="display:none;" :style="{display: searchType == 'designation' && designations.length > 0 ? '' : 'none'}">
						<div class="form-group">
							<v-select :options="designations" v-model="selectedDesignation" label="name"></v-select>
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

	<div class="row" style="display:none;" :style="{display: employees.length > 0 && showReport ? '' : 'none'}">
		<div class="col-md-12 text-right">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-md-12">
			<div class="table-responsive" id="reportContent">
				<table class="record-table">
					<thead>
						<tr>
							<th>Sl</th>
							<th>Image</th>
							<th>Employee ID</th>
							<th>Name</th>
							<th>Designation</th>
							<th>Department</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="emp in employees">
							<tr>
								<td>@{{ emp.sl }}</td>
								<td style="text-align: center;">
									<img v-if="emp.image == null || emp.image == ''" class="emp-image" src="{{ asset('noImage.gif') }}" alt="">
									<img v-else class="emp-image" :src="`/${emp.image}`" alt="">
								</td>
								<td>@{{ emp.code }}</td>
								<td>@{{ emp.name }}</td>
								<td>@{{ emp.designation.name }}</td>
								<td>@{{ emp.department.name }}</td>
								<td>@{{ emp.phone }}</td>
								<td>@{{ emp.email }}</td>
								<td>
									<span class="badge badge-success" v-if="emp.status == 'a'">Active</span>
									<span class="badge badge-danger" v-else>Deactive</span>
								</td>
								<td style="text-align:center;">
									@if(userAction('u'))
									<a v-bind:href="`/employee/${emp.id}`" title="Edit Employee"><i class="fa fa-pencil"></i></a>
									@endif
									@if(userAction('d'))
									<i @click="deleteEmployee(emp.id)" class="fa fa-trash"></i>
									@endif
								</td>
							</tr>
						</template>
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
	var employeeList = new Vue({
		el: "#EmployeeList",

		data() {
			return {
				searchType: '',
				employees: [],
				designations: [],
				selectedDesignation: {
					id: '',
					name: 'Select Designation'
				},

				departments: [],
				selectedDepartment: {
					id: '',
					name: 'Select Department'
				},

				onProgress: false,
				showReport: null,
			}
		},

		methods: {
			getDesignation() {
				axios.get("/get-designation")
					.then(res => {
						this.designations = res.data;
					})
			},

			getDepartment() {
				axios.get("/get-department")
					.then(res => {
						this.departments = res.data;
					})
			},

			onChangeSearchType() {
				this.employees = [];
				if (this.searchType == 'department') {
					this.getDepartment();
				} else if (this.searchType == 'designation') {
					this.getDesignation();
				}
			},

			getSearchResult() {
				let filter = {
					departmentId: this.selectedDepartment == null || this.selectedDepartment.id == '' ? '' : this.selectedDepartment.id,
					designationId: this.selectedDesignation == null || this.selectedDesignation.id == '' ? '' : this.selectedDesignation.id,
				}

				this.onProgress = true
				this.showReport = false
				axios.post('/get-employee', filter)
					.then(res => {
						this.employees = res.data.map((item, sl) => {
							item.sl = sl + 1;
							return item;
						});
						this.showReport = true
						this.onProgress = false
					})
			},

			deleteEmployee(employeeId) {
				if (confirm("Are you sure !!")) {
					axios.post("/delete-employee", {
							id: employeeId
						})
						.then(res => {
							toastr.success(res.data)
							this.getSearchResult();
						})
						.catch(err => {
							var r = JSON.parse(err.request.response);
							toastr.error(r.message);
						})
				}
			},

			async print() {
				let departmentText = '';
				if (this.selectedDepartment != null && this.selectedDepartment.id != '' && this.searchType == 'department') {
					departmentText = `<strong>Department: </strong> ${this.selectedDepartment.name}<br>`;
				}

				let designationText = '';
				if (this.selectedDesignation != null && this.selectedDesignation.id != '' && this.searchType == 'designation') {
					designationText = `<strong>Designation: </strong> ${this.selectedDesignation.name}<br>`;
				}

				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Employee Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${departmentText} ${designationText}
							</div>
							<div class="col-xs-6 text-right">
								
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportContent').innerHTML}
							</div>
						</div>
					</div>
				`;

				var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
				reportWindow.document.write(`
					@include('administration/reports/reportHeader')
				`);

				reportWindow.document.head.innerHTML += `
					<style>
						.record-table{
							width: 100%;
							border-collapse: collapse;
						}
						.record-table thead{
							background-color: #0097df;
							color:white;
						}
						.record-table th, .record-table td{
							padding: 3px;
							border: 1px solid #454545;
						}
						.record-table th{
							text-align: center;
						}
						.emp-image {
							height: 40px;
							width: 40px;
						}
					</style>
				`;
				reportWindow.document.body.innerHTML += reportContent;

				let rows = reportWindow.document.querySelectorAll('.record-table tr');
				rows.forEach(row => {
					row.lastChild.remove();
				})

				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
		}
	})
</script>
@endpush