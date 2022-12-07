<?php

//To open the session

session_start();          

// To include the config and have an acces to data base 

include('db_config.php');

if(isset($_GET['deco'])){
    unset($_SESSION['id']);
    header('Location: index.php');
}


if(isset($_POST['envoi'])){
    if(!empty($_POST['login']) && !empty($_POST['password'])){


        $login=htmlspecialchars($_POST['login']);  //htmlspecialchar to secure the data

        $password=htmlspecialchars($_POST['password']); 
        //$hashPassword=password_hash($password, PASSWORD_DEFAULT); // password_hash(encoding) to secure the password
        
        $recupUser = $conn->prepare("SELECT id, login, password FROM `utilisateurs` WHERE login = ?");
        $recupUser->execute(array($login));

        // var_dump($recupUser);

        $res=$recupUser->fetch(PDO::FETCH_ASSOC);
        
        var_dump($res);

       
        if($res){

            $id = $res['id'];

            if(password_verify($password, $res['password'])) {
                
                echo "connection reussi! ";

                $_SESSION['id'] = $id;  // To add an id to the session
                $_SESSION['login'] = $login;  // To add an id to the session

                if($login == "admin"){
                    header('Location: admin.php');
                }else {
                    header('Location: index.php'); // To redirect  to home page
                }

            } else {
                echo "<p class='err-msg'>Votre mot de passe ou login est incorrecte</p>";
            }


        }  else {
            echo "<p class='err-msg'>Utilisateur d'existe pas</p>";
        }

        
    } else {
       echo "<p class='err-msg'>Veuillez completer tous les champs... </p>";
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
        <title>Connexion</title>
    </head>

<body>

    <header>
        <nav>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/index.php">Accueil</a>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/connexion.php" active>Se connecter</a>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/inscription.php">Créer un compte</a>
        </nav>
    </header>

    <main> 
    <form action="" method="post" id="form" class="topBefore">  <!--The form with method "post" ---->
        <input id="login" name="login" placeholder="Login" type="text" ><br> 
        <input id="password" name="password" placeholder="Password" type="password" ><br>
        <input id="submit" type="submit" name="envoi" value="Envoi"><br>

    </form>

    </main>

</body>
</html>