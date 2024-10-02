create DATABASE db_olx;

use db_olx;

create  Table category(
    id INT PRIMARY key auto_increment,
    name VARCHAR(255) NOT NULL,
    img VARCHAR(255) NOT NULL
);