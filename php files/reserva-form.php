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
        $to = 'info@vibingventurs.com';
$clientEmail = $_POST['Email'];
$subject = 'Reserva de boleto recibida';
$clientSubject = '¡Gracias por tu reserva!';

// Mensaje para el correo del administrador
$message = '
<html>
<head>
  <title>Datos de la Reserva</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid black;
    }
    th, td {
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <h2>Datos de la Reserva</h2>
  <table>
    <tr>
      <th>Campo</th>
      <th>Valor</th>
    </tr>
    <tr><td>Primer nombre</td><td>' . htmlspecialchars($_POST['primer_nombre']) . '</td></tr>
    <tr><td>Segundo nombre</td><td>' . htmlspecialchars($_POST['segundo_nombre']) . '</td></tr>
    <tr><td>Primer apellido</td><td>' . htmlspecialchars($_POST['primer_apellido']) . '</td></tr>
    <tr><td>Segundo apellido</td><td>' . htmlspecialchars($_POST['segundo_apellido']) . '</td></tr>
    <tr><td>N° de pasaporte</td><td>' . htmlspecialchars($_FILES['pasaporte']['name']) . '</td></tr>
    <tr><td>Fecha de expedición</td><td>' . htmlspecialchars($_POST['fecha_expedicion']) . '</td></tr>
    <tr><td>Fecha de expiración</td><td>' . htmlspecialchars($_POST['fecha_expiracion']) . '</td></tr>
    <tr><td>Edad</td><td>' . htmlspecialchars($_POST['Edad']) . '</td></tr>
    <tr><td>Código de área</td><td>' . htmlspecialchars($_POST['Codigo_area']) . '</td></tr>
    <tr><td>Teléfono</td><td>' . htmlspecialchars($_POST['telefono']) . '</td></tr>
    <tr><td>Correo electrónico</td><td>' . htmlspecialchars($_POST['Email']) . '</td></tr>
    <tr><td>Origen</td><td>' . htmlspecialchars($_POST['Origen']) . '</td></tr>
    <tr><td>Destino</td><td>' . htmlspecialchars($_POST['Destino']) . '</td></tr>
    <tr><td>Fecha de salida</td><td>' . htmlspecialchars($_POST['fecha_salida']) . '</td></tr>
    <tr><td>Fecha de regreso</td><td>' . htmlspecialchars($_POST['fecha_regreso']) . '</td></tr>
    <tr><td>Maleta de mano</td><td>' . htmlspecialchars($_POST['maletas_de_mano']) . '</td></tr>
    <tr><td>Maleta facturada</td><td>' . htmlspecialchars($_POST['maleta_facturada']) . '</td></tr>
    <tr><td>Pre seleccionar asiento</td><td>' . (isset($_POST['Pre_seleccion_asiento']) ? 'Sí' : 'No') . '</td></tr>
    <tr><td>Cambio de itinerario</td><td>' . (isset($_POST['cambio_itinerario']) ? 'Sí' : 'No') . '</td></tr>
    <tr><td>Asiento Premium</td><td>' . (isset($_POST['Asiento_Premium']) ? 'Sí' : 'No') . '</td></tr>
    <tr><td>Acceso Sala VIP</td><td>' . (isset($_POST['Acceso_sala_VIP']) ? 'Sí' : 'No') . '</td></tr>
    <tr><td>Check-in por Vibing Venturs</td><td>' . (isset($_POST['Check-in_vibing']) ? 'Sí' : 'No') . '</td></tr>
    <tr><td>Código de área (Emergencia)</td><td>' . htmlspecialchars($_POST['Codigo_area_emergencia']) . '</td></tr>
    <tr><td>Teléfono (Emergencia)</td><td>' . htmlspecialchars($_POST['telefono_emergencia']) . '</td></tr>
    <tr><td>Correo electrónico (Emergencia)</td><td>' . htmlspecialchars($_POST['Email_emergencia']) . '</td></tr>
  </table>
</body>
</html>
';

// Mensaje para el correo del cliente
$clientMessage = '
<html>
<head>
  <title>Confirmación de Reserva</title>
</head>
<body>
  <p>¡Gracias por tu reserva!</p>
  <p>Este correo es para notificarte de que tu formulario ha sido enviado exitosamente.</p>
  <p>Atentamente, el equipo de Vibing Venturs.</p>
</body>
</html>
';

// Configuración de los headers para el correo HTML
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: <info@vibingventurs.com>' . "\r\n";

// Enviar correo al administrador
mail($to, $subject, $message, $headers);

// Enviar correo al cliente
mail($clientEmail, $clientSubject, $clientMessage, $headers);

// Redireccionar al usuario a una página de agradecimiento
header('Location: index.html');
exit();







        
    } else {
        // Si la verificación del reCAPTCHA falla
        echo "<script>alert('Por favor verifica que no eres un robot.'); window.location.href = 'index.html';</script>";
    }
}
?>
