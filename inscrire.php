<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Gestion Académique</title>
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
        
        .error-msg {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin: 20px auto;
            width: 90%;
            text-align: center;
            border: 1px solid #f5c6cb;
        }
        
        .success-msg {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin: 20px auto;
            width: 90%;
            text-align: center;
            border: 1px solid #c3e6cb;
        }
        
        .count {
            color: #666;
            margin-bottom: 20px;
            font-size: 16px;
        }
        
        .nav-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .nav-link a {
            background: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
        }
        
        .nav-link a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Système de Gestion Académique</h1>
        
        <?php
        $conn = new mysqli("localhost", "root", "2001", "gestion_academique");

        if ($conn->connect_error) {
            die("Connexion échouée: " . $conn->connect_error);
        }

        $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
        $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $matricule = isset($_POST['matricule']) ? trim($_POST['matricule']) : '';

        $inscription_reussie = false;
        $message_erreur = '';

        // Vérifier si le matricule existe déjà
        $check_stmt = $conn->prepare("SELECT matricule FROM etudiant WHERE matricule = ?");
        $check_stmt->bind_param("s", $matricule);
        $check_stmt->execute();
        $result_check = $check_stmt->get_result();

        if ($result_check->num_rows > 0) {
            $message_erreur = "✗ Le matricule <strong>$matricule</strong> existe déjà !";
        } else {
            // Insérer le nouvel étudiant
            $stmt = $conn->prepare("INSERT INTO etudiant(nom, prenom, email, matricule) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nom, $prenom, $email, $matricule);
            
            if($stmt->execute()) {
                $inscription_reussie = true;
                echo "<div class='success-msg'>✓ Inscription réussie pour <strong>$prenom $nom</strong> !</div>";
            } else {
                $message_erreur = "✗ Erreur lors de l'inscription : " . $stmt->error;
            }
            $stmt->close();
        }
        
        if (!$inscription_reussie && !empty($message_erreur)) {
            echo "<div class='error-msg'>$message_erreur</div>";
        }
        
        $check_stmt->close();
        
        // Afficher la liste des étudiants
        $result = $conn->query("SELECT * FROM etudiant");
        $count = $result->num_rows;

        echo "<p class='count'>Nombre total d'étudiants inscrits : <strong>$count</strong></p>";
        
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
        
        <div class="nav-link">
            <a href="index.php">← Nouvelle Inscription</a>
        </div>
    </div>
</body>
</html>
