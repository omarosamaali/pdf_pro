<x-user>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="min-h-[73vh] md:min-h-0 flex-1 mt-40 md:mt-0">
        <h1 class="text-5xl font-extrabold text-gray-900 text-center">PDF Pro</h1>
        <h5 class="text-2xl font-bold text-gray-800 my-3 text-center">Create your account</h5>

        <form class="max-w-md mx-auto" method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-text-input id="name" placeholder="Name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-text-input placeholder="Email" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-text-input placeholder="********" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-text-input placeholder="********" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center mt-4 flex-col justify-center">
                <x-primary-button class="my-5">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
        <div class="text-center">
            <span>Already have an account?</span>
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Log in') }}
            </a>
        </div>
    </div>

    <div class="p-10 h-full flex flex-col justify-center bg-gray-100 w-full mt-5 md:mt-0 md:w-2/5 bg-cover bg-center">
        <img class="mx-auto max-w-[390px] max-h-[300px]" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/authentication/illustration.svg" alt="">
        <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900">PDF tools for productive people</h3>
        <p class="text-md mt-2 text-gray-700">PDF Pro helps you convert, edit, e-sign, and protect PDF files quickly and easily. Enjoy a full suite of tools to effectively manage documents —no matter where you’re working.</p>
    </div>

</x-user>

