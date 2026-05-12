<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription Étudiant</title>
  <link rel="stylesheet" href="style.css">
  <style>
    h1 {
      text-align: center;
      color: #333;
      margin: 30px 0;
    }
    
    .links {
      text-align: center;
      margin-top: 20px;
    }
    
    .links a {
      background: #28a745;
      color: white;
      padding: 10px 20px;
      border-radius: 4px;
      text-decoration: none;
      transition: 0.3s;
      margin: 0 5px;
      display: inline-block;
    }
    
    .links a:hover {
      background: #218838;
    }
  </style>
</head>
<body>
  <h1>Système de Gestion Académique</h1>
  <form action="inscrire.php" method="POST">
    <label>Nom :</label><input type="text" name="nom" required><br>
    <label>Prénom :</label><input type="text" name="prenom" required><br>
    <label>Email :</label><input type="email" name="email" required><br>
    <label>Matricule :</label><input type="text" name="matricule" required><br>
    <button type="submit">Inscrire</button>
  </form>
  
  <div class="links">
    <a href="liste_etudiants.php">📋 Voir la liste des étudiants</a>
    <a href="init_db.php">⚙️ Initialiser la base de données</a>
  </div>
</body>
</html>
