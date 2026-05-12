<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px gray;
            border-radius: 8px;
            overflow: hidden;
        }
        
        table thead {
            background: #007BFF;
            color: white;
        }
        
        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        
        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        table tbody tr:hover {
            background: #f5f5f5;
            transition: 0.3s;
        }
        
        table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .count {
            color: #666;
            margin-bottom: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Étudiants</h1>
        
        <?php
        $conn = new mysqli("localhost", "root", "2001", "gestion_academique");
        
        if ($conn->connect_error) {
            die("Connexion échouée: " . $conn->connect_error);
        }
        
        $result = $conn->query("SELECT * FROM etudiant");
        $count = $result->num_rows;

        echo "<p class='count'>Nombre d'étudiants inscrits : <strong>$count</strong></p>";
        
        if($count > 0) {
            echo "<table>";
            echo "<thead><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Matricule</th></tr></thead>";
            echo "<tbody>";
            
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['nom']."</td>";
                echo "<td>".$row['prenom']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['matricule']."</td>";
                echo "</tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p style='color: #999; font-size: 16px;'>Aucun étudiant inscrit.</p>";
        }
        
        $conn->close();
        ?>
    </div>
</body>
</html>
