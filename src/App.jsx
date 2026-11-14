import { useEffect } from 'react';
import { AnimatePresence, motion } from 'framer-motion';
import { Route, Routes, useLocation } from 'react-router-dom';
import Footer from './components/Footer.jsx';
import MiniCart from './components/MiniCart.jsx';
import Navbar from './components/Navbar.jsx';
import Featured from './pages/Featured.jsx';
import Home from './pages/Home.jsx';
import NotFound from './pages/NotFound.jsx';
import ProductDetail from './pages/ProductDetail.jsx';
import Products from './pages/Products.jsx';
import Trust from './pages/Trust.jsx';

function ScrollToTop() {
  const { pathname } = useLocation();
  useEffect(() => {
    window.scrollTo({ top: 0, behavior: 'instant' });
  }, [pathname]);
  return null;
}

export default function App() {
  const location = useLocation();

  return (
    <div className="app-shell">
      <div className="glow-frame" aria-hidden="true">
        <span className="glow-edge glow-top" />
        <span className="glow-edge glow-bottom" />
        <span className="glow-edge glow-left" />
        <span className="glow-edge glow-right" />
      </div>

      <ScrollToTop />
      <Navbar />

      <AnimatePresence mode="wait">
        <motion.main
          key={location.pathname}
          initial={{ opacity: 0, y: 18, filter: 'blur(6px)' }}
          animate={{ opacity: 1, y: 0, filter: 'blur(0px)' }}
          exit={{ opacity: 0, y: -14, filter: 'blur(6px)' }}
          transition={{ duration: 0.38, ease: [0.22, 1, 0.36, 1] }}
        >
          <Routes location={location}>
            <Route path="/" element={<Home />} />
            <Route path="/featured" element={<Featured />} />
            <Route path="/products" element={<Products />} />
            <Route path="/product/:slug" element={<ProductDetail />} />
            <Route path="/trust" element={<Trust />} />
            <Route path="*" element={<NotFound />} />
          </Routes>
        </motion.main>
      </AnimatePresence>

      <Footer />
      <MiniCart />
    </div>
  );
}
