<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <div class="flex h-full items-center">
    <main class="w-full max-w-md mx-auto p-6">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="p-4 sm:p-7">
          <div class="text-center">
            <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign in</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
              Don't have an account yet?
              <a class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/register">
                Sign up here
              </a>
            </p>
          </div>

          <hr class="my-5 border-slate-300">

          <!-- Form -->
          <form wire:submit.prevent="login">
            <div class="grid gap-y-4">
              <!-- Email -->
              <div>
                <label for="email" class="block text-sm mb-2 dark:text-white">Email address</label>
                <div class="relative">
                  <input wire:model.defer="email" type="email" id="email" name="email"
                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                    required>
                </div>
                @error('email')
                  <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>

              <!-- Password -->
              <div>
                <div class="flex justify-between items-center">
                  <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
                  <a class="text-sm text-blue-600 decoration-2 hover:underline font-medium" href="/forgot">Forgot password?</a>
                </div>
                <div class="relative">
                  <input wire:model.defer="password" type="password" id="password" name="password"
                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                    required>
                </div>
                @error('password')
                  <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>

              <!-- Submit -->
              <button type="submit"
                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                Sign in
              </button>
            </div>
          </form>
          <!-- End Form -->
        </div>
      </div>
    </main>
  </div>
</div>
