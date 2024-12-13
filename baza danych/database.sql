CREATE DATABASE projekt;
CREATE TABLE wydarzenia( 
    id int AUTO_INCREMENT PRIMARY KEY,
    opis varchar(255),
    wydarzenie_data date,
    wydarzenie_czas time
);
CREATE TABLE logowanie( 
    id int AUTO_INCREMENT PRIMARY KEY,
    email varchar(255),
    login varchar(255),
    password varchar(255)
);