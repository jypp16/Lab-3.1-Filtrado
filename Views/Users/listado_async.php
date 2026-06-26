
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h3>Usuarios</h3>
    <a href="<?= BASE_URL ?>/users/crear" class="btn btn-primary">Crear Usuario</a>
</div>

<table class="table table-striped" id="tblUsuarios">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Correo</th>
        </tr>
    </thead>
    <tbody id="tblUsuarios_body">
    </tbody>
</table>

<script src="<?= BASE_URL ?>/assets/js/users.js"></script>