
<?php   
 //index.php  
session_start() ;
$connect = mysqli_connect("localhost", "root", "root", "geneve"); 


if(isset($_POST["add_to_cart"]))  
{  
  if(isset($_SESSION["shopping_cart"]))  
  {  
   $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
   if(!in_array($_GET["id"], $item_array_id))  
   {  
    $count = count($_SESSION["shopping_cart"]);  
    $item_array = array(  
     'item_id'               =>     $_GET["id"],  
     'item_name'               =>     $_POST["hidden_name"],  
     'item_price'          =>     $_POST["hidden_price"],  
     'item_quantity'          =>     $_POST["quantity"]  
     );  
    $_SESSION["shopping_cart"][$count] = $item_array;  
  }  
  else  
  {  
    echo '<script>alert("Item Already Added")</script>';  
    echo '<script>window.location="07-accounts.php"</script>';  
  }  
}  
else  
{  
 $item_array = array(  
  'item_id'               =>     $_GET["id"],  
  'item_name'               =>     $_POST["hidden_name"],  
  'item_price'          =>     $_POST["hidden_price"],  
  'item_quantity'          =>     $_POST["quantity"]  
  );  
 $_SESSION["shopping_cart"][0] = $item_array;  
}  
}  
if(isset($_GET["action"]))  
{  
  if($_GET["action"] == "delete")  
  {  
   foreach($_SESSION["shopping_cart"] as $keys => $values)  
   {  
    if($values["item_id"] == $_GET["id"])  
    {  
     unset($_SESSION["shopping_cart"][$keys]);  
     echo '<script>alert("Item Removed")</script>';  
     echo '<script>window.location="07-accounts.php"</script>';  
   }  
 }  
}  
}   
?>  
<?php require "header.php" ;
      require"headerpic.php";     
require"list-right.php";
?>
    


 



         <div class="list">



           <?php  
           $query = "SELECT * FROM tbl_product ORDER BY id ASC";  
           $result = mysqli_query($connect, $query);  
           if(mysqli_num_rows($result) > 0)  
           {  
            while($row = mysqli_fetch_array($result))  
            {  
             ?>  

             <form method="post" action="07-accounts.php?action=add&id=<?php echo $row["id"]; ?>">  


               <table border="5">
                <tr><td rowspan="9">  <img class="mySlides product_drag" src="<?php echo $row["image"]; ?>" style="width:220px;height:258px;"  data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-price="<?php echo $row['price']; ?>" ></td><th colspan="2">Basic Product Information</th></tr>
                <tr><td >Item Name</td><td><?php echo $row["name"]; ?></td></tr>
                
                <tr><td >Colour</td><td>Colour of Computer Systems & Software Engineering</td></tr>
                <tr><td >Description</td><td>Software Engineering</td></tr>
                <tr><td >Price:</td><td>USD<?php echo $row["price"]; ?></td></tr>

                <tr><td >quantity:</td><td>										<input type="text" name="quantity" value="1" />  
                </td></tr>

                <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />  
                <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />  

                <tr><td bgcolor=""></td><td>        
                 <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
               </td></tr>

             </table>

           </form>

           <?php  
         }  
       }  
       ?> 











       <table id="customers">  
        <tr>  
         <th width="40%">Item Name</th>  
         <th width="10%">Quantity</th>  
         <th width="20%">Price</th>  
         <th width="15%">Total</th>  
         <th width="5%">Action</th>  
       </tr>  
       <?php   
       if(!empty($_SESSION["shopping_cart"]))  
       {  
         $total = 0;  
         foreach($_SESSION["shopping_cart"] as $keys => $values)  
         {  
          ?>  
          <tr>  
           <td><?php echo $values["item_name"]; ?></td>  
           <td><?php echo $values["item_quantity"]; ?></td>  
           <td>RM <?php echo $values["item_price"]; ?></td>  
           <td>RM <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>  
           <td><a href="07-accounts.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
         </tr>  
         <?php  
         $total = $total + ($values["item_quantity"] * $values["item_price"]);  
       }  
       ?>  
       <tr>  
         <td colspan="3" align="right">Total</td>  
         <td align="right">RM <?php echo number_format($total, 2); ?></td>  
         <td></td>  
       </tr>  

       <tr>  
         <td colspan="3" align="right"></td>  
         <td align="right">

          <form action="javascript.php" method="post">
            <input type="submit" value="Proceed to payment" />
            <input type="hidden" name="amount" value="<?php echo number_format($total, 2); ?>">
          </form>

        </td>  

        <td></td>  
      </tr>  
      <?php  
    }  
    ?>  
  </table> 


</div>




</div>		




<style type="text/css">
  *
  table 	{
   font-family: arial, sans-serif;
   border-collapse: collapse;
   width:100%;
 }





.content{
 min-height: 300px;
 background: #FFFFFF;
 width: 650px;
 margin: 0 auto 0 auto;
 margin-top: 5px;
 margin-bottom: 5px;
 border: 3px solid black;
 float: left
}



</style>

<?php require "footer.php"; ?>

