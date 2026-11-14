import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import Reveal from '../components/Reveal.jsx';
import { TRUST_ITEMS } from '../data/products.js';

const slogans = [
  'Tech you can trust.',
  'Premium gear. Zero compromise.',
  'Built for people who notice the details.',
];

const tags = ['#NexusTech', '#PremiumGear', '#FreeReturns', '#2YearWarranty', '#FastShipping'];

export default function Trust() {
  return (
    <div className="page">
      <section className="section page-head">
        <div className="container">
          <Reveal>
            <span className="section-eyebrow">Page 05 — Why NexusTech</span>
            <h1>Shop with total confidence</h1>
            <p>
              A great product is only half the story. Here is everything we promise
              before, during and after every single order.
            </p>
          </Reveal>
        </div>
      </section>

      <section className="section tight">
        <div className="container">
          <Reveal>
            <div className="slogan-band glass">
              {slogans.map((s, i) => (
                <motion.span
                  key={s}
                  initial={{ opacity: 0, y: 14 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  viewport={{ once: true }}
                  transition={{ delay: i * 0.12, duration: 0.5 }}
                >
                  {s}
                </motion.span>
              ))}
            </div>
          </Reveal>
        </div>
      </section>

      <section className="section tight">
        <div className="container">
          <div className="trust-box glass">
            <div className="trust-box-head">
              <h2>Our service promises</h2>
              <p>Standard on every order — not an upgrade, not an extra fee.</p>
            </div>
            <div className="trust-cards">
              {TRUST_ITEMS.map((t, i) => (
                <motion.div
                  key={t.title}
                  className="trust-card"
                  initial={{ opacity: 0, y: 28, scale: 0.97 }}
                  whileInView={{ opacity: 1, y: 0, scale: 1 }}
                  viewport={{ once: true, margin: '-40px' }}
                  transition={{ delay: (i % 3) * 0.08, duration: 0.5, ease: [0.22, 1, 0.36, 1] }}
                  whileHover={{ y: -6 }}
                >
                  <motion.span
                    className="trust-icon"
                    whileHover={{ rotate: [0, -8, 8, 0], scale: 1.15 }}
                    transition={{ duration: 0.45 }}
                    aria-hidden="true"
                  >
                    {t.icon}
                  </motion.span>
                  <h3>{t.title}</h3>
                  <p>{t.tagline}</p>
                </motion.div>
              ))}
            </div>
            <div className="trust-tags">
              {tags.map((t, i) => (
                <motion.span
                  key={t}
                  className="chip static"
                  initial={{ opacity: 0, scale: 0.8 }}
                  whileInView={{ opacity: 1, scale: 1 }}
                  viewport={{ once: true }}
                  transition={{ delay: i * 0.06, type: 'spring', stiffness: 300, damping: 18 }}
                  whileHover={{ scale: 1.08 }}
                >
                  {t}
                </motion.span>
              ))}
            </div>
          </div>
        </div>
      </section>

      <section className="section">
        <div className="container center-cta">
          <Reveal>
            <h2 className="cta-title">Ready when you are.</h2>
            <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
              <Link to="/products" className="btn btn-primary btn-lg">
                Start shopping
              </Link>
            </motion.div>
          </Reveal>
        </div>
      </section>
    </div>
  );
}
