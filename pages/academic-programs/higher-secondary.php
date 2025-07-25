<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Higher Secondary - Bharat English School & Jr. College</title>
    <meta name="description" content="Higher Secondary Education at Bharat English School & Jr. College - Specialized streams preparing students for university education and professional careers.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../style.css?v=<?php echo time(); ?>">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- GSAP for Advanced Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
</head>
<body>
    <!-- Header -->
    <header id="header" class="header">
        <!-- Contact Bar -->
        <div class="contact-bar">
            <div class="container">
                <div class="contact-info">
                    <div class="contact-item">
                        <i data-lucide="phone"></i>
                        <span>+91 20 2550 1234</span>
                    </div>
                    <div class="contact-item">
                        <i data-lucide="mail"></i>
                        <span>admissions@bharatenglish.edu.in</span>
                    </div>
                    <div class="contact-item">
                        <i data-lucide="map-pin"></i>
                        <span>Koregaon Park, Pune, Maharashtra</span>
                    </div>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i data-lucide="twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i data-lucide="instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i data-lucide="linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <div class="main-nav">
            <div class="container">
                <div class="nav-content">
                    <div class="logo-section">
                        <div class="logo-container">
                            <div class="logo-circle">
                                <span>BESJC</span>
                            </div>
                        </div>
                        <div class="academy-name">
                            <div class="primary-name">Bharat English School & Jr. College</div>
                            <div class="secondary-name">Excellence • Innovation • Leadership</div>
                        </div>
                    </div>

                    <nav class="navigation" id="navigation">
                        <a href="../../index.php" class="nav-link">Home</a>
                        <a href="../../index.php#about" class="nav-link">About</a>
                        <a href="../../index.php#programs" class="nav-link">Programs</a>
                        <a href="../../index.php#campus" class="nav-link">Campus</a>
                        <a href="../../index.php#contact" class="nav-link">Contact</a>
                    </nav>

                    <div class="nav-actions">
                        <button class="search-btn" aria-label="Search" id="searchBtn">
                            <i data-lucide="search"></i>
                        </button>
                        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle menu">
                            <div class="hamburger">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </button>
                        <a href="../../admin-login.php" class="enrollment-btn" style="white-space: nowrap;">
                            <span>Admin Login</span>
                            <i data-lucide="arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="container">
            <div class="breadcrumb">
                <a href="../../index.php">Home</a>
                <i data-lucide="chevron-right"></i>
                <a href="../../index.php#programs">Academic Programs</a>
                <i data-lucide="chevron-right"></i>
                <span>Higher Secondary</span>
            </div>
        </div>
    </section>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <div class="header-icon">
                    <i data-lucide="target"></i>
                </div>
                <h1 class="page-title">Science Stream - Higher Secondary</h1>
                <p class="page-subtitle">Comprehensive science education preparing students for medical, engineering, and research careers</p>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview">
        <div class="container">
            <div class="overview-content">
                <div class="overview-text">
                    <h2>Excellence in Science Education</h2>
                    <p class="lead">Our Science Stream program (Classes 11-12) is designed to prepare students for medical, engineering, and research careers. With expert faculty, state-of-the-art laboratories, and comprehensive support, we ensure students are well-prepared for competitive examinations like JEE, NEET, and other entrance tests.</p>
                    
                    <div class="highlight-points">
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="atom"></i>
                            </div>
                            <div class="point-content">
                                <h4>Science Specialization</h4>
                                <p>Focused curriculum in Physics, Chemistry, Mathematics, and Biology with practical laboratory experience.</p>
                            </div>
                        </div>
                        
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="graduation-cap"></i>
                            </div>
                            <div class="point-content">
                                <h4>Medical & Engineering Prep</h4>
                                <p>Comprehensive preparation for JEE Main/Advanced, NEET, BITSAT, and other competitive entrance exams.</p>
                            </div>
                        </div>
                        
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="microscope"></i>
                            </div>
                            <div class="point-content">
                                <h4>Research & Innovation</h4>
                                <p>Hands-on research experience and innovation projects to develop scientific thinking and problem-solving skills.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="overview-image">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Higher Secondary Education">
                </div>
            </div>
        </div>
    </section>

    <!-- Streams Section -->
    <section class="streams-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Science Stream</h2>
                <p class="section-subtitle">Specialized program for future doctors, engineers, and researchers</p>
            </div>
            
            <div class="streams-grid">
                <div class="stream-card science">
                    <div class="stream-header">
                        <div class="stream-icon">
                            <i data-lucide="atom"></i>
                        </div>
                        <h3>Science Stream</h3>
                        <p>For future doctors, engineers, and researchers</p>
                    </div>
                    
                    <div class="stream-subjects">
                        <h4>Core Subjects:</h4>
                        <ul>
                            <li>Physics</li>
                            <li>Chemistry</li>
                            <li>Mathematics/Biology</li>
                            <li>English</li>
                            <li>Computer Science (Optional)</li>
                        </ul>
                    </div>
                    
                    <div class="career-paths">
                        <h4>Career Paths:</h4>
                        <div class="career-tags">
                            <span>Medicine</span>
                            <span>Engineering</span>
                            <span>Research</span>
                            <span>Technology</span>
                        </div>
                    </div>
                    
                    <div class="entrance-exams">
                        <h4>Entrance Exam Prep:</h4>
                        <div class="exam-tags">
                            <span>JEE Main/Advanced</span>
                            <span>NEET</span>
                            <span>BITSAT</span>
                            <span>State CET</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Competitive Exam Preparation -->
    <section class="exam-prep-section">
        <div class="container">
            <div class="exam-prep-content">
                <div class="prep-header">
                    <h2>Science Entrance Exam Excellence</h2>
                    <p>Our specialized coaching and preparation programs ensure success in medical and engineering entrance examinations.</p>
                </div>
                
                <div class="prep-features-grid">
                    <div class="prep-feature">
                        <div class="feature-icon">
                            <i data-lucide="users"></i>
                        </div>
                        <h4>Expert Science Faculty</h4>
                        <p>IIT/NIT graduates and experienced professionals providing specialized coaching in Physics, Chemistry, Mathematics, and Biology</p>
                    </div>
                    
                    <div class="prep-feature">
                        <div class="feature-icon">
                            <i data-lucide="clock"></i>
                        </div>
                        <h4>Integrated Preparation</h4>
                        <p>Seamless integration of entrance exam preparation with regular science curriculum</p>
                    </div>
                    
                    <div class="prep-feature">
                        <div class="feature-icon">
                            <i data-lucide="target"></i>
                        </div>
                        <h4>Science Mock Tests</h4>
                        <p>Regular mock tests for JEE, NEET, and BITSAT with detailed performance analysis</p>
                    </div>
                    
                    <div class="prep-feature">
                        <div class="feature-icon">
                            <i data-lucide="book"></i>
                        </div>
                        <h4>Science Study Material</h4>
                        <p>Comprehensive study materials, question banks, and laboratory manuals for thorough preparation</p>
                    </div>
                </div>
                
                <div class="success-stats">
                    <h3>Our Science Success Record</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">150+</div>
                            <div class="stat-label">JEE Qualifiers</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">120+</div>
                            <div class="stat-label">NEET Qualifiers</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">95%</div>
                            <div class="stat-label">Science University Admissions</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">25+</div>
                            <div class="stat-label">Top Science Rankers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities -->
    <section class="facilities-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">World-Class Science Facilities</h2>
                <p class="section-subtitle">Advanced laboratories and infrastructure supporting science education</p>
            </div>
            
            <div class="facilities-grid">
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Research Labs">
                    </div>
                    <div class="facility-content">
                        <h3>Research Laboratories</h3>
                        <p>State-of-the-art labs for Physics, Chemistry, Biology, and Computer Science with latest equipment.</p>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Digital Library">
                    </div>
                    <div class="facility-content">
                        <h3>Digital Library & E-Resources</h3>
                        <p>Extensive digital library with access to international journals and research databases.</p>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Study Halls">
                    </div>
                    <div class="facility-content">
                        <h3>Dedicated Study Halls</h3>
                        <p>Quiet study spaces with individual desks and group study rooms for collaborative learning.</p>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1581726690015-c9861fa5057f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Smart Classrooms">
                    </div>
                    <div class="facility-content">
                        <h3>Smart Classrooms</h3>
                        <p>Technology-enabled classrooms with interactive boards and digital learning resources.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
                            <div class="cta-content">
                    <h2>Ready to Pursue Science Excellence?</h2>
                    <p>Join our Science Stream and take the first step towards your dream medical or engineering career.</p>
                    <div class="cta-actions">
                        <a href="../../index.php#contact" class="primary-btn">
                            <span>Apply for Science Stream</span>
                            <i data-lucide="arrow-right"></i>
                        </a>
                        <a href="../academic-programs/primary-education.php" class="secondary-btn">
                            <span>View Primary Education</span>
                            <i data-lucide="arrow-right"></i>
                        </a>
                    </div>
                </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <div class="logo-circle">
                            <span>BESJC</span>
                        </div>
                        <div class="footer-brand">
                            <h4>Bharat English School & Jr. College</h4>
                            <p>Excellence • Innovation • Leadership</p>
                        </div>
                    </div>
                    <p class="footer-description">
                        Shaping future leaders through excellence in education, innovation in learning, and commitment to holistic development.
                    </p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i data-lucide="twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i data-lucide="instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i data-lucide="linkedin"></i></a>
                        <a href="#" aria-label="YouTube"><i data-lucide="youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4>Academic Programs</h4>
                    <ul>
                        <li><a href="primary-education.php">Primary Education</a></li>
                        <li><a href="secondary-education.php">Secondary Education</a></li>
                        <li><a href="higher-secondary.php">Science Stream (11-12)</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="../../index.php">Home</a></li>
                        <li><a href="../../index.php#about">About Us</a></li>
                        <li><a href="../../index.php#campus">Campus Life</a></li>
                        <li><a href="../../index.php#contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <div class="contact-info">
                        <p><i data-lucide="map-pin"></i> 123 Excellence Road, Koregaon Park, Pune</p>
                        <p><i data-lucide="phone"></i> +91 20 2550 1234</p>
                        <p><i data-lucide="mail"></i> admissions@bharatenglish.edu.in</p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 Bharat English School & Jr. College. All rights reserved.</p>
                <div class="footer-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="../../script.js?v=<?php echo time(); ?>"></script>
    
    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html> 