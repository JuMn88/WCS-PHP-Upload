<?php

    // Je vérifie si le formulaire est soumis comme d'habitude
    if($_SERVER['REQUEST_METHOD'] === "POST"){ 
        $errors = [];
        $data = array_map('trim', $_POST);
        // Securité en php
        // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés (attention ce dossier doit être accessible en écriture)
        $uploadDir = 'uploads/';
        // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client (mais d'autre stratégies de nommage sont possibles)
        $uploadFile = $uploadDir . uniqid();
        // Je récupère l'extension du fichier
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        // Les extensions autorisées
        $extensions_ok = ['jpg','webp','png', 'gif'];
        // Le poids max géré par PHP par défaut est de 2M
        $maxFileSize = 1000000;

        // Je sécurise et effectue mes tests
        if (empty($data['user_lastname'])) {
            $errors[] = 'Votre nom de famille';
        }
    
        if (empty($data['user_firstname'])) {
            $errors[] = 'Votre prénom';
        }

        if (empty($data['user_age'])) {
            $errors[] = 'Votre âge';
        }

        if ($data['user_age'] < 16) {
            $errors[] = 'Votre âge (vous êtes trop jeune pour avoir le permis!)';
        }

        /****** Si l'extension est autorisée *************/
        if( (!in_array($extension, $extensions_ok ))){
            $errors[] = 'Veuillez sélectionner une image de type Jpg ou Webp ou Png ou Gif !';
        }

        /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
        if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
        {
        $errors[] = "Votre fichier doit faire moins de 1M !";
        }

        /****** Si je n'ai pas d"erreur alors j'upload *************/
        if($errors == []) {
            // on déplace le fichier temporaire vers le nouvel emplacement sur le serveur. Ca y est, le fichier est uploadé
            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License</title>
</head>
<body>
    <?php if ($errors == []): ?>
        <img src='<?= $uploadFile ?>' alt='your profile picture'>
        <ul>
            <li><?= $data['user_lastname']; ?></li>
            <li><?= $data['user_firstname']; ?></li>
            <li><?= $data['user_age']; ?></li>
        </ul>
    <?php else: ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="form.php" method="post">
        <button name="return">Retour</button>
    </form>
</body>
</html>
