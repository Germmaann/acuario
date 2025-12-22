<div class="container" style="padding-top: 40px; padding-bottom: 60px;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card text-center" data-aos="fade-up">
                <div class="card-body">
                    <h1 style="font-size: 56px; color: #e74c3c;">500</h1>
                    <p style="font-size: 18px; color: #666;"><?php echo htmlspecialchars($errorMessage ?? 'Hubo un problema procesando tu solicitud.'); ?></p>
                    <div style="margin-top: 20px;">
                        <a class="btn btn-primary" href="<?php echo APP_URL; ?>">Ir al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>