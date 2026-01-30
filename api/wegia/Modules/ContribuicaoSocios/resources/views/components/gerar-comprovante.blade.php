<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante de Doacoes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            color: #333;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .info-box p {
            line-height: 1.8;
            margin-bottom: 8px;
        }

        .info-box strong {
            color: #2c3e50;
        }

        .metadata {
            margin-bottom: 25px;
            font-size: 11px;
        }

        .metadata p {
            margin-bottom: 5px;
            color: #666;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #3498db;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead {
            background-color: #3498db;
            color: white;
        }

        table th {
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }

        table td {
            padding: 10px 8px;
            border-bottom: 1px solid #dee2e6;
            font-size: 11px;
        }

        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table tbody tr:hover {
            background-color: #e9ecef;
        }

        .total {
            text-align: right;
            margin-top: 15px;
            font-size: 14px;
        }

        .total strong {
            color: #27ae60;
            font-size: 16px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
<div class="header">
    @if($logoBase64)
        <img src="{{ $logoBase64 }}" style="width: 150px;margin-bottom: 56px">
    @endif

    <h1>COMPROVANTE DE DOACOES</h1>
</div>

<div class="info-box">
    <p>Agradecemos a <strong>{{ $nome }}</strong> (Código de Doador: {{ $codigo }})</p>
    <p>pela doacao de <strong>R$ {{ $soma }}</strong> para nossa instituicao (CNPJ: <strong>{{ $cnpjInstituicao->paragrafo ?? 'XX.XXX.XXX/XXXX-XX' }}</strong>) no ano de <strong>{{ date('Y') }}</strong>.</p>
    <p style="margin-top: 15px; font-style: italic; color: #555;">{{ $mensagemAgradecimento->paragrafo ?? 'Mensagem de Agradecimento ao DOADOR' }}</p>
</div>

<div class="metadata">
    <p><strong>Codigo do Comprovante:</strong> {{ $codigo }}</p>
    <p><strong>Data de Emissao:</strong> {{ date('d/m/Y H:i:s') }}</p>
    <p><strong>Periodo:</strong> {{ \Carbon\Carbon::parse($comprovante->min('data_geracao'))->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($comprovante->max('data_geracao'))->format('d/m/Y') }}</p>
    <p><strong>CPF:</strong> {{ $comprovante[0]->socio->pessoa->cpf ?? 'Nao informado' }}</p>
</div>

<h2 class="section-title">Detalhamento das Doacoes</h2>

<table>
    <thead>
    <tr>
        <th>Codigo</th>
        <th>M. Pagamento</th>
        <th>D. Emissao</th>
        <th>D. Pagamento</th>
        <th style="text-align: right;">Valor</th>
    </tr>
    </thead>
    <tbody>
    @foreach($comprovante as $item)
        <tr>
            <td>{{ $item->codigo }}</td>
            <td>{{ $item->meioPagamento->meio ?? 'N/A' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->data_geracao)->format('d/m/Y') }}</td>
            <td>{{ $item->data_pagamento ? \Carbon\Carbon::parse($item->data_pagamento)->format('d/m/Y') : '-' }}</td>
            <td style="text-align: right;">R$ {{ number_format((float)$item->valor, 2, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="total">
    <p><strong>Total: R$ {{ $soma }}</strong></p>
</div>

</body>
</html>
