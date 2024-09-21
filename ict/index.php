<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iranprogrammer Modern Advertising</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .stats {
            background-color: transparent;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .dark-theme .stats {
            background-color: #2d3748;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    
    <?php
    $jsonData = file_get_contents('maindata.json');
    $data = json_decode($jsonData, true);

    $data['site_loads']++;

    file_put_contents('maindata.json', json_encode($data, JSON_PRETTY_PRINT));

    $theme = isset($_GET['theme']) ? $_GET['theme'] : 'light';
    ?>
    <div class="container mx-auto px-4 py-8 <?php echo $theme; ?>-theme">

        <h1 class="text-4xl font-bold mb-6 text-center text-gray-800 dark:text-white">Welcome to Iranprogrammer Modern Advertising</h1>
        <div class="stats">
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-2">Site Loads: <span class="font-semibold"><?php echo $data['site_loads']; ?></span></p>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-2">Codes: <span class="font-semibold"><?php echo $data['codes']; ?></span></p>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-2">Coins: <span class="font-semibold"><?php echo $data['coins']; ?></span></p>
        </div>

        <div class="button-container">
            <a href="./frontend/login.html" class="mr-4">
                <button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Sign In</button>
            </a>
            <a href="./frontend/signup.html">
                <button type="button" class="text-white bg-gradient-to-r from-green-500 via-green-600 to-green-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Sign Up</button>
            </a>
        </div>
    </div>
</body>
</html>