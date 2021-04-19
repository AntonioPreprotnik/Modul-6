<?php

    if(!isset($_GET['id']) || empty($_GET['id'])) {
        header('Location: index.php');
        exit();
    }

    include 'classes/db.php';
    $init_db = new Database();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(empty($_POST['id'])) {
            header('Location: index.php');
            exit();
        }

        $init_db->delete($_POST['id']);
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
    <h3>Jesi li siguran da želiš izbrisati tekst - <?php echo $data['tekst']; ?></h3>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input type="submit" value="DA">
    </form>
    <br>
    <a href="index.php">NE</a>
</body>
</html>