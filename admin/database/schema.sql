CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE
);

CREATE TABLE activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(50) NOT NULL,
    status VARCHAR(20) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(id)
);

CREATE TABLE user_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    permission VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(id)
);

CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    success BOOLEAN NOT NULL,
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE admin_users
ADD COLUMN password_last_changed TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN failed_login_attempts INT DEFAULT 0,
ADD COLUMN last_failed_login TIMESTAMP NULL;

CREATE TABLE quote_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    service VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    budget VARCHAR(20) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'new',
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);