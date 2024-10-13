<?php
include "../../includes/conn.php"; 

if (isset($_GET['projectId'])) {
    $projectId = intval($_GET['projectId']);
    
    try {
        $sql = "DELETE FROM projects WHERE projectId = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$projectId]);
        
        if ($stmt->rowCount() > 0) {
            header("Location: ../manageProject.php?message=Project deleted successfully");
            exit;
        } else {
            header("Location: ../manageProject.php?error=No project found with that ID");
            exit;
        }
    } catch (PDOException $e) {
        // Handle database error
        header("Location: ../manageProject.php?error=Failed to delete project: " . $e->getMessage());
        exit;
    }
} else {
    // Redirect if no projectId parameter is provided
    header("Location: ../manageProject.php?error=No projectId specified");
    exit;
}
?>
