<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login - BbIarA</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="p-8 rounded-lg w-full max-w-md">
    <!-- Logo -->
    <div class="text-center mb-6">
      <img src="{{ asset('assets/logo-transparent.png') }}" alt="BbIarA Logo" class="w-48 mx-auto">
    </div>

    @auth
    <!-- Authenticated User Message -->
    <div class="text-center mb-6">
      <p class="text-lg font-medium text-gray-700">You are already logged in.</p>
      @if(Auth::user()->usertype == 'owner')
        <a href="{{ route('owner.dashboard.index') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#005281] hover:bg-[#153c53] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Go to Dashboard
        </a>
      @elseif(Auth::user()->usertype == 'karyawan')
        <a href="{{ route('karyawan.cashier.index') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#005281] hover:bg-[#153c53] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Go to Cashier
        </a>
      @elseif(Auth::user()->usertype == 'inventaris')
        <a href="{{ route('inventaris.stock.index') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#005281] hover:bg-[#153c53] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Go to Stock Management
        </a>
      @endif
    </div>
    @else
    <!-- Session Status -->
    @if (session('status'))
      <div class="mb-4 text-sm font-medium text-green-600">
        {{ session('status') }}
      </div>
    @endif

    <!-- Form -->
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
      @csrf

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email*</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" 
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
               required autofocus>
        @error('email')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password*</label>
        <input type="password" id="password" name="password" placeholder="minimum 8 characters" 
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
               required>
        @error('password')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Remember me and Forgot password -->
      <div class="flex items-center justify-between">
        <label class="flex items-center">
          <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
          <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
        @endif
      </div>

      <!-- Submit Button -->
      <div>
        <button type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#005281] hover:bg-[#153c53] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Login
        </button>
      </div>
    </form>
    @endauth
  </div>
</body>
</html>