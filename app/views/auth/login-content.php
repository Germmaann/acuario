<div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">
        <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
            <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #148f77 0%, #16a085 100%); border: none;">
                <h2 class="mb-0" style="font-weight: 700; font-size: 28px;">🐠 Bienvenido</h2>
                <p class="mb-0" style="opacity: 0.9; font-size: 14px;">Ingresa a tu cuenta de Acuarismo</p>
            </div>
            <div class="card-body p-5">
                <form method="POST" action="<?php echo APP_URL; ?>/auth/login">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

                    <div class="form-group">
                        <label for="email" style="font-weight: 600; color: #333; margin-bottom: 8px;">
                            <i style="color: #148f77;">📧</i> Email
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-control form-control-lg" 
                               placeholder="tucorreo@ejemplo.com"
                               style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 12px 20px;"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="password" style="font-weight: 600; color: #333; margin-bottom: 8px;">
                            <i style="color: #148f77;">🔒</i> Contraseña
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-control form-control-lg" 
                               placeholder="••••••••"
                               style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 12px 20px;"
                               required>
                    </div>

                    <button type="submit" 
                            class="btn btn-lg btn-block text-white mt-4" 
                            style="background: linear-gradient(135deg, #148f77 0%, #16a085 100%); 
                                   border: none; 
                                   border-radius: 10px; 
                                   padding: 14px; 
                                   font-weight: 700;
                                   box-shadow: 0 4px 15px rgba(20, 143, 119, 0.4);
                                   transition: all 0.3s;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(20, 143, 119, 0.6)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(20, 143, 119, 0.4)';">
                        Iniciar Sesión
                    </button>
                </form>

                <hr style="margin: 30px 0; border-top: 1px solid #e0e0e0;">

                <div class="text-center">
                    <p class="mb-2" style="color: #666;">
                        ¿No tienes cuenta? 
                        <a href="<?php echo APP_URL; ?>/auth/register" 
                           style="color: #148f77; font-weight: 600; text-decoration: none;"
                           onmouseover="this.style.color='#16a085'"
                           onmouseout="this.style.color='#148f77'">
                            Regístrate aquí
                        </a>
                    </p>
                    <p class="mb-0">
                        <a href="<?php echo APP_URL; ?>/auth/forgot-password" 
                           style="color: #999; font-size: 14px; text-decoration: none;"
                           onmouseover="this.style.color='#148f77'"
                           onmouseout="this.style.color='#999'">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4" style="color: #999; font-size: 13px;">
            <p>🔒 Tus datos están protegidos y seguros</p>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #148f77 !important;
        box-shadow: 0 0 0 0.2rem rgba(20, 143, 119, 0.25) !important;
    }
</style>
