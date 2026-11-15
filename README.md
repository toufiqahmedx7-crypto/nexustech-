# NexusTech

Premium electronics eCommerce store — dark theme, glassmorphism, glowing blue accents.
Two full versions live in this repo:

| Version | Stack | Where |
|---|---|---|
| **React app** | React 18 + Vite + Framer Motion | `src/` — deployed to **GitHub Pages** via `.github/workflows/deploy.yml` (site: `https://toufiqahmedx7-crypto.github.io/nexustech-/`) |
| **PHP + MySQL app** | Plain PHP 8 + MySQL, no Node.js | `php-version/` — runs on XAMPP, includes **admin panel + order system** |

## React version (live on GitHub Pages)

```bash
npm install
npm run dev      # http://localhost:5173
npm run build    # output in dist/, copied to docs/ for GitHub Pages
```

Pages: Home (hero slider), Featured, Products (filters + search), Product Detail, Trust, plus a working cart with slide-out mini-cart.

## PHP + MySQL version (admin panel included)

1. Copy `php-version/` into XAMPP's `htdocs` as `nexustech`
2. Start Apache + MySQL, open `http://localhost/nexustech/setup.php` (one-click installer)
3. Store: `http://localhost/nexustech/index.php`
4. Admin panel: `http://localhost/nexustech/admin/login.php` — default login `admin` / `admin123` (change in `php-version/config.php`)

Features: full storefront, session cart with JSON API, checkout that creates real orders in MySQL and reduces stock, and an admin dashboard with product/category management and an order status pipeline. Full details in [`php-version/README.md`](php-version/README.md).
