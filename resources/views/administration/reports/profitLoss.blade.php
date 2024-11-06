@extends('master')
@section('title', 'Profit/Loss Report')
@section('breadcrumb_title', 'Profit/Loss Report')
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

    #table1 {
        border-collapse: collapse;
        width: 100%;
    }

    #table1 td,
    #table1 th {
        padding: 5px;
        border: 1px solid #909090;
    }

    #table1 th {
        text-align: center;
    }

    #table1 thead {
        background-color: #cbd6e7;
    }
</style>
@endpush
@section('content')
<div id="profitLoss">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Profit/Loss Report</legend>
            <div class="control-group">
                <form @submit.prevent="getProfitLoss">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="customer">Customer</label>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <v-select :options="customers" id="customer" v-model="selectedCustomer" label="display_name"></v-select>
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
                            <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Show Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>

    <div class="row" style="display:none;" :style="{ display: showReport ? '' : 'none' }">
        <div class="col-md-12 text-right">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="reportTable">
                <table id="table1">
                    <thead>
                        <tr>
                            <th>Product Id</th>
                            <th>Product</th>
                            <th>Sold Quantity</th>
                            <th>Purchase Rate</th>
                            <th>Purchased Total</th>
                            <th>Sold Amount</th>
                            <th>Profit/Loss</th>
                        </tr>
                    </thead>
                    <tbody v-for="data in reportData" v-if="reportData.length > 0">
                        <tr>
                            <td colspan="7" style="background-color: #e3eae7;">
                                <strong>Invoice: </strong> @{{ data.invoice }} |
                                <strong>Sales Date: </strong> @{{ data.date }} |
                                <strong>Guest: </strong> @{{ data.name }} |
                                <strong>Discount: </strong> @{{ data.discount | decimal }} |
                                <strong>VAT: </strong> @{{ data.vat | decimal }} |
                                <strong>Transport Cost: </strong> @{{ data.transport_cost | decimal }}
                            </td>
                        </tr>
                        <tr v-for="item in data.saleDetails">
                            <td>@{{ item.code }}</td>
                            <td>@{{ item.name }}</td>
                            <td style="text-align:right;">@{{ item.quantity }}</td>
                            <td style="text-align:right;">@{{ item.purchase_rate | decimal }}</td>
                            <td style="text-align:right;">@{{ item.purchased_amount | decimal }}</td>
                            <td style="text-align:right;">@{{ item.total | decimal }}</td>
                            <td style="text-align:right;">@{{ item.profit_loss | decimal }}</td>
                        </tr>
                        <tr style="background-color: #f0f0f0;font-weight: bold;">
                            <td colspan="4" style="text-align:right;">Total</td>
                            <td style="text-align:right;">
                                @{{ data.saleDetails.reduce((prev, cur) => {
                                        return prev + +parseFloat(cur.purchased_amount)
                                    }, 0) | decimal }}
                            </td>
                            <td style="text-align:right;">
                                @{{ data.saleDetails.reduce((prev, cur) => {
                                        return prev + +parseFloat(cur.total)
                                    }, 0) | decimal }}
                            </td>
                            <td style="text-align:right;">
                                @{{ data.saleDetails.reduce((prev, cur) => {
                                        return prev + +parseFloat(cur.profit_loss)
                                    }, 0) | decimal }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot style="font-weight:bold;background-color:#e9dcdc;">
                        <tr>
                            <td style="text-align:right;" colspan="4">Total Profit</td>
                            <td style="text-align:right;">
                                @{{ reportData.reduce((prev, cur) => {
                                        return prev +  +cur.saleDetails.reduce((p, c) => {
                                                return p + +parseFloat(c.purchased_amount)
                                            }, 0)
                                    }, 0).toFixed(fixed) }}
                            </td>
                            <td style="text-align:right;">
                                @{{ reportData.reduce((prev, cur) => {
                                        return prev +  +cur.saleDetails.reduce((p, c) => {
                                                return p + +parseFloat(c.total)
                                            }, 0)
                                    }, 0).toFixed(fixed) }}
                            </td>
                            <td style="text-align:right;">
                                @{{ totalProfit = reportData.reduce((prev, cur) => {
                                        return prev +  +cur.saleDetails.reduce((p, c) => {
                                                return p + +parseFloat(c.profit_loss)
                                            }, 0)
                                    }, 0).toFixed(fixed) }}
                            </td>
                        </tr>
                        <!-- <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">VAT (+)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ totalVat = reportData.reduce((prev, cur) => {
                                    return prev + +parseFloat(cur.vatAmount)
                                }, 0).toFixed(fixed) }}</td>
                        </tr> -->

                        <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Transaction In (+)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ otherIncomeExpense.income | decimal }}</td>
                        </tr>

                        <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Expense (-)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ otherIncomeExpense.expense | decimal }}</td>
                        </tr>

                        <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Purchase Vat (-)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ otherIncomeExpense.purchase_vat | decimal }}</td>
                        </tr>

                        <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Purchase Transport Cost (-)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ otherIncomeExpense.purchase_transport_cost | decimal }}</td>
                        </tr>

                        <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Sales Discount (-)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ totalDiscount = reportData.reduce((prev, cur) => {
                                    return prev + +parseFloat(cur.discountAmount)
                                }, 0).toFixed(fixed) }}</td>
                        </tr>

                        <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Sales Returned Value (-)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ otherIncomeExpense.returned_amount | decimal }}</td>
                        </tr>

                        <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Total Damaged (-)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ otherIncomeExpense.damaged_amount | decimal }}</td>
                        </tr>

                        <!-- <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Cash Transaction (-)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ otherIncomeExpense.expense | decimal }}</td>
                        </tr> -->

                        <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Employee Payment (-)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ otherIncomeExpense.employee_payment | decimal }}</td>
                        </tr>

                        <tr style="display: none;">
                            <td colspan="4" style="text-align:right;">Profit Distribute (-)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ otherIncomeExpense.profit_distribute | decimal }}</td>
                        </tr>

                        <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Loan Interest (-)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ otherIncomeExpense.loan_interest | decimal }}</td>
                        </tr>

                        <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Assets Sales (-)</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">@{{ otherIncomeExpense.assets_sales_profit_loss | decimal }}</td>
                        </tr>

                        <tr style="display:none;" :style="{display: selectedCustomer == null ? '' : 'none'}">
                            <td colspan="4" style="text-align:right;">Net Profit</td>
                            <td colspan="2"></td>
                            <td style="text-align:right;">
                                @{{ ((parseFloat(totalProfit) + parseFloat(otherIncome)) - (parseFloat(totalDiscount) + parseFloat(otherIncomeExpense.returned_amount) + parseFloat(otherIncomeExpense.damaged_amount) + parseFloat(otherIncomeExpense.expense) + parseFloat(otherIncomeExpense.employee_payment) + parseFloat(otherIncomeExpense.profit_distribute) + parseFloat(otherIncomeExpense.loan_interest) + parseFloat(otherIncomeExpense.assets_sales_profit_loss))).toFixed(fixed) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    var profitLoss = new Vue({
        el: "#profitLoss",

        data() {
            return {
                filter: {
                    customerId: null,
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD')
                },
                customers: [],
                selectedCustomer: null,
                reportData: [],
                otherIncomeExpense: {
                    income: 0,
                    expense: 0,
                    employee_payment: 0,
                    profit_distribute: 0,
                    loan_interest: 0,
                    assets_sales_profit_loss: 0,
                    damaged_amount: 0,
                    returned_amount: 0,
                    purchase_discount: 0,
                    purchase_vat: 0,
                    purchase_transport_cost: 0,
                },

                totalProfit: 0,
                //totalVat: 0,
                totalDiscount: 0,

                showReport: null,
                onProgress: false,
                fixed: "{{ session('organization')->fixed }}"
            }
        },

        filters: {
            decimal(value) {
                let fixed = "{{ session('organization')->fixed }}";
                return value == null ? parseFloat(0).toFixed(fixed) : parseFloat(value).toFixed(fixed);
            }
        },

        created() {
            this.getCustomers();
        },

        computed: {
            totalSaleTransportCost() {
                return this.reportData.reduce((prev, cur) => {
                    return prev + parseFloat(cur.transport_cost)
                }, 0);
            },

            otherIncome() {
                return (
                    +parseFloat(this.totalSaleTransportCost) + parseFloat(this.otherIncomeExpense.income) + parseFloat(this.otherIncomeExpense.purchase_discount)
                ) - (parseFloat(this.otherIncomeExpense.purchase_vat) + parseFloat(this.otherIncomeExpense.purchase_transport_cost)

                );
            }
        },

        methods: {
            getCustomers() {
                axios.get('/get-customer')
                    .then(res => {
                        let r = res.data.data;
                        this.customers = r.customers.map((item, index) => {
                            item.display_name = `${item.name} - ${item.code} - ${item.phone}`
                            return item;
                        });
                    })
            },

            async getProfitLoss() {
                if (this.selectedCustomer != null) {
                    this.filter.customerId = this.selectedCustomer.id;
                } else {
                    this.filter.customerId = null;
                }
                this.showReport = false
                this.onProgress = true

                this.reportData = await axios.post('/get-profit-loss', this.filter)
                    .then(res => {
                        return res.data;
                    })

                this.otherIncomeExpense = await axios.post('/get_other_income_expense', this.filter)
                    .then(res => {
                        return res.data[0]
                    })

                this.onProgress = false;
                this.showReport = true;

            },

            async print() {
                let customerText = '';
                if (this.selectedCustomer != null) {
                    customerText = `
						<strong>Guest Id: </strong> ${this.selectedCustomer.code}<br>
						<strong>Name: </strong> ${this.selectedCustomer.name}<br>
						<strong>Address: </strong> ${this.selectedCustomer.address}<br>
						<strong>Mobile: </strong> ${this.selectedCustomer.phone}
					`;
                }

                let dateText = '';
                if (this.filter.dateFrom != '' && this.filter.dateTo != '') {
                    dateText = `
						Statement from <strong>${this.filter.dateFrom}</strong> to <strong>${this.filter.dateTo}</strong>
					`;
                }
                let reportContent = `
					<div class="container">
						<h4 style="text-align:center">Profit/Loss Report</h4>
						<div class="row">
							<div class="col-md-6">${customerText}</div>
							<div class="col-md-6 text-right">${dateText}</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportTable').innerHTML}
							</div>
						</div>
					</div>
				`;

                var mywindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
                mywindow.document.write(`
                    @include('administration/reports/reportHeader')
				`);

                mywindow.document.head.innerHTML += `
					<style>
						#table1{
							border-collapse: collapse;
							width: 100%;
						}

						#table1 td, #table1 th{
							padding: 5px;
							border: 1px solid #909090;
						}

						#table1 th{
							text-align: center;
						}

						#table1 thead{
							background-color: #cbd6e7;
						}
					</style>
				`;
                mywindow.document.body.innerHTML += reportContent;

                mywindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                mywindow.print();
                mywindow.close();
            }
        }
    });
</script>
@endpush