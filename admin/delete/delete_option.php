<?php
include "../../includes/conn.php";

if (isset($_GET['optionId'])) {
    $optionId = intval($_GET['optionId']);
    
    try {
        $pdo->beginTransaction();
        $sql_projects = "DELETE FROM projects WHERE optionId = ?";
        $stmt_projects = $pdo->prepare($sql_projects);
        $stmt_projects->execute([$optionId]);

        $sql_options = "DELETE FROM options WHERE optionId = ?";
        $stmt_options = $pdo->prepare($sql_options);
        $stmt_options->execute([$optionId]);

        $pdo->commit();

        if ($stmt_projects->rowCount() > 0 || $stmt_options->rowCount() > 0) {
            header("Location: ../manageOpt.php?message=Records deleted successfully");
            exit;
        } else {
            header("Location: ../manageOpt.php?error=No records found for deletion");
            exit;
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        header("Location: ../manageOpt.php?error=Failed to delete records: " . $e->getMessage());
        exit;
    }
} else {
    header("Location: ../manageOpt.php?error=No optionId specified");
    exit;
}
?>
