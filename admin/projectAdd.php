<?php 
include "../includes/header.php";
$sql1 = "SELECT * FROM supervisors";
$stmt1 = $pdo->query($sql1);
$supervisors = $stmt1->fetchAll();

$sql2 = "SELECT * FROM options";
$stmt2 = $pdo->query($sql2);
$options = $stmt2->fetchAll();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 px-4">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Projects</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Add Project</li>
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
                  <h3 class="card-title">Project Details</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method = "POST">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                    <div class="form-group">
                      <label>Choose option</label>
                      <select class="form-control" name="optionId" required>
                              <?php foreach ($options as $option): ?>
                                <option value="<?php echo $option['optionId']; ?>"><?php echo htmlspecialchars($option['optionName']); ?></option>
                              <?php endforeach; ?>
                      </select>
                    </div>                                         
                    <div class="form-group">
                        <label>Project Name</label>
                        <input type="text" class="form-control" placeholder="Enter project name" required name="projectName">
                    </div>
                    <div class="form-group">
                        <label>Number of pages</label>
                        <input type="number" class="form-control" placeholder="Enter number of pages" required name = "pagination">
                    </div>                     
                      </div>
                      <div class="col-md-6">
                    <div class="form-group">
                        <label>Project Author</label>
                        <input type="text" class="form-control" placeholder="Enter project author" required name="author">
                    </div>  
                    <div class="form-group">
                    <label>Supervised By</label>
                    <select class="form-control" name="supervisor" required>
                              <?php foreach ($supervisors as $supervisor): ?>
                                <option value="<?php echo $supervisor['supervisorId']; ?>"><?php echo htmlspecialchars($supervisor['supervisorName']); ?></option>
                              <?php endforeach; ?>
                      </select>                                            
                      </div>                      
                    </div>
                    </div>                                       
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name="add">ADD</button>
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
 if (isset($_POST['add'])) {
  $option = $_POST["optionId"];
  $project_name = $_POST["projectName"];
  $num_pages = $_POST["pagination"];
  $project_author = $_POST["author"];
  $supervised_by = $_POST["supervisor"];
  $year = date("Y");

  // Prepare an insert statement
  $sql = "INSERT INTO projects (projectName, pagination, author, supervisorId, optionId, yearr,createdBy) 
          VALUES (:project_name, :num_pages, :project_author, :supervised_by, :option, :year,:createdBy)";

  // Prepare the statement
  $stmt = $pdo->prepare($sql);

  // Bind parameters
  $stmt->bindParam(':project_name', $project_name);
  $stmt->bindParam(':num_pages', $num_pages);
  $stmt->bindParam(':project_author', $project_author);
  $stmt->bindParam(':supervised_by', $supervised_by);
  $stmt->bindParam(':option', $option);
  $stmt->bindParam(':year', $year);
  $stmt->bindParam(':createdBy', $id);

  // Execute the statement
  if ($stmt->execute()) {
    echo "<script>
    alert('Project Added!')
    </script>";
  } else {
      echo "Error: " . $sql . "<br>" . $stmt->errorInfo()[2];
  }
}
 ?>