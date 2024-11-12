@extends('master')
@section('title', 'Business Monitor')
@section('breadcrumb_title', 'Business Monitor')
@push('style')
<style scoped>
    .widgets {
        width: 100%;
        min-height: 100px;
        padding: 8px;
        box-shadow: 0px 1px 2px #454545;
        border-radius: 3px;
        text-align: center;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }

    .widgets .widget-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .widgets .widget-content {
        flex-grow: 2;
        font-weight: bold;
    }

    .widgets .widget-content .widget-text {
        font-size: 13px;
        color: #6f6f6f;
    }

    .widgets .widget-content .widget-value {
        font-size: 16px;
    }

    .custom-table-bordered,
    .custom-table-bordered>tbody>tr>td,
    .custom-table-bordered>tbody>tr>th,
    .custom-table-bordered>tfoot>tr>td,
    .custom-table-bordered>tfoot>tr>th,
    .custom-table-bordered>thead>tr>td,
    .custom-table-bordered>thead>tr>th {
        border: 1px solid #224079;
    }

    .overallReport {
        border: 2px dashed #30cf;
        margin: 0;
        padding: 10px 0px;
        height: 360px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .graphReport {
        border: 2px dashed #30cf;
        margin: 15px 0;
        height: 320px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .topProductCustomer {
        border: 2px dashed #30cf;
        margin: 0;
        height: 270px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .overallReport {
            height: auto;
        }

        .graphReport {
            height: auto;
        }

        .topProductCustomer {
            height: auto;
        }
    }
</style>
@endpush
@section('content')
<div id="graph">
    <div class="row overallReport">
        <div v-if="showData" style="display:none;" v-bind:style="{ display: showData ? '' : 'none' }">
            <div class="col-md-2  col-xs-6" style="margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #1c8dff;">
                    <div class="widget-icon" style="background-color: #1c8dff;text-align:center;">
                        <i class="bi bi-table fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Total Table</div>
                        <div class="widget-value">@{{ totalTable }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #666633;">
                    <div class="widget-icon" style="background-color: #666633;text-align:center;">
                        <i class="bi bi-check2-circle fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Booked</div>
                        <div class="widget-value">@{{ totalBookedTable }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #008241;">
                    <div class="widget-icon" style="background-color: #008241;text-align:center;">
                        <i class="bi bi-check fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Available</div>
                        <div class="widget-value">@{{ totalAvailableTable }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #ff8000;">
                    <div class="widget-icon" style="background-color: #ff8000;text-align:center;">
                        <i class="bi bi-card-checklist fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Today Order</div>
                        <div class="widget-value">@{{ todayOrder }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #ae0000;">
                    <div class="widget-icon" style="background-color: #ae0000;text-align:center;">
                        <i class="fa fa-money fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Today Collection</div>
                        <div class="widget-value">{{$company->currency}} @{{ todayCollection | decimal }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #663300;">
                    <div class="widget-icon" style="background-color: #663300;text-align:center;">
                        <i class="fa fa-money fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Monthly Collection</div>
                        <div class="widget-value">{{$company->currency}} @{{ monthlyCollection | decimal }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-top: 5px;margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #1c8dff;">
                    <div class="widget-icon" style="background-color: #1c8dff;text-align:center;">
                        <i class="bi bi-people-fill fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Total Employee</div>
                        <div class="widget-value">@{{ totalEmployee }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-top: 5px;margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #666633;">
                    <div class="widget-icon" style="background-color: #666633;text-align:center;">
                        <i class="fa fa-money fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Cash Balance</div>
                        <div class="widget-value">{{$company->currency}} @{{ cashBalance | decimal }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-top: 5px;margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #008241;">
                    <div class="widget-icon" style="background-color: #008241;text-align:center;">
                        <i class="fa fa-money fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Bank Balance</div>
                        <div class="widget-value">{{$company->currency}} @{{ bankBalance | decimal }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-top: 5px;margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #ff8000;">
                    <div class="widget-icon" style="background-color: #ff8000;text-align:center;">
                        <i class="fa fa-money fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Expense</div>
                        <div class="widget-value">{{$company->currency}} @{{ expense | decimal }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-top: 5px;margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #ae0000;">
                    <div class="widget-icon" style="background-color: #ae0000;text-align:center;">
                        <i class="fa fa-money fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Loan Balance</div>
                        <div class="widget-value">{{$company->currency}} @{{ loanBalance | decimal }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-top: 5px;margin-bottom: 5px;">
                <div class="widgets" style="border-top: 5px solid #663300;">
                    <div class="widget-icon" style="background-color: #663300;text-align:center;">
                        <i class="fa fa-money fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Invest Balance</div>
                        <div class="widget-value">{{$company->currency}} @{{ investBalance | decimal }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-top: 5px;">
                <div class="widgets" style="border-top: 5px solid #1c8dff;">
                    <div class="widget-icon" style="background-color: #1c8dff;text-align:center;">
                        <i class="fa fa-money fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Total Due</div>
                        <div class="widget-value">@{{ dueAmount | decimal }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2  col-xs-6" style="margin-top: 5px;">
                <div class="widgets" style="border-top: 5px solid #666633;">
                    <div class="widget-icon" style="background-color: #666633;text-align:center;">
                        <i class="fa fa-money fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Current Due</div>
                        <div class="widget-value">{{$company->currency}} @{{ currentDue | decimal }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-2  col-xs-6" style="margin-top: 5px;">
                <div class="widgets" style="border-top: 5px solid #008241;">
                    <div class="widget-icon" style="background-color: #008241;text-align:center;">
                        <i class="fa fa-line-chart fa-2x"></i>
                    </div>

                    <div class="widget-content">
                        <div class="widget-text">Monthly Profit</div>
                        <div class="widget-value">{{$company->currency}} @{{ monthlyProfit | decimal }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:none;" v-bind:style="{display: showData == false ? '' : 'none'}">
            <div class="col-md-12 text-center">
                <img src="{{asset('loading.gif')}}" style="width: 90px;"> Loading..
            </div>
        </div>
    </div>

    <!-- graph section -->
    <div class="row graphReport">
        <div v-if="showGraph" style="display:none;width:100%;" v-bind:style="{ display: showGraph ? '' : 'none' }">
            <div class="row" style="border-bottom: 2px dashed #30cf;margin:0;">
                <div class="col-md-3 col-xs-9">
                    <div class="form-group" style="display: flex;align-items:center;">
                        <label for="year" style="width: 120px;">Select Year</label>
                        <input type="month" v-model="year" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 col-xs-3" style="padding-left: 0;">
                    <div class="form-group" style="display: flex;align-items:center;">
                        <button type="button" @click="getGraphData">Get Data</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="padding: 0;" v-if="salesGraph == 'monthly'">
                <h3 class="text-center" style="margin-top: 0;">This Month's Collection</h3>
                <sales-chart type="ColumnChart" :data="salesData" :options="salesChartOptions" />
            </div>
            <div class="col-md-12" style="padding: 0;" v-else>
                <h3 class="text-center" style="margin-top: 0;">This Year's Collection</h3>
                <sales-chart type="ColumnChart" :data="yearlySalesData" :options="yearlySalesChartOptions" />
            </div>
            <div class="col-md-12 text-center">
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-primary" @click="salesGraph = 'monthly'">Monthly</button>
                    <button type="button" class="btn btn-warning" @click="salesGraph = 'yearly'">Yearly</button>
                </div>
            </div>
        </div>

        <div style="display:none;" v-bind:style="{display: showGraph == false ? '' : 'none'}">
            <div class="col-md-12 text-center">
                <img src="{{asset('loading.gif')}}" style="width: 90px;"> Loading..
            </div>
        </div>
    </div>

    <div class="row topProductCustomer">
        <div v-if="topData" style="display:none;width:100%;" v-bind:style="{ display: topData ? '' : 'none' }">
            <div class="row" style="border-bottom: 2px dashed #30cf;margin:0;">
                <div class="col-md-3 col-xs-12">
                    <div class="form-group" style="display: flex;align-items:center;">
                        <label for="dateFrom" style="width: 120px;">Select Date</label>
                        <input type="date" v-model="dateFrom" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 no-padding-left">
                    <div class="form-group" style="display: flex;align-items:center;">
                        <label for="dateTo" style="width: 28px;">To</label>
                        <input type="date" v-model="dateTo" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 col-xs-12" style="padding-left: 0;">
                    <div class="form-group" style="display: flex;align-items:center;">
                        <button type="button" @click="getTopData('yes')">Get Data</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="text-center" style="margin: 0;">Top Menus</h3>
                <top-product-chart type="PieChart" :data="topMenus" :options="topMenusOptions" />
            </div>
            <div class="col-md-4 col-md-offset-2">
                <table class="table custom-table-bordered" style="margin-top: 10px;">
                    <thead>
                        <tr>
                            <td class="text-center" colspan="2" style="background-color: #224079;color: white;font-weight: 900;">Top Guest</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in topCustomers">
                            <td width="75%">@{{customer.customer_name}}</td>
                            <td width="25%">@{{customer.amount | decimal}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display:none;" v-bind:style="{display: topData == false ? '' : 'none'}">
            <div class="col-md-12 text-center">
                <img src="{{asset('loading.gif')}}" style="width: 90px;"> Loading..
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('backend')}}/js/vue/vue-google-charts.browser.js"></script>
<script>
    let googleChart = VueGoogleCharts.GChart;
    new Vue({
        el: '#graph',
        components: {
            'sales-chart': googleChart,
            'top-product-chart': googleChart,
            'top-production': googleChart,
            'top-customer-chart': googleChart
        },
        data() {
            return {
                year: moment().format("YYYY-MM"),
                dateFrom: moment().format("YYYY-MM-DD"),
                dateTo: moment().format("YYYY-MM-DD"),
                salesData: [
                    ['Date', 'Sales']
                ],
                salesChartOptions: {
                    chart: {
                        title: 'Sales',
                        subtitle: "This month's sales data",
                    },
                },
                yearlySalesData: [
                    ['Month', 'Sales']
                ],
                yearlySalesChartOptions: {
                    chart: {
                        title: 'Sales',
                        subtitle: "This year's sales data",
                    }
                },
                topMenus: [
                    ['Product', 'Quantity']
                ],
                topMenusOptions: {
                    chart: {
                        title: 'Top Sold Products',
                        subtitle: "Top sold products"
                    }
                },
                topProductions: [
                    ['Product', 'Quantity']
                ],
                topProductionsOptions: {
                    chart: {
                        title: 'Top Productions',
                        subtitle: "Top Productions"
                    }
                },
                topCustomers: [],
                totalTable: 0,
                totalBookedTable: 0,
                totalAvailableTable: 0,
                vacant: 0,
                todayOrder: 0,
                todayCollection: 0,
                monthlyCollection: 0,
                totalEmployee: 0,
                cashBalance: 0,
                bankBalance: 0,
                dueAmount: 0,
                currentDue: 0,
                expense: 0,
                investBalance: 0,
                loanBalance: 0,
                monthlyProfit: 0,
                showData: null,
                showGraph: null,
                topData: null,
                salesGraph: 'monthly',
                fixed: 2,
            }
        },

        filters: {
            decimal(value) {
                return value == null ? parseFloat(0).toFixed(2) : parseFloat(value).toFixed(2);
            }
        },
        created() {
            this.getOverallData();
            this.getGraphData();
            this.getTopData();
        },
        methods: {
            getOverallData() {
                this.showData = false;
                axios.get('/get-overall-data').then(res => {
                    this.totalTable          = res.data.total_table;
                    this.totalBookedTable    = res.data.total_booked_table;
                    this.totalAvailableTable = res.data.total_available_table;
                    this.vacant              = res.data.vacant;
                    this.todayOrder          = res.data.today_order;
                    this.totalEmployee       = res.data.total_employee;
                    this.todayCollection     = res.data.today_collection;
                    this.monthlyCollection   = res.data.monthly_collection;
                    this.cashBalance         = res.data.cash_balance;
                    this.bankBalance         = res.data.bank_balance;
                    this.dueAmount           = res.data.due_amount;
                    this.currentDue          = res.data.current_due;
                    this.investBalance       = res.data.invest_balance;
                    this.loanBalance         = res.data.loan_balance;
                    this.expense             = res.data.expense;
                    this.monthlyProfit       = res.data.monthly_profit;

                    this.showData = true;
                })
            },
            getGraphData() {
                this.showGraph = false;
                axios.post('/get-graph-data', {
                    year: this.year
                }).then(res => {
                    this.salesData = [
                        ['Date', 'Collection']
                    ]
                    res.data.monthly_record.forEach(d => {
                        this.salesData.push(d);
                    })

                    this.yearlySalesData = [
                        ['Month', 'Collection']
                    ]
                    res.data.yearly_record.forEach(d => {
                        this.yearlySalesData.push(d);
                    })

                    this.showGraph = true;
                })
            },
            getTopData(data = null) {
                this.topData = false;
                let filter = {
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo
                }
                if (data != null) {
                    filter.fromSubmit = data;
                }
                axios.post('/get-top-data', filter).then(res => {
                    this.topCustomers = res.data.top_customers;

                    this.topMenus = [
                        ['Table', 'Total Booked']
                    ]
                    res.data.top_menus.forEach(p => {
                        this.topMenus.push([p.menu_name, parseFloat(p.totaltable)]);
                    })

                    this.topData = true;
                })
            },
        }
    })
</script>
@endpush