<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['original_url'])) {
    $original_url = trim($_POST['original_url']);

    // Ensure the URL starts with http:// or https://
    if (!preg_match("/^https?:\/\//", $original_url)) {
        $original_url = "https://" . $original_url;
    }

    // Validate URL format
    if (!filter_var($original_url, FILTER_VALIDATE_URL)) {
        echo json_encode(["error" => "Invalid URL format"]);
        exit;
    }

    // Generate a unique short code (6-character random string)
    $short_code = substr(bin2hex(random_bytes(3)), 0, 6);

    // Insert into database
    $query = "INSERT INTO urls (original_url, short_code, created_at, click_count) VALUES (?, ?, NOW(), 0)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(["error" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("ss", $original_url, $short_code);
    
    if ($stmt->execute()) {
        echo json_encode(["shortened_url" => "http://localhost/url-shortner/redirect.php?code=" . $short_code]);
    } else {
        echo json_encode(["error" => "Failed to shorten URL"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
