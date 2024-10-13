<?php
session_start();
include_once "includes/conn.php";
if(!isset($_SESSION['username'])){
    header("location:./index2.php");
  }else{
    $admin = $_SESSION['username'];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>library</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <style>
        body {
         background-color: #ddded1;         
        }
        .navbar {
            background-color: #0073e6;
        }
        .navbar-brand img {
            width: 90px;
            height: auto;
        }

        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-top:13rem;
        }
        img {
            border-radius: 5px;
            box-shadow: #333;
        }
        span {
            color: red;
        }
        h1 {
            font-size:22px;
        }
        .desc {
            display:block;
        }
        .btn-outline-warning{
            border:1px solid darkorange;
        }
        .btn-outline-warning:hover{
            background-color:darkorange;
        }
        
    </style>
</head>
<body>
    
    <!-- Navbar -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="/mkul/home"><img src="./dist/img/Capture.png" alt="pvms Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <h1><marquee>MOUNT KIGALI UNIVERSITY LIBRARY</marquee></h1>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item mr-2">
                <a href="/mkul/home" class="btn btn-outline-warning">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            <!-- User Icon Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i> <span class="text-white"><?= htmlspecialchars($admin) ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="./change-password.php">Change Password</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="./admin/logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

    
<header>
        <div class="container-fluid">
            <div class="row mx-3 mt-4 desc" id="desc">
                    <!-- Show the search form only if no search has been performed -->
                    <?php if (!isset($_POST['Search'])): ?>
                        <div class="col">
                    <h1>From this page you can:</h1>
                    <p>Search the database using one or more keywords (title, author, Supervisor, Department, ...).</p>                        
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="">Search by:</label>
                                <select name="search_field" id="search_field" class="form-control col-3">
                                    <option value="all">All fields</option>
                                    <option value="projectName">Project name</option>
                                    <option value="pagination">Pagination</option>
                                    <option value="author">Author</option>
                                    <option value="supervisorName">Supervisor</option>
                                    <option value="departmentName">Department</option>
                                    <option value="optionName">Option</option>
                                    <option value="yearr">Published date</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <input type="text" required name="search_query" class="form-control col-5" placeholder="Search project">
                                <button type="submit" name="Search" class="btn btn-primary ml-2">Search</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mx-3">
                <div class="col">
                <?php 
                    $search_field = '';
                    $search_query = '';
                    $projects = [];
                    if (isset($_POST['Search'])) {
                        $search_field = $_POST["search_field"];
                        $search_query = $_POST["search_query"];

                        $sql = "SELECT projects.*, options.optionName, departments.departmentName, supervisors.supervisorName
                                FROM projects 
                                JOIN options ON projects.optionId = options.optionId 
                                JOIN departments ON options.departmentId = departments.departmentId
                                JOIN supervisors ON projects.supervisorId = supervisors.supervisorId";

                        if (!empty($search_field) && $search_field != "all") {
                            $sql .= " WHERE $search_field LIKE ?";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(["%$search_query%"]);
                        } else if ($search_field == "all") {
                            $sql .= " WHERE projectName LIKE ? OR pagination LIKE ? OR author LIKE ? OR supervisorName LIKE ? OR departmentName LIKE ? OR optionName LIKE ? OR yearr LIKE ?";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(["%$search_query%", "%$search_query%", "%$search_query%", "%$search_query%", "%$search_query%", "%$search_query%", "%$search_query%"]);
                        } else {
                            $stmt = $pdo->query($sql);
                        }

                        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $total_projects = $stmt->rowCount();
                        if (!empty($projects)) {
                            if ($search_field == "all") {
                                $search_field = "Result";
                            }
                ?>
                        <h1 class="mt-3">Search results</h1>
                        <hr class="bg-primary">
                        <p class="mt-2 text-primary"><?= $total_projects ?> <?= $search_field ?>(s) found for '<?= htmlspecialchars($search_query) ?>'</p>
                        <?php foreach ($projects as $project): ?>
                            <div class="">
                                <i class="fa fa-plus mr-1 toggle-details text-primary" data-toggle="collapse" data-target="#details-<?= $project['projectId'] ?>" aria-expanded="true" aria-controls="details-<?= $project['projectId'] ?>">
                                </i><span class="text-dark"><?= htmlspecialchars($project['projectName']) ?> / <?= htmlspecialchars($project['author']) ?></span>
                            </div>
                            <div id="details-<?= $project['projectId'] ?>" class="collapse mb-2 mt-2">
                                <div class="ml-5">
                                    <strong>Pagination:</strong> <?= htmlspecialchars($project['pagination']) ?><br>
                                    <strong>Author:</strong> <?= htmlspecialchars($project['author']) ?><br>
                                    <strong>Supervisor:</strong> <?= htmlspecialchars($project['supervisorName']) ?><br>
                                    <strong>Department:</strong> <?= htmlspecialchars($project['departmentName']) ?><br>
                                    <strong>Option:</strong> <?= htmlspecialchars($project['optionName']) ?><br>
                                    <strong>Published Date:</strong> <?= htmlspecialchars($project['createdAt']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                <?php
                    } else {
                ?>
                    <p class="mt-4">No projects found for '<span class="text-primary"><?= htmlspecialchars($search_query) ?></span>'.</p>
                <?php
                    }
                }                    
                ?>
                </div>
            </div>
        </div>
    </header>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

