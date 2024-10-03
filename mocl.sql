create DATABASE db_text;

use db_text;

create  Table category(
    id INT PRIMARY key auto_increment,
    name VARCHAR(255) NOT NULL,
    img VARCHAR(255) NOT NULL
);