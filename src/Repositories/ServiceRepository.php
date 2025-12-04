<?php

// Класс репозитория для работы с услугами
class ServiceRepository
{
    private array $services = [];

    // Конструктор класса для инициализации репозитория
    public function __construct(array $servicesData)
    {
        foreach ($servicesData as $item) {
            $this->services[] = new Service(
                $item['id'],
                $item['title'],
                $item['description'],
                $item['price'],
            );
        }
    }

    // Метод для получения всех услуг из репозитория
    public function getServicesAll(): array
    {
        return $this->services;
    }

    // Метод для получения услуги по её идентификатору
    public function getServiceById(int $id): Service
    {
        foreach ($this->services as $service) {
            if ($service->id === $id) {
                return $service;
            }
        }

        throw new \RuntimeException("Услуга с ID {$id} не найдена");
    }

}