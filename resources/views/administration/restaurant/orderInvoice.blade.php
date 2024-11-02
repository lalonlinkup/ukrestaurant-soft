@extends('master')
@section('title', 'Order Invoice')
@section('breadcrumb_title', 'Order Invoice')
@section('content')
<div id="orderInvoice">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <order-invoice v-bind:order_id="orderId"></order-invoice>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('components')}}/orderInvoice.js"></script>
<script>
    new Vue({
        el: '#orderInvoice',
        components: {
            orderInvoice
        },
        data() {
            return {
                orderId: parseInt('<?php echo $id; ?>'),
            }
        }
    })
</script>
@endpush