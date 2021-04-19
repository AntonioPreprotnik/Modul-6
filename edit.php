<?php

    if(!isset($_GET['id']) || empty($_GET['id'])) {
        Header('Location: index.php');
        exit();
    }

    include 'classes/db.php';
    $init_db = new Database();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(empty($_POST['tekst'])) {
            Header('Location: edit.php?id='.$_GET['id']);
            exit();
        }

        $init_db->update($_POST);
    }


    $data = $init_db->edit($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>
<body>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input type="text" name="tekst" value="<?php echo $data['tekst']; ?>">
        <br>
        <input type="submit" value="Ažuriraj">
    </form>
</body>
</html>