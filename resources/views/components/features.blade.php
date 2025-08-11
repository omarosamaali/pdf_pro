<style>
    .img {
        object-fit: fill;
        width: 100%;
        height: 100%;
    }

</style>

<!-- Work Your Way Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto">
        <!-- Section Title -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Work Your Way</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Transform and edit your PDF files with ease using our advanced tools
            </p>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1: Convert -->
            <div class="border border-gray-200 bg-white rounded-xl hover:scale-[1.1] transition 
            shadow-lg overflow-hidden hover:shadow-xl duration-300">
                <div class="h-56 flex items-center justify-center">
                    <img class="img border-b" src="https://img.freepik.com/free-vector/hand-drawn-essay-illustration_23-2150268421.jpg?t=st=1754569228~exp=1754572828~hmac=47cec11f833321e7b036da53393a29120d1e597dca6e9cc09608c5652fa6c026&w=740" alt="">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">File Conversion</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Convert your files to and from PDF effortlessly. We support all major file formats including Word, Excel, PowerPoint, and images. Fast and secure conversion while maintaining content quality.
                    </p>
                </div>
            </div>

            <!-- Card 2: Edit -->
            <div class="border border-gray-200 bg-white rounded-xl hover:scale-[1.1] transition 
            shadow-lg overflow-hidden hover:shadow-xl duration-300">
                <div class="h-56  flex items-center justify-center">
                    <img class="img border-b" src="https://img.freepik.com/free-vector/hand-drawn-essay-illustration_23-2150268424.jpg?t=st=1754569228~exp=1754572828~hmac=424587a32bb12193de2bb6bb80f92dce47f3d4e03b0907c0210a977419b25656" alt="">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">PDF Editing</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Edit PDF content directly. Add text, images, and signatures. Merge multiple files, split pages, and rearrange them according to your needs with our powerful editing tools.
                    </p>
                </div>
            </div>

            <!-- Card 3: Optimize -->
            <div class="border border-gray-200 bg-white rounded-xl hover:scale-[1.1] transition 
            shadow-lg overflow-hidden hover:shadow-xl duration-300">
                <div class="h-56 flex items-center justify-center">
                    <img class="img border-b" src="https://img.freepik.com/free-vector/hand-drawn-glossary-illustration_23-2150268427.jpg?t=st=1754569228~exp=1754572828~hmac=2eeb4cc96fd0291932b7c08224de591969bfbf606b4c37fe26b58f0e34fc57e3" alt="">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Optimize & Compress</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Reduce PDF file size while maintaining quality. Optimize your files for web and print, add password protection and encryption to secure your important documents.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Premium Section -->
<section class="rounded-2xl px-4 md:px-8 py-12 md:py-16 bg-gradient-to-br from-[#fff3d6] to-[#e0c27b] relative overflow-hidden">

    <!-- Background Decorative Elements -->
    <div class="absolute top-10 right-20 w-32 h-32 bg-gradient-to-br from-orange-200 to-red-300 rounded-full opacity-20"></div>
    <div class="absolute bottom-20 left-10 w-24 h-24 bg-gradient-to-br from-yellow-200 to-orange-300 rounded-full opacity-15"></div>
    <div class="absolute top-32 right-1/3 w-16 h-16 bg-gradient-to-br from-red-200 to-pink-300 rounded-full opacity-25"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-6 text-left">
                        Get more with Premium
                    </h2>

                    <!-- Features List -->
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">
                                <i class="fa-solid fa-check text-green-700"></i>
                            </div>
                            <p class="text-gray-600 text-md font-medium text-left rtl:text-right">
                                Boost conversions significantly with advanced performance optimization tools
                            </p>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">
                                <i class="fa-solid fa-check text-green-700"></i>
                            </div>
                            <p class="text-gray-600 text-md font-medium text-left rtl:text-right">
                                Edit PDFs effortlessly with advanced OCR technology and request secure e-Signatures
                            </p>
                        </div>

                        <div class="flex space-x-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">
                                <i class="fa-solid fa-check-double text-green-700"></i>
                            </div>
                            <p class="text-gray-600 text-md font-medium text-left rtl:text-right">
                                Connect tools and create custom workflows to meet your needs
                            </p>
                        </div>
                    </div>

                </div>

                <!-- CTA Button -->
                <div>
                    @auth
                    <a href="{{ route('premium') }}" class="w-fit bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold px-8 py-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-2">
                        <span class="pl-1">Get Premium</span>
                        <i class="fa-solid fa-crown"></i>
                    </a>
                    @else
                    <a href="{{ route('register') }}" class="w-fit bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold px-8 py-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-2">
                        <span class="pl-1">Get Premium</span>
                        <i class="fa-solid fa-crown"></i>
                    </a>
                    @endauth

                </div>
            </div>


            <!-- Right Visual Content -->
            <div class="relative hidden md:block">
                <!-- Main Document Mockup -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 transform rotate-2 hover:rotate-0 transition-transform duration-300">
                    <!-- Document Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                        <div class="text-sm font-medium text-gray-500">Interior Design Project</div>
                    </div>

                    <!-- Document Title -->
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Brief Approval</h3>

                    <!-- Document Content Area -->
                    <div class="space-y-4">
                        <!-- Text Lines -->
                        <div class="space-y-2">
                            <div class="h-2 bg-gray-200 rounded w-full"></div>
                            <div class="h-2 bg-gray-200 rounded w-5/6"></div>
                            <div class="h-2 bg-gray-200 rounded w-4/5"></div>
                        </div>

                        <!-- Image Placeholder -->
                        <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg h-32 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>

                        <!-- More Text Lines -->
                        <div class="space-y-2">
                            <div class="h-2 bg-gray-200 rounded w-full"></div>
                            <div class="h-2 bg-gray-200 rounded w-3/4"></div>
                        </div>

                        <!-- Signature Area -->
                        <div class="border-t pt-4 mt-6">
                            <div class="flex justify-between items-end">
                                <div class="text-xs text-gray-500">Signature:</div>
                                <div class="w-24 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded opacity-20"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Elements -->
                <div class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl shadow-lg flex items-center justify-center transform rotate-12">
                    <span class="text-white font-bold text-sm">Aa</span>
                </div>

                <div class="absolute -bottom-2 -left-4 w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-full shadow-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Small Team Photo Mockup -->
                <div class="absolute bottom-8 right-12 w-20 h-12 bg-gradient-to-r from-gray-300 to-gray-400 rounded-lg shadow-md opacity-80"></div>
            </div>


        </div>
    </div>
</section>

<!-- Convert Section -->
<section class="py-16">
    <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
        <img class="w-full" src="https://www.ilovepdf.com/img/home/iloveimg.webp" alt="/ image">

        <div class="mt-4 md:mt-0 flex flex-col rtl:justify-start ltr:justify-end">
            <h2 class="text-left rtl:text-right mb-4 text-4xl tracking-tight font-extrabold text-gray-900">
                Transform Your PDF Workflow with Ease</h2>
            <p class="text-left rtl:text-right mb-6 font-light text-gray-500 md:text-lg ">
                Our platform empowers you to edit, convert, and manage PDFs effortlessly. From unlimited conversions to advanced OCR and secure e-Signatures, streamline your documents and boost productivity with tools designed for you.
            </p>
            <a href="{{ route('register') }}" class="w-fit inline-flex items-center text-white bg-black 
            hover:bg-black focus:ring-4 
            focus:ring-black font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Get started
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
</section>


<section>
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:px-6">
        <div class="max-w-lg-md mx-auto">
            <h2 class="mb-2 text-[24px] md:text-[42px] text-center justify-center tracking-tight font-extrabold text-[#33333b]">The PDF software trusted by millions of users.</h2>
            <p class="mb-3 font-normal text-gray-800 sm:text-xl">PDF Pro is your number one web app for editing PDF with ease. Enjoy all the tools you need to work efficiently with your digital documents while keeping your data safe and secure.</p>
        </div>
    </div>
</section>
