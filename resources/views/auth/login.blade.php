<x-user>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="min-h-[73vh] md:min-h-0 flex-1 mt-40 md:mt-0">
        <h1 class="text-5xl font-extrabold text-gray-900 text-center">PDF Pro</h1>
        <h5 class="text-2xl font-bold text-gray-800 my-3 text-center">{{ __('messages.login_to_your_account') }}</h5>

        <form class="max-w-md mx-auto" method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-text-input value="987omar123osama456@gmail.com" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="{{ __('messages.email_address') }}" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="{{ __('messages.password') }}" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('messages.remember_me') }}</span>
                </label>
            </div>

            <div class="flex items-center mt-4 flex-col justify-center">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('messages.forgot_password_question') }}
                </a>
                @endif

                <x-primary-button class="my-5">
                    {{ __('messages.log_in_button') }}
                </x-primary-button>
            </div>
        </form>
        <div class="text-center">
            <span>{{ __('messages.dont_have_account_question') }}</span>
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                {{ __('messages.create_an_account') }}
            </a>
        </div>
    </div>

    <div class="p-10 h-full flex flex-col justify-center bg-gray-100 w-full mt-5 md:mt-0 md:w-2/5 bg-cover bg-center">
        <img class="mx-auto max-w-[390px] max-h-[300px]" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/authentication/illustration.svg" alt="">
        <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ __('messages.login_to_your_workspace') }}</h3>
        <p class="text-md mt-2 text-gray-700">{{ __('messages.login_workspace_desc') }}</p>
    </div>
</x-user>
