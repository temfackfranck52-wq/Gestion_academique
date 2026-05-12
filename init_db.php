<?php
// Connexion à MySQL sans spécifier de base de données
$conn = new mysqli("localhost", "root", "2001");

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Créer la base de données
$sql_db = "CREATE DATABASE IF NOT EXISTS gestion_academique CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

if ($conn->query($sql_db) === TRUE) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin: 20px auto; width: 90%; text-align: center; border: 1px solid #c3e6cb;'>";
    echo "✓ Base de données 'gestion_academique' créée/vérifiée avec succès !";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin: 20px auto; width: 90%; text-align: center; border: 1px solid #f5c6cb;'>";
    echo "✗ Erreur lors de la création de la base de données: " . $conn->error;
    echo "</div>";
}

// Sélectionner la base de données
$conn->select_db("gestion_academique");

// Créer la table etudiant
$sql_table = "CREATE TABLE IF NOT EXISTS etudiant (
    matricule VARCHAR(50) PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql_table) === TRUE) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin: 20px auto; width: 90%; text-align: center; border: 1px solid #c3e6cb;'>";
    echo "✓ Table 'etudiant' créée/vérifiée avec succès !";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin: 20px auto; width: 90%; text-align: center; border: 1px solid #f5c6cb;'>";
    echo "✗ Erreur lors de la création de la table: " . $conn->error;
    echo "</div>";
}

// Afficher le nombre d'étudiants existants
$result = $conn->query("SELECT COUNT(*) as count FROM etudiant");
$row = $result->fetch_assoc();
$count = $row['count'];

echo "<div style='text-align: center; margin: 20px auto; width: 90%;'>";
echo "<p style='color: #666; font-size: 16px;'>Nombre total d'étudiants dans la base de données : <strong>$count</strong></p>";
echo "</div>";

// Afficher les étudiants existants s'il y en a
if ($count > 0) {
    $result = $conn->query("SELECT * FROM etudiant");
    echo "<table style='width: 90%; margin: 20px auto; border-collapse: collapse; background: white; box-shadow: 0px 0px 10px gray; border-radius: 8px; overflow: hidden;'>";
    echo "<thead style='background: #007BFF; color: white;'>";
    echo "<tr style='border-bottom: 1px solid #ddd;'>";
    echo "<th style='padding: 12px; text-align: left; font-weight: bold;'>Matricule</th>";
    echo "<th style='padding: 12px; text-align: left; font-weight: bold;'>Nom</th>";
    echo "<th style='padding: 12px; text-align: left; font-weight: bold;'>Prénom</th>";
    echo "<th style='padding: 12px; text-align: left; font-weight: bold;'>Email</th>";
    echo "<th style='padding: 12px; text-align: left; font-weight: bold;'>Date d'inscription</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr style='border-bottom: 1px solid #ddd;'>";
        echo "<td style='padding: 12px;'>" . htmlspecialchars($row['matricule']) . "</td>";
        echo "<td style='padding: 12px;'>" . htmlspecialchars($row['nom']) . "</td>";
        echo "<td style='padding: 12px;'>" . htmlspecialchars($row['prenom']) . "</td>";
        echo "<td style='padding: 12px;'>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td style='padding: 12px;'>" . $row['date_inscription'] . "</td>";
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
}

// Lien de retour
echo "<div style='text-align: center; margin-top: 30px;'>";
echo "<a href='index.php' style='background: #007BFF; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; transition: 0.3s;'>← Retour à l'accueil</a>";
echo "</div>";

$conn->close();
?>
