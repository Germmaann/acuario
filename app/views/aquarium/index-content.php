<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #148f77 0%, #16a085 100%); border-radius: 15px;">
                <div class="card-body text-center py-5 text-white">
                    <h1 style="font-weight: 700; font-size: 36px; margin-bottom: 10px;">
                        <i class="fas fa-fish"></i> <?php echo __('aquarium.index.title'); ?>
                    </h1>
                    <p style="font-size: 18px; opacity: 0.9; margin-bottom: 20px;"><?php echo __('aquarium.index.subtitle'); ?></p>
                    <a href="<?php echo APP_URL; ?>/aquarium/create" class="btn btn-light btn-lg" style="padding: 12px 35px; border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                        <i class="fas fa-plus-circle"></i> <?php echo __('aquarium.index.create_new'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($aquariums)): ?>
        <!-- Empty State -->
        <div class="row" data-aos="fade-up">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body text-center py-5">
                        <div style="font-size: 100px; opacity: 0.2; margin-bottom: 20px;">
                            <i class="fas fa-fish"></i>
                        </div>
                        <h3 style="color: #666; margin-bottom: 15px;"><?php echo __('aquarium.index.empty'); ?></h3>
                        <p style="color: #999; font-size: 16px; margin-bottom: 30px;">
                            <?php echo __('aquarium.index.empty_sub'); ?>
                        </p>
                        <a href="<?php echo APP_URL; ?>/aquarium/create" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus-circle"></i> <?php echo __('aquarium.index.create_first'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Aquarium Grid -->
        <div class="row">
            <?php foreach ($aquariums as $index => $aquarium): ?>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: all 0.3s;">
                        
                        <!-- Image Section -->
                        <div style="position: relative; overflow: hidden;">
                            <?php if ($aquarium['main_image']): ?>
                                <a href="<?php echo APP_URL; ?>/aquarium/show?id=<?php echo $aquarium['id']; ?>">
                                    <img src="<?php echo APP_URL; ?>/uploads/gallery/<?php echo htmlspecialchars($aquarium['main_image']); ?>" 
                                         style="width: 100%; height: 220px; object-fit: cover; transition: transform 0.3s;"
                                         onmouseover="this.style.transform='scale(1.1)'"
                                         onmouseout="this.style.transform='scale(1)'">
                                </a>
                            <?php else: ?>
                                <div style="width: 100%; height: 220px; background: linear-gradient(135deg, #148f77 0%, #16a085 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-fish" style="font-size: 60px; color: rgba(255,255,255,0.5);"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Status Badge -->
                            <div style="position: absolute; top: 15px; left: 15px;">
                                <?php 
                                    $statusColor = '#16a085';
                                    $statusIcon = 'fa-play-circle';
                                    $statusText = __('aquarium.status.active');
                                    
                                    if ($aquarium['status'] == 'inactivo') {
                                        $statusColor = '#e74c3c';
                                        $statusIcon = 'fa-pause-circle';
                                        $statusText = __('aquarium.status.inactive');
                                    } elseif ($aquarium['status'] == 'en_construcción') {
                                        $statusColor = '#f39c12';
                                        $statusIcon = 'fa-tools';
                                        $statusText = __('aquarium.status.under_construction');
                                    }
                                ?>
                                <span style="background: <?php echo $statusColor; ?>; 
                                             color: white; 
                                             padding: 6px 15px; 
                                             border-radius: 20px; 
                                             font-size: 12px; 
                                             font-weight: 700;
                                             box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                                    <i class="fas <?php echo $statusIcon; ?>" style="font-size: 10px; margin-right: 5px;"></i><?php echo $statusText; ?>
                                </span>
                            </div>
                            
                            <!-- Delete Button -->
                            <div style="position: absolute; top: 15px; right: 15px;">
                                <form method="POST" action="<?php echo APP_URL; ?>/aquarium/delete" style="display: inline;">
                                    <input type="hidden" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">
                                    <input type="hidden" name="aquarium_id" value="<?php echo $aquarium['id']; ?>">
                                    <button type="submit" 
                                            style="background: rgba(231, 76, 60, 0.9); 
                                                   color: white; 
                                                   border: none; 
                                                   width: 35px;
                                                   height: 35px;
                                                   border-radius: 50%; 
                                                   cursor: pointer; 
                                                   font-size: 14px;
                                                   transition: all 0.3s;
                                                   box-shadow: 0 2px 10px rgba(0,0,0,0.2);"
                                            title="Eliminar acuario"
                                            onmouseover="this.style.background='rgba(192, 57, 43, 1)'; this.style.transform='scale(1.1)'"
                                            onmouseout="this.style.background='rgba(231, 76, 60, 0.9)'; this.style.transform='scale(1)'"
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este acuario?\n\nSe eliminarán todos sus peces, plantas y fotos.');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Content Section -->
                        <div class="card-body" style="padding: 20px;">
                            <a href="<?php echo APP_URL; ?>/aquarium/show?id=<?php echo $aquarium['id']; ?>" style="text-decoration: none; color: inherit;">
                                <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 15px; font-size: 20px;">
                                    <?php echo htmlspecialchars($aquarium['name']); ?>
                                </h4>
                            </a>
                            
                            <!-- Info Cards -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div style="background: #f8f9fa; padding: 12px; border-radius: 10px; text-align: center;">
                                        <div style="font-size: 24px; color: #16a085; margin-bottom: 5px;">
                                            <i class="fas fa-water"></i>
                                        </div>
                                        <div style="font-weight: 700; font-size: 18px; color: #2c3e50;">
                                            <?php echo $aquarium['volume_liters']; ?>L
                                        </div>
                                        <div style="font-size: 11px; color: #7f8c8d; text-transform: uppercase;"><?php echo __('aquarium.index.volume'); ?></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="background: #f8f9fa; padding: 12px; border-radius: 10px; text-align: center;">
                                        <div style="font-size: 24px; color: #16a085; margin-bottom: 5px;">
                                            <i class="fas fa-layer-group"></i>
                                        </div>
                                        <div style="font-weight: 700; font-size: 14px; color: #2c3e50;">
                                            <?php echo ucfirst(str_replace('_', ' ', $aquarium['type'])); ?>
                                        </div>
                                        <div style="font-size: 11px; color: #7f8c8d; text-transform: uppercase;"><?php echo __('aquarium.index.type'); ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Metadata -->
                            <div style="border-top: 1px solid #ecf0f1; padding-top: 15px; margin-top: 15px;">
                                <small style="color: #95a5a6; display: flex; align-items: center; gap: 5px;">
                                    <i class="far fa-calendar-alt"></i> 
                                    <?php echo __('aquarium.index.created_on'); ?> <?php echo date('d/m/Y', strtotime($aquarium['created_at'])); ?>
                                </small>
                            </div>
                            
                            <!-- Action Button -->
                            <a href="<?php echo APP_URL; ?>/aquarium/show?id=<?php echo $aquarium['id']; ?>" 
                               class="btn btn-primary btn-block mt-3" 
                               style="border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-eye"></i> <?php echo __('aquarium.index.view_details'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Stats Summary -->
        <div class="row mt-4" data-aos="fade-up">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; background: #f8f9fa;">
                    <div class="card-body text-center py-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div style="font-size: 32px; font-weight: 700; color: #16a085;">
                                    <?php echo count($aquariums); ?>
                                </div>
                                <div style="color: #7f8c8d; font-size: 14px;"><?php echo __('aquarium.index.total_aquariums'); ?></div>
                            </div>
                            <div class="col-md-4">
                                <div style="font-size: 32px; font-weight: 700; color: #16a085;">
                                    <?php echo count(array_filter($aquariums, fn($a) => $a['status'] == 'activo')); ?>
                                </div>
                                <div style="color: #7f8c8d; font-size: 14px;"><?php echo __('aquarium.index.active'); ?></div>
                            </div>
                            <div class="col-md-4">
                                <div style="font-size: 32px; font-weight: 700; color: #16a085;">
                                    <?php echo array_sum(array_column($aquariums, 'volume_liters')); ?>L
                                </div>
                                <div style="color: #7f8c8d; font-size: 14px;"><?php echo __('aquarium.index.total_volume'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
    }
</style>

