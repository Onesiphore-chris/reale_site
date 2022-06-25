<?php

    session_start();
    require_once 'config.php';

    if (isset($_POST['email']) && isset($_POST['password']))
     {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $check = $bdd->prepare('SELECT Pseudo, Email, Passwork FROM connect WHERE Email = :email');
        $check->execute(array(
            'email' => $email
        ));
        $data = $check->fetch();
        $row = $check->rowCount();

        if ($row == 1) {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $password = hash('md5', $password);

                if($data['Passwork'] === $password)
                {
                    $_SESSION['user'] = $data['Pseudo'];
                    header('Location:landing.php');

                }else header('Location:index.php?login_err=password');
            }else header('Location:index.php?login_err=email');
        } else header('Location:index.php?login_err=already');


    } else header('Location:index.php');


?>