<?php
// The API URL to create a new user
$apiUrl = 'http://localhost/api/users';

// Initialize variables
$message = null;
$error = null;

// Check if the form is submitted
if (isset($_POST['name'], $_POST['email'], $_POST['age'])) {
    // Prepare the data to be sent
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'age' => (int)$_POST['age']
    ];

    // JSON encode the data
    $dataJson = json_encode($data);

    // Set HTTP context with POST method and content
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json' . "\r\n" .
                        'Content-Length: ' . strlen($dataJson) . "\r\n",
            'content' => $dataJson
        ]
    ]);

    // Use file_get_contents to send the POST request
    $response = @file_get_contents($apiUrl, false, $context);

    // Check if the response is valid
    if ($response !== false) {
        $result = json_decode($response, true);

        // Check for success message from API
        if (isset($result['message'])) {
            $message = "User created successfully.";
        } else {
            $error = "Failed to create user.";
        }
    } else {
        $error = "Could not connect to the API!";
    }
} else {
    $error = "Please fill out all fields!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
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
        input[type="text"], input[type="email"], input[type="number"] {
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
        <h2>Create User</h2>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <button type="submit">Create User</button>
        </form>
        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php elseif ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
