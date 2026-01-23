<?php

echo "\n=================================\n";
echo "TEST DE ENDPOINTS - IES El Rincón\n";
echo "=================================\n\n";

$baseUrl = 'http://localhost:8000/api';
$token = '';

// Función helper para hacer peticiones
function makeRequest($method, $url, $data = null, $token = null)
{
    $ch = curl_init($url);

    $headers = ['Content-Type: application/json'];
    if ($token) {
        $headers[] = "Authorization: Bearer $token";
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'code' => $httpCode,
        'body' => json_decode($response, true)
    ];
}

// TEST 1: Login
echo "1️⃣  TEST: Login (POST /login)\n";
echo "-----------------------------------\n";
$response = makeRequest('POST', "$baseUrl/login", [
    'email' => 'admin@iesrincon.es',
    'password' => 'admin123'
]);

if ($response['code'] === 200) {
    echo "✅ Login exitoso!\n";
    echo "   Usuario: " . $response['body']['user']['name'] . "\n";
    echo "   Role: " . $response['body']['user']['role'] . "\n";
    $token = $response['body']['access_token'];
    echo "   Token obtenido: " . substr($token, 0, 20) . "...\n";
} else {
    echo "❌ Error en login: HTTP " . $response['code'] . "\n";
    print_r($response['body']);
    exit(1);
}

echo "\n";

// TEST 2: Me (Usuario autenticado)
echo "2️⃣  TEST: Me (GET /me)\n";
echo "-----------------------------------\n";
$response = makeRequest('GET', "$baseUrl/me", null, $token);

if ($response['code'] === 200) {
    echo "✅ Usuario autenticado!\n";
    echo "   Email: " . $response['body']['user']['email'] . "\n";
} else {
    echo "❌ Error: HTTP " . $response['code'] . "\n";
}

echo "\n";

// TEST 3: Listar Aulas
echo "3️⃣  TEST: Listar Aulas (GET /rooms)\n";
echo "-----------------------------------\n";
$response = makeRequest('GET', "$baseUrl/rooms", null, $token);

if ($response['code'] === 200) {
    echo "✅ Aulas obtenidas!\n";
    echo "   Total de aulas: " . count($response['body']) . "\n";
    if (count($response['body']) > 0) {
        echo "   Primera aula: " . $response['body'][0]['name'] . " (Barcode: " . $response['body'][0]['barcode'] . ")\n";
    }
} else {
    echo "❌ Error: HTTP " . $response['code'] . "\n";
}

echo "\n";

// TEST 4: Listar Materiales
echo "4️⃣  TEST: Listar Materiales (GET /materials)\n";
echo "-----------------------------------\n";
$response = makeRequest('GET', "$baseUrl/materials", null, $token);

if ($response['code'] === 200) {
    echo "✅ Materiales obtenidos!\n";
    echo "   Total de materiales: " . count($response['body']) . "\n";
    if (count($response['body']) > 0) {
        echo "   Primer material: " . $response['body'][0]['name'] . " (" . $response['body'][0]['status'] . ")\n";
    }
} else {
    echo "❌ Error: HTTP " . $response['code'] . "\n";
}

echo "\n";

// TEST 5: Crear nueva aula
echo "5️⃣  TEST: Crear Aula (POST /rooms)\n";
echo "-----------------------------------\n";
$response = makeRequest('POST', "$baseUrl/rooms", [
    'name' => 'Aula Test 999',
    'barcode' => 'TEST-999-BC-' . time(),
    'description' => 'Aula de prueba creada automáticamente'
], $token);

if ($response['code'] === 201) {
    echo "✅ Aula creada exitosamente!\n";
    echo "   ID: " . $response['body']['id'] . "\n";
    echo "   Nombre: " . $response['body']['name'] . "\n";
    $testRoomId = $response['body']['id'];
} else {
    echo "❌ Error: HTTP " . $response['code'] . "\n";
    if (isset($response['body']['message'])) {
        echo "   Mensaje: " . $response['body']['message'] . "\n";
    }
}

echo "\n";

// TEST 6: Obtener aula específica
if (isset($testRoomId)) {
    echo "6️⃣  TEST: Obtener Aula (GET /rooms/{id})\n";
    echo "-----------------------------------\n";
    $response = makeRequest('GET', "$baseUrl/rooms/$testRoomId", null, $token);

    if ($response['code'] === 200) {
        echo "✅ Aula obtenida!\n";
        echo "   Nombre: " . $response['body']['name'] . "\n";
        echo "   Barcode: " . $response['body']['barcode'] . "\n";
    } else {
        echo "❌ Error: HTTP " . $response['code'] . "\n";
    }

    echo "\n";
}

// TEST 7: Crear reserva
echo "7️⃣  TEST: Crear Reserva de Aula (POST /room-reservations)\n";
echo "-----------------------------------\n";
$response = makeRequest('POST', "$baseUrl/room-reservations", [
    'user_id' => 1,
    'room_id' => 1,
    'start_date' => '2026-01-30 09:00:00',
    'end_date' => '2026-01-30 11:00:00',
    'observations' => 'Reserva de prueba automática',
    'status' => 'activa'
], $token);

if ($response['code'] === 201) {
    echo "✅ Reserva creada exitosamente!\n";
    echo "   ID: " . $response['body']['id'] . "\n";
    echo "   Usuario: " . $response['body']['user']['name'] . "\n";
    echo "   Aula: " . $response['body']['room']['name'] . "\n";
    $testReservationId = $response['body']['id'];
} else {
    echo "❌ Error: HTTP " . $response['code'] . "\n";
    if (isset($response['body']['errors'])) {
        print_r($response['body']['errors']);
    }
}

echo "\n";

// TEST 8: Crear préstamo
echo "8️⃣  TEST: Crear Préstamo (POST /material-loans)\n";
echo "-----------------------------------\n";
$response = makeRequest('POST', "$baseUrl/material-loans", [
    'user_id' => 2,
    'material_id' => 1,
    'loan_date' => '2026-01-23 10:00:00',
    'due_date' => '2026-01-30 10:00:00',
    'observations' => 'Préstamo de prueba automático',
    'status' => 'prestado'
], $token);

if ($response['code'] === 201) {
    echo "✅ Préstamo creado exitosamente!\n";
    echo "   ID: " . $response['body']['id'] . "\n";
    echo "   Usuario: " . $response['body']['user']['name'] . "\n";
    echo "   Material: " . $response['body']['material']['name'] . "\n";
    $testLoanId = $response['body']['id'];
} else {
    echo "❌ Error: HTTP " . $response['code'] . "\n";
    if (isset($response['body']['errors'])) {
        print_r($response['body']['errors']);
    }
}

echo "\n";

// TEST 9: Actualizar préstamo (marcar como devuelto)
if (isset($testLoanId)) {
    echo "9️⃣  TEST: Actualizar Préstamo (PUT /material-loans/{id})\n";
    echo "-----------------------------------\n";
    $response = makeRequest('PUT', "$baseUrl/material-loans/$testLoanId", [
        'return_date' => '2026-01-23 18:00:00',
        'status' => 'devuelto'
    ], $token);

    if ($response['code'] === 200) {
        echo "✅ Préstamo actualizado!\n";
        echo "   Estado: " . $response['body']['status'] . "\n";
        echo "   Fecha devolución: " . $response['body']['return_date'] . "\n";
    } else {
        echo "❌ Error: HTTP " . $response['code'] . "\n";
    }

    echo "\n";
}

// TEST 10: Logout
echo "🔟 TEST: Logout (POST /logout)\n";
echo "-----------------------------------\n";
$response = makeRequest('POST', "$baseUrl/logout", null, $token);

if ($response['code'] === 200) {
    echo "✅ Logout exitoso!\n";
    echo "   " . $response['body']['message'] . "\n";
} else {
    echo "❌ Error: HTTP " . $response['code'] . "\n";
}

echo "\n";
echo "=================================\n";
echo "✅ TESTS COMPLETADOS\n";
echo "=================================\n\n";
