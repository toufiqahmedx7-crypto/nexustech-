import { AnimatePresence, motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { useCart } from '../context/CartContext.jsx';
import { formatPrice } from '../data/products.js';

export default function MiniCart() {
  const { items, isOpen, closeCart, removeItem, updateQty, total, count } = useCart();

  return (
    <AnimatePresence>
      {isOpen && (
        <>
          <motion.div
            className="cart-overlay"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            transition={{ duration: 0.25 }}
            onClick={closeCart}
          />
          <motion.aside
            className="mini-cart"
            role="dialog"
            aria-label="Shopping cart"
            initial={{ x: '100%' }}
            animate={{ x: 0 }}
            exit={{ x: '100%' }}
            transition={{ type: 'spring', stiffness: 320, damping: 32 }}
          >
            <div className="mini-cart-head">
              <h3>
                Your Cart <span className="cart-count-pill">{count}</span>
              </h3>
              <motion.button
                className="icon-button"
                onClick={closeCart}
                whileHover={{ rotate: 90, scale: 1.1 }}
                whileTap={{ scale: 0.9 }}
                aria-label="Close cart"
              >
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" aria-hidden="true">
                  <path d="M18 6 6 18M6 6l12 12" />
                </svg>
              </motion.button>
            </div>

            <div className="mini-cart-body">
              <AnimatePresence initial={false}>
                {items.length === 0 ? (
                  <motion.div
                    className="cart-empty"
                    initial={{ opacity: 0, y: 10 }}
                    animate={{ opacity: 1, y: 0 }}
                    exit={{ opacity: 0 }}
                  >
                    <div className="cart-empty-icon" aria-hidden="true">🛒</div>
                    <p>Your cart is empty.</p>
                    <Link to="/products" className="btn btn-ghost" onClick={closeCart}>
                      Browse products
                    </Link>
                  </motion.div>
                ) : (
                  items.map((item) => (
                    <motion.div
                      key={item.key}
                      className="cart-item"
                      layout
                      initial={{ opacity: 0, x: 40 }}
                      animate={{ opacity: 1, x: 0 }}
                      exit={{ opacity: 0, x: 40, height: 0, marginBottom: 0 }}
                      transition={{ duration: 0.25 }}
                    >
                      <Link to={`/product/${item.slug}`} onClick={closeCart} className="cart-item-img">
                        <img src={item.image} alt={item.name} loading="lazy" />
                      </Link>
                      <div className="cart-item-info">
                        <Link to={`/product/${item.slug}`} onClick={closeCart} className="cart-item-name">
                          {item.name}
                        </Link>
                        <span className="cart-item-price">{formatPrice(item.price)}</span>
                        <div className="qty-stepper small">
                          <motion.button whileTap={{ scale: 0.85 }} onClick={() => updateQty(item.key, item.qty - 1)} aria-label="Decrease quantity">−</motion.button>
                          <span>{item.qty}</span>
                          <motion.button whileTap={{ scale: 0.85 }} onClick={() => updateQty(item.key, item.qty + 1)} aria-label="Increase quantity">+</motion.button>
                        </div>
                      </div>
                      <motion.button
                        className="icon-button remove"
                        onClick={() => removeItem(item.key)}
                        whileHover={{ scale: 1.15 }}
                        whileTap={{ scale: 0.85 }}
                        aria-label={`Remove ${item.name}`}
                      >
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" aria-hidden="true">
                          <path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                        </svg>
                      </motion.button>
                    </motion.div>
                  ))
                )}
              </AnimatePresence>
            </div>

            {items.length > 0 && (
              <motion.div
                className="mini-cart-foot"
                initial={{ opacity: 0, y: 16 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.1 }}
              >
                <div className="cart-total-row">
                  <span>Subtotal</span>
                  <motion.span key={total} initial={{ scale: 1.12, color: '#38bdf8' }} animate={{ scale: 1, color: '#f5f7fa' }}>
                    {formatPrice(total)}
                  </motion.span>
                </div>
                <p className="cart-note">Free express shipping on orders over $50.</p>
                <motion.button
                  className="btn btn-primary btn-block"
                  whileHover={{ scale: 1.02 }}
                  whileTap={{ scale: 0.97 }}
                >
                  Checkout securely
                </motion.button>
              </motion.div>
            )}
          </motion.aside>
        </>
      )}
    </AnimatePresence>
  );
}
