<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); border-radius: 15px;">
                <div class="card-body py-5 text-white text-center">
                    <h1 style="font-weight: 700; font-size: 36px; margin-bottom: 10px;">
                        <i class="fas fa-images"></i> Galería Pública
                    </h1>
                    <p style="font-size: 16px; opacity: 0.9; margin-bottom: 0;">Fotos compartidas por la comunidad de acuaristas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <?php if (empty($galleries)): ?>
        <div class="row" data-aos="fade-up">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body text-center py-5">
                        <div style="font-size: 100px; opacity: 0.2; margin-bottom: 20px;">
                            <i class="fas fa-image"></i>
                        </div>
                        <h3 style="color: #666; margin-bottom: 15px;">No hay fotos en la galería</h3>
                        <p style="color: #999; font-size: 16px;">
                            Sé el primero en compartir fotos de tu terrario
                        </p>
                        <?php if (Session::isLogged()): ?>
                            <a href="<?php echo APP_URL; ?>/terrarium" class="btn btn-primary" style="border-radius: 50px; padding: 12px 30px; background: linear-gradient(135deg, #d35400 0%, #e67e22 100%); border: none; color: white; font-weight: 600; text-decoration: none; display: inline-block; margin-top: 15px;">
                                <i class="fas fa-arrow-right"></i> Ir a Mis Terrarios
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row" data-aos="fade-up">
            <div class="col-12 mb-3">
                <p style="color: #7f8c8d; font-size: 14px;">
                    <i class="fas fa-info-circle"></i> Mostrando <strong><?php echo count($galleries); ?></strong> foto(s)
                </p>
            </div>
        </div>

        <div class="row">
            <?php foreach ($galleries as $index => $photo): ?>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s; cursor: pointer;">
                        <div style="position: relative; overflow: hidden; height: 280px;">
                            <img src="<?php echo APP_URL; ?>/uploads/gallery/<?php echo htmlspecialchars($photo['image_path']); ?>" 
                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;"
                                 onmouseover="this.style.transform='scale(1.05)'"
                                 onmouseout="this.style.transform='scale(1)'"
                                 alt="<?php echo htmlspecialchars($photo['title'] ?? 'Foto'); ?>">
                            
                            <!-- Info Overlay -->
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.8) 100%); color: white; padding: 20px; transition: opacity 0.3s;">
                                <h6 style="margin: 0 0 5px 0; font-weight: 700;">
                                    <?php echo htmlspecialchars($photo['terrarium_name']); ?>
                                </h6>
                                <small style="opacity: 0.9;">
                                    Por: <strong><?php echo htmlspecialchars($photo['username']); ?></strong>
                                </small>
                            </div>
                        </div>
                        
                        <!-- Card Info -->
                        <div style="background: white; padding: 15px;">
                            <?php if (!empty($photo['title'])): ?>
                                <h6 style="margin: 0 0 8px 0; font-weight: 700; color: #2c3e50;">
                                    <?php echo htmlspecialchars($photo['title']); ?>
                                </h6>
                            <?php endif; ?>
                            
                            <?php if (!empty($photo['description'])): ?>
                                <p style="margin: 0 0 10px 0; color: #7f8c8d; font-size: 13px;">
                                    <?php echo htmlspecialchars(substr($photo['description'], 0, 80)); ?>...
                                </p>
                            <?php endif; ?>
                            
                            <small style="color: #95a5a6; display: block;">
                                <i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($photo['created_at'])); ?>
                            </small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="row mt-4" data-aos="fade-up">
            <div class="col-12" style="text-align: center;">
                <nav aria-label="Page navigation">
                    <ul style="display: inline-block; list-style: none; padding: 0;">
                        <?php if ((isset($_GET['page']) ? (int)$_GET['page'] : 1) > 1): ?>
                            <li style="display: inline-block; margin: 0 5px;">
                                <a href="<?php echo APP_URL; ?>/terrarium/gallery?page=<?php echo ((isset($_GET['page']) ? (int)$_GET['page'] : 1) - 1); ?>" 
                                   style="padding: 10px 15px; border-radius: 5px; background: #f0f0f0; text-decoration: none; color: #2c3e50; font-weight: 600;">
                                    <i class="fas fa-chevron-left"></i> Anterior
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <li style="display: inline-block; margin: 0 5px;">
                            <a href="<?php echo APP_URL; ?>/terrarium/gallery?page=<?php echo ((isset($_GET['page']) ? (int)$_GET['page'] : 1) + 1); ?>" 
                               style="padding: 10px 15px; border-radius: 5px; background: linear-gradient(135deg, #d35400 0%, #e67e22 100%); text-decoration: none; color: white; font-weight: 600;">
                                Siguiente <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Estilos AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
</script>
