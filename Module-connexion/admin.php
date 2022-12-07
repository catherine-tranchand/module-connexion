<?php
session_start();
include('db_config.php');

if(!isset($_SESSION['id'])){
    header('Location: index.php');
}


if($_SESSION['login'] != "admin"){

   header('Location: index.php');

}

    $_SESSION['login'] == "admin" && $_SESSION['password'] == "admin";
    $recupUsers = $conn->prepare("SELECT * FROM `utilisateurs`");
    $recupUsers->execute();
    $user=$recupUsers->fetchAll(PDO::FETCH_ASSOC);

 //   var_dump($user);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
</head>


<body>

    <header>
        <nav>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/index.php">Accueil</a>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/profil.php">Profil</a>
            <a href="https://catherine-tranchand.students-laplateforme.io/Module-connexion/connexion.php?deco">Déconnection</a>
        </nav>
    </header>

        <h1>Liste des utilisateurs</h1>
        <table>
            <thead>
                <tr>
                    <th>ID </th>
                    <th>Login </th>
                    <th>Prenom </th>
                    <th>Nom </th>
                    <th>Password </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
<?php  foreach($user as $ligne){
    echo "<tr>";   
    
         foreach($ligne as $value ){
            echo "<td>";
            echo $value;
            echo "</td>";
         }
    echo "</tr>";
} 


?>


    </tbody>
    </table>



    </body>
    </html> 

