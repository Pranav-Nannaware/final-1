<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secondary Education - Bharat English School & Jr. College</title>
    <meta name="description" content="Secondary Education at Bharat English School & Jr. College - Comprehensive curriculum with focus on critical thinking, research skills, and subject specialization.">
    
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
                <span>Secondary Education</span>
            </div>
        </div>
    </section>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <div class="header-icon">
                    <i data-lucide="graduation-cap"></i>
                </div>
                <h1 class="page-title">Secondary Education</h1>
                <p class="page-subtitle">Comprehensive curriculum with focus on critical thinking, research skills, and subject specialization</p>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview">
        <div class="container">
            <div class="overview-content">
                <div class="overview-text">
                    <h2>Preparing for the Future</h2>
                    <p class="lead">Our Secondary Education program (Classes 6-10) is designed to challenge and inspire students as they transition from childhood to adolescence. We focus on developing critical thinking skills, fostering independence, and preparing students for higher secondary education and beyond.</p>
                    
                    <div class="highlight-points">
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="brain"></i>
                            </div>
                            <div class="point-content">
                                <h4>Critical Thinking</h4>
                                <p>Development of analytical and problem-solving skills through inquiry-based learning approaches.</p>
                            </div>
                        </div>
                        
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="search"></i>
                            </div>
                            <div class="point-content">
                                <h4>Research Skills</h4>
                                <p>Training in research methodology, information gathering, and academic writing skills.</p>
                            </div>
                        </div>
                        
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="target"></i>
                            </div>
                            <div class="point-content">
                                <h4>Subject Specialization</h4>
                                <p>Introduction to specialized subjects and exploration of career interests and aptitudes.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="overview-image">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Secondary Education">
                </div>
            </div>
        </div>
    </section>

    <!-- Curriculum -->
    <section class="curriculum-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Advanced Curriculum</h2>
                <p class="section-subtitle">Rigorous academic program preparing students for higher education</p>
            </div>
            
            <div class="curriculum-grid">
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="book-open"></i>
                    </div>
                    <h3>Languages</h3>
                    <ul>
                        <li>English Literature & Grammar</li>
                        <li>Hindi/Marathi</li>
                        <li>Sanskrit</li>
                        <li>French/German (Optional)</li>
                        <li>Communication Skills</li>
                    </ul>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="calculator"></i>
                    </div>
                    <h3>Mathematics</h3>
                    <ul>
                        <li>Algebra & Geometry</li>
                        <li>Trigonometry</li>
                        <li>Statistics & Probability</li>
                        <li>Mensuration</li>
                        <li>Applied Mathematics</li>
                    </ul>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="atom"></i>
                    </div>
                    <h3>Science</h3>
                    <ul>
                        <li>Physics</li>
                        <li>Chemistry</li>
                        <li>Biology</li>
                        <li>Environmental Science</li>
                        <li>Laboratory Practicals</li>
                    </ul>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="globe"></i>
                    </div>
                    <h3>Social Studies</h3>
                    <ul>
                        <li>History & Civics</li>
                        <li>Geography</li>
                        <li>Economics</li>
                        <li>Political Science</li>
                        <li>Current Affairs</li>
                    </ul>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="monitor"></i>
                    </div>
                    <h3>Computer Science</h3>
                    <ul>
                        <li>Programming Fundamentals</li>
                        <li>Web Development</li>
                        <li>Database Management</li>
                        <li>Artificial Intelligence Basics</li>
                        <li>Digital Literacy</li>
                    </ul>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="palette"></i>
                    </div>
                    <h3>Electives</h3>
                    <ul>
                        <li>Fine Arts</li>
                        <li>Music & Performing Arts</li>
                        <li>Physical Education</li>
                        <li>Entrepreneurship</li>
                        <li>Life Skills</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Board Preparation -->
    <section class="board-prep-section">
        <div class="container">
            <div class="board-prep-content">
                <div class="prep-info">
                    <h2>Board Examination Preparation</h2>
                    <p>Our comprehensive preparation strategy ensures students excel in Class 10 board examinations while developing deeper understanding of subjects.</p>
                    
                    <div class="prep-features">
                        <div class="prep-feature">
                            <div class="feature-icon">
                                <i data-lucide="clipboard-check"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Mock Examinations</h4>
                                <p>Regular mock tests simulating actual board exam conditions to build confidence and exam temperament.</p>
                            </div>
                        </div>
                        
                        <div class="prep-feature">
                            <div class="feature-icon">
                                <i data-lucide="users"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Expert Faculty</h4>
                                <p>Experienced teachers with proven track record in board exam preparation and subject expertise.</p>
                            </div>
                        </div>
                        
                        <div class="prep-feature">
                            <div class="feature-icon">
                                <i data-lucide="book"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Study Materials</h4>
                                <p>Comprehensive study materials, practice papers, and previous years' question banks.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="results-showcase">
                    <h3>Our Results Speak</h3>
                    <div class="results-grid">
                        <div class="result-stat">
                            <div class="stat-number">98%</div>
                            <div class="stat-label">Pass Percentage</div>
                        </div>
                        <div class="result-stat">
                            <div class="stat-number">85%</div>
                            <div class="stat-label">Above 80% Marks</div>
                        </div>
                        <div class="result-stat">
                            <div class="stat-number">45%</div>
                            <div class="stat-label">Above 90% Marks</div>
                        </div>
                        <div class="result-stat">
                            <div class="stat-number">15</div>
                            <div class="stat-label">State Toppers</div>
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
                <h2 class="section-title">Advanced Learning Facilities</h2>
                <p class="section-subtitle">Modern infrastructure supporting comprehensive secondary education</p>
            </div>
            
            <div class="facilities-grid">
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Science Labs">
                    </div>
                    <div class="facility-content">
                        <h3>Advanced Science Laboratories</h3>
                        <p>Fully equipped Physics, Chemistry, and Biology labs with modern instruments and safety equipment.</p>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Computer Lab">
                    </div>
                    <div class="facility-content">
                        <h3>Computer & IT Labs</h3>
                        <p>State-of-the-art computer labs with latest software and high-speed internet connectivity.</p>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Library">
                    </div>
                    <div class="facility-content">
                        <h3>Digital Library & Resource Center</h3>
                        <p>Extensive collection of books, journals, and digital resources with quiet study areas.</p>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Sports Complex">
                    </div>
                    <div class="facility-content">
                        <h3>Sports Complex</h3>
                        <p>Multi-purpose sports facilities including basketball court, volleyball court, and athletics track.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Shape Your Future with Us</h2>
                <p>Join our Secondary Education program and build a strong foundation for higher studies and career success.</p>
                <div class="cta-actions">
                    <a href="../../index.php#contact" class="primary-btn">
                        <span>Apply Now</span>
                        <i data-lucide="arrow-right"></i>
                    </a>
                    <a href="../academic-programs/higher-secondary.php" class="secondary-btn">
                        <span>View Higher Secondary</span>
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
                        <li><a href="higher-secondary.php">Higher Secondary</a></li>
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