# Full Stack C2C Ecommerce Platform

A complete consumer-to-consumer (C2C) ecommerce platform built with modern web technologies. This application enables peer-to-peer transactions with a full-featured marketplace experience.

## 🌟 Features

- **User Authentication & Registration** - Secure user account management
- **Product Listings** - Browse and search products from multiple sellers
- **Shopping Cart & Checkout** - Complete purchase workflow
- **User Profiles** - Buyer and seller profile management
- **Transaction Management** - Track orders and transactions
- **Responsive Design** - Works seamlessly across all devices

## 🛠️ Technology Stack

- **Backend**: PHP
- **Frontend**: 
  - HTML5
  - CSS3 (Vanilla)
  - JavaScript (Vanilla)
- **Database**: MySQL (inferred from typical PHP stack)

## 📋 Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Composer (for dependency management, optional)

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Miles-7/Full-Stack-C-2-C-Ecommerce-Platform-.git
   cd Full-Stack-C-2-C-Ecommerce-Platform-
   ```

2. **Set up the database**
   ```bash
   # Create the database and import schema
   mysql -u root -p < database/schema.sql
   ```

3. **Configure the application**
   - Copy configuration template (if provided)
   - Update database credentials in configuration file
   - Set appropriate file permissions for uploads

4. **Start the server**
   ```bash
   php -S localhost:8000
   # or use your web server (Apache/Nginx)
   ```

5. **Access the application**
   - Open your browser and navigate to: `https://vuka.42web.io/public/pages/register.php`
   - Or locally: `http://localhost:8000`

## 📁 Project Structure

```
├── public/          # Publicly accessible files
│   └── pages/       # HTML pages
├── src/             # Source code
├── config/          # Configuration files
├── database/        # Database schema and migrations
└── assets/          # CSS, JavaScript, images
```

## 🔐 Security

- Implement proper input validation and sanitization
- Use prepared statements to prevent SQL injection
- Hash passwords securely
- Implement CSRF protection
- Validate user permissions on all transactions

## 📝 Usage

### For Buyers
1. Register an account
2. Browse products
3. Add items to cart
4. Proceed to checkout
5. Complete payment
6. Track your orders

### For Sellers
1. Create a seller account
2. List your products
3. Manage inventory
4. Process orders
5. Handle returns and refunds

## 🐛 Known Issues

Currently no open issues. If you encounter any bugs, please open an issue on GitHub.

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is currently unlicensed. Please add a LICENSE file if you plan to distribute it.

## 🔗 Live Demo

Visit the live application: [https://vuka.42web.io/public/pages/register.php](https://vuka.42web.io/public/pages/register.php)

---

**Topics**: Full Stack Development, HTML/CSS/JavaScript, PHP
