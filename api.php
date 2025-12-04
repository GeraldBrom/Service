<?php

// API endpoint для получения списка всех услуг
header('Content-Type: application/json; charset=utf-8');

// Подключение необходимых классов
require_once __DIR__ . '/src/Models/Service.php';
require_once __DIR__ . '/src/Repositories/ServiceRepository.php';

// Загрузка данных услуг и создание репозитория
$servicesData = require __DIR__ . '/data/services.php';
$repository = new ServiceRepository($servicesData);

// Получение всех услуг из репозитория
$services = $repository->getServicesAll();

// Формирование массива результата для JSON ответа
$result = [];
foreach ($services as $service) {
    $result[] = [
        'id' => $service->id,
        'title' => $service->title,
        'description' => $service->description,
        'price' => $service->price,
    ];
}

// Вывод результата в формате JSON
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);