<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/Models/Service.php';
require_once __DIR__ . '/../src/Repositories/ServiceRepository.php';

$servicesData = require __DIR__ . '/../data/services.php';
$repository = new ServiceRepository($servicesData);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Не указан ID услуги'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $service = $repository->getServiceById($id);
    
    $result = [
        'id' => $service->id,
        'title' => $service->title,
        'description' => $service->description,
        'price' => $service->price,
    ];
    
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (\RuntimeException $e) {
    http_response_code(404);
    echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}

