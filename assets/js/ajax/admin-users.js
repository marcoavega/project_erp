// **Evento que se ejecuta cuando el DOM ha sido completamente cargado**
// `DOMContentLoaded` asegura que el código solo se ejecute cuando la página 
// ha terminado de cargar, evitando errores por elementos que aún no están disponibles.
document.addEventListener("DOMContentLoaded", function () {

  // ------------------------------------------------------------------
  // **Configuración de la Tabla de Usuarios usando Tabulator**
  // Se busca el elemento HTML donde se mostrará la tabla de usuarios.
  // Si el elemento no existe (por ejemplo, en otra página donde la tabla no se use),
  // se detiene la ejecución de este código evitando errores innecesarios.
  // ------------------------------------------------------------------
  var usersTableElement = document.getElementById("users-table");

  // Si la tabla no está presente en la página, **se detiene la ejecución**.
  if (!usersTableElement) return;

  var deleteUserID = null; // Variable global que almacenará el ID del usuario seleccionado para eliminación.

  // ------------------------------------------------------------------
  // **Inicialización de la tabla interactiva con Tabulator**
  // Tabulator es una librería JavaScript que permite crear tablas dinámicas
  // con funciones avanzadas como edición, eliminación y exportación de datos.
  // ------------------------------------------------------------------
  var table = new Tabulator("#users-table", {
    index: "user_id", // Identificador único de cada usuario en la tabla.
    ajaxURL: BASE_URL + "api/users.php?action=get", // Dirección de la API que proporciona los datos de usuarios.
    ajaxConfig: "GET", // Método HTTP usado para recuperar los datos del servidor.
    layout: "fitColumns", // Ajusta automáticamente el ancho de las columnas para que encajen en la pantalla.
    responsiveLayout: "collapse", // Permite adaptar la tabla en pantallas pequeñas ocultando columnas menos importantes.
    placeholder: "Cargando usuarios...", // Mensaje mostrado mientras se obtienen los datos del servidor.

    // **Definición de las columnas de la tabla**
    columns: [
      { title: "ID", field: "user_id", width: 70, sorter: "number" }, // Identificador único del usuario.
      { title: "Usuario", field: "username", editor: "input" }, // Permite editar el nombre del usuario directamente en la tabla.
      { title: "Email", field: "email", editor: "input" }, // Campo editable para modificar el correo electrónico.
      {
        title: "Nivel", // Indica el nivel de acceso del usuario (Ejemplo: administrador, usuario estándar).
        field: "level_user",
        editor: "number", // Permite modificar el nivel del usuario ingresando un número.
        hozAlign: "center", // Centra el contenido de esta columna.
      },
      {
        title: "Creado", // Fecha en la que se registró el usuario en el sistema.
        field: "created_at",
        formatter: function (cell) {
          var value = cell.getValue();
          var date = new Date(value);
          if (isNaN(date.getTime())) return ""; // Si la fecha es inválida, devuelve una celda vacía.

          // **Formato de fecha: DD/MM/YYYY**
          var day = date.getDate();
          var month = date.getMonth() + 1;
          var year = date.getFullYear();
          return (day < 10 ? "0" + day : day) + "/" + (month < 10 ? "0" + month : month) + "/" + year;
        },
      },
      {
        title: "Actualizado", // Última modificación en los datos del usuario.
        field: "updated_at",
        formatter: function (cell) {
          var value = cell.getValue();
          var date = new Date(value);
          if (isNaN(date.getTime())) return "";

          var day = date.getDate();
          var month = date.getMonth() + 1;
          var year = date.getFullYear();
          return (day < 10 ? "0" + day : day) + "/" + (month < 10 ? "0" + month : month) + "/" + year;
        },
      },
      {
        title: "Acciones", // Botones para editar y eliminar usuarios.
        responsive: false, // Siempre visible, incluso en pantallas pequeñas.
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
          var rowData = cell.getRow().getData(); // Obtiene los datos del usuario que corresponde a la fila donde se hizo clic.

          // **Si el usuario hace clic en "Editar"**, se abre el modal de edición.
          if (e.target.classList.contains("edit-btn")) {
            document.getElementById("edit-user-id").value = rowData.user_id;
            document.getElementById("edit-username").value = rowData.username;
            document.getElementById("edit-email").value = rowData.email;
            document.getElementById("edit-level").value = rowData.level_user;
            var editModal = new bootstrap.Modal(document.getElementById("editUserModal"));
            editModal.show(); // Se muestra el modal de edición.
          }

          // **Si el usuario hace clic en "Eliminar"**, se almacena el ID del usuario y se muestra el modal de confirmación.
          if (e.target.classList.contains("delete-btn")) {
            deleteUserID = rowData.user_id;
            var deleteModal = new bootstrap.Modal(document.getElementById("deleteUserModal"));
            deleteModal.show(); // Se muestra el modal de eliminación.
          }
        },
      },
    ],
  });

  // ------------------------------------------------------------------
  // **Filtro de búsqueda en la tabla de usuarios**
  // Permite al usuario escribir en un campo de búsqueda para encontrar usuarios
  // de acuerdo con su nombre o correo electrónico.
  // ------------------------------------------------------------------
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

});
