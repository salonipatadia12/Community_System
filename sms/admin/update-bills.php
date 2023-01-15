<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['smsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {

$smsaid=$_SESSION['smsaid'];

$ppu=$_POST['ppu'];
$unitcons=$_POST['unitcons'];
$echarge=$_POST['echarge'];
$flatnum=$_POST['flatno'];
$block=$_POST['block'];

$sql="insert into tblbill(FlatNum,Block,PricepUnit,UnitCons,Echarge)values(:flatnum,:block,:ppu,:unitcons,:echarge)";
$query=$dbh->prepare($sql);
$query->bindParam(':ppu',$ppu,PDO::PARAM_STR);
$query->bindParam(':unitcons',$unitcons,PDO::PARAM_STR);
$query->bindParam(':echarge',$echarge,PDO::PARAM_STR);
$query->bindParam(':flatnum',$flatnum,PDO::PARAM_STR);
$query->bindParam(':block',$block,PDO::PARAM_STR);
 $query->execute();

   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Electricity Bill details have been added.")</script>';
echo "<script>window.location.href ='manage-bill.php'</script>";
  }
  else
    {
         echo '<script>alert("Something went wrong. Please try again")</script>';
    }

  
}

?>
<!doctype html>
<html lang="en">

<head>
<title>Society Maintenance System || Flat Bill Details</title>

<!-- VENDOR CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/vendor/animate-css/animate.min.css">
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" href="../assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/vendor/sweetalert/sweetalert.css"/>

<!-- MAIN CSS -->
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/color_skins.css">
<style>
    td.details-control {
    background: url('../assets/images/details_open.png') no-repeat center center;
    cursor: pointer;
}
    tr.shown td.details-control {
        background: url('../assets/images/details_close.png') no-repeat center center;
    }
</style>
<script>

function getelectbill(val,inds) 
{   
var inds=$(".units").val();
var val=$(".unitprice").val();
var abh=inds+'$'+val;
//alert(abh);
    $.ajax({
        type: "POST",
        url: "get-bill.php",
        //data:'comp_id1='+inds,
        data:'units_price='+abh,
       //data: 'comp_id1='+val+'&value2='+inds,
//data:"{'data1':'"+value1+"','data2':'"+value2+"'}"
        success: function(data){
            //alert(data);
            $("#echarge").html(data);
            
        }
        });
        }
      </script>
</head>
<body class="theme-blue">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="../assets/images/thumbnail.png" width="48" height="48" alt="Mplify"></div>
        <p>Please wait...</p>
    </div>
</div>
<!-- Overlay For Sidebars -->
<div class="overlay" style="display: none;"></div>

<div id="wrapper">

    <?php include_once('includes/header.php');?>
<?php include_once('includes/sidebar.php');?>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2>Flat Bill</h2>
                    </div>            
                    <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                        <ul class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Flat Bill Details</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>Flat Bill Details</h2>                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
<?php 
$block=$_POST['block'];
$flatnum=$_POST['flatnum'];  

?>            
                          <table border="1" class="table table-bordered">
    <tr>
    <th>Block</th>
    <td><?php  echo ($block);?></td>
    <th>Flat Number</th>
    <td><?php  echo ($flatnum);?></td>
  </tr>
</table>

<?php
$sql="SELECT tblallotment.Name,tblallotment.ContactNumber,tblallotment.Block,tblallotment.FlatNum,tblallotment.EContactnum,tblallotment.Noofmember,tblallotment.Address,tblallotment.AllotmentDate,tblflat.Floor,tblflat.FlatType,tblflat.MCharge from  tblallotment join  tblflat on (tblallotment.FlatNum=tblflat.FlatNum and tblallotment.Block=tblflat.Block) where(tblallotment.Block=:block and tblallotment.FlatNum=:flatnum)";
$query = $dbh -> prepare($sql);
$query->bindParam(':block',$block,PDO::PARAM_STR);
$query->bindParam(':flatnum',$flatnum,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                                <table border="1" class="table table-bordered">
                                  <tr align="center">
<td colspan="4" style="font-size:20px;color:blue">
 Allotment Details</td></tr>

    <tr>
    <th>Name</th>
    <td><?php  echo ($row->Name);?></td>
    <th>Mobile Number</th>
    <td><?php  echo ($row->ContactNumber);?></td>
  </tr>
  
  <tr>
    <th>Emergency Contact Number</th>
    <td><?php  echo ($row->EContactnum);?></td>
     <th>No. of Members</th>
    <td><?php  echo ($row->Noofmember);?></td>
  </tr>

  <tr>
   
    <th>Address</th>
    <td colspan="3"><?php  echo ($row->Address);?></td>
     
  </tr>
  <tr>
    <th>Block</th>
    <td><?php  echo ($row->Block);?></td>
    <th>Flat No.</th>
    <td><?php  echo $fno=$row->FlatNum;?></td>
  </tr>
   <tr>
   
    <th>Floor</th>
    <td><?php  echo ($row->Floor);?></td>
     <th>Flat Type</th>
    <td><?php  echo ($row->FlatType);?></td>
  </tr>
  <tr>
   
    <th>Maintenance Charges</th>
    <td ><?php  echo $mcharge=$row->MCharge;?></td>
   <th>Allotment Date</th>
    <td><?php  echo ($row->AllotmentDate);?></td>   
  </tr>
  

 
   
<?php $cnt=$cnt+1;} ?>
                                </table>
   <table border="1" class="table table-bordered">
     <form name="submit" method="post" enctype="multipart/form-data"> 
<input type="hidden" name="block" value="<?php  echo ($block);?>">
<input type="hidden" name="flatno" value="<?php  echo ($flatnum);?>">

<tr>
<th>Units Consumed: </th>
<td>
  <input type="text" name="unitcons" id="unitcons" class="form-control wd-450 units">
</td></tr>
<tr><th>Price Per Unit: </th>
<td>
  <input type="text" name="ppu" id="ppu" class="form-control wd-450 unitprice" onChange="getelectbill(this.value);">
</td></tr>
<tr>
<th>Electricity Charge: </th>
<td>
<select name="echarge" id="echarge" class="form-control wd-450"> 
</select>
</td></tr>

<tr>
<th>Maintenance Charge: </th>
<td>
  <input type="text" name="mcharge" id="mcharge" class="form-control wd-450" value="<?php echo $mcharge;?>" readonly>
</td></tr>
  <tr align="center">
    <td colspan="2"><button type="submit" name="submit" class="btn btn-az-primary pd-x-20">Submit</button></td>
  </tr>
  </form>
   </table>

<h4 style="font-size:20px;color:blue" align="center">
 Electricity Bill Details</h4>
<?php
$sql="SELECT * from tblbill where Block=:block and FlatNum=:flatnum";
$query = $dbh -> prepare($sql);
$query->bindParam(':block',$block,PDO::PARAM_STR);
$query->bindParam(':flatnum',$flatnum,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row1)
{               ?>
<table border="1" class="table table-bordered">
<tr>
   
    <th>Date of Bill</th>
    <td colspan="3" style="color: red" ><?php  echo ($row1->BillDate);?></td>
     
  </tr>
 <tr>
      
   <th>Units Consumed</th>
    <td><?php  echo ($row1->UnitCons);?>*<?php  echo ($row1->PricepUnit);?>(Price Per Unit)</td>   
  </tr>
  <tr>
   <tr>
    <th>Electricity Charge</th>
    <td ><?php  echo $echarge=$row1->Echarge;?></td></tr>
    <tr>
  <tr>
    <th>Maintenance Charge</th>
    <td ><?php echo $mcharge;?></td></tr>
    <tr>

   <th>Total Charge</th>
    <td><?php  echo $mcharge+$echarge ;?></td>   
  </tr>

  <?php $cnt=$cnt+1;}} ?> 
 </table>  
 <hr color="blue"/>                       
   <?php } else {?>
    <h3 align="center" style="color:red"> Flat not allotted</h3>
<?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
              </div>

        
        </div>
    </div>
    
</div>

<!-- Javascript -->
<script src="assets/bundles/libscripts.bundle.js"></script>    
<script src="assets/bundles/vendorscripts.bundle.js"></script>

<script src="assets/bundles/datatablescripts.bundle.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js --> 


<script src="assets/bundles/mainscripts.bundle.js"></script>
<script src="assets/bundles/morrisscripts.bundle.js"></script>
<script src="assets/js/pages/tables/jquery-datatable.js"></script>
</body>
</html>
<?php }  ?>