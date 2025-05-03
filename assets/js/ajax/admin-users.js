document.addEventListener("DOMContentLoaded", function () {
  var usersTableElement = document.getElementById("users-table");
  if (!usersTableElement) return;

  // Variable global para almacenar el ID del usuario a eliminar
  var deleteUserID = null;

  // Inicialización de Tabulator
  var table = new Tabulator("#users-table", {
    index: "user_id",
    ajaxURL: BASE_URL + "api/users.php?action=get",
    ajaxConfig: "GET",
    layout: "fitColumns",
    responsiveLayout: "collapse", // Permite que la tabla se adapte en pantallas pequeñas
    placeholder: "Cargando usuarios...",
    columns: [
      { title: "ID", field: "user_id", width: 70, sorter: "number" },
      { title: "Usuario", field: "username", editor: "input" },
      { title: "Email", field: "email", editor: "input" },
      {
        title: "Nivel",
        field: "level_user",
        editor: "number",
        hozAlign: "center",
      },
      {
        title: "Creado",
        field: "created_at",
        formatter: function (cell) {
          var value = cell.getValue();
          var date = new Date(value);
          if (isNaN(date.getTime())) {
            return "";
          }
          var day = date.getDate();
          var month = date.getMonth() + 1;
          var year = date.getFullYear();
          return (
            (day < 10 ? "0" + day : day) +
            "/" +
            (month < 10 ? "0" + month : month) +
            "/" +
            year
          );
        },
      },
      {
        title: "Actualizado",
        field: "updated_at",
        formatter: function (cell) {
          var value = cell.getValue();
          var date = new Date(value);
          if (isNaN(date.getTime())) {
            return "";
          }
          var day = date.getDate();
          var month = date.getMonth() + 1;
          var year = date.getFullYear();
          return (
            (day < 10 ? "0" + day : day) +
            "/" +
            (month < 10 ? "0" + month : month) +
            "/" +
            year
          );
        },
      },
      {
        title: "Acciones",
        responsive: false, // Siempre visible, sin colapsar
        hozAlign: "center",
        width: 150,
        formatter: function () {
          return (
            "<div class='btn-group'>" +
            "<button class='btn btn-sm btn-info edit-btn me-1'>Editar</button>" +
            "<button class='btn btn-sm btn-danger delete-btn'>Eliminar</button>" +
            "</div>"
          );
        },
        cellClick: function (e, cell) {
          var rowData = cell.getRow().getData();
          // Botón para editar
          if (e.target.classList.contains("edit-btn")) {
            document.getElementById("edit-user-id").value = rowData.user_id;
            document.getElementById("edit-username").value = rowData.username;
            document.getElementById("edit-email").value = rowData.email;
            document.getElementById("edit-level").value = rowData.level_user;
            var editModal = new bootstrap.Modal(
              document.getElementById("editUserModal")
            );
            editModal.show();
          }
          // Botón para eliminar: guardar el ID en la variable global
          if (e.target.classList.contains("delete-btn")) {
            deleteUserID = rowData.user_id;
            var deleteModal = new bootstrap.Modal(
              document.getElementById("deleteUserModal")
            );
            deleteModal.show();
          }
        },
      },
    ],
  });

  // Buscador para filtrar la tabla por nombre o email
  var searchInput = document.getElementById("table-search");
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      var query = searchInput.value.toLowerCase();
      table.setFilter(function (data) {
        return (
          data.username.toLowerCase().includes(query) ||
          data.email.toLowerCase().includes(query)
        );
      });
    });
  }

  // Botón de "Guardar cambios" del modal de edición
  document
    .getElementById("saveChangesBtn")
    .addEventListener("click", function () {
      var userID = document.getElementById("edit-user-id").value;
      var username = document.getElementById("edit-username").value;
      var email = document.getElementById("edit-email").value;
      var level = document.getElementById("edit-level").value;

      var updateData = {
        user_id: parseInt(userID),
        username: username,
        email: email,
        level_user: parseInt(level),
      };

      fetch(BASE_URL + "api/users.php?action=update", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ userData: updateData }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (!data.success) {
            alert("Error al actualizar usuario: " + data.message);
          } else {
            alert("Usuario actualizado correctamente");
            table
              .updateOrAddData([updateData])
              .then(() => {
                console.log("Registro actualizado en la tabla");
              })
              .catch((err) => {
                console.error("Error actualizando registro:", err);
              });
            var modalEl = document.getElementById("editUserModal");
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
          }
        })
        .catch((error) => {
          console.error("Error en la solicitud AJAX:", error);
        });
    });

  // Botón de confirmación del modal de eliminación
  document
    .getElementById("confirmDeleteBtn")
    .addEventListener("click", function () {
      if (!deleteUserID) return;
      fetch(BASE_URL + "api/users.php?action=delete", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ user_id: parseInt(deleteUserID) }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (!data.success) {
            alert("Error al eliminar usuario: " + data.message);
          } else {
            alert("Usuario eliminado correctamente");
            table
              .deleteRow(deleteUserID)
              .then(() => {
                console.log("Registro eliminado");
              })
              .catch((err) => {
                console.error("Error eliminando registro:", err);
              });
            deleteUserID = null;
            var modalEl = document.getElementById("deleteUserModal");
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
          }
        })
        .catch((error) => {
          console.error("Error en la solicitud AJAX:", error);
        });
    });

  // Botón de exportación a CSV
  document
    .getElementById("exportCSVBtn")
    .addEventListener("click", function () {
      table.download("csv", "usuarios.csv");
    });

  // Botón de exportación a Excel (omitiendo la columna 'img_url')
  document
    .getElementById("exportExcelBtn")
    .addEventListener("click", function () {
      const dataToExport = table.getData().map((row) => {
        const { img_url, ...filteredRow } = row;
        return filteredRow;
      });

      table.download("xlsx", "usuarios.xlsx", {
        sheetName: "Reporte Usuarios",
        documentProcessing: function (workbook) {
          const sheet = workbook.Sheets["Reporte Usuarios"];
          sheet["A1"].s = { font: { bold: true, color: { rgb: "FF0000" } } };
          return workbook;
        },
        rows: dataToExport,
      });
    });

  // Botón de exportación a JSON
  document
    .getElementById("exportJSONBtn")
    .addEventListener("click", function () {
      table.download("json", "usuarios.json");
    });

  document
    .getElementById("exportPDFBtn")
    .addEventListener("click", function () {
      console.log("Botón de exportación PDF presionado.");
      try {
        if (!table) {
          console.error("El objeto 'table' no está definido.");
          return;
        }

        table.download("pdf", "usuarios.pdf", {
          orientation: "landscape", // Horizontal
          title: "Lista de Usuarios",
          autoTable: {
            styles: {
              fontSize: 8,
              cellPadding: 2,
            },
            margin: { top: 30, left: 5, right: 5 },
            headStyles: {
              fillColor: [22, 160, 133],
              textColor: 255,
              fontStyle: "bold",
              halign: "center",
            },
            theme: "striped",
            // Se especifican únicamente las columnas deseadas en el PDF (sin la de imagen).
            columns: [
              { header: "ID", dataKey: "user_id" },
              { header: "Usuario", dataKey: "username" },
              { header: "Email", dataKey: "email" },
              { header: "Nivel", dataKey: "level_user" },
              { header: "Creado", dataKey: "created_at" },
              { header: "Actualizado", dataKey: "updated_at" },
            ],
            didDrawPage: function (data) {
              var doc = data.doc;
              doc.setFontSize(14);
              doc.text(
                "Reporte de Usuarios - Generado: " +
                  new Date().toLocaleDateString(),
                10,
                15
              );
            },
          },
        });
      } catch (e) {
        console.error("Error en el handler de exportación PDF:", e);
      }
    });



    // Al inicio de DOMContentLoaded
const addUserBtn = document.getElementById('addUserBtn');
const addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
addUserBtn.addEventListener('click', () => addUserModal.show());

// Al guardar nuevo usuario
document.getElementById('saveNewUserBtn').addEventListener('click', () => {
  const username = document.getElementById('new-username').value.trim();
  const email = document.getElementById('new-email').value.trim();
  const password = document.getElementById('new-password').value;
  const levelNew    = parseInt(document.getElementById('new-level').value, 10);

  fetch(BASE_URL + 'api/users.php?action=create', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({userData: {username, email, password, level_user: levelNew}})
  })
  .then(res => res.json())
  .then(data => {
    if (!data.success) {
      alert('Error al crear usuario: ' + data.message);
    } else {
      table.addData([data.newUser]).then(()=>{
        addUserModal.hide();
      });
    }
  })
  .catch(err => console.error('Error:', err));
});




    
});
