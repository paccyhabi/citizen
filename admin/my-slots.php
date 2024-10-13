<?php 
include "../includes/header.php";

// Fetch Slots and their corresponding department names from the database
$sql = "SELECT * from slots where officerId = '$id'";
$stmt = $pdo->query($sql);
$Slots = $stmt->fetchAll();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Slots</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Manage Slots</li>
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
                    <th>Start time</th>
                    <th>End time</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($Slots as $index => $Slot): ?>
                    <tr>
                      <td><?php echo $index + 1; ?></td>
                      <td><?php echo htmlspecialchars($Slot['startTime']); ?></td>
                      <td><?php echo htmlspecialchars($Slot['endTime']); ?></td>
                      <td>
                      <a href="editSlot.php?id=<?php echo htmlspecialchars($Slot['id']); ?>" class="btn btn-warning btn-sm">
                          <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="delete/delete_Slot.php?id=<?php echo htmlspecialchars($Slot['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Slot?');">
                          <i class="fas fa-trash-alt"></i> Delete
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php  
 include "../includes/datatableFooter.php";
?>
