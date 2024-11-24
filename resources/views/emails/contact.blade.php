<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje de contacto</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f9ff;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
        }
        .hero {
            text-align: center;
        }
        .hero h1 {
            font-size: 36px;
            font-family: 'Patrick Hand', sans-serif;
            color: #00796b;
        }
        .hero p {
            font-size: 18px;
            margin: 10px 0;
        }
        .content {
            margin-top: 30px;
            font-size: 16px;
            line-height: 1.6;
        }
        .content p {
            margin-bottom: 10px;
        }
        .content .strong {
            font-weight: bold;
            color: #00796b;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        .btn {
            display: inline-block;
            background-color: #00796b;
            color: #fff;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="hero">
        <h1>Nuevo mensaje de contacto</h1>
        <p>Has recibido un mensaje de un usuario interesado en tu página web.</p>
    </div>

    <div class="content">
        <p><span class="strong">Nombre:</span> {{ $data['name'] }}</p>
        <p><span class="strong">Email:</span> {{ $data['email'] }}</p>
        <p><span class="strong">Asunto:</span> {{ $data['title'] }}</p>
        <p><span class="strong">Mensaje:</span></p>
        <p>{{ $data['message'] }}</p>
    </div>

    <div class="footer">
        <p>Gracias por usar nuestro servicio de contacto. Si no esperabas este mensaje, por favor ignóralo.</p>
    </div>
</div>

</body>
</html>
