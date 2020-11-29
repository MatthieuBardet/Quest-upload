<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['submit'])) {
        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {

            $errors = [];
            $mime = ['image/jpeg', 'image/png', 'image/gif'];

            if (empty($_FILES['file']['name'][$i])) {
                $errors[] = "Vous n'avez sélectionné aucun fichier";
            }

            if ($_FILES['file']['size'][$i] > 1000000) {
                $errors[] = "Votre fichier doit peser moins de 1MO";
            }

            if (!in_array($_FILES['file']['type'][$i], $mime)) {
                $errors[] = "Votre fichier doit être au format jpg, png ou gif";
            }

            if (!empty($errors)) { ?>
                <ul> <?php
                    foreach ($errors as $error) { ?>
                        <li><?= $error; ?></li> <?php
                    } ?>
                </ul> <?php
            } else {
                $uploadDir = 'uploads/';
                $extension = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $uploadFile = $uploadDir . basename($filename);
                move_uploaded_file($_FILES['file']['tmp_name'][$i], $uploadFile);
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="../../public/assets/css/style.css">
    <title>Laisse pas trainer ton file</title>
</head>
<body>
<h1>Upload d'image</h1>
<form action="" method="post" enctype="multipart/form-data">
    <label for="upload">Votre image</label>
    <input type="file" name="file[]" id="upload" multiple="multiple">
    <button type="submit">Envoyer</button>
</form>
<?php

$filesName = new FilesystemIterator('uploads/', FilesystemIterator::KEY_AS_FILENAME);

foreach ($filesName as $name) {
    $name->getFilename(); ?>
    <figure>
    <img src="<?= "uploads/" . $name->getFilename() ?>" alt="Image">
    <p><?= $name->getFilename() ?></P>
    </figure><?php
} ?>
</body>
</html>