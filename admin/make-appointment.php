<?php 
include "../includes/header.php";
if(isset($_POST['Make'])){
  $village = $_POST['village'];
  $reason = $_POST['reason'];
  $slot = $_POST['slot'];
  $sql = "INSERT INTO appointments (village,reason,createdBy,slotId) VALUES (:village, :reason, :by, :slot)";
  $stmt = $pdo->prepare($sql);
  $params = [
      ':village' => $village,
      ':reason' => $reason,
      ':slot' => $slot,
      ':by' => $id
  ];
  if($stmt->execute($params)){
      $message = 'Appointment Made!';
  } else {
      $message = 'Unable to Make Appointment';
  }
}

$sql2 = "SELECT * FROM slots";
$stmt2 = $pdo->query($sql2);
$slots = $stmt2->fetchAll(); 
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="ml-3 text-dark">Make Appointment</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Make Appointment</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row px-4">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Appointment Details</h3>
                </div>
                <form role="form" method="POST">
                <div class="card-body">
                    <!-- Display success message if available -->
                    <?php if (isset($message)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>

                    <!-- Village input field -->
                    <div class="form-group">
                    <label for="village">Village</label>
                    <input type="text" id="village" class="form-control" placeholder="Enter your village" required name="village">
                    </div>

                    <!-- Reason input field -->
                    <div class="form-group">
                    <label for="reason">Reason</label>
                    <textarea name="reason" id="reason" class="form-control" rows="3" placeholder="Enter the reason for the appointment" required></textarea>
                    </div>

                    <!-- Slot selection field -->
                    <div class="form-group">
                    <label for="slot">Slot</label>
                    <select id="slot" class="form-control" name="slot" required>
                        <?php foreach ($slots as $slot): ?>
                        <option value="<?= htmlspecialchars($slot['id']); ?>">
                            <?= htmlspecialchars($slot['startTime']); ?> - <?= htmlspecialchars($slot['endTime']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    </div>                                      
                </div>
                <!-- /.card-body -->

                <!-- Submit button -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name="Make">
                    Make Appointment
                    </button>
                </div>
            </form>

              </div>
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