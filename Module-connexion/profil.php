<?php

session_start();
include('db_config.php');   

if(!isset($_SESSION['id'])){
    header('Location: index.php');

}

$id = $_SESSION['id'];
$recupUser = $conn->prepare("SELECT * FROM `utilisateurs` WHERE id = '$id'");
$recupUser->execute();
$user = $recupUser->fetch(PDO::FETCH_ASSOC);
$login = $user['login'];
$prenom = $user['prenom'];
$nom = $user['nom'];
$hashPassword = $user['password'];

//var_dump($user);


if(isset($_POST['modifier'])){
    if(!empty($_POST['login']) && !empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['newPassword']) && !empty($_POST['confirmNewPassword'])){

        $newLogin=htmlspecialchars($_POST['login']);  //htmlspecialchar to secure the data
        $newPrenom=htmlspecialchars($_POST['prenom']);
        $newNom=htmlspecialchars($_POST['nom']);
        $newPassword=htmlspecialchars($_POST['newPassword']); 
        $newConfirmPassword=htmlspecialchars($_POST['confirmNewPassword']);


        $recupUser = $conn->prepare('SELECT * FROM utilisateurs WHERE login = ?');
        $recupUser->execute(array($newLogin));
        
        $foundUser = ($recupUser->rowCount() > 0);
        
        if($foundUser){
            echo "<p class='err-msg'>User is already exists</p>";
           
        } else {


            if($newPassword == $newConfirmPassword) {
                
                $newPassword=password_hash($newPassword, PASSWORD_DEFAULT);

                $updateUser = $conn->prepare("UPDATE `utilisateurs` SET `login` = ?, `prenom` = ?, `nom`= ?, `password`= ? WHERE id = ?");
                $updateUser->execute(array($newLogin, $newPrenom, $newNom, $newPassword, $id));

                if($updateUser){
                    echo "<p class='success-msg'>Profile updated successfully</p>";
                }

            } else {
                    echo "<p class='err-msg'>Passwords do not match</p>";
            }
        }

    } else {
       echo "<p class='err-msg'>Veuillez completer tous les champs...</p>";
    }

}

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href=style.css>
        <title>Module-connexion</title>
    </head>

<body>
    
    <header>
        <nav>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/index.php">Accueil</a>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/profil.php">Profil</a>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/connexion.php?deco">Déconnection</a>
        </nav>
    </header>
   
    <main> 
    <h2>Modifiez votre profil</h2>

    <form action="" method="post" id="form" class="topBefore" >  <!--The form with method "post" ---->
        <input id="login" name="login" placeholder="Login" type="text" value="<?php echo $login; ?>" ><br> 
        <input id="prenom" name="prenom" placeholder="Prenom" type="text" value="<?php echo $prenom; ?>" ><br>
        <input id="nom" name="nom" placeholder="Nom" type="text" value="<?php echo $nom; ?>" ><br>
        <input id="password" name="newPassword" placeholder="New Password" type="password" ><br>
        <input id="password" name="confirmNewPassword" placeholder="Confirm New Password" type="password" ><br>
        
        <input id="submit" type="submit" name="modifier" value="Modifier"><br>

    </form>

</main>

</body>
</html>