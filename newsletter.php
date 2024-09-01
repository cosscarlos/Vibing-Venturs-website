<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Clave secreta de reCAPTCHA
    $recaptcha_secret = '6Lejig8qAAAAAOcY18HurZKJWcE0hbmCqAH19hSR';
    // Respuesta de reCAPTCHA del formulario
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Verificar reCAPTCHA
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = [
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    ];
    // Configurar opciones para la solicitud HTTP
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptcha_data)
        ]
    ];
    // Crear contexto de flujo para la solicitud
    $context = stream_context_create($options);
    // Realizar solicitud a la API de reCAPTCHA
    $response = file_get_contents($recaptcha_url, false, $context);
    // Decodificar la respuesta JSON
    $response_keys = json_decode($response, true);

    // Verificar si la verificación de reCAPTCHA fue exitosa y si la puntuación es suficiente
    if ($response_keys["success"] && $response_keys["score"] >= 0.5) {
        // Procesar el formulario si la verificación de reCAPTCHA es válida
        $name = htmlspecialchars(trim($_POST["name"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

        // Validar nombre y correo electrónico (ejemplo básico)
        if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Por favor completa todos los campos correctamente.'); window.location.href = 'index.html';</script>";
            exit; // Salir del script si hay errores
        }

        // Envío de correo
        $to = "info@vibingventurs.com";
        $subject = "Nuevo registro de newsletter";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: <$email>" . "\r\n";

        $body = "
            <html>
            <head>
                <title>$subject</title>
            </head>
            <body>
                <table border='1'>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                    </tr>
                    <tr>
                        <td>$name</td>
                        <td>$email</td>
                    </tr>
                </table>
            </body>
            </html>
        ";

        // Enviar correo electrónico
        if (mail($to, $subject, $body, $headers)) {
            echo "<script>alert('Mensaje enviado exitosamente!'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('Hubo un error al enviar el mensaje.'); window.location.href = 'index.html';</script>";
        }
    } else {
        // Si la verificación de reCAPTCHA falla, mostrar mensaje de error
        echo "<script>alert('Por favor verifica que no eres un robot.'); window.location.href = 'index.html';</script>";
    }
}
?>
