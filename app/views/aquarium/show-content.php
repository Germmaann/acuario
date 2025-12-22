<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #148f77 0%, #16a085 100%); border-radius: 15px;">
                <div class="card-body py-4 text-white">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h1 style="font-weight: 700; font-size: 32px; margin-bottom: 5px;">
                                <i class="fas fa-water"></i> <?php echo htmlspecialchars($aquarium['name']); ?>
                                <?php if ($aquarium['status'] === 'inactivo'): ?>
                                    <span style="font-size: 18px; opacity: 0.9; margin-left: 10px;">
                                        <i class="fas fa-pause-circle"></i> (Inactivo)
                                    </span>
                                <?php endif; ?>
                            </h1>
                            <p style="opacity: 0.9; margin: 0;">
                                <i class="fas fa-calendar-alt"></i> Creado el <?php echo date('d/m/Y', strtotime($aquarium['created_at'])); ?>
                            </p>
                        </div>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: flex-end;">
                            <?php if (!isset($isPublicView)): ?>
                            <button class="btn btn-light" id="toggleStatusBtn" style="border-radius: 50px; font-weight: 600;" onclick="toggleAquariumStatus(<?php echo $aquarium['id']; ?>)">
                                <?php if ($aquarium['status'] === 'activo'): ?>
                                    <i class="fas fa-pause-circle"></i> Desactivar
                                <?php else: ?>
                                    <i class="fas fa-play-circle"></i> Activar
                                <?php endif; ?>
                            </button>
                            <?php endif; ?>
                            <a href="<?php echo APP_URL; ?>/aquarium" class="btn btn-light" style="border-radius: 50px; font-weight: 600;">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards Row -->
    <div class="row mb-4" data-aos="fade-up">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body text-center">
                    <div style="font-size: 40px; color: #16a085; margin-bottom: 10px;">
                        <i class="fas fa-water"></i>
                    </div>
                    <h3 style="font-size: 28px; font-weight: 700; color: #2c3e50; margin-bottom: 5px;">
                        <?php echo $aquarium['volume_liters']; ?>L
                    </h3>
                    <p style="color: #7f8c8d; margin: 0; font-size: 13px; text-transform: uppercase;">Volumen</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body text-center">
                    <div style="font-size: 40px; color: #16a085; margin-bottom: 10px;">
                        <i class="fas fa-cube"></i>
                    </div>
                    <h5 style="font-weight: 700; color: #2c3e50; margin-bottom: 5px;">
                        <?php echo $aquarium['dimensions_length']; ?> × <?php echo $aquarium['dimensions_width']; ?> × <?php echo $aquarium['dimensions_height']; ?>
                    </h5>
                    <p style="color: #7f8c8d; margin: 0; font-size: 13px; text-transform: uppercase;">Dimensiones (cm)</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body text-center">
                    <div style="font-size: 40px; color: #16a085; margin-bottom: 10px;">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h5 style="font-weight: 700; color: #2c3e50; margin-bottom: 5px;">
                        <?php echo ucfirst(str_replace('_', ' ', $aquarium['type'])); ?>
                    </h5>
                    <p style="color: #7f8c8d; margin: 0; font-size: 13px; text-transform: uppercase;">Tipo de Acuario</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body text-center">
                    <div style="font-size: 40px; color: #16a085; margin-bottom: 10px;">
                        <i class="fas fa-circle" style="font-size: 20px;"></i>
                    </div>
                    <h5 style="font-weight: 700; color: #2c3e50; margin-bottom: 5px; text-transform: capitalize;">
                        <?php echo ucfirst($aquarium['status']); ?>
                    </h5>
                    <p style="color: #7f8c8d; margin: 0; font-size: 13px; text-transform: uppercase;">Estado</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment & Config -->
    <div class="row mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 20px;">
                        <i class="fas fa-cogs"></i> Equipamiento y Configuración
                    </h4>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 10px;">
                                <i class="fas fa-filter" style="color: #16a085; font-size: 24px; margin-bottom: 8px;"></i>
                                <h6 style="color: #7f8c8d; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Filtro</h6>
                                <strong style="color: #2c3e50;"><?php echo htmlspecialchars($aquarium['filter_type'] ?? 'No especificado'); ?></strong>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 10px;">
                                <i class="fas fa-lightbulb" style="color: #f39c12; font-size: 24px; margin-bottom: 8px;"></i>
                                <h6 style="color: #7f8c8d; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Horas de Luz</h6>
                                <strong style="color: #2c3e50;"><?php echo $aquarium['lighting_hours']; ?> horas/día</strong>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 10px;">
                                <i class="fas fa-wind" style="color: #3498db; font-size: 24px; margin-bottom: 8px;"></i>
                                <h6 style="color: #7f8c8d; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Inyección CO2</h6>
                                <strong style="color: #2c3e50;"><?php echo $aquarium['co2_injection'] ? '✓ Sí' : '✗ No'; ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="row mb-4" data-aos="fade-up" data-aos-delay="200">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 style="font-weight: 700; color: #2c3e50; margin: 0;">
                            <i class="fas fa-images"></i> Galería de Fotos
                        </h4>
                        <?php if (!isset($isPublicView) && $aquarium['user_id'] == Session::getUserId()): ?>
                        <button class="btn btn-primary" data-toggle="collapse" data-target="#uploadForm" style="border-radius: 50px;">
                            <i class="fas fa-camera"></i> Subir Foto
                        </button>
                        <?php endif; ?>
                    </div>

                    <?php if (!isset($isPublicView) && $aquarium['user_id'] == Session::getUserId()): ?>
                    <div class="collapse mb-3" id="uploadForm">
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
                            <form method="POST" action="<?php echo APP_URL; ?>/aquarium/upload-photo" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <input type="hidden" name="aquarium_id" value="<?php echo $aquarium['id']; ?>">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">Foto:</label>
                                        <input type="file" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" required class="form-control">
                                        <small style="color: #666; display: block; margin-top: 5px;">JPG, PNG, WebP, GIF</small>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">Título (opcional):</label>
                                        <input type="text" name="title" placeholder="Ej. Vista frontal" class="form-control">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">Descripción:</label>
                                        <input type="text" name="description" placeholder="Notas breves" class="form-control">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Subir foto
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (empty($gallery)): ?>
                        <div class="text-center py-5" style="color: #95a5a6;">
                            <i class="far fa-images" style="font-size: 60px; opacity: 0.3;"></i>
                            <p style="margin-top: 15px;">Aún no hay fotos del acuario.</p>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($gallery as $photo): ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; position: relative;">
                                        <img src="<?php echo APP_URL; ?>/uploads/gallery/<?php echo htmlspecialchars($photo['image_path']); ?>" 
                                             style="width: 100%; height: 180px; object-fit: cover;"
                                             alt="<?php echo htmlspecialchars($photo['title'] ?? ''); ?>">
                                        <?php if (!isset($isPublicView) && $aquarium['user_id'] == Session::getUserId()): ?>
                                        <form method="POST" action="<?php echo APP_URL; ?>/aquarium/delete-photo" style="position: absolute; top: 10px; right: 10px;">
                                            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                            <input type="hidden" name="photo_id" value="<?php echo $photo['id']; ?>">
                                            <input type="hidden" name="aquarium_id" value="<?php echo $aquarium['id']; ?>">
                                            <button type="submit" 
                                                    style="background: rgba(231, 76, 60, 0.9); color: white; border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 14px;"
                                                    onclick="return confirm('¿Eliminar esta foto?');">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                        <?php if (!empty($photo['title']) || !empty($photo['description'])): ?>
                                        <div class="card-body" style="padding: 12px;">
                                            <?php if (!empty($photo['title'])): ?>
                                                <h6 style="font-weight: 600; margin-bottom: 5px;"><?php echo htmlspecialchars($photo['title']); ?></h6>
                                            <?php endif; ?>
                                            <?php if (!empty($photo['description'])): ?>
                                                <small style="color: #7f8c8d;"><?php echo htmlspecialchars($photo['description']); ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Fishes Section -->

    <!-- Fishes Section -->
    <div class="row mb-4" data-aos="fade-up" data-aos-delay="300">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 style="font-weight: 700; color: #2c3e50; margin: 0;">
                            <i class="fas fa-fish"></i> Peces del Acuario
                        </h4>
                        <?php if (!isset($isPublicView)): ?>
                        <button class="btn btn-primary" data-toggle="collapse" data-target="#addFishForm" style="border-radius: 50px;">
                            <i class="fas fa-plus-circle"></i> Agregar Pez
                        </button>
                        <?php endif; ?>
                    </div>

                    <?php if (!isset($isPublicView)): ?>
                    <div class="collapse mb-3" id="addFishForm" style="overflow: visible;">
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; overflow: visible;">
                            <form method="POST" action="<?php echo APP_URL; ?>/aquarium/add-fish" style="overflow: visible;">
                                <input type="hidden" name="aquarium_id" value="<?php echo $aquarium['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <div class="row">
                                    <div class="col-12 col-lg-6 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">Seleccionar de la Wiki:</label>
                                        <select name="fish_id" class="form-control">
                                            <option value="">-- Opcional --</option>
                                            <?php foreach ($availableFishes as $fish): ?>
                                                <option value="<?php echo $fish['id']; ?>">
                                                    <?php echo htmlspecialchars($fish['common_name']); ?> 
                                                    (<?php echo htmlspecialchars($fish['scientific_name']); ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small style="color: #666; display: block; margin-top: 5px;">O usa un pez personalizado</small>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">Nombre personalizado:</label>
                                        <input type="text" name="custom_common_name" placeholder="Ej. Pez Globo" class="form-control">
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-2 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">Cantidad:</label>
                                        <input type="number" name="quantity" value="1" min="1" required class="form-control">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">Nombre científico (opcional):</label>
                                        <input type="text" name="custom_scientific_name" placeholder="Ej. Tetraodon" class="form-control">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Agregar
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (empty($fishes)): ?>
                        <div class="text-center py-5" style="color: #95a5a6;">
                            <i class="fas fa-fish" style="font-size: 60px; opacity: 0.3;"></i>
                            <p style="margin-top: 15px;">Sin peces aún. ¡Agrega el primero!</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover" style="margin: 0;">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 15px; border: none;">
                                            <i class="fas fa-fish"></i> Especie
                                        </th>
                                        <th style="padding: 15px; text-align: center; border: none;">
                                            <i class="fas fa-sort-numeric-up"></i> Cantidad
                                        </th>
                                        <th style="padding: 15px; text-align: center; border: none;">
                                            <i class="fas fa-link"></i> Ficha
                                        </th>
                                        <th style="padding: 15px; text-align: center; border: none;">
                                            <i class="fas fa-cog"></i> Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($fishes as $fish): ?>
                                        <tr>
                                            <td style="padding: 15px; vertical-align: middle;">
                                                <strong><?php echo htmlspecialchars($fish['common_name']); ?></strong>
                                            </td>
                                            <td style="padding: 15px; text-align: center; vertical-align: middle;">
                                                <span style="background: #16a085; color: white; padding: 5px 15px; border-radius: 20px; font-weight: 600;">
                                                    <?php echo $fish['quantity']; ?>
                                                </span>
                                            </td>
                                            <td style="padding: 15px; text-align: center; vertical-align: middle;">
                                                <a href="<?php echo APP_URL; ?>/fish/show?id=<?php echo $fish['fish_id']; ?>" class="btn btn-sm btn-primary" style="border-radius: 50px;">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                            </td>
                                            <td style="padding: 15px; text-align: center; vertical-align: middle;">
                                                <button class="btn btn-sm btn-secondary" style="border-radius: 50px;">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                                <?php 
                                                    $canEditFish = Session::isAdmin() || (Session::isLogged() && Session::getUserId() == ($fish['author_id'] ?? 0));
                                                    $incomplete = empty($fish['description']) || empty($fish['main_image']);
                                                ?>
                                                <?php if ($canEditFish && $incomplete): ?>
                                                    <a class="btn btn-sm btn-warning" style="border-radius: 50px; margin-left: 5px;" href="<?php echo APP_URL; ?>/fish/edit?id=<?php echo $fish['fish_id']; ?>">
                                                        <i class="fas fa-edit"></i> Completar
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Plants Section -->
    <div class="row mb-4" data-aos="fade-up" data-aos-delay="400">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 style="font-weight: 700; color: #2c3e50; margin: 0;">
                            <i class="fas fa-leaf"></i> Plantas
                        </h4>
                        <?php if (!isset($isPublicView)): ?>
                        <button class="btn btn-primary" data-toggle="collapse" data-target="#addPlantForm" style="border-radius: 50px;">
                            <i class="fas fa-plus-circle"></i> Agregar Planta
                        </button>
                        <?php endif; ?>
                    </div>

                    <?php if (!isset($isPublicView)): ?>
                    <div class="collapse mb-3" id="addPlantForm" style="overflow: visible;">
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; overflow: visible;">
                            <form method="POST" action="<?php echo APP_URL; ?>/aquarium/add-plant" style="overflow: visible;">
                                <input type="hidden" name="aquarium_id" value="<?php echo $aquarium['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">Nombre:</label>
                                        <input type="text" name="name" required class="form-control" placeholder="Ej. Anubias nana">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">Nivel de Cuidado:</label>
                                        <select name="care_level" required class="form-control">
                                            <option value="facil">Fácil</option>
                                            <option value="medio">Medio</option>
                                            <option value="dificil">Difícil</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">Cantidad:</label>
                                        <input type="number" name="quantity" value="1" min="1" required class="form-control">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Agregar
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (empty($plants)): ?>
                        <div class="text-center py-5" style="color: #95a5a6;">
                            <i class="fas fa-leaf" style="font-size: 60px; opacity: 0.3;"></i>
                            <p style="margin-top: 15px;">Sin plantas aún.</p>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($plants as $plant): ?>
                                <div class="col-md-6 mb-3">
                                    <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; border-left: 4px solid #16a085;">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 style="font-weight: 700; color: #2c3e50; margin-bottom: 5px;">
                                                    <i class="fas fa-seedling" style="color: #16a085;"></i> 
                                                    <?php echo htmlspecialchars($plant['name']); ?>
                                                </h6>
                                                <small style="color: #7f8c8d;">
                                                    Cuidado: <strong><?php echo ucfirst($plant['care_level']); ?></strong> • 
                                                    Cantidad: <strong><?php echo $plant['quantity']; ?></strong>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Log Section -->
    <div class="row mb-4" data-aos="fade-up" data-aos-delay="500">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 style="font-weight: 700; color: #2c3e50; margin: 0;">
                            <i class="fas fa-tools"></i> Bitácora de Mantenimiento
                        </h4>
                        <?php if (!isset($isPublicView)): ?>
                        <button class="btn btn-primary" data-toggle="collapse" data-target="#addMaintenanceForm" style="border-radius: 50px;">
                            <i class="fas fa-plus-circle"></i> Nuevo Registro
                        </button>
                        <?php endif; ?>
                    </div>

                    <?php if (!isset($isPublicView)): ?>
                    <div class="collapse mb-3" id="addMaintenanceForm" style="overflow: visible;">
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; overflow: visible;">
                            <form method="POST" action="<?php echo APP_URL; ?>/aquarium/log-maintenance" style="overflow: visible;">
                                <input type="hidden" name="aquarium_id" value="<?php echo $aquarium['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">
                                            <i class="fas fa-tag"></i> Tipo de Mantenimiento:
                                        </label>
                                        <select name="log_type" required class="form-control">
                                            <option value="">Seleccione...</option>
                                            <option value="cambio_agua">🚰 Cambio de agua</option>
                                            <option value="limpieza_filtro">🧹 Limpieza de filtro</option>
                                            <option value="poda_plantas">✂️ Poda de plantas</option>
                                            <option value="analisis_agua">🧪 Análisis de agua</option>
                                            <option value="otro">📝 Otro</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">
                                            <i class="fas fa-align-left"></i> Descripción:
                                        </label>
                                        <textarea name="description" class="form-control" rows="3" placeholder="Detalles del mantenimiento realizado..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" id="reminderCheckbox" name="reminder_enabled" value="1" onchange="document.getElementById('reminderFields').style.display = this.checked ? 'block' : 'none'">
                                            <label class="custom-control-label" for="reminderCheckbox" style="font-weight: 600;">
                                                <i class="fas fa-bell"></i> Programar recordatorio por correo
                                            </label>
                                        </div>
                                        <div id="reminderFields" style="display: none; padding-left: 30px; margin-top: 15px; overflow: visible;">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label style="font-weight: 600; margin-bottom: 8px; display: block;">Frecuencia:</label>
                                                    <select name="reminder_days" class="form-control">
                                                        <option value="0">Selecciona frecuencia</option>
                                                        <option value="7">Cada 7 días</option>
                                                        <option value="14">Cada 14 días</option>
                                                        <option value="30">Cada 30 días</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label style="font-weight: 600; margin-bottom: 8px; display: block;">Personalizado (días):</label>
                                                    <input type="number" name="reminder_days_custom" min="1" max="365" placeholder="Ej. 45" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Registrar Mantenimiento
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (empty($maintenanceLogs)): ?>
                        <div class="text-center py-5" style="color: #95a5a6;">
                            <i class="fas fa-clipboard-list" style="font-size: 60px; opacity: 0.3;"></i>
                            <p style="margin-top: 15px;">Sin registros de mantenimiento aún.</p>
                        </div>
                    <?php else: ?>
                        <div style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
                            <?php foreach ($maintenanceLogs as $log): ?>
                                <div class="mb-3" style="position: relative; padding-left: 30px; border-left: 3px solid #16a085;">
                                    <div style="position: absolute; left: -8px; top: 5px; width: 13px; height: 13px; border-radius: 50%; background: #16a085;"></div>
                                    <div style="background: #f8f9fa; padding: 15px; border-radius: 10px;">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 style="font-weight: 700; color: #2c3e50; margin: 0;">
                                                <?php echo ucfirst(str_replace('_', ' ', $log['log_type'])); ?>
                                            </h6>
                                            <small style="color: #7f8c8d;">
                                                <i class="fas fa-calendar"></i> 
                                                <?php echo date('d/m/Y', strtotime($log['created_at'])); ?>
                                            </small>
                                        </div>
                                        <?php if (!empty($log['description'])): ?>
                                        <p style="margin: 0; color: #666; font-size: 14px;">
                                            <?php echo nl2br(htmlspecialchars($log['description'])); ?>
                                        </p>
                                        <?php endif; ?>
                                        <?php if (!empty($log['reminder_days'])): ?>
                                            <div style="margin-top: 10px; padding: 8px 12px; background: #fff3cd; border-left: 3px solid #ffc107; border-radius: 5px;">
                                                <small style="color: #856404;">
                                                    <i class="fas fa-bell"></i> 
                                                    Recordatorio cada <?php echo $log['reminder_days']; ?> días
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
</script>

<style>
.btn-primary {
    background: linear-gradient(135deg, #148f77 0%, #16a085 100%);
    border: none;
    color: white;
    padding: 10px 25px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(20, 143, 119, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(20, 143, 119, 0.4);
}

.btn-secondary {
    background: #e74c3c;
    border: none;
    color: white;
    padding: 8px 20px;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #c0392b;
    transform: translateY(-2px);
}

.btn-warning {
    background: #f39c12;
    border: none;
    color: white;
    padding: 8px 20px;
}

.btn-warning:hover {
    background: #e67e22;
}

.form-control {
    border-radius: 8px;
    border: 2px solid #eef2f6;
    background: white;
    padding: 12px 15px;
    transition: all 0.3s ease;
    height: auto;
    min-height: 44px;
    font-size: 15px;
}

.form-control:focus {
    border-color: #148f77;
    box-shadow: 0 0 0 0.2rem rgba(20, 143, 119, 0.25);
    background: white;
}

select.form-control {
    padding: 12px 15px;
    height: auto;
    min-height: 44px;
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23148f77' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 20px;
    padding-right: 40px;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    transition: background-color 0.3s ease;
}

.custom-control-input:checked~.custom-control-label::before {
    background-color: #16a085;
    border-color: #16a085;
}

/* Responsive Forms */
@media (max-width: 768px) {
    .collapse {
        margin-right: -12px;
        margin-left: -12px;
    }
    
    .collapse > div {
        padding: 15px !important;
    }
    
    .form-control {
        padding: 12px 10px;
        font-size: 16px;
    }
    
    .form-control:focus {
        outline: none;
    }
    
    label {
        font-size: 14px !important;
    }
    
    textarea.form-control {
        min-height: 100px;
    }
    
    .btn {
        width: 100%;
        margin-top: 10px;
    }
}

@media (max-width: 480px) {
    .row {
        margin-right: -8px;
        margin-left: -8px;
    }
    
    [class*="col-"] {
        padding-right: 8px;
        padding-left: 8px;
    }
}

/* Collapse Styles - Ensure content is visible */
.collapse {
    overflow: visible !important;
}

.collapse.show {
    display: block;
    overflow: visible !important;
}

.collapse + * {
    margin-top: 0;
}

.card-body .collapse {
    margin-left: -20px;
    margin-right: -20px;
    margin-bottom: -20px;
    padding-left: 20px;
    padding-right: 20px;
}
</style>

<script>
function toggleAquariumStatus(aquariumId) {
    const btn = document.getElementById('toggleStatusBtn');
    const wasActive = btn.innerHTML.includes('Desactivar');
    
    if (!confirm(wasActive ? '¿Desactivar este acuario?' : '¿Activar este acuario?')) {
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';

    fetch('<?php echo APP_URL; ?>/aquarium/toggle-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'aquarium_id=' + aquariumId + '&csrf_token=<?php echo $csrfToken; ?>'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar el estado
            const statusStr = data.status === 'activo' ? 'Desactivar' : 'Activar';
            const icon = data.status === 'activo' ? 'fa-pause-circle' : 'fa-play-circle';
            const titleSection = document.querySelector('h1');
            
            // Actualizar badge de estado en el título
            const inactiveBadge = titleSection.querySelector('.fa-pause-circle');
            if (data.status === 'inactivo') {
                if (!inactiveBadge) {
                    const badge = document.createElement('span');
                    badge.style.cssText = 'font-size: 18px; opacity: 0.9; margin-left: 10px;';
                    badge.innerHTML = '<i class="fas fa-pause-circle"></i> (Inactivo)';
                    titleSection.appendChild(badge);
                }
            } else {
                if (inactiveBadge) {
                    inactiveBadge.parentElement.remove();
                }
            }
            
            // Actualizar botón
            btn.innerHTML = '<i class="fas ' + icon + '"></i> ' + statusStr;
            btn.disabled = false;
            
            // Mostrar notificación
            alert(data.message || 'Estado actualizado correctamente');
            
            // Recargar la página después de 1 segundo para reflejar cambios visuales
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            alert(data.message || 'Error al actualizar el estado');
            btn.disabled = false;
            btn.innerHTML = wasActive ? '<i class="fas fa-pause-circle"></i> Desactivar' : '<i class="fas fa-play-circle"></i> Activar';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
        btn.disabled = false;
        btn.innerHTML = wasActive ? '<i class="fas fa-pause-circle"></i> Desactivar' : '<i class="fas fa-play-circle"></i> Activar';
    });
}
</script>
