@extends('master')
@section('title', 'Material Stock')
@section('breadcrumb_title', 'Material Stock')
@push('style')
<style scoped>
    .v-select .dropdown-toggle {
        padding: 0px;
        height: 30px !important;
    }

    .v-select .dropdown-menu {
        width: 100% !important;
        overflow-y: auto !important;
    }

    table>thead>tr>th {
        text-align: center;
    }
</style>
@endpush
@section('content')
<div id="materialStock">
    <fieldset class="scheduler-border bg-of-skyblue">
        <legend class="scheduler-border">Stock Report</legend>
        <div class="control-group">
            <div class="row" style="margin: 0;">
                <form @submit.prevent="getMaterialStock">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Select Type</label>
                            <select class="form-select no-padding" style="width: 100%;" @change="onChangeStock" v-model="searchType">
                                <option value="total">Total Stock</option>
                                <option value="material">Material Wise Stock</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'material'" style="display: none;" :style="{display: searchType == 'material' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="materials" id="material" v-model="selectedMaterial" label="name" placeholder="Select Material" @search="onSearchMaterial"></v-select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" name="date" style="height: 30px;" class="form-control" v-model="date" />
                        </div>
                    </div>
                    <div class="col-md-1 col-xs-12">
                        <div class="form-group">
                            <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Show Stock</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </fieldset>
    <div class="row" style="display: flex;justify-content:space-between;align-items:center;">
        <div class="col-md-3" v-if="stocks2.length > 0" style="display:none;" :style="{display: stocks2.length > 0 ? '' : 'none'}">
            <input type="search" @input="filterArray($event)" placeholder="Search..." class="form-control">
        </div>
        <div class="col-md-9 text-right">
            <a v-if="stocks.length > 0" style="display:none;" :style="{display: stocks.length > 0 ? '' : 'none'}" href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>
        </div>

    </div>
    <div class="row" v-if="stocks.length > 0 && showReport" style="display:none;" :style="{display: stocks.length > 0 && showReport ? '' : 'none'}">
        <div class="col-md-12">
            <div class="table-responsive" id="reportTable">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Material Name</th>
                            <th>Purchase Qty</th>
                            <th>Production Qty</th>
                            <th>Current Qty</th>
                            <th>Price</th>
                            <th>Stock Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, sl) in stocks">
                            <td>@{{ sl + 1 }}</td>
                            <td style="text-align: left;">@{{ item.name }}</td>
                            <td>@{{ item.purchased_quantity | decimal }}</td>
                            <td>@{{ item.production_quantity | decimal }}</td>
                            <td>@{{ item.current_quantity | decimal }} @{{ item.unit_name }}</td>
                            <td>@{{ item.price | decimal }}</td>
                            <td style="text-align: right;">@{{ item.stockValue | decimal }}</td>
                        </tr>
                        <tr>
                            <th colspan="4" style="text-align:right;">Total Stock Value</th>
                            <th>@{{ stocks.reduce((prev, curr) => {return prev + parseFloat(curr.current_quantity)}, 0).toFixed(2) }}</th>
                            <th></th>
                            <th style="text-align: right;">@{{ stocks.reduce((prev, curr) => {return prev + parseFloat(curr.stockValue)}, 0).toFixed(2) }}</th>
                        </tr>
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
    new Vue({
        el: '#materialStock',
        data() {
            return {
                date: moment().format("YYYY-MM-DD"),
                searchType: 'total',
                stocks: [],
                stocks2: [],

                materials: [],
                selectedMaterial: null,

                onProgress: false,
                showReport: null
            }
        },

        filters: {
            decimal(value) {
                let fixed = 2;
                return value == null ? parseFloat(0).toFixed(fixed) : parseFloat(value).toFixed(fixed);
            }
        },

        methods: {
            getMaterial() {
                axios.post("/get-material", {
                        forSearch: 'yes',
                    })
                    .then(res => {
                        this.materials = res.data;
                    })
            },
            async onSearchMaterial(val, loading) {
                if (val.length > 2) {
                    loading(true);
                    await axios.post("/get-material", {
                            name: val,
                        })
                        .then(res => {
                            this.materials = res.data;
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getMaterial();
                }
            },
            onChangeStock() {
                this.stocks = [];
                this.stocks2 = [];
                this.selectedMaterial = null
                if (this.searchType == 'material') {
                    this.getMaterial();
                }
            },
            getMaterialStock() {
                let filter = {
                    date: this.date,
                    materialId: this.selectedMaterial != null ? this.selectedMaterial.id : '',
                }
                this.onProgress = true
                this.showReport = false
                axios.post('/get-material-stock', filter)
                    .then(res => {
                        this.stocks = res.data;
                        this.stocks2 = res.data;
                        this.onProgress = false
                        this.showReport = true
                    })
                    .catch(err => {
                        this.onProgress = false
                        this.showReport = null
                        var r = JSON.parse(err.request.response);
                        if (r.errors != undefined) {
                            console.log(r.errors);
                        }
                        toastr.error(r.message);
                    })
            },

            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Material Stock Report</h4>
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

            // filter stock
            filterArray(event) {
                this.stocks = this.stocks2.filter(stock => {
                    return stock.name.toLowerCase().startsWith(event.target.value.toLowerCase())
                })
            },
        },
    })
</script>
@endpush