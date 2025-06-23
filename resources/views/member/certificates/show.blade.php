<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between items-center">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
            {{ $certificate->title }}
        </h2>
        <a href="{{ route('member.certificates.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to My <Certificates></Certificates>
            </a>
    </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $certificate->title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Issued on: {{ \Carbon\Carbon::parse($issuedAt)->format('F j, Y') }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('certificates.download', ['certificate' => $certificate->id, 'member' => $member->id]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Download Certificate
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="certificate-container">
                    <div class="certificate">
                        <div class="border-outer"></div>
                        <div class="border-inner"></div>
                        
                        <div class="certificate-content">
                            <div class="batch-number">
                                <p>BATCH NUMBER</p>
                            </div>
                            <div class="header-image">
                                <img src="{{ asset('images/rec.png') }}" alt="Header Image">
                            </div>
                            <div class="certificate-title">
                                <h2>
                                    <span>{{ $certificate->title}}</span>
                                </h2>
                            </div>
                            <div class="recipient-text">
                                <p>This certifies that</p>
                                <div class="recipient">{{ $member->first_name }} {{ $member->last_name }}</div>
                                <div class="name-line"></div>
                                <div class="membership-text">
                                    {!! $certificate->content !!}
                                </div>
                            </div>
                            <div class="signatures">
                                @foreach($certificate->signatories as $signatory)
                                    <div class="signature">
                                        <div class="signature-line"></div>
                                        <div class="signature-name">{{ $signatory->name }}</div>
                                        @if($signatory->position)
                                            <div class="signature-title">{{ $signatory->position }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>      
                            <div class="logo-bottom">
                                <img src="{{ asset('images/propagate.png') }}" alt="Propagate Image">
                            </div>
                        </div>
                        <div class="wave-bottom">
                            <img src="{{ asset('images/bot.png') }}" alt="Left Bottom Image">
                        </div>
                        <div class="wave-top">
                            <img src="{{ asset('images/top.png') }}" alt="Right Top Image">
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Include all the styles from your jcertificate.blade.php here */
        .certificate-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 0;
            margin-top: 8rem;
        }
        
        .certificate {
            page-break-inside: avoid;
            page-break-after: avoid;
            page-break-before: avoid;
            width: 297mm;
            height: 210mm;
            padding: 15mm;
            background-color: white;
            position: relative;
            margin: 0 auto;
            margin-bottom: 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background-image: url('https://static.vecteezy.com/system/resources/thumbnails/006/513/062/small_2x/abstract-clean-white-soft-cloth-background-with-soft-waves-luxury-gray-curved-smooth-curtain-background-illustration-free-vector.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        
        .border-outer {
            position: absolute;
            top: 5mm;
            left: 5mm;
            right: 5mm;
            bottom: 5mm;
            border: 3px solid #0c044c;
            pointer-events: none;
        }
        
        .border-inner {
            position: absolute;
            top: 10mm;
            left: 10mm;
            right: 10mm;
            bottom: 10mm;
            border: 2px solid #5898b0;
            pointer-events: none;
        }
        
        .certificate-content {
            height: 180mm;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        
        .batch-number {
            text-align: left;
            font-size: 1rem;
            font-weight: bold;
        }
        
        .header-image img {
            max-height: 80px;
            width: auto;
        }
        
        .certificate-title h2 {
            font-size: 3.75rem;
            font-weight: 800;
            position: relative;
            color: #041c5c;
        }
        
        .certificate-title span {
            display: inline-block;
            padding-bottom: 3mm;
            margin-bottom: 10mm;
        }
        
        .recipient-text {
            text-align: center;
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }
        
        .name-line {
            border-bottom: 2px solid black;
            width: 58.333333%;
            margin: 0 auto;
            height: 10mm;
            margin-top: 8mm;
            margin-bottom: 8mm;
        }
        
        .membership-text {
            text-align: center;
            font-size: 1.125rem;
            line-height: 1.8;
            margin-top: 8mm;
            margin-bottom: 8mm;
        }
        
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
        }
        
        .signature {
            text-align: center;
            width: 45%;
        }
        
        .signature-line {
            border-top: 2px solid black;
            width: 80mm;
            margin: 0 auto;
        }
        
        .signature-name {
            font-size: 1.125rem;
            margin-top: 0.5rem;
            font-weight: 800;
            color: #041c5c;
        }
        
        .signature-title {
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 0.25rem;
        }
        
        .logo-bottom img {
            max-height: 50px;
            width: auto;
        }
        
        .wave-bottom img {
            max-height: 300px;
            width: 800px;
        }
        
        .wave-top img {
            max-height: 300px;
            width: 800px;
        }
        
        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
            }
            .certificate-container {
                padding: 0;
                margin-top: 0;
            }
            .certificate {
                box-shadow: none;
                margin: 0;
            }
        }
        
        @media (max-width: 768px) {
            .certificate-container {
                margin-top: 4rem;
                padding: 1rem;
            }
            
            .certificate {
                width: 100%;
                height: auto;
                padding: 10mm;
            }
            
            .certificate-title h2 {
                font-size: 2.5rem;
            }
            
            .membership-text div {
                margin-left: 0 !important;
            }
            
            .signature-line {
                width: 100%;
            }
            
            .wave-bottom img,
            .wave-top img {
                max-height: 150px;
                width: 400px;
            }
        }
        
        @media (max-width: 480px) {
            .certificate-title h2 {
                font-size: 1.8rem;
            }
            
            .recipient-text,
            .membership-text {
                font-size: 1rem;
            }
            
            .signatures {
                flex-direction: column;
                align-items: center;
            }
            
            .signature {
                width: 100%;
                margin-bottom: 1rem;
            }
            
            .wave-bottom img,
            .wave-top img {
                display: none;
            }
        }
    </style>
</x-app-layout>