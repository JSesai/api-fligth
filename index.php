<?php

require 'flight/Flight.php';

// conectarse a la base de datos con metodo del framework en array se ponen datos para hacer la conexion 
Flight::register('db','PDO',array('mysql:host=localhost;dbname=guitarras','root',''));
// Flight::register('db','PDO',array('mysql:host=localhost;dbname=u738088629_guitarras','u738088629_js','Julio-j1'));

//GET metodo  para obtener los datos de las guitarras con la ruta especificada
Flight::route('/', function () {
   
    Flight::jsonp(["Api de tienda de guitarras"]);
});
//GET metodo  para obtener los datos de las guitarras con la ruta especificada
Flight::route('GET /guitarras', function () {
    $sentencia= Flight::db()->prepare("SELECT * FROM `guitarras`");
    $sentencia->execute();
    $datos=$sentencia->fetchAll();

    Flight::json($datos);
});

//GET metodo  para obtener los datos de una guitarra con la ruta especificada
Flight::route('GET /guitarras/@id', function ($id) {
    //$id=(Flight::request()->data->id); //metodo request detecta la clave enviada en json
    $sentencia= Flight::db()->prepare("SELECT * FROM `guitarras` WHERE id_guitarra = ?");
    $sentencia->bindParam(1, $id);
    $sentencia->execute();
    $datos=$sentencia->fetchAll();

    Flight::json($datos);
});

//metodo POST recibe datos para insertar datos en la BD de una guitarra con la ruta especificada
Flight::route('POST /guitarras', function () {
    $nombre=(Flight::request()->data->nombre); //metodo request detecta la clave enviada en json
    $valor=(Flight::request()->data->valor); //metodo request detecta la clave enviada en json
    $descripcion=(Flight::request()->data->descripcion); //metodo request detecta la clave enviada en json
    $imagen=(Flight::request()->data->imagen); //metodo request detecta la clave enviada en json
    
    // insert con los datos recibidos 
    $sql = "INSERT INTO `guitarras` (`nombre`, `valor`, `descripcion`, `imagen`) VALUES (?, ?, ?, ?)";
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $nombre);
    $sentencia->bindParam(2, $valor);
    $sentencia->bindParam(3, $descripcion);
    $sentencia->bindParam(4, $imagen);
    $sentencia->execute();
    Flight::jsonp(["guitarra agregada"]);
});

//metodo UPDATE recibe datos para actualizar datos en la BD de una guitarra especifica
Flight::route('PUT /actualizarGuitarra', function () {
    $id=(Flight::request()->data->id); //metodo request detecta la clave enviada en json
    $nombre=(Flight::request()->data->nombre); //metodo request detecta la clave enviada en json
    $valor=(Flight::request()->data->valor); //metodo request detecta la clave enviada en json
    $descripcion=(Flight::request()->data->descripcion); //metodo request detecta la clave enviada en json
    $imagen=(Flight::request()->data->imagen); //metodo request detecta la clave enviada en json
    
    // insert con los datos recibidos 
    $sql = "UPDATE `guitarras` SET `nombre` = ?, `valor` = ?, `descripcion` = ? , `imagen` = ? WHERE `guitarras`.`id_guitarra` = ?";
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $nombre);
    $sentencia->bindParam(2, $valor);
    $sentencia->bindParam(3, $descripcion);
    $sentencia->bindParam(4, $imagen);
    $sentencia->bindParam(5, $id);
    $sentencia->execute();
    Flight::jsonp(["guitarra actualizada"]);
});

// metodo que sirve para eliminar registro en la base de datos en base id recibido
Flight::route('DELETE /guitarras', function () {
    $id=(Flight::request()->data->id); //metodo request detecta la clave enviada en json en este caso es el id
  
    // delete con los datos recibidos 
    $sql = "DELETE FROM `guitarras` WHERE id_guitarra = ?"; //sentencia sql que elimina el registro 
    $sentencia= Flight::db()->prepare($sql);//sentencia preparada
    $sentencia->bindParam(1, $id);//sutituimos el parametro ? por lo almacenado en $id
    $sentencia->execute(); //ejecutamos la sentencia preparada
    Flight::jsonp(["guitarra eliminada"]); //mensaje de retorno de que se ha eliminado la guitarra 
});

//GET metodo  para obtener las entradas de los post 
Flight::route('GET /posts', function () {
    $sentencia= Flight::db()->prepare("SELECT * FROM `post`");
    $sentencia->execute();
    $datos=$sentencia->fetchAll();

    Flight::json($datos);
});

//GET metodo  para obtener una entrada de un post 
Flight::route('GET /posts/@id', function ($id) {
    $sentencia= Flight::db()->prepare("SELECT * FROM `post` WHERE id = ?");
    $sentencia->bindParam(1, $id);
    $sentencia->execute();
    $datos=$sentencia->fetchAll();

    Flight::json($datos);
});
 
Flight::start();

