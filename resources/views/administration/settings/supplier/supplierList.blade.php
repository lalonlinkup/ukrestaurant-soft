@extends('master')
@section('title', 'Supplier List')
@section('breadcrumb_title', 'Supplier List')
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
<div id="supplierList">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Supplier List</legend>
            <div class="control-group">
                <form @submit.prevent="getSupplier">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Select Type</label>
                            <select class="form-select no-padding" style="width: 100%;" v-model="searchType" @change="onChangeSearchType">
                                <option value="">All</option>
                                <option value="area">By Area</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'supplier'" style="display: none;" :style="{display: searchType == 'supplier' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="suppliers" v-model="selectedSupplier" label="display_name" @search="onSearchSupplier"></v-select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'area'" style="display: none;" :style="{display: searchType == 'area' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="districts" v-model="selectedDistrict" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-1 col-xs-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="padding: 0 6px;">Show Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>
    <div class="row" style="display:none;margin:0;" v-bind:style="{display: suppliers.length > 0 && showReport ? '' : 'none'}">
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
                                <th>Supplier Code</th>
                                <th>Supplier Name</th>
                                <th>Owner Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in suppliers">
                                <td style="text-align:center;">@{{ sl + 1 }}</td>
                                <td>@{{ item.code }}</td>
                                <td>@{{ item.name }}</td>
                                <td>@{{ item.owner_name}}</td>
                                <td>@{{ item.address}}</td>
                                <td>@{{ item.phone}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-if="suppliers.length == 0 && showReport">
        <div class="col-md-12" style="text-align: center;">
            Data Not Found
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
        el: '#supplierList',
        data() {
            return {
                searchType: '',
                districts: [],
                selectedDistrict: null,
                
                suppliers: [],
                showReport: null,
            }
        },

        filters: {
            decimal(value) {
                return value == null ? parseFloat(0).toFixed(2) : parseFloat(value).toFixed(2);
            }
        },

        created() {
            this.getSupplier();
        },

        methods: {
            getDistrict() {
                axios.get("/get-district")
                    .then(res => {
                        this.districts = res.data;
                    })
            },
            onChangeSearchType() {
                this.suppliers = [];
                this.selectedDistrict = null
                if (this.searchType == 'area') {
                    this.getDistrict();
                }
            },
            getSupplier() {
                let filter = {
                    districtId: this.selectedDistrict == null ? '' : this.selectedDistrict.id
                }
                this.showReport = false
                axios.post("/get-supplier", filter)
                    .then(res => {
                        let r = res.data;
                        this.suppliers = r.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code}`
                            return item;
                        });
                        this.showReport = true
                    })
            },

            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Supplier List</h4>
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