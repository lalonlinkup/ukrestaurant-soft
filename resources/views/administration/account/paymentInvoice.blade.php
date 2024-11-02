@extends('master')
@section('title')
    {{ ucfirst($slug).' Payment Invoice' }}
@endsection
@section('breadcrumb_title')
    {{ ucfirst($slug).' Payment Invoice' }}
@endsection
@push('style')
    <style>
        * {
            font-size: 13px;
            margin: 0px auto;
            padding: 0px auto;
        }

        .border {
            border-collapse: collapse;
        }

        .border th {
            border: 1px solid #515050;
            font-size: 12px;
            font-weight: 600;
            padding: 4px;
            color: #000;
            font-family: tahoma;
        }

        .border td {
            border: 1px solid #515050;
            font-size: 12px;
            padding: 4px;
            color: #000;
            font-family: tahoma;
        }
    </style>
@endpush
@section('content')
    <div class="content_scroll" style="width: 850px; ">
        <div style="text-align: right;">
            <a href="{{ route($slug == 'customer' ? 'customer.payment' : 'supplier.payment') }}" title="" class="buttonAshiqe">Go Back</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a id="printIcon" style="cursor:pointer"> <i class="fa fa-print" style="font-size:24px;color:green"></i>
                Print</a>
        </div>
        <div id="reportContent">
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-xs-12">
                    <h6
                        style="background:#ddd; text-align: center; font-size: 18px; font-weight: 900; padding: 5px; color: #bd4700;">
                        {{ ucfirst($slug) }} Payment Invoice</h6>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-xs-12">
                    <table style="width: 100%;">
                        <tr>
                            <td style="font-size: 13px; font-weight: 600;"> TR. Id: {{ $payment->invoice }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; font-weight: 600; ">TR. Date: {{ date('d-m-Y',strtotime($payment->date)) }} </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-size: 13px; font-weight: 600; ">Name:
                                {{ $slug == 'customer' ? $payment->customer->name : $payment->supplier->name }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-size: 13px; font-weight: 600; ">Phone No:
                                {{ $slug == 'customer' ? $payment->customer->phone : $payment->supplier->phone }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row" style="margin-bottom: 20px;">
                <div class="col-xs-12">
                    <table class="border" cellspacing="0" cellpadding="0" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="font-size: 14px; font-weight: 700;text-align:center;">Sl No</th>
                                <th style="font-size: 14px; font-weight: 700;text-align:center;">Description</th>
                                <th style="font-size: 14px; font-weight: 700;text-align:center;">Recieved</th>
                                <th style="font-size: 14px; font-weight: 700;text-align:center;">Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;">01</td>
                                <td>
                                    {{ $payment->method }}
                                    @if($payment->method == 'bank')
                                     - {{$payment->bankAccount ? $payment->bankAccount->name:'n/a'}} - {{$payment->bankAccount ? $payment->bankAccount->number:'n/a'}}
                                    @endif
                                </td>
                                <td style="text-align:right;">
                                    @if ($payment->type == 'CR')
                                        {{ number_format($payment->amount, 2, '.', '') }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                                <td style="text-align:right;">
                                    @if ($payment->type == 'CP')
                                        {{ number_format($payment->amount, 2, '.', '') }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2" style="font-size: 14px; font-weight: 700; text-align: right;">Total:</th>
                                <th style="font-size: 13px; font-weight: 700;text-align:right;">
                                    @if ($payment->type == 'CR')
                                        {{ number_format($payment->amount, 2, '.', '') }}
                                    @else
                                        0.00
                                    @endif
                                </th>
                                <th style="font-size: 13px; font-weight: 700;text-align:right;">
                                    @if ($payment->type == 'CP')
                                        {{ number_format($payment->amount, 2, '.', '') }}
                                    @else
                                        0.00
                                    @endif
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-xs-12">
                    <h6 style=" font-size: 12px; font-weight: 600;">Paid (In Word):
                        {{ convertNumberToWord($payment->amount) }}</h6>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-xs-12 text-left;">
                    <table style="width: 25%;float:left;">
                        @if ($slug == 'customer')
                        <tr>
                            <td style="font-size: 13px; font-weight: 600; ">Previous Due : </td>
                            <td style="font-size: 13px; font-weight: 600; text-align: right; ">
                                {{ number_format($payment->previous_due, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; font-weight: 600; border-bottom: 2px solid #000; ">Paid Amount :
                            </td>
                            <td
                                style="font-size: 13px; font-weight: 600; border-bottom: 2px solid #000; text-align: right; ">
                                {{ number_format($payment->amount, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; font-weight: 600; ">Current Due : </td>
                            <td style="font-size: 13px; font-weight: 600; text-align: right; ">
                                @if ($payment->type == 'CR')
                                    {{ number_format(($payment->previous_due - $payment->amount), 2, '.', '') }}
                                @else
                                    {{ number_format(($payment->previous_due + $payment->amount), 2, '.', '') }}
                                @endif
                            </td>
                        </tr>
                        @endif
                    </table>
                    <div style="float:right;text-decoration: overline;">
                        <strong>Autorizied signature</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        function convertNumberToWord($num = false)
        {
            $num = str_replace([',', ' '], '', trim($num));
            if (!$num) {
                return false;
            }
            $num = (int) $num;
            $words = [];
            $list1 = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
            $list2 = ['', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred'];
            $list3 = ['', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion', 'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'];
            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);
            for ($i = 0; $i < count($num_levels); $i++) {
                $levels--;
                $hundreds = (int) ($num_levels[$i] / 100);
                $hundreds = $hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '';
                $tens = (int) ($num_levels[$i] % 100);
                $singles = '';
                if ($tens < 20) {
                    $tens = $tens ? ' ' . $list1[$tens] . ' ' : '';
                } else {
                    $tens = (int) ($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = (int) ($num_levels[$i] % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . ($levels && (int) $num_levels[$i] ? ' ' . $list3[$levels] . ' ' : '');
            } //end for loop
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }
            $inword = implode(' ', $words) . 'Only';
            return strtoupper($inword);
        }

    @endphp
@endsection

@push('script')
    <script>
        let printIcon = document.querySelector('#printIcon');
        printIcon.addEventListener('click', () => {
            event.preventDefault();
            print();
        })
        async function print() {
            let reportContent = `
            <style>
                .border {
                    border-collapse: collapse;
                }

                .border th {
                    border: 1px solid #515050;
                    font-size: 12px;
                    font-weight: 600;
                    padding: 4px;
                    color: #000;
                    font-family: tahoma;
                }

                .border td {
                    border: 1px solid #515050;
                    font-size: 12px;
                    padding: 4px;
                    color: #000;
                    font-family: tahoma;
                }
            </style>
            <div class="container">
                ${document.querySelector('#reportContent').innerHTML}
            </div>
        `;

            var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
            reportWindow.document.write(`
            @include('administration/reports/reportHeader')
        `);

            reportWindow.document.body.innerHTML += reportContent;

            reportWindow.focus();
            await new Promise(resolve => setTimeout(resolve, 1000));
            reportWindow.print();
            reportWindow.close();
        }
    </script>
@endpush
