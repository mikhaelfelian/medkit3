document.addEventListener('DOMContentLoaded', function() {
    // Get current page path
    const currentPath = window.location.pathname;
    const currentPage = currentPath.split('/').pop();
    
    // Get all sidebar links
    const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
    
    // Remove any existing active classes
    sidebarLinks.forEach(link => {
        link.classList.remove('active');
        
        // Check if this link matches current page
        const linkPath = link.getAttribute('href');
        const linkPage = linkPath.split('/').pop();
        
        if (currentPage === linkPage || 
            (currentPage === '' && linkPath.includes('index.html'))) {
            link.classList.add('active');
        }
    });

    // Initialize code highlighting
    if (typeof Prism !== 'undefined') {
        Prism.highlightAll();
    }
}); 