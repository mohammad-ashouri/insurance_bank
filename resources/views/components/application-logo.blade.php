<svg width="200" height="200" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <linearGradient id="mainGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#667eea" />
            <stop offset="100%" stop-color="#764ba2" />
        </linearGradient>
        <linearGradient id="dotGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#06B6D4" />
            <stop offset="100%" stop-color="#3B82F6" />
        </linearGradient>
    </defs>

    <!-- نماد اصلی - نمایش اکانت‌های متصل -->
    <circle cx="100" cy="80" r="25" fill="url(#mainGrad)" opacity="0.9"/>

    <!-- اکانت‌های متصل شده -->
    <circle cx="60" cy="60" r="15" fill="url(#dotGrad)" opacity="0.8"/>
    <circle cx="140" cy="60" r="15" fill="url(#dotGrad)" opacity="0.8"/>
    <circle cx="60" cy="120" r="15" fill="url(#dotGrad)" opacity="0.8"/>
    <circle cx="140" cy="120" r="15" fill="url(#dotGrad)" opacity="0.8"/>

    <!-- خطوط ارتباطی مدرن با نقاط -->
    <path d="M100 90 L75 70" stroke="url(#dotGrad)" stroke-width="3" stroke-dasharray="4 2" opacity="0.7"/>
    <path d="M100 90 L125 70" stroke="url(#dotGrad)" stroke-width="3" stroke-dasharray="4 2" opacity="0.7"/>
    <path d="M100 90 L75 110" stroke="url(#dotGrad)" stroke-width="3" stroke-dasharray="4 2" opacity="0.7"/>
    <path d="M100 90 L125 110" stroke="url(#dotGrad)" stroke-width="3" stroke-dasharray="4 2" opacity="0.7"/>

    <!-- نماد چرخ دنده برای مدیریت (سمت راست) -->
    <g transform="translate(140, 140) scale(0.7)">
        <circle cx="0" cy="0" r="12" fill="none" stroke="#667eea" stroke-width="2"/>
        <path d="M0 -12 L0 -8 M8.5 -10.5 L6.5 -7 M10.5 8.5 L7 6.5 M0 12 L0 8 M-10.5 8.5 L-7 6.5 M-8.5 -10.5 L-6.5 -7"
              stroke="#667eea" stroke-width="1.5"/>
        <circle cx="0" cy="0" r="3" fill="#667eea"/>
    </g>

    <!-- نماد قفل برای امنیت (سمت چپ) -->
    <g transform="translate(60, 140)">
        <rect x="-8" y="-10" width="16" height="12" rx="2" fill="none" stroke="#06B6D4" stroke-width="2"/>
        <rect x="-5" y="2" width="10" height="8" rx="1" fill="#06B6D4" opacity="0.7"/>
        <circle cx="0" cy="-15" r="4" fill="none" stroke="#06B6D4" stroke-width="2"/>
    </g>

    <!-- متن فارسی با فونت مدرن -->
    <text x="100" y="180" text-anchor="middle" fill="#fff" font-family="Tahoma, Arial, sans-serif" font-size="11" font-weight="bold" letter-spacing="0.5">
        سامانه مدیریت اکانت‌ها
    </text>
</svg>
