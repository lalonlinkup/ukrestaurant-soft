@extends('master')
@section('title', 'Rentaurant Menu List')
@section('breadcrumb_title', 'Rentaurant Menu List')
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
<div id="menuList">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Rentaurant Menu List Search</legend>
            <div class="control-group">
                <form @submit.prevent="getMenu">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeSearchType" style="width: 100%;" v-model="searchType">
                                <option value="">All</option>
                                <option value="category">By Category</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'category'" style="display: none;" :style="{display: searchType == 'category' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="categories" id="category" v-model="selectedCategory" label="name"></v-select>
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
    <div style="display:none;" v-bind:style="{display: menus.length > 0 && showReport ? '' : 'none'}">
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
                                <th>Menu ID</th>
                                <th>Menu Name</th>
                                <th>Category Name</th>
                                <th>Unit Name</th>
                                <th>vat</th>
                                <th style="text-align: right;">Sale Rate</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in menus">
                                <td style="text-align:center;">@{{ sl + 1 }}</td>
                                <td>@{{ item.code }}</td>
                                <td style="text-align: left !important;">@{{ item.name }}</td>
                                <td>@{{ item.category_name }}</td>
                                <td>@{{ item.unit_name }}</td>
                                <td>@{{ item.vat }}</td>
                                <td style="text-align: right;">@{{ item.sale_rate }}</td>
                                <td style="text-align: center;">
                                    <span class="badge badge-success" v-if="item.status == 'a'">Active</span>
                                    <span class="badge badge-danger" v-else>Inactive</span>
                                </td>
                                <td>
                                    <i @click="updateStatus(item.id)" :style="{color: item.status == 'a' ? 'green' : 'red'}" class="icon-size" :class="item.status == 'a' ? 'bi bi-toggle-on' : 'bi bi-toggle-off'"></i>
                                </td>
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
        el: '#menuList',
        data() {
            return {
                searchType: '',
                menus: [],

                categories: [],
                selectedCategory: null,

                onProgress: false,
                showReport: null,
            }
        },

        methods: {
            getCategory() {
                axios.get("/get-menu-category")
                    .then(res => {
                        this.categories = res.data
                    })
            },

            onChangeSearchType() {
                this.categories = [];
                if (this.searchType == 'category') {
                    this.getCategory();
                }
            },

            getMenu() {
                let filter = {
                    categoryId: this.selectedCategory != null ? this.selectedCategory.id : ''
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-menu", filter)
                    .then(res => {
                        let r = res.data;
                        this.menus = r.filter(item => item.status != 'd')
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

            updateStatus(rowId) {
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/update-status", formdata)
                        .then(res => {
                            toastr.success(res.data)
                            this.getMenu();
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

            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Rastaurant Menu List</h4 style="text-align:center">
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

                let rows = mywindow.document.querySelectorAll('.record-table tr');
                rows.forEach(row => {
                    row.lastChild.remove();
                })

                mywindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                mywindow.print();
                mywindow.close();
            }
        },
    })
</script>
@endpush