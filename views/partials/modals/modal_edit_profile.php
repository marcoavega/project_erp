<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="edit-username" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="edit-username" name="username" value="<?php echo $username; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit-email" name="email" value="<?php echo $email; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="edit-password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="edit-password" name="password" placeholder="Dejar en blanco para no cambiar">
                    </div>
                    <div class="mb-3">
                        <label for="edit-user_image" class="form-label">Imagen de Perfil</label>
                        <input type="file" class="form-control" id="edit-user_image" name="user_image" accept="image/*">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveProfileChanges">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>