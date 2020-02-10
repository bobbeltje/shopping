<?php
require_once "pdo.php";
session_start();

# alerts
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
# POST
if ( isset($_POST['item']) && isset($_POST['category']) ) {
    if ( $_POST['category'].'oi' === '0oi') {
        $_SESSION['error'] = 'You need to set a category';
        header( 'Location: index.php' ) ;
        return;
    }
    
    $nrows = $pdo->query("select count(*) from shopping_list")->fetchColumn();
    
    if ($nrows > 5){
        $_SESSION['error'] = 'List cannot have more than 6 elements';
        header('Location: index.php');
    }else{
        $sql = "INSERT INTO shopping_list (item, category, quantity) 
                  VALUES (:item, :category, :quantity)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':item' => $_POST['item'],
            ':category' => $_POST['category'],
            ':quantity' => $_POST['quantity']));
       $_SESSION['success'] = 'Record Added';
       header( 'Location: index.php' ) ;
    }
   return;
}
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
function htmlentities(str) {
   return $('<div/>').text(str).html();
}
$(document).ready(function(){
    $.getJSON('getjson.php', function(rows) {
    $("#mytab").empty();
    console.log(rows);
    found = false;
    for (var i = 0; i < rows.length; i++) {
        row = rows[i];
        found = true;
        window.console && console.log('Row: '+i+' '+row.item);
        $("#mytab").append("<tr><td>"+htmlentities(row.item)+'</td><td>'
            + htmlentities(row.quantity)+'</td><td>'
            + htmlentities(row.category)+"</td><td>\n"
            //~ + '<a href="edit.php?id='+htmlentities(row.id)+'">Edit</a> / '
            + '<a href="delete.php?id='+htmlentities(row.id)+'">Delete</a>\n</td></tr>');
    }
    if ( ! found ) {
        $("#mytab").append("<tr><td>No entries found</td></tr>\n");
    }
});
});
</script>
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

