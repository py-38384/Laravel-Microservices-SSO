<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6">Login to Your Account</h2>

    <form id="loginForm" class="space-y-4" method="post"
      action="{{ route('login') }}{{ request()->filled('next') ? '?next=' . request()->query('next') : '' }}">
      <!-- Email -->
       @csrf
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input 
          type="email" 
          id="email" 
          name="email" 
          placeholder="you@example.com"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          value="{{ old('email') }}"
          required
        >
        @error('email')
        <span class="text-red-500">
            {{ $message }}
        </span>
        @enderror
        @error('login')
        <span class="text-red-500">
            {{ $message }}
        </span>
        @enderror
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input 
          type="password" 
          id="password" 
          name="password" 
          placeholder="********"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          required
        >
        @error('password')
        <span class="text-red-500">
            {{ $message }}
        </span>
        @enderror
      </div>

      <!-- Submit -->
      <button 
        type="submit"
        class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors"
      >
        Login
      </button>
    </form>

    <p class="text-sm text-gray-500 mt-4 text-center">
      Don't have an account? <a href="#" class="text-blue-600 hover:underline">Sign up</a>
    </p>
  </div>
</body>
</html>
