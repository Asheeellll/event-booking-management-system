# Event Booking Management System

A Laravel-based Event Booking Management System developed as part of the **Grovit AI Mini Project Assignment**. The application allows users to submit event enquiries, generate AI-powered event plans, and enables administrators to manage enquiries through a clean dashboard.

---

## ✨ Features

### User Features
- Submit event enquiries
- AI-powered Event Planner
- Choose Silver, Gold, or Premium package
- Theme preference support
- Budget-aware event recommendations
- Responsive design

### Admin Features
- Secure admin login
- Dashboard with enquiry statistics
- View all enquiries
- Search enquiries
- Filter enquiries by status
- Update enquiry status

### AI Event Planner
The AI planner generates customized event plans based on:
- Event details
- Guest count
- Budget
- Selected package
- Theme preference

The generated plan includes:
- Event Theme
- Decoration
- Food & Drinks
- Entertainment
- Timeline
- Budget Allocation
- Additional Suggestions

The planner automatically adjusts recommendations based on the available budget and guest count.

---

# 🛠 Tech Stack

- Laravel 10
- PHP
- MySQL
- Bootstrap 5
- JavaScript
- Vite
- OpenRouter AI API

---

# 📂 Project Structure

```
app/
resources/
routes/
database/
public/
```

---

# ⚙ Installation

```bash
git clone https://github.com/YOUR_USERNAME/event-booking-management-system.git

cd event-booking-management-system

composer install

npm install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

npm run dev

php artisan serve
```

---

# 🔑 Admin Login

Email

```
admin@eventbook.in
```

Password

```
<your-admin-password>
```

---

# 🤖 AI Event Planner

The AI Event Planner uses the **OpenRouter API** to generate personalized event plans.

It considers:
- Theme preference
- Budget
- Budget per guest
- Selected package
- Guest count

This ensures recommendations remain practical and appropriate for the user's requirements.

---

# 📸 Screenshots

Add screenshots here after deployment.

- Home Page
- Event Enquiry Form
- AI Event Planner
- Admin Dashboard
- Enquiry Management

---

# 🚀 Future Improvements

- Email notifications
- PDF quotation generation
- Payment gateway integration
- Calendar integration
- Event analytics dashboard

---

# 👨‍💻 Author

**Asheel Bava Fakruddien**

GitHub: https://github.com/Asheeellll
LinkedIn: https://www.linkedin.com/in/asheel-bava-fakruddien-74823427b/

---

# 📄 License

This project was developed for educational and assessment purposes as part of the Grovit AI Mini Project.