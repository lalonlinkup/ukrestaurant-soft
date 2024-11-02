@extends('master')
@section('title', 'Loan View')
@section('breadcrumb_title', 'Loan View')
@push('style')
    <style scoped>
        .balance-section {
            width: 100%;
            min-height: 150px;
            background-color: #f0f1d3;
            border: 1px solid #cfcfcf;
            text-align: center;
            padding: 25px 10px;
            border-radius: 5px;
        }

        .balance-section h3 {
            margin: 0;
            padding: 0;
        }

        .account-section {
            display: flex;
            border: 1px solid #cfcfcf;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .account-section h3 {
            margin: 10px 0;
            padding: 0;
        }

        .account-section .col1 {
            background-color: #247195;
            color: white;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .account-section .col2 {
            background-color: #def1f8;
            flex: 2;
            padding: 10px;
            align-items: center;
            text-align: center;
            justify-content: center;
        }
    </style>
@endpush
@section('content')
    <div class="row mt-1">
        <div class="col-md-4 col-md-offset-4 mb-1">
            <div class="balance-section">
                <i class="fa fa-money fa-3x"></i>
                <h3>Loan Balance</h3>
                @php
                    $loan_balance = array_reduce($loan_transaction_summary, function ($prev, $curr) {
                        return $prev + $curr->balance;
                    });
                @endphp
                <h1> {{ $company->currency }} {{ number_format($loan_balance, 2) }}</h1>
            </div>
        </div>
    </div>

    <div class="row mt-1">
        @foreach ($loan_transaction_summary as $account)
            <div class="col-md-3">
                <div class="account-section">
                    <div class="col1">
                        <i class="fa fa-dollar fa-3x"></i>
                    </div>
                    <div class="col2">
                        {{ $account->name }}<br>
                        {{ $account->number }}<br>
                        {{ strlen($account->bank_name) > 20 ? substr($account->bank_name, 0, 20) . ' ...' : $account->bank_name }}
                        <h3> {{ $company->currency }} {{ number_format($account->balance, 2, '.', '') }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
