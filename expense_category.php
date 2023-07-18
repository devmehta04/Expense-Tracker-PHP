<?php
session_start();
ob_start();
require_once('db_config.php');

if (isset($_POST['submit']) && !empty($_POST['amount']) && !empty($_POST['expense_category_name'])) {
  // echo print_r($_POST);
  $amount = mysqli_real_escape_string($con, $_POST['amount']);
  $expense_category_name = mysqli_real_escape_string($con, $_POST['expense_category_name']);
  $created_at = date('Y-m-d');

  $sql = "SELECT expense_category_name  FROM expense_category_tbl WHERE expense_category_name = '$expense_category_name' ";
  $query = mysqli_query($con, $sql);
  if ($one = mysqli_num_rows($query) == 1) {
    echo '
         <script type="text/javascript">
          alert("' . ucfirst($expense_category_name) . ' already exist");
         </script>';
    header('expense_category.php');
  }


  $data = mysqli_query($con, "INSERT INTO expense_category_tbl(expense_category_name, created_at, amount) VALUES('" . $expense_category_name . "', '" . $created_at . "','" . $amount . "')");
}

//if data inserted successfully
if (@$data === TRUE) {
  echo '
         <script type="text/javascript">
          alert("Success!");
         </script>';
} else {
  $message = "All fields are required";
}
?>





<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Item Category</title>
  <!-- BOOTSTRAP STYLES-->
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <!-- FONTAWESOME STYLES-->
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLES-->
  <link href="assets/css/custom.css" rel="stylesheet" />
  <!-- GOOGLE FONTS-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
  <!-- TABLE STYLES-->
  <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

  <!--AWESOME ICON-->
  <link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.min.css">

  <!--  <script language="javascript" type="text/javascript">
function removeSpaces(string) {
 return string.split(' ').join('');
}
</script> -->


</head>

<body>
  <div id="wrapper">
    <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0;">
      <div class="navbar-header">
        <a class="navbar-brand">Expensify</a>
      </div>
    </nav>
    <!-- /. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation">
      <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
          <li>
            <?php
            echo " <li><a href='index.php'> <img class = 'icons' src= './assets/img/expenses.png'> Expenses </a></li>";
            ?>
          </li>
          <li>
            <?php
            echo " <li><a class='active-menu' href='expense_category.php'> <img class = 'icons' src = './assets/img/categories.png'> Categories </a></li>";
            ?>
          </li>
          <li><?php
              echo " <li><a href='expense_report.php'> <img class = 'icons' src = './assets/img/report.png'> Reports </a></li>";
              ?>
          </li>
        </ul>
      </div>
    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
      <div id="page-inner">
        <!--  Modals-->
        <div class="panel panel-default">
          <div class="panel-body">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
              Create Expense Category
            </button>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add Expense Category</h4>
                  </div>
                  <div class="modal-body">
                    <div class="header">
                    </div>
                    <div class="content">

                      <form action="expense_category.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                          <div class="form-group col-md-12">
                            <label>Expense Name : </label>
                            <input type="text" name="expense_category_name" id="expense_category_name" class="form-control" placeholder="Expense Name" required>
                          </div>
                          <br>
                          <div class="form-group col-md-12">
                            <label> Enter Budget : </label>
                            <input type="text" name="amount" id="amount" class="form-control" placeholder="Amount :" onBlur="this.value=trim(this.value);" required>
                          </div>
                        </div>
                        <?php if (isset($message)) {
                          echo "<font color='2F4068'><h5>$message</font></h5>";
                        } ?>
                        <div class="modal-footer">
                          <input type="reset" id="rest" value="Cancel" class="btn btn-danger" />
                          <input type="submit" id="submit" name="submit" value="Add" class="btn btn-primary" />
                        </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
              <div class="panel-heading">
                Category List
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>

                      <th>Expense Name</th>
                      <th>Amount </th>
                      <th>Date Created</th>
                      <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>


                      <?php
                      $sql = mysqli_query($con, "SELECT * FROM expense_category_tbl order by expense_category_name ASC");
                      while ($row = mysqli_fetch_array($sql)) {
                      ?>
                        <tr>
                          <td><?php echo $row['expense_category_name'] ?></td>
                          <td><?php echo number_format((float)$row['amount'], 2, '.', '') ?></td>
                          <td><?php echo $date = DATE_FORMAT(new DateTime($row['created_at']), 'd-M-Y') ?></td>
                          <td>
                            <button type="button" class="btn btn-info btn-xs" data-target="#modal_update<?php echo $row['expense_category_id'] ?>" data-toggle='modal'><span class='glyphicon glyphicon-pencil'></span> Edit</button>
                          </td>

                          <div class="modal fade" id="modal_update<?php echo $row['expense_category_id'] ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title">Update Expense</h3>
                                </div>
                                <form action="update_expense.php" method="POST" enctype="multipart/form-data">
                                  <div class="modal-body">


                                    <input type="hidden" id="getID" name="getID" value="<?php echo $row['expense_category_id'] ?>">

                                    <div class="row">
                                      <div class="form-group col-md-12">
                                        <label>Expense Name</label>
                                        <input type="text" name="expense_name" id="expense_name" class="form-control" value="<?php echo $row['expense_category_name'] ?>" required="">
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="form-group col-md-12">
                                        <label>Expense Amount</label>
                                        <input type="text" name="amount" id="amount" class="form-control" value="<?php echo $row['amount'] ?>" required="">
                                      </div>
                                    </div>
                                  </div>


                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                    <input type="submit" id="submit" name="submit" value="Yes" class="btn btn-primary" />
                                  </div>

                                </form>
                              </div>
                            </div>
                          </div>
                        <?php
                      }
                      ob_flush();
                        ?>

                    </tbody>
                  </table>

                </div>

              </div>
            </div>
            <!--End Advanced Tables -->
          </div>
        </div>
        <!-- /. ROW  -->
        <div class="row"><!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
        <!-- /. WRAPPER  -->
        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- JQUERY SCRIPTS -->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="assets/js/jquery.metisMenu.js"></script>
        <!-- DATA TABLE SCRIPTS -->
        <script src="assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
          $(document).ready(function() {
            $('#dataTables-example').dataTable();
          });
        </script>
        <!-- CUSTOM SCRIPTS -->
        <script src="assets/js/custom.js"></script>



</body>

</html>