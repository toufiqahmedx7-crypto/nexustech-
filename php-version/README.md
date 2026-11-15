# NexusTech — PHP + MySQL Version

The same premium dark-themed electronics store as the React app, rebuilt with **plain PHP 8 + MySQL** — no Node.js, no npm. Just copy it into XAMPP and open in your browser.

## Quick Start (XAMPP)

1. **Install XAMPP** (includes Apache, PHP, MySQL/MariaDB): https://www.apachefriends.org
2. **Copy this folder** into your XAMPP web root:
   - Windows: `C:\xampp\htdocs\` — rename the copied folder to `nexustech`
   - macOS: `/Applications/XAMPP/htdocs/`
   - Linux: `/opt/lampp/htdocs/`
3. **Start Apache and MySQL** in the XAMPP Control Panel.
4. **Run the installer** — open in your browser:
   ```
   http://localhost/nexustech/setup.php
   ```
   This creates the `nexustech` database, both tables, and seeds 24 products + 6 categories automatically.
5. **Open the store**:
   ```
   http://localhost/nexustech/index.php
   ```

> The app connects to MySQL with XAMPP defaults: host `127.0.0.1`, user `root`, empty password. Change these at the top of `config.php` if yours differ.

## Manual Database Setup (alternative)

If you prefer importing by hand, open phpMyAdmin (`http://localhost/phpmyadmin`), create a database named `nexustech`, then import `database.sql`. It contains the schema and all seed data.

## Pages

| Page | URL | What's on it |
|---|---|---|
| Home | `index.php` | Full-width hero slider (arrows, crossfade + slide), trust strip, category cards, trending products, promo banner |
| Featured | `featured.php` | Spotlight card, category filter chips, 4 premium products per category |
| Products | `products.php` | Full catalog grouped by category, working filters + live search |
| Product Detail | `product.php?slug=...` | Image gallery with thumbnails, specs, stock status, color swatches, quantity selector, Add to Cart, 4 recommendations |
| Trust | `trust.php` | Slogans, service promises with icons, tags |
| Checkout | `checkout.php` | Delivery form + order summary, turns the cart into a real order |

The shopping cart lives in the PHP session. Add/update/remove through the slide-out mini-cart, which talks to `cart-api.php` (JSON endpoints) with `fetch` — no page reloads.

## Admin Panel

Open:

```
http://localhost/nexustech/admin/login.php
```

Default credentials (change them at the top of the **Admin auth** section in `config.php`):

- Username: `admin`
- Password: `admin123`

What you can do:

| Section | What it does |
|---|---|
| Dashboard | Product / category / order counts, revenue, recent orders, low-stock alerts |
| Products | Full list with search-free table, add / edit / delete (images, specs, colors, stock, badge, price) |
| Categories | Add / delete categories (delete is blocked while products use them) |
| Orders | Every checkout order with customer info, items and a status pipeline: pending → paid → shipped → delivered / cancelled |

Orders placed from the store's checkout page appear here instantly, and product stock is reduced automatically.

> If you already ran `setup.php` before the admin panel existed, just open `setup.php` again — it will create the two new order tables without touching your data.

## Structure

```
php-version/
├── config.php          DB connection (PDO), cart + product helpers, card renderer
├── setup.php           One-click installer: creates DB, tables, seeds data
├── seed-data.php       24 products, 6 categories, image URL helpers
├── database.sql        Manual import alternative
├── index.php           Home / hero slider
├── featured.php        Featured products + filter chips
├── products.php        Catalog + search
├── product.php         Product detail
├── trust.php           Trust / promises page
├── cart-api.php        JSON cart API (add/update/remove/clear/list)
├── checkout.php        Delivery form, creates the order + reduces stock
├── admin/
│   ├── login.php       Admin login (default admin / admin123)
│   ├── logout.php
│   ├── auth.php        Session gate for every admin page
│   ├── index.php       Dashboard: stats, recent orders, low stock
│   ├── products.php    Product table + delete
│   ├── product-form.php Add / edit product (all fields incl. specs & images)
│   ├── categories.php  Category list + add / delete
│   ├── orders.php      Order list + status pipeline
│   ├── order-view.php  Single order detail + status update
│   ├── includes/       Admin layout (sidebar, topbar)
│   └── assets/admin.css Admin design system
├── includes/
│   ├── header.php      <head>, glow frame, navbar, hamburger menu
│   └── footer.php      Footer, newsletter, cart drawer markup
└── assets/
    ├── css/style.css   Full design system (dark theme, glassmorphism, animations)
    ├── js/main.js      Slider, filters, gallery, cart drawer, micro-interactions
    └── img/favicon.svg
```

## Notes

- All queries use PDO prepared statements; all output is escaped with `htmlspecialchars` via the `e()` helper.
- Animations are pure CSS + a small vanilla JS file (IntersectionObserver reveals, hero crossfade, cart drawer slide, gallery fades) — no frameworks.
- Product images load from Unsplash, so an internet connection is needed for images to appear.
