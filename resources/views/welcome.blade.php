<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lost and Found - Reuniting Items with Their Owners</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <style>
            :root {
                --primary-color: #4f46e5;
                --primary-light: #818cf8;
                --primary-dark: #3730a3;
                --secondary-color: #f59e0b;
                --secondary-light: #fbbf24;
                --secondary-dark: #d97706;
                --accent-color: #10b981;
                --accent-light: #34d399;
                --accent-dark: #059669;
                --text-dark: #1f2937;
                --text-light: #f9fafb;
                --bg-light: #f9fafb;
                --bg-dark: #f3f4f6;
                --bg-card: #ffffff;
                --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }
            
            body {
                font-family: 'Poppins', sans-serif;
                margin: 0;
                padding: 0;
                background-color: var(--bg-light);
                color: var(--text-dark);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            .hero {
                position: relative;
                height: 100vh;
                background-image: url('https://images.unsplash.com/photo-1557683316-973673baf926?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
                background-size: cover;
                background-position: center;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                overflow: hidden;
            }
            .hero::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
                z-index: 1;
            }
            .hero-content {
                position: relative;
                z-index: 2;
                max-width: 800px;
                padding: 2rem;
            }
            .hero-title {
                font-size: 3.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
                background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: fadeIn 1.5s ease-out;
            }
            .hero-subtitle {
                font-size: 1.5rem;
                margin-bottom: 2rem;
                color: var(--text-dark);
                animation: fadeIn 2s ease-out;
            }
            .hindi-slogan {
                font-size: 1.8rem;
                margin-bottom: 1.5rem;
                color: var(--secondary-dark);
                font-weight: 500;
                animation: fadeIn 2.5s ease-out;
            }
            .english-slogan {
                font-size: 1.2rem;
                margin-bottom: 2rem;
                color: var(--text-dark);
                font-style: italic;
                animation: fadeIn 3s ease-out;
            }
            .cta-buttons {
                display: flex;
                justify-content: center;
                gap: 1.5rem;
                margin-top: 2rem;
                animation: fadeIn 3.5s ease-out;
            }
            .btn {
                display: inline-flex;
                align-items: center;
                padding: 0.75rem 1.5rem;
                border-radius: 0.5rem;
                font-weight: 500;
                text-decoration: none;
                transition: all 0.3s ease;
            }
            .btn-primary {
                background: linear-gradient(135deg, #1d4ed8, #2563eb);
                color: #ffffff;
                box-shadow: var(--shadow-md);
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                background: linear-gradient(135deg, #1e40af, #1d4ed8);
                box-shadow: var(--shadow-lg);
            }
            .btn-secondary {
                background: #ffffff;
                color: #1d4ed8;
                border: 2px solid #1d4ed8;
                box-shadow: var(--shadow-sm);
            }
            .btn-secondary:hover {
                background: #f8fafc;
                border-color: #1e40af;
                color: #1e40af;
            }
            .features {
                padding: 5rem 2rem;
                background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            }
            .features-container {
                max-width: 1200px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
            }
            .feature-card {
                background: var(--bg-card);
                border-radius: 1rem;
                padding: 2rem;
                text-align: center;
                transition: transform 0.3s ease;
                box-shadow: var(--shadow-md);
            }
            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: var(--shadow-lg);
            }
            .feature-icon {
                font-size: 2.5rem;
                margin-bottom: 1rem;
                color: var(--primary-color);
            }
            .feature-title {
                font-size: 1.5rem;
                margin-bottom: 1rem;
                color: var(--text-dark);
                background-color: var(--bg-light);
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                box-shadow: var(--shadow-sm);
                display: inline-block;
            }
            .feature-text {
                color: var(--text-dark);
            }
            .footer {
                background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
                color: var(--text-dark);
                padding: 2rem;
                margin-top: auto;
                border-top: 1px solid #bae6fd;
            }
            .footer-content {
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 1.5rem;
            }
            .footer-title {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                color: var(--primary-dark);
                background-color: var(--bg-light);
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                box-shadow: var(--shadow-sm);
            }
            .footer-text {
                font-size: 1rem;
                color: var(--text-dark);
                background-color: var(--bg-light);
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                box-shadow: var(--shadow-sm);
            }
            .social-links {
                display: flex;
                gap: 1.5rem;
                margin-top: 1rem;
            }
            .social-link {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: var(--primary-color);
                text-decoration: none;
                transition: all 0.3s ease;
                background-color: var(--bg-light);
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                box-shadow: var(--shadow-sm);
            }
            .social-link:hover {
                transform: translateY(-2px);
                color: var(--primary-dark);
                box-shadow: var(--shadow-md);
            }
            .social-icon {
                width: 24px;
                height: 24px;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @media (max-width: 768px) {
                .hero-title {
                    font-size: 2.5rem;
                }
                .hero-subtitle {
                    font-size: 1.2rem;
                }
                .hindi-slogan {
                    font-size: 1.5rem;
                }
                .cta-buttons {
                    flex-direction: column;
                    gap: 1rem;
                }
                .footer-content {
                    text-align: center;
                }
                .social-links {
                    justify-content: center;
                }
            }
        </style>
    </head>
    <body>
        <div class="hero">
            <div class="hero-content">
                <h1 class="hero-title">Lost and Found</h1>
                <p class="hero-subtitle">Reuniting lost items with their rightful owners</p>
                <p class="hindi-slogan">खोई हुई वस्तु को पाना, खुशी की बात है</p>
                <p class="english-slogan">"Finding what was lost, bringing joy to hearts"</p>
                <div class="cta-buttons">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                            <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>

        <section class="features">
            <div class="features-container">
                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3 class="feature-title">Search Lost Items</h3>
                    <p class="feature-text">Browse through our database of lost items and find what you're looking for with our advanced search filters.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📝</div>
                    <h3 class="feature-title">Report Found Items</h3>
                    <p class="feature-text">Found something that doesn't belong to you? Report it here to help reunite it with its owner.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🤝</div>
                    <h3 class="feature-title">Connect with Others</h3>
                    <p class="feature-text">Our messaging system allows you to communicate directly with item owners or finders to arrange returns.</p>
                </div>
            </div>
        </section>

        <footer class="footer">
            <div class="footer-content">
                <h2 class="footer-title">Developer</h2>
                <p class="footer-text">Prem Aman</p>
                <div class="social-links">
                    <a href="https://github.com/premaman10" target="_blank" class="social-link">
                        <svg class="social-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        <span>GitHub</span>
                    </a>
                    <a href="https://www.linkedin.com/in/prem-aman" target="_blank" class="social-link">
                        <svg class="social-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                        <span>LinkedIn</span>
                    </a>
                </div>
            </div>
        </footer>
    </body>
</html>
