<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #148f77 0%, #16a085 100%); border-radius: 15px;">
                <div class="card-body text-center py-5 text-white">
                    <h1 style="font-weight: 700; font-size: 36px; margin-bottom: 10px;">🐠 Wiki Colaborativa de Peces</h1>
                    <p style="font-size: 18px; opacity: 0.9; margin-bottom: 0;">Descubre y aprende sobre diferentes especies acuáticas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background: #f8f9fa; border: 2px solid #e0e0e0; border-right: none; border-radius: 10px 0 0 10px;">
                                        🔍
                                    </span>
                                </div>
                                <input type="text" 
                                       id="search" 
                                       class="form-control form-control-lg" 
                                       placeholder="Buscar peces por nombre..."
                                       style="border: 2px solid #e0e0e0; border-left: none; border-radius: 0 10px 10px 0; padding: 12px 20px;">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <select id="difficulty" 
                                    class="form-control form-control-lg" 
                                    style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 20px;">
                                <option value="">Todas las dificultades</option>
                                <option value="muy_fácil">Muy Fácil</option>
                                <option value="fácil">Fácil</option>
                                <option value="medio">Medio</option>
                                <option value="difícil">Difícil</option>
                                <option value="muy_difícil">Muy Difícil</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button onclick="search()" 
                                    class="btn btn-lg btn-block text-white" 
                                    style="background: linear-gradient(135deg, #148f77 0%, #16a085 100%); 
                                           border: none; 
                                           border-radius: 10px; 
                                           font-weight: 700;
                                           box-shadow: 0 4px 15px rgba(20, 143, 119, 0.4);">
                                Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fish Grid -->
    <?php if (empty($fishes)): ?>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body text-center py-5">
                        <div style="font-size: 80px; opacity: 0.3;">🐟</div>
                        <h4 style="color: #999; margin-top: 20px;">No hay peces registrados aún</h4>
                        <p style="color: #bbb;">Sé el primero en agregar un pez a la wiki</p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($fishes as $fish): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card border-0 shadow-sm h-100" 
                         style="border-radius: 15px; overflow: hidden; cursor: pointer; transition: all 0.3s;"
                         onclick="location.href='<?php echo APP_URL; ?>/fish/show?id=<?php echo $fish['id']; ?>'"
                         onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.2)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)';">
                        
                        <!-- Image Section -->
                        <?php if ($fish['main_image']): ?>
                            <div style="height: 200px; overflow: hidden; position: relative;">
                                <img src="<?php echo APP_URL; ?>/uploads/fish/<?php echo htmlspecialchars($fish['main_image']); ?>" 
                                     style="width: 100%; height: 100%; object-fit: cover;">
                                <div style="position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.95); padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; color: #148f77;">
                                    <?php echo ucfirst(str_replace('_', ' ', $fish['difficulty'])); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div style="height: 200px; background: linear-gradient(135deg, #148f77 0%, #16a085 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 60px;">
                                🐠
                            </div>
                        <?php endif; ?>
                        
                        <!-- Content Section -->
                        <div class="card-body">
                            <h5 style="font-weight: 700; color: #333; margin-bottom: 5px;">
                                <?php echo htmlspecialchars($fish['common_name']); ?>
                            </h5>
                            <p style="color: #999; font-size: 13px; font-style: italic; margin-bottom: 15px;">
                                <?php echo htmlspecialchars($fish['scientific_name'] ?? 'Desconocido'); ?>
                            </p>
                            
                            <div style="display: flex; align-items: center; gap: 10px; padding: 10px; background: #f8f9fa; border-radius: 10px;">
                                <span style="font-size: 20px;">📏</span>
                                <div>
                                    <small style="color: #666; font-size: 11px; display: block;">Tamaño</small>
                                    <strong style="color: #333; font-size: 14px;"><?php echo $fish['size_min']; ?>-<?php echo $fish['size_max']; ?> cm</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Paginación">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $i === (int)($_GET['page'] ?? 1) ? 'active' : ''; ?>">
                                <a class="page-link" 
                                   href="?page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?><?php echo isset($_GET['difficulty']) ? '&difficulty=' . urlencode($_GET['difficulty']) : ''; ?>"
                                   style="<?php echo $i === (int)($_GET['page'] ?? 1) ? 'background: linear-gradient(135deg, #148f77 0%, #16a085 100%); border: none; color: white;' : 'color: #148f77; border: 1px solid #e0e0e0;'; ?> border-radius: 10px; margin: 0 3px; font-weight: 600;">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
    .form-control:focus {
        border-color: #148f77 !important;
        box-shadow: 0 0 0 0.2rem rgba(20, 143, 119, 0.25) !important;
    }
    .page-link:hover {
        background: #f8f9fa !important;
        border-color: #148f77 !important;
    }
</style>

<script>
function search() {
    const searchTerm = document.getElementById('search').value;
    const difficulty = document.getElementById('difficulty').value;
    let url = '<?php echo APP_URL; ?>/fish?page=1';
    if (searchTerm) url += '&search=' + encodeURIComponent(searchTerm);
    if (difficulty) url += '&difficulty=' + encodeURIComponent(difficulty);
    location.href = url;
}

document.getElementById('search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') search();
});
</script>
