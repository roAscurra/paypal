<?php

// Configura tus credenciales de cliente y secretas de PayPal
$clientID = 'AezMuAOhAZTiZeWUHNK_8hRhLPXXqgs-uEB6eE9vdvaX_YLUzT8mD0ZLV4-boS8DnDK5QXiWMua7xcgI';
$secret = 'EJPv7_8kI5pc1LGENunCX-JSTk91sMlVo1P_KkAcOW5efEk4ps6zPBsjzrym0C3ShzEnPx6QfX2MGfrP';

// Configura las credenciales de sandbox o producción según tus necesidades
$sandbox = true;
$baseUrl = $sandbox ? 'https://api.sandbox.paypal.com' : 'https://api.paypal.com';

// Obtén el ID de la orden desde el cuerpo de la solicitud
$orderID = json_decode(file_get_contents('php://input'), true)['orderID'];

// Endpoint para capturar la orden
$captureOrderEndpoint = '/v2/checkout/orders/' . $orderID . '/capture';

// URL completa para la solicitud
$captureOrderUrl = $baseUrl . $captureOrderEndpoint;

// Configura las opciones de la solicitud
$options = [
    'http' => [
        'method' => 'POST',
        'header' => [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($clientID . ':' . $secret),
        ],
        'content' => json_encode([]),
    ],
];

// Crea el contexto de la solicitud
$context = stream_context_create($options);

// Realiza la solicitud para capturar la orden
$response = file_get_contents($captureOrderUrl, false, $context);

// Verifica si la solicitud fue exitosa
if ($response === false) {
    // Manejar el error de la solicitud
    http_response_code(500);
    echo json_encode(['error' => 'Error al capturar la orden de PayPal']);
} else {
    // La solicitud fue exitosa, devuelve la respuesta al cliente
    echo $response;
}

?>
