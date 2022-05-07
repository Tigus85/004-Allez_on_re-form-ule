<?php


// fonction verification email
function sanitizeEmail($email){
	$email = trim($email);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	return $email;
}

// fonction autorisation nom de domaine
function confirmationMail (string $email, array $autorize ){
  foreach($autorize as $mail){
    if(preg_match($mail, $email)){
      return true;
    }
  }
  return false;
}



var_dump($_POST);

$first_name =  htmlspecialchars($_POST['first_name']);
$last_name = htmlspecialchars($_POST['last_name']);
$years28 = 883008000;

$autorize_mail = [
  "[.fr]",
  "[.com]",
  "[.net]",
  "[.org]",
  "[.club]",
  "[.co.uk]"
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <script type="text/javascript" src="index.js" defer></script>
  <title>Validation formulaire</title>
</head>
<body>



<?php



if(
  !empty($first_name)
  && !empty($last_name)
  && !empty($_POST['date_of_birth'])
  && !empty($_POST['email'])
  && sanitizeEmail($_POST['email'])
  && isset($_POST["submit_btn"])
  && strlen($last_name) >= 2 
  && strlen($last_name) >= 3
  && !preg_match('#^[^0-9]*([0-9])#',$first_name)
  && (time() - (strtotime($_POST['date_of_birth'])) > $years28)
  && confirmationMail($_POST['email'], $autorize_mail)
  ) { 
    ?>
    <header>
      <h1>Vos informations </h1>
    </header>

    <section>
      <p>Votre Nom est <?= $last_name ?>  et fait au moins 2 caractères</p>
      <p>Votre Prénom est <?= $first_name ?> et fait 3 caractéres sans chiffres </p>
      <p>Votre date de naissance est 
        <?= date( "d/m/Y",strtotime($_POST['date_of_birth']))  ?>
        et vous avez plus de 28 ans </p>
      <p>Votre adresse mail est <?= sanitizeEmail($_POST['email']) ?> </p>
      <p>Votre statut professionnel est :  <?= $_POST['professionalStatus'] ;?></p>
      <p>Votre niveau d'études  est :  <?= $_POST['level']  ;?></p>
      <?php

        if (!isset($_POST['hobbies'])){
       
           echo "<p>Coquin ! Tu ne veux pas nous dire tes petits secrets 😉</p>" ;
        } elseif (count($_POST['hobbies']) === 1 ){
          echo "<p>Votre loisirs favoris est : " .$_POST['hobbies'][0] . "</p>";
        }else{
          echo "<p>Vos loisirs favoris sont : ";
          foreach($_POST['hobbies'] as $hobbie){
          echo $hobbie . " "; 
          }
          echo "</p>";
        }
    ?>
    </section>
    <?php

  } 
else { 
  echo "<header> <h1>Erreur au niveau de la saisie</h1> </header>";
}
?>
    
</body>
</html>
