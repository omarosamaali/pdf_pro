<x-user>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="min-h-[73vh] md:min-h-0 flex-1 mt-40 md:mt-0">
        <h1 class="text-5xl font-extrabold text-gray-900 text-center">PDF Pro</h1>
        <h5 class="text-2xl font-bold text-gray-800 my-3 text-center">{{ __('messages.create_your_account') }}</h5>

        <form class="max-w-md mx-auto" method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-text-input id="name" placeholder="{{ __('messages.name') }}" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-text-input placeholder="{{ __('messages.email_placeholder') }}" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-text-input placeholder="{{ __('messages.password_placeholder') }}" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-text-input placeholder="{{ __('messages.confirm_password') }}" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center mt-4 flex-col justify-center">
                <x-primary-button class="my-5">
                    {{ __('messages.register_button') }}
                </x-primary-button>
            </div>
        </form>
        <div class="text-center">
            <span>{{ __('messages.already_have_account_question') }}</span>
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('messages.login_link') }}
            </a>
        </div>
    </div>

    <div class="p-10 h-full flex flex-col justify-center bg-gray-100 w-full mt-5 md:mt-0 md:w-2/5 bg-cover bg-center">
        <img class="mx-auto max-w-[390px] max-h-[300px]" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/authentication/illustration.svg" alt="">
        <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ __('messages.pdf_tools_for_productive_people') }}</h3>
        <p class="text-md mt-2 text-gray-700">{{ __('messages.pdf_tools_desc') }}</p>
    </div>

</x-user>
