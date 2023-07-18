<?php
session_start();
ob_start();
require_once('db_config.php');
?>





<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Record Expense</title>
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
            echo " <li><a  href='expense_category.php'> <img class = 'icons' src = './assets/img/categories.png'> Categories </a></li>";
            ?>
          </li>
          <li><?php
              echo " <li><a class='active-menu' href='expense_report.php'> <img class = 'icons' src = './assets/img/report.png'> Reports </a></li>";
              ?>
          </li>
        </ul>
      </div>
    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
      <div id="page-inner">





        <div class="row">
          <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
              <div class="panel-heading">
                Expense Details <cdiv class="pull-right">Filter Report using the search</cdiv>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                      <!-- <tr> -->
                      <th>Expense Name</th>
                      <th>Amount Spent</th>
                      <th>Description</th>
                      <th>Date</th>
                      <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>


                      <?php
                      $sql = mysqli_query($con, "SELECT *FROM expense_category_tbl i LEFT JOIN expense_tbl s ON i.expense_category_id= s.expense_category_id
  WHERE (s.expense_category_id>0 )");
                      while ($row = mysqli_fetch_array($sql)) {
                      ?>
                        <tr>
                          <td><?php echo $row['expense_category_name']; ?></td>
                          <td><?php echo $row['amount_spent']; ?></td>
                          <td><?php echo $row['expense_description']; ?></td>
                          <td><?php echo $row['expense_date']; ?></td>
                          <td>
                            <button type="button" class="btn btn-danger btn-xs" data-target="#modal_delete<?php echo $row['expense_id'] ?>" data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</button>
                          </td>

                          <div class="modal fade" id="modal_delete<?php echo $row['expense_id'] ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title">System</h3>
                                </div>
                                <div class="modal-body">
                                  <center>
                                    <h4>Are you sure you want to delete this expense?</h4>
                                  </center>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                  <a type="button" class="btn btn-primary" href="delete.php?expense_id=<?php echo $row['expense_id'] ?>">Yes</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php } ?>

                        <?php
                        ob_flush();
                        mysqli_close($con);
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!--End Advanced Tables -->
          </div>
        </div>

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