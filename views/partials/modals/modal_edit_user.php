<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <form id="editUserForm">
              <input type="hidden" id="edit-user-id">
              <div class="mb-3">
                <label for="edit-username" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="edit-username">
              </div>
              <div class="mb-3">
                <label for="edit-email" class="form-label">Email</label>
                <input type="email" class="form-control" id="edit-email">
              </div>
              <div class="mb-3">
                <label for="edit-level" class="form-label">Nivel</label>
                <input type="number" class="form-control" id="edit-level">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="saveChangesBtn">Guardar cambios</button>
          </div>
        </div>
      </div>
    </div>