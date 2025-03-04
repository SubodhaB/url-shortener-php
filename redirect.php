<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['code'])) {
    $short_code = trim($_GET['code']);

    // Sanitize input to prevent SQL injection
    $short_code = htmlspecialchars(strip_tags($short_code));

    // Prepare statement to get the original URL
    $query = "SELECT original_url FROM urls WHERE short_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $short_code);
    $stmt->execute();
    $stmt->bind_result($original_url);
    $stmt->fetch();
    $stmt->close();

    if (!empty($original_url)) {
        // Update click count
        $updateQuery = "UPDATE urls SET click_count = click_count + 1 WHERE short_code = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("s", $short_code);
        $updateStmt->execute();
        $updateStmt->close();

        // Redirect to the original URL
        header("Location: " . $original_url);
        exit;
    } else {
        echo "Invalid Short URL!";
    }
} else {
    echo "Invalid request!";
}
?>
