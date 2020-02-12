<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['delete']) ) {
    $sql = "DELETE FROM shopping_list";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $_SESSION['success'] = 'Shopping list cleared';
    header( 'Location: index.php' ) ;
    return;
}

echo('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
');
echo("<div class='container-fluid'>");
echo "<h3>Clear the entire list?</h3>\n";

echo('<form method="post">');
echo('<input class="btn btn-danger" type="submit" value="Delete" name="delete">');
echo('<div class="form-group">');
echo('<a href="index.php">Cancel</a>');
echo('</div>');
echo("\n</form>\n");
echo('</div>');
