@extends('master')
@section('title', 'Asset List')
@section('breadcrumb_title', 'Asset List')
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
<div id="assetList">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Asset List Search</legend>
            <div class="control-group">
                <form @submit.prevent="getAsset">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeSearchType" style="width: 100%;" v-model="searchType">
                                <option value="">All</option>
                                <option value="brand">By Brand</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'brand'" style="display: none;" :style="{display: searchType == 'brand' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="brands" id="brand" v-model="selectedBrand" label="name"></v-select>
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
    <div style="display:none;" v-bind:style="{display: assets.length > 0 && showReport ? '' : 'none'}">
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
                                <th>Asset Name</th>
                                <th>Asset Code</th>
                                <th>Brand Name</th>
                                <th>Unit Name</th>
                                <th>Origin</th>
                                <th style="text-align: right;">Price</th>
                                <th>Is Active</th>
                                <th>Is Serial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in assets">
                                <td style="text-align:center;">@{{ sl + 1 }}</td>
                                <td style="text-align: left !important;">@{{ item.name }}</td>
                                <td>@{{ item.code }}</td>
                                <td>@{{ item.brand_name }}</td>
                                <td>@{{ item.unit_name }}</td>
                                <td>@{{ item.origin }}</td>
                                <td style="text-align: right;">@{{ item.price }}</td>
                                <td style="text-align: center;">
                                    <span class="badge badge-success" v-if="item.is_active == 1">True</span>
                                    <span class="badge badge-danger" v-else>False</span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge badge-success" v-if="item.is_serial == 1">True</span>
                                    <span class="badge badge-danger" v-else>False</span>
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
        el: '#assetList',
        data() {
            return {
                searchType: '',
                assets: [],

                brands: [],
                selectedBrand: null,

                onProgress: false,
                showReport: null,
            }
        },

        methods: {
            getBrand() {
                axios.get("/get-brand")
                    .then(res => {
                        this.brands = res.data
                    })
            },

            onChangeSearchType() {
                this.brands = [];
                if (this.searchType == 'brand') {
                    this.getBrand();
                }
            },

            getAsset() {
                let filter = {
                    brandId: this.selectedBrand != null ? this.selectedBrand.id : ''
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-asset", filter)
                    .then(res => {
                        let r = res.data;
                        this.assets = r.filter(item => item.status != 'd')
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
                                <h4 style="text-align:center">Asset List</h4 style="text-align:center">
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