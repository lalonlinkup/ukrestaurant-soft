@extends('master')
@section('title', 'Material Purchase Invoice')
@section('breadcrumb_title', 'Material Purchase Invoice')
@section('content')
<div id="materialPurchaseInvoice">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <material-purchase-invoice v-bind:purchase_id="purchaseId" v-bind:fixed="2" v-bind:company="company"></material-purchase-invoice>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('components')}}/materialPurchaseInvoice.js"></script>
<script>
    new Vue({
        el: '#materialPurchaseInvoice',
        components: {
            materialPurchaseInvoice
        },
        data() {
            return {
                purchaseId: parseInt('<?php echo $id; ?>'),
                company: {
                    logo: "{{ $company->logo }}",
                    title: "{{ $company->title }}",
                    address: "{{ $company->address }}",
                }
            }
        }
    })
</script>
@endpush