<?php

// Класс модели услуги, представляющий данные об услуге
class Service
{
    public int $id;
    public string $title;
    public string $description;
    public int $price;

    // Конструктор класса для инициализации свойств услуги
    public function __construct(
        int $id,
        string $title,
        string $description,
        int $price
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
    }
}