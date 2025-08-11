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
            , title: 'نجاح!'
            , text: '{{ session('success') }}'
            , showConfirmButton: false
            , timer: 3000 // الرسالة هتختفي بعد 3 ثواني
        });

    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error'
            , title: 'خطأ!'
            , text: '{{ session('error') }}'
        , });

    </script>
    @endif
    <main class="container mx-auto px-6 py-12">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Choose Your Payment Method</h2>
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
                                    <p class="text-gray-600 mt-2">الطريقة الأكثر أمانًا</p>
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
                                        <span class="text-sm text-yellow-700">حماية المشتري مضمونة</span>
                                    </div>
                                </div>
                                <form action="{{ route('paypal.pay') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-yellow-500 text-white font-semibold py-4 rounded-xl hover:bg-yellow-600 transition duration-300">
                                        ادفع باستخدام PayPal
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
                                    <h3 class="text-xl font-bold text-gray-800">التحويل البنكي</h3>
                                    <p class="text-gray-600 mt-2">تحويل بنكي مباشر</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full mr-3">رسوم أقل</span>
                                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="bank-arrow"></i>
                            </div>
                        </div>

                        <div class="payment-details hidden" id="bank-details">
                            <div class="border-t pt-6">
                                @if(isset($bankDetail))
                                <div class="bg-gray-100 rounded-lg p-4 mb-6 border border-gray-200">
                                    <h4 class="text-lg font-bold text-gray-800 mb-3">تفاصيل الحساب البنكي</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                                        <div>
                                            <span class="font-semibold text-gray-900">اسم البنك:</span>
                                            <span class="block mt-1">{{ $bankDetail->bank_name }}</span>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-900">اسم صاحب الحساب:</span>
                                            <span class="block mt-1">{{ $bankDetail->account_holder_name }}</span>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-900">رقم الحساب:</span>
                                            <span class="block mt-1">{{ $bankDetail->account_number }}</span>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-900">رقم الايبان (IBAN):</span>
                                            <span class="block mt-1">{{ $bankDetail->iban }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <p class="text-sm text-gray-600 mb-4">بعد إتمام التحويل البنكي، يرجى ملء النموذج التالي ورفع إيصال الدفع لتأكيد العملية. سيتم مراجعة طلبك وتفعيل اشتراكك في أقرب وقت.</p>

                                <form action="{{ route('payment.bank_transfer.submit') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">

                                    <div class="mb-4">
                                        <label for="sender_name" class="block text-gray-700 font-semibold mb-2">اسم صاحب الحساب المحول منه</label>
                                        <input type="text" id="sender_name" name="sender_name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="amount" class="block text-gray-700 font-semibold mb-2">المبلغ المحول</label>
                                        <input type="text" id="amount" name="amount" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                    </div>

                                    <div class="mb-6">
                                        <label for="transfer_receipt" class="block text-gray-700 font-semibold mb-2">إيصال التحويل</label>
                                        <input type="file" id="transfer_receipt" name="transfer_receipt" class="w-full text-gray-700" required>
                                        <p class="mt-2 text-sm text-gray-500">صيغ الملفات المسموح بها: JPG, PNG, PDF</p>
                                    </div>

                                    <button type="submit" class="w-full bg-green-500 text-white font-semibold py-4 rounded-xl hover:bg-green-600 transition duration-300">
                                        تأكيد وإرسال الإيصال
                                    </button>
                                </form>

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
                                    <h3 class="text-xl font-bold text-gray-800">PayTabs</h3>
                                    <p class="text-gray-600">بوابة دفع محلية ودولية</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full mr-3">الأكثر شيوعًا</span>
                                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="paytabs-arrow"></i>
                            </div>
                        </div>
                        <div class="payment-details hidden" id="paytabs-details">
                            <div class="border-t pt-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-3">طرق الدفع المتاحة:</h4>
                                        <div class="space-y-2 text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                <span>فيزا وماستركارد</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                <span>مدى، السعودية</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                <span>محافظ إلكترونية محلية</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                <span>Apple Pay و Google Pay</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-3">الميزات:</h4>
                                        <div class="space-y-1 text-sm text-gray-600">
                                            <div>• معالجة الدفع الفوري</div>
                                            <div>• حماية أمنية متقدمة</div>
                                            <div>• دعم العملات المحلية</div>
                                            <div>• واجهة مستخدم عربية</div>
                                        </div>
                                    </div>
                                </div>
                                <button class="w-full paytabs-bg text-white font-semibold py-4 rounded-xl hover:opacity-90 transition duration-300" onclick="openModal('paytabs')">
                                    <i class="fas fa-lock mr-2"></i>
                                    ادفع الآن باستخدام PayTabs
                                </button>
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
                                <label for="card-number" class="block text-gray-700 font-semibold mb-2">رقم البطاقة</label>
                                <input type="text" id="card-number" class="w-full p-3 border rounded-lg" placeholder="1234 5678 9012 3456" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="expiry-date" class="block text-gray-700 font-semibold mb-2">تاريخ الانتهاء</label>
                                    <input type="text" id="expiry-date" class="w-full p-3 border rounded-lg" placeholder="MM/YY" required>
                                </div>
                                <div>
                                    <label for="cvv" class="block text-gray-700 font-semibold mb-2">CVV</label>
                                    <input type="text" id="cvv" class="w-full p-3 border rounded-lg" placeholder="123" required>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
                                تأكيد الدفع
                            </button>
                        </form>
                        <button class="mt-4 w-full bg-gray-300 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-400 transition duration-300" onclick="closeModal()">
                            إغلاق
                        </button>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 glow-effect sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Order Summary</h2>
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg">Selected Plan:</span>
                            <span class="text-lg font-semibold text-indigo-600">
                                {{ $subscription?->name_en ?? 'No Plan Selected' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center text-xl font-bold text-gray-900">
                        <span>Total Amount:</span>
                        <span>
                            {{ $subscription ? number_format($subscription->price, 2) : 'N/A' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center text-xl font-bold text-gray-900">
                        <span>Daily Operations:</span>
                        <span>
                            {{ $subscription->daily_operations_limit ?? 'No Limit' }}
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
        let activePayment = null;

        function togglePayment(event, paymentType) {
            // هنا الكود بيمنع إن الضغطة على أي حاجة داخل payment-details تقفل القائمة
            if (event.target.closest('.payment-details')) {
                return; // بيتجاهل تنفيذ باقي الكود لو الضغطة كانت جوه تفاصيل الدفع
            }

            const details = document.getElementById(paymentType + '-details');
            const arrow = document.getElementById(paymentType + '-arrow');
            const option = details.parentElement;

            // ... باقي الكود من هنا زي ما هو ...
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
