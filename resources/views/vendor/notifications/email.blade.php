<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu correo electrónico</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }
        .email-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        .email-header h1 {
            margin: 20px 0 0;
            font-size: 28px;
            font-weight: 600;
        }
        .email-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            display: block;
        }
        .email-content {
            padding: 40px;
            text-align: center;
        }
        .email-content p {
            margin-bottom: 24px;
            font-size: 16px;
            color: #4a5568;
        }
        .verification-btn {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white !important;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
            transition: all 0.3s ease;
        }
        .verification-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.3);
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 24px;
            text-align: center;
            font-size: 14px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
        }
        .link-alternative {
            word-break: break-all;
            font-size: 13px;
            color: #4a5568;
            background: #f1f5f9;
            padding: 12px;
            border-radius: 6px;
            margin-top: 20px;
            display: inline-block;
            max-width: 100%;
        }
        .signature {
            margin-top: 20px;
            color: #4a5568;
            font-weight: 500;
        }
        @media (max-width: 640px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            .email-content {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <img src="https://cdn-icons-png.flaticon.com/512/3176/3176272.png" alt="Verificación" class="email-logo">
        <h1 style="color: white; text-align: center">Verifica tu dirección de correo</h1>
    </div>

    <div class="email-content">
        <p>¡Gracias por registrarte en nuestro servicio! Estamos emocionados de tenerte con nosotros.</p>
        <p>Para comenzar a disfrutar de todas las funcionalidades, por favor verifica tu dirección de correo electrónico haciendo clic en el siguiente botón:</p>

        @isset($actionText)
            <a href="{{ $actionUrl }}" class="verification-btn">Verificar mi correo</a>

            <p>Si el botón no funciona, copia y pega este enlace en tu navegador:</p>
            <a href="{{ $actionUrl }}" class="link-alternative">{{ $actionUrl }}</a>
        @endisset

        <p class="signature">{{ $salutation ?? ('El equipo de ' . config('app.name')) }}</p>
    </div>

    <div class="email-footer">
        <p>Si no solicitaste este correo, puedes ignorarlo de forma segura.</p>
        <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
    </div>
</div>
</body>
</html>
