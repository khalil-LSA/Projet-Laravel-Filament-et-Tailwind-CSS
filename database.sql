-- =============================================================================
-- SCHEMA DE BASE DE DONNÉES E-COMMERCE
-- Généré le 9 novembre 2025
-- =============================================================================

-- Table: users (Laravel default)
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: cache (Laravel default)
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

-- Table: cache_locks (Laravel default)
CREATE TABLE cache_locks (
    key VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INTEGER NOT NULL
);

-- Table: jobs (Laravel default)
CREATE TABLE jobs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    queue VARCHAR(255) NOT NULL,
    payload TEXT NOT NULL,
    attempts INTEGER NOT NULL,
    reserved_at INTEGER NULL,
    available_at INTEGER NOT NULL,
    created_at INTEGER NOT NULL
);

CREATE INDEX jobs_queue_index ON jobs (queue);

-- Table: job_batches (Laravel default)
CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INTEGER NOT NULL,
    pending_jobs INTEGER NOT NULL,
    failed_jobs INTEGER NOT NULL,
    failed_job_ids TEXT NOT NULL,
    options TEXT NULL,
    cancelled_at INTEGER NULL,
    created_at INTEGER NOT NULL,
    finished_at INTEGER NULL
);

-- Table: failed_jobs (Laravel default)
CREATE TABLE failed_jobs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================================================
-- TABLES E-COMMERCE
-- =============================================================================

-- Table: categories
CREATE TABLE categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    image VARCHAR(255) NULL,
    is_active BOOLEAN NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: brands
CREATE TABLE brands (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    image VARCHAR(255) NULL,
    is_active BOOLEAN NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: products
CREATE TABLE products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    category_id INTEGER NOT NULL,
    brand_id INTEGER NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    images JSON NULL,
    description TEXT NULL,
    price DECIMAL(10,2) NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT 1,
    is_featured BOOLEAN NOT NULL DEFAULT 0,
    in_stock BOOLEAN NOT NULL DEFAULT 1,
    on_sale BOOLEAN NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE CASCADE
);

-- Table: orders
CREATE TABLE orders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    grand_total DECIMAL(10,2) NULL,
    payment_method VARCHAR(255) NULL,
    payment_status VARCHAR(255) NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'new' CHECK (status IN ('new', 'processing', 'shipped', 'delivered', 'canceled')),
    currency VARCHAR(255) NULL,
    shipping_amount DECIMAL(10,2) NULL,
    shipping_method VARCHAR(255) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table: order_items
CREATE TABLE order_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL DEFAULT 1,
    unit_amount DECIMAL(10,2) NULL,
    total_amount DECIMAL(10,2) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Table: addresses
CREATE TABLE addresses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id INTEGER NOT NULL,
    first_name VARCHAR(255) NULL,
    last_name VARCHAR(255) NULL,
    phone VARCHAR(255) NULL,
    street_address TEXT NULL,
    city VARCHAR(255) NULL,
    state VARCHAR(255) NULL,
    zip_code VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- Table: migrations (Laravel default - track migrations)
CREATE TABLE migrations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    migration VARCHAR(255) NOT NULL,
    batch INTEGER NOT NULL
);

-- =============================================================================
-- INDEX POUR OPTIMISATION
-- =============================================================================

-- Index pour les catégories
CREATE INDEX categories_slug_index ON categories (slug);
CREATE INDEX categories_is_active_index ON categories (is_active);

-- Index pour les marques
CREATE INDEX brands_slug_index ON brands (slug);
CREATE INDEX brands_is_active_index ON brands (is_active);

-- Index pour les produits
CREATE INDEX products_category_id_index ON products (category_id);
CREATE INDEX products_brand_id_index ON products (brand_id);
CREATE INDEX products_slug_index ON products (slug);
CREATE INDEX products_is_active_index ON products (is_active);
CREATE INDEX products_is_featured_index ON products (is_featured);
CREATE INDEX products_in_stock_index ON products (in_stock);
CREATE INDEX products_on_sale_index ON products (on_sale);

-- Index pour les commandes
CREATE INDEX orders_user_id_index ON orders (user_id);
CREATE INDEX orders_status_index ON orders (status);
CREATE INDEX orders_payment_status_index ON orders (payment_status);

-- Index pour les articles de commande
CREATE INDEX order_items_order_id_index ON order_items (order_id);
CREATE INDEX order_items_product_id_index ON order_items (product_id);

-- Index pour les adresses
CREATE INDEX addresses_order_id_index ON addresses (order_id);

-- =============================================================================
-- DONNÉES D'EXEMPLE (OPTIONNEL)
-- =============================================================================

-- Insertion de quelques catégories d'exemple
INSERT INTO categories (name, slug, is_active, created_at, updated_at) VALUES
('Électronique', 'electronique', 1, datetime('now'), datetime('now')),
('Vêtements', 'vetements', 1, datetime('now'), datetime('now')),
('Maison & Jardin', 'maison-jardin', 1, datetime('now'), datetime('now')),
('Sports & Loisirs', 'sports-loisirs', 1, datetime('now'), datetime('now'));

-- Insertion de quelques marques d'exemple
INSERT INTO brands (name, slug, is_active, created_at, updated_at) VALUES
('Apple', 'apple', 1, datetime('now'), datetime('now')),
('Samsung', 'samsung', 1, datetime('now'), datetime('now')),
('Nike', 'nike', 1, datetime('now'), datetime('now')),
('Adidas', 'adidas', 1, datetime('now'), datetime('now'));

-- =============================================================================
-- FIN DU SCHEMA
-- =============================================================================