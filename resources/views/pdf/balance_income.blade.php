<!DOCTYPE html>
<html lang="ru">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Акт-Сверки</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url("{{ storage_path('fonts/DejaVuSans.ttf') }}") format('truetype');
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0px;
            padding-top: 0px;
            background-color: #f8f9fa;
            color: #333;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .contragent {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            /* Ko‘k rang */
            text-align: center;
            margin-bottom: 10px;
        }

        .contragent strong {
            color: #333;
            /* Qora rang */
        }


        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e2e6ea;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .amount {
            text-align: right;
        }
    </style>
</head>

<body>
    <h2>Приход денег </h2>
    {{-- <p> За период: последние 3 месяца</p> --}}
    @php
        $firstValidReport = $reports->first(function ($report) {
            return !empty($report->contragent);
        });
    @endphp

    <p class="contragent">
        <strong>Контрагент:</strong> {{ optional($firstValidReport)->contragent ?? 'Неизвестный контрагент' }}
    </p>
    <p class="contragent">
        <strong>ИНН:</strong>
        {{ optional($firstValidReport)->contragent_tin ? number_format($firstValidReport->contragent_tin, 0, '', ' ') : '—' }}
    </p>


    <table>
        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold;">Итого:</td>
            <td style="font-weight: bold;">{{ number_format($reports->sum('income'), 2, ',', ' ') }}</td>
        </tr>
        <thead>
            <tr>
                <th>№</th>
                <th>Дата</th>
                <th>Документ</th>
                <th>Сумма кредит</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="width: 80px;">{{ \Carbon\Carbon::parse($report->date)->format('d.m.Y') }}</td>
                    <td>{{ $report->document }}</td>
                    <td class="amount">{{ number_format($report->income, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Итого:</td>
                <td style="font-weight: bold;">{{ number_format($reports->sum('income'), 2, ',', ' ') }}</td>
            </tr>
        </tfoot>
    </table>

    <p class="footer"> Система автоматически сгенерировала этот отчет.</p>
</body>

</html>
