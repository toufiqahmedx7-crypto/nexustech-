import { motion } from 'framer-motion';
import { useState } from 'react';
import { Link } from 'react-router-dom';
import { CATEGORIES } from '../data/products.js';

const shopLinks = ['All Products', 'Featured', 'New Arrivals', 'Best Sellers', 'Deals'];
const supportLinks = ['Help Center', 'Track Order', 'Shipping Info', 'Returns', 'Warranty'];
const aboutLinks = ['Our Story', 'Careers', 'Press', 'Sustainability', 'Affiliates'];

const socials = [
  {
    label: 'X',
    path: 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z',
  },
  { label: 'Instagram', path: 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6 6 0 1 0 0 12 6 6 0 0 0 0-12zm0 9.895a3.895 3.895 0 1 1 0-7.79 3.895 3.895 0 0 1 0 7.79zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z' },
  { label: 'YouTube', path: 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z' },
  { label: 'LinkedIn', path: 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 1 1 0-4.125 2.062 2.062 0 0 1 0 4.125zM7.119 20.452H3.554V9h3.565v11.452z' },
];

const payments = ['Visa', 'Mastercard', 'Amex', 'PayPal', 'Apple Pay', 'G Pay'];

export default function Footer() {
  const [email, setEmail] = useState('');
  const [subscribed, setSubscribed] = useState(false);

  const submit = (e) => {
    e.preventDefault();
    if (!email.trim()) return;
    setSubscribed(true);
    setEmail('');
    setTimeout(() => setSubscribed(false), 3200);
  };

  return (
    <footer className="footer">
      <div className="footer-glow" aria-hidden="true" />
      <div className="container">
        <div className="footer-grid">
          <div className="footer-brand-col">
            <Link to="/" className="brand">
              <span className="brand-mark small">
                <svg viewBox="0 0 32 32" width="22" height="22" aria-hidden="true">
                  <rect x="2" y="2" width="28" height="28" rx="8" fill="none" stroke="#38bdf8" strokeWidth="2.5" />
                  <path d="M10 22V10l12 12V10" fill="none" stroke="#38bdf8" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" />
                </svg>
              </span>
              <span className="brand-name">
                Nexus<span>Tech</span>
              </span>
            </Link>
            <p className="footer-tagline">
              Premium electronics and gadgets, curated for people who care about the details.
            </p>
            <div className="socials">
              {socials.map((s) => (
                <motion.a
                  key={s.label}
                  href="#"
                  onClick={(e) => e.preventDefault()}
                  aria-label={s.label}
                  whileHover={{ y: -3, scale: 1.1 }}
                  whileTap={{ scale: 0.92 }}
                >
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d={s.path} />
                  </svg>
                </motion.a>
              ))}
            </div>
          </div>

          <div className="footer-col">
            <h4>Shop</h4>
            <ul>
              {shopLinks.map((l) => (
                <li key={l}>
                  <Link to={l === 'Featured' ? '/featured' : '/products'}>{l}</Link>
                </li>
              ))}
            </ul>
          </div>

          <div className="footer-col">
            <h4>Categories</h4>
            <ul>
              {CATEGORIES.map((c) => (
                <li key={c.id}>
                  <Link to={`/products?category=${c.id}`}>{c.label}</Link>
                </li>
              ))}
            </ul>
          </div>

          <div className="footer-col">
            <h4>Support</h4>
            <ul>
              {supportLinks.map((l) => (
                <li key={l}>
                  <Link to="/trust">{l}</Link>
                </li>
              ))}
            </ul>
          </div>

          <div className="footer-col">
            <h4>About</h4>
            <ul>
              {aboutLinks.map((l) => (
                <li key={l}>
                  <Link to="/trust">{l}</Link>
                </li>
              ))}
            </ul>
          </div>

          <div className="footer-col footer-news">
            <h4>Stay in the loop</h4>
            <p>Early drops, exclusive deals. No spam, ever.</p>
            <form className="newsletter" onSubmit={submit}>
              <input
                type="email"
                placeholder="you@email.com"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                aria-label="Email address"
                required
              />
              <motion.button className="btn btn-primary" whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.92 }} type="submit">
                {subscribed ? '✓ Joined' : 'Join'}
              </motion.button>
            </form>
            <div className="payments" aria-label="Accepted payment methods">
              {payments.map((p) => (
                <motion.span key={p} whileHover={{ y: -2 }}>
                  {p}
                </motion.span>
              ))}
            </div>
          </div>
        </div>

        <div className="footer-bottom">
          <span>© {new Date().getFullYear()} NexusTech. All rights reserved.</span>
          <div className="footer-legal">
            <Link to="/trust">Privacy</Link>
            <Link to="/trust">Terms</Link>
            <Link to="/trust">Cookies</Link>
          </div>
        </div>
      </div>
    </footer>
  );
}
