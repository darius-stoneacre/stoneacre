<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Report</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            /*height: 100vh;*/
            margin: 0;
        }

        .full-height {
            /*height: 100vh;*/
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content" style="width: 80%;align-content: center">
        <div class="title m-b-md">
            Report
        </div>

        <h4>Success: {{ count($success) }}</h4>
        <h4>Failed: {{ count($failed) }}</h4>
        <table>
            <thead>
                <th><label>Make</label></th>
                <th><label>Range</label></th>
                <th><label>Model</label></th>
                <th><label>Derivative</label></th>
                <th><label>Reg</label></th>
                <th><label>CSV Line</label></th>
                <th><label>Failed</label></th>
            </thead>
            <tbody>
            @foreach($failed as $fail)
                <tr>
                    <td>{{ $fail['MAKE'] ?? '' }}</td>
                    <td>{{ $fail['RANGE'] ?? '' }}</td>
                    <td>{{ $fail['MODEL'] ?? '' }}</td>
                    <td>{{ $fail['DERIVATIVE'] ?? '' }}</td>
                    <td>{{ $fail['REG'] ?? '' }}</td>
                    <td>{{ $fail['error']['line_csv'] ?? '' }}</td>
                    <td style="font-size: 9pt;">{{ $fail['error']['message'] ??  '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
