import { motion } from 'framer-motion';
import { useMemo, useState } from 'react';
import { Link } from 'react-router-dom';
import ProductCard, { Rating } from '../components/ProductCard.jsx';
import Reveal from '../components/Reveal.jsx';
import { CATEGORIES, FEATURED, PRODUCTS, formatPrice, getByCategory } from '../data/products.js';
import { useCart } from '../context/CartContext.jsx';

function SpotlightCard({ product }) {
  const { addItem } = useCart();
  return (
    <motion.article
      className="spotlight glass"
      initial={{ opacity: 0, scale: 0.96 }}
      whileInView={{ opacity: 1, scale: 1 }}
      viewport={{ once: true, margin: '-60px' }}
      transition={{ duration: 0.6, ease: [0.22, 1, 0.36, 1] }}
    >
      <Link to={`/product/${product.slug}`} className="spotlight-media">
        <img src={product.images[0]} alt={product.name} loading="lazy" />
      </Link>
      <div className="spotlight-body">
        <span className="section-eyebrow">{product.badge || product.brand}</span>
        <h3>{product.name}</h3>
        <p>{product.short}</p>
        <Rating value={product.rating} reviews={product.reviews} />
        <div className="spotlight-foot">
          <div className="price-group">
            <span className="price">{formatPrice(product.price)}</span>
            {product.oldPrice && <span className="price-old">{formatPrice(product.oldPrice)}</span>}
          </div>
          <motion.button
            className="btn btn-primary"
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.92 }}
            onClick={() => addItem(product)}
          >
            Add to Cart
          </motion.button>
        </div>
      </div>
    </motion.article>
  );
}

export default function Featured() {
  const [active, setActive] = useState('all');

  const shown = useMemo(() => {
    if (active === 'all') return FEATURED;
    return getByCategory(active).slice(0, 4);
  }, [active]);

  const spotlight = useMemo(() => {
    if (active === 'all') return PRODUCTS.find((p) => p.slug === 'nova-x9-pro');
    return getByCategory(active)[0];
  }, [active]);

  return (
    <div className="page">
      <section className="section page-head">
        <div className="container">
          <Reveal>
            <span className="section-eyebrow">Page 02 — Featured</span>
            <h1>Featured products</h1>
            <p>The best of the best — flagship devices our team actually uses every day.</p>
          </Reveal>
        </div>
      </section>

      <section className="section tight">
        <div className="container">
          <Reveal>
            <div className="chip-row" role="tablist" aria-label="Filter featured by category">
              <motion.button
                className={`chip ${active === 'all' ? 'active' : ''}`}
                onClick={() => setActive('all')}
                whileHover={{ scale: 1.06 }}
                whileTap={{ scale: 0.92 }}
                role="tab"
                aria-selected={active === 'all'}
              >
                All
              </motion.button>
              {CATEGORIES.map((c) => (
                <motion.button
                  key={c.id}
                  className={`chip ${active === c.id ? 'active' : ''}`}
                  onClick={() => setActive(c.id)}
                  whileHover={{ scale: 1.06 }}
                  whileTap={{ scale: 0.92 }}
                  role="tab"
                  aria-selected={active === c.id}
                >
                  <span aria-hidden="true">{c.icon}</span> {c.label}
                </motion.button>
              ))}
            </div>
          </Reveal>
        </div>
      </section>

      <section className="section tight">
        <div className="container">
          <SpotlightCard product={spotlight} />
        </div>
      </section>

      <section className="section tight">
        <div className="container">
          <motion.div className="product-grid featured-grid" layout>
            {shown.map((p, i) => (
              <ProductCard key={p.id} product={p} index={i} />
            ))}
          </motion.div>
        </div>
      </section>

      <section className="section">
        <div className="container center-cta">
          <Reveal>
            <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
              <Link to="/products" className="btn btn-ghost btn-lg">
                Browse the full catalog
              </Link>
            </motion.div>
          </Reveal>
        </div>
      </section>
    </div>
  );
}
