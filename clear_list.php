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

echo "<p>Clear the entire list?</p>\n";

echo('<form method="post">');
echo('<input type="submit" value="Delete" name="delete">');
echo('<a href="index.php">Cancel</a>');
echo("\n</form>\n");

