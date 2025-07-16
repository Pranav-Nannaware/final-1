<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Bharat English School & Jr. College</title>
    <meta name="description" content="Learn more about Bharat English School & Jr. College - A legacy of excellence in education spanning over three decades, fostering innovation, leadership, and academic excellence.">
    
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
                <span>About Us</span>
            </div>
        </div>
    </section>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <div class="header-icon">
                    <i data-lucide="award"></i>
                </div>
                <h1 class="page-title">About Bharat English School & Jr. College</h1>
                <p class="page-subtitle">A glorious legacy of excellence spanning over a century since 1923</p>
            </div>
        </div>
    </section>

    <!-- Our Story -->
    <section class="program-overview">
        <div class="container">
            <div class="overview-content">
                <div class="overview-text">
                    <h2>Our Glorious Legacy</h2>
                    <p class="lead">Bharat English School and Junior College, Shivajinagar, Pune was established during the pre-independence era on 3rd December 1923 by Late G.C Angal alias Abasaheb. Inspired by feelings of patriotism and national cause, our school has a glorious legacy and history of over 100 years of educational excellence.</p>
                    
                    <div class="highlight-points">
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="calendar"></i>
                            </div>
                            <div class="point-content">
                                <h4>Established 1923</h4>
                                <p>Founded during pre-independence era by Late G.C Angal alias Abasaheb, inspired by patriotism and national cause.</p>
                            </div>
                        </div>
                        
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="trophy"></i>
                            </div>
                            <div class="point-content">
                                <h4>95%+ SSC Results</h4>
                                <p>Consistently achieving outstanding academic performance with SSC results above 95 percent year after year.</p>
                            </div>
                        </div>
                        
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="graduation-cap"></i>
                            </div>
                            <div class="point-content">
                                <h4>600+ College Students</h4>
                                <p>Four divisions of XI and XII with excellent laboratories and experienced faculty serving students from across Pune region.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="overview-image">
                    <img src="../../images/1.png" alt="Our School Heritage">
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="curriculum-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our Mission & Vision</h2>
                <p class="section-subtitle">Guiding principles that drive our educational philosophy</p>
            </div>
            
            <div class="curriculum-grid">
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>To continue our century-old legacy of providing quality education while fostering patriotism, national values, and holistic development of students.</p>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="target"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>To provide quality and quantity education with special attention to physical, mental, and intellectual development, making students responsible citizens.</p>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="heart"></i>
                    </div>
                    <h3>Our Values</h3>
                    <ul>
                        <li>Patriotism & National Cause</li>
                        <li>Quality Education</li>
                        <li>Holistic Development</li>
                        <li>Social Responsibility</li>
                        <li>Academic Excellence</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Junior College Section -->
    <section class="learning-approach">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our Junior College</h2>
                <p class="section-subtitle">Excellence in higher secondary education since 1990</p>
            </div>
            
            <div class="facilities-grid">
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="../../images/chem_lab-2.jpg" alt="Science Laboratories">
                    </div>
                    <div class="facility-content">
                        <h3>Well-Equipped Chemistry Lab</h3>
                        <p>Modern chemistry lab featuring advanced instruments, safety equipment, and hands-on resources to conduct experiments, enhance practical skills, and foster scientific thinking.</p>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="../../images/it-1.jpg" alt="Experienced Faculty">
                    </div>
                    <div class="facility-content">
                        <h3>Computer Science Lab</h3>
                        <p>Equipped with high-performance systems and development tools to support programming, software development, and project-based learning.</p>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="../../images/it-2.jpg" alt="Student Development">
                    </div>
                    <div class="facility-content">
                        <h3> Information Technology Lab</h3>
                        <p>Modern IT lab designed for practical training in networking, databases, and emerging digital technologies.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements -->
    <section class="exam-prep-section">
        <div class="container">
            <div class="prep-header">
                <h2>Our Achievements</h2>
                <p>Recognition and milestones that reflect our century-old commitment to excellence</p>
            </div>
            
            <div class="prep-features-grid">
                <div class="prep-feature">
                    <div class="feature-icon">
                        <i data-lucide="award"></i>
                    </div>
                    <h4>95%+ SSC Results</h4>
                    <p>Consistently achieving outstanding academic performance with SSC results above 95 percent, demonstrating our commitment to quality education.</p>
                </div>
                
                <div class="prep-feature">
                    <div class="feature-icon">
                        <i data-lucide="heart"></i>
                    </div>
                    <h4>Financial Support</h4>
                    <p>Providing financial help to poor and needy students through collaboration with various NGOs, ensuring education is accessible to all.</p>
                </div>
                
                <div class="prep-feature">
                    <div class="feature-icon">
                        <i data-lucide="map-pin"></i>
                    </div>
                    <h4>Wide Accessibility</h4>
                    <p>Serving students from Aundh, Sangvi, Baner, Pimpri, Chinchwad, Alandi, Talegaon, and Lonavala, making quality education accessible.</p>
                </div>
                
                <div class="prep-feature">
                    <div class="feature-icon">
                        <i data-lucide="users"></i>
                    </div>
                    <h4>600+ College Students</h4>
                    <p>Four divisions of XI and XII with over 600 students pursuing higher secondary education in our well-equipped college.</p>
                </div>
            </div>
            
            <div class="success-stats">
                <h3>Our Impact in Numbers</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Years of Excellence</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">95%+</div>
                        <div class="stat-label">SSC Success Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">600+</div>
                        <div class="stat-label">College Students</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">4</div>
                        <div class="stat-label">Science Divisions</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Team -->
    <section class="leadership-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Leadership Team</h2>
                <p class="section-subtitle">Visionary leaders driving educational excellence</p>
            </div>
            
            <div class="leadership-grid">
                <div class="leadership-card">
                    <div class="leadership-image">
                        <img src="../../images/VPS.jpg" alt="President Message">
                    </div>
                    <div class="leadership-content">
                        <h3>Late G.C. Alias Abasaheb Anagal</h3>
                        <h4>Founder & Visionary Educationist</h4>                      
                        <p>Founder of Vidya Prasarini Sabha in 1923, Abasaheb Anagal dedicated his life to spreading education among the needy. With a vision of collective growth, he laid the foundation for an institute that now educates over 20,000 students across 25 branches.</p>
                        
                    </div>
                </div>
                <div class="leadership-card">
                    <div class="leadership-image">
                        <img src="../../images/dr.aute.jpg" alt="1923 Foundation">
                    </div>
                    <div class="leadership-content">
                        <h3>Dr. V.M. Auti</h3>
                        <h4>President, Vidya Prasarini Sabha</h4>
                        <p>Dr. Auti continues the legacy of founder Abasaheb Anagal with a vision of inclusive, value-based education. Under his leadership, VPS has expanded across Pune and Lonavala with a strong commitment to academic excellence.</p>
                    </div>
                </div>
                
                <div class="leadership-card">
                    <div class="leadership-image">
                        <img src="../../images/cp.jpg" alt="President Message">
                    </div>
                    <div class="leadership-content">
                        <h3>Dr. Garware Madam</h3>
                        <h4>Chairperson, Governing Council, VPS</h4>                      
                        <p>The first female Chairperson of VPS, she has been instrumental in expanding into Engineering and Pharmacy education, upholding quality and accessibility for all students.</p>
                        
                    </div>
                </div>
                
                <div class="leadership-card">
                    <div class="leadership-image">
                        <img src="../../images/gavali.jpg" alt="1990 Junior College">
                    </div>
                    <div class="leadership-content">
                        <h3>Dr. Gavali Sir</h3>
                        <h4>Secretary, Vidya Prasarini Sabha</h4>
                        <p>A key leader in VPS’s journey into higher education, he has led the start of BCA, BCS, Engineering, and Pharmacy colleges, and helped earn a NAAC B+ grade.</p>
                    </div>
                </div>
                
                <div class="leadership-card">
                    <div class="leadership-image">
                        <img src="../../images/bhurke.jpg" alt="Modern Facilities">
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

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Join Our Legacy of Excellence</h2>
                <p>Become part of a community that has been shaping future leaders for over three decades.</p>
                <div class="cta-actions">
                    <a href="../../studreg/index.php" class="primary-btn">
                        <span>Apply for Admission</span>
                        <i data-lucide="arrow-right"></i>
                    </a>
                    <a href="../../index.php#programs" class="secondary-btn">
                        <span>Explore Programs</span>
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
                        <li><a href="../academic-programs/primary-education.php">Primary Education</a></li>
                        <li><a href="../academic-programs/secondary-education.php">Secondary Education</a></li>
                        <li><a href="../academic-programs/higher-secondary.php">Higher Secondary</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="../../index.php">Home</a></li>
                        <li><a href="index.php">About Us</a></li>
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