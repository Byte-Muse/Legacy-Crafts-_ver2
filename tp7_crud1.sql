CREATE DATABASE tp7_crud4;
Use tp7_crud4;

CREATE TABLE formations(
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100),
    niveau VARCHAR(100)

)ENGINE=InnoDB;

CREATE TABLE etudiant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    tel VARCHAR (20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    formation_id INT NOT NULL,
    CONSTRAINT fk_etudiants_formation FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE RESTRICT ON UPDATE CASCADE



) ENGINE=InnoDB;


CREATE TABLE module(
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100),
    heures INT NOT NULL, 
    formation_id INT NOT NULL,
    CONSTRAINT fk_module_formation FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE RESTRICT ON UPDATE CASCADE

)ENGINE=InnoDB;

INSERT INTO formations (titre, niveau) VALUES
    ('Mosaic', 'Beginner'),
    ('Calligraphy', 'Intermediate'),
    ('Potery', 'Beginner'),
    ('Carpet weaving', 'Advanced');

INSERT INTO module (titre, heures, formation_id) VALUES
    ("Piece Cutting", 12, 1),
    ("Geometric Motifs", 10, 1),
    ("Setting and Assembly", 14, 1),
    ("Basic Designs", 8, 2),
    ("Kufi and Maghribi Styles", 12, 2),
    ("Model on the Wheel", 12, 3),
    ("Glazing and Firing", 10, 3),
    ("Natural Dyeing", 6, 4),
    ("Berber Knots", 16, 4);

INSERT INTO etudiant (nom, tel, email, formation_id) VALUES
    ('Saloua', '0600000001', 'anesthesiolgist@example.com', 1),
    ('Ghita', '0600000002', 'masterchef@example.com', 1),
    ('Jihane', '0600000003', 'sunshinelawyer@example.com', 2),
    ('May', '0600000004', 'saddistnurse@example.com', 3),
    ('Fatoma', '0600000005', 'sunshine&rainbows@example.com', 4),
    ('Annie', '0600000006', 'youngdutchess@example.com', 3);