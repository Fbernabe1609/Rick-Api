<x-guest-layout>
    <div class="flex items-center justify-center">
        <div class="flex bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="w-full p-10">
                <div class="text-center mb-5">
                    <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-100">Welcome</h2>
                    <p class="text-gray-500 dark:text-gray-400">Please login or register to continue</p>
                </div>
                <div class="mb-4">
                    <ul class="flex border-b border-gray-300 dark:border-gray-700">
                        <li class="-mb-px mr-1">
                            <span
                                class="inline-block border-l border-t border-r rounded-t py-2 px-4 text-blue-700 dark:text-blue-500 font-semibold hover:cursor-pointer"
                                id="login-tab">Login</span>
                        </li>
                        <li class="mr-1">
                            <span
                                class="inline-block py-2 px-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 font-semibold hover:cursor-pointer"
                                id="register-tab">Register</span>
                        </li>
                    </ul>
                </div>
                <div id="form-container">

                    <!-- Login -->
                    <x-auth-session-status class="mb-4" :status="session('status')"/>
                    <form id="login-form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')"/>
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                          :value="old('email')" required autofocus autocomplete="username"/>
                            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')"/>

                            <x-text-input id="password" class="block mt-1 w-full"
                                          type="password"
                                          name="password"
                                          required autocomplete="current-password"/>

                            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                       class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                       name="remember">
                                <span
                                    class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                   href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-primary-button class="ms-3">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Register -->
                    <form id="register-form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')"/>
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                          :value="old('name')" required autofocus autocomplete="name"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')"/>
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                          :value="old('email')" required autocomplete="username"/>
                            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')"/>

                            <x-text-input id="password" class="block mt-1 w-full"
                                          type="password"
                                          name="password"
                                          required autocomplete="new-password"/>

                            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

                            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                          type="password"
                                          name="password_confirmation" required autocomplete="new-password"/>

                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                               href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>

                            <x-primary-button class="ms-4">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('register-form').classList.add('hidden');

        document.getElementById('login-tab').addEventListener('click', function () {
            document.getElementById('login-form').classList.remove('hidden');
            document.getElementById('register-form').classList.add('hidden');
            this.classList.add('border-l', 'border-t', 'border-r', 'rounded-t', 'text-blue-700', 'dark:text-blue-500');
            this.classList.remove('text-gray-500', 'hover:text-gray-700', 'dark:text-gray-400', 'dark:hover:text-gray-300');
            document.getElementById('register-tab').classList.remove('border-l', 'border-t', 'border-r', 'rounded-t', 'text-blue-700', 'dark:text-blue-500');
            document.getElementById('register-tab').classList.add('text-gray-500', 'hover:text-gray-700', 'dark:text-gray-400', 'dark:hover:text-gray-300');
        });

        document.getElementById('register-tab').addEventListener('click', function () {
            document.getElementById('register-form').classList.remove('hidden');
            document.getElementById('login-form').classList.add('hidden');
            this.classList.add('border-l', 'border-t', 'border-r', 'rounded-t', 'text-blue-700', 'dark:text-blue-500');
            document.getElementById('login-tab').classList.remove('border-l', 'border-t', 'border-r', 'rounded-t', 'text-blue-700', 'dark:text-blue-500');
            document.getElementById('login-tab').classList.add('text-gray-500', 'hover:text-gray-700', 'dark:text-gray-400', 'dark:hover:text-gray-300');
            this.classList.remove('text-gray-500', 'hover:text-gray-700', 'dark:text-gray-400', 'dark:hover:text-gray-300');
        });
    </script>
</x-guest-layout>
