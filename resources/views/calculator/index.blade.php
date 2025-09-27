@extends('layouts.main')

@section('title', 'Zakat Calculator')

@section('navbar')
    @include('partials.navbarHome')
@endsection

@section('content')
<div class="relative bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-40 h-40 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-0 w-40 h-40 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-40 h-40 bg-cyan-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <div class="absolute inset-0 bg-opacity-5 bg-emerald-900" style="background-image: url('data:image/svg+xml,<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><g fill="%23059669" fill-opacity="0.05"><path d="M20 20c0 11.046-8.954 20-20 20s-20-8.954-20-20 8.954-20 20-20 20 8.954 20 20zm-30 0c0 5.523 4.477 10 10 10s10-4.477 10-10-4.477-10-10-10-10 4.477-10 10z"/></g></svg></div>

    <div class="relative container mx-auto px-4 py-16">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mt-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-full mb-6 shadow-lg">
                    <i class="fas fa-calculator text-white text-3xl"></i>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-6">
                    Zakat Calculator
                </h1>
               
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-16">
                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-white/50 hover:border-emerald-200 overflow-hidden">
                    <div class="p-6 text-center relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 to-teal-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10">
                            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-coins text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Zakat Mal</h3>
                            <p class="text-gray-600 mb-4 text-sm leading-relaxed">Calculate zakat on your wealth, savings, and assets according to Islamic guidelines</p>
                            <button class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-6 py-2 rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 w-full font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-sm" 
                                    onclick="openCalculator('mal')">
                                <i class="fas fa-calculator mr-2"></i>Calculate Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-white/50 hover:border-blue-200 overflow-hidden">
                    <div class="p-6 text-center relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-indigo-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-heart text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Zakat Fitrah</h3>
                            <p class="text-gray-600 mb-4 text-sm leading-relaxed">Calculate zakat fitrah for Ramadan based on rice prices and family members</p>
                            <button class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 w-full font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-sm" 
                                    onclick="openCalculator('fitrah')">
                                <i class="fas fa-calculator mr-2"></i>Calculate Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-white/50 hover:border-purple-200 overflow-hidden">
                    <div class="p-6 text-center relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-50/50 to-indigo-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10">
                            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-briefcase text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Zakat Profesi</h3>
                            <p class="text-gray-600 mb-4 text-sm leading-relaxed">Calculate zakat on professional income and monthly earnings</p>
                            <button class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-2 rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-300 w-full font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-sm" 
                                    onclick="openCalculator('profesi')">
                                <i class="fas fa-calculator mr-2"></i>Calculate Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-white/50 hover:border-yellow-200 overflow-hidden">
                    <div class="p-6 text-center relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-50/50 to-orange-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10">
                            <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-gem text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Zakat Emas</h3>
                            <p class="text-gray-600 mb-4 text-sm leading-relaxed">Calculate zakat on gold, silver, and precious metals</p>
                            <button class="bg-gradient-to-r from-yellow-600 to-orange-600 text-white px-6 py-2 rounded-xl hover:from-yellow-700 hover:to-orange-700 transition-all duration-300 w-full font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-sm" 
                                    onclick="openCalculator('emas')">
                                <i class="fas fa-calculator mr-2"></i>Calculate Now
                            </button>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="calculatorModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all duration-300 scale-95">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 id="modalTitle" class="text-2xl font-bold text-gray-800"></h3>
                    <button onclick="closeCalculator()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all duration-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div id="calculatorContent">
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl p-12 shadow-lg">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">About Zakat</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">Understanding the spiritual and social significance of zakat in Islamic faith</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl w-16 h-16 flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-hand-holding-heart text-white text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 mb-3">Purification</h4>
                        <p class="text-gray-600 leading-relaxed">Zakat purifies your wealth and soul, creating spiritual balance and divine blessing</p>
                    </div>
                    
                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl w-16 h-16 flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 mb-3">Community</h4>
                        <p class="text-gray-600 leading-relaxed">Helps build stronger communities by supporting those in need and fostering unity</p>
                    </div>
                    
                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl w-16 h-16 flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-balance-scale text-white text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 mb-3">Justice</h4>
                        <p class="text-gray-600 leading-relaxed">Promotes social and economic justice through equitable wealth distribution</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gradient-to-br from-emerald-600 to-teal-700 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-12 border border-white/20">
                <h2 class="text-4xl font-bold text-white mb-6">Ready to Pay Your Zakat?</h2>
                <p class="text-xl text-emerald-100 mb-8 max-w-2xl mx-auto">
                    After calculating your zakat obligation, you can proceed to make your payment directly without creating an account.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('guest.payment.create') }}"
                        class="group bg-white hover:bg-emerald-50 text-emerald-700 hover:text-emerald-800 font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex items-center gap-3 min-w-[250px]">
                        <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L3.09 8.26L12 22L20.91 8.26L12 2Z"/>
                        </svg>
                        <span class="font-semibold tracking-wide">PAY ZAKAT NOW</span>
                    </a>
                    <p class="text-emerald-100 text-sm">
                        <i class="fas fa-info-circle mr-2"></i>
                        No account required • Quick payment process • Instant receipt
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>

<script>
function openCalculator(type) {
    const modal = document.getElementById('calculatorModal');
    const title = document.getElementById('modalTitle');
    const content = document.getElementById('calculatorContent');
    
    const titles = {
        'mal': 'Zakat Mal Calculator',
        'fitrah': 'Zakat Fitrah Calculator',
        'profesi': 'Zakat Profesi Calculator',
        'emas': 'Zakat Emas Calculator'
    };
    
    title.textContent = titles[type];
    
    loadCalculatorForm(type, content);
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.querySelector('div > div').classList.remove('scale-95');
        modal.querySelector('div > div').classList.add('scale-100');
    }, 10);
}

function closeCalculator() {
    const modal = document.getElementById('calculatorModal');
    const modalContent = modal.querySelector('div > div');
    
    modalContent.classList.remove('scale-100');
    modalContent.classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

function loadCalculatorForm(type, container) {
    let formHTML = '';
    let resultHTML = '';
    
    switch(type) {
        case 'mal':
            formHTML = `
                <form id="malForm" onsubmit="calculateZakatMal(event)" class="space-y-6">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 rounded">
                        <p class="text-sm text-blue-700"><strong>Nisab:</strong> Equivalent to 85 grams of gold (approximately IDR 85,000,000)</p>
                        <p class="text-sm text-blue-700"><strong>Rate:</strong> 2.5% annually</p>
                        <p class="text-sm text-blue-700"><strong>Condition:</strong> Wealth must be held for one full lunar year (haul)</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Total Wealth (IDR)</label>
                        <input type="number" id="wealth" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-emerald-500 focus:outline-none transition-colors" placeholder="Enter your total wealth (cash, savings, investments)" required>
                        <p class="text-xs text-gray-500 mt-1">Include: Cash, bank savings, investments, business capital</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Total Debts (IDR)</label>
                        <input type="number" id="debts" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-emerald-500 focus:outline-none transition-colors" placeholder="0">
                        <p class="text-xs text-gray-500 mt-1">Include: Loans, credit cards, mortgages due within the year</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Basic Living Expenses (Annual IDR)</label>
                        <input type="number" id="expenses" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-emerald-500 focus:outline-none transition-colors" placeholder="0">
                        <p class="text-xs text-gray-500 mt-1">Basic necessities: food, clothing, shelter, education</p>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-3 rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 font-semibold shadow-lg">
                        <i class="fas fa-calculator mr-2"></i>Calculate Zakat
                    </button>
                </form>
            `;
            resultHTML = `
                <div id="malResult" class="hidden">
                    <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 border-2 border-emerald-200 rounded-xl p-6">
                        <h4 class="font-bold text-emerald-800 mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>Calculation Result:
                        </h4>
                        <div id="resultTextMal" class="text-emerald-700 mb-4"></div>
                        <div id="paymentAction" class="pt-4 border-t border-emerald-200">
                            <a href="{{ route('guest.payment.create') }}" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg transition-all duration-300 font-semibold">
                                <i class="fas fa-hand-holding-usd mr-2"></i>
                                Pay Zakat Now
                            </a>
                            <p class="text-xs text-emerald-600 mt-2">No account required • Secure payment process</p>
                        </div>
                    </div>
                </div>
            `;
            break;
        case 'fitrah':
            formHTML = `
                <form id="fitrahForm" onsubmit="calculateZakatFitrah(event)" class="space-y-6">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 rounded">
                        <p class="text-sm text-blue-700"><strong>Amount:</strong> 2.5 kg (or 3.5 liters) of staple food per person</p>
                        <p class="text-sm text-blue-700"><strong>Time:</strong> Must be paid before Eid prayer</p>
                        <p class="text-sm text-blue-700"><strong>Recipients:</strong> 8 categories of mustahik</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Number of Family Members</label>
                        <input type="number" id="people" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:outline-none transition-colors" placeholder="Enter number of people" required min="1">
                        <p class="text-xs text-gray-500 mt-1">Include yourself and all dependents</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Staple Food Type</label>
                        <select id="foodType" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:outline-none transition-colors">
                            <option value="rice">Rice (Beras)</option>
                            <option value="wheat">Wheat (Gandum)</option>
                            <option value="dates">Dates (Kurma)</option>
                            <option value="barley">Barley (Gandum Hitam)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Price per kg (IDR)</label>
                        <input type="number" id="foodPrice" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:outline-none transition-colors" placeholder="15000">
                        <p class="text-xs text-gray-500 mt-1">Current market price of the staple food</p>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 font-semibold shadow-lg">
                        <i class="fas fa-calculator mr-2"></i>Calculate Zakat
                    </button>
                </form>
            `;
            resultHTML = `
                <div id="fitrahResult" class="hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl p-6">
                        <h4 class="font-bold text-blue-800 mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>Calculation Result:
                        </h4>
                        <div id="resultTextFitrah" class="text-blue-700 mb-4"></div>
                        <div id="paymentAction" class="pt-4 border-t border-blue-200">
                            <a href="{{ route('guest.payment.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-all duration-300 font-semibold">
                                <i class="fas fa-hand-holding-usd mr-2"></i>
                                Pay Zakat Now
                            </a>
                            <p class="text-xs text-blue-600 mt-2">No account required • Secure payment process</p>
                        </div>
                    </div>
                </div>
            `;
            break;
        case 'profesi':
            formHTML = `
                <form id="profesiForm" onsubmit="calculateZakatProfesi(event)" class="space-y-6">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 rounded">
                        <p class="text-sm text-blue-700"><strong>Nisab:</strong> Equivalent to 85 grams of gold monthly</p>
                        <p class="text-sm text-blue-700"><strong>Rate:</strong> 2.5% of net income</p>
                        <p class="text-sm text-blue-700"><strong>Payment:</strong> Can be paid monthly or annually</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Gross Monthly Income (IDR)</label>
                        <input type="number" id="income" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-purple-500 focus:outline-none transition-colors" placeholder="Enter your gross monthly income" required>
                        <p class="text-xs text-gray-500 mt-1">Total income before any deductions</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Monthly Basic Needs (IDR)</label>
                        <input type="number" id="basicNeeds" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-purple-500 focus:outline-none transition-colors" placeholder="0">
                        <p class="text-xs text-gray-500 mt-1">Food, housing, clothing, transportation, education</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Monthly Debt Payments (IDR)</label>
                        <input type="number" id="debtPayments" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-purple-500 focus:outline-none transition-colors" placeholder="0">
                        <p class="text-xs text-gray-500 mt-1">Loan installments, credit card payments</p>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-300 font-semibold shadow-lg">
                        <i class="fas fa-calculator mr-2"></i>Calculate Zakat
                    </button>
                </form>
            `;
            resultHTML = `
                <div id="profesiResult" class="hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 border-2 border-purple-200 rounded-xl p-6">
                        <h4 class="font-bold text-purple-800 mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>Calculation Result:
                        </h4>
                        <div id="resultTextProfesi" class="text-purple-700 mb-4"></div>
                        <div id="paymentAction" class="pt-4 border-t border-purple-200">
                            <a href="{{ route('guest.payment.create') }}" class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg transition-all duration-300 font-semibold">
                                <i class="fas fa-hand-holding-usd mr-2"></i>
                                Pay Zakat Now
                            </a>
                            <p class="text-xs text-purple-600 mt-2">No account required • Secure payment process</p>
                        </div>
                    </div>
                </div>
            `;
            break;
        case 'emas':
            formHTML = `
                <form id="emasForm" onsubmit="calculateZakatEmas(event)" class="space-y-6">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 rounded">
                        <p class="text-sm text-blue-700"><strong>Gold Nisab:</strong> 85 grams (approx. 20 dinar)</p>
                        <p class="text-sm text-blue-700"><strong>Silver Nisab:</strong> 595 grams (approx. 200 dirham)</p>
                        <p class="text-sm text-blue-700"><strong>Rate:</strong> 2.5% annually</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Precious Metal Type</label>
                        <select id="metalType" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-yellow-500 focus:outline-none transition-colors" onchange="updatePriceField()">
                            <option value="gold">Gold (Emas)</option>
                            <option value="silver">Silver (Perak)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Total Weight (grams)</label>
                        <input type="number" id="weight" step="0.01" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-yellow-500 focus:outline-none transition-colors" placeholder="Enter total weight in grams" required>
                        <p class="text-xs text-gray-500 mt-1">Include all jewelry, bars, coins</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Current Price per gram (IDR)</label>
                        <input type="number" id="pricePerGram" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-yellow-500 focus:outline-none transition-colors" placeholder="1000000">
                        <p class="text-xs text-gray-500 mt-1">Current market price per gram</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Jewelry Deduction (%)</label>
                        <select id="jewelryDeduction" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-yellow-500 focus:outline-none transition-colors">
                            <option value="0">0% - Investment gold/silver (bars, coins)</option>
                            <option value="25">25% - Frequently worn jewelry</option>
                            <option value="50">50% - Occasionally worn jewelry</option>
                            <option value="0">0% - Never worn jewelry (investment)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Some scholars allow deduction for personal use jewelry</p>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-yellow-600 to-orange-600 text-white py-3 rounded-xl hover:from-yellow-700 hover:to-orange-700 transition-all duration-300 font-semibold shadow-lg">
                        <i class="fas fa-calculator mr-2"></i>Calculate Zakat
                    </button>
                </form>
            `;
            resultHTML = `
                <div id="emasResult" class="hidden">
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-100 border-2 border-yellow-200 rounded-xl p-6">
                        <h4 class="font-bold text-yellow-800 mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>Calculation Result:
                        </h4>
                        <div id="resultTextEmas" class="text-yellow-700"></div>
                    </div>
                </div>
            `;
            break;
    }
    
    container.innerHTML = formHTML + resultHTML;
}

function calculateZakatMal(event) {
    event.preventDefault();
    const form = document.getElementById('malForm');
    const result = document.getElementById('malResult');
    const resultText = document.getElementById('resultTextMal');
    
    const wealth = parseFloat(document.getElementById('wealth').value) || 0;
    const debts = parseFloat(document.getElementById('debts').value) || 0;
    const expenses = parseFloat(document.getElementById('expenses').value) || 0;
    
    const goldPricePerGram = 1000000;
    const nisabAmount = 85 * goldPricePerGram; // 85,000,000 IDR
    
    const netWealth = wealth - debts - expenses;
    
    let resultHTML = '';
    
    if (netWealth >= nisabAmount) {
        const zakatAmount = netWealth * 0.025; // 2.5%
        resultHTML = `
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span>Total Wealth:</span>
                    <span class="font-semibold">IDR ${wealth.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Total Debts:</span>
                    <span class="font-semibold">IDR ${debts.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Basic Expenses:</span>
                    <span class="font-semibold">IDR ${expenses.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Net Zakatable Wealth:</span>
                    <span class="font-semibold">IDR ${netWealth.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Nisab (85g gold):</span>
                    <span class="font-semibold">IDR ${nisabAmount.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-emerald-800 bg-emerald-100 p-3 rounded">
                    <span>Zakat Due (2.5%):</span>
                    <span>IDR ${zakatAmount.toLocaleString('id-ID')}</span>
                </div>
                <div class="bg-green-50 p-3 rounded mt-4">
                    <p class="text-sm text-green-700">✓ Your wealth has reached nisab. Zakat is obligatory.</p>
                    <p class="text-sm text-green-700">✓ Ensure this wealth has been held for one full lunar year (haul).</p>
                </div>
            </div>
        `;
    } else {
        const shortfall = nisabAmount - netWealth;
        resultHTML = `
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span>Net Zakatable Wealth:</span>
                    <span class="font-semibold">IDR ${netWealth.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Nisab (85g gold):</span>
                    <span class="font-semibold">IDR ${nisabAmount.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-orange-800 bg-orange-100 p-3 rounded">
                    <span>Shortfall:</span>
                    <span>IDR ${shortfall.toLocaleString('id-ID')}</span>
                </div>
                <div class="bg-yellow-50 p-3 rounded mt-4">
                    <p class="text-sm text-yellow-700">ⓘ Your wealth has not reached nisab. No zakat obligation.</p>
                    <p class="text-sm text-yellow-700">ⓘ Consider voluntary charity (sadaqah) for spiritual rewards.</p>
                </div>
            </div>
        `;
    }
    
    resultText.innerHTML = resultHTML;
    
    form.classList.add('hidden');
    result.classList.remove('hidden');
    result.classList.add('space-y-6');
}

function calculateZakatFitrah(event) {
    event.preventDefault();
    const form = document.getElementById('fitrahForm');
    const result = document.getElementById('fitrahResult');
    const resultText = document.getElementById('resultTextFitrah');
    
    const people = parseInt(document.getElementById('people').value) || 0;
    const foodType = document.getElementById('foodType').value;
    const foodPrice = parseFloat(document.getElementById('foodPrice').value) || 0;
    
    const amountPerPerson = 2.5; // kg
    const totalAmount = people * amountPerPerson;
    const totalCost = totalAmount * foodPrice;
    
    const foodNames = {
        'rice': 'Rice (Beras)',
        'wheat': 'Wheat (Gandum)', 
        'dates': 'Dates (Kurma)',
        'barley': 'Barley (Gandum Hitam)'
    };
    
    const resultHTML = `
        <div class="space-y-3">
            <div class="flex justify-between border-b pb-2">
                <span>Family Members:</span>
                <span class="font-semibold">${people} person(s)</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span>Food Type:</span>
                <span class="font-semibold">${foodNames[foodType]}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span>Amount per Person:</span>
                <span class="font-semibold">${amountPerPerson} kg</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span>Total Amount:</span>
                <span class="font-semibold">${totalAmount} kg</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span>Price per kg:</span>
                <span class="font-semibold">IDR ${foodPrice.toLocaleString('id-ID')}</span>
            </div>
            <div class="flex justify-between text-lg font-bold text-blue-800 bg-blue-100 p-3 rounded">
                <span>Total Zakat Fitrah:</span>
                <span>IDR ${totalCost.toLocaleString('id-ID')}</span>
            </div>
            <div class="bg-blue-50 p-3 rounded mt-4">
                <p class="text-sm text-blue-700">✓ Pay before Eid prayer</p>
                <p class="text-sm text-blue-700">✓ Can be paid from start of Ramadan until Eid</p>
                <p class="text-sm text-blue-700">✓ Better to give actual food than money according to some scholars</p>
            </div>
        </div>
    `;
    
    resultText.innerHTML = resultHTML;
    
    form.classList.add('hidden');
    result.classList.remove('hidden');
    result.classList.add('space-y-6');
}

function calculateZakatProfesi(event) {
    event.preventDefault();
    const form = document.getElementById('profesiForm');
    const result = document.getElementById('profesiResult');
    const resultText = document.getElementById('resultTextProfesi');

    const grossIncome = parseFloat(document.getElementById('income').value) || 0;
    const basicNeeds = parseFloat(document.getElementById('basicNeeds').value) || 0;
    const debtPayments = parseFloat(document.getElementById('debtPayments').value) || 0;
    
    const goldPricePerGram = 1000000;
    const monthlyNisab = (85 * goldPricePerGram) / 12; // Approximately 7,083,333 IDR
    
    const netIncome = grossIncome - basicNeeds - debtPayments;
    
    let resultHTML = '';
    
    if (netIncome >= monthlyNisab) {
        const monthlyZakat = netIncome * 0.025; // 2.5%
        const annualZakat = monthlyZakat * 12;
        
        resultHTML = `
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span>Gross Monthly Income:</span>
                    <span class="font-semibold">IDR ${grossIncome.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Basic Needs:</span>
                    <span class="font-semibold">IDR ${basicNeeds.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Debt Payments:</span>
                    <span class="font-semibold">IDR ${debtPayments.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Net Income:</span>
                    <span class="font-semibold">IDR ${netIncome.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Monthly Nisab:</span>
                    <span class="font-semibold">IDR ${monthlyNisab.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-purple-800 bg-purple-100 p-3 rounded">
                    <span>Monthly Zakat (2.5%):</span>
                    <span>IDR ${monthlyZakat.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-purple-800 bg-purple-100 p-3 rounded">
                    <span>Annual Zakat:</span>
                    <span>IDR ${annualZakat.toLocaleString('id-ID')}</span>
                </div>
                <div class="bg-green-50 p-3 rounded mt-4">
                    <p class="text-sm text-green-700">✓ Your income has reached nisab. Zakat is obligatory.</p>
                    <p class="text-sm text-green-700">✓ You can pay monthly or save for annual payment.</p>
                </div>
            </div>
        `;
    } else {
        const shortfall = monthlyNisab - netIncome;
        resultHTML = `
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span>Net Monthly Income:</span>
                    <span class="font-semibold">IDR ${netIncome.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Monthly Nisab:</span>
                    <span class="font-semibold">IDR ${monthlyNisab.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-orange-800 bg-orange-100 p-3 rounded">
                    <span>Shortfall:</span>
                    <span>IDR ${shortfall.toLocaleString('id-ID')}</span>
                </div>
                <div class="bg-yellow-50 p-3 rounded mt-4">
                    <p class="text-sm text-yellow-700">ⓘ Your income has not reached nisab. No zakat obligation.</p>
                    <p class="text-sm text-yellow-700">ⓘ Consider voluntary charity (sadaqah) for spiritual rewards.</p>
                </div>
            </div>
        `;
    }
    
    resultText.innerHTML = resultHTML;

    form.classList.add('hidden');
    result.classList.remove('hidden');
    result.classList.add('space-y-6');
}

function calculateZakatEmas(event) {
    event.preventDefault();
    const form = document.getElementById('emasForm');
    const result = document.getElementById('emasResult');
    const resultText = document.getElementById('resultTextEmas');

    const metalType = document.getElementById('metalType').value;
    const weight = parseFloat(document.getElementById('weight').value) || 0;
    const pricePerGram = parseFloat(document.getElementById('pricePerGram').value) || 0;
    const jewelryDeduction = parseFloat(document.getElementById('jewelryDeduction').value) || 0;
    
    const goldNisab = 85; // grams
    const silverNisab = 595; // grams
    
    const nisab = metalType === 'gold' ? goldNisab : silverNisab;
    const totalValue = weight * pricePerGram;
    const deductionAmount = totalValue * (jewelryDeduction / 100);
    const netValue = totalValue - deductionAmount;
    const netWeight = netValue / pricePerGram;
    
    let resultHTML = '';
    
    if (netWeight >= nisab) {
        const zakatAmount = netValue * 0.025; // 2.5%
        const zakatInGrams = zakatAmount / pricePerGram;
        
        resultHTML = `
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span>Metal Type:</span>
                    <span class="font-semibold">${metalType === 'gold' ? 'Gold (Emas)' : 'Silver (Perak)'}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Total Weight:</span>
                    <span class="font-semibold">${weight} grams</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Price per gram:</span>
                    <span class="font-semibold">IDR ${pricePerGram.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Total Value:</span>
                    <span class="font-semibold">IDR ${totalValue.toLocaleString('id-ID')}</span>
                </div>
                ${jewelryDeduction > 0 ? `
                <div class="flex justify-between border-b pb-2">
                    <span>Jewelry Deduction (${jewelryDeduction}%):</span>
                    <span class="font-semibold">IDR ${deductionAmount.toLocaleString('id-ID')}</span>
                </div>
                ` : ''}
                <div class="flex justify-between border-b pb-2">
                    <span>Net Zakatable Value:</span>
                    <span class="font-semibold">IDR ${netValue.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Nisab (${nisab}g):</span>
                    <span class="font-semibold">${nisab} grams</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-yellow-800 bg-yellow-100 p-3 rounded">
                    <span>Zakat Due (2.5%):</span>
                    <span>IDR ${zakatAmount.toLocaleString('id-ID')}</span>
                </div>
                <div class="flex justify-between text-sm font-semibold text-yellow-700 bg-yellow-50 p-2 rounded">
                    <span>Equivalent in ${metalType}:</span>
                    <span>${zakatInGrams.toFixed(2)} grams</span>
                </div>
                <div class="bg-green-50 p-3 rounded mt-4">
                    <p class="text-sm text-green-700">✓ Your ${metalType} has reached nisab. Zakat is obligatory.</p>
                    <p class="text-sm text-green-700">✓ Ensure this ${metalType} has been held for one full lunar year (haul).</p>
                    ${jewelryDeduction > 0 ? '<p class="text-sm text-green-700">✓ Deduction applied for personal use jewelry.</p>' : ''}
                </div>
            </div>
        `;
    } else {
        const shortfall = nisab - netWeight;
        resultHTML = `
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span>Net Weight:</span>
                    <span class="font-semibold">${netWeight.toFixed(2)} grams</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span>Nisab (${nisab}g):</span>
                    <span class="font-semibold">${nisab} grams</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-orange-800 bg-orange-100 p-3 rounded">
                    <span>Shortfall:</span>
                    <span>${shortfall.toFixed(2)} grams</span>
                </div>
                <div class="bg-yellow-50 p-3 rounded mt-4">
                    <p class="text-sm text-yellow-700">ⓘ Your ${metalType} has not reached nisab. No zakat obligation.</p>
                    <p class="text-sm text-yellow-700">ⓘ Consider voluntary charity (sadaqah) for spiritual rewards.</p>
                </div>
            </div>
        `;
    }
    
    resultText.innerHTML = resultHTML;

    form.classList.add('hidden');
    result.classList.remove('hidden');
}

// Helper function to update price field for gold/silver
function updatePriceField() {
    const metalType = document.getElementById('metalType').value;
    const priceField = document.getElementById('pricePerGram');
    
    if (metalType === 'gold') {
        priceField.placeholder = '1000000'; // Approximate gold price
        priceField.value = '';
    } else {
        priceField.placeholder = '15000'; // Approximate silver price
        priceField.value = '';
    }
}

// Close modal when clicking outside
document.getElementById('calculatorModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCalculator();
    }
});
</script>
@endsection