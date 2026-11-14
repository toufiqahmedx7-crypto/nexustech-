import { AnimatePresence, motion, useScroll, useTransform } from 'framer-motion';
import { useEffect, useState } from 'react';
import { Link, NavLink, useLocation } from 'react-router-dom';
import { useCart } from '../context/CartContext.jsx';

const links = [
  { to: '/', label: 'Home' },
  { to: '/featured', label: 'Featured' },
  { to: '/products', label: 'Products' },
  { to: '/trust', label: 'Why Us' },
];

export default function Navbar() {
  const { count, openCart } = useCart();
  const [scrolled, setScrolled] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);
  const [bump, setBump] = useState(false);
  const location = useLocation();
  const { scrollY } = useScroll();
  const bg = useTransform(scrollY, [0, 60], ['rgba(10, 12, 18, 0.35)', 'rgba(10, 12, 18, 0.88)']);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 24);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
    return () => window.removeEventListener('scroll', onScroll);
  }, []);

  useEffect(() => setMenuOpen(false), [location.pathname]);

  useEffect(() => {
    if (count === 0) return;
    setBump(true);
    const t = setTimeout(() => setBump(false), 350);
    return () => clearTimeout(t);
  }, [count]);

  return (
    <motion.header
      className={`navbar ${scrolled ? 'is-scrolled' : ''}`}
      style={{ background: bg }}
      initial={{ y: -80, opacity: 0 }}
      animate={{ y: 0, opacity: 1 }}
      transition={{ duration: 0.6, ease: [0.22, 1, 0.36, 1] }}
    >
      <div className="navbar-inner container">
        <Link to="/" className="brand" aria-label="NexusTech home">
          <motion.span
            className="brand-mark"
            whileHover={{ rotate: 90, scale: 1.1 }}
            transition={{ type: 'spring', stiffness: 300, damping: 15 }}
          >
            <svg viewBox="0 0 32 32" width="26" height="26" aria-hidden="true">
              <defs>
                <linearGradient id="brand-g" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0%" stopColor="#38bdf8" />
                  <stop offset="100%" stopColor="#2563eb" />
                </linearGradient>
              </defs>
              <rect x="2" y="2" width="28" height="28" rx="8" fill="none" stroke="url(#brand-g)" strokeWidth="2.5" />
              <path d="M10 22V10l12 12V10" fill="none" stroke="url(#brand-g)" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </motion.span>
          <span className="brand-name">
            Nexus<span>Tech</span>
          </span>
        </Link>

        <nav className="nav-links" aria-label="Primary">
          {links.map((l) => (
            <NavLink key={l.to} to={l.to} end={l.to === '/'} className={({ isActive }) => `nav-link ${isActive ? 'active' : ''}`}>
              <motion.span whileHover={{ y: -2 }} transition={{ type: 'spring', stiffness: 400, damping: 20 }}>
                {l.label}
              </motion.span>
            </NavLink>
          ))}
        </nav>

        <div className="nav-actions">
          <motion.button
            className="cart-button"
            onClick={openCart}
            whileHover={{ scale: 1.06 }}
            whileTap={{ scale: 0.92 }}
            aria-label={`Open cart, ${count} items`}
          >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
              <circle cx="9" cy="21" r="1" />
              <circle cx="20" cy="21" r="1" />
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
            </svg>
            <AnimatePresence>
              {count > 0 && (
                <motion.span
                  key="badge"
                  className={`cart-badge ${bump ? 'bump' : ''}`}
                  initial={{ scale: 0, opacity: 0 }}
                  animate={{ scale: bump ? 1.35 : 1, opacity: 1 }}
                  exit={{ scale: 0, opacity: 0 }}
                  transition={{ type: 'spring', stiffness: 500, damping: 18 }}
                >
                  {count}
                </motion.span>
              )}
            </AnimatePresence>
          </motion.button>

          <motion.button
            className={`hamburger ${menuOpen ? 'open' : ''}`}
            onClick={() => setMenuOpen((o) => !o)}
            whileTap={{ scale: 0.9 }}
            aria-label="Toggle menu"
            aria-expanded={menuOpen}
          >
            <span />
            <span />
            <span />
          </motion.button>
        </div>
      </div>

      <AnimatePresence>
        {menuOpen && (
          <motion.nav
            className="mobile-menu"
            initial={{ height: 0, opacity: 0 }}
            animate={{ height: 'auto', opacity: 1 }}
            exit={{ height: 0, opacity: 0 }}
            transition={{ duration: 0.32, ease: [0.22, 1, 0.36, 1] }}
            aria-label="Mobile"
          >
            {links.map((l, i) => (
              <motion.div
                key={l.to}
                initial={{ opacity: 0, x: -16 }}
                animate={{ opacity: 1, x: 0 }}
                transition={{ delay: 0.06 * i, duration: 0.28 }}
              >
                <NavLink to={l.to} end={l.to === '/'} className={({ isActive }) => `mobile-link ${isActive ? 'active' : ''}`}>
                  {l.label}
                </NavLink>
              </motion.div>
            ))}
          </motion.nav>
        )}
      </AnimatePresence>
    </motion.header>
  );
}
