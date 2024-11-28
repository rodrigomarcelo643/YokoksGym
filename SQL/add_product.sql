    CREATE TABLE AddProducts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ProductName VARCHAR(255) NOT NULL,
        ProductId VARCHAR(255) NOT NULL,
        Price VARCHAR(255),
        Stocks VARCHAR(255) NOT NULL,
        ProductType VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        image LONGBLOB
    );
