<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Jussimatic</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">Welcome to Jussimatic</h1>
        <p class="mb-6 text-gray-700 dark:text-gray-300">Thank you for registering. We're excited to have you on board.</p>
        
        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Your account details</h2>
            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
                <li>Your username is <span class="font-semibold text-gray-900 dark:text-white">{{ $email }}</span></li>
                <li>Your password is <span class="font-semibold text-gray-900 dark:text-white">{{ $plainPassword }}</span></li>
            </ul>
        </div>
    </div>
</body>
</html>
