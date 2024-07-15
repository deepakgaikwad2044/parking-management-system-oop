<?php

include_once "config/con.php";

$obj = new Query();

if (isset($_POST["submit"])) {
  unset($_POST["submit"]);

  $data = $_POST;

  $res = $obj->insertData("users", $data);

  if ($res == false) {
    
    if(isset($_SESSION['veh_no'])) {
     $veh_no = $_SESSION["veh_no"];
$_SESSION["error"] = "Vehicle number $veh_no has not checked out. Cannot create a duplicate entry.";

    unset($veh_no);    
    }elseif(isset($_SESSION['email'])){
     $mail = $_SESSION["email"];
    $_SESSION["error"] = " $mail already  exist";
    unset($mail);  
    }
   
  } elseif ($res) {
    $_SESSION["success"] = "entry created  successfully";
  } else {
    $_SESSION["success"] = "something went wrong";
  }
  header("LOCATION:index.php");
  exit();
}
?>
 
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Parking-Management-System-Add-Page</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
      
      *{
        margin: 0;
        padding:0;
        box-sizing:border-box;
      }
      
    </style>
  </head>
  <body>
    
    <div class="container py-3">
      
    <h5 class="text-danger mb-3 mx-3">Park New Entry</h5>
    
    <a href="index.php" class="btn btn-dark mx-3 mb-5"> Back</a>
  
   
   <div class=" container py-3 my-1">
     
     <form method="post" action="add.php">
       
       <!-- vehicle no -->
       <div class="form-group mb-3">
          <label for="veh_no" class="form-label">Vehicle No</label>
  <input type="text" id="veh_no" class="form-control" name="veh_no" placeholder="Mh 12 gh 1234" required="">
       </div>
       
        <!-- vehicle owner name -->
 <div class="form-group mb-3">
     <label for="veh_owner_name" class="form-label">Vehicle Owner Name</label>
  <input type="text" id="veh_owner_name" class="form-control" name="veh_owner_name" placeholder="Vijay Dhiwar" required="">
       </div>
  
   <!-- vehicle type -->
 <div class="form-group mb-3">
          <label for="veh_type" class="form-label">Vehicle type</label>
  <select id="veh_type" class="form-control" name="veh_type" placeholder="Mh 12 gh 1234" required>
     <option value="two wheeler" selected>two wheeler</option>
     <option value="four wheeler">four wheeler</option>
     
      <option value="heavy vehicle">heavy vehicle</option>
     </select>
     
       </div>
    
     <!-- email -->
        <div class="form-group mb-3">
          <label for="email" class="form-label">Email</label>
  <input type="email" class="form-control" name="email" id="email" placeholder="joygupta@gmail.com">
       </div>
       
        <!-- phone no -->
 <div class="form-group mb-3">
          <label for="phone" class="form-label">Vehicle Owner Contact No</label>
  <input type="number" id="phone" class="form-control" name="phone" placeholder="9012345678" required="">
       </div>
    
    
       <!-- payout type -->
 <div class="form-group mb-3">
          <label for="payout_type" class="form-label">Vehicle type</label>
  <select id="payout_type" class="form-control" name="payout_type" required>
     <option value="cash">cash</option>
     <option value="online">online</option>
     </select>
     
       </div>
  
       <button type="submit" name="submit" class="btn btn-success">Submit</button>
     </form>
</div>

    </div>
   
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>