<?php
include_once "config/con.php";

$obj = new Query();

// display to revenue
$get_revenue = $obj->getRevenue();

//delete created entry
if (isset($_GET["action"]) && $_GET["action"] == "delete") {
  $id = $_GET["id"];
  $obj->deleteRecord("users", "id", $id);
  $_SESSION["success"] = "created entry deleted successfully";

  header("LOCATION: index.php");
  exit();
}

//delete completed entry

if (isset($_GET["action"]) && $_GET["action"] == "deleterow") {
  $id = $_GET["id"];

  $data = [
    "deleted" => "1",
  ];

  $res = $obj->deleteComplete("users", "id", $id, $data);

  if (!true) {
    $_SESSION["error"] = " something went wrong try again later..";
  } else {
    $_SESSION["success"] = "successfully row deleted";
  }
  header("LOCATION: index.php");
  exit();
}

// check out
if (isset($_GET["action"]) && $_GET["action"] == "out") {
  $id = $_GET["id"];

  $res = $obj->checkOut("users", "check_out", "id", $id);

  if ($res == false) {
    $_SESSION["error"] = " something went wrong try again later..";
  } elseif ($res) {
    $_SESSION["success"] = "check out proccess completed";
  } else {
    $_SESSION["error"] = "check out undone";
  }

  header("LOCATION: index.php");
  exit();
}

$data = [
  "deleted" => "0",
];

//display to record
$res = $obj->getData("users", "*", "id", "desc", $data);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parking-Management-System-Home-Page</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    
    <style>
   
      *{
        margin: 0;
        padding:0;
        box-sizing:border-box;
      }
      
.material-symbols-outlined {
  font-variation-settings:
  'FILL' 0,
  'wght' 400,
  'GRAD' 0,
  'opsz' 24
}

.material-symbols-outline {
   display: flex;
   justify-content:center;
   align-items: center;
}
   
  body {
    position: relative;
    margin: 0;
    padding: 0;
    width:100vw;
    min-height:100vh;
}

body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width:100vw;
    height:100%;
    background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkJb0icy3l7QBe6JQ7LNQebqjWyQZLv8R6zD_C_5vYxV-PiPaNcw8UjSdp&s=10') no-repeat center center;
    background-size: cover;
    filter:blur(.3rem);
    opacity: .9; 
    z-index: -1;
}

.white {
  color: #fefefe;
}

marquee {
  transform: translateY(-2.5rem);
  
  & h6 {
    font-size:.8rem;
  }
  
}
   
   img {
     width:2.5rem;
     height:2.5rem;
     margin-left:.9rem;
     object-fit: cover;
     border-radius:.5rem;
   }
    .table-responsive {
      overflow-x: auto;
    }
    
    .table-responsive {
      height:80vh;
    }
    .table th, .table td {
      white-space:nowrap;
      padding:.8rem;
    }
    .table thead th {
      background-color: #f8f9fa;
      font-weight: bold;
    }
    .table td p.text-success {
      margin: 0;
    }
    .dropdown-toggle::after {
      display: none;
       }
 
    </style>
  </head>
  <body>
    
    <div class="container py-3">
    
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXloO5FFNiQ7y3O37DmVPlND_Ugl5vXdKBq2tkytFCYsnIE4yd5w2Dcu8E&s=10" class="img-fluid" />  
    
  <h3 class="white mb-5 mx-3">DG-Parking</h3>
    <div>
     
     <div class="px-3">
       
      <marquee scrollamount="2" class="white">Location: (Pune) capital  towers paasion mall near  wakad pune-411057 , (Mumbai) dadar station near kkr jwellers opposite mumbai-400014.  Important: For any parking-related emergencies, please call our toll-free number 3489 immediately. We are here to assist you 24/7 to ensure your safety and convenience.</marquee>

     </div>
       
      <?php include_once "alert.php"; ?>
    </div>
   
   <div class="d-flex justify-content-between align-items-center my-3 gap-3">
    
    <a href="add.php" class="btn btn-sm btn-success mx-3 mb-3" style=""> Add Entry</a>
 
    <h6 class="white mx-3"> Earned : <?php $get_revenue = $get_revenue ?  $get_revenue . " RS " : "0" ;
     echo  $get_revenue
    ?> </h6>
    
   </div> 
  
  
    
  <div class="table-responsive p-3">
  <table class="table table-striped table-bordered " >
  <thead>
    <tr>
      <th>id</th>
      <th>no</th>
      <th>name</th>
      <th>veh type</th>
      <th>email</th>
      <th>phone</th>
      <th>date</th>
      <th>in</th>
      <th>out</th>
      <th>charge</th>
      <th>status</th>
      <th>type</th>
      <th>Act</th>
      
    </tr>
  </thead>
  
  <tbody>
    <?php
    $i = 1;
    if ($res->num_rows > 0) {
      while ($row = $res->fetch_assoc()) { ?>
            <tr>
                <td> <?php echo $i++; ?></td>
                <td> <?php echo $row["veh_no"]; ?></td>
                <td> <?php echo $row["veh_owner_name"]; ?></td>
                <td> <?php echo $row["veh_type"]; ?></td>
                <td> <?php echo $row["email"]; ?></td>
                <td> <?php echo $row["phone"]; ?></td>
                <td> <?php echo $row["date"]; ?></td>
                <td> <?php echo $row["check_in"]; ?></td>
                <td> <?php echo $row["check_out"]; ?></td>
                <td> <?php echo $row["parking_fees"]; ?></td>
                <td> <?php echo $row["status"] == 1
                  ? "<p class='text-success'>complete </p>"
                  : "-"; ?> </td>
                <td> <?php echo $row["payout_type"]; ?></td>
               
                 <td> 
                <?php if ($row["status"] != 1) { ?>
                  
                        <div class="dropdown">
                            <a class="nav-link" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-symbols-outlined">more_vert</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li>
    <a class="dropdown-item" href="edit.php?id=<?php echo $row["id"]; ?>">
    <span class="material-symbols-outlined">edit_square</span> Edit
       </a>  </li>
                                <li>
                                    <a class="dropdown-item" href="./?action=delete&id=<?php echo $row[
                                      "id"
                                    ]; ?>" onclick="return confirm('Do you want to delete it?');">
                                        <span class="material-symbols-outlined">delete</span> Delete
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="./?action=out&id=<?php echo $row[
                                      "id"
                                    ]; ?>" onclick="return confirm('Do you want to out it?');">
                                        <span class="material-symbols-outlined">logout</span> Check Out
                                    </a>
                                </li>
                            </ul>
                        </div>
                  
                <?php } else { ?> 
                                         <div class="dropdown">
                            <a class="nav-link" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-symbols-outlined">more_vert</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
         <li>
        
    <a class="dropdown-item" href="./?action=deleterow&id=<?php echo $row[
      "id"
    ]; ?>" onclick="return confirm('Do you want to delete row ?');">
                                        <span class="material-symbols-outlined">delete</span> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    
                    
                 <?php } ?> 
                  </td>
            </tr>
            <?php }
    } else {
       ?>
        <tr>
            <td colspan="15" class="text-center"> no records found </td>
        </tr>
        <?php
    }
    ?>
</tbody>

</table>
  </div>

      </div>

    
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>