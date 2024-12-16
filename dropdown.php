<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Dropdown Value</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .form-container {
            background: white;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
        }
        .form-container h1 {
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            text-align: center;
            color: #333;
        }
        .form-container input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        @media (max-width: 600px) {
            .form-container {
                padding: 1.5rem;
            }
            .form-container h1 {
                font-size: 1.25rem;
            }
            .form-container input[type="text"], .form-container button {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Add Dropdown Value</h1>
        <form action="add_dropdown_value.php" method="post">
            <input type="text" name="dropdown_value" placeholder="New Dropdown Value" required>
            <button type="submit" name="add">Add</button>
        </form>
    </div>
</body>
</html>
