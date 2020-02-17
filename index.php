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
    
    if ($nrows >= 39){
        $_SESSION['error'] = 'List cannot have more than 40 elements';
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
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="www/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script type="text/javascript" src="www/js.js"></script>
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
        var tmp = "row_" + row.id;
        //~ window.console && console.log('Row: '+i+' '+row.item);
        $("#mytab").append("<tr id='"+tmp+"'>"
            + '<td onclick="change_opacity(' +tmp+ ')">'
            + htmlentities(row.item)+'</td><td>'
            + htmlentities(row.quantity)+'</td><td>'
            + htmlentities(row.category)+"</td><td>\n"
            //~ + '<a href="edit.php?id='+htmlentities(row.id)+'">Edit</a> / '
            + '<a class="btn btn-warning" href="delete.php?id='+htmlentities(row.id)+'">X</a>\n</td></tr>');
    }
    if ( ! found ) {
        $("#mytab").append("<tr><td>No entries found</td></tr>\n");
    }
});
});
</script>
</head>
<body>
<div class='container-fluid'>
<h1>Shopping list</h1>
<div class='content-section'>
<h3>Add something</h3>
<form method='post'>
    <div class='form-group'>
        <p>Item: <input class='form-control' type='text' name='item'></p>
    </div>
    <div class='form-group'>
        <label for="category">Category:</label>
        <select class='form-control' name="category" id="category">
        <option value="0">-- Please Select --</option>
        <option value="Veggies">Veggies</option>
        <option value="Snacks">Snacks</option>
        <option value="Dairy">Dairy</option>
        <option value="Frozen">Frozen</option>
        <option value="Drinks">Drinks</option>
        <option value="Household">Household</option>
        <option value="Pasta etc">Pasta etc</option>
        <option value="Other">Other</option>
        </select>
    </div>
    <div class='form-group'>
        Quantity: <input type='text' name='quantity'>
    </div>
   <input class='btn btn-primary' type='submit' value='Add'>
</form>
</div>
<table class='table'>
  <tbody id="mytab">
  </tbody>
</table>
<a class='btn btn-danger' href="clear_list.php">Clear the list</a>
</div>
</body>
</html>
