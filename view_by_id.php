<?php
// The API URL to fetch user data by ID
$apiUrl = 'http://localhost/api/users/';

// Initialize variables
$user = null;
$error = null;

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $url = $apiUrl . $id;

    // Use file_get_contents to get data from the API
    $response = @file_get_contents($url);

    // Check if the response is valid
    if ($response !== false) {
        // Decode the JSON response to an associative array
        $user = json_decode($response, true);

        // Check if user is not found (API returns null or an error message)
        if (is_null($user) || isset($user['message'])) {
            $error = "User not found!";
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
    <title>View User by ID</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Details</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php elseif ($user): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><?php echo htmlspecialchars($user['age']); ?></td>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
