

-- =========================================
-- DUCKMART GROCERY
-- CUSTOMER ACCOUNT DATABASE
-- =========================================

-- Select the group's existing database
USE groupD;

-- Create customer accounts table
CREATE TABLE IF NOT EXISTS customers (

    id INT AUTO_INCREMENT PRIMARY KEY,

    first_name VARCHAR(50) NOT NULL,

    last_name VARCHAR(50) NOT NULL,

    email VARCHAR(100) NOT NULL UNIQUE,

    username VARCHAR(50) NOT NULL UNIQUE,

    password_hash VARCHAR(255) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- Display the customers table structure
DESCRIBE customers;

-- Display registered customers
SELECT
    id,
    first_name,
    last_name,
    email,
    username,
    created_at
FROM customers;
