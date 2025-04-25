
# Lost and Found Web Application

![image](https://github.com/user-attachments/assets/3c8259f4-62ad-47b2-b34c-046632bb8e5f)
![image](https://github.com/user-attachments/assets/5a1ab73c-c6a5-4ca6-91ff-7300e6a508f0)



## 📌 Project Overview

This is a **Lost and Found Web Application** developed using Laravel and Tailwind CSS as part of the **MVC Programming course** at **Lovely Professional University**, under the guidance of **Professor Kuldeep Kushwaha Sir**.

The application helps users within an institution report and recover lost or found items through a secure, intelligent, and user-friendly platform.

---

## 🎯 Key Features

- 🔐 **Authentication System**
  - Secure user registration and login
  - Password reset via email
  - Session handling and authorization policies

- 🧭 **Dashboard**
  - Real-time stats: total lost, found, and matched items
  - Quick links to report or view items

- 📦 **Lost & Found Modules**
  - Item listing, advanced filtering, and search
  - Image upload and item tagging
  - Individual item view with full details

- 🤖 **Smart Matching Algorithm**
  - Matches lost and found items based on name, description, tags, and category
  - Automatically updates item status and notifies users

- 💡 **Responsive Design**
  - Built using **Tailwind CSS** for mobile-friendly UI
  - Clean, minimal, and accessible layout

---

## ⚙️ Tech Stack

- **Backend Framework:** Laravel (PHP)
- **Frontend Templating:** Blade
- **Styling:** Tailwind CSS
- **Database:** MySQL
- **Authentication:** Laravel Breeze (or custom Laravel auth)
- **Hosting (Optional):** Laravel Valet / XAMPP / PHP Server

---

## 📁 Folder Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── LostItemController.php
│   │   │   ├── FoundItemController.php
│   └── Models/
│       ├── User.php
│       ├── LostItem.php
│       └── FoundItem.php
├── resources/
│   ├── views/
│   │   ├── lost-items/
│   │   ├── found-items/
│   │   ├── auth/
│   │   ├── layouts/
│   │   └── dashboard.blade.php
├── routes/
│   └── web.php
```

---

## 🛠️ Installation & Setup

```bash
# 1. Clone the repository
git clone https://github.com/yourusername/lost-found-app.git
cd lost-found-app

# 2. Install dependencies
composer install
npm install && npm run dev

# 3. Setup .env file
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env, then run:
php artisan migrate

# 5. Run the application
php artisan serve
```

---

## 🔒 Security

- CSRF protection on all forms
- Middleware to restrict unauthorized access
- Data validation on all user inputs
- Authorization policies for user-specific access

---

## ✨ Future Improvements

- 🔔 Real-time notifications with Laravel Echo or WebSockets
- 📨 Email verification and item claim request workflow
- 📱 Progressive Web App (PWA) support
- 🧠 AI-based smart matching with NLP for item descriptions

---

## 🧑‍🎓 Author

**[Your Full Name]**  
Third-Year Student  
**Lovely Professional University**  
👨‍🏫 Under the guidance of **Prof. Kuldeep Kushwaha**

---

## 📃 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

```

---

Let me know:
- The **actual image links** or local paths you want to include at the top.
- Your **GitHub username** if you want the clone link personalized.
- Any custom badge or status (e.g., GitHub Actions, Laravel version, etc.).

I can also generate a polished PDF version of this if you'd like.
