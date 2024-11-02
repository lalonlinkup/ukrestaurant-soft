@extends('master')
@section('title', 'Issue Invoice')
@section('breadcrumb_title', 'Issue Invoice')
@section('content')
<div id="issueInvoice">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <issue-invoice v-bind:issue_id="issueId" v-bind:fixed="2" v-bind:company="company"></issue-invoice>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('components')}}/issueInvoice.js"></script>
<script>
    new Vue({
        el: '#issueInvoice',
        components: {
            issueInvoice
        },
        data() {
            return {
                issueId: parseInt('<?php echo $id; ?>'),
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