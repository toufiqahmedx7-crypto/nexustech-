import { AnimatePresence, motion } from 'framer-motion';
import { useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import ProductCard, { Rating } from '../components/ProductCard.jsx';
import Reveal from '../components/Reveal.jsx';
import { useCart } from '../context/CartContext.jsx';
import { CATEGORIES, formatPrice, getProduct, getRelated } from '../data/products.js';

function Gallery({ images, name }) {
  const [active, setActive] = useState(0);

  useEffect(() => setActive(0), [images]);

  return (
    <div className="gallery">
      <div className="gallery-main glass">
        <AnimatePresence mode="wait">
          <motion.img
            key={active}
            src={images[active]}
            alt={`${name} view ${active + 1}`}
            initial={{ opacity: 0, scale: 1.05 }}
            animate={{ opacity: 1, scale: 1 }}
            exit={{ opacity: 0, scale: 0.98 }}
            transition={{ duration: 0.35, ease: [0.22, 1, 0.36, 1] }}
          />
        </AnimatePresence>
      </div>
      <div className="gallery-thumbs">
        {images.map((src, i) => (
          <motion.button
            key={src + i}
            className={`gallery-thumb ${i === active ? 'active' : ''}`}
            onClick={() => setActive(i)}
            whileHover={{ scale: 1.06, y: -2 }}
            whileTap={{ scale: 0.94 }}
            aria-label={`View image ${i + 1}`}
          >
            <img src={src} alt="" loading="lazy" />
          </motion.button>
        ))}
      </div>
    </div>
  );
}

export default function ProductDetail() {
  const { slug } = useParams();
  const product = getProduct(slug);
  const { addItem } = useCart();
  const [qty, setQty] = useState(1);
  const [color, setColor] = useState(0);
  const [added, setAdded] = useState(false);

  useEffect(() => setQty(1), [slug]);

  if (!product) {
    return (
      <div className="page container section">
        <div className="no-results glass">
          <h2>Product not found</h2>
          <Link to="/products" className="btn btn-primary">
            Back to catalog
          </Link>
        </div>
      </div>
    );
  }

  const related = getRelated(product, 4);
  const category = CATEGORIES.find((c) => c.id === product.category);
  const inStock = product.stock > 0;

  const handleAdd = () => {
    addItem(product, qty, product.colors[color]);
    setAdded(true);
    setTimeout(() => setAdded(false), 1600);
  };

  return (
    <div className="page">
      <section className="section tight">
        <div className="container">
          <Reveal className="breadcrumbs">
            <Link to="/">Home</Link>
            <span aria-hidden="true">/</span>
            <Link to={`/products?category=${product.category}`}>{category.label}</Link>
            <span aria-hidden="true">/</span>
            <span>{product.name}</span>
          </Reveal>

          <div className="detail-layout">
            <Gallery images={product.images} name={product.name} />

            <motion.div
              className="detail-info"
              initial={{ opacity: 0, x: 32 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.55, delay: 0.1, ease: [0.22, 1, 0.36, 1] }}
            >
              <div className="detail-badges">
                <span className="chip static">{category.icon} {category.label}</span>
                {product.badge && <span className="badge badge-flagship">{product.badge}</span>}
              </div>

              <h1>{product.name}</h1>
              <p className="detail-short">{product.short}</p>
              <Rating value={product.rating} reviews={product.reviews} />

              <div className="price-group detail-price">
                <span className="price">{formatPrice(product.price)}</span>
                {product.oldPrice && <span className="price-old">{formatPrice(product.oldPrice)}</span>}
                {product.oldPrice && (
                  <span className="save-pill">
                    Save {formatPrice(product.oldPrice - product.price)}
                  </span>
                )}
              </div>

              <div className="stock-row">
                <motion.span
                  className={`stock-dot ${inStock ? 'in' : 'out'}`}
                  animate={inStock ? { scale: [1, 1.35, 1] } : {}}
                  transition={{ repeat: Infinity, duration: 2 }}
                />
                <span className={inStock ? 'stock-in' : 'stock-out'}>
                  {inStock ? `In stock — ${product.stock} units ready to ship` : 'Out of stock'}
                </span>
              </div>

              <div className="option-group">
                <span className="option-label">Finish</span>
                <div className="color-row">
                  {product.colors.map((c, i) => (
                    <motion.button
                      key={c + i}
                      className={`color-swatch ${i === color ? 'active' : ''}`}
                      style={{ background: c }}
                      onClick={() => setColor(i)}
                      whileHover={{ scale: 1.15 }}
                      whileTap={{ scale: 0.9 }}
                      aria-label={`Color option ${i + 1}`}
                      aria-pressed={i === color}
                    />
                  ))}
                </div>
              </div>

              <div className="buy-row">
                <div className="qty-stepper">
                  <motion.button whileTap={{ scale: 0.85 }} onClick={() => setQty((q) => Math.max(1, q - 1))} aria-label="Decrease quantity">−</motion.button>
                  <motion.span key={qty} initial={{ scale: 1.2 }} animate={{ scale: 1 }}>
                    {qty}
                  </motion.span>
                  <motion.button whileTap={{ scale: 0.85 }} onClick={() => setQty((q) => Math.min(99, q + 1))} aria-label="Increase quantity">+</motion.button>
                </div>
                <motion.button
                  className={`btn btn-primary btn-lg add-btn ${added ? 'added' : ''}`}
                  onClick={handleAdd}
                  whileHover={{ scale: 1.03 }}
                  whileTap={{ scale: 0.95 }}
                  disabled={!inStock}
                >
                  <AnimatePresence mode="wait">
                    <motion.span
                      key={added ? 'added' : 'add'}
                      initial={{ opacity: 0, y: 8 }}
                      animate={{ opacity: 1, y: 0 }}
                      exit={{ opacity: 0, y: -8 }}
                      transition={{ duration: 0.18 }}
                    >
                      {added ? '✓ Added to cart' : `Add to Cart — ${formatPrice(product.price * qty)}`}
                    </motion.span>
                  </AnimatePresence>
                </motion.button>
              </div>

              <p className="detail-description">{product.description}</p>

              <div className="specs glass">
                <h3>Full specifications</h3>
                <dl>
                  {Object.entries(product.specs).map(([k, v], i) => (
                    <motion.div
                      key={k}
                      className="spec-row"
                      initial={{ opacity: 0, x: -12 }}
                      whileInView={{ opacity: 1, x: 0 }}
                      viewport={{ once: true }}
                      transition={{ delay: i * 0.05, duration: 0.35 }}
                    >
                      <dt>{k}</dt>
                      <dd>{v}</dd>
                    </motion.div>
                  ))}
                </dl>
              </div>
            </motion.div>
          </div>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <Reveal className="section-head">
            <span className="section-eyebrow">You may also like</span>
            <h2>Recommended for you</h2>
          </Reveal>
          <div className="product-grid">
            {related.map((p, i) => (
              <ProductCard key={p.id} product={p} index={i} />
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}
