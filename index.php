<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bharat English School & Jr. College - Shaping Future Leaders</title>
    <meta name="description" content="Bharat English School & Jr. College - Premier educational institution fostering innovation, leadership, and academic excellence. Discover our world-class programs, state-of-the-art facilities, and distinguished faculty.">
    <meta name="keywords" content="Pune education, academic excellence, leadership development, innovation, technology, arts, sports, Pune academy, best school Pune">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Bharat English School & Jr. College - Shaping Future Leaders">
    <meta property="og:description" content="Premier educational institution fostering innovation, leadership, and academic excellence in Pune">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">
    <meta property="og:image" content="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- GSAP for Advanced Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="loading-content">
            <div class="loading-logo">
                <img src="images/college-logo.jpg" alt="Bharat English School & Jr. College Logo" class="college-logo">
                <div class="logo-text">BESJC</div>
            </div>
            <div class="loading-bar">
                <div class="loading-progress"></div>
            </div>
            <p class="loading-text">Loading Excellence...</p>
        </div>
    </div>



    <!-- Header -->
    <header id="header" class="header">
        <!-- Contact Bar -->
        <div class="contact-bar">
            <div class="container">
                <div class="contact-info">
                    <div class="contact-item">
                        <i data-lucide="phone"></i>
                        <span> 020255360354</span>
                    </div>
                    <div class="contact-item">
                        <i data-lucide="mail"></i>
                        <span>bharatprincipal5@gmail.com
                        </span>
                    </div>
                    <div class="contact-item">
                        <i data-lucide="map-pin"></i>
                        <span>Survey No 19/2, TP Scheme, Near Police Ground & Akashwani Kendra, Pune University Road, Shivaji Nagar-411005
                        </span>
                    </div>
                    <!-- <div class="social-links">
                        <a href="#" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i data-lucide="twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i data-lucide="instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i data-lucide="linkedin"></i></a>
                    </div> -->
                </div>
            </div>
        </div>
                    <h1 style="text-align: center; font-size: 30px; font-weight: 600; color: #000; margin-top: 10px;">
                        <span class="title-line highlight">उद्धारेंदात्मनात्मानं </span> 
                    </h1>
                  
        <!-- Main Navigation -->
        <div class="main-nav">
            <div class="container">
                <div class="nav-content">
                    <div class="logo-section">
                        <div class="logo-container">
                            <img src="images/college-logo.jpg" alt="Bharat English School & Jr. College Logo" class="college-logo">
                        </div>
                        <div class="academy-name">
                            <div class="primary-name">Bharat English School & Jr. College</div>
                            <div class="secondary-name">• Excellence • Innovation</div>
                        </div>
                    </div>

                    <nav class="navigation" id="navigation">
                        <a href="#home" class="nav-link" data-section="home">Home</a>
                        <a href="#about" class="nav-link" data-section="about">About</a>
                        <a href="#programs" class="nav-link" data-section="programs">Programs</a>
                        <a href="#campus" class="nav-link" data-section="campus">Campus</a>
                        <a href="#admissions" class="nav-link" data-section="admissions" style="white-space: nowrap;">Admissions</a>
                        <a href="#contact" class="nav-link" data-section="contact">Contact</a>
                    </nav>

                    <div class="nav-actions">
                        <button class="search-btn" aria-label="Search" id="searchBtn">
                            <i data-lucide="search"></i>
                        </button>
                        <!-- <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle menu">
                            <div class="hamburger">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </button> -->
                        <button class="student-enrollment-btn" id="studentEnrollmentBtn" onclick="window.location.href='reg/index.php'" style="white-space: nowrap;">
                            <span> 12th Student Enrollment</span>
                            <i data-lucide="user-plus"></i>
                        </button>
                        <button class="enrollment-btn" id="enrollmentBtn" onclick="window.location.href='adminpage/login.php'" style="white-space: nowrap;">
                            <span>Admin Login</span>
                            <i data-lucide="arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Search Overlay -->
    <!-- <div class="search-overlay" id="searchOverlay">
        <div class="search-container">
            <div class="search-header">
                <h3>Search</h3>
                <button class="close-search" id="closeSearch">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="search-input-container">
                <i data-lucide="search"></i>
                <input type="text" placeholder="Search programs, faculty, events..." id="searchInput">
            </div>
            <div class="search-suggestions">
                <div class="suggestion-category">
                    <h4>Popular Searches</h4>
                    <div class="suggestion-tags">
                        <span class="tag">Admissions</span>
                        <span class="tag">Scholarships</span>
                        <span class="tag">Campus Life</span>
                        <span class="tag">Events</span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Admission Tab -->
    <div class="admission-tab" id="admissionTab" onclick="window.location.href='studreg/index.php'">
        <div class="tab-content">
            <i data-lucide="calendar"></i>
            <span>Admissions Open</span>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="slideshow-background"></div>
        <div class="hero-background" style="display:none;">
            <!-- Removed hero-slideshow and hero-slide images -->
            <div class="hero-overlay"></div>
            <!-- Floating SVG shapes for hero -->
            <svg class="floating-shape floating-shape-1" width="80" height="80" viewBox="0 0 80 80" fill="none"><circle cx="40" cy="40" r="40" fill="#facc15" fill-opacity="0.15"/></svg>
            <svg class="floating-shape floating-shape-2" width="60" height="60" viewBox="0 0 60 60" fill="none"><rect width="60" height="60" rx="15" fill="#667eea" fill-opacity="0.12"/></svg>
        </div>
        
        <div class="hero-content">
            <div class="container">
                <div class="hero-text">
                    <p class="hero-subtitle highlight"></p>
                </div>
                
                <!-- Removed hero-stats section -->
            </div>
        </div>
        
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
            <span>Scroll to explore</span>
        </div>
    </section>
    <!-- SVG Wave Divider -->
    <div class="wave-divider">
      <svg viewBox="0 0 1440 320"><path fill="#667eea" fill-opacity="1" d="M0,160L80,170.7C160,181,320,203,480,197.3C640,192,800,160,960,133.3C1120,107,1280,85,1360,74.7L1440,64L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
    </div>

    <!-- Leadership Team -->
  <section class="leadership-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Under the guidance of Leadership Team</h2>
                <p class="section-subtitle">Visionary leaders driving educational excellence</p>
            </div>
            
            <div class="leadership-grid">
                <div class="leadership-card">
                    <div class="leadership-image">
                        <img src="images/VPS.jpg" alt="President Message">
                    </div>
                    <div class="leadership-content">
                        <h3>Late G.C. Alias Abasaheb Anagal</h3>
                        <h4>Founder & Visionary Educationist</h4>                      
                        <p>Founder of Vidya Prasarini Sabha in 1923, Abasaheb Anagal dedicated his life to spreading education among the needy. With a vision of collective growth, he laid the foundation for an institute that now educates over 20,000 students across 25 branches.</p>
                        
                    </div>
                </div>
                <div class="leadership-card">
                    <div class="leadership-image">
                        <img src="images/dr.aute.jpg" alt="1923 Foundation">
                    </div>
                    <div class="leadership-content">
                        <h3>Dr. V.M. Auti</h3>
                        <h4>President, Vidya Prasarini Sabha</h4>
                        <p>Dr. Auti continues the legacy of founder Abasaheb Anagal with a vision of inclusive, value-based education. Under his leadership, VPS has expanded across Pune and Lonavala with a strong commitment to academic excellence.</p>
                    </div>
                </div>
                
                <div class="leadership-card">
                    <div class="leadership-image">
                        <img src="images/cp.jpg" alt="President Message">
                    </div>
                    <div class="leadership-content">
                        <h3>Dr. Garware Madam</h3>
                        <h4>Chairperson, Governing Council, VPS</h4>                      
                        <p>The first female Chairperson of VPS, she has been instrumental in expanding into Engineering and Pharmacy education, upholding quality and accessibility for all students.</p>
                        
                    </div>
                </div>
                
                <div class="leadership-card">
                    <div class="leadership-image">
                        <img src="images/gavali1.jpg" alt="1990 Junior College">
                    </div>
                    <div class="leadership-content">
                        <h3>Dr. Gavali Sir</h3>
                        <h4>Secretary, Vidya Prasarini Sabha</h4>
                        <p>A key leader in VPS’s journey into higher education, he has led the start of BCA, BCS, Engineering, and Pharmacy colleges, and helped earn a NAAC B+ grade.</p>
                    </div>
                </div>
                
                <div class="leadership-card">
                    <div class="leadership-image">
                        <img src="images/bhurke.jpg" alt="Modern Facilities">
                    </div>
                    <div class="leadership-content">
                        <h3>Shri. Vijay Bhurke</h3>
                        <h4>Joint Secretary, VPS</h4>
                        <p>With a focus on all-round student development, he ensures state-of-the-art facilities, digital learning, and value-based education across VPS institutions</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="section-header">
                                    <h2 class="section-title">About Bharat English School & Jr. College</h2>
                <p class="section-subtitle">A legacy of excellence spanning over three decades</p>
            </div>
            <svg class="floating-shape floating-shape-3" width="100" height="100" viewBox="0 0 100 100" fill="none"><polygon points="50,0 100,100 0,100" fill="#764ba2" fill-opacity="0.10"/></svg>
            <div class="about-content">
                <div class="about-text">
                    <div class="about-highlight">
                        <div class="highlight-icon">
                            <i data-lucide="award"></i>
                        </div>
                        <div class="highlight-text">
                            <h3>Excellence in Education</h3>
                            <p>Ranked among the top 10 schools in Maharashtra for academic excellence and holistic development.</p>
                        </div>
                    </div>
                    
                    <p class="about-description">
                        Founded in 1923, Bharat English School & Jr. College has been at the forefront of educational innovation, 
                        combining traditional values with modern pedagogy. Our commitment to excellence extends beyond 
                        academics to encompass character development, leadership skills, and global citizenship.
                    </p>
                    
                    <div class="about-features">
                        <div class="feature-item">
                            <i data-lucide="users"></i>
                            <span>Expert Faculty</span>
                        </div>
                        <div class="feature-item">
                            <i data-lucide="globe"></i>
                            <span>Global Perspective</span>
                        </div>
                        <div class="feature-item">
                            <i data-lucide="heart"></i>
                            <span>Holistic Development</span>
                        </div>
                    </div>
                    
                    <a href="pages/about/index.php" class="learn-more-btn">
                        <span>Learn More</span>
                        <i data-lucide="arrow-right"></i>
                    </a>
                </div>
                
                <div class="about-visual">
                    <div class="image-grid">
                        <div class="image-item main-image">
                            <img src="images/sports-1.jpg" alt="Students in classroom">
                        </div>
                        <div class="image-item">
                            <img src="images/sports-2.jpg" alt="Science lab">
                        </div>
                        <div class="image-item">
                            <img src="images/project.jpg" alt="Library">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- SVG Wave Divider -->
    <div class="wave-divider wave-divider-flip">
      <svg viewBox="0 0 1440 320"><path fill="#facc15" fill-opacity="1" d="M0,224L80,197.3C160,171,320,117,480,117.3C640,117,800,171,960,197.3C1120,224,1280,224,1360,224L1440,224L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
    </div>

    <!-- Programs Section -->
    <section class="programs-section" id="programs">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Academic Programs</h2>
                <p class="section-subtitle">Comprehensive curriculum designed for the future</p>
            </div>
            
            <div class="programs-grid">
                <!-- <div class="program-card" data-category="primary">
                    <div class="program-icon">
                        <i data-lucide="book-open"></i>
                    </div>
                    <h3>Primary Education</h3>
                    <p>Foundation years focusing on curiosity, creativity, and character building through play-based learning.</p>
                    <ul class="program-features">
                        <li>Interactive Learning</li>
                        <li>Creative Arts</li>
                        <li>Physical Development</li>
                    </ul>
                    <a href="pages/academic-programs/primary-education.php" class="program-btn">
                        <span>Learn More</span>
                        <i data-lucide="arrow-right"></i>
                    </a>
                </div> -->
                
                <div class="program-card" data-category="secondary">
                    <div class="program-icon">
                        <i data-lucide="graduation-cap"></i>
                    </div>
                    <h3>Secondary Education</h3>
                    <p>Comprehensive curriculum with focus on critical thinking, research skills, and subject specialization.</p>
                    <ul class="program-features">
                        <li>Advanced Mathematics</li>
                        <li>Science & Technology</li>
                        <li>Literature & Arts</li>
                    </ul>
                    <a href="pages/academic-programs/secondary-education.php" class="program-btn">
                        <span>Learn More</span>
                        <i data-lucide="arrow-right"></i>
                    </a>
                </div>
                
                <div class="program-card" data-category="higher">
                    <div class="program-icon">
                        <i data-lucide="target"></i>
                    </div>
                    <h3>Higher Secondary</h3>
                    <p>Specialized streams preparing students for university education and professional careers.</p>
                    <ul class="program-features">
                        <li>Science Stream</li>
                        <!-- <li>Commerce Stream</li>
                        <li>Arts Stream</li> -->
                    </ul>
                    <a href="pages/academic-programs/higher-secondary.php" class="program-btn" style="margin-top: 130px;">
                        <span>Learn More</span>
                        <i data-lucide="arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- SVG Wave Divider -->
    <div class="wave-divider">
      <svg viewBox="0 0 1440 320"><path fill="#764ba2" fill-opacity="1" d="M0,64L80,101.3C160,139,320,213,480,229.3C640,245,800,203,960,186.7C1120,171,1280,181,1360,186.7L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
    </div>

    <!-- Campus Life Section -->
    <section class="campus-section" id="campus">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Campus Life</h2>
                <p class="section-subtitle">Where learning meets living</p>
            </div>
            
            <div class="campus-showcase">
                <div class="campus-item">
                    <div class="campus-image">
                        <img src="images/5.png" alt="Modern Classrooms">
                    </div>
                    <div class="campus-content">
                        <h3>Celebrations & Events</h3>
                        <p>Cultural fests, annual days, festivals, and special events bring joy, unity, and vibrant student participation to campus life. Where every moment becomes a memory</p>
                    </div>
                </div>
                
                <div class="campus-item reverse">
                    <div class="campus-image">
                        <img src="images/chem_lab-1.jpg" alt="Science Labs">
                    </div>
                    <div class="campus-content">
                        <h3>Well-Equipped Chemistry Lab</h3>
                        <p>Modern chemistry lab featuring advanced instruments, safety equipment, and hands-on resources to conduct experiments, enhance practical skills, and foster scientific thinking.</p>
                    </div>
                </div>
                
                <div class="campus-item">
                    <div class="campus-image">
                        <img src="images/it-2.jpg" alt="Library">
                    </div>
                    <div class="campus-content">
                        <h3>Computer Science Lab</h3>
                        <p>Equipped with high-performance systems and development tools to support programming, software development, and project-based learning.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- SVG Wave Divider -->
    <div class="wave-divider wave-divider-flip">
      <svg viewBox="0 0 1440 320"><path fill="#667eea" fill-opacity="1" d="M0,288L80,272C160,256,320,224,480,197.3C640,171,800,149,960,154.7C1120,160,1280,192,1360,208L1440,224L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
    </div>

  

    <!-- Admissions Section -->
    <section class="admissions-section" id="admissions">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Admissions</h2>
                <p class="section-subtitle">Begin your journey to excellence</p>
            </div>
            
            <div class="admissions-content">
                <div class="admissions-info">
                    <div class="admission-card">
                        <div class="admission-icon">
                            <i data-lucide="calendar"></i>
                        </div>
                        <h3>Admission Open</h3>
                        <p>Applications are now being accepted for the academic year 2024-25. Secure your child's future with quality education.</p>
                        <ul class="admission-features">
                            <li><i data-lucide="check"></i> Online Application Process</li>
                            <li><i data-lucide="check"></i> Document Verification</li>
                            <li><i data-lucide="check"></i> Merit-based Selection</li>
                            <li><i data-lucide="check"></i> Scholarship Opportunities</li>
                        </ul>
                    </div>
                    
                    <div class="admission-card">
                        <div class="admission-icon">
                            <i data-lucide="file-text"></i>
                        </div>
                        <h3>Required Documents</h3>
                        <p>Ensure you have all necessary documents ready before starting the application process.</p>
                        <ul class="admission-features">
                            <li><i data-lucide="check"></i> 10th Marksheet</li>
                            <li><i data-lucide="check"></i> School Leaving Certificate</li>
                            <li><i data-lucide="check"></i> Aadhaar Card</li>
                            <li><i data-lucide="check"></i> Passport Size Photo</li>
                        </ul>
                    </div>
                    
                    <div class="admission-card">
                        <div class="admission-icon">
                            <i data-lucide="clock"></i>
                        </div>
                        <h3>Application Timeline</h3>
                        <p>Important dates to remember for the admission process.</p>
                        <ul class="admission-features">
                            <li><i data-lucide="calendar"></i> Application Deadline: March 31, 2024</li>
                            <li><i data-lucide="calendar"></i> Document Verification: April 1-15, 2024</li>
                            <li><i data-lucide="calendar"></i> Merit List: April 20, 2024</li>
                            <li><i data-lucide="calendar"></i> Admission Confirmation: May 1, 2024</li>
                        </ul>
                    </div>
                </div>
                
                <div class="admissions-actions">
                    <div class="action-buttons">
                        <a href="studreg/instructions.php" class="primary-btn">
                            <i data-lucide="book-open"></i>
                            <span>Read Instructions</span>
                        </a>
                        <a href="studreg/registration.php" class="secondary-btn">
                            <i data-lucide="user-plus"></i>
                            <span>Start Application</span>
                        </a>
                    </div>
                    <p class="admission-note">Please read the instructions carefully before starting your application. The process takes approximately 15-20 minutes to complete.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- SVG Wave Divider -->
    <div class="wave-divider">
      <svg viewBox="0 0 1440 320"><path fill="#facc15" fill-opacity="1" d="M0,32L80,53.3C160,75,320,117,480,133.3C640,149,800,139,960,133.3C1120,128,1280,128,1360,128L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
    </div>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">What Parents Say</h2>
                <p class="section-subtitle">Trusted by thousands of families</p>
            </div>
            
            <div class="testimonials-carousel">
                <div class="testimonials-container" id="testimonialsContainer">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="quote-icon">
                                <i data-lucide="quote"></i>
                            </div>
                            <p>"Bharat English School & Jr. College has transformed my child's learning journey. The teachers are dedicated, the facilities are world-class, and the values instilled are priceless."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Mrs. Priya Sharma">
                            <div class="author-info">
                                <h4>Mrs. Priya Sharma</h4>
                                <span>Parent of Class 11 Student</span>
                            </div>
                        </div>
                        <div class="rating">
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="quote-icon">
                                <i data-lucide="quote"></i>
                            </div>
                            <p>"We are thankful to Hinge Sir, Nirgundikar Madam, Havaldar madam, Bhosale Sir, Barne madam. Under their guidance we cracked entrance like NEET-UG and NEET-PG. Today we are glad to say we studied in Bharat English School and Jr. College to become future doctors."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Mr. Rajesh Patel">
                            <div class="author-info">
                                <h4>Dr. Siddhant S. Gadhave</h4>
                                <span>Batch No.:- 2015-2016
                                      Profession : PG – IInd year in M.D. Pediatrics
                                </span>
                            </div>
                        </div>
                        <div class="rating">
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="quote-icon">
                                <i data-lucide="quote"></i>
                            </div>
                            <p>"The school's focus on innovation and technology has prepared my son for the digital future. The teachers are exceptional and truly care about each student's success."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Mrs. Anjali Deshmukh">
                            <div class="author-info">
                                <h4>Mrs. Anjali Deshmukh</h4>
                                <span>Parent of Class 12 Student</span>
                            </div>
                        </div>
                        <div class="rating">
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                            <i data-lucide="star" class="star filled"></i>
                        </div>
                    </div>
                </div>
                
                <div class="carousel-controls">
                    <button class="carousel-btn prev" id="testimonialsPrev">
                        <i data-lucide="chevron-left"></i>
                    </button>
                    <button class="carousel-btn next" id="testimonialsNext">
                        <i data-lucide="chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- SVG Wave Divider -->
    <div class="wave-divider">
      <svg viewBox="0 0 1440 320"><path fill="#facc15" fill-opacity="1" d="M0,32L80,53.3C160,75,320,117,480,133.3C640,149,800,139,960,133.3C1120,128,1280,128,1360,128L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
    </div>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <h2>Get in Touch</h2>
                                            <p>Ready to join the Bharat English School & Jr. College family? Contact us today to learn more about our programs and admission process.</p>
                    
                    <div class="contact-details">
                        <div class="contact-item">
                            <i data-lucide="map-pin"></i>
                            <div>
                                <h4>Address</h4>
                                <p>Survey No 19/2, TP Scheme, Near Police Ground & Akashwani Kendra, Pune University Road, Shivaji Nagar-411005<br>Pune, Maharashtra </p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <i data-lucide="phone"></i>
                            <div>
                                <h4>Phone</h4>
                                <p>02025536035</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <i data-lucide="mail"></i>
                            <div>
                                <h4>Email</h4>
                                <p>bharatprincipal5@gmail.com </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h3>Send us a Message</h3>
                    <form id="contactForm">
                        <div class="form-group">
                            <input type="text" id="name" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" id="phone" name="phone" placeholder="Your Phone">
                        </div>
                        <div class="form-group">
                            <select id="interest" name="interest" required>
                                <option value="">Select Interest</option>
                                <option value="admissions">Admissions</option>
                                <option value="programs">Programs</option>
                                <option value="campus">Campus Tour</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea id="message" name="message" placeholder="Your Message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">
                            <span>Send Message</span>
                            <i data-lucide="send"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- SVG Wave Divider -->
    <div class="wave-divider wave-divider-flip">
      <svg viewBox="0 0 1440 320"><path fill="#667eea" fill-opacity="1" d="M0,288L80,272C160,256,320,224,480,197.3C640,171,800,149,960,154.7C1120,160,1280,192,1360,208L1440,224L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="images/college-logo.jpg" alt="Bharat English School & Jr. College Logo" class="footer-college-logo">
                        <div class="footer-brand">
                            <h4>Bharat English School & Jr. College</h4>
                            <p>Excellence • Innovation • Leadership</p>
                        </div>
                    </div>
                    <p class="footer-description">
                        Shaping future leaders through excellence in education, innovation in learning, and commitment to holistic development.
                    </p>
                    <!-- <div class="social-links">
                        <a href="#" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i data-lucide="twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i data-lucide="instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i data-lucide="linkedin"></i></a>
                        <a href="#" aria-label="YouTube"><i data-lucide="youtube"></i></a>
                    </div> -->
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#programs">Programs</a></li>
                        <li><a href="#campus">Campus Life</a></li>
                        <li><a href="#admissions">Admissions</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Programs</h4>
                    <ul>
                        <!-- <li><a href="#">Primary Education</a></li> -->
                        <li><a href="#">Secondary Education</a></li>
                        <li><a href="#">Higher Secondary</a></li>
                        <li><a href="#">Sports & Activities</a></li>
                        <li><a href="#">Arts & Culture</a></li>
                        <li><a href="#">Technology</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <div class="contact-info">
                        <p><i data-lucide="map-pin"></i> Survey No 19/2, TP Scheme, Near Police Ground & Akashwani Kendra, Pune University Road, Shivaji Nagar-411005</p>
                        <p><i data-lucide="phone"></i>  02025536035</p>
                        <p><i data-lucide="mail"></i> bharatprincipal5@gmail.com </p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Bharat English School & Jr. College. All rights reserved.</p>
                <div class="footer-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="scroll-to-top">
        <i data-lucide="chevron-up"></i>
    </button>

    <!-- JavaScript -->
    <script src="script.js?v=<?php echo time(); ?>"></script>
    
    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
    
    <!-- Fallback script to ensure loading screen is removed -->
    <script>
        // Fallback to remove loading screen if main script fails
        setTimeout(function() {
            const loadingScreen = document.getElementById('loadingScreen');
            if (loadingScreen && loadingScreen.parentNode) {
                console.log('Fallback: Removing loading screen');
                loadingScreen.classList.add('hidden');
                setTimeout(function() {
                    if (loadingScreen && loadingScreen.parentNode) {
                        loadingScreen.remove();
                    }
                }, 500);
            }
        }, 4000); // Remove after 4 seconds as fallback
    </script>
    <!-- Update button classes for pulse effect -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('button, .primary-btn, .secondary-btn, .enrollment-btn, .learn-more-btn, .program-btn, .submit-btn').forEach(btn => {
          btn.classList.add('button-pulse');
        });
      });
    </script>
</body>
</html>
