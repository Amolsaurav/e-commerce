# 🛍️ Simple E-Commerce Website

This is a PHP + MySQL-based e-commerce platform featuring user and admin dashboards, dynamic category and product displays, cart management, and image handling via URL or file upload.

---

## 📁 Features

### 👤 User Features
- Register and log in as a user.
- Browse product categories in a grid layout.
- View all products under each category.
- Click to view full product description and pricing.
- Add products to the cart.
- View cart contents and proceed to checkout (no payment gateway).
- See discounted prices with strikethrough on original prices.

### 🛠️ Admin Features
- Secure login as admin (`Admin/Admin@123` by default).
- Add/View/Delete product categories with image (via upload or URL).
- Add/View/Delete products with name, description, old price, discounted price, and image.
- Unified delete handler for both products and categories.
- Separate clean interface from user dashboard.

---

## 🧰 Technologies Used

- **Frontend**: HTML, CSS, Bootstrap (optional), Font Awesome
- **Backend**: PHP (Core PHP, no frameworks)
- **Database**: MySQL
- **Image Handling**: `VARCHAR(255)` storing either uploaded file path or direct URL

---

## 🗃️ Database Structure

### 📦 `categories`
| Column      | Type         | Description                |
|-------------|--------------|----------------------------|
| id          | int(11)      | Primary Key, Auto Increment |
| name        | varchar(255) | Category name              |
| image       | varchar(255) | URL or path to image       |

### 🛒 `products`
| Column           | Type         | Description                      |
|------------------|--------------|----------------------------------|
| id               | int(11)      | Primary Key, Auto Increment      |
| name             | varchar(255) | Product name                     |
| description      | text         | Product details                  |
| old_price        | varchar(255) | Original price                   |
| discounted_price | varchar(255) | Discounted price (shown in bold) |
| price            | varchar(255) | Final price (if applicable)      |
| image            | varchar(255) | URL or file path                 |
| category_id      | int(11)      | Foreign Key → categories.id      |

---

## 🚀 Getting Started

### ✅ Prerequisites
- PHP (v7.x or v8.x)
- MySQL or MariaDB
- Apache (e.g., XAMPP/LAMP/WAMP)

### ⚙️ Setup Instructions

1. Clone or download this repository.
2. Import `database.sql` file into your MySQL server.
3. Update `config.php` with your DB credentials:
   ```php
   $conn = mysqli_connect("localhost", "root", "", "your_db_name");
