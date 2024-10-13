<?php
include "../../includes/conn.php"; 

if (isset($_GET['supervisorId'])) {
    $supervisorId = intval($_GET['supervisorId']);
    
    try {

        $sql1 = "DELETE FROM projects WHERE supervisorId = ?";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([$supervisorId]);

        $sql = "DELETE FROM supervisors WHERE supervisorId = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$supervisorId]);
        
        if ($stmt1->rowCount() > 0 || $stmt->rowCount() > 0) {
            header("Location: ../manageSuper.php?message=Supervisor deleted successfully");
            exit;
        } else {
            header("Location: ../manageSup.php?error=No supervisor found with that ID");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: ../manageSuper.php?error=Failed to delete supervisor: " . $e->getMessage());
        exit;
    }
} else {
    // Redirect if no supervisorId parameter is provided
    header("Location: ../manageSuper.php?error=No supervisorId specified");
    exit;
}
?>
