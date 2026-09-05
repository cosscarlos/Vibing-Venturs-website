<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recaptcha
    $recaptcha_secret = '6Lejig8qAAAAAOcY18HurZKJWcE0hbmCqAH19hSR';
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Verificar reCAPTCHA
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = [
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    ];
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptcha_data)
        ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($recaptcha_url, false, $context);
    $response_keys = json_decode($response, true);

    // Verificar el éxito del reCAPTCHA y el score mínimo
    if ($response_keys["success"] && $response_keys["score"] >= 0.5) {
        // Procesar el formulario si el reCAPTCHA es válido
        $name = htmlspecialchars(trim($_POST["name"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = htmlspecialchars(trim($_POST["message"]));

        $to = "info@vibingventurs.com";
        $subject = "Nuevo correo de contacto";

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
                        <th>Mensaje</th>
                    </tr>
                    <tr>
                        <td>$name</td>
                        <td>$email</td>
                        <td>$message</td>
                    </tr>
                </table>
            </body>
            </html>
        ";

        // Envío de correo
        if (mail($to, $subject, $body, $headers)) {
            echo "<script>alert('Mensaje enviado exitosamente!'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('Hubo un error al enviar el mensaje.'); window.location.href = 'index.html';</script>";
        }
    } else {
        // Si la verificación del reCAPTCHA falla
        echo "<script>alert('Por favor verifica que no eres un robot.'); window.location.href = 'index.html';</script>";
    }
}
?>
