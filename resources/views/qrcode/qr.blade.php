<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Video Landing Page</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
      * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
      }

      body {
          font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
          overflow-x: hidden;
          height: 100vh;
      }

      /* Video Background Container */
      .video-container {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          overflow: hidden;
          z-index: -1;
      }

      #bg-video {
          position: absolute;
          top: 50%;
          left: 50%;
          min-width: 100%;
          min-height: 100%;
          width: auto;
          height: auto;
          transform: translate(-50%, -50%);
          object-fit: cover;
      }

      /* Blue SVG Overlay */
      .svg-overlay {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          z-index: 1;
      }

      /* Main Content */
      .content-wrapper {
          position: relative;
          z-index: 2;
          min-height: 100vh;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
          padding: 20px;
      }

      .content-container {
          text-align: center;
          width: 100%;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
          min-height: 100vh;
          {{--  padding: 40px 0;  --}}
      }

      /* Logo Styles */
      .logo-container {
          display: flex;
          align-items: center;
          justify-content: center;
          padding: 40px 0 20px 0;
          animation: float 3s ease-in-out infinite;
      }

      .logo {
          width: 200px;
          height: auto;
          filter: drop-shadow(0 10px 30px rgba(0,0,0,0.3));
          transition: transform 0.3s ease;
      }

      .logo:hover {
          transform: scale(1.05);
      }
      .video-gallery .swiper-slide a img {
        height: 130px;
        border-radius: 15px;

    }
      /* Contact Links Container */
      .contact-links {
          display: flex;
          gap: 30px;
          justify-content: center;
          flex-wrap: wrap;
          margin-top: 40px;
      }

      /* Department Contact Rows */
      .department-contacts {
          display: flex;
          flex-direction: column;
          gap: 20px;
          {{--  margin: 30px 0;  --}}
          align-items: center;
      }

      /* CTA Download Button */
      .cta-container { display: flex; justify-content: center; margin: 16px 0 10px 0; }
      .cta-download {
          display: inline-flex;
          align-items: center;
          gap: 12px;
          padding: 14px 26px;
          border-radius: 9999px;
          color: #fff;
          text-decoration: none;
          font-size: 16px;
          font-weight: 700;
          background: linear-gradient(90deg, #2563eb, #1e40af);
          border: 1px solid rgba(255,255,255,0.25);
          box-shadow: 0 10px 30px rgba(0,0,0,0.25);
          transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.3s ease;
      }
      .cta-download:hover { transform: translateY(-2px); box-shadow: 0 14px 36px rgba(0,0,0,0.35); }
      .cta-download svg { width: 20px; height: 20px; }

      /* Social Links Row */
      .social-links { display: inline-flex; align-items: center; justify-content: center; gap: 14px; margin: 14px 0 8px 0; }
      .social-icon {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          width: 44px;
          height: 44px;
          border-radius: 9999px;
          color: #ffffff;
          text-decoration: none;
          border: 1px solid rgba(255, 255, 255, 0.25);
          background: rgba(255, 255, 255, 0.1);
          backdrop-filter: blur(8px);
          -webkit-backdrop-filter: blur(8px);
          transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
          box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
      }
      .social-icon:hover { transform: translateY(-2px); background: rgba(255, 255, 255, 0.2); border-color: rgba(255, 255, 255, 0.45); box-shadow: 0 10px 32px rgba(0, 0, 0, 0.25); }
      .social-icon svg { width: 20px; height: 20px; }

      .department-row {
          display: flex;
          align-items: center;
          gap: 15px;
          padding: 5px 15px;
          background: rgba(255, 255, 255, 0.1);
          backdrop-filter: blur(10px);
          -webkit-backdrop-filter: blur(10px);
          border: 1px solid rgba(255, 255, 255, 0.2);
          border-radius: 50px;
          box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
          transition: all 0.3s ease;
      }

      .department-row:hover {
          background: rgba(255, 255, 255, 0.2);
          transform: translateY(-2px);
          box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
          border-color: rgba(255, 255, 255, 0.4);
      }

      .department-label {
          color: #ffffff;
          font-size: 16px;
          font-weight: 600;
          margin-right: 10px;
          white-space: nowrap;
      }

      .department-icons {
          display: flex;
          gap: 12px;
          align-items: center;
      }

      .department-icon {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          width: 40px;
          height: 40px;
          border-radius: 50%;
          color: #ffffff;
          text-decoration: none;
          border: 1px solid rgba(255, 255, 255, 0.25);
          background: rgba(255, 255, 255, 0.1);
          backdrop-filter: blur(8px);
          -webkit-backdrop-filter: blur(8px);
          transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
          box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
      }

      .department-icon:hover {
          transform: translateY(-2px);
          background: rgba(255, 255, 255, 0.2);
          border-color: rgba(255, 255, 255, 0.45);
          box-shadow: 0 10px 32px rgba(0, 0, 0, 0.25);
      }

      .department-icon svg {
          width: 18px;
          height: 18px;
      }

      /* Compact Icons Row */
      .contact-icons {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 12px;
          margin-top: 20px;
          margin-bottom: 20px;
      }

      .contact-icon {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          width: 40px;
          height: 40px;
          border-radius: 9999px;
          color: #ffffff;
          text-decoration: none;
          border: 1px solid rgba(255, 255, 255, 0.25);
          background: rgba(255, 255, 255, 0.4);
          backdrop-filter: blur(8px);
          -webkit-backdrop-filter: blur(8px);
          transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
          box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
      }

      .contact-icon:hover {
          transform: translateY(-2px);
          background: rgba(255, 255, 255, 0.16);
          border-color: rgba(255, 255, 255, 0.45);
          box-shadow: 0 10px 32px rgba(0, 0, 0, 0.25);
      }

      .contact-icon svg {
          width: 18px;
          height: 18px;
      }

      .contact-icon-label {
          padding: 0 10px;
          gap: 8px;
          width: auto;
          height: 40px;
      }
      .contact-icon-label span { font-size: 12px; color: #ffffff; font-weight: 600; }

      /* Individual Link Styles */
      .contact-link {
          display: flex;
          align-items: center;
          gap: 12px;
          padding: 15px 30px;
          background: rgba(255, 255, 255, 0.1);
          backdrop-filter: blur(10px);
          -webkit-backdrop-filter: blur(10px);
          border: 1px solid rgba(255, 255, 255, 0.2);
          border-radius: 50px;
          color: white;
          text-decoration: none;
          font-size: 16px;
          font-weight: 500;
          transition: all 0.3s ease;
          box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      }

      .contact-link:hover {
          background: rgba(255, 255, 255, 0.2);
          transform: translateY(-3px);
          box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
          border-color: rgba(255, 255, 255, 0.4);
      }

      .contact-link svg {
          width: 20px;
          height: 20px;
          transition: transform 0.3s ease;
      }

      .contact-link:hover svg {
          transform: rotate(10deg);
      }

      /* WhatsApp specific styling */
      .whatsapp-link {
          background: rgba(37, 211, 102, 0.2);
          border-color: rgba(37, 211, 102, 0.3);
      }

      .whatsapp-link:hover {
          background: rgba(37, 211, 102, 0.3);
          border-color: rgba(37, 211, 102, 0.5);
          box-shadow: 0 12px 40px rgba(37, 211, 102, 0.2);
      }

      /* Animations */
      @keyframes fadeInUp {
          from {
              opacity: 0;
              transform: translateY(30px);
          }
          to {
              opacity: 1;
              transform: translateY(0);
          }
      }

      @keyframes float {
          0%, 100% {
              transform: translateY(0);
          }
          50% {
              transform: translateY(-20px);
          }
      }

      /* Responsive Design */
      @media (max-width: 768px) {
          .contact-links {
              flex-direction: column;
              align-items: center;
              gap: 20px;
          }

          .contact-link {
              width: 250px;
              justify-content: center;
          }

          .logo {
              width: 150px;
          }
      }

      /* Loading Animation */
      .loading-overlay {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: #0a0a0a;
          z-index: 9999;
          display: flex;
          align-items: center;
          justify-content: center;
          transition: opacity 0.5s ease;
      }

      .loading-overlay.hidden {
          opacity: 0;
          pointer-events: none;
      }

      .loader {
          width: 50px;
          height: 50px;
          border: 3px solid rgba(255, 255, 255, 0.1);
          border-top-color: #3498db;
          border-radius: 50%;
          animation: spin 1s linear infinite;
      }

      @keyframes spin {
          to { transform: rotate(360deg); }
      }

      /* Video Gallery Grid */
      .video-gallery {
          position: relative;
          z-index: 2;
          padding: 32px 20px 60px 20px;
          max-width: 1100px;
          margin: 0 auto;
      }
      /* Footer Social Area */
      .footer-social { position: relative; z-index: 2; padding: 12px 20px 28px 20px; display: flex; justify-content: center; }
      .footer-social .social-links { margin: 8px 0 0 0; }

      .video-gallery-title {
          color: rgb(255, 255, 255);
          font-size: 22px;
          font-weight: 700;
          letter-spacing: 0.5px;
          text-align: center;
          margin: 0 0 16px 0;
          opacity: 0.95;
      }

      .video-swiper {
          position: relative;
      }
      .video-swiper .swiper-wrapper { padding-bottom: 8px; }
      .video-swiper .swiper-slide { margin-right: 0; }
      .video-swiper .swiper-slide {
          width: 70%;
          max-width: 480px;
      }
      @media (min-width: 600px) { .video-swiper .swiper-slide { width: 40%; } }
      @media (min-width: 960px) { .video-swiper .swiper-slide { width: 30%; } }

      .video-card {
          position: relative;
          border-radius: 10px;
          overflow: hidden;
          background: rgba(255,255,255,0.06);
          {{--  border: 1px solid rgba(255,255,255,0.12);  --}}
          box-shadow: 0 10px 30px rgba(0,0,0,0.25);
          aspect-ratio: 16 / 9;
      }

      .video-thumb {
          width: 100%;
          height: 100%;
          object-fit: cover;
          display: block;
          max-height: 130px;
      }

      .play-badge {
          position: absolute;
          top: 50%;
          left:0;
          transform: translate(-50%, -50%);
          display: flex;
          align-items: center;
          justify-content: center;
          width: 48px;
          height: 48px;
          border-radius: 50%;
          background: rgba(0,0,0,0.55);
          border: 1px solid rgba(255,255,255,0.35);
          margin: 0;
          padding: 0;
      }

      .play-badge svg { width: 16px; height: 16px; }

      .video-title {
          position: absolute;
          top: calc(50% + 36px);
          left: 0;
          transform: translateX(-50%);
          color: #ffffff;
          font-size: 14px;
          font-weight: 600;
          padding: 6px 10px;
          background: rgba(0, 0, 0, 0.45);
          border: 1px solid rgba(255, 255, 255, 0.25);
          border-radius: 10px;
          white-space: nowrap;
          pointer-events: none;
      }

      .video-nav {
          display: flex;
          justify-content: center;
          gap: 10px;
          margin-top: 10px;
      }
      .video-nav button {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          width: 40px;
          height: 40px;
          border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.25);
          background: rgba(0, 0, 0, 0.4);
          color: #fff;
          transition: background 0.2s ease, border-color 0.2s ease;
      }
      .video-nav button:hover {
          background: rgba(0, 0, 0, 0.6);
          border-color: rgba(255, 255, 255, 0.45);
      }

      /* Image Gallery Slider */
      .image-gallery {
          position: relative;
          z-index: 2;
          padding: 12px 0 0 0;
          max-width: 1100px;
          margin: 0 auto;
      }
      .image-swiper { position: relative; }
      .image-swiper .swiper-wrapper { padding-bottom: 6px; }
      .image-swiper .swiper-slide { width: 70%; max-width: 520px; }
      @media (min-width: 600px) { .image-swiper .swiper-slide { width: 50%; } }
      @media (min-width: 960px) { .image-swiper .swiper-slide { width: 33.3333%; } }
      .image-card {
          position: relative;
          border-radius: 10px;
          overflow: hidden;
          background: rgba(255,255,255,0.06);
          {{--  border: 1px solid rgba(255,255,255,0.12);  --}}
          box-shadow: 0 10px 30px rgba(0,0,0,0.25);
          height: 200px;
      }
      .image-card img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 10px; max-height:130px}
      @media (min-width: 600px) { .image-card { height: 230px; } }
      @media (min-width: 960px) { .image-card { height: 260px; } }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loader">
        <div class="loader"></div>
    </div>

    <!-- Video Background -->
    <div class="video-container">
        <video id="bg-video" autoplay muted playsinline webkit-playsinline preload="metadata" poster="{{ asset('X-Files/qr-imgs/1.jpg') }}">
            <source src="{{ asset('X-Files/AOJ-2.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Blue SVG Overlay -->
        <svg class="svg-overlay" preserveAspectRatio="none" viewBox="0 0 1920 1080">
            <defs>
                <linearGradient id="blueGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#1e3c72;stop-opacity:0.7" />
                    <stop offset="50%" style="stop-color:#2a5298;stop-opacity:0.5" />
                    <stop offset="100%" style="stop-color:#3498db;stop-opacity:0.3" />
                </linearGradient>
                <pattern id="pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                    <circle cx="50" cy="50" r="1" fill="white" opacity="0.1">
                        <animate attributeName="r" values="1;3;1" dur="3s" repeatCount="indefinite" />
                    </circle>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#blueGradient)" />
            <rect width="100%" height="100%" fill="url(#pattern)" opacity="0.3" />
        </svg>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="content-container">
            <!-- Company Logo -->
            <div class="logo-container">
                <img src="{{ asset('X-Files/logo-white.png') }}" alt="Company Logo" class="logo" fetchpriority="high">
            </div>





            <!-- Compact Contact Icons -->
            <div class="contact-icons mb-3" aria-label="Contact options">
                <a href="https://wa.me/971558892742?text=Hello%2C%20I%20would%20like%20to%20know%20more%20about%20your%20services." target="_blank" rel="noopener" class="contact-icon" title="WhatsApp" aria-label="WhatsApp">
                    <svg viewBox="0 0 24 24" fill="#25D366" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.297"/>
                    </svg>
                </a>
                <a href="tel:+971558892742" class="contact-icon" title="Call" aria-label="Call">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path fill="#60A5FA" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </a>
                <a href="https://orioncc.com" target="_blank" rel="noopener" class="contact-icon" title="Website" aria-label="Website">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" stroke="#FBBF24" stroke-width="2" fill="none"></circle>
                        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" stroke="#FBBF24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a>
                <a href="mailto:a.gamal@orioncc.com" class="contact-icon contact-icon-label" title="Email" aria-label="Email">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#A78BFA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 4h16v16H4z"/>
                        <path d="M22 6 12 13 2 6"/>
                    </svg>
                    <span>Email</span>
                </a>
            </div>
            <!-- Department Contact Rows -->
            <div class="department-contacts">


                <!-- Estimation Row -->
                <div class="department-row">
                    <span class="department-label">For Inquiry</span>
                    <div class="department-icons">
                        <a href="tel:+971522815730" class="department-icon" title="Call For Inquiry" aria-label="Call For Inquiry">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path fill="#60A5FA" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/971522815730?text=Hello%2C%20I%20would%20like%20to%20get%20an%20estimation%20for%20your%20services." target="_blank" rel="noopener" class="department-icon" title="WhatsApp Estimation" aria-label="WhatsApp Estimation">
                            <svg viewBox="0 0 24 24" fill="#25D366" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.297"/>
                            </svg>
                        </a>
                    </div>
                </div>


            </div>

            <!-- Big CTA: Download Our Profile -->
            <div class="cta-container">
                <a href="/company-profile.pdf" download class="cta-download" title="Download our profile" aria-label="Download our profile">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v10"/><path d="m7 10 5 5 5-5"/><path d="M5 19h14"/></svg>
                    <span>Download our profile</span>
                </a>
            </div>
            <!-- Video Gallery (Lightbox) -->
            <section class="video-gallery" aria-label="Media gallery">
                <div class="video-gallery-title">Projects Gallery</div>
                <div class="video-swiper swiper" id="videoSwiper">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <a href="{{ asset('X-Files/vid/ORION 3 AUG warehouses (1).mov') }}" class="glightbox video-card" data-gallery="videos" data-type="video" data-width="1280" data-height="720">
                                <img src="{{ asset('X-Files/qr-imgs/25intro.jpg') }}" alt="Video 1" class="video-thumb" loading="lazy">
                                <span class="play-badge" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="#fff"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                                <span class="video-title">Rakez 20K</span>
                            </a>
                        </div>

                        <div class="swiper-slide">
                            <a href="{{ asset('X-Files/vid/ORION ALGHAIL 28 AUG.mov') }}" class="glightbox video-card" data-gallery="videos" data-type="video" data-width="1280" data-height="720">
                                <img src="{{ asset('X-Files/qr-imgs/15k.png') }}" alt="Video 2" class="video-thumb" loading="lazy">
                                <span class="play-badge" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="#fff"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                                <span class="video-title">Rakez 15K</span>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="video-nav">
                    <button id="videoPrev" aria-label="Previous">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <button id="videoNext" aria-label="Next">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </section>
        </div>
    </div>

    <!-- Footer Social Links at Bottom -->
    <div class="footer-social">
        <div class="social-links" aria-label="Social links">
            <a href="https://www.facebook.com/orioncontractingcompany" target="_blank" rel="noopener" class="social-icon" title="Facebook" aria-label="Facebook" style="background:#1877F2;border-color:rgba(255,255,255,0.35)">
                <svg viewBox="0 0 24 24" fill="#fff" aria-hidden="true"><path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-2.9h2v-2.2c0-2 1.2-3.2 3-3.2.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2v1.9h2.3L14 14.9h-2v7A10 10 0 0 0 22 12"/></svg>
            </a>
            <a href="https://www.instagram.com/orioncontracting/" target="_blank" rel="noopener" class="social-icon" title="Instagram" aria-label="Instagram" style="background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%,#285AEB 90%);border-color:rgba(255,255,255,0.35)">
                <svg viewBox="0 0 24 24" fill="#fff" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm5 5.5A4.5 4.5 0 1 0 16.5 12 4.5 4.5 0 0 0 12 7.5zm6-1.8a1.2 1.2 0 1 0 1.2 1.2 1.2 1.2 0 0 0-1.2-1.2z"/></svg>
            </a>
            <a href="https://www.linkedin.com/company/orion-contracting-company-llc?_l=en_US" target="_blank" rel="noopener" class="social-icon" title="LinkedIn" aria-label="LinkedIn" style="background:#0A66C2;border-color:rgba(255,255,255,0.35)">
                <svg viewBox="0 0 24 24" fill="#fff" aria-hidden="true"><path d="M20.45 20.45h-3.55V14.8c0-1.34-.02-3.06-1.86-3.06-1.86 0-2.14 1.45-2.14 2.95v5.76H9.35V9h3.4v1.56h.05a3.73 3.73 0 0 1 3.36-1.85c3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.11 20.45H3.56V9h3.55z"/></svg>
            </a>
            <a href="https://www.youtube.com/@orioncontracting9881" target="_blank" rel="noopener" class="social-icon" title="YouTube" aria-label="YouTube" style="background:#FF0000;border-color:rgba(255,255,255,0.35)">
                <svg viewBox="0 0 24 24" fill="#fff" aria-hidden="true"><path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.6 3.5 12 3.5 12 3.5s-7.6 0-9.4.6A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.8.6 9.4.6 9.4.6s7.6 0 9.4-.6a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8zM9.75 15.5v-7L15.5 12l-5.75 3.5z"/></svg>
            </a>
        </div>
    </div>

    <script>
        // Hide loader when page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.getElementById('loader').classList.add('hidden');
            }, 200);

            // Initialize GLightbox for videos
            const initLightbox = () => {
                if (window.GLightbox) {
                    window.gbx?.destroy?.();
                    window.gbx = window.GLightbox({
                        selector: '.glightbox',
                        touchNavigation: true,
                        autoplayVideos: true,
                        openEffect: 'zoom',
                        closeEffect: 'fade',
                        slideEffect: 'slide',
                        loop: true
                    });
                }
            };

            if (window.GLightbox) {
                initLightbox();
            }
        });

        // Defer load GLightbox JS
        (function loadLightbox() {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js';
            script.defer = true;
            script.onload = () => {
                try {
                    if (window.GLightbox) {
                        window.gbx?.destroy?.();
                        window.gbx = window.GLightbox({
                            selector: '.glightbox',
                            touchNavigation: true,
                            autoplayVideos: true,
                            openEffect: 'zoom',
                            closeEffect: 'fade',
                            slideEffect: 'slide',
                            loop: true
                        });
                    }
                } catch (e) {}
            };
            document.head.appendChild(script);
        })();

        // Defer load Swiper JS and initialize slider
        (function loadSwiper() {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js';
            script.defer = true;
            script.onload = () => {
                try {
                    if (window.Swiper) {
                        window.videoSwiper?.destroy?.();
                        window.videoSwiper = new window.Swiper('#videoSwiper', {
                            slidesPerView: 'auto',
                            spaceBetween: 16,
                            centeredSlides: false,
                            freeMode: true,
                            grabCursor: true,
                            loop: false,
                            watchSlidesProgress: true,
                            preloadImages: false,
                            lazy: { loadPrevNext: true, loadOnTransitionStart: true },
                            autoplay: {
                                delay: 2500,
                                disableOnInteraction: false
                            },
                            navigation: {
                                nextEl: '#videoNext',
                                prevEl: '#videoPrev'
                            },
                            keyboard: { enabled: true },
                            breakpoints: {
                                0: { spaceBetween: 14 },
                                600: { spaceBetween: 16 },
                                960: { spaceBetween: 20 }
                            }
                        });

                        // Removed second swiper; using only #videoSwiper for combined media
                    }
                } catch (e) {}
            };
            document.head.appendChild(script);
        })();

        // Robust autoplay for background video
        (function ensureBackgroundVideoAutoplay() {
            const video = document.getElementById('bg-video');
            if (!video) return;

            const tryPlay = () => {
                try {
                    video.muted = true;
                    video.setAttribute('muted', '');
                    video.setAttribute('playsinline', '');
                    video.setAttribute('webkit-playsinline', '');
                    const p = video.play();
                    if (p && typeof p.then === 'function') {
                        p.catch(() => {});
                    }
                } catch (e) {}
            };

            // Attempt on several signals
            if (video.readyState >= 2) tryPlay();
            video.addEventListener('loadedmetadata', tryPlay, { once: true });
            video.addEventListener('canplay', tryPlay, { once: true });

            // Fallbacks: user interactions and visibility changes
            const userKick = () => { tryPlay(); document.removeEventListener('click', userKick); document.removeEventListener('touchstart', userKick); };
            document.addEventListener('click', userKick);
            document.addEventListener('touchstart', userKick, { passive: true });
            document.addEventListener('visibilitychange', () => { if (!document.hidden) tryPlay(); });
        })();

        // Add parallax effect on mouse move
        document.addEventListener('mousemove', (e) => {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            const logo = document.querySelector('.logo-container');
            if (logo) {
                logo.style.transform = `translate(${(x - 0.5) * 20}px, ${(y - 0.5) * 20}px)`;
            }
        });
    </script>
</body>
</html>
