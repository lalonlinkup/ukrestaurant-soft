@extends('master')
@section('title', 'Production Record')
@section('breadcrumb_title', 'Production Record')
@push('style')
<style scoped>
    .v-select .dropdown-toggle {
        padding: 0px;
        height: 30px !important;
    }

    .v-select .dropdown-menu {
        width: 350px !important;
        overflow-y: auto !important;
    }

    table>thead>tr>th {
        text-align: center;
    }
</style>
@endpush
@section('content')
<div id="productionRecord">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Search Production Record</legend>
            <div class="control-group">
                <form @submit.prevent="getProduction">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeType" style="width: 100%;" v-model="filter.searchType">
                                <option value="">All</option>
                                {{-- <option value="customer">By Customer</option> --}}
                                <option value="material">By Material</option>
                                <option value="user">By User</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'customer'" style="display: none;" :style="{display: filter.searchType == 'customer' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="customers" v-model="selectedCustomer" label="display_name" @search="onSearchcustomer"></v-select>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'user'" style="display: none;" :style="{display: filter.searchType == 'user' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="users" v-model="selectedUser" label="name"></v-select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12" v-if="filter.searchType == 'material'" style="display: none;" :style="{display: filter.searchType == 'material' ? '': 'none'}">
                        <div class="form-group">
                            <v-select :options="materials" v-model="selectedMaterial" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 no-padding" v-if="filter.searchType != 'material'" style="display: none;" :style="{display: filter.searchType != 'material' ? '' : 'none'}">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">RecordType</label>
                            <select class="form-select no-padding" @change="onChangeType" style="width: 100%;" v-model="filter.recordType">
                                <option value="with">With Details</option>
                                <option value="without">Without Details</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateFrom">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <input type="date" style="height: 30px;" class="form-control" v-model="filter.dateTo">
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

    <div class="row" style="display: flex;justify-content:space-between;">
        <div class="col-md-3" v-if="productions2.length > 0" style="display:none;" :style="{display: productions2.length > 0 ? '' : 'none'}">
            <input type="search" @input="filterArray($event)" placeholder="Search..." class="form-control">
        </div>
        <div class="col-md-9 text-right">
            <a v-if="productions.length > 0" style="display:none;" :style="{display: productions.length > 0 ? '' : 'none'}" href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
    </div>
    <div class="row" v-if="productions.length > 0 && showReport" style="display:none;" :style="{display: productions.length > 0 && showReport ? '' : 'none'}">
        <div class="col-md-12">
            <div class="table-responsive" id="reportTable">
                <table class="table table-bordered record-table table-condensed" v-if="filter.searchType != 'material' && filter.recordType == 'with'" style="display:none;" :style="{display: filter.searchType != 'material' && filter.recordType == 'with'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Production Invoice</th>
                            <th>Date</th>
                            <th>Order Invoice</th>
                            <th>Guest Name</th>
                            <th>Material Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th style="text-align: right;">Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(production, index) in productions">
                            <tr>
                                <td>@{{ index + 1 }}</td>
                                <td>@{{ production.invoice }}</td>
                                <td>@{{ production.date | dateFormat("DD-MM-YYYY") }}</td>
                                <td>@{{ production.order.invoice }}</td>
                                <td>@{{ production.order.customer_id == null ? production.order.customer_name : production.order.customer.name }}</td>
                                <td>@{{ production.production_details[0].material.name }}</td>
                                <td style="text-align:center;">@{{ production.production_details[0].price | decimal }}</td>
                                <td style="text-align:center;">@{{ production.production_details[0].quantity | decimal }}</td>
                                <td style="text-align:right;">@{{ production.production_details[0].total | decimal }}</td>
                                <td style="text-align:center;">
                                    <a href="" title="Production Invoice" v-bind:href="`/production-invoice-print/${production.id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                    @if(userAction('u'))
                                    <a href="" title="Edit Production" @click.prevent="productionEdit(production)"><i class="fa fa-edit"></i></a>
                                    @endif
                                </td>
                            </tr>
                            <tr v-for="(item, sl) in production.production_details.slice(1)">
                                <td colspan="5" :rowspan="production.production_details.length - 1" v-if="sl == 0"></td>
                                <td>@{{ item.material.name }}</td>
                                <td style="text-align:center;">@{{ item.price | decimal }}</td>
                                <td style="text-align:center;">@{{ item.quantity | decimal }}</td>
                                <td style="text-align:right;">@{{ item.total | decimal }}</td>
                                <td></td>
                            </tr>
                            <tr style="font-weight:bold;">
                                <td colspan="7" style="font-weight:normal;text-align:left;"><strong>Description: </strong>@{{ production.description }}</td>
                                <td style="text-align:center;">Total Quantity<br>@{{ production.production_details.reduce((prev, curr) => {return prev + parseFloat(curr.quantity)}, 0) | decimal }}</td>
                                <td style="text-align:right;">
                                    Total: @{{ production.total | decimal }}<br>
                                </td>
                                <td></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <table class="table table-bordered record-table table-condensed" v-if="filter.searchType != 'material' && filter.recordType == 'without'" style="display:none;" :style="{display: filter.searchType != 'material' && filter.recordType == 'without'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Production Inv No.</th>
                            <th>Date</th>
                            <th>Order Invoice</th>
                            <th>Guest Name</th>
                            <th>Description</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(production, index) in productions">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ production.invoice }}</td>
                            <td>@{{ production.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ production.order.invoice }}</td>
                            <td>@{{ production.order.customer_id == null ? production.order.customer_name : production.order.customer.name }}</td>
                            <td style="text-align:left;">@{{ production.description }}</td>
                            <td style="text-align:right;">@{{ production.total | decimal }}</td>
                            <td style="text-align:center;">
                                <a href="" title="Production Invoice" v-bind:href="`/production-invoice-print/${production.id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                @if(userAction('u'))
                                <a href="" title="Edit Production" @click.prevent="productionEdit(production)"><i class="fa fa-edit"></i></a>
                                @endif
                            </td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="6" style="text-align:right;">Total</td>
                            <td style="text-align:right;">@{{ productions.reduce((prev, curr)=>{return prev + parseFloat(curr.total)}, 0) | decimal }}</td>
                            <td></td>
                        </tr>
                    </tbody>

                </table>
                <table class="table table-bproductioned record-table table-condensed" v-if="filter.searchType == 'material'" style="display:none;" :style="{display: filter.searchType == 'material'? '': 'none'}">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Invoice No.</th>
                            <th>Date</th>
                            <th>Guest Name</th>
                            <th>Material Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(production, index) in productions">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ production.invoice }}</td>
                            <td>@{{ production.date | dateFormat("DD-MM-YYYY") }}</td>
                            <td>@{{ production.customer_name }}</td>
                            <td>@{{ production.name }}</td>
                            <td style="text-align:right;">@{{ production.price }}</td>
                            <td style="text-align:right;">@{{ production.quantity }}</td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="6" style="text-align:right;">Total Quantity</td>
                            <td style="text-align:right;">@{{ productions.reduce((prev, curr) => { return prev + parseFloat(curr.quantity)}, 0) }}</td>
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
        el: '#productionRecord',
        data() {
            return {
                filter: {
                    searchType: "",
                    recordType: "without",
                    status: 'a',
                    dateFrom: moment().format("YYYY-MM-DD"),
                    dateTo: moment().format("YYYY-MM-DD"),
                },
                productions: [],
                productions2: [],

                customers: [],
                selectedCustomer: null,
                materials: [],
                selectedMaterial: null,
                users: [],
                selectedUser: null,
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
            async productionEdit(row) {
                location.href = "/production/" + row.id
            },

            getUser() {
                axios.post("/get-user")
                    .then(res => {
                        this.users = res.data.users;
                    })
            },

            getMaterial() {
                axios.get("/get-material")
                    .then(res => {
                        this.materials = res.data;
                    })
            },

            getCustomer() {
                axios.get("/get-customer")
                    .then(res => {
                        let r = res.data;
                        this.customers = r.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code}`
                            return item;
                        });
                    })
            },

            onChangeType(event) {
                this.productions = [];
                this.productions2 = [];
                this.selectedCustomer = null;
                this.selectedMaterial = null;
                this.selectedUser = null;
                this.filter.customerId = "";
                this.filter.materialId = "";
                this.filter.userId = "";
                if (event.target.value == 'customer') {
                    this.getCustomer();
                } else if (event.target.value == 'material') {
                    this.getMaterial();
                } else if (event.target.value == 'user') {
                    this.getUser();
                }
            },
            
            getProduction() {
                if (this.filter.searchType == 'customer') {
                    this.filter.customerId = this.selectedCustomer != null ? this.selectedCustomer.id : ""
                }
                if (this.filter.searchType == 'material') {
                    var url = '/get-production-details';
                    this.filter.materialId = this.selectedMaterial != null ? this.selectedMaterial.id : ""
                } else {
                    var url = "/get-production";
                    this.filter.userId = this.selectedUser != null ? this.selectedUser.id : ""
                }
                this.onProgress = true
                this.showReport = false
                axios.post(url, this.filter)
                    .then(res => {
                        let productions = res.data;
                        this.productions = productions.map(item => {
                            item.paid = parseFloat(parseFloat(item.paid) - parseFloat(item.returnAmount)).toFixed(this.fixed)
                            return item;
                        })
                        this.productions2 = this.productions
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

            //search method here
            async onSearchcustomer(val, loading) {
                if (val.length > 2) {
                    loading(true)
                    await axios.post("/get-customer", {
                            name: val
                        })
                        .then(res => {
                            let r = res.data;
                            this.customers = r.map((item, index) => {
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

            // print method hre
            async print() {
                let dateText = '';
                if (this.dateFrom != '' && this.dateTo != '') {
                    dateText = `Statement from <strong>${moment(this.filter.dateFrom).format('DD-MM-YYYY')}</strong> to <strong>${moment(this.filter.dateTo).format('DD-MM-YYYY')}</strong>`;
                }

                let userText = '';
                if (this.selectedUser != null && this.selectedUser.username != '' && this.filter.searchType == 'user') {
                    userText = `<strong>Production by: </strong> ${this.selectedUser.username}`;
                }

                let customerText = '';
                if (this.selectedCustomer != null && this.selectedCustomer.id != '' && this.filter.searchType == 'customer') {
                    customerText = `<strong>Guest: </strong> ${this.selectedCustomer.name}<br>`;
                }

                let materialText = '';
                if (this.selectedMaterial != null && this.selectedMaterial.id != '' && this.filter.searchType == 'material') {
                    materialText = `<strong>Material: </strong> ${this.selectedMaterial.name}`;
                }

                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Productions Record</h4 style="text-align:center">
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-6">
								${userText} ${customerText} ${materialText}
							</div>
							<div class="col-xs-6 text-right">
								${dateText}
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

                if (this.filter.searchType != 'material') {
                    let rows = mywindow.document.querySelectorAll('.record-table tr');
                    rows.forEach(row => {
                        row.lastChild.remove();
                    })
                }

                mywindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                mywindow.print();
                mywindow.close();
            },

            // filter productionrecord
            filterArray(event) {
                this.productions = this.productions2.filter(production => {
                    return production.invoice.toLowerCase().startsWith(event.target.value.toLowerCase()) ||
                        production.date.toLowerCase().startsWith(event.target.value.toLowerCase());
                })
            },
        },
    })
</script>
@endpush