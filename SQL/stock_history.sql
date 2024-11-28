CREATE TABLE stock_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_code VARCHAR(255) NOT NULL,
    change_amount INT NOT NULL,
    reason TEXT,
    change_date DATETIME NOT NULL,
    FOREIGN KEY (product_id) REFERENCES AddProducts(id)
);
