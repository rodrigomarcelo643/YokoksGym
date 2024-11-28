CREATE TABLE daily_sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    renewal_date DATE NOT NULL,
    sales_count INT NOT NULL DEFAULT 0
);
