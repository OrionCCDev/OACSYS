<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Video Landing Page</title>
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
          padding: 40px 0;
      }

      /* Logo Styles */
      .logo-container {
          flex: 1;
          display: flex;
          align-items: end;
          justify-content: center;
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

      /* Contact Links Container */
      .contact-links {
          display: flex;
          gap: 30px;
          justify-content: center;
          flex-wrap: wrap;
          margin-top: 40px;
      }

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
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loader">
        <div class="loader"></div>
    </div>

    <!-- Video Background -->
    <div class="video-container">
        <video id="bg-video" autoplay muted loop playsinline>
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
                <img src="{{ asset('X-Files/logo-white.png') }}" alt="Company Logo" class="logo">
            </div>

            <!-- Download Button -->
            <a href="/company-profile.pdf" download class="download-btn" style="display:inline-flex;align-items:center;gap:12px;padding:16px 36px;background:linear-gradient(90deg,#2563eb,#1e40af);color:#fff;font-size:18px;font-weight:600;border:none;border-radius:40px;box-shadow:0 8px 32px rgba(37,99,235,0.15);margin:40px auto 0 auto;cursor:pointer;transition:background 0.3s,box-shadow 0.3s;text-decoration:none;">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                Download Company Profile
            </a>

            <!-- Contact Links -->
            <div class="contact-links">
                <!-- Email Link -->
                <a href="mailto:contact@yourcompany.com" class="contact-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                        <path d="m22 7-10 5L2 7"></path>
                    </svg>
                    <span>contact@yourcompany.com</span>
                </a>

                <!-- Phone Link -->
                <a href="tel:+1234567890" class="contact-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <span>+1 (234) 567-890</span>
                </a>

                <!-- Website Link -->
                <a href="https://yourwebsite.com" target="_blank" rel="noopener" class="contact-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                    </svg>
                    <span>yourwebsite.com</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Hide loader when page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.getElementById('loader').classList.add('hidden');
            }, 500);
        });

        // Ensure video plays on interaction if autoplay is blocked
        document.addEventListener('click', function() {
            const video = document.getElementById('bg-video');
            if (video.paused) {
                video.play();
            }
        });

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
