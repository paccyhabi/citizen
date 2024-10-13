<?php 
include "../includes/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?php echo $role;?> Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
<?php
  if($role == 'admin'){
    ?>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php 
                            // Count departments
                            $sqlCount = "SELECT COUNT(*) AS officersCount FROM users where role = 'officer'";
                            $stmtCount = $pdo->query($sqlCount);
                            $officerCount = $stmtCount->fetch(PDO::FETCH_ASSOC)['officersCount'];  
                            ?>
                            <h3><?php echo $officerCount; ?></h3>
                            <p>Officers</p>
                        </div>
                        <div class="icon">
                        <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <a href="manage-officers.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <?php 
                            // Count options
                            $sqlUsers = "SELECT COUNT(*) AS usersCount FROM users where role ='umuturage'";
                            $stmtUsers = $pdo->query($sqlUsers);
                            $usersCount = $stmtUsers->fetch(PDO::FETCH_ASSOC)['usersCount'];  
                            ?>
                            <h3><?php echo $usersCount; ?></h3>
                            <p>Citizens</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="manage-users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <?php 
                            $sqlAppointments = "SELECT COUNT(*) AS appointmentsCount FROM appointments";
                            $stmtAppointments = $pdo->query($sqlAppointments);
                            $appointmentsCount = $stmtAppointments->fetch(PDO::FETCH_ASSOC)['appointmentsCount']; 
                            ?>
                            <h3><?php echo $appointmentsCount; ?></h3>
                            <p>Appointments</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <a href="manage-appointments.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>    
    <?php
  } else if($role == 'officer'){
    ?>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php 
                            $sqlCount = "SELECT COUNT(*) AS appointmentCount FROM appointments inner join slots on slots.id = appointments.slotId WHERE slots.officerId = '$id'";
                            $stmtCount = $pdo->query($sqlCount);
                            $appointmentCount = $stmtCount->fetch(PDO::FETCH_ASSOC)['appointmentCount'];  
                            ?>
                            <h3><?php echo $appointmentCount; ?></h3>
                            <p>Appointments</p>
                        </div>
                        <div class="icon">
                        <i class="fa-solid fa-list-check"></i>
                        </div>
                        <a href="my-appointments.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <?php 
                            $sqlSlots = "SELECT COUNT(*) AS slotCount FROM slots where officerId = '$id'";
                            $stmtSlot = $pdo->query($sqlSlots);
                            $slotCount = $stmtSlot->fetch(PDO::FETCH_ASSOC)['slotCount'];  
                            ?>
                            <h3><?php echo $slotCount; ?></h3>
                            <p>Slots</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="my-slots.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>    
    <?php
  }else if($role =='umuturage'){
?>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <?php 
        
                            $sqlAppointments = "SELECT COUNT(*) AS appointmentsCount FROM appointments where citizenId = '$id'";
                            $stmtAppointments = $pdo->query($sqlAppointments);
                            $AppointmentsCount = $stmtAppointments->fetch(PDO::FETCH_ASSOC)['appointmentsCount']; 
                            ?>
                            <h3><?php echo $AppointmentsCount; ?></h3>
                            <p>My Appointments</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <a href="my-appointments.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
<?php
  } else{
    echo "nione";
  }    
?>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include "../includes/footer.php";
?>
