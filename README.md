# 🏥 Click Salud

Aplicación web que permite a los usuarios registrarse, iniciar sesión y gestionar sus citas médicas. Desarrollada con arquitectura **Modelo-Vista-Controlador (MVC)** para separar lógica de negocio, presentación y control de flujo.

---

## 📁 Estructura del Proyecto

```
/ClickSalud/
├── controllers/      # Controladores: lógica de flujo (ej. CitaController.php)
├── includes/         # Plantillas o templates del proyecto
    ├── config/       # Configuración (DB, variables de entorno)
    ├── templates/    # Plantillas que se reutilizan durante todo el desarrollo del proyecto (footer, header, base, etc)
├── models/           # Modelos de datos y acceso a DB (ej. Usuario.php)
├── views/            # Vistas: plantillas /PHP
├── public/           # Recursos estáticos (CSS, JS, imágenes)
    ├── index.php     # Punto de entrada en nuestra aplicación
├── src/              # Imágenes, archivos SASS y JavaScript antes de ser procesados, empaquetados y minificados para producción
├── composer.json     # Dependencias y scripts de PHP
├── gulpfile.js       # Scripts en javascript con la libreria Gulp para empaquetar y automatizar tareas
├── package.json      # Dependencias y scripts de node
├── Router.php        # Define y gestiona las rutas: asocia URLs a controladores y acciones

```
---

## 🚀 Funcionalidades

- Ver información general de la página sin login
- Crear cuenta de usuario
- Iniciar sesión (usuario o admin)
- Enviar email de contacto
- Panel "Mis Citas" para usuarios:
  - Ver, crear y cancelar citas
- Panel de Administración (solo admin):
  - CRUD completo de elementos del sitio

---

## ⚙️ Tecnologías

- **Frontend**: JavaScript
- **Backend**: Node.js / PHP / Composer
- **Base de datos**: MySQL
- **Vistas**: HTML puro con PHP
- **Estilo**: CSS preprocesado con SASS
- **Autenticación**: Sesiones manejadas desde PHP

---

## 🔧 Instalación

```bash
git clone https://github.com/AdrianCalveteDev/ClickSalud.git
cd clicksalud
npm install
npm run dev #levanta el compilador de CSS y Javascript
cd public
php -S localhost:3000
```

Accede en: `http://localhost:3000`

---

## 👥 Roles de Usuario

- **usuario**: puede gestionar sus citas
- **admin**: accede al panel de administración y gestiona contenido web

---

## 📌 Estructura MVC aplicada

| Componente  | Ejemplo                          | Descripción                             |
|-------------|----------------------------------|-----------------------------------------|
| Modelo      | `models/Cita.php`                | Define el esquema de la cita            |
| Vista       | `views/misCitas.php`             | Plantilla que muestra citas al usuario  |
| Controlador | `controllers/CitaController.php` | Lógica para manejar solicitudes de citas|

---

## 📄 Licencia

Este proyecto se ha realizado como proyecto final del ciclo formativo superior en Desarollo de Aplicaciones Web. 
Está bajo la licencia MIT y puedes usarlo y modificarlo libremente.

---

## ✉️ Contacto

¿Dudas o sugerencias?  
📧 [adriancalvetedev@gmail.com](mailto:adriancalvetedev@gmail.com)