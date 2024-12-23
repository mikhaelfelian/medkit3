<?php
$title = 'HMVC Framework Documentation';
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Documentation</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="documentation-wrapper">
                <!-- Sidebar -->
                <div class="doc-sidebar">
                    <div class="sidebar-content">
                        <h3>Contents</h3>
                        <ul class="doc-nav">
                            <li><a href="#getting-started" class="nav-link">Getting Started</a></li>
                            <li><a href="#structure" class="nav-link">Directory Structure</a></li>
                            <li><a href="#mvc" class="nav-link">MVC Pattern</a></li>
                            <li><a href="#migrations" class="nav-link">Database Migrations</a></li>
                            <li><a href="#forms" class="nav-link">Form Handling</a></li>
                            <li><a href="#routing" class="nav-link">Routing</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="doc-content">
                    <section id="getting-started" class="doc-section">
                        <h2>Getting Started</h2>
                        <div class="content">
                            <h3>Installation</h3>
                            <pre><code>git clone [repository-url]
cd project-directory
composer install</code></pre>

                            <h3>Configuration</h3>
                            <p>Configure your database in config/config.php:</p>
                            <pre><code>$db_config = [
    'development' => [
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'your_database'
    ]
];</code></pre>
                        </div>
                    </section>

                    <!-- Other sections remain the same, just wrapped in doc-section -->
                    <!-- ... -->
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->push('styles') ?>
<style>
/* Documentation Layout */
.documentation-wrapper {
    display: flex;
    gap: 2rem;
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
}

/* Sidebar Styles */
.doc-sidebar {
    width: 250px;
    flex-shrink: 0;
}

.sidebar-content {
    position: sticky;
    top: 20px;
    background: #fff;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.doc-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.doc-nav li {
    margin-bottom: 0.5rem;
}

.doc-nav .nav-link {
    display: block;
    padding: 0.5rem 1rem;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.doc-nav .nav-link:hover,
.doc-nav .nav-link.active {
    background: #f0f0f0;
    color: #007bff;
}

/* Main Content Styles */
.doc-content {
    flex: 1;
    min-width: 0; /* Prevents flex item from overflowing */
}

.doc-section {
    background: #fff;
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.doc-section h2 {
    margin-top: 0;
    padding-bottom: 1rem;
    border-bottom: 2px solid #eee;
}

/* Code Blocks */
pre {
    background: #f8f8f8;
    padding: 1rem;
    border-radius: 4px;
    overflow-x: auto;
    margin: 1rem 0;
}

code {
    font-family: 'Courier New', Courier, monospace;
    font-size: 14px;
    line-height: 1.5;
}

/* Responsive Design */
@media (max-width: 768px) {
    .documentation-wrapper {
        flex-direction: column;
    }

    .doc-sidebar {
        width: 100%;
    }

    .sidebar-content {
        position: relative;
        top: 0;
        margin-bottom: 1rem;
    }

    .doc-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .doc-nav li {
        margin: 0;
    }

    .doc-section {
        padding: 1rem;
    }
}

/* Typography */
h2 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
}

h3 {
    color: #34495e;
    margin: 1.5rem 0 1rem;
}

p {
    line-height: 1.6;
    color: #444;
}

/* Utilities */
.content {
    margin-bottom: 2rem;
}
</style>
<?php $this->end() ?>

<?php $this->push('scripts') ?>
<script>
$(document).ready(function() {
    // Smooth scrolling
    $('.nav-link').on('click', function(e) {
        e.preventDefault();
        const target = $($(this).attr('href'));
        $('html, body').animate({
            scrollTop: target.offset().top - 20
        }, 500);
    });

    // Active section highlighting
    $(window).on('scroll', function() {
        const scrollPosition = $(window).scrollTop();

        $('.doc-section').each(function() {
            const top = $(this).offset().top - 100;
            const bottom = top + $(this).outerHeight();

            if (scrollPosition >= top && scrollPosition <= bottom) {
                const id = $(this).attr('id');
                $('.nav-link').removeClass('active');
                $(`.nav-link[href="#${id}"]`).addClass('active');
            }
        });
    });
});
</script>
<?php $this->end() ?> 