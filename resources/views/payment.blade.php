@extends('layouts.app')

@section('content')
<style>
    .payment-details {
        display: none;
    }

    .payment-details.show {
        display: block;
    }

    .payment-option.active {
        border: 2px solid #4f46e5;
    }

    .pulse-dot {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.2);
            opacity: 0.7;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .pulse-animation {
        animation: pulse 2s infinite;
    }

    .slide-up {
        animation: slideUp 0.5s ease-out forwards;
    }

    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .paytabs-bg {
        background: linear-gradient(90deg, #ff6f61, #de5c9d);
    }

</style>

<body class="bg-gray-50 min-h-screen font-sans">
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success'
            , title: '{{ __("messages.success_title") }}'
            , text: '{{ session('
            success ') }}'
            , showConfirmButton: false
            , timer: 3000
        });

    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error'
            , title: '{{ __("messages.error_title") }}'
            , text: '{{ session('
            error ') }}'
        , });

    </script>
    @endif

    <main class="container mx-auto px-6 py-12">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">{{ __('messages.choose_payment_method_title') }}</h2>
        <div class="flex flex-col lg:flex-row gap-8 max-w-6xl mx-auto">
            <div class="w-full lg:w-2/3">
                <div class="space-y-6">
                    <div class="payment-option bg-white rounded-2xl shadow-lg p-6" onclick="togglePayment(event, 'paypal')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <i class="fab fa-paypal text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">PayPal</h3>
                                    <p class="text-gray-600 mt-2">{{ __('messages.most_secure_label') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="pulse-dot w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="paypal-arrow"></i>
                            </div>
                        </div>
                        <div class="payment-details hidden" id="paypal-details">
                            <div class="border-t pt-6">
                                <div class="bg-yellow-50 rounded-lg p-4 mb-6 border border-yellow-200">
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-shield-alt text-yellow-600 mr-2"></i>
                                        <span class="text-sm text-yellow-700">{{ __('messages.buyer_protection_guaranteed') }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('paypal.pay') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-yellow-500 text-white font-semibold py-4 rounded-xl hover:bg-yellow-600 transition duration-300">
                                        {{ __('messages.pay_with_paypal_button') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="payment-option bg-white rounded-2xl shadow-lg p-6" onclick="togglePayment(event, 'bank')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-university text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ __('messages.bank_transfer_title') }}</h3>
                                    <p class="text-gray-600 mt-2">{{ __('messages.direct_bank_transfer') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full mr-3">{{ __('messages.fewer_fees') }}</span>
                                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="bank-arrow"></i>
                            </div>
                        </div>

                        <div class="payment-details hidden" id="bank-details">
                            <div class="border-t pt-6">
                                @if(isset($bankDetail))
                                <div class="bg-gray-100 rounded-lg p-4 mb-6 border border-gray-200">
                                    <h4 class="text-lg font-bold text-gray-800 mb-3">{{ __('messages.bank_details_title') }}</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                                        <div>
                                            <span class="font-semibold text-gray-900">{{ __('messages.bank_name') }}</span>
                                            <span class="block mt-1">{{ $bankDetail->bank_name }}</span>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-900">{{ __('messages.account_holder_name') }}</span>
                                            <span class="block mt-1">{{ $bankDetail->account_holder_name }}</span>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-900">{{ __('messages.account_number') }}</span>
                                            <span class="block mt-1">{{ $bankDetail->account_number }}</span>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-900">{{ __('messages.iban_number') }}</span>
                                            <span class="block mt-1">{{ $bankDetail->iban }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <p class="text-sm text-gray-600 mb-4">{{ __('messages.bank_transfer_note') }}</p>

                                {{-- Display success/error messages --}}
                                @if(session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                    {{ session('success') }}
                                </div>
                                @endif

                                @if(session('error'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                    {{ session('error') }}
                                </div>
                                @endif

                                {{-- Display validation errors --}}
                                @if($errors->any())
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                    <ul class="list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                {{-- Check if user already has a pending transfer --}}
                                @if(isset($existingTransfer) && $existingTransfer)
                                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                                    <p>لديك طلب تحويل مصرفي معلق بالفعل لهذا الاشتراك. حالة الطلب: {{ $existingTransfer->status }}</p>
                                    <p>تاريخ الإرسال: {{ $existingTransfer->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                                @endif

                                <form action="{{ route('payment.bank_transfer.submit') }}" method="POST" enctype="multipart/form-data" id="bankTransferForm">
                                    @csrf
                                    <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">

                                    {{-- Debug info (remove in production) --}}
                                    <div class="mb-4 p-3 bg-gray-100 rounded text-sm">
                                        <strong>Debug Info:</strong><br>
                                        Subscription ID: {{ $subscription->id }}<br>
                                        User ID: {{ auth()->id() }}<br>
                                        Subscription Name: {{ $subscription->name ?? 'N/A' }}
                                    </div>

                                    <div class="mb-4">
                                        <label for="sender_name" class="block text-gray-700 font-semibold mb-2">
                                            {{ __('messages.sender_name_label') }}
                                        </label>
                                        <input type="text" id="sender_name" name="sender_name" value="{{ old('sender_name') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required placeholder="أدخل اسم المرسل">
                                    </div>

                                    <div class="mb-4">
                                        <label for="amount" class="block text-gray-700 font-semibold mb-2">
                                            {{ __('messages.amount_label') }}
                                        </label>
                                        <input type="number" step="0.01" id="amount" name="amount" value="{{ old('amount') ?? $subscription->price }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required placeholder="أدخل المبلغ">
                                    </div>

                                    <div class="mb-6">
                                        <label for="transfer_receipt" class="block text-gray-700 font-semibold mb-2">
                                            {{ __('messages.transfer_receipt_label') }}
                                        </label>
                                        <input type="file" id="transfer_receipt" name="transfer_receipt" class="w-full text-gray-700 border border-gray-300 rounded-lg p-2" required accept=".jpeg,.jpg,.png,.pdf">
                                        <p class="mt-2 text-sm text-gray-500">
                                            {{ __('messages.allowed_file_types') }}
                                        </p>
                                    </div>

                                    <button type="submit" class="w-full bg-green-500 text-white font-semibold py-4 rounded-xl hover:bg-green-600 transition duration-300 disabled:opacity-50" id="submitBtn">
                                        {{ __('messages.confirm_and_submit_button') }}
                                    </button>
                                </form>

                                <script>
                                    // Add form submission handling
                                    document.getElementById('bankTransferForm').addEventListener('submit', function(e) {
                                        const submitBtn = document.getElementById('submitBtn');
                                        submitBtn.disabled = true;
                                        submitBtn.innerHTML = 'جاري الإرسال...';
                                        // Re-enable button after 5 seconds in case of error
                                        setTimeout(() => {
                                            submitBtn.disabled = false;
                                            submitBtn.innerHTML = '{{ __("messages.confirm_and_submit_button") }}';
                                        }, 5000);
                                    });

                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="payment-option bg-white rounded-2xl shadow-lg p-6" onclick="togglePayment(event, 'paytabs')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 paytabs-bg rounded-full flex items-center justify-center">
                                    <i class="fas fa-credit-card text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ __('messages.paytabs_title') }}</h3>
                                    <p class="text-gray-600">{{ __('messages.local_international_gateway') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full mr-3">{{ __('messages.most_popular_label') }}</span>
                                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="paytabs-arrow"></i>
                            </div>
                        </div>
                        <div class="payment-details hidden" id="paytabs-details">
                            <div class="border-t pt-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-3">{{ __('messages.available_payment_methods') }}</h4>
                                        <div class="space-y-2 text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                <span>{{ __('messages.visa_mastercard') }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                <span>{{ __('messages.mada_saudi_arabia') }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                <span>{{ __('messages.local_wallets') }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                <span>{{ __('messages.apple_google_pay') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-3">{{ __('messages.features_title') }}</h4>
                                        <div class="space-y-1 text-sm text-gray-600">
                                            <div>• {{ __('messages.instant_payment') }}</div>
                                            <div>• {{ __('messages.advanced_security') }}</div>
                                            <div>• {{ __('messages.local_currency_support') }}</div>
                                            <div>• {{ __('messages.arabic_ui') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <button class="w-full paytabs-bg text-white font-semibold py-4 rounded-xl hover:opacity-90 transition duration-300" 
                                {{-- onclick="openModal('paytabs')" --}}
                                onclick="openAlert()"
                                >

                                    <i class="fas fa-lock mr-2"></i>
                                    {{ __('messages.pay_with_paytabs_button') }}
                                </button>
                                <script>
                                    function openAlert(){
                                        alert("coming soon");
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                    <div class="bg-white rounded-lg p-6 w-full max-w-md">
                        <h3 class="text-xl font-bold mb-4" id="modal-title"></h3>
                        <p class="text-gray-600 mb-6" id="modal-description"></p>
                        <form action="{{ route('payment.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="subscription_id" value="{{ $subscription['id'] ?? '' }}">
                            <input type="hidden" name="payment_method" id="payment-method">
                            <div class="mb-4">
                                <label for="card-number" class="block text-gray-700 font-semibold mb-2">{{ __('messages.modal_card_number') }}</label>
                                <input type="text" id="card-number" class="w-full p-3 border rounded-lg" placeholder="1234 5678 9012 3456" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="expiry-date" class="block text-gray-700 font-semibold mb-2">{{ __('messages.modal_expiry_date') }}</label>
                                    <input type="text" id="expiry-date" class="w-full p-3 border rounded-lg" placeholder="MM/YY" required>
                                </div>
                                <div>
                                    <label for="cvv" class="block text-gray-700 font-semibold mb-2">{{ __('messages.modal_cvv') }}</label>
                                    <input type="text" id="cvv" class="w-full p-3 border rounded-lg" placeholder="123" required>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
                                {{ __('messages.modal_confirm_payment') }}
                            </button>
                        </form>
                        <button class="mt-4 w-full bg-gray-300 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-400 transition duration-300" onclick="closeModal()">
                            {{ __('messages.modal_close') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 glow-effect sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">{{ __('messages.order_summary') }}</h2>
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg">{{ __('messages.selected_plan') }}</span>
                            <span class="text-lg font-semibold text-indigo-600">
                                {{ $subscription?->name_en ?? __('messages.no_plan_selected') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center text-xl font-bold text-gray-900">
                        <span>{{ __('messages.total_amount') }}</span>
                        <span>
                            {{ $subscription ? number_format($subscription->price, 2) : 'N/A' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center text-xl font-bold text-gray-900">
                        <span>{{ __('messages.daily_operations') }}</span>
                        <span>
                            {{ $subscription->daily_operations_limit ?? __('messages.no_limit') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function openModal(paymentMethod) {
            // إظهار المودال
            document.getElementById('payment-modal').classList.remove('hidden');
            // تخزين نوع وسيلة الدفع
            document.getElementById('payment-method').value = paymentMethod;

            // تحديث العنوان والوصف حسب الميثود
            const title = document.getElementById('modal-title');
            const desc = document.getElementById('modal-description');

            if (paymentMethod === 'paytabs') {
                title.innerText = "Pay with PayTabs";
                desc.innerText = "Please enter your card details securely.";
            } else if (paymentMethod === 'paypal') {
                title.innerText = "Pay with PayPal";
                desc.innerText = "Redirecting you to PayPal for secure checkout.";
            } else if (paymentMethod === 'bank') {
                title.innerText = "Bank Transfer";
                desc.innerText = "Please provide your transfer details.";
            }
        }

        function closeModal() {
            document.getElementById('payment-modal').classList.add('hidden');
        }

    </script>

    <script>
        let activePayment = null;

        function togglePayment(event, paymentType) {
            if (event.target.closest('.payment-details')) {
                return;
            }

            const details = document.getElementById(paymentType + '-details');
            const arrow = document.getElementById(paymentType + '-arrow');
            const option = details.parentElement;

            document.querySelectorAll('.payment-details').forEach(detail => {
                if (detail !== details) {
                    detail.classList.remove('show');
                    detail.parentElement.classList.remove('active');
                }
            });

            document.querySelectorAll('[id$="-arrow"]').forEach(arr => {
                arr.style.transform = 'rotate(0deg)';
            });

            if (activePayment === paymentType) {
                details.classList.remove('show');
                option.classList.remove('active');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
                activePayment = null;
            } else {
                details.classList.add('show');
                option.classList.add('active');
                if (arrow) {
                    arrow.style.transform = 'rotate(180deg)';
                }
                activePayment = paymentType;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.payment-option');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('slide-up');
                }, index * 100);
            });
            const securityIcons = document.querySelectorAll('.fa-lock, .fa-shield-alt, .fa-user-shield');
            securityIcons.forEach(icon => {
                icon.classList.add('pulse-animation');
            });
        });

    </script>

</body>
@endsection
