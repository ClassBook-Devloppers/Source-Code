-- Création d'une table pour stocker des informations sur les utilisateurs
CREATE TABLE Users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255) NOT NULL,
    Prenom VARCHAR(255) NOT NULL,
    Username VARCHAR(255) UNIQUE NOT NULL,
    Permission VARCHAR(50) DEFAULT 'Standard', 'Admin', 
);
