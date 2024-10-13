<?php 
include "../includes/header.php";

if (isset($_GET['supervisorId'])) {
    $supervisorId = $_GET['supervisorId'];
    
    // Fetch supervisor details
    $sql = "SELECT * FROM supervisors WHERE supervisorId = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$supervisorId]);
    $supervisor = $stmt->fetch();

    if (!$supervisor) {
        echo "Supervisor not found.";
        exit;
    }
} else {
    echo "No supervisor ID provided.";
    exit;
}

// Update supervisor details
if (isset($_POST['update'])) {
    $supervisorName = $_POST['supervisorName'];
    $supervisorPhone = $_POST['supervisorPhone'];
    $supervisorEmail = $_POST['supervisorEmail'];
    $departmentId = $_POST['departmentId'];

    $sql = "UPDATE supervisors SET supervisorName = ?, supervisorEmail = ?, supervisorPhone = ?, departmentId = ? WHERE supervisorId = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$supervisorName, $supervisorEmail, $supervisorPhone, $departmentId, $supervisorId]);

    if ($stmt->rowCount() > 0) {
      echo "
      <script>
      window.location.replace('manageSuper.php');
      </script>
      ";
      exit;
  }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Supervisor</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Edit Supervisor</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Supervisor</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST">
              <div class="card-body">
                <div class="form-group">
                  <label for="supervisorName">Supervisor Name</label>
                  <input type="text" name="supervisorName" class="form-control" id="supervisorName" value="<?php echo htmlspecialchars($supervisor['supervisorName']); ?>" required>
                </div>
                <div class="form-group">
                  <label for="supervisorPhone">Phone</label>
                  <input type="text" name="supervisorPhone" class="form-control" id="supervisorPhone" value="<?php echo htmlspecialchars($supervisor['supervisorPhone']); ?>" required>
                </div>
                <div class="form-group">
                  <label for="supervisorEmail">Email</label>
                  <input type="email" name="supervisorEmail" class="form-control" id="supervisorEmail" value="<?php echo htmlspecialchars($supervisor['supervisorEmail']); ?>" required>
                </div>
                <div class="form-group">
                  <label for="departmentId">Department</label>
                  <select name="departmentId" class="form-control" id="departmentId" required>
                    <?php
                    $sql = "SELECT * FROM departments";
                    $stmt = $pdo->query($sql);
                    $departments = $stmt->fetchAll();
                    foreach ($departments as $department) {
                      $selected = $department['departmentId'] == $supervisor['departmentId'] ? 'selected' : '';
                      echo "<option value='" . htmlspecialchars($department['departmentId']) . "' $selected>" . htmlspecialchars($department['departmentName']) . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="update">Update</button>
                <a href="manageSuper.php" class="btn btn-danger">Cancel</a>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php 
 include "../includes/footer.php";
?>
