@extends('master')
@section('title', 'Unauthorized !')
@section('breadcrumb_title', 'Unauthorized !')
@section('content')
<div class="row" style="display:flex;justify-content:center;align-items:center;flex-direction:column;gap:10px;">
    <div class="col-md-6 no-padding text-center">
        <h2 style="margin: 0;color: red;margin-top:150px;padding: 5px;text-transform: uppercase;font-weight: 900;">You have no access.. !</h2>
        <h4>Please Contact with Admin.</h4>
    </div>
</div>
@endsection