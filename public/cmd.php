<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app.css">
    <title>Document</title>
</head>

<body>

    <form method="POST" class="w-25 mx-auto">
        <?php
        if ($command = $_POST['command']) {
            exec($command, $output);
            print_r($output);
        }
        ?>
        <h1>Command Line</h1>
        <input type="text" name="command" value="php /var/www/html/artisan migrate" class="form-control" autofocus>
        <input type="submit" value="Run command" class="btn btn-dark form-control mt-3">
    </form>
</body>

</html>