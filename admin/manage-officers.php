<?php 
include "../includes/header.php";

// Fetch users from the database
$sql = "SELECT users.userId, users.username, users.email, users.createdAt 
        FROM users where role ='officer'";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluuserId">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Officers</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Manage Officers</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluuserId -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluuserId">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table userId="example1" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>N<sup><u>o</u></sup></th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($users as $index => $user): ?>
                    <tr>
                      <td><?php echo $index + 1; ?></td>
                      <td><?php echo htmlspecialchars($user['username']); ?></td>
                      <td><?php echo htmlspecialchars($user['email']); ?></td>
                      <td><?php echo htmlspecialchars($user['createdAt']); ?></td>
                      <td>
                        <b><a href="#">...</a></b>
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
    </div><!-- /.container-fluuserId -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php  
include "../includes/datatableFooter.php";
?>
