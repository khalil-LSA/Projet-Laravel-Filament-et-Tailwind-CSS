-- =============================================================================
-- EXPORT DE LA BASE DE DONNÉES E-COMMERCE
-- Base de données SQLite exportée le 9 novembre 2025
-- Fichier source: database/database.sqlite
-- =============================================================================

PRAGMA foreign_keys = OFF;

-- =============================================================================
-- TABLES LARAVEL PAR DÉFAUT
-- =============================================================================

DROP TABLE IF EXISTS migrations;
CREATE TABLE migrations (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    migration VARCHAR(255) NOT NULL,
    batch INTEGER NOT NULL
);

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    email_verified_at DATETIME DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) DEFAULT NULL,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL
);
CREATE UNIQUE INDEX users_email_unique ON users (email);

DROP TABLE IF EXISTS cache;
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY NOT NULL,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

DROP TABLE IF EXISTS cache_locks;
CREATE TABLE cache_locks (
    key VARCHAR(255) PRIMARY KEY NOT NULL,
    owner VARCHAR(255) NOT NULL,
    expiration INTEGER NOT NULL
);

DROP TABLE IF EXISTS jobs;
CREATE TABLE jobs (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    queue VARCHAR(255) NOT NULL,
    payload TEXT NOT NULL,
    attempts INTEGER NOT NULL,
    reserved_at INTEGER DEFAULT NULL,
    available_at INTEGER NOT NULL,
    created_at INTEGER NOT NULL
);
CREATE INDEX jobs_queue_index ON jobs (queue);

DROP TABLE IF EXISTS job_batches;
CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL,
    total_jobs INTEGER NOT NULL,
    pending_jobs INTEGER NOT NULL,
    failed_jobs INTEGER NOT NULL,
    failed_job_ids TEXT NOT NULL,
    options TEXT DEFAULT NULL,
    cancelled_at INTEGER DEFAULT NULL,
    created_at INTEGER NOT NULL,
    finished_at INTEGER DEFAULT NULL
);

DROP TABLE IF EXISTS failed_jobs;
CREATE TABLE failed_jobs (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    uuid VARCHAR(255) NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX failed_jobs_uuid_unique ON failed_jobs (uuid);

-- =============================================================================
-- TABLES E-COMMERCE
-- =============================================================================

-- Table: categories
DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    is_active BOOLEAN NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL
);
CREATE UNIQUE INDEX categories_slug_unique ON categories (slug);

-- Table: brands
DROP TABLE IF EXISTS brands;
CREATE TABLE brands (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    is_active BOOLEAN NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL
);
CREATE UNIQUE INDEX brands_slug_unique ON brands (slug);

-- Table: products
DROP TABLE IF EXISTS products;
CREATE TABLE products (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    category_id INTEGER NOT NULL,
    brand_id INTEGER NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    images JSON DEFAULT NULL,
    description TEXT DEFAULT NULL,
    price DECIMAL(10,2) NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT 1,
    is_featured BOOLEAN NOT NULL DEFAULT 0,
    in_stock BOOLEAN NOT NULL DEFAULT 1,
    on_sale BOOLEAN NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    CONSTRAINT products_category_id_foreign 
        FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE,
    CONSTRAINT products_brand_id_foreign 
        FOREIGN KEY (brand_id) REFERENCES brands (id) ON DELETE CASCADE
);
CREATE UNIQUE INDEX products_slug_unique ON products (slug);
CREATE INDEX products_category_id_index ON products (category_id);
CREATE INDEX products_brand_id_index ON products (brand_id);

-- Table: orders
DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    user_id INTEGER NOT NULL,
    grand_total DECIMAL(10,2) DEFAULT NULL,
    payment_method VARCHAR(255) DEFAULT NULL,
    payment_status VARCHAR(255) DEFAULT NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'new',
    currency VARCHAR(255) DEFAULT NULL,
    shipping_amount DECIMAL(10,2) DEFAULT NULL,
    shipping_method VARCHAR(255) DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    CONSTRAINT orders_user_id_foreign 
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT orders_status_check 
        CHECK (status IN ('new','processing','shipped','delivered','canceled'))
);
CREATE INDEX orders_user_id_index ON orders (user_id);

-- Table: order_items
DROP TABLE IF EXISTS order_items;
CREATE TABLE order_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    order_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL DEFAULT 1,
    unit_amount DECIMAL(10,2) DEFAULT NULL,
    total_amount DECIMAL(10,2) DEFAULT NULL,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    CONSTRAINT order_items_order_id_foreign 
        FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE,
    CONSTRAINT order_items_product_id_foreign 
        FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
);
CREATE INDEX order_items_order_id_index ON order_items (order_id);
CREATE INDEX order_items_product_id_index ON order_items (product_id);

-- Table: addresses
DROP TABLE IF EXISTS addresses;
CREATE TABLE addresses (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    order_id INTEGER NOT NULL,
    first_name VARCHAR(255) DEFAULT NULL,
    last_name VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(255) DEFAULT NULL,
    street_address TEXT DEFAULT NULL,
    city VARCHAR(255) DEFAULT NULL,
    state VARCHAR(255) DEFAULT NULL,
    zip_code VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    CONSTRAINT addresses_order_id_foreign 
        FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE
);
CREATE INDEX addresses_order_id_index ON addresses (order_id);

-- =============================================================================
-- DONNÉES DES MIGRATIONS EXÉCUTÉES
-- =============================================================================

INSERT INTO migrations (migration, batch) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2025_11_09_142600_create_categories_table', 2),
('2025_11_09_142856_create_brands_table', 2),
('2025_11_09_142950_create_products_table', 2),
('2025_11_09_143022_create_orders_table', 2),
('2025_11_09_143049_create_order_items_table', 2),
('2025_11_09_143124_create_addresses_table', 2);

-- =============================================================================
-- DONNÉES D'EXEMPLE POUR TESTER
-- =============================================================================

-- Catégories d'exemple
INSERT INTO categories (name, slug, image, is_active, created_at, updated_at) VALUES
('Électronique', 'electronique', NULL, 1, datetime('now'), datetime('now')),
('Vêtements', 'vetements', NULL, 1, datetime('now'), datetime('now')),
('Maison & Jardin', 'maison-jardin', NULL, 1, datetime('now'), datetime('now')),
('Sports & Loisirs', 'sports-loisirs', NULL, 1, datetime('now'), datetime('now'));

-- Marques d'exemple
INSERT INTO brands (name, slug, image, is_active, created_at, updated_at) VALUES
('Apple', 'apple', NULL, 1, datetime('now'), datetime('now')),
('Samsung', 'samsung', NULL, 1, datetime('now'), datetime('now')),
('Nike', 'nike', NULL, 1, datetime('now'), datetime('now')),
('Adidas', 'adidas', NULL, 1, datetime('now'), datetime('now'));

-- Utilisateur d'exemple
INSERT INTO users (name, email, password, created_at, updated_at) VALUES
('Admin User', 'admin@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', datetime('now'), datetime('now'));

PRAGMA foreign_keys = ON;

-- =============================================================================
-- FIN DE L'EXPORT
-- =============================================================================