<?php
$pageTitle = 'Главная - Список услуг';
require_once __DIR__ . '/layout/header.php';
?>

<section class="hero">
    <div class="container">
        <h1 class="hero-title">Наши услуги</h1>
        <p class="hero-subtitle">Выберите услугу, которая вам подходит</p>
    </div>
</section>

<section id="services" class="services">
    <div class="container">
        <div id="services-container" class="services-grid">
            <div class="loading">Загрузка услуг...</div>
        </div>
    </div>
</section>

<section id="contact" class="contact">
    <div class="container">
        <h2 class="section-title">Оставить заявку</h2>
        <form id="contact-form" class="contact-form">
            <div class="form-group">
                <label for="name">Имя *</label>
                <input type="text" id="name" name="name" required>
                <span class="error-message" id="name-error"></span>
            </div>
            <div class="form-group">
                <label for="contact">Email или телефон *</label>
                <input type="text" id="contact" name="contact" required>
                <span class="error-message" id="contact-error"></span>
            </div>
            <button type="submit" class="btn btn-primary">Отправить заявку</button>
            <div id="form-message" class="form-message"></div>
        </form>
    </div>
</section>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
