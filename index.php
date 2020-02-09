<?php
require_once "protected/pdo.php";
session_start();
?>
<html>
<head>
</head><body>
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
?>
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

