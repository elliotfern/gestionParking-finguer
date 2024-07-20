// main.js

// Importar las funciones necesarias desde otros archivos
import * as file1 from './form-handlers/insert-data.js';
import * as file2 from './globals.js';
import * as file3 from './load-api/api-get.js'
import * as file4 from './form-handlers/delete-data.js'


//import { renderUI } from './ui.js';

// Función principal de inicialización
function init() {
    // Configurar los manejadores de eventos
    //setupEventListeners();

    // Header authorization ajax
    

    // Obtener datos iniciales
    //fetchData();

    // Renderizar la interfaz de usuario
    //renderUI();
}

// Intervalo para mantener la sesión activa
setInterval(function() {
    let server = window.location.hostname;
    let url = `https://${server}/public/inc/keep_session_alive.php`
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            console.log('Session kept alive');
        })
        .catch(error => {
            console.error('Error keeping session alive:', error);
        });
}, 600000); // 10 minutos (600000 milisegundos)

// Llamar a la función init() cuando la página se haya cargado completamente
document.addEventListener('DOMContentLoaded', init);

file1.addClient();
file3.clientsList();
file3.loadTableClients();