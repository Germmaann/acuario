<div class="container" style="padding-top: 40px; padding-bottom: 60px;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card text-center" data-aos="fade-up">
                <div class="card-body">
                    <h1 style="font-size: 56px; color: #f39c12;">503</h1>
                    <p style="font-size: 18px; color: #666;"><?php echo htmlspecialchars($errorMessage ?? 'El servicio está temporalmente no disponible.'); ?></p>
                    <div style="margin-top: 20px;">
                        <a class="btn btn-primary" href="<?php echo APP_URL; ?>">Ir al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>