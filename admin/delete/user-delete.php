<?php
include "../../includes/conn.php";

if (isset($_GET['userId'])) {
    $userId = intval($_GET['userId']);
    
    try {
        // Begin a transaction
        $pdo->beginTransaction();

        // Check if user exists before deletion
        $checkUser = $pdo->prepare("SELECT * FROM users WHERE userId = ?");
        $checkUser->execute([$userId]);

        if ($checkUser->rowCount() > 0) {
            // Prepare the deletion statement
            $sql_users = "DELETE FROM users WHERE userId = ?";
            $stmt_users = $pdo->prepare($sql_users);
            $stmt_users->execute([$userId]);

            // Commit the transaction
            $pdo->commit();

            if ($stmt_users->rowCount() > 0) {
                header("Location: ../manage-users.php?message=User deleted successfully");
                exit;
            } else {
                header("Location: ../manage-users.php?error=No records found for deletion");
                exit;
            }
        } else {
            // User does not exist
            header("Location: ../manage-users.php?error=User not found");
            exit;
        }
    } catch (PDOException $e) {
        // Rollback the transaction in case of an error
        $pdo->rollBack();
        header("Location: ../manage-users.php?error=Failed to delete user: " . $e->getMessage());
        exit;
    }
} else {
    header("Location: ../manage-users.php?error=No userId specified");
    exit;
}
?>
