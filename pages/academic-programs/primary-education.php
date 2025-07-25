<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primary Education - Bharat English School & Jr. College</title>
    <meta name="description" content="Primary Education at Bharat English School & Jr. College - Foundation years focusing on curiosity, creativity, and character building through play-based learning.">
    
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
                <span>Primary Education</span>
            </div>
        </div>
    </section>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <div class="header-icon">
                    <i data-lucide="book-open"></i>
                </div>
                <h1 class="page-title">Primary Education</h1>
                <p class="page-subtitle">Foundation years focusing on curiosity, creativity, and character building through play-based learning</p>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview">
        <div class="container">
            <div class="overview-content">
                <div class="overview-text">
                    <h2>Building Strong Foundations</h2>
                    <p class="lead">Our Primary Education program (Classes 1-5) is designed to nurture young minds during their most formative years. We believe that the foundation laid during these early years determines a child's future academic success and overall development.</p>
                    
                    <div class="highlight-points">
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="star"></i>
                            </div>
                            <div class="point-content">
                                <h4>Play-Based Learning</h4>
                                <p>Learning through play, games, and interactive activities that make education enjoyable and effective.</p>
                            </div>
                        </div>
                        
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="heart"></i>
                            </div>
                            <div class="point-content">
                                <h4>Character Development</h4>
                                <p>Emphasis on moral values, ethics, and character building alongside academic excellence.</p>
                            </div>
                        </div>
                        
                        <div class="point">
                            <div class="point-icon">
                                <i data-lucide="users"></i>
                            </div>
                            <div class="point-content">
                                <h4>Individual Attention</h4>
                                <p>Small class sizes ensure personalized attention to each child's unique learning needs.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="overview-image">
                    <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Primary Education">
                </div>
            </div>
        </div>
    </section>

    <!-- Curriculum -->
    <section class="curriculum-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Comprehensive Curriculum</h2>
                <p class="section-subtitle">A well-rounded education covering all essential subjects and skills</p>
            </div>
            
            <div class="curriculum-grid">
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="book"></i>
                    </div>
                    <h3>Language Arts</h3>
                    <ul>
                        <li>English Language & Literature</li>
                        <li>Reading Comprehension</li>
                        <li>Creative Writing</li>
                        <li>Vocabulary Building</li>
                        <li>Public Speaking</li>
                    </ul>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="calculator"></i>
                    </div>
                    <h3>Mathematics</h3>
                    <ul>
                        <li>Number Concepts</li>
                        <li>Basic Operations</li>
                        <li>Problem Solving</li>
                        <li>Geometry & Shapes</li>
                        <li>Mental Math</li>
                    </ul>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="flask-conical"></i>
                    </div>
                    <h3>Science</h3>
                    <ul>
                        <li>Nature Studies</li>
                        <li>Basic Physics Concepts</li>
                        <li>Life Sciences</li>
                        <li>Environmental Science</li>
                        <li>Hands-on Experiments</li>
                    </ul>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="map"></i>
                    </div>
                    <h3>Social Studies</h3>
                    <ul>
                        <li>History & Heritage</li>
                        <li>Geography</li>
                        <li>Civics</li>
                        <li>Cultural Studies</li>
                        <li>Community Awareness</li>
                    </ul>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="palette"></i>
                    </div>
                    <h3>Creative Arts</h3>
                    <ul>
                        <li>Drawing & Painting</li>
                        <li>Music & Dance</li>
                        <li>Drama & Theater</li>
                        <li>Craft Work</li>
                        <li>Creative Expression</li>
                    </ul>
                </div>
                
                <div class="curriculum-card">
                    <div class="card-icon">
                        <i data-lucide="activity"></i>
                    </div>
                    <h3>Physical Education</h3>
                    <ul>
                        <li>Sports & Games</li>
                        <li>Yoga & Meditation</li>
                        <li>Motor Skills Development</li>
                        <li>Team Building</li>
                        <li>Health & Wellness</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Approach -->
    <section class="learning-approach">
        <div class="container">
            <div class="approach-content">
                <div class="approach-text">
                    <h2>Our Learning Approach</h2>
                    <p>We follow a child-centric approach that recognizes each student as a unique individual with their own learning style, pace, and interests.</p>
                    
                    <div class="approach-features">
                        <div class="feature">
                            <h4>Activity-Based Learning</h4>
                            <p>Hands-on activities, projects, and experiments that make learning tangible and memorable.</p>
                        </div>
                        
                        <div class="feature">
                            <h4>Technology Integration</h4>
                            <p>Age-appropriate use of technology to enhance learning experiences and digital literacy.</p>
                        </div>
                        
                        <div class="feature">
                            <h4>Continuous Assessment</h4>
                            <p>Regular evaluation through various methods including observations, portfolios, and creative projects.</p>
                        </div>
                        
                        <div class="feature">
                            <h4>Parent Partnership</h4>
                            <p>Close collaboration with parents to ensure consistent support and reinforcement at home.</p>
                        </div>
                    </div>
                </div>
                
                <div class="approach-stats">
                    <div class="stat-item">
                        <div class="stat-number">15:1</div>
                        <div class="stat-label">Student-Teacher Ratio</div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-number">8</div>
                        <div class="stat-label">Specialized Classrooms</div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-number">25+</div>
                        <div class="stat-label">Co-curricular Activities</div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Parent Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities -->
    <section class="facilities-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Primary Education Facilities</h2>
                <p class="section-subtitle">State-of-the-art facilities designed specifically for young learners</p>
            </div>
            
            <div class="facilities-grid">
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1581726690015-c9861fa5057f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Smart Classrooms">
                    </div>
                    <div class="facility-content">
                        <h3>Smart Classrooms</h3>
                        <p>Interactive whiteboards, audio-visual aids, and child-friendly furniture designed for comfort and engagement.</p>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Play Area">
                    </div>
                    <div class="facility-content">
                        <h3>Indoor & Outdoor Play Areas</h3>
                        <p>Safe and stimulating play spaces with age-appropriate equipment for physical development.</p>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Library">
                    </div>
                    <div class="facility-content">
                        <h3>Children's Library</h3>
                        <p>Colorful library with picture books, story books, and interactive reading corners to foster love for reading.</p>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1530587191325-3db32d826c18?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Art Room">
                    </div>
                    <div class="facility-content">
                        <h3>Art & Craft Room</h3>
                        <p>Dedicated space for creative activities with all necessary materials and tools for artistic expression.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Give Your Child the Best Start?</h2>
                <p>Join our Primary Education program and watch your child develop into a confident, curious, and capable learner.</p>
                <div class="cta-actions">
                    <a href="../../index.php#contact" class="primary-btn">
                        <span>Apply Now</span>
                        <i data-lucide="arrow-right"></i>
                    </a>
                    <a href="../academic-programs/secondary-education.php" class="secondary-btn">
                        <span>View Secondary Education</span>
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