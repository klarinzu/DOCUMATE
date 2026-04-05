<div class="min-h-screen grid grid-cols-1 md:grid-cols-4">

    <!-- LEFT SIDE -->
    <div class="md:col-span-3 flex items-center justify-center p-10 bg-white">

        <div class="w-full max-w-md">

            <!-- LOGO -->
            <div class="flex justify-center mb-4">
                <img src="/images/favicon.png" class="w-14 h-14">
            </div>

            <!-- TITLE -->
            <h1 class="text-2xl font-bold text-center mb-6">
                Login to your account
            </h1>

            <form wire:submit.prevent="loginUser" class="space-y-4">

                <!-- LOGIN -->
                <div>
                    <label>Student Number or Email <span class="text-red-500">*</span></label>

                    <input 
                        wire:model.live="login"
                        placeholder="e.g. 202312345 or juan@gmail.com"
                        class="input
                        @error('login') border-red-500 @enderror
                        @if($login && !$errors->has('login')) border-green-500 @endif">

                    @error('login')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>


                <!-- PASSWORD -->
                <div x-data="{ show:false }">
                    <label>Password <span class="text-red-500">*</span></label>

                    <div class="relative">
                        <input 
                            :type="show ? 'text' : 'password'"
                            wire:model.live="password"
                            placeholder="Enter your password"
                            class="input pr-10
                            @error('password') border-red-500 @enderror
                            @if($password && !$errors->has('password')) border-green-500 @endif">

                        <!-- EYE ICON -->
                        <button type="button"
                            @click="show = !show"
                            class="absolute right-3 top-3 text-gray-500">

                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.1 6.1A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.207M15 12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m3-3v6" />
                            </svg>

                        </button>
                    </div>

                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>


                <!-- KEEP SIGNED IN -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" wire:model="remember" class="rounded">
                        Keep me signed in
                    </label>
                </div>


                <!-- LOGIN BUTTON -->
                <button 
                    type="submit"
                    class="w-full py-3 bg-[#2A57B4] hover:bg-blue-700 text-white rounded-xl transition">
                    Sign In
                </button>

            </form>

            <!-- DIVIDER -->
            <div class="flex items-center my-6">
                <div class="flex-grow h-px bg-gray-300"></div>
                <span class="mx-3 text-gray-500 text-sm">or</span>
                <div class="flex-grow h-px bg-gray-300"></div>
            </div>

            <!-- REGISTER BUTTON -->
            <a href="/register"
               class="block w-full text-center py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl transition">
                Create an account
            </a>

            <!-- TERMS -->
            <p class="mt-6 text-xs text-gray-500 text-center">
                By signing in you agree to our
                <a href="/terms" class="text-blue-600 hover:underline">Terms</a>
                and
                <a href="/policy" class="text-blue-600 hover:underline">Policy</a>.
            </p>

        </div>
    </div>


    <!-- RIGHT SIDE IMAGE -->
    <div class="hidden md:block md:col-span-1 bg-cover bg-center"
         style="background-image: url('/images/backdrop.jpg');">
    </div>

</div>