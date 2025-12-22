<div class="container-fluid">
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #148f77 0%, #16a085 100%); border-radius: 15px;">
                <div class="card-body py-5 text-white">
                    <h1 style="font-weight: 700; font-size: 32px; margin-bottom: 20px;">
                        <i class="fas fa-search"></i> Buscar Acuarios
                    </h1>
                    <form method="GET" action="<?php echo APP_URL; ?>/aquarium/search" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        <div>
                            <input type="text" name="q" class="form-control" placeholder="Buscar por nombre..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" style="border-radius: 8px; padding: 12px 15px; border: none;">
                        </div>
                        <div>
                            <select name="type" class="form-control" style="border-radius: 8px; padding: 12px 15px; border: none;">
                                <option value="">Todos los tipos</option>
                                <option value="agua_dulce" <?php echo (isset($_GET['type']) && $_GET['type'] === 'agua_dulce') ? 'selected' : ''; ?>>💧 Agua dulce</option>
                                <option value="agua_salada" <?php echo (isset($_GET['type']) && $_GET['type'] === 'agua_salada') ? 'selected' : ''; ?>>🌊 Agua salada</option>
                                <option value="brackish" <?php echo (isset($_GET['type']) && $_GET['type'] === 'brackish') ? 'selected' : ''; ?>>🌿 Brackish</option>
                            </select>
                        </div>
                        <div>
                            <select name="status" class="form-control" style="border-radius: 8px; padding: 12px 15px; border: none;">
                                <option value="">Todos los estados</option>
                                <option value="activo" <?php echo (isset($_GET['status']) && $_GET['status'] === 'activo') ? 'selected' : ''; ?>>Activo</option>
                                <option value="inactivo" <?php echo (isset($_GET['status']) && $_GET['status'] === 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                                <option value="en_construcción" <?php echo (isset($_GET['status']) && $_GET['status'] === 'en_construcción') ? 'selected' : ''; ?>>En construcción</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-light" style="width: 100%; border-radius: 8px; padding: 12px 15px; border: none; font-weight: 600; color: #16a085;">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($aquariums)): ?>
        <div class="row" data-aos="fade-up">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body text-center py-5">
                        <div style="font-size: 80px; opacity: 0.2; margin-bottom: 20px;">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 style="color: #666; margin-bottom: 15px;">No se encontraron acuarios</h3>
                        <p style="color: #999; font-size: 16px;">Intenta con otros términos de búsqueda o filtros</p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row" data-aos="fade-up">
            <div class="col-12">
                <p style="color: #7f8c8d; margin-bottom: 20px;">
                    <strong><?php echo count($aquariums); ?></strong> acuario(s) encontrado(s)
                </p>
            </div>
        </div>

        <div class="row">
            <?php foreach ($aquariums as $index => $aquarium): ?>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: all 0.3s;">
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
                                    <i class="fas fa-water" style="font-size: 60px; color: rgba(255,255,255,0.5);"></i>
                                </div>
                            <?php endif; ?>
                            <div style="position: absolute; top: 15px; left: 15px;">
                                <?php 
                                    $statusColor = '#27ae60';
                                    $statusIcon = 'fa-play-circle';
                                    $statusText = 'Activo';
                                    if ($aquarium['status'] == 'inactivo') { $statusColor = '#e74c3c'; $statusIcon = 'fa-pause-circle'; $statusText = 'Inactivo'; }
                                    elseif ($aquarium['status'] == 'en_construcción') { $statusColor = '#f39c12'; $statusIcon = 'fa-tools'; $statusText = 'En construcción'; }
                                ?>
                                <span style="background: <?php echo $statusColor; ?>; color: white; padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: 700; box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                                    <i class="fas <?php echo $statusIcon; ?>" style="font-size: 10px; margin-right: 5px;"></i><?php echo $statusText; ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column" style="flex-grow: 1;">
                            <h5 style="font-weight: 700; color: #2c3e50; margin-bottom: 10px;">
                                <?php echo htmlspecialchars($aquarium['name']); ?>
                            </h5>
                            <?php if (!empty($aquarium['description'])): ?>
                                <p style="color: #7f8c8d; font-size: 14px; margin-bottom: 15px; flex-grow: 1;">
                                    <?php echo htmlspecialchars(substr($aquarium['description'], 0, 100)); ?>...
                                </p>
                            <?php endif; ?>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                                <div style="background: #f8f9fa; padding: 12px; border-radius: 8px; text-align: center;">
                                    <small style="color: #7f8c8d; display: block; font-size: 11px; text-transform: uppercase;">Tipo</small>
                                    <strong style="color: #2c3e50; font-size: 13px;">
                                        <?php echo ucfirst(str_replace('_', ' ', $aquarium['type'])); ?>
                                    </strong>
                                </div>
                                <div style="background: #f8f9fa; padding: 12px; border-radius: 8px; text-align: center;">
                                    <small style="color: #7f8c8d; display: block; font-size: 11px; text-transform: uppercase;">Volumen</small>
                                    <strong style="color: #2c3e50; font-size: 13px;">
                                        <?php echo $aquarium['volume_liters']; ?>L
                                    </strong>
                                </div>
                            </div>
                            <a href="<?php echo APP_URL; ?>/aquarium/show?id=<?php echo $aquarium['id']; ?>" class="btn btn-primary" style="border-radius: 50px; width: 100%; font-weight: 600; margin-top: auto; background: linear-gradient(135deg, #148f77 0%, #16a085 100%); border: none; color: white;">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 100 });
</script>
