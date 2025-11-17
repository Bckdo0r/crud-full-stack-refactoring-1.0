/**
*    File        : frontend/js/api/studentsAPI.js
*    Project     : CRUD PHP
*    Author      : Tecnologías Informáticas B - Facultad de Ingeniería - UNMdP
*    License     : http://www.gnu.org/licenses/gpl.txt  GNU GPL 3.0
*    Date        : Mayo 2025
*    Status      : Prototype
*    Iteration   : 3.0 ( prototype )
*/

import { createAPI } from './apiFactory.js';
export const baseAPI = createAPI('students');   //le doy los metodos basicos para una API y despues agregarle la funcionalidad existe Email

//verifica si un metodo ya existe en la base de datos
async function existeEmail(email) {
    const response = await fetch(`../../backend/server.php?module=students&email=${encodeURIComponent(email)}`);
    if (!response.ok) {
        throw new Error('Error verificando el correo');
    }
    const data = await response.json();
    return data.exists; // El backend debe devolver { exists: true/false }
}

export const studentsAPI = {
    fetchAll: () => baseAPI.fetchAll(),
    fetchPaginated: (page, limit) => baseAPI.fetchPaginated(page, limit),
    create: (data) => baseAPI.create(data),
    update: (data) => baseAPI.update(data),
    remove: (id) => baseAPI.remove(id),
    existeEmail
};
