@extends('master')
@section('title', 'Billing Invoice List')
@section('breadcrumb_title', 'Billing Invoice List')
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
        width: 360px !important;
        overflow-y: auto !important;
    }
</style>
@endpush
@section('content')
<div id="invoiceList">
    <div class="row" style="margin: 0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Search Billing Invoice</legend>
            <div class="control-group">
                <div class="col-md-5 col-xs-12 col-md-offset-3">
                    <div class="form-group" style="display: flex;align-items:center;">
                        <label for="" style="width:150px;">Search Invoice</label>
                        <v-select :options="invoices" style="width: 100%;" label="display_name" v-model="selectedInvoice" @input="onChangeInvoice" @search="onSearchInvoice" placeholder="Select Invoice"></v-select>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <input type="button" class="btn btn-primary" value="Show Report" v-on:click="onChangeInvoice" style="margin-top:0px;width:150px;display: none;">
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2" v-if="selectedInvoice != null">
            <billing-invoice v-if="showInvoice" v-bind:billing_id="selectedInvoice.id"></billing-invoice>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('components')}}/billingInvoice.js"></script>
<script>
    new Vue({
        el: '#invoiceList',
        components: {
            billingInvoice
        },
        data() {
            return {
                searchType: '',
                invoices: [],
                selectedInvoice: null,
                showInvoice: false,
            }
        },

        created() {
            this.getBillInvoice();
        },

        methods: {
            getBillInvoice() {
                let filter = {
                    forSearch: 'yes',
                }
                axios.post('get-booking', filter)
                    .then(res => {
                        this.invoices = res.data.map(item => {
                            item.display_name = `${item.invoice} - ${item.customer_name}`
                            return item;
                        });
                    })
            },

            async onChangeInvoice() {
                this.showInvoice = false;
                await new Promise(r => setTimeout(r, 500));
                this.showInvoice = true;
            },

            async onSearchInvoice(val, loading) {
                if (val.length > 2) {
                    loading(true)
                    await axios.post("/get-booking", {
                            invoice: val
                        })
                        .then(res => {
                            this.invoices = res.data.map(item => {
                                item.display_name = `${item.invoice} - ${item.customer_name}`
                                return item;
                            });
                            loading(false)
                        })
                } else {
                    loading(false)
                    await this.getBillInvoice();
                }
            },
        },
    })
</script>
@endpush