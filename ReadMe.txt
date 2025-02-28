 
# Zoho CRM Integration

Цей проєкт реалізує інтеграцію з **Zoho CRM**, дозволяючи створювати угоди (**Deals**) та акаунти (**Accounts**) через API.

## 🔧 Використані технології
- **Back-end**: Laravel
- **Front-end**: Vue.js
- **База даних**: MySQL/PostgreSQL
- **Zoho CRM API**: Для взаємодії з CRM

## 📂 Структура проєкту
- `resources/js/components/ZohoForm.vue` – Форма для введення даних угоди та акаунта
- `app/Http/Controllers/ZohoController.php` – Контролер для обробки API-запитів
- `app/Services/ZohoTokenService.php` – Сервіс для збереження та оновлення токенів
- `database/migrations/create_zoho_tokens_table.php` – Міграція для збереження токенів

---

## 🚀 Налаштування проєкту

### 1️⃣ Клонування репозиторію
```bash
 git clone https://github.com/your-repo.git
 cd your-repo
```

### 2️⃣ Встановлення залежностей
```bash
composer install
npm install
```

### 3️⃣ Налаштування .env
```bash
cp .env.example .env
```
Редагуйте `.env` та додайте ключі Zoho API:
```env
ZOHO_CLIENT_ID=your_zoho_client_id
ZOHO_CLIENT_SECRET=your_zoho_client_secret
```

### 4️⃣ Налаштування бази даних
Вкажіть параметри підключення у `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Створіть таблиці:
```bash
php artisan migrate
```

### 5️⃣ Отримання Zoho `refresh_token`
Отримайте код авторизації в Zoho, а потім виконайте команду:
```bash
curl -X POST https://accounts.zoho.com/oauth/v2/token \
     -d "client_id=YOUR_ZOHO_CLIENT_ID" \
     -d "client_secret=YOUR_ZOHO_CLIENT_SECRET" \
     -d "code=YOUR_AUTHORIZATION_CODE" \
     -d "grant_type=authorization_code"
```
Скопіюйте `refresh_token` та збережіть у базі:
```bash
php artisan tinker
>>> \App\Models\ZohoToken::create(['access_token' => '', 'refresh_token' => 'YOUR_REFRESH_TOKEN', 'expires_at' => now()]);
```

### 6️⃣ Запуск сервера
```bash
php artisan serve
npm run dev
```

---

## 🛠 Функціонал
- **Форма введення** (Vue.js) для створення угод та акаунтів у Zoho CRM
- **Обробка API-запитів** (Laravel) для взаємодії з Zoho
- **Збереження та оновлення токенів** у базі
- **Автоматичне оновлення токенів** через Artisan команду

### Використання форми
Відкрийте браузер і перейдіть за посиланням:
```text
http://127.0.0.1:8000
```

---

## 🔄 Оновлення токенів
Щоб оновити `access_token`, виконайте команду:
```bash
php artisan zoho:refresh-token
```
Щоб автоматизувати оновлення, додайте до `crontab`:
```bash
* * * * * php /path/to/your/project/artisan schedule:run >> /dev/null 2>&1
```

---

## 📌 API Маршрути

| Метод | URL | Опис |
|--------|--------------------------------|--------------------------|
| `POST` | `/api/zoho/create` | Створення угоди та акаунта |

Приклад запиту:
```json
{
  "dealName": "Test Deal",
  "dealStage": "Qualification",
  "accountName": "Test Account",
  "accountWebsite": "https://test.com",
  "accountPhone": "+1234567890"
}
```

---

## 🏁 Готово!
Тепер ви можете використовувати додаток для взаємодії з Zoho CRM. 🎉

