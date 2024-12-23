document.addEventListener('DOMContentLoaded', function() {
    // Handle active state of sidebar links
    const links = document.querySelectorAll('.sidebar-nav a');
    
    links.forEach(link => {
        link.addEventListener('click', function() {
            links.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
}); 