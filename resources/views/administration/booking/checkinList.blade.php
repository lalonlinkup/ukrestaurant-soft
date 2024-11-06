@extends('master')
@section('title', 'Checkin Table List')
@section('breadcrumb_title', 'Checkin Table List')
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
</style>
@endpush
@section('content')
<div id="tableList">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Checkin Table List Search</legend>
            <div class="control-group">
                <form @submit.prevent="getCheckinList">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeSearchType" style="width: 100%;" v-model="searchType">
                                <option value="">All</option>
                                <option value="category">By Category</option>
                                <option value="tabletype">By Table Type</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'category'" style="display: none;" :style="{display: searchType == 'category' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="categories" id="category" v-model="selectedCategory" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'tabletype'" style="display: none;" :style="{display: searchType == 'tabletype' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="tabletypes" id="category" v-model="selectedTableType" label="name"></v-select>
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
    <div style="display:none;" v-bind:style="{display: tables.length > 0 && showReport ? '' : 'none'}">
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
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Table Name</th>
                                <th>Table Type</th>
                                <th>Customer</th>
                                <th>AreaName</th>
                                <th>Checkin</th>
                                <th>Checkout</th>
                                <th>Total Days</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in tables">
                                <td style="text-align:center;">@{{ sl + 1 }}</td>
                                <td style="text-align: left !important;">@{{ item.name }}</td>
                                <td>@{{ item.tabletype_name }}</td>
                                <td>
                                    @{{item.customers?.customer_name}} - @{{item.customers?.customer_code}}
                                </td>
                                <td>@{{item.customers?.area_name}}</td>
                                <td>@{{ item.details[0].checkin_date | dateFormat("DD-MM-YYYY") }}</td>
                                <td>@{{ item.details[0].checkout_date | dateFormat("DD-MM-YYYY") }}</td>
                                <td>@{{ item.details[0].days }}</td>
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
        el: '#tableList',
        data() {
            return {
                searchType: '',
                tables: [],

                categories: [],
                selectedCateogry: null,

                tabletypes: [],
                selectedTableType: null,

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
            getCategory() {
                axios.get("/get-category").then(res => {
                    this.categories = res.data
                })
            },
            getTableType() {
                axios.get("/get-tabletype").then(res => {
                    this.tabletypes = res.data
                })
            },
            onChangeSearchType() {
                this.tabletypes = [];
                this.selectedCategory = null;
                this.selectedTableType = null;
                if (this.searchType == 'category') {
                    this.getCategory();
                }
                if (this.searchType == 'tabletype') {
                    this.getTableType();
                }
            },
            getCheckinList() {
                let filter = {
                    typeId: this.selectedTableType != null ? this.selectedTableType.id : '',
                    categoryId: this.selectedCategory != null ? this.selectedCategory.id : '',
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-checkin-list", filter).then(res => {
                    let r = res.data;
                    this.tables = r.filter(item => item.status == 'a')
                    this.onProgress = false
                    this.showReport = true
                }).catch(err => {
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
                                <h4 style="text-align:center">Table List</h4>
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