@extends('master')
@section('title', 'Guest Due List')
@section('breadcrumb_title', 'Guest Due List')
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
        width: 350px !important;
        overflow-y: auto !important;
    }
</style>
@endpush
@section('content')
<div id="customerdueList">
    <fieldset class="scheduler-border bg-of-skyblue">
        <legend class="scheduler-border">Guest Due List</legend>
        <div class="control-group">
            <div class="row" style="margin: 0;">
                <form @submit.prevent="getCustomerDue">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" style="width: 100%;" v-model="searchType" @change="onChangeSearchType">
                                <option value="">All</option>
                                <option value="customer">By Guest</option>
                                <option value="area">By Area</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'customer'" style="display: none;" :style="{display: searchType == 'customer' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="customers" v-model="selectedCustomer" label="display_name" @search="onSearchCustomer"></v-select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'area'" style="display: none;" :style="{display: searchType == 'area' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="districts" v-model="selectedDistrict" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-1 col-xs-12">
                        <div class="form-group">
                            <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Show Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </fieldset>
    <div class="row" style="display: flex;justify-content:space-between;">
        <div class="col-md-3" v-if="filterDues.length > 0" style="display:none;" :style="{display: filterDues.length > 0 ? '' : 'none'}">
            <input type="search" @input="filterArray($event)" placeholder="Search..." class="form-control">
        </div>
        <div class="col-md-9 text-right">
            <a v-if="dues.length > 0" style="display:none;" :style="{display: dues.length > 0 ? '' : 'none'}" href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
    </div>
    <div style="display:none;" v-bind:style="{display: dues.length > 0 && showReport ? '' : 'none'}">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" id="reportTable">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Guest Code</th>
                                <th>Guest Name</th>
                                <th>Owner Name</th>
                                <th>Area</th>
                                <th>Phone</th>
                                <th>Due Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in dues">
                                <td style="text-align:center;">@{{ sl + 1 }}</td>
                                <td>@{{ item.code }}</td>
                                <td>@{{ item.name }}</td>
                                <td>@{{ item.owner_name}}</td>
                                <td>@{{ item.areaName}}</td>
                                <td>@{{ item.phone}}</td>
                                <td style="text-align: right">@{{ item.dueAmount | decimal}}</td>
                            </tr>
                            <tr>
                                <th colspan="6">Total Due</th>
                                <th style="text-align: right;">@{{dues.reduce((prev, curr) => {return prev + +parseFloat(curr.dueAmount)}, 0) | decimal}}</th>
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
        el: '#customerdueList',
        data() {
            return {
                searchType: '',
                dues: [],
                filterDues: [],
                customers: [],
                selectedCustomer: null,
                districts: [],
                selectedDistrict: null,

                onProgress: false,
                showReport: null,
            }
        },

        filters: {
            decimal(value) {
                let fixed = "{{session('organization')->fixed}}";
                return value == null ? parseFloat(0).toFixed(fixed) : parseFloat(value).toFixed(fixed);
            }
        },

        methods: {
            getDistrict() {
                axios.get("/get-district")
                    .then(res => {
                        this.districts = res.data.data;
                    })
            },
            getCustomer() {
                let filter = {
                    forSearch: 'yes'
                }
                axios.post("/get-customer", filter)
                    .then(res => {
                        let r = res.data.data;
                        this.customers = r.customers.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code}`
                            return item;
                        });
                    })
            },
            async onSearchCustomer(val, loading) {
                if (val.length > 2) {
                    loading(true)
                    await axios.post("/get-customer", {
                            name: val
                        })
                        .then(res => {
                            let r = res.data.data;
                            this.customers = r.customers.map((item, index) => {
                                item.display_name = `${item.name} - ${item.code}`
                                return item;
                            });
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getCustomer();
                }
            },
            onChangeSearchType() {
                this.dues = [];
                this.filterDues = [];
                this.selectedCustomer = null
                this.selectedDistrict = null
                if (this.searchType == 'customer') {
                    this.getCustomer();
                }
                if (this.searchType == 'area') {
                    this.getDistrict();
                }
            },
            getCustomerDue() {
                let filter = {
                    customerId: this.selectedCustomer != null ? this.selectedCustomer.id : '',
                    districtId: this.selectedDistrict != null ? this.selectedDistrict.id : ''
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-customer-due", filter)
                    .then(res => {
                        let r = res.data;
                        this.dues = r.filter(item => item.dueAmount != 0);
                        this.filterDues = this.dues
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

            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Guest Due List</h4>
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
            },

            // filter salerecord
            filterArray(event) {
                this.dues = this.filterDues.filter(due => {
                    return due.code.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
                        due.name.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
                        due.phone.toLowerCase().startsWith(event.target.value.toLowerCase());
                })
            },
        },
    })
</script>
@endpush