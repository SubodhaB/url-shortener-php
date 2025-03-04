<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Simple URL Shortener</h2>
        <form id="shortenForm">
            <input type="text" id="original_url" placeholder="Enter your URL here" required>
            <button type="submit">Shorten</button>
        </form>
        <p id="shortenedUrl"></p>
    </div>

    <script>
        document.getElementById('shortenForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let original_url = document.getElementById('original_url').value;

            fetch('shorten.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'original_url=' + encodeURIComponent(original_url)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('shortenedUrl').innerHTML = 'Shortened URL: <a href="' + data.shortened_url + '">' + data.shortened_url + '</a>';
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
