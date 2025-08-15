<style>
    .floating-particle {
        position: fixed;
        border-radius: 50%;
        animation: floatParticle 8s ease-in-out infinite;
        width: 500px !important;
        height: 500px !important;
        top: 55px;
        right: -231px;
        background: #0c9a0c17;
    }

    .floating-particle-left {
        position: absolute;
        border-radius: 0px !important;
        animation: floatParticle 4s ease-in-out infinite;
        width: 50px !important;
        height: 39px !important;
        top: 91px;
        rotate: 16deg;
        left: 43px;
        background: #0c9a0c0a;

    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @keyframes floatParticle {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }

        100% {
            transform: translateY(0);
        }
    }


    .page-title p {
        color: #a0a0a0;
        font-size: 1.2rem;
    }

    .tabs-container {
        position: relative;
        margin-bottom: 30px;
    }

    .tabs-nav {
        display: flex;
        justify-content: center;
        border-radius: 20px;
        width: fit-content;
        margin: auto;
        padding: 8px;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
        flex-wrap: wrap;
        gap: 15px;
    }

    .svg {
        justify-content: center;
        margin: auto;
        margin-bottom: 13px;
    }

    .tab-item {
        background: #fffffffa;
        padding: 3px 20px;
        border-radius: 15px;
        color: #4b4b4b;
        border: 1px solid #d6d6df;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
        min-width: fit-content;
        justify-content: center;
    }

    .tab-item:hover {
        border: 1px solid #333333;
    }

    .tab-item.active {
        background: #0F0F23;
        font-weight: 700;
        color: white;
    }

    .tab-icon {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .tab-item:hover .tab-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .tab-item.active .tab-icon {
        transform: rotate(0deg) scale(1.2);
    }

    .tabs-content {
        position: relative;
    }

    .tab-panel {
        display: none;
        animation: fadeInUp 0.5s ease-out;
        border-radius: 20px;
        padding: 0px 0px;
        border: 1px solid rgba(0, 255, 150, 0.1);
        min-height: 400px;
    }

    .tab-panel.active {
        display: block;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .panel-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .panel-header h2 {
        font-size: 2.5rem;
        color: #00ff96;
        margin-bottom: 10px;
        text-shadow: 0 0 10px rgba(0, 255, 150, 0.3);
    }

    .panel-header p {
        color: #ffffff;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .content-card {
        background: rgba(255, 255, 255, 0.6);
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #d6d6df;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .content-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 20, 147, 0.1), transparent);
        transition: left 0.8s ease;
    }

    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 255, 150, 0.2);
        border-color: #ff1493;
    }

    .content-card:hover::before {
        left: 100%;
    }

    .card-icon {
        font-size: 2.5rem;
        color: #00bfff;
        margin-bottom: 15px;
        display: block;
    }

    .card-title {
        color: #33333b;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .card-description {
        color: #a0a0a0;
        line-height: 1.5;
    }

    .special-effect {
        position: relative;
    }

    .special-effect::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: radial-gradient(circle, rgba(0, 255, 150, 0.3), transparent);
        transform: translate(-50%, -50%);
        transition: all 0.6s ease;
        border-radius: 50%;
    }

    .special-effect:hover::after {
        width: 200px;
        height: 200px;
    }

    @media (max-width: 768px) {
        .tabs-nav {
            flex-direction: column;
            gap: 8px;
        }

        .tab-item {
            width: 100%;
            min-width: unset;
        }

        .page-title h1 {
            font-size: 2rem;
        }

        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    .banners-section {
        display: flex;
        gap: 20px;
        margin: 30px 0;
        justify-content: center;
        flex-wrap: wrap;
    }

    .banner-item {
        flex: 1;
        min-width: 250px;
        max-width: 320px;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .banner-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .banner-image {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s ease;
    }

    .banner-item:hover .banner-image {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .banners-section {
            flex-direction: column;
            gap: 15px;
        }

        .banner-item {
            max-width: 100%;
            min-width: unset;
        }
    }

</style>

<section>
    <div class="floating-particle"></div>
    <div class="floating-particle-left"></div>

    <div class="mx-auto">
        <div class="tabs-container">
            <div class="tabs-nav">
                <button class="tab-item active" data-tab="all">
                    <span>{{ __('messages.all') }}</span>
                </button>
                <button class="tab-item" data-tab="convert">
                    <span>{{ __('messages.convert_pdf') }}</span>
                </button>
                <button class="tab-item" data-tab="edit">
                    <span>{{ __('messages.edit_pdf') }}</span>
                </button>
            </div>

            <div>
                <div class="banners-section">
                    @foreach ($banners as $banner)
                    <div class="banner-item" style="width:300px; height:250px; margin: auto;">
                        @if($banner->type === 'adsense')
                        @else
                        <a href="{{ $banner->url }}">
                            @if($banner->isVideo())
                            <video width="300" height="250" style="object-fit: cover; height: 100%;    margin: auto; " controls>
                                <source src="{{ $banner->file_url }}" type="video/{{ $banner->file_type }}">
                            </video>
                            @else
                            <img src="{{ $banner->file_url }}" alt="البانر" width="300" height="250" style=" width: 100%;    margin: auto; height: 100%; object-fit: cover;">
                            @endif
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="tabs-content">
                    <div class="tab-panel active" id="all">
                        <div class="content-grid">
                            <a href="{{ route('pdf_to_jpg') }}" class="content-card special-effect glow-effect">
                                <span class="card-icon">
                                    <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#FBEFA8" fill-rule="evenodd" d="M32.324 15.656h-9.55c-2.477 0-3.375.258-4.28.742a5.06 5.06 0 0 0-2.098 2.102c-.484.902-.742 1.8-.742 4.277v9.55H5.18c-1.8 0-2.453-.187-3.113-.54A3.7 3.7 0 0 1 .54 30.26C.188 29.598 0 28.945 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.7 3.7 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54a3.7 3.7 0 0 1 1.527 1.527c.352.66.54 1.313.54 3.113zm0 0">
                                        </path>
                                        <path fill="#B7A001" d="M14.477 7.52c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844L7.566 6.316a.89.89 0 0 0-1.246 0c-.168.16-.258.38-.258.61s.1.453.258.613l5.145 5.05H7.55c-.488 0-.883.387-.883.867s.395.863.883.863h6.047a.85.85 0 0 0 .34-.066.86.86 0 0 0 .477-.47.74.74 0 0 0 .066-.328l.004-5.934zm0 0">
                                        </path>
                                        <g fill-rule="evenodd">
                                            <path fill="#D6BF2D" d="M22.855 17.676H44.82c1.8 0 2.453.188 3.113.543a3.67 3.67 0 0 1 1.527 1.527c.352.656.54 1.31.54 3.11V44.82c0 1.8-.187 2.453-.54 3.113a3.7 3.7 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54a3.7 3.7 0 0 1-1.527-1.527c-.352-.66-.54-1.312-.54-3.113V22.855c0-1.8.188-2.453.54-3.113.348-.648.88-1.18 1.527-1.527.66-.352 1.313-.54 3.113-.54zm0 0">
                                            </path>
                                            <path fill="#FFF" d="M41.5 26c1.102 0 2 .898 2 2s-.898 2-2 2-2-.898-2-2 .898-2 2-2M30.6 39h-6.344c-.1 0-.172-.047-.215-.125s-.043-.168.004-.242l6.574-11.02a.26.26 0 0 1 .426 0l3.832 6.422 2.57-2.625a.24.24 0 0 1 .176-.074h.008c.07 0 .137.03.18.086l6.1 7.13c.07.043.11.12.11.203a.246.246 0 0 1-.246.242H30.6v-.004zm0 0">
                                            </path>
                                        </g>
                                    </svg>
                                </span>
                                <h3 class="card-title">{{ __('messages.convert_to_jpg') }}</h3>
                                <p class="card-description">{{ __('messages.convert_to_jpg_desc') }}</p>
                            </a>
                            <a href="{{ route('pdf_to_word') }}" class="content-card special-effect">
                                <span class="card-icon">
                                    <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#DCE5FA" fill-rule="evenodd" d="M32.324 15.656h-9.547c-2.477 0-3.375.258-4.28.742a5.04 5.04 0 0 0-2.098 2.102c-.484.902-.742 1.8-.742 4.277v9.547H5.18c-1.8 0-2.45-.187-3.113-.54A3.7 3.7 0 0 1 .54 30.257c-.352-.66-.54-1.31-.54-3.113V5.18c0-1.8.188-2.45.54-3.113S1.4.89 2.066.54 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54a3.7 3.7 0 0 1 1.527 1.527c.352.66.54 1.313.54 3.113zm0 0">
                                        </path>
                                        <path fill="#295795" d="M14.477 7.52a.88.88 0 0 0-.883-.867c-.48 0-.883.39-.883.867v3.844L7.566 6.316a.89.89 0 0 0-1.246 0c-.168.16-.258.38-.258.61s.1.453.258.613l5.145 5.05H7.547c-.488 0-.883.387-.883.863s.398.867.883.867h6.055a.9.9 0 0 0 .336-.066.86.86 0 0 0 .477-.47.74.74 0 0 0 .066-.328l.004-5.938zm0 0">
                                        </path>
                                        <path fill="#5F83C6" fill-rule="evenodd" d="M22.855 17.676H44.82c1.8 0 2.45.188 3.113.543a3.7 3.7 0 0 1 1.527 1.523c.352.66.54 1.313.54 3.113V44.82c0 1.8-.187 2.45-.54 3.113s-.867 1.176-1.527 1.527-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54a3.7 3.7 0 0 1-1.527-1.527c-.352-.66-.54-1.312-.54-3.113V22.855c0-1.8.188-2.453.54-3.113.348-.648.88-1.18 1.527-1.527.66-.352 1.313-.54 3.113-.54zm0 0">
                                        </path>
                                        <path fill="#FFF" d="M38.996 26.75h2.965l-2.94 14.64h-3.094l-1.777-9.035-1.824 9.035H29.12L26.2 26.75h3.164l1.508 9.363 1.938-9.363h3.004l1.727 9.297zm0 0">
                                        </path>
                                    </svg>
                                </span>
                                <h3 class="card-title">{{ __('messages.convert_to_word') }}</h3>
                                <p class="card-description">{{ __('messages.convert_to_word_desc') }}.</p>
                            </a>
                            <a href="{{ route('pdf_to_powerpoint') }}" class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#F3D9CC" fill-rule="evenodd" d="M32.324 15.656h-9.55c-2.477 0-3.375.258-4.28.742a5.06 5.06 0 0 0-2.098 2.102c-.484.902-.742 1.8-.742 4.277v9.55H5.18c-1.8 0-2.453-.187-3.113-.54A3.7 3.7 0 0 1 .54 30.26C.188 29.598 0 28.945 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.7 3.7 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54a3.7 3.7 0 0 1 1.527 1.527c.352.66.54 1.313.54 3.113zm0 0">
                                        </path>
                                        <path fill="#D04526" d="M14.477 7.52c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844L7.566 6.316a.89.89 0 0 0-1.246 0c-.168.16-.258.38-.258.61s.1.453.258.613l5.145 5.05H7.55c-.488 0-.883.387-.883.867s.395.863.883.863h6.047a.85.85 0 0 0 .34-.066.86.86 0 0 0 .477-.47.74.74 0 0 0 .066-.328l.004-5.934zm0 0">
                                        </path>
                                        <g fill-rule="evenodd">
                                            <path fill="#FF7651" d="M22.855 17.676H44.82c1.8 0 2.453.188 3.113.543a3.67 3.67 0 0 1 1.527 1.527c.352.656.54 1.31.54 3.11V44.82c0 1.8-.187 2.453-.54 3.113a3.7 3.7 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54a3.7 3.7 0 0 1-1.527-1.527c-.352-.66-.54-1.312-.54-3.113V22.855c0-1.8.188-2.453.54-3.113.348-.648.88-1.18 1.527-1.527.66-.352 1.313-.54 3.113-.54zm0 0">
                                            </path>
                                            <path fill="#FFF" d="M38.367 34.648Q36.737 36 34.008 36H32.39v5H29V26.5h5.313q5.686 0 5.688 4.62.001 2.18-1.633 3.535zM33.82 29H32.5v4.5h1.32q2.679 0 2.68-2.273c0-1.484-.89-2.227-2.68-2.227m0 0">
                                            </path>
                                        </g>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.convert_to_powerpoint') }}</h3>
                                <p class="card-description">{{ __('messages.convert_to_powerpoint_desc') }}</p>
                            </a>
                            <a href="{{ route('pdf_to_excel') }}" class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#C2E5C3" fill-rule="evenodd" d="M32.324 15.656h-9.55c-2.477 0-3.375.258-4.28.742a5.06 5.06 0 0 0-2.098 2.102c-.484.902-.742 1.8-.742 4.277v9.55H5.18c-1.8 0-2.453-.187-3.113-.54A3.7 3.7 0 0 1 .54 30.26C.188 29.598 0 28.945 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.7 3.7 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54a3.7 3.7 0 0 1 1.527 1.527c.352.66.54 1.313.54 3.113zm0 0">
                                        </path>
                                        <path fill="#2E7237" d="M14.477 7.52c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844L7.566 6.316a.89.89 0 0 0-1.246 0c-.168.16-.258.38-.258.61s.1.453.258.613l5.145 5.05H7.55c-.488 0-.883.387-.883.867s.395.863.883.863h6.047a.85.85 0 0 0 .34-.066.86.86 0 0 0 .477-.47.74.74 0 0 0 .066-.328l.004-5.934zm0 0">
                                        </path>
                                        <g fill-rule="evenodd">
                                            <path fill="#5EA162" d="M22.855 17.676H44.82c1.8 0 2.453.188 3.113.543a3.67 3.67 0 0 1 1.527 1.527c.352.656.54 1.31.54 3.11V44.82c0 1.8-.187 2.453-.54 3.113a3.7 3.7 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54a3.7 3.7 0 0 1-1.527-1.527c-.352-.66-.54-1.312-.54-3.113V22.855c0-1.8.188-2.453.54-3.113.348-.648.88-1.18 1.527-1.527.66-.352 1.313-.54 3.113-.54zm0 0">
                                            </path>
                                            <path fill="#FFF" d="m36.61 41-2.508-4.72c-.102-.176-.195-.5-.3-.973h-.04q-.071.334-.336 1.012L30.9 41H27l4.64-7.25-4.246-7.25h3.992l2.082 4.348c.164.344.313.754.438 1.227h.04c.082-.285.234-.703.457-1.266l2.316-4.31h3.66l-4.37 7.19L40.5 41zm0 0">
                                            </path>
                                        </g>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.convert_to_excel') }}</h3>
                                <p class="card-description">{{ __('messages.convert_to_excel_desc') }}</p>
                            </a>
                            <a href="{{ route('images_to_pdf') }}" class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#FBEFA8" fill-rule="evenodd" d="M17.676 34.344h9.55c2.477 0 3.375-.258 4.28-.742a5.04 5.04 0 0 0 2.098-2.102c.484-.902.742-1.8.742-4.277v-9.547H44.82c1.8 0 2.453.188 3.113.54s1.176.87 1.527 1.527.54 1.31.54 3.113V44.82c0 1.8-.187 2.453-.54 3.113a3.7 3.7 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54s-1.172-.87-1.527-1.527-.54-1.312-.54-3.113zm0 0">
                                        </path>
                                        <path fill="#B7A001" d="M43.94 37.137c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844l-5.145-5.047a.893.893 0 0 0-1.25 0 .85.85 0 0 0-.258.609.86.86 0 0 0 .258.613l5.145 5.05H37.01c-.488 0-.883.387-.883.867s.395.867.883.867h6.05a.9.9 0 0 0 .336-.07.87.87 0 0 0 .477-.465.8.8 0 0 0 .066-.332l.004-5.934zm0 0">
                                        </path>
                                        <g fill-rule="evenodd">
                                            <path fill="#D6BF2D" d="M5.184 0h21.988c1.8 0 2.453.188 3.113.54.652.344 1.184.88 1.527 1.53.352.656.54 1.313.54 3.113v21.984c0 1.805-.187 2.457-.54 3.117a3.67 3.67 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H5.184c-1.8 0-2.457-.187-3.113-.54a3.67 3.67 0 0 1-1.527-1.527C.188 29.625 0 28.973 0 27.168V5.184c0-1.8.188-2.457.54-3.113.344-.652.88-1.184 1.53-1.53S3.383 0 5.184 0m0 0">
                                            </path>
                                            <path fill="#FFF" d="M10.28 12.945v4.688c0 1.66-.926 2.66-2.707 2.66C5.406 20.293 5 18.852 5 18.07c0-.668.31-1.098.86-1.098.648 0 .813.504.813 1.05 0 .516.242.89.88.89.594 0 .926-.44.926-1.3V12.95c0-.54.352-.898.902-.898s.902.36.902.898zm1.672 6.402v-6.102c0-.8.418-1.055 1.055-1.055h2.762c1.516 0 2.738.75 2.738 2.508 0 1.44-1 2.508-2.75 2.508h-2v2.152c0 .54-.355.902-.902.902s-.902-.363-.902-.902zm1.805-5.773v2.242h1.68c.727 0 1.266-.437 1.266-1.12 0-.793-.56-1.12-1.45-1.12zm13.285 3.1v2.984a.595.595 0 0 1-.613.602c-.52 0-.66-.32-.773-1.023-.516.648-1.23 1.066-2.352 1.066-2.793 0-3.863-1.926-3.863-4.145 0-2.676 1.672-4.148 4.125-4.148 2.004 0 3.07 1.2 3.07 1.902 0 .63-.46.793-.848.793-.89 0-.56-1.242-2.32-1.242-1.242 0-2.223.813-2.223 2.816 0 1.56.77 2.637 2.246 2.637.957 0 1.793-.648 1.88-1.617H24.2c-.383 0-.812-.14-.812-.69 0-.44.254-.69.703-.69h2.223c.527 0 .738.262.738.758zm0 0">
                                            </path>
                                        </g>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.images_to_pdf') }}</h3>

                                <p class="card-description">{{ __('messages.images_to_pdf_desc') }}</p>
                            </a>
                            <a href="{{ route('compress_pdf') }}" class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#8FBC5D" fill-rule="evenodd" d="M31.523 28h14.953c1.223 0 1.668.13 2.117.367.44.234.805.598 1.04 1.04.242.45.367.895.367 2.117v14.953c0 1.223-.13 1.668-.367 2.117-.234.44-.598.805-1.04 1.04-.45.242-.895.367-2.117.367H31.523c-1.223 0-1.668-.13-2.117-.367a2.52 2.52 0 0 1-1.04-1.04c-.242-.45-.367-.895-.367-2.117V31.523c0-1.223.13-1.668.367-2.117.234-.44.598-.805 1.04-1.04.45-.242.895-.367 2.117-.367zm0-28h14.953c1.223 0 1.668.13 2.117.367.44.234.805.598 1.04 1.04.242.45.367.895.367 2.117v14.953c0 1.223-.13 1.668-.367 2.117-.234.44-.598.805-1.04 1.04-.45.242-.895.367-2.117.367H31.523c-1.223 0-1.668-.13-2.117-.367a2.52 2.52 0 0 1-1.04-1.04c-.242-.45-.367-.895-.367-2.117V3.523c0-1.223.13-1.668.367-2.117.234-.44.598-.805 1.04-1.04C29.855.125 30.3 0 31.523 0m-28 28h14.953c1.223 0 1.668.13 2.117.367.44.234.805.598 1.04 1.04.242.45.367.895.367 2.117v14.953c0 1.223-.13 1.668-.367 2.117-.234.44-.598.805-1.04 1.04-.45.242-.895.367-2.117.367H3.523c-1.223 0-1.668-.13-2.117-.367a2.52 2.52 0 0 1-1.04-1.04C.125 48.145 0 47.7 0 46.477V31.523c0-1.223.13-1.668.367-2.117.234-.44.598-.805 1.04-1.04.45-.242.895-.367 2.117-.367zm0-28h14.953c1.223 0 1.668.13 2.117.367.44.234.805.598 1.04 1.04.242.45.367.895.367 2.117v14.953c0 1.223-.13 1.668-.367 2.117-.234.44-.598.805-1.04 1.04-.45.242-.895.367-2.117.367H3.523c-1.223 0-1.668-.13-2.117-.367a2.52 2.52 0 0 1-1.04-1.04C.125 20.145 0 19.7 0 18.477V3.523C0 2.3.13 1.852.367 1.406A2.56 2.56 0 0 1 1.406.367C1.855.13 2.3 0 3.523 0m0 0">
                                        </path>
                                        <path fill="#FFF" d="M35 41.8c0 .48.398.867.883.867a.88.88 0 0 0 .883-.867v-3.844l5.145 5.05a.89.89 0 0 0 1.246 0 .85.85 0 0 0 .262-.613c0-.23-.094-.45-.262-.613l-5.14-5.047h3.914a.88.88 0 0 0 .883-.867.874.874 0 0 0-.883-.867h-6.05a.875.875 0 0 0-.817.536.8.8 0 0 0-.066.328zm7.3-26.387c.48 0 .867-.398.867-.883a.88.88 0 0 0-.867-.883h-3.844l5.05-5.14a.9.9 0 0 0 0-1.25.86.86 0 0 0-1.227 0l-5.047 5.148V8.492a.876.876 0 0 0-.867-.883.87.87 0 0 0-.867.879v6.05c0 .113.023.23.066.336a.86.86 0 0 0 .47.477.8.8 0 0 0 .332.07H42.3zM8.46 35c-.48 0-.867.398-.867.883s.387.883.867.883h3.844L7.254 41.9a.893.893 0 0 0 0 1.25.86.86 0 0 0 .613.258c.23 0 .45-.094.613-.258l5.047-5.145v3.914c0 .488.387.883.867.883s.867-.402.867-.883v-6.05a.875.875 0 0 0-.536-.813.8.8 0 0 0-.332-.07H8.46zm6.074-27.406a.874.874 0 0 0-.883.867v3.844l-5.145-5.05a.9.9 0 0 0-1.25 0A.86.86 0 0 0 7 7.867c0 .23.094.45.258.613l5.145 5.047H8.488c-.488 0-.883.387-.883.867s.402.867.883.867h6.05a.9.9 0 0 0 .336-.066c.215-.1.39-.258.477-.47.05-.102.07-.22.07-.332V8.46a.874.874 0 0 0-.883-.867zm0 0">
                                        </path>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.compress_pdf') }}</h3>
                                <p class="card-description">{{ __('messages.compress_pdf_desc') }}</p>
                            </a>
                            <a href="{{ route('merge_pdf') }}" class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <g fill="#EE6C4D" fill-rule="evenodd">
                                            <path d="M5.488.363h21.75c1.78 0 2.43.184 3.082.535a3.66 3.66 0 0 1 1.512 1.512c.348.652.535 1.297.535 3.082v21.746c0 1.78-.187 2.43-.535 3.082a3.66 3.66 0 0 1-1.512 1.512c-.652.348-1.3.535-3.082.535H5.488c-1.78 0-2.43-.187-3.082-.535A3.66 3.66 0 0 1 .895 30.32c-.348-.652-.535-1.3-.535-3.082V5.488c0-1.78.188-2.43.535-3.082A3.7 3.7 0 0 1 2.406.895c.652-.348 1.3-.53 3.082-.53zm0 0">
                                            </path>
                                            <path d="M44.563 49.69H22.816c-1.78 0-2.43-.184-3.082-.535a3.6 3.6 0 0 1-1.512-1.512c-.348-.652-.535-1.297-.535-3.082V22.816c0-1.78.184-2.43.535-3.082a3.6 3.6 0 0 1 1.512-1.512c.652-.348 1.3-.535 3.082-.535h21.746c1.785 0 2.43.188 3.082.535.645.34 1.172.867 1.512 1.512.352.652.535 1.3.535 3.082v21.746c0 1.785-.184 2.43-.535 3.082a3.6 3.6 0 0 1-1.512 1.512c-.652.352-1.297.535-3.082.535zm0 0">
                                            </path>
                                        </g>
                                        <path fill="#FFF" d="M17.906 10.965a.87.87 0 0 0-.875.86v3.8L9.84 8.523a.886.886 0 0 0-1.238 0 .85.85 0 0 0-.254.605.86.86 0 0 0 .254.6l7.195 7.098h-3.875c-.484 0-.875.387-.875.86s.4.86.875.86h5.984a.9.9 0 0 0 .332-.066.86.86 0 0 0 .473-.465.8.8 0 0 0 .066-.328v-5.87a.86.86 0 0 0-.87-.86zm14.418 28.008c.48 0 .87-.383.87-.86v-3.797l7.195 7.098a.88.88 0 0 0 1.234 0 .85.85 0 0 0 .258-.605c0-.23-.094-.45-.258-.605l-7.2-7.102h3.875c.484 0 .875-.383.875-.86s-.4-.855-.875-.855h-5.984a.9.9 0 0 0-.336.066.9.9 0 0 0-.473.46.9.9 0 0 0-.066.328v5.87c0 .477.4.86.875.86zm-10.1-10.1c-.355.352-.93.352-1.285 0s-.355-.934 0-1.3a.91.91 0 0 1 1.285 0 .927.927 0 0 1 0 1.3m3.374-3.357a.91.91 0 0 1-1.285 0 .91.91 0 0 1 0-1.285.914.914 0 0 1 1.285 0 .91.91 0 0 1 0 1.285m3.36-3.364a.91.91 0 0 1-1.285 0 .91.91 0 0 1 0-1.285.91.91 0 0 1 1.285 0 .91.91 0 0 1 0 1.285m0 0">
                                        </path>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.merge_pdf') }}</h3>
                                <p class="card-description">{{ __('messages.merge_pdf_desc') }}.</p>
                            </a>
                            <a href={{ route('rotate_pdf') }} class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill-rule="evenodd" viewBox="0 0 50 50">
                                        <path fill="#AB6993" d="M8.012 0h33.976c2.786 0 3.796.3 4.815.835a5.7 5.7 0 0 1 2.363 2.363c.545 1.02.835 2.03.835 4.815v33.976c0 2.786-.3 3.796-.835 4.815a5.7 5.7 0 0 1-2.363 2.363c-1.02.545-2.03.835-4.815.835H8.012c-2.786 0-3.796-.3-4.815-.835a5.7 5.7 0 0 1-2.363-2.363C.3 45.784 0 44.774 0 41.988V8.012c0-2.786.3-3.796.835-4.815A5.7 5.7 0 0 1 3.197.835C4.216.3 5.226 0 8.012 0">
                                        </path>
                                        <g fill="#FFF">
                                            <path fill-rule="nonzero" d="M23.366 13.26a1.25 1.25 0 1 1 .318 2.48c-5.352.686-9.434 5.212-9.434 10.638 0 4.407 2.692 8.285 6.726 9.926a1.25 1.25 0 0 1-.942 2.316c-4.963-2.02-8.284-6.804-8.284-12.242 0-6.697 5.03-12.273 11.616-13.118m14.778 11.437a1.25 1.25 0 1 1-2.475.354 11.6 11.6 0 0 0-.905-3.163 1.25 1.25 0 1 1 2.278-1.03 14 14 0 0 1 1.102 3.84zM26.71 39.493a1.25 1.25 0 0 1-.354-2.475c1.1-.157 2.125-.445 3.09-.872a1.25 1.25 0 0 1 1.013 2.286 14 14 0 0 1-3.748 1.06zm8.792-4.998a1.25 1.25 0 1 1-2-1.5q1.078-1.434 1.627-2.866a1.25 1.25 0 1 1 2.335.893C37 32.206 36.35 33.36 35.5 34.495z">
                                            </path>
                                            <path d="M24.282 21a.786.786 0 0 1-.78-.78V9.28c0-.427.354-.78.78-.78.208 0 .403.085.55.232l5.47 5.47c.146.146.232.342.232.55s-.085.403-.232.55l-5.47 5.47a.78.78 0 0 1-.55.232z">
                                            </path>
                                        </g>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.rotate_pdf') }}</h3>
                                <p class="card-description">{{ __('messages.rotate_pdf_desc') }}.</p>
                            </a>
                            <a href={{ route('add_watermark') }} class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#AB6993" fill-rule="evenodd" d="M8.012 0h33.977c2.785 0 3.797.29 4.813.836a5.65 5.65 0 0 1 2.363 2.363C49.71 4.215 50 5.227 50 8.012v33.977c0 2.785-.29 3.797-.836 4.813a5.65 5.65 0 0 1-2.363 2.363c-1.016.547-2.027.836-4.812.836H8.012c-2.785 0-3.797-.29-4.816-.836S1.38 47.82.836 46.8 0 44.773 0 41.988V8.012C0 5.227.29 4.215.836 3.2A5.65 5.65 0 0 1 3.199.836C4.215.29 5.227 0 8.012 0m0 0">
                                        </path>
                                        <path fill="#FFF" d="M22.7 22.523c0 .863-1.094 3.023-2.11 4.668a.68.68 0 0 0-.078.523.64.64 0 0 0 .61.47h7.75a.63.63 0 0 0 .566-.352.65.65 0 0 0-.055-.672c-1.445-1.97-2.1-3.398-2.1-4.633s.645-2.66 2.094-4.637a5.5 5.5 0 0 0 1.012-3.195c0-3.02-2.422-5.477-5.398-5.477s-5.398 2.45-5.398 5.473a5.5 5.5 0 0 0 1.02 3.203c1.44 1.97 2.086 3.398 2.086 4.63zm14.02 6.55H13.266a.64.64 0 0 0-.633.645v6.465c0 .352.285.645.633.645H36.72a.64.64 0 0 0 .633-.645V29.72a.643.643 0 0 0-.633-.645zm-3.582 8.7H16.863a.64.64 0 0 0-.633.645v.727c0 .352.285.645.633.645h16.273a.64.64 0 0 0 .633-.645v-.727a.643.643 0 0 0-.633-.645zm0 0">
                                        </path>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.add_watermark') }}</h3>
                                <p class="card-description">{{ __('messages.add_watermark_desc') }}.</p>
                            </a>
                        </div>
                    </div>

                    <!-- Convert Files Tab -->
                    <div class="tab-panel" id="convert">
                        <div class="content-grid">
                            <a href="{{ route('pdf_to_jpg') }}" class="content-card special-effect glow-effect">
                                <span class="card-icon">
                                    <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#FBEFA8" fill-rule="evenodd" d="M32.324 15.656h-9.55c-2.477 0-3.375.258-4.28.742a5.06 5.06 0 0 0-2.098 2.102c-.484.902-.742 1.8-.742 4.277v9.55H5.18c-1.8 0-2.453-.187-3.113-.54A3.7 3.7 0 0 1 .54 30.26C.188 29.598 0 28.945 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.7 3.7 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54a3.7 3.7 0 0 1 1.527 1.527c.352.66.54 1.313.54 3.113zm0 0">
                                        </path>
                                        <path fill="#B7A001" d="M14.477 7.52c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844L7.566 6.316a.89.89 0 0 0-1.246 0c-.168.16-.258.38-.258.61s.1.453.258.613l5.145 5.05H7.55c-.488 0-.883.387-.883.867s.395.863.883.863h6.047a.85.85 0 0 0 .34-.066.86.86 0 0 0 .477-.47.74.74 0 0 0 .066-.328l.004-5.934zm0 0">
                                        </path>
                                        <g fill-rule="evenodd">
                                            <path fill="#D6BF2D" d="M22.855 17.676H44.82c1.8 0 2.453.188 3.113.543a3.67 3.67 0 0 1 1.527 1.527c.352.656.54 1.31.54 3.11V44.82c0 1.8-.187 2.453-.54 3.113a3.7 3.7 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54a3.7 3.7 0 0 1-1.527-1.527c-.352-.66-.54-1.312-.54-3.113V22.855c0-1.8.188-2.453.54-3.113.348-.648.88-1.18 1.527-1.527.66-.352 1.313-.54 3.113-.54zm0 0">
                                            </path>
                                            <path fill="#FFF" d="M41.5 26c1.102 0 2 .898 2 2s-.898 2-2 2-2-.898-2-2 .898-2 2-2M30.6 39h-6.344c-.1 0-.172-.047-.215-.125s-.043-.168.004-.242l6.574-11.02a.26.26 0 0 1 .426 0l3.832 6.422 2.57-2.625a.24.24 0 0 1 .176-.074h.008c.07 0 .137.03.18.086l6.1 7.13c.07.043.11.12.11.203a.246.246 0 0 1-.246.242H30.6v-.004zm0 0">
                                            </path>
                                        </g>
                                    </svg>
                                </span>
                                <h3 class="card-title">{{ __('messages.convert_to_jpg') }}</h3>
                                <p class="card-description">{{ __('messages.convert_to_jpg_desc') }}.</p>
                            </a>
                            <a href="{{ route('pdf_to_jpg') }}" class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#DCE5FA" fill-rule="evenodd" d="M32.324 15.656h-9.547c-2.477 0-3.375.258-4.28.742a5.04 5.04 0 0 0-2.098 2.102c-.484.902-.742 1.8-.742 4.277v9.547H5.18c-1.8 0-2.45-.187-3.113-.54A3.7 3.7 0 0 1 .54 30.257c-.352-.66-.54-1.31-.54-3.113V5.18c0-1.8.188-2.45.54-3.113S1.4.89 2.066.54 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54a3.7 3.7 0 0 1 1.527 1.527c.352.66.54 1.313.54 3.113zm0 0">
                                        </path>
                                        <path fill="#295795" d="M14.477 7.52a.88.88 0 0 0-.883-.867c-.48 0-.883.39-.883.867v3.844L7.566 6.316a.89.89 0 0 0-1.246 0c-.168.16-.258.38-.258.61s.1.453.258.613l5.145 5.05H7.547c-.488 0-.883.387-.883.863s.398.867.883.867h6.055a.9.9 0 0 0 .336-.066.86.86 0 0 0 .477-.47.74.74 0 0 0 .066-.328l.004-5.938zm0 0">
                                        </path>
                                        <path fill="#5F83C6" fill-rule="evenodd" d="M22.855 17.676H44.82c1.8 0 2.45.188 3.113.543a3.7 3.7 0 0 1 1.527 1.523c.352.66.54 1.313.54 3.113V44.82c0 1.8-.187 2.45-.54 3.113s-.867 1.176-1.527 1.527-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54a3.7 3.7 0 0 1-1.527-1.527c-.352-.66-.54-1.312-.54-3.113V22.855c0-1.8.188-2.453.54-3.113.348-.648.88-1.18 1.527-1.527.66-.352 1.313-.54 3.113-.54zm0 0">
                                        </path>
                                        <path fill="#FFF" d="M38.996 26.75h2.965l-2.94 14.64h-3.094l-1.777-9.035-1.824 9.035H29.12L26.2 26.75h3.164l1.508 9.363 1.938-9.363h3.004l1.727 9.297zm0 0">
                                        </path>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.convert_to_word') }}</h3>
                                <p class="card-description">{{ __('messages.convert_to_word_desc') }}.</p>
                            </a>
                            <a hre="{{ route('pdf_to_powerpoint') }}" class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#F3D9CC" fill-rule="evenodd" d="M32.324 15.656h-9.55c-2.477 0-3.375.258-4.28.742a5.06 5.06 0 0 0-2.098 2.102c-.484.902-.742 1.8-.742 4.277v9.55H5.18c-1.8 0-2.453-.187-3.113-.54A3.7 3.7 0 0 1 .54 30.26C.188 29.598 0 28.945 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.7 3.7 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54a3.7 3.7 0 0 1 1.527 1.527c.352.66.54 1.313.54 3.113zm0 0">
                                        </path>
                                        <path fill="#D04526" d="M14.477 7.52c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844L7.566 6.316a.89.89 0 0 0-1.246 0c-.168.16-.258.38-.258.61s.1.453.258.613l5.145 5.05H7.55c-.488 0-.883.387-.883.867s.395.863.883.863h6.047a.85.85 0 0 0 .34-.066.86.86 0 0 0 .477-.47.74.74 0 0 0 .066-.328l.004-5.934zm0 0">
                                        </path>
                                        <g fill-rule="evenodd">
                                            <path fill="#FF7651" d="M22.855 17.676H44.82c1.8 0 2.453.188 3.113.543a3.67 3.67 0 0 1 1.527 1.527c.352.656.54 1.31.54 3.11V44.82c0 1.8-.187 2.453-.54 3.113a3.7 3.7 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54a3.7 3.7 0 0 1-1.527-1.527c-.352-.66-.54-1.312-.54-3.113V22.855c0-1.8.188-2.453.54-3.113.348-.648.88-1.18 1.527-1.527.66-.352 1.313-.54 3.113-.54zm0 0">
                                            </path>
                                            <path fill="#FFF" d="M38.367 34.648Q36.737 36 34.008 36H32.39v5H29V26.5h5.313q5.686 0 5.688 4.62.001 2.18-1.633 3.535zM33.82 29H32.5v4.5h1.32q2.679 0 2.68-2.273c0-1.484-.89-2.227-2.68-2.227m0 0">
                                            </path>
                                        </g>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.convert_to_powerpoint') }}</h3>
                                <p class="card-description">{{ __('messages.convert_to_powerpoint_desc') }}.</p>
                            </a>
                            <a href="{{ route('pdf_to_excel') }}" class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#C2E5C3" fill-rule="evenodd" d="M32.324 15.656h-9.55c-2.477 0-3.375.258-4.28.742a5.06 5.06 0 0 0-2.098 2.102c-.484.902-.742 1.8-.742 4.277v9.55H5.18c-1.8 0-2.453-.187-3.113-.54A3.7 3.7 0 0 1 .54 30.26C.188 29.598 0 28.945 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.7 3.7 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54a3.7 3.7 0 0 1 1.527 1.527c.352.66.54 1.313.54 3.113zm0 0">
                                        </path>
                                        <path fill="#2E7237" d="M14.477 7.52c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844L7.566 6.316a.89.89 0 0 0-1.246 0c-.168.16-.258.38-.258.61s.1.453.258.613l5.145 5.05H7.55c-.488 0-.883.387-.883.867s.395.863.883.863h6.047a.85.85 0 0 0 .34-.066.86.86 0 0 0 .477-.47.74.74 0 0 0 .066-.328l.004-5.934zm0 0">
                                        </path>
                                        <g fill-rule="evenodd">
                                            <path fill="#5EA162" d="M22.855 17.676H44.82c1.8 0 2.453.188 3.113.543a3.67 3.67 0 0 1 1.527 1.527c.352.656.54 1.31.54 3.11V44.82c0 1.8-.187 2.453-.54 3.113a3.7 3.7 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54a3.7 3.7 0 0 1-1.527-1.527c-.352-.66-.54-1.312-.54-3.113V22.855c0-1.8.188-2.453.54-3.113.348-.648.88-1.18 1.527-1.527.66-.352 1.313-.54 3.113-.54zm0 0">
                                            </path>
                                            <path fill="#FFF" d="m36.61 41-2.508-4.72c-.102-.176-.195-.5-.3-.973h-.04q-.071.334-.336 1.012L30.9 41H27l4.64-7.25-4.246-7.25h3.992l2.082 4.348c.164.344.313.754.438 1.227h.04c.082-.285.234-.703.457-1.266l2.316-4.31h3.66l-4.37 7.19L40.5 41zm0 0">
                                            </path>
                                        </g>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.convert_to_excel') }}</h3>
                                <p class="card-description">{{ __('messages.convert_to_excel_desc') }}.</p>
                            </a>
                            <a href="{{ route('images_to_pdf') }}" class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#FBEFA8" fill-rule="evenodd" d="M17.676 34.344h9.55c2.477 0 3.375-.258 4.28-.742a5.04 5.04 0 0 0 2.098-2.102c.484-.902.742-1.8.742-4.277v-9.547H44.82c1.8 0 2.453.188 3.113.54s1.176.87 1.527 1.527.54 1.31.54 3.113V44.82c0 1.8-.187 2.453-.54 3.113a3.7 3.7 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54s-1.172-.87-1.527-1.527-.54-1.312-.54-3.113zm0 0">
                                        </path>
                                        <path fill="#B7A001" d="M43.94 37.137c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844l-5.145-5.047a.893.893 0 0 0-1.25 0 .85.85 0 0 0-.258.609.86.86 0 0 0 .258.613l5.145 5.05H37.01c-.488 0-.883.387-.883.867s.395.867.883.867h6.05a.9.9 0 0 0 .336-.07.87.87 0 0 0 .477-.465.8.8 0 0 0 .066-.332l.004-5.934zm0 0">
                                        </path>
                                        <g fill-rule="evenodd">
                                            <path fill="#D6BF2D" d="M5.184 0h21.988c1.8 0 2.453.188 3.113.54.652.344 1.184.88 1.527 1.53.352.656.54 1.313.54 3.113v21.984c0 1.805-.187 2.457-.54 3.117a3.67 3.67 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H5.184c-1.8 0-2.457-.187-3.113-.54a3.67 3.67 0 0 1-1.527-1.527C.188 29.625 0 28.973 0 27.168V5.184c0-1.8.188-2.457.54-3.113.344-.652.88-1.184 1.53-1.53S3.383 0 5.184 0m0 0">
                                            </path>
                                            <path fill="#FFF" d="M10.28 12.945v4.688c0 1.66-.926 2.66-2.707 2.66C5.406 20.293 5 18.852 5 18.07c0-.668.31-1.098.86-1.098.648 0 .813.504.813 1.05 0 .516.242.89.88.89.594 0 .926-.44.926-1.3V12.95c0-.54.352-.898.902-.898s.902.36.902.898zm1.672 6.402v-6.102c0-.8.418-1.055 1.055-1.055h2.762c1.516 0 2.738.75 2.738 2.508 0 1.44-1 2.508-2.75 2.508h-2v2.152c0 .54-.355.902-.902.902s-.902-.363-.902-.902zm1.805-5.773v2.242h1.68c.727 0 1.266-.437 1.266-1.12 0-.793-.56-1.12-1.45-1.12zm13.285 3.1v2.984a.595.595 0 0 1-.613.602c-.52 0-.66-.32-.773-1.023-.516.648-1.23 1.066-2.352 1.066-2.793 0-3.863-1.926-3.863-4.145 0-2.676 1.672-4.148 4.125-4.148 2.004 0 3.07 1.2 3.07 1.902 0 .63-.46.793-.848.793-.89 0-.56-1.242-2.32-1.242-1.242 0-2.223.813-2.223 2.816 0 1.56.77 2.637 2.246 2.637.957 0 1.793-.648 1.88-1.617H24.2c-.383 0-.812-.14-.812-.69 0-.44.254-.69.703-.69h2.223c.527 0 .738.262.738.758zm0 0">
                                            </path>
                                        </g>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.images_to_pdf') }}</h3>
                                <p class="card-description">{{ __('messages.images_to_pdf_desc') }}.</p>
                            </a>
                        </div>
                    </div>

                    <!-- Edit Files Tab -->
                    <div class="tab-panel" id="edit">
                        <div class="content-grid">
                            <a href="{{ route('compress_pdf') }}" class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#8FBC5D" fill-rule="evenodd" d="M31.523 28h14.953c1.223 0 1.668.13 2.117.367.44.234.805.598 1.04 1.04.242.45.367.895.367 2.117v14.953c0 1.223-.13 1.668-.367 2.117-.234.44-.598.805-1.04 1.04-.45.242-.895.367-2.117.367H31.523c-1.223 0-1.668-.13-2.117-.367a2.52 2.52 0 0 1-1.04-1.04c-.242-.45-.367-.895-.367-2.117V31.523c0-1.223.13-1.668.367-2.117.234-.44.598-.805 1.04-1.04.45-.242.895-.367 2.117-.367zm0-28h14.953c1.223 0 1.668.13 2.117.367.44.234.805.598 1.04 1.04.242.45.367.895.367 2.117v14.953c0 1.223-.13 1.668-.367 2.117-.234.44-.598.805-1.04 1.04-.45.242-.895.367-2.117.367H31.523c-1.223 0-1.668-.13-2.117-.367a2.52 2.52 0 0 1-1.04-1.04c-.242-.45-.367-.895-.367-2.117V3.523c0-1.223.13-1.668.367-2.117.234-.44.598-.805 1.04-1.04C29.855.125 30.3 0 31.523 0m-28 28h14.953c1.223 0 1.668.13 2.117.367.44.234.805.598 1.04 1.04.242.45.367.895.367 2.117v14.953c0 1.223-.13 1.668-.367 2.117-.234.44-.598.805-1.04 1.04-.45.242-.895.367-2.117.367H3.523c-1.223 0-1.668-.13-2.117-.367a2.52 2.52 0 0 1-1.04-1.04C.125 48.145 0 47.7 0 46.477V31.523c0-1.223.13-1.668.367-2.117.234-.44.598-.805 1.04-1.04.45-.242.895-.367 2.117-.367zm0-28h14.953c1.223 0 1.668.13 2.117.367.44.234.805.598 1.04 1.04.242.45.367.895.367 2.117v14.953c0 1.223-.13 1.668-.367 2.117-.234.44-.598.805-1.04 1.04-.45.242-.895.367-2.117.367H3.523c-1.223 0-1.668-.13-2.117-.367a2.52 2.52 0 0 1-1.04-1.04C.125 20.145 0 19.7 0 18.477V3.523C0 2.3.13 1.852.367 1.406A2.56 2.56 0 0 1 1.406.367C1.855.13 2.3 0 3.523 0m0 0">
                                        </path>
                                        <path fill="#FFF" d="M35 41.8c0 .48.398.867.883.867a.88.88 0 0 0 .883-.867v-3.844l5.145 5.05a.89.89 0 0 0 1.246 0 .85.85 0 0 0 .262-.613c0-.23-.094-.45-.262-.613l-5.14-5.047h3.914a.88.88 0 0 0 .883-.867.874.874 0 0 0-.883-.867h-6.05a.875.875 0 0 0-.817.536.8.8 0 0 0-.066.328zm7.3-26.387c.48 0 .867-.398.867-.883a.88.88 0 0 0-.867-.883h-3.844l5.05-5.14a.9.9 0 0 0 0-1.25.86.86 0 0 0-1.227 0l-5.047 5.148V8.492a.876.876 0 0 0-.867-.883.87.87 0 0 0-.867.879v6.05c0 .113.023.23.066.336a.86.86 0 0 0 .47.477.8.8 0 0 0 .332.07H42.3zM8.46 35c-.48 0-.867.398-.867.883s.387.883.867.883h3.844L7.254 41.9a.893.893 0 0 0 0 1.25.86.86 0 0 0 .613.258c.23 0 .45-.094.613-.258l5.047-5.145v3.914c0 .488.387.883.867.883s.867-.402.867-.883v-6.05a.875.875 0 0 0-.536-.813.8.8 0 0 0-.332-.07H8.46zm6.074-27.406a.874.874 0 0 0-.883.867v3.844l-5.145-5.05a.9.9 0 0 0-1.25 0A.86.86 0 0 0 7 7.867c0 .23.094.45.258.613l5.145 5.047H8.488c-.488 0-.883.387-.883.867s.402.867.883.867h6.05a.9.9 0 0 0 .336-.066c.215-.1.39-.258.477-.47.05-.102.07-.22.07-.332V8.46a.874.874 0 0 0-.883-.867zm0 0">
                                        </path>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.compress_pdf') }}</h3>
                                <p class="card-description">{{ __('messages.compress_pdf_desc') }}.</p>
                            </a>
                            <a href="{{ route('merge_pdf') }}" class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <g fill="#EE6C4D" fill-rule="evenodd">
                                            <path d="M5.488.363h21.75c1.78 0 2.43.184 3.082.535a3.66 3.66 0 0 1 1.512 1.512c.348.652.535 1.297.535 3.082v21.746c0 1.78-.187 2.43-.535 3.082a3.66 3.66 0 0 1-1.512 1.512c-.652.348-1.3.535-3.082.535H5.488c-1.78 0-2.43-.187-3.082-.535A3.66 3.66 0 0 1 .895 30.32c-.348-.652-.535-1.3-.535-3.082V5.488c0-1.78.188-2.43.535-3.082A3.7 3.7 0 0 1 2.406.895c.652-.348 1.3-.53 3.082-.53zm0 0">
                                            </path>
                                            <path d="M44.563 49.69H22.816c-1.78 0-2.43-.184-3.082-.535a3.6 3.6 0 0 1-1.512-1.512c-.348-.652-.535-1.297-.535-3.082V22.816c0-1.78.184-2.43.535-3.082a3.6 3.6 0 0 1 1.512-1.512c.652-.348 1.3-.535 3.082-.535h21.746c1.785 0 2.43.188 3.082.535.645.34 1.172.867 1.512 1.512.352.652.535 1.3.535 3.082v21.746c0 1.785-.184 2.43-.535 3.082a3.6 3.6 0 0 1-1.512 1.512c-.652.352-1.297.535-3.082.535zm0 0">
                                            </path>
                                        </g>
                                        <path fill="#FFF" d="M17.906 10.965a.87.87 0 0 0-.875.86v3.8L9.84 8.523a.886.886 0 0 0-1.238 0 .85.85 0 0 0-.254.605.86.86 0 0 0 .254.6l7.195 7.098h-3.875c-.484 0-.875.387-.875.86s.4.86.875.86h5.984a.9.9 0 0 0 .332-.066.86.86 0 0 0 .473-.465.8.8 0 0 0 .066-.328v-5.87a.86.86 0 0 0-.87-.86zm14.418 28.008c.48 0 .87-.383.87-.86v-3.797l7.195 7.098a.88.88 0 0 0 1.234 0 .85.85 0 0 0 .258-.605c0-.23-.094-.45-.258-.605l-7.2-7.102h3.875c.484 0 .875-.383.875-.86s-.4-.855-.875-.855h-5.984a.9.9 0 0 0-.336.066.9.9 0 0 0-.473.46.9.9 0 0 0-.066.328v5.87c0 .477.4.86.875.86zm-10.1-10.1c-.355.352-.93.352-1.285 0s-.355-.934 0-1.3a.91.91 0 0 1 1.285 0 .927.927 0 0 1 0 1.3m3.374-3.357a.91.91 0 0 1-1.285 0 .91.91 0 0 1 0-1.285.914.914 0 0 1 1.285 0 .91.91 0 0 1 0 1.285m3.36-3.364a.91.91 0 0 1-1.285 0 .91.91 0 0 1 0-1.285.91.91 0 0 1 1.285 0 .91.91 0 0 1 0 1.285m0 0">
                                        </path>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.merge_pdf') }}</h3>
                                <p class="card-description">{{ __('messages.merge_pdf_desc') }}.</p>
                            </a>
                            <a href={{ route('rotate_pdf') }} class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill-rule="evenodd" viewBox="0 0 50 50">
                                        <path fill="#AB6993" d="M8.012 0h33.976c2.786 0 3.796.3 4.815.835a5.7 5.7 0 0 1 2.363 2.363c.545 1.02.835 2.03.835 4.815v33.976c0 2.786-.3 3.796-.835 4.815a5.7 5.7 0 0 1-2.363 2.363c-1.02.545-2.03.835-4.815.835H8.012c-2.786 0-3.796-.3-4.815-.835a5.7 5.7 0 0 1-2.363-2.363C.3 45.784 0 44.774 0 41.988V8.012c0-2.786.3-3.796.835-4.815A5.7 5.7 0 0 1 3.197.835C4.216.3 5.226 0 8.012 0">
                                        </path>
                                        <g fill="#FFF">
                                            <path fill-rule="nonzero" d="M23.366 13.26a1.25 1.25 0 1 1 .318 2.48c-5.352.686-9.434 5.212-9.434 10.638 0 4.407 2.692 8.285 6.726 9.926a1.25 1.25 0 0 1-.942 2.316c-4.963-2.02-8.284-6.804-8.284-12.242 0-6.697 5.03-12.273 11.616-13.118m14.778 11.437a1.25 1.25 0 1 1-2.475.354 11.6 11.6 0 0 0-.905-3.163 1.25 1.25 0 1 1 2.278-1.03 14 14 0 0 1 1.102 3.84zM26.71 39.493a1.25 1.25 0 0 1-.354-2.475c1.1-.157 2.125-.445 3.09-.872a1.25 1.25 0 0 1 1.013 2.286 14 14 0 0 1-3.748 1.06zm8.792-4.998a1.25 1.25 0 1 1-2-1.5q1.078-1.434 1.627-2.866a1.25 1.25 0 1 1 2.335.893C37 32.206 36.35 33.36 35.5 34.495z">
                                            </path>
                                            <path d="M24.282 21a.786.786 0 0 1-.78-.78V9.28c0-.427.354-.78.78-.78.208 0 .403.085.55.232l5.47 5.47c.146.146.232.342.232.55s-.085.403-.232.55l-5.47 5.47a.78.78 0 0 1-.55.232z">
                                            </path>
                                        </g>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.rotate_pdf') }}</h3>
                                <p class="card-description">{{ __('messages.rotate_pdf_desc') }}.</p>
                            </a>
                            <div class="content-card special-effect">
                                <span class="card-icon"><svg class="svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 50 50">
                                        <path fill="#AB6993" fill-rule="evenodd" d="M8.012 0h33.977c2.785 0 3.797.29 4.813.836a5.65 5.65 0 0 1 2.363 2.363C49.71 4.215 50 5.227 50 8.012v33.977c0 2.785-.29 3.797-.836 4.813a5.65 5.65 0 0 1-2.363 2.363c-1.016.547-2.027.836-4.812.836H8.012c-2.785 0-3.797-.29-4.816-.836S1.38 47.82.836 46.8 0 44.773 0 41.988V8.012C0 5.227.29 4.215.836 3.2A5.65 5.65 0 0 1 3.199.836C4.215.29 5.227 0 8.012 0m0 0">
                                        </path>
                                        <path fill="#FFF" d="M22.7 22.523c0 .863-1.094 3.023-2.11 4.668a.68.68 0 0 0-.078.523.64.64 0 0 0 .61.47h7.75a.63.63 0 0 0 .566-.352.65.65 0 0 0-.055-.672c-1.445-1.97-2.1-3.398-2.1-4.633s.645-2.66 2.094-4.637a5.5 5.5 0 0 0 1.012-3.195c0-3.02-2.422-5.477-5.398-5.477s-5.398 2.45-5.398 5.473a5.5 5.5 0 0 0 1.02 3.203c1.44 1.97 2.086 3.398 2.086 4.63zm14.02 6.55H13.266a.64.64 0 0 0-.633.645v6.465c0 .352.285.645.633.645H36.72a.64.64 0 0 0 .633-.645V29.72a.643.643 0 0 0-.633-.645zm-3.582 8.7H16.863a.64.64 0 0 0-.633.645v.727c0 .352.285.645.633.645h16.273a.64.64 0 0 0 .633-.645v-.727a.643.643 0 0 0-.633-.645zm0 0">
                                        </path>
                                    </svg></span>

                                <h3 class="card-title">{{ __('messages.add_watermark') }}</h3>
                                <p class="card-description">{{ __('messages.add_watermark_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const tabItems = document.querySelectorAll('.tab-item');
        const tabPanels = document.querySelectorAll('.tab-panel');

        function updateIndicator(activeTab) {
            const tabRect = activeTab.getBoundingClientRect();
            const navRect = activeTab.parentElement.getBoundingClientRect();
        }

        const activeTab = document.querySelector('.tab-item.active');
        if (activeTab) {
            updateIndicator(activeTab);
        }

        tabItems.forEach(tab => {
            tab.addEventListener('click', () => {
                tabItems.forEach(t => t.classList.remove('active'));
                tabPanels.forEach(p => p.classList.remove('active'));
                tab.classList.add('active');
                const targetPanel = document.getElementById(tab.dataset.tab);
                if (targetPanel) {
                    targetPanel.classList.add('active');
                }
                updateIndicator(tab);
                tab.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    tab.style.transform = '';
                }, 150);
            });
            tab.addEventListener('mouseenter', () => {
                if (!tab.classList.contains('active')) {
                    tab.style.transform = 'translateY(-2px) scale(1.02)';
                }
            });

            tab.addEventListener('mouseleave', () => {
                if (!tab.classList.contains('active')) {
                    tab.style.transform = '';
                }
            });
        });
        const cards = document.querySelectorAll('.content-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                const icon = card.querySelector('.card-icon');
                if (icon) {
                    icon.style.transform = 'rotate(10deg) scale(1.1)';
                }
            });

            card.addEventListener('mouseleave', () => {
                const icon = card.querySelector('.card-icon');
                if (icon) {
                    icon.style.transform = '';
                }
            });
            card.addEventListener('click', () => {
                card.style.transform = 'translateY(-5px) scale(1.02)';
                setTimeout(() => {
                    card.style.transform = 'translateY(-5px)';
                }, 200);
            });
        });
        window.addEventListener('resize', () => {
            const activeTab = document.querySelector('.tab-item.active');
            if (activeTab) {
                updateIndicator(activeTab);
            }
        });

        function typeWriter(element, text, speed = 50) {
            let i = 0;
            element.innerHTML = '';

            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            type();
        }
        tabItems.forEach(tab => {
            tab.addEventListener('click', () => {
                setTimeout(() => {
                    const activePanel = document.querySelector('.tab-panel.active');
                    const header = activePanel.querySelector('.panel-header h2');
                    if (header) {
                        const text = header.textContent;
                        typeWriter(header, text, 30);
                    }
                }, 100);
            });
        });

    </script>
</section>
