async function loadServices() {
    const container = document.getElementById('services-container');
    if (!container) return;

    try {
        const basePath = window.BASE_PATH || '';
        const response = await fetch(`${basePath}/api.php`);
        if (!response.ok) throw new Error('Ошибка загрузки услуг');
        
        const services = await response.json();

        if (services.length === 0) {
            container.innerHTML = '<p class="no-services">Услуги не найдены</p>';
            return;
        }

        container.innerHTML = services.map(service => `
            <div class="service-card" onclick="window.location.href='${basePath}/service.php?id=${service.id}'">
                <h3 class="service-card-title">${escapeHtml(service.title)}</h3>
                <p class="service-card-description">${escapeHtml(service.description)}</p>
                <div class="service-card-footer">
                    <span class="service-card-price">${new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', minimumFractionDigits: 0 }).format(service.price)}</span>
                    <button class="btn btn-secondary">Подробнее</button>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Ошибка загрузки услуг:', error);
        container.innerHTML = '<p class="error">Ошибка загрузки услуг. Попробуйте обновить страницу.</p>';
    }
}

async function loadService() {
    const container = document.getElementById('service-container');
    if (!container) return;

    const serviceId = new URLSearchParams(window.location.search).get('id');
    if (!serviceId) {
        container.innerHTML = '<p class="error">ID услуги не указан</p>';
        return;
    }

    try {
        const basePath = window.BASE_PATH || '';
        const response = await fetch(`${basePath}/api/api-service.php?id=${serviceId}`);
        
        if (!response.ok) {
            if (response.status === 404) {
                try {
                    const error = await response.json();
                    throw new Error(error.error || 'Услуга не найдена');
                } catch {
                    throw new Error('Услуга не найдена');
                }
            }
            throw new Error('Ошибка загрузки услуги');
        }
        
        const service = await response.json();

        container.innerHTML = `
            <div class="service-detail-card">
                <h1 class="service-detail-title">${escapeHtml(service.title)}</h1>
                <p class="service-detail-description">${escapeHtml(service.description)}</p>
                <div class="service-detail-price">${new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', minimumFractionDigits: 0 }).format(service.price)}</div>
                <a href="${basePath}/" class="btn btn-secondary">Вернуться к списку</a>
            </div>
        `;

        const serviceIdInput = document.getElementById('service-id');
        if (serviceIdInput) {
            serviceIdInput.value = service.id;
        }
    } catch (error) {
        console.error('Ошибка загрузки услуги:', error);
        container.innerHTML = `<p class="error">${escapeHtml(error.message)}</p>`;
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function validateForm(formData) {
    const errors = {};
    const name = formData.get('name')?.trim() || '';
    const contact = formData.get('contact')?.trim() || '';

    if (!name) {
        errors.name = 'Имя обязательно для заполнения';
    }

    if (!contact) {
        errors.contact = 'Контактные данные обязательны для заполнения';
    } else {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRegex = /^[\d\s\-\+\(\)]+$/;
        
        if (!emailRegex.test(contact) && !phoneRegex.test(contact)) {
            errors.contact = 'Укажите корректный email или телефон';
        }
    }

    return errors;
}

function showValidationErrors(errors) {
    document.querySelectorAll('.error-message').forEach(el => {
        el.textContent = '';
        el.style.display = 'none';
    });

    Object.keys(errors).forEach(field => {
        const errorElement = document.getElementById(`${field}-error`);
        if (errorElement) {
            errorElement.textContent = errors[field];
            errorElement.style.display = 'block';
        }
    });
}

async function handleFormSubmit(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const messageElement = document.getElementById('form-message');

    const errors = validateForm(formData);
    if (Object.keys(errors).length > 0) {
        showValidationErrors(errors);
        messageElement.textContent = '';
        messageElement.className = 'form-message';
        return;
    }

    showValidationErrors({});

    const data = {
        name: formData.get('name'),
        contact: formData.get('contact'),
    };

    const serviceId = formData.get('service_id');
    if (serviceId) {
        data.service_id = parseInt(serviceId);
    }

    try {
        const basePath = window.BASE_PATH || '';
        const response = await fetch(`${basePath}/api/api-form.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (!response.ok) {
            if (result.errors) {
                showValidationErrors(result.errors);
            }
            messageElement.textContent = result.error || 'Ошибка отправки заявки';
            messageElement.className = 'form-message error';
            return;
        }

        messageElement.textContent = result.message || 'Заявка успешно отправлена!';
        messageElement.className = 'form-message success';
        form.reset();

        setTimeout(() => {
            messageElement.textContent = '';
            messageElement.className = 'form-message';
        }, 5000);
    } catch (error) {
        console.error('Ошибка отправки формы:', error);
        messageElement.textContent = 'Ошибка отправки заявки. Попробуйте позже.';
        messageElement.className = 'form-message error';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('services-container')) {
        loadServices();
    }

    if (document.getElementById('service-container')) {
        loadService();
    }

    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', handleFormSubmit);
    }
});