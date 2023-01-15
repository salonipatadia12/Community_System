<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['smsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {

$eid=$_GET['editid'];
$remark=$_POST['remark'];
$sql="update tblvisitor set remark=:remark where ID=:eid";
$query=$dbh->prepare($sql);
$query->bindParam(':remark',$remark,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
 $query->execute();

  echo '<script>alert("Visitor details have been updated")</script>';

  }

?>
<!doctype html>
<html lang="en">

<head>
<title>Society Maintenance System || Visitor Details</title>

<!-- VENDOR CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/vendor/animate-css/animate.min.css">
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css">
<link rel="stylesheet" href="../assets/vendor/parsleyjs/css/parsley.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/color_skins.css">

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
                        <h2>Visitor Details</h2>
                    </div>            
                    <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                        <ul class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="icon-home"></i></a></li>  
                            <li class="breadcrumb-item active">Visitor Details</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Visitor Details</h2>
                        </div>
                        <div class="body">
                           
                            
                                <?php
                   $eid=$_GET['editid'];
$sql="SELECT * from tblvisitor where ID=$eid";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                              <table border="1" class="table table-bordered mg-b-0">
                                            <tr>
    <th>Visitor's Name</th>
    <td><?php  echo $row->VisitorName;?></td>
  </tr>
  

  <tr>
    <th>Mobile Number</th>
    <td><?php  echo $row->MobileNumber;?></td>
  </tr>
  <tr>
    <th>Address</th>
    <td><?php  echo $row->Address;?></td>
  </tr>
  <tr>
    <th>Block</th>
    <td><?php  echo $row->Block;?></td>
  </tr>
  <tr>
    <tr>
    <th>Flat Number</th>
    <td><?php  echo $row->FlatNo;?></td>
  </tr>
  <tr>
    <th>Who to Meet</th>
    <td><?php  echo $row->WhomtoMeet;?></td>
  </tr>
 
  <tr>
    <th>Reason for meeting</th>
    <td><?php  echo $row->ReasontoMeet;?></td>
  </tr>
  <tr>
    <th>Vistor's Entering Time</th>
    <td><?php  echo $row->EnterDate;?></td>
  </tr>
<?php $cnt=$cnt+1;}} ?> 

<?php if($row->remark==""){ ?>
    <form method="post">
         <tr>
    <th>Exit Remark :</th>
    <td>
    <textarea name="remark" placeholder="" rows="12" cols="14" class="form-control" required="true"></textarea></td>
  </tr>                               
 <tr align="center">
    <td colspan="2"><button type="submit" name="submit" class="btn btn-primary btn-sm">Update</button></td>
  </tr>
                                        </form>
               <?php } else { ?>

<tr>
    <th>Exit Remark </th>
    <td><?php echo $row->remark; ?></td>
  </tr>


<tr>
<th>Out Time</th>
<td><?php echo $row->outtime; ?>  </td> 
<?php } ?>
</tr>
</table> 
                            
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

<script src="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../assets/vendor/parsleyjs/js/parsley.min.js"></script>
    
<script src="assets/bundles/mainscripts.bundle.js"></script>
<script src="assets/bundles/morrisscripts.bundle.js"></script>
<script>
    $(function() {
        // validation needs name of the element
        $('#food').multiselect();

        // initialize after multiselect
        $('#basic-form').parsley();
    });
    </script>
</body>
</html>

<?php }  ?>