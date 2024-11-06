@extends('master')
@section('title', 'Table List')
@section('breadcrumb_title', 'Table List')
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
            <legend class="scheduler-border">Table List Search</legend>
            <div class="control-group">
                <form @submit.prevent="getTables">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeSearchType" style="width: 100%;" v-model="searchType">
                                <option value="">All</option>
                                <option value="floor">By Floor</option>
                                <option value="incharge">By Incharge</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'floor'" style="display: none;" :style="{display: searchType == 'floor' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="floors" id="floor" v-model="selectedFloor" label="name" placeholder="Select Floor"></v-select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'incharge'" style="display: none;" :style="{display: searchType == 'incharge' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="incharges" id="incharge" v-model="selectedIncharge" label="name" placeholder="Select Incharge"></v-select>
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
                                <th>Table ID</th>
                                <th>Table Name</th>
                                <th>Table Type</th>
                                <th>Floor</th>
                                <th>Incharge</th>
                                <th>Capacity</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in tables">
                                <td style="text-align:center;">@{{ sl + 1 }}</td>
                                <td>@{{ item.code }}</td>
                                <td style="text-align: left !important;">@{{ item.name }}</td>
                                <td>@{{ item.tabletype_name }}</td>
                                <td>@{{ item.floor_name }}</td>
                                <td>@{{ item.incharge_name }}</td>
                                <td>@{{ item.capacity }}</td>
                                <td>@{{ item.location }}</td>
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

                floors: [],
                selectedFloor: null,

                incharges: [],
                selectedIncharge: null,

                tabletypes: [],
                selectedTableType: null,

                onProgress: false,
                showReport: null,
            }
        },

        methods: {
            getFloor() {
                axios.get("/get-floor").then(res => {
                    this.floors = res.data
                })
            },
            getIncharge() {
                axios.get("/get-employee").then(res => {
                    this.incharges = res.data
                })
            },
            getTableType() {
                axios.get("/get-tabletype").then(res => {
                    this.tabletypes = res.data
                })
            },
            onChangeSearchType() {
                this.tabletypes = [];
                if (this.searchType == 'floor') {
                    this.getFloor();
                }
                if (this.searchType == 'incharge') {
                    this.getIncharge();
                }
                if (this.searchType == 'tabletype') {
                    this.getTableType();
                }
            },
            getTables() {
                if (this.searchType != 'tabletype') {
                    this.selectedTableType = null;
                }
                if (this.searchType != 'floor') {
                    this.selectedFloor = null;
                }
                if (this.searchType != 'incharge') {
                    this.selectedIncharge = null;
                }

                let filter = {
                    tabletypeId: this.selectedTableType != null ? this.selectedTableType.id : '',
                    floorId: this.selectedFloor != null ? this.selectedFloor.id : '',
                    inchargeId: this.selectedIncharge != null ? this.selectedIncharge.id : ''
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-table", filter).then(res => {
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