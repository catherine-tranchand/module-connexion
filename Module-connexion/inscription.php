<?php

session_start();
include('db_config.php');


if(isset($_POST['envoi'])){
    if(!empty($_POST['login']) && !empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['password']) && !empty($_POST['confirmPassword'])){
        $login=htmlspecialchars($_POST['login']);  //htmlspecialchar to secure the data
        $prenom=htmlspecialchars($_POST['prenom']);
        $nom=htmlspecialchars($_POST['nom']);
        $password=htmlspecialchars($_POST['password']);
        $hashPassword=password_hash($_POST['password'], PASSWORD_DEFAULT); // password_hash(encoding) to secure the password
        $confirmPassword=htmlspecialchars($_POST['confirmPassword']);
        // $users = $bdd->query("SELECT * FROM utilisateurs");
        // var_dump($users);
        // $insertUsers->execute();
        
        $recupUser = $conn->prepare('SELECT * FROM utilisateurs WHERE login = ?');
        $recupUser->execute(array($login));
        
        $foundUser = ($recupUser->rowCount() > 0);
        
        if($foundUser){
            echo "User is already exists";
            header("Location: https://catherine-tranchand.students-laplateforme.io/Module-connexion/connexion.php");
           
        } else {

            echo "password -> $password <br> confirmPassword -> $confirmPassword <br> hashPassword -> $hashPassword";

            if ($password == $confirmPassword) {

                $insertUsers=$conn->prepare("INSERT INTO utilisateurs(login, prenom, nom, password) VALUES(?, ?, ?, ?)");
                $insertUsers->execute(array($login, $prenom, $nom, $hashPassword));
                header("Location: https://catherine-tranchand.students-laplateforme.io/Module-connexion/connexion.php");

            }else {
                echo "<p class='err-msg'>passwords do not match</p>";
            }
           
        }
        
        //  if($recupUser->rowCount()>0){
        // $_SESSION['login'] = $login;
        // $_SESSION['prenom'] = $prenom;
        // $_SESSION['nom'] = $nom;
        // $_SESSION['password'] = $password;
        // $_SESSION['id'] = $recupUser->fetch()['id'];
        // }

        //  echo "Id number is  " . $_SESSION['id'];
        }   
        else{
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
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/connexion.php">Se connecter</a>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/inscription.php" active>Créer un compte</a>
        </nav>
    </header>

   
    <main> 
        <h2>Inscription</h2>
        <form action="" method="post" id="form" class="topBefore">  <!--The form with method "post" ---->
            <input id="login" name="login" placeholder="Login" type="text" ><br> 
            <input id="prenom" name="prenom" placeholder="Prenom" type="text" ><br>
            <input id="nom" name="nom" placeholder="Nom" type="text" ><br>
            <input id="password" name="password" placeholder="Password" type="password" ><br>
            <input id="password" name="confirmPassword" placeholder="Confirm Password" type="password" ><br>
            
            <input id="submit" type="submit" name="envoi" value="Envoi"><br>

        </form>

    </main>

</body>

</html>
