<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Appointment Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #333333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #444444;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .delete-btn {
            background-color: #ff4d4d;
        }

        .delete-btn:hover {
            background-color: #cc0000;
        }

        .warning {
            color: #ff4d4d;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter Appointment Details</h2>
        <form action="save_appointment.php" method="POST">
            <input type="hidden" name="RequestID" value="<?php echo $requestID; ?>">

            <label for="date">Appointment Date (YYYY-MM-DD):</label>
            <input type="text" name="date" id="date" required>

            <label for="cost">Cost ($):</label>
            <input type="text" name="cost" id="cost" required>

            <label for="description">Description:</label>
            <input type="text" name="desc" id="description" required>

            <button type="submit">Save Appointment</button>
        </form>

        <h2>Delete Request</h2>
        <p class="warning">Deleting is permanent and cannot be undone!</p>
        <form action="delete_request.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this request?');">
            <input type="hidden" name="RequestID" value="<?php echo $requestID; ?>">
            <button type="submit" class="delete-btn">Delete Request</button>
        </form>
    </div>
</body>
</html>
