<?php
require_once "protected/pdo.php";
session_start();

if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}

if ( isset($_POST['item']) && isset($_POST['category']) ) {
    if ( $_POST['category'].'oi' === '0oi') {
        $_SESSION['error'] = 'You need to set a category';
        header( 'Location: index.php' ) ;
        return;
    }

    $sql = "INSERT INTO shopping_list (item, category, quantity) 
              VALUES (:item, :category, :quantity)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':item' => $_POST['item'],
        ':category' => $_POST['category'],
        ':quantity' => $_POST['quantity']));
   $_SESSION['success'] = 'Record Added';
   header( 'Location: index.php' ) ;
   return;
}
?>
<html>
<head>
    <?php print_r($_POST); ?>
</head>
<body>
<p><b>Add something</b></p>
<form method='post'>
    <p>Item: <input type='text' name='item'></p>
    <p><label for="category">Category:
    <select name="category" id="category">
    <option value="0">-- Please Select --</option>
    <option value="Veggies">Veggies</option>
    <option value="Frozen">Frozen</option>
    <option value="Snacks">Snacks</option>
    <option value="Dairy">Dairy</option>
    </select>
   </p>
   <p>Quantity: <input type='text' name='quantity'></p>
   <input type='submit' value='Add'>
</form>
<table>
  <tbody id="mytab">
  </tbody>
</table>

