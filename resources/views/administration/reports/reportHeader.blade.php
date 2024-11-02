<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
    <link rel="stylesheet" href="{{asset('backend')}}/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px !important;
        }

        body,
        table {
            font-size: 13px;
        }

        table th {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-2"><img src="{{ asset($company->logo ? $company->logo : 'noImage.gif') }}" alt="Logo" style="height:80px;border: 1px solid gray; border-radius: 5px;" /></div>
            <div class="col-xs-10" style="padding-top:5px;">
                <strong style="font-size:18px;">{{ $company->title }}</strong><br>
                <p style="white-space: pre-line;">{{ $company->address }}</p>
                <p style="white-space: pre-line;">{{ $company->phone }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
            </div>
        </div>
    </div>
</body>

</html>