<?php

namespace App;

class Servicio {

    // Base de datos
    protected static $baseDatos;
    protected static $columnasBaseDatos = ['id', 'nombre', 'descripcion', 'precio', 'duracion_min', 'especialidad_id', 'creado_en', 'actualizado_en', 'imagen'];

    // Validación de datos
    protected static $errores = [];

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $duracion_min;
    public $especialidad_id;
    public $creado_en;
    public $actualizado_en;
    public $imagen;

    // Asignamos la conexión a la base de datos
    public static function setBaseDatos($baseDatos){
        self::$baseDatos = $baseDatos;
    }

    // Creamos el constructor de la clase
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->duracion_min = $args['duracion_min'] ?? '';
        $this->especialidad_id = $args['especialidad_id'] ?? 1;
        $this->creado_en = date('Y-m-d H:i:s');
        $this->actualizado_en = date('Y-m-d H:i:s');
        $this->imagen = $args['imagen'] ?? '';
    }

    public function guardar(){
        if(!is_null($this->id)){
            // actualizamos el registro
            $this->actualizarRegistro();
        } else {
            // creamos un nuevo registro
            $this->crearRegistro();
        }
    }

    public function crearRegistro(){
        // Sanitizamos los datos para evitar sql injection y XSS
        $datos = $this->sanitizarDatos();

        // Insertar los datos en la base de datos
        $query = "INSERT INTO servicios ( ";
        $query .= join(', ', array_keys($datos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($datos));
        $query .= " ') ";
        
        $resultado = self::$baseDatos->query($query);

        if($resultado){
            //Si el formulario funciona correctamente, redirigimos al usuario a la página del administrador
            header('Location: /admin/propiedades/servicios/index.php?resultado=1');
        }

    }

    public function actualizarRegistro(){
        // Sanitizamos los datos para evitar sql injection y XSS
        $datos = $this->sanitizarDatos();

        $valores = [];
        foreach($datos as $llave => $valor){
            $valores[] = "$llave='$valor'";
        }

        $query = "UPDATE servicios SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$baseDatos->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$baseDatos->query($query);

        if($resultado){
            //Si el formulario funciona correctamente, redirigimos al usuario a la página del administrador
            // pasandole la variable resultado=2 para mostrar mensaje de actualización al usuario
             header('Location: /admin/propiedades/servicios/index.php?resultado=2');
        } else {
            // Mostrar el error (para debuguear)
            // echo "Error en la consulta: " . mysqli_error($baseDatos);
        }
    }

    // Eliminar un registro
    public function eliminarServicio(){

        // Query para eliminar el servicio por su ID
        $queryEliminarServicio = "DELETE FROM servicios WHERE id = " . self::$baseDatos->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$baseDatos->query($queryEliminarServicio);

        // Si hay un registro eliminado redirigimos al usuario al index de administrador con el id para resultado de 3
        if ($resultado){
            $this->borrarImagen();
            header('Location: /admin/propiedades/servicios/index.php?resultado=3');
        }
    }

    // Metodo para IDENTIFICAR y unir los datos de la base de datos
    public function datos(){
        $datos = [];
        foreach(self::$columnasBaseDatos as $columna){
            // Si el nombre de la columna es el id, lo ignoramos ya que es un autoincrement y nosotros no tenemos que incidir sobre el
            if($columna === 'id') continue;
            $datos[$columna] = $this->$columna;
        }
        return $datos;
    }

    // Sanitizamos los datos para evitar sql injection o XSS
    public function sanitizarDatos(){
        $datos = $this->datos();
        $sanitizado = [];

        foreach($datos as $llave => $valor){
            $sanitizado[$llave] = self::$baseDatos->escape_string($valor);
        }

        return $sanitizado;
    }

    /* VALIDACIÓN DE DATOS */
    public static function getErrores(){
        return self::$errores;
    }
    public function validar(){
         /* VALIDAMOS LOS DATOS DEL FORMULARIO */
        // Si no se selecciona una especialidad, llenamos el array con el error.
        if(!$this->especialidad_id){
            self::$errores[] = "Es necesario seleccionar una especialidad";
        }
        // Si el nombre no se rellena, llenamos el array de errores con el error correspondiente.
        if(!$this->nombre) {
            self::$errores[] = "El nombre es obligatorio";
        }
        // Si no se pone un precio, le indicamos al usuario mediante mensaje de error que es obligatio.
        if(!$this->precio){
            self::$errores[] = "El precio es obligatorio";
        }
        // De la misma manera, indicamos al usuario que debe definir la duración del servicio.
        if(!$this->duracion_min){
            self::$errores[] = "Debes definir la duración del servicio en minutos";
        }
        if(!$this->imagen){
            self::$errores[] = "La imágen es obligatoria";
        }
        return self::$errores;
    }

    public function setImagen($imagen){
        // Eliminar la imagen previa (si existe)
        if(!is_null($this->id)){
            // Comprobamos si existe el archivo para no generar errores
            $this->borrarImagen();
        }

        // Asignamos al atributo imagen el nombre de la imagen y lo guardamos en memoria
        if($imagen){
            $this->imagen =$imagen;
        }
    }

    // Eliminar archivo
    public function borrarImagen(){
        // Comprobamos si existe el archivo para no generar errores
        $archivoExite = file_exists(CARPETA_IMAGENES_SERVICIOS . $this->imagen);
        if($archivoExite){
            unlink(CARPETA_IMAGENES_SERVICIOS  .$this->imagen);
        } else {
            // echo "El archivo no existe";
            // echo "/../../../imagenes/servicios/".$this->imagen;
            // exit;
        }
    }

    // READ
    // Listar todos los servicios
    public static function all(){
        $query = "SELECT * FROM servicios;";
        $resultado = self::consultaSQL($query);

        return $resultado;
    }
    // Buscar un servicio por su id
    public static function buscarServicio($idServicio) {
            $queryServicio = "SELECT * FROM servicios WHERE id = $idServicio";
            $resultado = self::consultaSQL($queryServicio);

            // Devolvemos el primer elemento del array que en el caso del servicio es el id
            return array_shift($resultado); // array_shift, devuelve el primer elemento de un array
    }
    public static function consultaSQL($query){
        // Consultar la base de datos
        $resultado = self::$baseDatos->query($query);

        // Iterar los resultados y añadirlos a un array
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = self::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Recuperar los resultados
        return $array;
    }
    protected static function crearObjeto($registro){
        $objeto = new self;

        foreach($registro as $llave => $valor) {
            if(property_exists($objeto, $llave)){
                $objeto->$llave = $valor;
            }
        }

        return $objeto;
    }

    // Sincroniza el objeto de active record con los cambios realizado por el usuario en el UPDATE
    public function sincronizar( $args = [] ){
        foreach($args as $llave => $valor){
            if(property_exists($this, $llave) && !is_null($valor)){
                $this->$llave = $valor;
            }
        }
    }

    
}