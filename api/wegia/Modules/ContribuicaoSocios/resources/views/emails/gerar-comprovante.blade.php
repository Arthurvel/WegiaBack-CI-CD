<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante de Doacoes - {{ $titulo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .header {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin: 0;
            font-weight: 600;
        }

        .content {
            padding: 40px 30px;
            background-color: #f8f9fa;
        }

        .greeting {
            margin-bottom: 20px;
            font-size: 16px;
            line-height: 1.6;
        }

        .message {
            margin-bottom: 25px;
            font-size: 15px;
            line-height: 1.6;
            color: #555;
        }

        .highlight-box {
            background-color: #ffffff;
            border-left: 4px solid #3498db;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .highlight-box p {
            margin: 0;
            font-size: 16px;
            color: #2c3e50;
        }

        .highlight-box strong {
            color: #3498db;
            font-size: 18px;
        }

        .signature {
            margin-top: 30px;
            font-size: 15px;
            line-height: 1.6;
        }

        .footer {
            background-color: #ffffff;
            padding: 20px 30px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
        }

        .footer p {
            font-size: 12px;
            color: #999;
            margin: 5px 0;
            line-height: 1.5;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <h1>{{ $titulo }}</h1>
    </div>

    <div class="content">
        <div class="greeting">
            <p>Prezado(a) <strong>{{ $nome }}</strong>,</p>
        </div>

        <p>
            Anexamos o comprovante de suas doações no período de
            <strong>{{ \Carbon\Carbon::parse($periodoInicio)->format('d/m/Y') }}</strong>
            a
            <strong>{{ \Carbon\Carbon::parse($periodoFim)->format('d/m/Y') }}</strong>.
        </p>

        <div class="highlight-box">
            <p><strong>Valor Total: R$ {{ $valorTotal }}</strong></p>
        </div>

        <div class="signature">
            <p>Atenciosamente,<br>{{ $titulo }}</p>
        </div>
    </div>

    <div class="footer">
        <p>Este email foi enviado automaticamente pelo sistema.</p>
        <p>Data: {{ $dataEnvio }}</p>
    </div>
</div>
</body>
</html>
