<!DOCTYPE html>
<html lang="<?php echo I18n::getLang(); ?>">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="acuario, peces, wiki, acuarismo" />
    <meta name="description" content="Sistema colaborativo de gestión de acuarios y wiki de peces" />
    <meta name="author" content="" />
    
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : ''; ?><?php echo APP_NAME; ?></title>
    
    <!-- Owl Carousel -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo APP_URL; ?>/assets/css/bootstrap.css" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link href="<?php echo APP_URL; ?>/assets/css/style.css" rel="stylesheet" />
    <link href="<?php echo APP_URL; ?>/assets/css/responsive.css" rel="stylesheet" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            color: #444;
            background: #f8fbfe;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Raleway', sans-serif;
            font-weight: 700;
        }
        
        /* Header Styles - Aventro Style */
        .header_section {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            padding: 8px 0;
        }
        
        .header_section .container {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        .navbar {
            padding: 0;
        }
        
        .navbar-brand {
            font-family: 'Raleway', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #148f77 !important;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s;
        }
        
        .navbar-brand:hover {
            color: #16a085 !important;
        }
        
        .navbar-brand i {
            color: #16a085;
            margin-right: 8px;
        }
        
        .nav-link {
            font-family: 'Raleway', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #3e4450 !important;
            padding: 6px 10px !important;
            margin: 0 3px;
            transition: all 0.3s;
            position: relative;
            white-space: nowrap;
        }
        .navbar-nav { 
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: #148f77 !important;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 10px;
            right: 10px;
            height: 2px;
            background: #16a085;
            transform: scaleX(0);
            transition: transform 0.3s;
        }
        
        .nav-link:hover::before {
            transform: scaleX(1);
        }
        
        .btn-getstarted {
            background: linear-gradient(135deg, #148f77 0%, #16a085 100%);
            color: white !important;
            padding: 8px 18px;
            border-radius: 50px;
            font-weight: 600;
            margin-left: 8px;
            transition: all 0.3s;
            border: none;
            text-decoration: none;
            font-size: 14px;
            white-space: nowrap;
        }
        
        .btn-getstarted:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(20, 143, 119, 0.4);
        }
        
        @media (max-width: 768px) {
            .nav-link {
                padding: 8px 12px !important;
            }
            
            .btn-getstarted {
                margin-left: 0;
                margin-top: 10px;
            }
            
            .navbar-nav {
                gap: 0;
            }
        }
        
        .main-content {
            min-height: 60vh;
            padding: 100px 0 60px 0;
            background: #f8fbfe;
        }
        
        /* Card Styles - Modern */
        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            border: none;
            transition: all 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #3e4450;
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #eef2f6;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            background: #fafbfc;
        }
        
        .form-control:focus {
            border-color: #148f77;
            box-shadow: 0 0 0 0.2rem rgba(20, 143, 119, 0.15);
            outline: none;
            background: white;
        }

        /* Selects: altura y flecha consistentes */
        select.form-control {
            min-height: 44px;
            padding: 12px 40px 12px 15px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23148f77' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
        }
        select.form-control.form-control-lg {
            min-height: 52px;
            padding: 14px 44px 14px 18px;
            font-size: 16px;
        }
        
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }
        
        .btn {
            padding: 12px 35px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
            font-size: 15px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #148f77 0%, #16a085 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(20, 143, 119, 0.4);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        /* Footer Styles */
        footer {
            background: #1a1d2e;
            color: rgba(255, 255, 255, 0.7);
            padding: 60px 0 30px;
            font-size: 14px;
        }
        
        footer h4 {
            color: white;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        footer a:hover {
            color: #16a085;
        }
        
        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin: 0 5px;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background: #16a085;
            color: white;
        }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="header_section">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="<?php echo APP_URL; ?>">
                    <i class="fas fa-fish"></i>ACUARISMO
                </a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                        style="border: 2px solid #2E3192; padding: 5px 10px;">
                    <i class="fas fa-bars" style="color: #2E3192;"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>/fish">
                                <i class="fas fa-fish"></i> <?php echo __('nav.fish'); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>/articles">
                                <i class="fas fa-book"></i> <?php echo __('nav.articles'); ?>
                            </a>
                        </li>
                        <?php if (Session::isLogged()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="aquariumDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-water"></i> <?php echo __('nav.aquariums.mine'); ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="aquariumDropdown" style="border-radius: 8px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/aquarium">
                                    <i class="fas fa-list" style="color: #16a085;"></i> <?php echo __('nav.see_all'); ?>
                                </a>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/aquarium/dashboard">
                                    <i class="fas fa-chart-line" style="color: #3498db;"></i> <?php echo __('nav.dashboard'); ?>
                                </a>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/aquarium/search">
                                    <i class="fas fa-search" style="color: #f39c12;"></i> <?php echo __('nav.search'); ?>
                                </a>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/aquarium/gallery">
                                    <i class="fas fa-images" style="color: #9b59b6;"></i> <?php echo __('nav.gallery_public'); ?>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/aquarium/create">
                                    <i class="fas fa-plus-circle" style="color: #27ae60;"></i> <?php echo __('nav.create_new'); ?>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="terrariumDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-leaf"></i> <?php echo __('nav.terrariums.mine'); ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="terrariumDropdown" style="border-radius: 8px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/terrarium">
                                    <i class="fas fa-list" style="color: #e67e22;"></i> <?php echo __('nav.see_all'); ?>
                                </a>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/terrarium/dashboard">
                                    <i class="fas fa-chart-line" style="color: #3498db;"></i> <?php echo __('nav.dashboard'); ?>
                                </a>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/terrarium/search">
                                    <i class="fas fa-search" style="color: #f39c12;"></i> <?php echo __('nav.search'); ?>
                                </a>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/terrarium/gallery">
                                    <i class="fas fa-images" style="color: #9b59b6;"></i> <?php echo __('nav.gallery_public'); ?>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/terrarium/create">
                                    <i class="fas fa-plus-circle" style="color: #27ae60;"></i> <?php echo __('nav.create_new'); ?>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="toolsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-tools"></i> <?php echo __('nav.tools'); ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="toolsDropdown" style="border-radius: 8px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/alerts">
                                    <i class="fas fa-bell" style="color: #f39c12;"></i> <?php echo __('nav.alerts'); ?>
                                </a>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/reports">
                                    <i class="fas fa-file-export" style="color: #3498db;"></i> <?php echo __('nav.reports'); ?>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>/user/profile">
                                <i class="fas fa-user"></i> <?php echo __('nav.profile'); ?>
                            </a>
                        </li>
                        <?php if (Session::isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>/admin">
                                <i class="fas fa-cog"></i> <?php echo __('nav.admin'); ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a href="<?php echo APP_URL; ?>/auth/logout" class="btn-getstarted">
                                <i class="fas fa-sign-out-alt"></i> <?php echo __('nav.logout'); ?>
                            </a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>/auth/login">
                                <i class="fas fa-sign-in-alt"></i> <?php echo __('nav.login'); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo APP_URL; ?>/auth/register" class="btn-getstarted">
                                <i class="fas fa-user-plus"></i> <?php echo __('nav.register'); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link" style="opacity:.8">
                                <a href="<?php echo APP_URL; ?>/lang/es" style="margin-right:6px;<?php echo I18n::getLang()==='es' ? 'font-weight:700;color:#148f77!important;' : '' ?>">ES</a>
                                |
                                <a href="<?php echo APP_URL; ?>/lang/en" style="margin-left:6px;<?php echo I18n::getLang()==='en' ? 'font-weight:700;color:#148f77!important;' : '' ?>">EN</a>
                            </span>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <section class="main-content">
        <div class="container">
            <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['flash_type'] ?? 'success'; ?> alert-dismissible fade show" role="alert">
                <?php 
                echo htmlspecialchars($_SESSION['flash_message']); 
                unset($_SESSION['flash_message'], $_SESSION['flash_type']);
                ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?>
            
            <?php 
            // Incluir vista de contenido con las variables necesarias
            if (isset($contentView) && file_exists($contentView)) {
                include $contentView;
            }
            ?>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h4><i class="fas fa-fish"></i> <?php echo __('footer.about.title'); ?></h4>
                    <p><?php echo __('footer.about.text'); ?></p>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h4><?php echo __('footer.links.title'); ?></h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 10px;"><a href="<?php echo APP_URL; ?>/fish"><i class="fas fa-angle-right"></i> <?php echo __('footer.links.wiki'); ?></a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo APP_URL; ?>/aquarium"><i class="fas fa-angle-right"></i> <?php echo __('footer.links.aquarium'); ?></a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo APP_URL; ?>/user/profile"><i class="fas fa-angle-right"></i> <?php echo __('footer.links.profile'); ?></a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4><?php echo __('footer.services.title'); ?></h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 10px;"><a href="#"><i class="fas fa-angle-right"></i> <?php echo __('footer.services.create_aquarium'); ?></a></li>
                        <li style="margin-bottom: 10px;"><a href="#"><i class="fas fa-angle-right"></i> <?php echo __('footer.services.add_fish'); ?></a></li>
                        <li style="margin-bottom: 10px;"><a href="#"><i class="fas fa-angle-right"></i> <?php echo __('footer.services.report_error'); ?></a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4><?php echo __('footer.contact.title'); ?></h4>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo __('footer.contact.city'); ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo __('footer.contact.phone'); ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo __('footer.contact.email'); ?></p>
                </div>
            </div>
            
            <div class="row mt-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <div class="col-12 text-center">
                    <p><?php echo __('footer.copyright', ['year' => date('Y')]); ?></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script type="text/javascript" src="<?php echo APP_URL; ?>/assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?php echo APP_URL; ?>/assets/js/bootstrap.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html>
