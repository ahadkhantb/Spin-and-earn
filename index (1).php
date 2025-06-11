<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spin and Win!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Hind Siliguri', sans-serif;
        }
        /* হুইল ঘোরার জন্য অ্যানিমেশন */
        #wheel {
            transition: transform 5s ease-out;
        }
        /* হুইলের উপরে পয়েন্টার স্টাইল */
        .pointer {
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-top: 40px solid #ef4444; /* Red color for pointer */
            position: absolute;
            top: -15px; /* Position it above the wheel's center */
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }
        /* Modal background */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.6);
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-6 md:p-10 rounded-2xl shadow-2xl text-center max-w-md w-full">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">স্পিন করে জিতে নিন!</h1>
        <p class="text-gray-600 mb-6">আপনার ভাগ্য পরীক্ষা করুন এবং আকর্ষণীয় পুরস্কার জিতুন।</p>
        
        <!-- Disclaimer -->
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-lg">
          <p class="font-bold">গুরুত্বপূর্ণ ಸೂಚনা</p>
          <p class="text-sm">পেমেন্ট পেতে সকল রুলস্ ফলো করুন ধন্যবাদ।</p>
        </div>

        <!-- Wheel and Pointer Container -->
        <div class="relative w-72 h-72 md:w-80 md:h-80 mx-auto mb-8 flex items-center justify-center">
            <div class="pointer"></div>
            <!-- User's uploaded image will be used here -->
            <img id="wheel" src="https://i.ibb.co/tP1dx6h7/download-26-removebg-preview.png" alt="Spinning Wheel" class="w-full h-full object-contain">
        </div>
        
        <!-- Spin Button -->
        <button id="spin-btn" class="bg-gradient-to-r from-green-400 to-blue-500 hover:from-green-500 hover:to-blue-600 text-white font-bold py-3 px-10 rounded-full shadow-lg transform hover:scale-105 transition-transform duration-300">
            চাকা ঘোরান!
        </button>

        <!-- Winning Result Display -->
        <div id="result-display" class="mt-6 text-2xl font-semibold text-indigo-600 hidden"></div>

    </div>

    <!-- Bank Info Modal -->
    <div id="form-modal" class="fixed inset-0 modal-backdrop items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 md:p-8 animate-fade-in">
            <h2 class="text-2xl font-bold text-center mb-2">অভিনন্দন! আপনি জিতেছেন!</h2>
            <p class="text-center text-gray-600 mb-6">পুরস্কার গ্রহণ করতে আপনার ব্যাংক অ্যাকাউন্টের তথ্য দিন।</p>
            <form id="bank-form">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">সম্পূর্ণ নাম</label>
                    <input type="text" id="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="আপনার পুরো নাম লিখুন" required>
                </div>
                <div class="mb-4">
                    <label for="bankName" class="block text-gray-700 font-semibold mb-2">ব্যাংকের নাম</label>
                    <input type="text" id="bankName" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="ব্যাংকের নাম" required>
                </div>
                <div class="mb-4">
                    <label for="accountNumber" class="block text-gray-700 font-semibold mb-2">অ্যাকাউন্ট নম্বর</label>
                    <input type="text" id="accountNumber" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="অ্যাকাউন্ট নম্বর" required>
                </div>
                <div class="mb-6">
                    <label for="ifsc" class="block text-gray-700 font-semibold mb-2">IFSC কোড</label>
                    <input type="text" id="ifsc" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="IFSC কোড" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition-colors duration-300">
                    জমা দিন
                </button>
            </form>
        </div>
    </div>

    <!-- WhatsApp Share Modal -->
    <div id="share-modal" class="fixed inset-0 modal-backdrop items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8 text-center animate-fade-in">
            <h2 class="text-2xl font-bold text-green-500 mb-4">ধন্যবাদ!</h2>
            <p class="text-gray-700 mb-6">আপনার পুরস্কারটি দাবি করার জন্য শেষ ধাপটি সম্পূর্ণ করুন। এই অফারটি আপনার ১০ জন বন্ধু বা গ্রুপকে হোয়াটসঅ্যাপে শেয়ার করুন।</p>
            <a id="whatsapp-share-btn" href="#" target="_blank" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                এখনই শেয়ার করুন
            </a>
        </div>
    </div>

    <script>
        const spinBtn = document.getElementById('spin-btn');
        const wheel = document.getElementById('wheel');
        const resultDisplay = document.getElementById('result-display');
        
        const formModal = document.getElementById('form-modal');
        const shareModal = document.getElementById('share-modal');
        const bankForm = document.getElementById('bank-form');
        const whatsappShareBtn = document.getElementById('whatsapp-share-btn');

        // হুইলের প্রতিটি সেগমেন্টের মান
        const segments = ["10$", "5$", "2$", "50$", "1$", "5$", "20$", "JACKPOT", "15$", "100$", "1$", "ZERO"];
        const segmentDegrees = 360 / segments.length; // প্রতিটি সেগমেন্টের জন্য কোণ

        let isSpinning = false;
        let currentRotation = 0;

        spinBtn.addEventListener('click', () => {
            if (isSpinning) return;

            isSpinning = true;
            spinBtn.disabled = true;
            spinBtn.textContent = 'ঘুরছে...';
            resultDisplay.classList.add('hidden');

            // একটি র‍্যান্ডম ঘূর্ণন তৈরি করুন
            const randomSpins = Math.floor(Math.random() * 5) + 5; // 5 থেকে 9 বার পুরো ঘুরবে
            const randomStopAngle = Math.floor(Math.random() * 360);
            const totalRotation = (randomSpins * 360) + randomStopAngle;
            
            currentRotation += totalRotation;
            
            wheel.style.transform = `rotate(${currentRotation}deg)`;

            // স্পিন শেষ হওয়ার জন্য অপেক্ষা করুন
            setTimeout(() => {
                isSpinning = false;
                spinBtn.disabled = false;
                spinBtn.textContent = 'আবার ঘোরান!';

                // কোন সেগমেন্ট জিতেছে তা নির্ধারণ করুন
                const finalRotation = currentRotation % 360;
                const winningSegmentIndex = Math.floor((360 - finalRotation) / segmentDegrees) % segments.length;
                const winningValue = segments[winningSegmentIndex];
                
                if (winningValue === 'ZERO' || winningValue === 'JACKPOT') {
                    resultDisplay.textContent = `আপনি ${winningValue} জিতেছেন!`;
                } else {
                    resultDisplay.textContent = `অভিনন্দন! আপনি ${winningValue} জিতেছেন!`;
                }
                
                resultDisplay.classList.remove('hidden');

                // যদি 'ZERO' না হয়, তাহলে ফর্ম দেখান
                if (winningValue !== 'ZERO') {
                    setTimeout(() => {
                        formModal.classList.remove('hidden');
                        formModal.classList.add('flex');
                    }, 1000); // 1 সেকেন্ড পরে ফর্ম দেখান
                }

            }, 5000); // অ্যানিমেশন সময় (5 সেকেন্ড)
        });

        // ব্যাংক ফর্ম জমা দেওয়ার পর
        bankForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            formModal.classList.remove('flex');
            formModal.classList.add('hidden');
            
            shareModal.classList.remove('hidden');
            shareModal.classList.add('flex');
            
            // হোয়াটসঅ্যাপ শেয়ার লিঙ্ক তৈরি করুন
            const shareText = encodeURIComponent("আমি এই দারুন স্পিন গেম থেকে একটি পুরস্কার জিতেছি! আপনিও আপনার ভাগ্য পরীক্ষা করে দেখতে পারেন: demo.kenakata24.shop");
            whatsappShareBtn.href = `https://api.whatsapp.com/send?text=${shareText}`;
        });

    </script>

</body>
</html>
