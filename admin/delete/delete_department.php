<?php
include "../../includes/conn.php"; // Assuming this file includes database connection
if (isset($_GET['departmentId'])) {
    $departmentId = intval($_GET['departmentId']);
    try {
        $pdo->beginTransaction();
        // Delete from supervisors table
        $sql_supervisors = "DELETE FROM supervisors WHERE departmentId = ?";
        $stmt_supervisors = $pdo->prepare($sql_supervisors);
        $stmt_supervisors->execute([$departmentId]);

        // Delete from options table
        $sql_options = "DELETE FROM options WHERE departmentId = ?";
        $stmt_options = $pdo->prepare($sql_options);
        $stmt_options->execute([$departmentId]);

        $sql_departments = "DELETE FROM departments WHERE departmentId = ?";
        $stmt_departments = $pdo->prepare($sql_departments);
        $stmt_departments->execute([$departmentId]);
        // Commit the transaction if all deletions were successful
        $pdo->commit();
        // Check if any row was affected in any table
        if ($stmt_departments->rowCount() > 0 || $stmt_options->rowCount() > 0 || $stmt_supervisors->rowCount() > 0) {
            header("Location: ../manageDepart.php?message=Records deleted successfully");
            exit;
        } else {
            header("Location: ../manageDepart.php?error=No records found for deletion");
            exit;
        }
    } catch (PDOException $e) {
        // Rollback the transaction if an error occurred
        $pdo->rollBack();
        header("Location: ../manageDepart.php?error=Failed to delete records: " . $e->getMessage());
        exit;
    }
} else {
    header("Location: ../manageDepart.php?error=No departmentId specified");
    exit;
}
?>
