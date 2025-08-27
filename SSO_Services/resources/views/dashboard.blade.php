<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const allowedOrigins = [
            "http://serviceprovider1.local:8000",
        ];
        allowedOrigins.forEach(origin => {
            if(window.opener){
                window.opener.postMessage(
                    { type: "auth_token", token: "{{ auth()->user()->token->token }}" },
                    origin
                );
            }
            if (window.self !== window.top) {
                window.parent.postMessage(
                    { type: "auth_token", token: "{{ auth()->user()->token->token }}" },
                    origin
                );
            }
        })
        if(window.opener){
            window.close();
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            <div class="p-6 font-bold text-xl border-b">Dashboard</div>
            <nav class="mt-6">
                <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100 rounded">Home</a>
                <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100 rounded">Users</a>
                <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100 rounded">Settings</a>
                <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100 rounded">Reports</a>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col">

            <!-- Header -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Profile</button>
                    <form action="{{ route('logout') }}" method="post"> 
                        @csrf 
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" type="submit">Logout</button>
                    </form>
                </div>
            </header>

            <!-- Content area -->
            <main class="p-6 flex-1 overflow-y-auto">

                <!-- Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-6 rounded shadow">
                        <h2 class="text-gray-500 font-semibold">Users</h2>
                        <p class="text-2xl font-bold mt-2">1,245</p>
                    </div>
                    <div class="bg-white p-6 rounded shadow">
                        <h2 class="text-gray-500 font-semibold">Sales</h2>
                        <p class="text-2xl font-bold mt-2">$12,340</p>
                    </div>
                    <div class="bg-white p-6 rounded shadow">
                        <h2 class="text-gray-500 font-semibold">Revenue</h2>
                        <p class="text-2xl font-bold mt-2">$54,200</p>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white rounded shadow overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4">John Doe</td>
                                <td class="px-6 py-4">john@example.com</td>
                                <td class="px-6 py-4">Admin</td>
                                <td class="px-6 py-4">Active</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">Jane Smith</td>
                                <td class="px-6 py-4">jane@example.com</td>
                                <td class="px-6 py-4">Editor</td>
                                <td class="px-6 py-4">Inactive</td>
                            </tr>
                            <!-- Add more rows here -->
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>
</body>
</html>
