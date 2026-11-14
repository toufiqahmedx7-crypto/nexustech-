import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';

export default function NotFound() {
  return (
    <div className="page container section">
      <motion.div
        className="no-results glass"
        initial={{ opacity: 0, y: 24 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5 }}
      >
        <span className="nf-code" aria-hidden="true">404</span>
        <h2>Page not found</h2>
        <p>The page you are looking for does not exist or has moved.</p>
        <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
          <Link to="/" className="btn btn-primary">
            Back to home
          </Link>
        </motion.div>
      </motion.div>
    </div>
  );
}
