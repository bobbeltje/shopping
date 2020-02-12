<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['delete']) && isset($_POST['id']) ) {
    $sql = "DELETE FROM shopping_list WHERE id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

$stmt = $pdo->prepare("SELECT item, id FROM shopping_list where id = :xyz");
$stmt->execute(array(":xyz" => $_GET['id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for id';
    header( 'Location: index.php' ) ;
    return;
}

echo('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
');
echo("<div class='container-fluid'>");
echo "<h3>Confirm: Deleting ".htmlentities($row['item'])."</h3>\n";

echo('<form method="post">');
echo('<input type="hidden" name="id" value="'.$row['id'].'">'."\n");
echo('<div class="form-group">');
echo('<input class="btn btn-warning" type="submit" value="Delete" name="delete">');
echo('</div>');
echo('<a href="index.php">Cancel</a>');
echo("\n</form>\n");
echo("</div>");

