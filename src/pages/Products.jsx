import { AnimatePresence, motion } from 'framer-motion';
import { useMemo, useState } from 'react';
import { useSearchParams } from 'react-router-dom';
import ProductCard from '../components/ProductCard.jsx';
import Reveal from '../components/Reveal.jsx';
import { CATEGORIES, PRODUCTS, getByCategory } from '../data/products.js';

export default function Products() {
  const [searchParams, setSearchParams] = useSearchParams();
  const [query, setQuery] = useState('');
  const active = searchParams.get('category') || 'all';

  const setCategory = (id) => {
    if (id === 'all') {
      searchParams.delete('category');
      setSearchParams(searchParams, { replace: true });
    } else {
      setSearchParams({ category: id }, { replace: true });
    }
  };

  const groups = useMemo(() => {
    const q = query.trim().toLowerCase();
    const cats = active === 'all' ? CATEGORIES : CATEGORIES.filter((c) => c.id === active);
    return cats
      .map((c) => {
        const list = (active === 'all' ? getByCategory(c.id) : getByCategory(c.id)).filter(
          (p) =>
            !q ||
            p.name.toLowerCase().includes(q) ||
            p.brand.toLowerCase().includes(q) ||
            p.short.toLowerCase().includes(q)
        );
        return { category: c, products: list };
      })
      .filter((g) => g.products.length > 0);
  }, [active, query]);

  const totalResults = groups.reduce((s, g) => s + g.products.length, 0);

  return (
    <div className="page">
      <section className="section page-head">
        <div className="container">
          <Reveal>
            <span className="section-eyebrow">Page 03 — Catalog</span>
            <h1>All products</h1>
            <p>The complete NexusTech lineup — 24 devices across six categories.</p>
          </Reveal>
        </div>
      </section>

      <section className="section tight sticky-controls">
        <div className="container">
          <Reveal>
            <div className="catalog-controls">
              <div className="chip-row" role="tablist" aria-label="Category filter">
                <motion.button
                  className={`chip ${active === 'all' ? 'active' : ''}`}
                  onClick={() => setCategory('all')}
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
                    onClick={() => setCategory(c.id)}
                    whileHover={{ scale: 1.06 }}
                    whileTap={{ scale: 0.92 }}
                    role="tab"
                    aria-selected={active === c.id}
                  >
                    <span aria-hidden="true">{c.icon}</span> {c.label}
                  </motion.button>
                ))}
              </div>

              <div className="search-box">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" aria-hidden="true">
                  <circle cx="11" cy="11" r="8" />
                  <path d="m21 21-4.35-4.35" />
                </svg>
                <input
                  type="search"
                  placeholder="Search products, brands…"
                  value={query}
                  onChange={(e) => setQuery(e.target.value)}
                  aria-label="Search products"
                />
                {query && (
                  <motion.button
                    className="search-clear"
                    onClick={() => setQuery('')}
                    initial={{ scale: 0 }}
                    animate={{ scale: 1 }}
                    whileTap={{ scale: 0.85 }}
                    aria-label="Clear search"
                  >
                    ×
                  </motion.button>
                )}
              </div>
            </div>
          </Reveal>
        </div>
      </section>

      <section className="section tight">
        <div className="container">
          {totalResults === 0 ? (
            <motion.div className="no-results glass" initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
              <span aria-hidden="true">🔍</span>
              <h3>No matches for “{query}”</h3>
              <p>Try a different keyword or clear the filters.</p>
              <motion.button
                className="btn btn-ghost"
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                onClick={() => {
                  setQuery('');
                  setCategory('all');
                }}
              >
                Reset filters
              </motion.button>
            </motion.div>
          ) : (
            groups.map((g) => (
              <div key={g.category.id} className="catalog-group">
                <Reveal className="group-head">
                  <h2>
                    <span aria-hidden="true">{g.category.icon}</span> {g.category.label}
                  </h2>
                  <span className="group-count">
                    {g.products.length} product{g.products.length > 1 ? 's' : ''}
                  </span>
                </Reveal>
                <motion.div className="product-grid" layout>
                  <AnimatePresence mode="popLayout">
                    {g.products.map((p, i) => (
                      <ProductCard key={p.id} product={p} index={i} />
                    ))}
                  </AnimatePresence>
                </motion.div>
              </div>
            ))
          )}
        </div>
      </section>
    </div>
  );
}
