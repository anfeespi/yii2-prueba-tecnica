# Prueba Técnica Desarrollador PHP – Yii2

Este repositorio contiene la solución a la prueba técnica para el cargo de Desarrollador PHP (Yii2). El sistema es un gestor de Proyectos y Tareas con integración a una API externa.

## Requisitos del Sistema

Para ejecutar este proyecto localmente se necesita:

*   **PHP:** 8.5 o superior.
*   **MySQL:** 5.7 o superior.
*   **Composer:** Gestor de dependencias de PHP.
*   **XAMPP:** En este caso XAMPP suple la necesidad de MySQL y PHP y es el que usé

## Pasos de Instalación

### 1. Clonar el repositorio
```bash
git clone
cd prueba-tecnica-yii2
```
  

### 2. Instalar dependencias

Instalar las librerías de Yii2 y extensions necesarias (como yii2-httpclient):
```bash 
composer install
```
  

### 3. Configurar Base de Datos

    Crea una base de datos vacía en MySQL llamada yii2_prueba.

    Abrir el archivo config/db.php y ajusta tus credenciales locales:

```PHP
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2_prueba',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

### 4. Ejecutar Migraciones

Crea las tablas (user, project, task, external_posts) ejecutando:
```Bash
php yii migrate
```
  

### 5. Iniciar la Aplicación

Puedes usar el servidor integrado de Yii:
```bash
php yii serve
```
  
La aplicación estará disponible en: http://localhost:8080
## Funcionalidades Principales
### 1. Gestión de Proyectos y Tareas (Ejercicio 1 y 2)

CRUD Completo: Creación, lectura, actualización y borrado de usuarios, proyectos y tareas.

   Reglas de Negocio:

   - Las tareas se asignan a un proyecto.

   - Estado de tarea controlado mediante Dropdown (todo, doing, done).

   - Fechas (created_at, updated_at) gestionadas automáticamente por TimestampBehavior.

   - Vistas Anidadas: En el detalle de un proyecto se pueden ver sus tareas asociadas y crear nuevas pre-vinculadas.

### 2. Sincronización con API Externa (Ejercicio 2B)

- Integración: Consumo de https://jsonplaceholder.typicode.com/posts.

- Lógica de Sincronización:

  * Uso de ExternalPostService para separar la lógica del controlador.

  * Validación de cambios mediante Hash MD5 del payload.

  * Visualización formateada del JSON en la vista detalle.

Uso: Ir al menú External Posts y hacer clic en el botón amarillo "🔄 Sincronizar con API".

## Ejercicios Teóricos
### Ejercicio 3: SQL y Optimización

Consulta para obtener tareas en 'doing' con Proyecto y Usuario:
```SQL
SELECT 
    t.title AS Tarea,
    t.status AS Estado,
    p.name AS Proyecto,
    u.name AS Asignado_A
FROM task t
INNER JOIN project p ON t.project_id = p.id
LEFT JOIN user u ON t.assigned_to = u.id
WHERE t.status = 'doing';
```

Explicación:

- Se utiliza INNER JOIN para Proyectos porque toda tarea debe tener un proyecto padre.

- Se utiliza LEFT JOIN para Usuarios porque una tarea puede estar en 'doing' sin tener un usuario asignado aún.

- Índices: Se recomienda índice en task(status) para filtrado rápido y en las claves foráneas (project_id, assigned_to) para optimizar los joins.

### Ejercicio 4: Manejo de Estados

Para evitar transiciones de estado inválidas (ej: de 'done' a 'todo'), la lógica se implementa en el Modelo (Task) sobrescribiendo el método beforeSave().

Razón: Centralizar la validación en el Modelo asegura la integridad de los datos sin importar si la petición viene de la Web, API o Consola, cumpliendo el principio de encapsulamiento y seguridad.
