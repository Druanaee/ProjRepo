CREATE DATABASE projekt;
CREATE TABLE wydarzenia( 
    id int AUTO_INCREMENT PRIMARY KEY,
    opis varchar(255),
    wydarzenie_data date,
    wydarzenie_czas time
);