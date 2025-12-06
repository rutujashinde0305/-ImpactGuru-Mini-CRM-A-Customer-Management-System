<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ImpactGuru CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #0f172a; /* dark navy */
        }
        .card {
            background-color: #1e293b; 
            border-radius: 12px;
        }
        .text-light {
            color: #e2e8f0;
        }
    </style>
</head>

<body class="text-gray-200">

    <!-- NAVBAR -->
    <nav class="w-full bg-[#1e293b] px-10 py-5 flex justify-between items-center shadow">
        <h1 class="text-2xl font-bold text-blue-400">ImpactGuru CRM</h1>

        <div class="space-x-4">
            <a href="/login" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Login</a>
            <a href="/register" class="px-4 py-2 border border-blue-400 text-blue-400 rounded-lg hover:bg-blue-500 hover:text-white">
                Register
            </a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="text-center mt-24 px-10">
        <h2 class="text-5xl font-bold text-light">Welcome to ImpactGuru CRM</h2>
        <p class="text-gray-400 mt-4 text-lg max-w-2xl mx-auto">
            A modern and powerful CRM system to manage customers, orders, staff workflows, 
            and exports — built with Laravel & Tailwind.
        </p>

        <div class="mt-10">
            <a href="/login" class="px-6 py-3 bg-blue-600 text-white rounded-lg text-lg hover:bg-blue-700">
                Get Started
            </a>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto mt-24 px-10">

        <div class="card p-6 shadow">
            <h3 class="text-xl font-semibold text-blue-300">Customer Management</h3>
            <p class="text-gray-400 mt-2">
                Add, edit, update and export customers using a clean and modern interface.
            </p>
        </div>

        <div class="card p-6 shadow">
            <h3 class="text-xl font-semibold text-green-300">Order Tracking</h3>
            <p class="text-gray-400 mt-2">
                Track customer orders with email alerts, status updates, and quick actions.
            </p>
        </div>

        <div class="card p-6 shadow">
            <h3 class="text-xl font-semibold text-purple-300">Role-Based Access</h3>
            <p class="text-gray-400 mt-2">
                Admin and Staff dashboards with permissions, restricting data deletion.
            </p>
        </div>

    </section>

    <!-- FOOTER -->
    <footer class="text-center text-gray-500 mt-24 py-10">
        © 2025 ImpactGuru CRM — Built for Internship Project.
    </footer>

</body>

</html>
