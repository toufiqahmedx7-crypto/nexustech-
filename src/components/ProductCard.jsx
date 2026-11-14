import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { useCart } from '../context/CartContext.jsx';
import { formatPrice } from '../data/products.js';

export function Rating({ value, reviews }) {
  return (
    <div className="rating" aria-label={`Rated ${value} out of 5`}>
      <span className="stars" aria-hidden="true">
        {[1, 2, 3, 4, 5].map((i) => (
          <svg key={i} width="13" height="13" viewBox="0 0 24 24" className={i <= Math.round(value) ? 'star filled' : 'star'}>
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z" />
          </svg>
        ))}
      </span>
      <span className="rating-value">{value.toFixed(1)}</span>
      {reviews != null && <span className="rating-count">({reviews.toLocaleString()})</span>}
    </div>
  );
}

export default function ProductCard({ product, index = 0 }) {
  const { addItem } = useCart();

  return (
    <motion.article
      className="product-card glass"
      initial={{ opacity: 0, y: 32 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true, margin: '-40px' }}
      transition={{ duration: 0.5, delay: (index % 4) * 0.07, ease: [0.22, 1, 0.36, 1] }}
      whileHover={{ y: -8 }}
    >
      <Link to={`/product/${product.slug}`} className="product-media">
        <img src={product.images[0]} alt={product.name} loading="lazy" />
        {product.badge && <span className={`badge badge-${product.badge.toLowerCase().replace(/\s/g, '-')}`}>{product.badge}</span>}
        {product.stock <= 15 && <span className="badge badge-low">Only {product.stock} left</span>}
      </Link>

      <div className="product-body">
        <span className="product-brand">{product.brand}</span>
        <Link to={`/product/${product.slug}`} className="product-name">
          {product.name}
        </Link>
        <Rating value={product.rating} reviews={product.reviews} />
        <div className="product-foot">
          <div className="price-group">
            <span className="price">{formatPrice(product.price)}</span>
            {product.oldPrice && <span className="price-old">{formatPrice(product.oldPrice)}</span>}
          </div>
          <motion.button
            className="btn btn-primary btn-sm"
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.9 }}
            onClick={() => addItem(product)}
            aria-label={`Add ${product.name} to cart`}
          >
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" aria-hidden="true">
              <path d="M12 5v14M5 12h14" />
            </svg>
            Add
          </motion.button>
        </div>
      </div>
    </motion.article>
  );
}
