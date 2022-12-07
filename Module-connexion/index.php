<?php
session_start();
include('db_config.php');

$userConnected = false;
$adminConnected =  false;

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $userConnected = true;

    $recupUser = $conn->prepare("SELECT nom, prenom, `login`  FROM `utilisateurs` WHERE id = '$id'");
    $recupUser->execute();
    $user = $recupUser->fetch(PDO::FETCH_ASSOC);
   
    if($user['login'] == "admin"){
        $adminConnected = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=style.css>
    <title>Accueil</title>
</head>

<body>

<?php if($adminConnected){?>

<header>
<nav>
    <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/profil.php">Profil</a>
    <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/admin.php">Admin</a>
    <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/connexion.php?deco">Déconnection</a>
</nav>
</header>
<main>

<h1>Bienvenue, Admin :) <h1>
        
<!-- PHP: If user is connected ... -->
<?php } elseif($userConnected) { ?>

    <header>
        <nav>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/profil.php">Profil</a>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/connexion.php?deco">Déconnection</a>
            
        </nav>
    </header>
    
    <main>
        <h1>Welcome <b><?php echo $user['prenom'] . " " . $user['nom']; ?></b></h1>
    </main>

    


    <!-- PHP: If user is not connected ... -->
    <?php } else { ?>

    <header>
        <nav>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/index.php" active>Accueil</a>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/connexion.php">Se connecter</a>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/inscription.php">Créer un compte</a>
        </nav>
    </header>

    <main>
        <h1>Welcome to module-connexion!</h1>
       
    </main>

    <?php } ?>  

 
</body>

</html>
