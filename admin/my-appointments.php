<?php 
include "../includes/header.php";
$sql = "SELECT * FROM appointments inner join slots on appointments.slotId =slots.id where appointments.citizenId = '$id'";
$stmt = $pdo->query($sql);
$Appointments = $stmt->fetchAll();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Appointments</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">Manage Appointments</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
          <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>N<sup><u>o</u></sup></th>
                <th>Reason</th>
                <th>Start from</th>
                <th>End to</th>
                <th>Status</th>
              </tr>
              </thead>
              <tbody>
              <?php foreach ($Appointments as $index => $appointment): ?>
              <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($appointment['reason']); ?></td>
                <td><?php echo htmlspecialchars($appointment['startTime']); ?></td>
                <td><?php echo htmlspecialchars($appointment['endTime']); ?></td>
                <td><?php echo htmlspecialchars($appointment['status']); ?></td>
              </tr>
              <?php endforeach; ?>              
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php 
  include "../includes/datatableFooter.php";
  
  ?>