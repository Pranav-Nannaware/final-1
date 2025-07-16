<!-- Navigation Component for Module Pages -->
<style>
.admin-nav {
    background: linear-gradient(135deg, #667eea, #764ba2);
    padding: 1rem 0;
    margin-bottom: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.admin-nav .nav-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.admin-nav .nav-brand {
    color: white;
    text-decoration: none;
    font-size: 1.2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.admin-nav .nav-brand i {
    margin-right: 0.5rem;
}

.admin-nav .nav-brand:hover {
    color: rgba(255,255,255,0.8);
}

.admin-nav .nav-links {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.admin-nav .nav-link {
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.admin-nav .nav-link:hover {
    background: rgba(255,255,255,0.2);
    color: white;
}

.admin-nav .nav-link.active {
    background: rgba(255,255,255,0.3);
    color: white;
}

@media (max-width: 768px) {
    .admin-nav .nav-container {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .admin-nav .nav-links {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>

<nav class="admin-nav">
    <div class="nav-container">
        <a href="../index.php" class="nav-brand">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
        
        <div class="nav-links">
            <a href="../12thadm/index.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/12thadm/') !== false) ? 'active' : ''; ?>">
                <i class="fas fa-user-shield"></i> Admin
            </a>
            <a href="../recipt/index.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/recipt/') !== false) ? 'active' : ''; ?>">
                <i class="fas fa-receipt"></i> Receipts
            </a>
            <a href="../studmanage/index.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/studmanage/') !== false) ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> Students
            </a>
        </div>
    </div>
</nav>

<!-- Font Awesome if not already included -->
<script>
if (!document.querySelector('link[href*="font-awesome"]')) {
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';
    document.head.appendChild(link);
}
</script> 