<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DocuMate</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #003399;
        }
    </style>
</head>

<body class="font-sans bg-white text-gray-800 scroll-smooth">

    <!-- ================= HEADER ================= -->
    <header class="bg-white/90 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">

            <!-- Logo + Title -->
            <div class="flex items-center space-x-3">
                <!-- Replace src with your image -->
                <img src="\images\DocumateLogo.png" alt="DocuMate Logo" class="size-16 object-contain">

                <h1 class="text-4xl font-bold tracking-wide text-[#2A57B4]" style="font-family: 'Montserrat', sans-serif;">
                    DocuMate
                </h1>
            </div>

            <!-- Navigation -->
            <nav class="flex items-center space-x-10 text-sm font-semibold">

                <a href="#about" 
                class="text-gray-700 text-xl hover:text-[#2A57B4] transition">
                    About
                </a>

                <a href="#creators" 
                class="text-gray-700 text-xl hover:text-[#2A57B4] transition">
                    Creators
                </a>

                <a href="#faqs" 
                class="text-gray-700 text-xl hover:text-[#2A57B4] transition">
                    FAQs
                </a>

            </nav>
        </div>
    </header>

    <!-- ================= HERO ================= -->
    <section class="min-h-screen flex items-center bg-white pt-28">

        <div class="w-full grid md:grid-cols-2 items-center">

            <!-- LEFT SIDE -->
            <div class="px-8 md:px-16">

                <h1 class="text-8xl font-semibold tracking-wide text-[#2A57B4]" style="font-family: 'Montserrat', sans-serif;">
                    Tap,
                    select,
                    access.
                </h1>

                <p class="text-lg text-gray-600 my-8 leading-relaxed max-w-lg">
                    A smarter way to manage student transactions, automate workflows, 
                    and ensure transparent multi-office approvals.
                </p>

                <div class="flex flex-col sm:mt-20 mb-20 gap-4 items-start">

                    <!-- Login Button -->
                    <a href="{{ route('login') }}"
                    class="px-20 py-3 bg-[#2A57B4] text-white rounded-full font-bold hover:opacity-90 transition">
                        Sign in
                    </a>

                    <!-- Sign Up Text Link -->
                    <a href="{{ route('register') }}"
                    class="text-sm text-gray-600 hover:text-[#2A57B4] transition">
                        Don't have an account yet? Sign up here.
                    </a>

                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="h-full flex items-end">

                <img src="{{ asset('images/covergirl.png') }}" 
                    alt="DocuMate Cover" 
                    class="w-full h-full object-cover">

            </div>

        </div>

    </section>

    <!-- ================= ABOUT ================= -->
    <section id="about" class="py-24 bg-[#2A57B4] text-white">

        <div class="max-w-5xl mx-auto px-6 grid md:grid-cols-2 gap-6 items-center">

            <!-- LEFT SIDE -->
            <div class="text-right md:pr-4">
                <h1 class="text-9xl font-bold leading-none tracking-tight"
                    style="font-family: 'Montserrat', sans-serif;">
                    
                    DOCU<br>
                    MATE

                </h1>
            </div>

            <!-- RIGHT SIDE -->
            <div class="text-left md:pl-4">

                <h2 class="text-3xl font-bold mb-4">
                    ABOUT
                </h2>

                <p class="text-white/90 leading-relaxed text-lg">
                    DocuMate is a centralized student transaction system designed to enhance 
                    efficiency, transparency, and accountability. It integrates structured 
                    workflows, digital records management, and role-based access control 
                    to streamline university operations.
                </p>

            </div>

        </div>

    </section>

    <!-- ================= CREATORS ================= -->
    <section id="creators" class="py-24 bg-white">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-medium text-[#2A57B4]">MEET THE TEAM</h2>
            <h1 class="text-6xl font-semibold text-[#2A57B4] mb-6">THE CREATORS</h1>
            <h2 class="text-centered text-2x1 text-gray-600 px-28 font-regular text-grey mb-10">
                A dedicated team committed to building an efficient, innovative, and user-centered student transaction system.
            </h2>

            <!-- 2x2 GRID -->
            <div class="grid md:grid-cols-2 gap-10">

                <!-- CARD -->
                <div class="bg-white px-8 pt-8 pb-4 rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition 
                            text-center flex flex-col items-center min-h-[480px]">

                    <!-- IMAGE (BIGGER) -->
                    <img src="{{ asset('images/pfp1.png') }}"
                        class="w-44 h-44 rounded-full object-cover mb-6"
                        alt="Creator">

                    <!-- NAME -->
                    <h3 class="font-semibold text-2xl">Rujen Andrea Ecaldre</h3>

                    <!-- ROLE -->
                    <p class="text-sm text-[#2A57B4] font-medium mb-3">Project Leader</p>

                    <!-- SOCIAL MEDIA -->
                    <div class="flex gap-4 mb-5">

                        <a href="https://facebook.com" target="_blank" class="text-gray-500 hover:text-[#003399] transition">
                            <!-- Facebook Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2.2v-2.9h2.2V9.4c0-2.2 1.3-3.4 3.3-3.4.96 0 2 .17 2 .17v2.2h-1.1c-1.1 0-1.4.68-1.4 1.38v1.66h2.4l-.38 2.9h-2.02v7A10 10 0 0 0 22 12z"/>
                            </svg>
                        </a>

                        <a href="https://github.com" target="_blank" class="text-gray-500 hover:text-[#003399] transition">
                            <!-- GitHub Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 .5C5.73.5.98 5.26.98 11.53c0 4.87 3.16 9 7.55 10.46.55.1.75-.24.75-.54v-2.02c-3.07.67-3.72-1.48-3.72-1.48-.5-1.27-1.23-1.6-1.23-1.6-1-.7.08-.69.08-.69 1.1.08 1.68 1.13 1.68 1.13.98 1.68 2.56 1.2 3.18.92.1-.7.38-1.2.7-1.48-2.45-.28-5.03-1.22-5.03-5.42 0-1.2.43-2.18 1.13-2.95-.11-.28-.49-1.4.11-2.92 0 0 .92-.29 3.02 1.13a10.5 10.5 0 0 1 5.5 0c2.1-1.42 3.02-1.13 3.02-1.13.6 1.52.22 2.64.11 2.92.7.77 1.13 1.75 1.13 2.95 0 4.21-2.58 5.14-5.04 5.41.39.34.74 1.01.74 2.04v3.02c0 .3.2.65.76.54 4.38-1.46 7.54-5.6 7.54-10.46C23.02 5.26 18.27.5 12 .5z"/>
                            </svg>
                        </a>

                    </div>

                    <!-- DESCRIPTION -->
                    <p class="text-sm text-gray-600 mt-4 max-w-sm">
                        Leads the team by managing workflows, ensuring collaboration, and keeping the project aligned with its goals and deadlines.
                    </p>

                    <!-- PUSH SKILLS DOWN -->
                    <div class="mt-auto flex flex-wrap justify-center gap-2">

                        <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                            Research
                        </span>

                        <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                            Management
                        </span>

                        <span class="px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded-full">
                            System Design
                        </span>
                        <span class="px-3 py-1 text-xs bg-lime-100 text-lime-700 rounded-full">
                            Database
                        </span>

                    </div>

                </div>
                <div class="bg-white px-8 pt-8 pb-4 rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition 
                            text-center flex flex-col items-center min-h-[480px]">

                    <!-- IMAGE (BIGGER) -->
                    <img src="{{ asset('images/pfp2.png') }}"
                        class="w-44 h-44 rounded-full object-cover mb-6"
                        alt="Creator">

                    <!-- NAME -->
                    <h3 class="font-semibold text-2xl">Clarisse Villa</h3>

                    <!-- ROLE -->
                    <p class="text-sm text-[#2A57B4] font-medium mb-3">Technical Writer</p>

                    <!-- SOCIAL MEDIA -->
                    <div class="flex gap-4 mb-5">

                        <a href="https://facebook.com" target="_blank" class="text-gray-500 hover:text-[#003399] transition">
                            <!-- Facebook Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2.2v-2.9h2.2V9.4c0-2.2 1.3-3.4 3.3-3.4.96 0 2 .17 2 .17v2.2h-1.1c-1.1 0-1.4.68-1.4 1.38v1.66h2.4l-.38 2.9h-2.02v7A10 10 0 0 0 22 12z"/>
                            </svg>
                        </a>

                        <a href="https://github.com" target="_blank" class="text-gray-500 hover:text-[#003399] transition">
                            <!-- GitHub Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 .5C5.73.5.98 5.26.98 11.53c0 4.87 3.16 9 7.55 10.46.55.1.75-.24.75-.54v-2.02c-3.07.67-3.72-1.48-3.72-1.48-.5-1.27-1.23-1.6-1.23-1.6-1-.7.08-.69.08-.69 1.1.08 1.68 1.13 1.68 1.13.98 1.68 2.56 1.2 3.18.92.1-.7.38-1.2.7-1.48-2.45-.28-5.03-1.22-5.03-5.42 0-1.2.43-2.18 1.13-2.95-.11-.28-.49-1.4.11-2.92 0 0 .92-.29 3.02 1.13a10.5 10.5 0 0 1 5.5 0c2.1-1.42 3.02-1.13 3.02-1.13.6 1.52.22 2.64.11 2.92.7.77 1.13 1.75 1.13 2.95 0 4.21-2.58 5.14-5.04 5.41.39.34.74 1.01.74 2.04v3.02c0 .3.2.65.76.54 4.38-1.46 7.54-5.6 7.54-10.46C23.02 5.26 18.27.5 12 .5z"/>
                            </svg>
                        </a>

                    </div>

                    <!-- DESCRIPTION -->
                    <p class="text-sm text-gray-600 mt-4 max-w-sm">
                        Produces structured technical documentation, ensuring all system components, workflows, and outputs are clearly communicated and well-documented.
                    </p>

                    <!-- PUSH SKILLS DOWN -->
                    <div class="mt-auto flex flex-wrap justify-center gap-2">

                        <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                            Research
                        </span>

                        <span class="px-3 py-1 text-xs bg-cyan-100 text-cyan-700 rounded-full">
                            Documentation
                        </span>

                        <span class="px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded-full">
                            System Analyst
                        </span>
                        <span class="px-3 py-1 text-xs bg-amber-100 text-amber-700 rounded-full">
                            Charts
                        </span>

                    </div>

                </div>
                <div class="bg-white px-8 pt-8 pb-4 rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition 
                            text-center flex flex-col items-center min-h-[480px]">

                    <!-- IMAGE (BIGGER) -->
                    <img src="{{ asset('images/pfp3.png') }}"
                        class="w-44 h-44 rounded-full object-cover mb-6"
                        alt="Creator">

                    <!-- NAME -->
                    <h3 class="font-semibold text-2xl">Clarence Magpatoc</h3>

                    <!-- ROLE -->
                    <p class="text-sm text-[#2A57B4] font-medium mb-3">Research & Development</p>

                    <!-- SOCIAL MEDIA -->
                    <div class="flex gap-4 mb-5">

                        <a href="https://facebook.com" target="_blank" class="text-gray-500 hover:text-[#003399] transition">
                            <!-- Facebook Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2.2v-2.9h2.2V9.4c0-2.2 1.3-3.4 3.3-3.4.96 0 2 .17 2 .17v2.2h-1.1c-1.1 0-1.4.68-1.4 1.38v1.66h2.4l-.38 2.9h-2.02v7A10 10 0 0 0 22 12z"/>
                            </svg>
                        </a>

                        <a href="https://github.com" target="_blank" class="text-gray-500 hover:text-[#003399] transition">
                            <!-- GitHub Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 .5C5.73.5.98 5.26.98 11.53c0 4.87 3.16 9 7.55 10.46.55.1.75-.24.75-.54v-2.02c-3.07.67-3.72-1.48-3.72-1.48-.5-1.27-1.23-1.6-1.23-1.6-1-.7.08-.69.08-.69 1.1.08 1.68 1.13 1.68 1.13.98 1.68 2.56 1.2 3.18.92.1-.7.38-1.2.7-1.48-2.45-.28-5.03-1.22-5.03-5.42 0-1.2.43-2.18 1.13-2.95-.11-.28-.49-1.4.11-2.92 0 0 .92-.29 3.02 1.13a10.5 10.5 0 0 1 5.5 0c2.1-1.42 3.02-1.13 3.02-1.13.6 1.52.22 2.64.11 2.92.7.77 1.13 1.75 1.13 2.95 0 4.21-2.58 5.14-5.04 5.41.39.34.74 1.01.74 2.04v3.02c0 .3.2.65.76.54 4.38-1.46 7.54-5.6 7.54-10.46C23.02 5.26 18.27.5 12 .5z"/>
                            </svg>
                        </a>

                    </div>

                    <!-- DESCRIPTION -->
                    <p class="text-sm text-gray-600 mt-4 max-w-sm">
                        Conducts research, analyzes system requirements, and develops solutions to improve functionality, efficiency, and innovation within the project.
                    </p>

                    <!-- PUSH SKILLS DOWN -->
                    <div class="mt-auto flex flex-wrap justify-center gap-2">

                        <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                            Research
                        </span>

                        <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                            Laravel
                        </span>

                        <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">
                            Tailwind
                        </span>
                        <span class="px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded-full">
                            System Analyst
                        </span>

                    </div>

                </div>
                <div class="bg-white px-8 pt-8 pb-4 rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition 
                            text-center flex flex-col items-center min-h-[480px]">

                    <!-- IMAGE (BIGGER) -->
                    <img src="{{ asset('images/pfp4.png') }}"
                        class="w-44 h-44 rounded-full object-cover mb-6"
                        alt="Creator">

                    <!-- NAME -->
                    <h3 class="font-semibold text-2xl">Khanley Mesa</h3>

                    <!-- ROLE -->
                    <p class="text-sm text-[#2A57B4] font-medium mb-3">Design & Development</p>

                    <!-- SOCIAL MEDIA -->
                    <div class="flex gap-4 mb-5">

                        <a href="https://facebook.com" target="_blank" class="text-gray-500 hover:text-[#003399] transition">
                            <!-- Facebook Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2.2v-2.9h2.2V9.4c0-2.2 1.3-3.4 3.3-3.4.96 0 2 .17 2 .17v2.2h-1.1c-1.1 0-1.4.68-1.4 1.38v1.66h2.4l-.38 2.9h-2.02v7A10 10 0 0 0 22 12z"/>
                            </svg>
                        </a>

                        <a href="https://github.com" target="_blank" class="text-gray-500 hover:text-[#003399] transition">
                            <!-- GitHub Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 .5C5.73.5.98 5.26.98 11.53c0 4.87 3.16 9 7.55 10.46.55.1.75-.24.75-.54v-2.02c-3.07.67-3.72-1.48-3.72-1.48-.5-1.27-1.23-1.6-1.23-1.6-1-.7.08-.69.08-.69 1.1.08 1.68 1.13 1.68 1.13.98 1.68 2.56 1.2 3.18.92.1-.7.38-1.2.7-1.48-2.45-.28-5.03-1.22-5.03-5.42 0-1.2.43-2.18 1.13-2.95-.11-.28-.49-1.4.11-2.92 0 0 .92-.29 3.02 1.13a10.5 10.5 0 0 1 5.5 0c2.1-1.42 3.02-1.13 3.02-1.13.6 1.52.22 2.64.11 2.92.7.77 1.13 1.75 1.13 2.95 0 4.21-2.58 5.14-5.04 5.41.39.34.74 1.01.74 2.04v3.02c0 .3.2.65.76.54 4.38-1.46 7.54-5.6 7.54-10.46C23.02 5.26 18.27.5 12 .5z"/>
                            </svg>
                        </a>

                    </div>

                    <!-- DESCRIPTION -->
                    <p class="text-sm text-gray-600 mt-4 max-w-sm">
                        Handles system design and implementation, integrating front-end and back-end components to deliver a functional and user-friendly application.
                    </p>

                    <!-- PUSH SKILLS DOWN -->
                    <div class="mt-auto flex flex-wrap justify-center gap-2">

                        <span class="px-3 py-1 text-xs bg-slate-100 text-slate-700 rounded-full">
                            UI/UX
                        </span>

                        <span class="px-3 py-1 text-xs bg-fuchsia-100 text-fuchsia-700 rounded-full">
                            Backend
                        </span>

                        <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                            Laravel
                        </span>
                        <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">
                            Tailwind
                        </span>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ================= FAQ ================= -->
    <section id="faqs" class="pt-24 pb-28 bg-white">
        <div class="max-w-4xl mx-auto px-6">

            <h1 class="text-left text-6xl font-semibold text-[#2A57B4] mb-5">
                Frequently asked questions...
            </h1>
            <h2 class="text-left text-xl font-regular text-grey mb-10">
                These are the commonly asked questions about the system, its features, and its security measures. Can't find your question here? Feel free to contact us for more information!
            </h2>

            <div class="space-y-12">

                <!-- FAQ ITEM -->
                <div class="flex flex-col gap-5">

                    <!-- QUESTION (RIGHT) -->
                    <div class="flex justify-end">
                        <div class="bg-white border border-gray-200 text-[#2A57B4] 
                                    font-semibold px-6 py-4 rounded-3xl rounded-tr-md 
                                    max-w-md text-base shadow-md hover:shadow-lg transition">
                            What is DocuMate?
                        </div>
                    </div>

                    <!-- ANSWER (LEFT) -->
                    <div class="flex justify-start">
                        <div class="bg-[#2A57B4] text-white font-semibold
                                    px-6 py-4 rounded-3xl rounded-tl-md 
                                    max-w-md text-base shadow-md hover:shadow-lg transition">
                            A digital system designed to streamline student transactions, 
                            improve workflow efficiency, and ensure transparent approvals.
                        </div>
                    </div>

                </div>

                <!-- FAQ ITEM -->
                <div class="flex flex-col gap-5">

                    <div class="flex justify-end">
                        <div class="bg-white border border-gray-200 text-[#2A57B4] font-semibold
                                    px-6 py-4 rounded-3xl rounded-tr-md 
                                    max-w-md text-base shadow-md hover:shadow-lg transition">
                            Who can use the system?
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <div class="bg-[#2A57B4] text-white font-semibold
                                    px-6 py-4 rounded-3xl rounded-tl-md 
                                    max-w-md text-base shadow-md hover:shadow-lg transition">
                            Students, officers, and administrators within the institution 
                            can access and utilize the system based on their roles.
                        </div>
                    </div>

                </div>

                <!-- FAQ ITEM -->
                <div class="flex flex-col gap-5">

                    <div class="flex justify-end">
                        <div class="bg-white border border-gray-200 text-[#2A57B4] font-semibold
                                    px-6 py-4 rounded-3xl rounded-tr-md 
                                    max-w-md text-base shadow-md hover:shadow-lg transition">
                            Is my data secure?
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <div class="bg-[#2A57B4] text-white font-semibold
                                    px-6 py-4 rounded-3xl rounded-tl-md 
                                    max-w-md text-base shadow-md hover:shadow-lg transition">
                            Yes. The system implements role-based access control and 
                            secure authentication to protect user data and ensure privacy.
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-[#2A57B4] text-white py-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4 text-sm">

            <!-- LEFT SIDE -->
            <div class="text-center md:text-left">
                © {{ date('Y') }} DocuMate. All rights reserved.
            </div>

            <!-- RIGHT SIDE -->
            <div class="flex flex-wrap justify-center md:justify-end items-center gap-4">

                <a href="#" class="hover:underline hover:opacity-80">
                    Privacy Policy
                </a>

                <a href="#" class="hover:underline hover:opacity-80">
                    Terms & Conditions
                </a>

                <span class="opacity-100">
                    Ecaldre et al, 2026
                </span>

            </div>

        </div>
    </footer>
    <div class="bg-[#FFBF00] py-1"></div>

</body>
</html>