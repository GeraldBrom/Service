<?php
$pageTitle = 'Детали услуги';
require_once __DIR__ . '/layout/header.php';
?>

<section class="service-detail">
    <div class="container">
        <div id="service-container">
            <div class="loading">Загрузка информации об услуге...</div>
        </div>
    </div>
</section>

<section id="contact" class="contact">
    <div class="container">
        <h2 class="section-title">Оставить заявку</h2>
        <form id="contact-form" class="contact-form">
            <input type="hidden" id="service-id" name="service_id">
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
