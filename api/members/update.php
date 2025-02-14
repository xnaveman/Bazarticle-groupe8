<?php
if(!isset($_SESSION)){
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';
require_once '../../functions/query/select.php';
require_once '../../functions/query/update.php';

$numMemb = intval($_POST['numMemb']);
$nomMemb = ctrlSaisies($_POST['nomMemb']);
$prenomMemb = ctrlSaisies($_POST['prenomMemb']);
$passMemb = ctrlSaisies($_POST['passMemb']);
$passMembVerif = ctrlSaisies($_POST['passMembVerif']);
$eMailMemb = ctrlSaisies($_POST['eMailMemb']);
$eMailMembVerif = ctrlSaisies($_POST['eMailMembVerif']);
$numStat = intval($_POST['numStat']);

$errors = [];

$passRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,15}$/';

if (empty($nomMemb) || empty($prenomMemb) || empty($passMemb) || empty($eMailMemb) || empty($eMailMembVerif) || empty($passMembVerif)){
    $errors[] = "Toutes les cases du formulaire doivent être remplies !";
} elseif($eMailMembVerif != $eMailMemb) {
    $errors[] = "Les mails ne sont pas identiques";
} elseif($passMembVerif != $passMemb) {
    $errors[] = "Les mots de passe ne sont pas identiques";
} elseif (!preg_match($passRegex, $passMemb)) {
    $errors[] = "Le mot de passe doit contenir entre 8 et 15 caractères, avec au moins une majuscule, une minuscule, un chiffre et un caractère spécial.";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ../../views/backend/members/edit.php?numMemb=' . $numMemb);
    exit();
} else {
    //$hashedPassMemb = password_hash($passMemb, PASSWORD_DEFAULT);
    sql_update('MEMBRE', "nomMemb = '$nomMemb', prenomMemb = '$prenomMemb', passMemb = '$passMemb', eMailMemb = '$eMailMemb', numStat = $numStat", "numMemb = $numMemb");
    header('Location: ../../views/backend/members/list.php');
    exit();
}
?>
