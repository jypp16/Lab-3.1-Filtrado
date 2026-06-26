<div class="row mt-4">
    <div class="col-md-12">
        <h3>Filtrado de Productos</h3>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <strong>Categoria</strong>
            </div>
            <div class="card-body">
                <select class="form-select" id="selectCategoria">
                    <option value="">Seleccione una categoria...</option>
                </select>
            </div>
        </div>

        <div class="card mt-3" id="cardFiltros" style="display:none;">
            <div class="card-header bg-secondary text-white">
                <strong>Filtros</strong>
            </div>
            <div class="card-body" id="filtrosContainer">
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <strong>Productos</strong>
                <input type="text" class="form-control form-control-sm w-50" id="buscador" placeholder="Buscar producto..." disabled>
            </div>
            <div class="card-body">
                <div id="mensajeInicial" class="text-muted text-center">
                    Seleccione una categoria para ver los productos.
                </div>
                <table class="table table-striped table-hover" id="tblProductos" style="display:none;">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Valores</th>
                        </tr>
                    </thead>
                    <tbody id="tblProductos_body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/filtrado.js"></script>
