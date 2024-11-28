CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
     member_name VARCHAR(255) NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    total DECIMAL(10, 2) NOT NULL
);
