// **Evento que ejecuta el script una vez que el contenido del DOM ha sido cargado**
document.addEventListener('DOMContentLoaded', () => {

  // **Seleccionar el botón de alternancia de tema**
  const btn = document.getElementById('themeToggleBtn');
  
  // **Verificación de existencia del botón**:
  // Si el botón no existe en el DOM, se detiene la ejecución sin errores.
  if (!btn) return;

  // **Seleccionar los íconos de tema claro y oscuro**
  const iconLight = document.getElementById('iconLight'); // Ícono de sol
  const iconDark  = document.getElementById('iconDark');  // Ícono de luna
  
  // **Seleccionar el elemento raíz del documento (HTML)**
  const html = document.documentElement; // Se usa para aplicar el atributo de tema.

  // **Obtener el estado de tema guardado en `localStorage`**
  let theme = localStorage.getItem('theme') || 'light'; 
  // Si `localStorage` contiene un tema previo, se usa ese valor; de lo contrario, se establece en "light".

  // **Aplicar el tema inicial al HTML**
  html.setAttribute('data-bs-theme', theme); 
  // Establece el atributo `data-bs-theme` en `<html>` para que Bootstrap lo detecte.

  // **Mostrar u ocultar los íconos según el tema actual**
  iconLight.classList.toggle('d-none', theme === 'dark'); // Oculta el ícono de sol si el tema es oscuro.
  iconDark.classList.toggle('d-none', theme === 'light'); // Oculta el ícono de luna si el tema es claro.

  // **Agregar evento de clic al botón**
  btn.addEventListener('click', () => {
      // Alternar entre los temas "light" y "dark".
      theme = (theme === 'light') ? 'dark' : 'light';

      // **Actualizar el atributo del tema en el HTML**
      html.setAttribute('data-bs-theme', theme);

      // **Guardar el nuevo estado de tema en `localStorage`**
      localStorage.setItem('theme', theme); 
      // Permite que el tema se mantenga después de recargar la página.

      // **Alternar visibilidad de los íconos**
      iconLight.classList.toggle('d-none');
      iconDark.classList.toggle('d-none');
  });

});
