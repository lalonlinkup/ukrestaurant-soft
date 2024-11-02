@extends('master')
@section('title', 'Billing Invoice')
@section('breadcrumb_title', 'Billing Invoice')
@section('content')
<div id="billingInvoice">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <billing-invoice v-bind:billing_id="billingId"></billing-invoice>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('components')}}/billingInvoice.js"></script>
<script>
    new Vue({
        el: '#billingInvoice',
        components: {
            billingInvoice
        },
        data() {
            return {
                billingId: parseInt('<?php echo $id; ?>'),
            }
        }
    })
</script>
@endpush