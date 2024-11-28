CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL, 
    contact_number VARCHAR(20) NOT NULL,
    membership_type VARCHAR(50) NOT NULL,
    membership_start DATE NOT NULL,
    membership_due_date DATE NOT NULL,
    total_cost VARCHAR(255) NOT NULL,
    birthdate DATE NOT NULL,
    profile_picture LONGBLOB NOT NULL,
    email VARCHAR(255) NOT NULL, 
    added_item_list VARCHAR(255) NOT NULL,
    paid_status ENUM('paid', 'not paid') NOT NULL DEFAULT 'not paid',
    totalMembershipSale VARCHAR(255) NOT NULL
);
