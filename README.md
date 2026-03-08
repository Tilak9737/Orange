# 🍊 Orange E-Commerce

Orange is a modern, full-featured e-commerce platform designed to provide a seamless shopping experience. From smooth, engaging UI animations to robust backend inventory and cart management, Orange is built to handle the end-to-end flow of digital retail.

---

## 📸 Application Previews

*Note: The application features a dynamic custom cursor and continuous micro-animations that are best experienced live.*

### Home Page
![Home Page](screenshots/1_home.png)

### Shop Page
![Shop Page](screenshots/2_shop.png)

### Cart
![Cart](screenshots/3_cart.png)

### Contact
![Contact](screenshots/4_contact.png)

### Login
![Login](screenshots/5_login.png)

---

## ⚡ How It Works

**The shopping experience is designed to be frictionless:**
1. **Browsing & Discovery**: Users are greeted with an immersive landing page and can navigate to the Shop to browse products. All products are categorized, and their stock levels are tracked in real-time.
2. **Guest Cart System**: Users do not need to create an account to start shopping. Items added to the cart are stored using an intelligent session/cookie-based guest cart system.
3. **Authentication & Merging**: When a user decides to register or log in, their existing guest cart is automatically and seamlessly merged with their persistent database cart.
4. **Checkout Flow**: Users proceed to a secure checkout where they can apply promotional coupons (with real-time validation for limits and expiration dates) and finalize their orders.
5. **Order Management**: Users can track their past orders and order statuses.
6. **Administrator Control**: Admins have access to a secure dashboard to manage the entire store—including creating/editing products, managing categories, tracking overall stock, defining coupon codes, and processing user orders.

---

## ✨ Full Feature List

### 🛒 Customer Experience
- **Guest Checkout Support**: Shop without logging in; carts are preserved.
- **Intelligent Cart Merging**: Guest carts are automatically merged into user accounts upon login.
- **Dynamic Cart Calculations**: Real-time total calculation including tax and discounts.
- **Coupon System**: Support for discount codes with complex validation (usage limits, minimum cart values, expiration dates).
- **Order Tracking**: Detailed order history and status tracking.
- **Wishlist**: Save favorite products for later (database-backed for users).
- **Responsive Design**: Flawless experience across mobile, tablet, and desktop devices.
- **Premium UI/UX**: Custom cursor, smooth scroll triggers, and glassmorphism elements.

### 🛡️ Administrator Dashboard
- **Product Management**: Full CRUD (Create, Read, Update, Delete) operations for products.
- **Inventory Tracking**: Stock level management and out-of-stock prevention.
- **Category Control**: Organize products into dynamic categories.
- **Coupon Engine**: Generate and manage promotional codes with specific rules.
- **Order Fulfillment**: View, manage, and update customer order statuses.
- **Role-Based Access Control**: Secure routes ensuring only admins can access store management tools.

---

## 🛠️ Technology Stack

Orange is built on a modern, robust, and scalable stack, utilizing best-in-class tools for both frontend aesthetics and backend reliability.

### Major Technologies
- **[Laravel 12.x](https://laravel.com/)**: The core PHP framework powering the backend API, routing, authentication, and business logic.
- **[PostgreSQL](https://www.postgresql.org/)**: The primary relational database used for robust data integrity.
- **[Neon](https://neon.tech/)**: Serverless, true-cloud PostgreSQL providing connection pooling and scalable database hosting.
- **[Tailwind CSS 3.x](https://tailwindcss.com/)**: Utility-first CSS framework used for rapid, custom, and responsive UI styling.

### Minor / Supporting Technologies & Libraries
- **[Alpine.js](https://alpinejs.dev/)**: Lightweight JavaScript framework for declarative, reactive frontend behaviors (dropdowns, modals, toggles).
- **[GSAP (GreenSock)](https://gsap.com/)**: Industry-standard JavaScript animation library used for complex, timeline-based UI animations.
- **[AOS (Animate On Scroll)](https://michalsnik.github.io/aos/)**: Lightweight library for triggering scroll-based reveal animations.
- **[Remix Icon](https://remixicon.com/)**: Comprehensive open-source icon library used throughout the UI.
- **[Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)**: Minimal and simple authentication scaffolding.
- **[Puppeteer (Core)](https://pptr.dev/)**: Used internally for automated full-page application screenshot generation.

### Architecture & Patterns
- **Service Pattern**: Business logic (like Cart Merging and Coupon Validation) is extracted into dedicated Service classes (e.g., `CartService`, `CouponService`) to keep Controllers thin.
- **Dynamic Port Binding**: Built-in shell scripts to dynamically allocate Apache listening ports based on deployment environments.
- **Session/Cookie State Management**: Used heavily for preserving guest states seamlessly before authentication.
- **HTTPS Enforcement**: Middleware and Service Provider configurations to ensure strict secure protocol usage across load balancers/proxies.

---
*Built with ❤️ utilizing the power of Laravel and modern frontend tools.*
