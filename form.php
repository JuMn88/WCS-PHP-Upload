<form action="license.php" method="post" enctype="multipart/form-data">
    <label for="lastname">Nom :</label>
    <input type="text" id="lastname" name="user_lastname">
    <label for="firstname">Prénom :</label>
    <input type="text" id="firstname" name="user_firstname">
    <label for="age">Âge :</label>
    <input type="number" id="age" name="user_age">
    <label for="imageUpload">Sélectionner une photo de profil</label>    
    <input type="file" name="avatar" id="imageUpload" />
    <button name="send">Envoyer</button>
</form>