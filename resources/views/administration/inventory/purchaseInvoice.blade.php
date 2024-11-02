@extends('master')
@section('title', 'Purchase Invoice')
@section('breadcrumb_title', 'Purchase Invoice')
@section('content')
<div id="purchaseInvoice">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <purchase-invoice v-bind:purchase_id="purchaseId" v-bind:fixed="2" v-bind:company="company"></purchase-invoice>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('components')}}/purchaseInvoice.js"></script>
<script>
    new Vue({
        el: '#purchaseInvoice',
        components: {
            purchaseInvoice
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