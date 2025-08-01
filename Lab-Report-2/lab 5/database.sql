-- This table will store user login information.
-- We are using 'accounts' to avoid confusion with the old 'users' table.
CREATE TABLE accounts (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Increased length for hashed passwords
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- This table will store all the bio data from your form.
-- It is linked to the 'accounts' table via the 'account_id' column.
CREATE TABLE biodata (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    account_id INT(11) UNSIGNED NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    marital_status VARCHAR(20) NOT NULL,
    blood_group VARCHAR(5) NOT NULL,
    hobbies VARCHAR(255) DEFAULT NULL, -- Hobbies will be stored as a comma-separated string
    github_url VARCHAR(255) DEFAULT NULL,
    linkedin_url VARCHAR(255) DEFAULT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (account_id) REFERENCES accounts(id) ON DELETE CASCADE
);
