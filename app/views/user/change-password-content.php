<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #148f77 0%, #16a085 100%); border: none;">
                    <h2 class="mb-0" style="font-weight: 700;">🔐 Cambiar Contraseña</h2>
                    <p class="mb-0" style="opacity: 0.9; font-size: 14px;">Actualiza tu contraseña de forma segura</p>
                </div>

                <div class="card-body p-5">
                    <form method="POST" action="<?php echo APP_URL; ?>/user/change-password">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

                        <div class="form-group mb-4">
                            <label for="current_password" style="font-weight: 600; color: #333; margin-bottom: 8px;">
                                <i style="color: #148f77;">🔒</i> Contraseña Actual
                            </label>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password" 
                                   class="form-control form-control-lg" 
                                   placeholder="••••••••"
                                   style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 12px 20px;"
                                   required>
                            <small class="form-text text-muted" style="display: block; margin-top: 5px;">
                                Necesitamos tu contraseña actual por seguridad
                            </small>
                        </div>

                        <div class="form-group mb-4">
                            <label for="new_password" style="font-weight: 600; color: #333; margin-bottom: 8px;">
                                <i style="color: #148f77;">🆕</i> Nueva Contraseña
                            </label>
                            <input type="password" 
                                   id="new_password" 
                                   name="new_password" 
                                   class="form-control form-control-lg" 
                                   placeholder="••••••••"
                                   style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 12px 20px;"
                                   required>
                            <small class="form-text text-muted" style="display: block; margin-top: 5px;">
                                Mínimo 6 caracteres
                            </small>
                        </div>

                        <div class="form-group mb-4">
                            <label for="confirm_password" style="font-weight: 600; color: #333; margin-bottom: 8px;">
                                <i style="color: #148f77;">✅</i> Confirmar Contraseña
                            </label>
                            <input type="password" 
                                   id="confirm_password" 
                                   name="confirm_password" 
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
                            Cambiar Contraseña
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="<?php echo APP_URL; ?>/user/profile" 
                           style="color: #148f77; text-decoration: none; font-weight: 600;"
                           onmouseover="this.style.color='#16a085'"
                           onmouseout="this.style.color='#148f77'">
                            ← Volver al Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #148f77 !important;
        box-shadow: 0 0 0 0.2rem rgba(20, 143, 119, 0.25) !important;
    }
</style>
