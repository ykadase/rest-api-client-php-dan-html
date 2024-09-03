<?php
// The API URL to delete a user
$apiUrl = 'http://localhost/api/users/';

// Initialize variables
$message = null;
$error = null;

// Check if ID is provided via POST
if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $url = $apiUrl . $id;

    // Set HTTP context with DELETE method
    $context = stream_context_create([
        'http' => [
            'method' => 'DELETE',
        ]
    ]);

    // Use file_get_contents to send the DELETE request
    $response = @file_get_contents($url, false, $context);

    // Check if the response is valid
    if ($response !== false) {
        $result = json_decode($response, true);

        // Check for success message from API
        if (isset($result['message'])) {
            $message = "User deleted successfully.";
        } else {
            $error = "Failed to delete user.";
        }
    } else {
        $error = "Could not connect to the API!";
    }
} else {
    $error = "No ID provided!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .container h2 {
            margin-bottom: 20px;
            font-size: 20px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"], input[type="number"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message, .error {
            text-align: center;
            margin-top: 20px;
        }
        .message {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete User</h2>
        <form method="POST" action="">
            <label for="id">User ID:</label>
            <input type="number" id="id" name="id" required>
            <button type="submit">Delete User</button>
        </form>
        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php elseif ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
