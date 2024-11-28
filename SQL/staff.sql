CREATE TABLE addstaff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    staffUsername VARCHAR(255) NOT NULL UNIQUE,
    staffPassword VARCHAR(255) NOT NULL,
    staffEmail VARCHAR(255) NOT NULL,
    profileImage LONGBLOB
);
