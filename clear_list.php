<?php
require_once "pdo.php";
require_once "helpers.php";
session_start();

if ( isset($_POST['delete']) ) {
    $sql = "DELETE FROM shopping_list";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $_SESSION['success'] = 'Shopping list cleared';
    header( 'Location: index.php' ) ;
    return;
}

echo(make_head());
echo("<div class='container-fluid'>");
echo "<h3>Clear the entire list?</h3>\n";

echo('<form method="post">');
echo('<div class="form-group">');
echo('<input class="btn btn-danger" type="submit" value="Delete" name="delete">');
echo('</div>');
echo('<a href="index.php">Cancel</a>');
echo("\n</form>\n");
echo('</div>');
