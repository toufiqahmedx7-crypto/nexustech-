import { AnimatePresence, motion } from 'framer-motion';
import { useCallback, useEffect, useRef, useState } from 'react';
import { Link } from 'react-router-dom';
import ProductCard from '../components/ProductCard.jsx';
import Reveal from '../components/Reveal.jsx';
import { CATEGORIES, FEATURED, HERO_SLIDES, TRUST_ITEMS } from '../data/products.js';

const AUTOPLAY_MS = 6000;

function HeroSlider() {
  const [[index, direction], setState] = useState([0, 0]);
  const timer = useRef(null);

  const go = useCallback(
    (dir) => {
      setState(([i]) => [(i + dir + HERO_SLIDES.length) % HERO_SLIDES.length, dir]);
    },
    []
  );

  useEffect(() => {
    timer.current = setInterval(() => go(1), AUTOPLAY_MS);
    return () => clearInterval(timer.current);
  }, [go, index]);

  const slide = HERO_SLIDES[index];

  return (
    <section className="hero" aria-label="Featured promotions">
      <div className="hero-viewport">
        <AnimatePresence mode="popLayout" custom={direction}>
          <motion.div
            key={slide.id}
            className="hero-slide"
            custom={direction}
            initial={{ opacity: 0, x: direction >= 0 ? 120 : -120, scale: 1.04 }}
            animate={{ opacity: 1, x: 0, scale: 1 }}
            exit={{ opacity: 0, x: direction >= 0 ? -120 : 120, scale: 0.98 }}
            transition={{ duration: 0.65, ease: [0.22, 1, 0.36, 1] }}
          >
            <div className="hero-media">
              <motion.img
                src={slide.image}
                alt={slide.title}
                initial={{ scale: 1.12 }}
                animate={{ scale: 1 }}
                transition={{ duration: 6, ease: 'easeOut' }}
              />
              <div className="hero-scrim" />
            </div>

            <div className="container hero-content">
              <motion.span
                className="hero-eyebrow"
                initial={{ opacity: 0, y: 24 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.15, duration: 0.5 }}
              >
                {slide.eyebrow}
              </motion.span>
              <motion.h1
                initial={{ opacity: 0, y: 32 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.25, duration: 0.55, ease: [0.22, 1, 0.36, 1] }}
              >
                {slide.title}
              </motion.h1>
              <motion.p
                initial={{ opacity: 0, y: 32 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.35, duration: 0.55, ease: [0.22, 1, 0.36, 1] }}
              >
                {slide.subtitle}
              </motion.p>
              <motion.div
                className="hero-cta"
                initial={{ opacity: 0, y: 32 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.45, duration: 0.55, ease: [0.22, 1, 0.36, 1] }}
              >
                <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
                  <Link to={slide.link} className="btn btn-primary btn-lg">
                    Shop Now
                  </Link>
                </motion.div>
                <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
                  <Link to="/products" className="btn btn-ghost btn-lg">
                    Explore catalog
                  </Link>
                </motion.div>
                <span className="hero-price">{slide.price}</span>
              </motion.div>
            </div>
          </motion.div>
        </AnimatePresence>

        <motion.button
          className="hero-arrow prev"
          onClick={() => go(-1)}
          whileHover={{ scale: 1.12, backgroundColor: 'rgba(56, 189, 248, 0.25)' }}
          whileTap={{ scale: 0.9 }}
          aria-label="Previous slide"
        >
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
            <path d="M15 18l-6-6 6-6" />
          </svg>
        </motion.button>
        <motion.button
          className="hero-arrow next"
          onClick={() => go(1)}
          whileHover={{ scale: 1.12, backgroundColor: 'rgba(56, 189, 248, 0.25)' }}
          whileTap={{ scale: 0.9 }}
          aria-label="Next slide"
        >
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
            <path d="M9 18l6-6-6-6" />
          </svg>
        </motion.button>

        <div className="hero-dots" role="tablist" aria-label="Slides">
          {HERO_SLIDES.map((s, i) => (
            <motion.button
              key={s.id}
              className={`hero-dot ${i === index ? 'active' : ''}`}
              onClick={() => setState([i, i > index ? 1 : -1])}
              whileHover={{ scale: 1.3 }}
              whileTap={{ scale: 0.85 }}
              aria-label={`Go to slide ${i + 1}`}
              aria-selected={i === index}
              role="tab"
            />
          ))}
        </div>
      </div>
    </section>
  );
}

export default function Home() {
  return (
    <>
      <HeroSlider />

      <section className="section trust-strip">
        <div className="container trust-grid">
          {TRUST_ITEMS.slice(0, 5).map((t, i) => (
            <Reveal key={t.title} delay={i * 0.06} className="trust-chip glass">
              <span className="trust-chip-icon" aria-hidden="true">{t.icon}</span>
              <div>
                <strong>{t.title}</strong>
                <span>{t.tagline}</span>
              </div>
            </Reveal>
          ))}
        </div>
      </section>

      <section className="section">
        <div className="container">
          <Reveal className="section-head">
            <span className="section-eyebrow">Shop by category</span>
            <h2>Find your next device</h2>
            <p>Six curated categories, one obsessive standard of quality.</p>
          </Reveal>
          <div className="category-grid">
            {CATEGORIES.map((c, i) => (
              <Reveal key={c.id} delay={i * 0.05}>
                <motion.div whileHover={{ y: -6, scale: 1.02 }} whileTap={{ scale: 0.97 }}>
                  <Link to={`/products?category=${c.id}`} className="category-card glass">
                    <span className="category-icon" aria-hidden="true">{c.icon}</span>
                    <h3>{c.label}</h3>
                    <p>{c.tagline}</p>
                    <span className="category-arrow" aria-hidden="true">→</span>
                  </Link>
                </motion.div>
              </Reveal>
            ))}
          </div>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <Reveal className="section-head">
            <span className="section-eyebrow">Trending now</span>
            <h2>This week's hottest gear</h2>
            <p>Hand-picked by our team, loved by thousands of customers.</p>
          </Reveal>
          <div className="product-grid">
            {FEATURED.slice(0, 4).map((p, i) => (
              <ProductCard key={p.id} product={p} index={i} />
            ))}
          </div>
          <Reveal className="center-cta">
            <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
              <Link to="/featured" className="btn btn-ghost btn-lg">
                View all featured
              </Link>
            </motion.div>
          </Reveal>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <Reveal>
            <div className="promo-banner glass">
              <div>
                <span className="section-eyebrow">Limited time</span>
                <h2>Up to 25% off audio &amp; wearables</h2>
                <p>Deals refresh every Monday. Members get first access.</p>
              </div>
              <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
                <Link to="/products" className="btn btn-primary btn-lg">
                  Grab the deals
                </Link>
              </motion.div>
            </div>
          </Reveal>
        </div>
      </section>
    </>
  );
}
