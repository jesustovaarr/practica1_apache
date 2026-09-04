CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserts
INSERT INTO productos (sku, name, description, price, stock) VALUES
('PROD-01', 'Teclado', 'Teclado mecánico con retroiluminación RGB.', 1250.00, 15),
('PROD-02', 'Lampara', 'Lampara con luz automatica segun tus actividades.', 650.50, 25),
('PROD-03', 'Escritorio', 'Escritorio comodo para tu trabajo.', 5800.00, 8);


CREATE TABLE api_users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    status ENUM('ACTIVE','INACTIVE') DEFAULT 'ACTIVE',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE api_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    revoked BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_api_tokens_user
    FOREIGN KEY (user_id)
    REFERENCES api_users(id)
    ON DELETE CASCADE
);

-- Inserts
INSERT INTO api_users (username, email, password_hash, status) 
VALUES (
    'jesus',
    'jesus@gmail.com',
    '$2y$12$UFFvcVf1pSo3io6JdTL4jOO96YP7IbGCHN5vCG2NiJ26ZNpnrVK56',
    'ACTIVE'
);