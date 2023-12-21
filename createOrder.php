<?php

// Configura tu ID de cliente de PayPal
$clientID = 'AezMuAOhAZTiZeWUHNK_8hRhLPXXqgs-uEB6eE9vdvaX_YLUzT8mD0ZLV4-boS8DnDK5QXiWMua7xcgI';
$secret = 'EJPv7_8kI5pc1LGENunCX-JSTk91sMlVo1P_KkAcOW5efEk4ps6zPBsjzrym0C3ShzEnPx6QfX2MGfrP';

// Configura las credenciales de sandbox o producción según tus necesidades
$sandbox = true;
$baseUrl = $sandbox ? 'https://api.sandbox.paypal.com' : 'https://api.paypal.com';

// Endpoint para crear una orden
$createOrderEndpoint = '/v2/checkout/orders';

// URL completa para la solicitud
$createOrderUrl = $baseUrl . $createOrderEndpoint;

// Configura las opciones de la solicitud
$options = [
    'http' => [
        'method' => 'POST',
        'header' => [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($clientID . ':' . $secret),
        ],
        'content' => json_encode([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => '100.00',
                    ],
                ],
            ],
        ]),
    ],
];


// Crea el contexto de la solicitud
$context = stream_context_create($options);

// Realiza la solicitud para crear la orden
$response = file_get_contents($createOrderUrl, false, $context);

// Verifica si la solicitud fue exitosa
if ($response === false) {
    // Manejar el error de la solicitud
    http_response_code(500);
    echo json_encode(['error' => 'Error al crear la orden de PayPal']);
} else {
    // La solicitud fue exitosa, devuelve la respuesta al cliente
    echo $response;
}

?>
