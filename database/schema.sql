CREATE TABLE utilisateurs (
id INT AUTO_INCREMENT PRIMARY KEY,
nom VARCHAR(100),
prenom VARCHAR(100),
email VARCHAR(150) UNIQUE,
mot_de_passe VARCHAR(255),
role ENUM('admin','medecin','secretaire'),
actif TINYINT(1) DEFAULT 1
);

CREATE TABLE patients (
id INT AUTO_INCREMENT PRIMARY KEY,
nom VARCHAR(100),
prenom VARCHAR(100),
date_naissance DATE,
sexe ENUM('Homme','Femme'),
telephone VARCHAR(30),
email VARCHAR(150),
adresse TEXT,
allergies TEXT,
antecedents TEXT
);

CREATE TABLE rendez_vous (
id INT AUTO_INCREMENT PRIMARY KEY,
patient_id INT,
medecin_id INT,
date_rdv DATE,
heure_debut TIME,
heure_fin TIME,
motif TEXT,
statut ENUM('programmé','annulé','terminé') DEFAULT 'programmé'
);

CREATE TABLE consultations (
id INT AUTO_INCREMENT PRIMARY KEY,
rendez_vous_id INT,
patient_id INT,
medecin_id INT,
date_consultation DATETIME,
diagnostic TEXT,
traitement TEXT,
observations TEXT
);

CREATE TABLE factures (
id INT AUTO_INCREMENT PRIMARY KEY,
consultation_id INT,
montant DECIMAL(10,2),
statut_paiement ENUM('payée','non_payée') DEFAULT 'non_payée'
);