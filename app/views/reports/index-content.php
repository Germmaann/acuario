<div class="container-fluid">
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); border-radius: 15px;">
                <div class="card-body py-5 text-white text-center">
                    <h1 style="font-weight: 700; font-size: 32px; margin-bottom: 10px;">
                        <i class="fas fa-file-export"></i> Exportar / Reportes
                    </h1>
                    <p style="font-size: 16px; opacity: 0.9; margin-bottom: 0;">Descarga CSV de tus acuarios, terrarios y mantenimientos</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" data-aos="fade-up">
        <div class="col-lg-4 mb-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center">
                    <i class="fas fa-water" style="font-size: 40px; color: #16a085; margin-bottom: 10px;"></i>
                    <h5 style="font-weight: 700; color: #2c3e50;">Acuarios</h5>
                    <p style="color: #7f8c8d;">Lista de acuarios y detalles básicos</p>
                    <a href="<?php echo APP_URL; ?>/reports/export-aquariums" class="btn btn-primary" style="border-radius: 50px;">
                        <i class="fas fa-download"></i> Descargar CSV
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center">
                    <i class="fas fa-leaf" style="font-size: 40px; color: #e67e22; margin-bottom: 10px;"></i>
                    <h5 style="font-weight: 700; color: #2c3e50;">Terrarios</h5>
                    <p style="color: #7f8c8d;">Lista de terrarios y parámetros</p>
                    <a href="<?php echo APP_URL; ?>/reports/export-terrariums" class="btn btn-primary" style="border-radius: 50px;">
                        <i class="fas fa-download"></i> Descargar CSV
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center">
                    <i class="fas fa-wrench" style="font-size: 40px; color: #3498db; margin-bottom: 10px;"></i>
                    <h5 style="font-weight: 700; color: #2c3e50;">Mantenimientos</h5>
                    <p style="color: #7f8c8d;">Últimas acciones en ambos módulos</p>
                    <a href="<?php echo APP_URL; ?>/reports/export-maintenance" class="btn btn-primary" style="border-radius: 50px;">
                        <i class="fas fa-download"></i> Descargar CSV
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 100 });
</script>
