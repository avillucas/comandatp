<?php
namespace Core\Dao;

use Core\Empleado;
use Core\Entidad;
use Core\Exceptions\SysException;
use Core\Exceptions\SysValidationException;
use Core\Mozo;
use Core\Preparador;
use Core\Usuario;
use Core\Producto;
use Core\Pelicula;
use Core\Actor;

class ActorEntidadDao extends EntidadDao
{

    /** @var string $nombre */
    public $nombre;

    /** @var string $apellido */
    public $apellido;

    /** @var string $nacionalidad */
    public $nacionalidad;

    /** @var string $fechaNacimiento */
    public $fechaNacimiento;

    public static function crear( $nombre, $apellido,  $nacionalidad, $fechaNacimiento)
    {        
        $actor = new Actor(null, $nombre, $apellido,  $nacionalidad, $fechaNacimiento);
        ActorEntidadDao::save($actor);
        return $actor;
    }

  
    public static function insertar(Entidad $entidad)
    {
        /** @var Actor $actor */
        $actor = $entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO actores (nombre,apellido,fecha_nacimiento, nacionalidad)
            VALUES (:nombre,:apellido,:fechaNacimiento,:nacionalidad)
        ");
        $consulta->bindValue(':nombre', $actor->getNombre(), \PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $actor->getApellido(), \PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $actor->getNacionalidad(), \PDO::PARAM_STR);        
        $consulta->bindValue(':fechaNacimiento', $actor->getFechaNacimiento(), \PDO::PARAM_STR);                
        
        
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function eliminar(Entidad $entidad)
    {
        /** @var Producto $entidad */
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				DELETE 
				FROM peliculas 				
				WHERE id=:id
        ");
        $consulta->bindValue(':id', $entidad->getId(), \PDO::PARAM_INT);
        $consulta->execute();
        return true;
    }


    public static function actualizar(Entidad $entidad)
    {
        /** @var Usuario $usuario */
        $usuario = $entidad;
        /** @var Usuario $entidad */
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				UPDATE usuarios 
				SET email = :email,
				clave=:clave,				
				nombre=:nombre,
                empleado_id=:empleado_id
				WHERE id = :id");
        $consulta->bindValue(':email', $usuario->getEmail(), \PDO::PARAM_STR);
        $consulta->bindValue(':clave', $usuario->getClave(), \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $usuario->getNombre(), \PDO::PARAM_STR);
        $consulta->bindValue(':empleado_id', $usuario->getEmpleado()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':id',$usuario->getId(), \PDO::PARAM_INT);
        return $consulta->execute();
    }

   

    /**
     * @return array|Pelicula[]
     */
    public static function traerTodos()
    {
        $query = '
          SELECT p.id, p.nombre, p.tipo , p.fecha_estreno AS fechaEstreno, p.cantidad_publico AS cantidadPublico, p.foto_pelicula AS foto
          FROM  peliculas AS p
        ';
        return parent::baseTraerTodos(PeliculaEntidadDao::class,$query);
    }

    public static function traerUno($id)
    {
        $query = '
        SELECT p.id, p.nombre, p.tipo , p.fecha_estreno AS fechaEstreno, p.cantidad_publico AS cantidadPublico, p.foto_pelicula AS foto
        FROM  peliculas AS p
        ';
        return parent::baseTraerUno(PeliculaEntidadDao::class,$id,$query);
    }

    /**
     * @return Usuario
     */
    public function getEntidad()
    {
        $actor =  new Actor($this->id,$this->nombre,$this->apellido,$this->nacionalidad,$this->fechaNacimiento);        
        return $actor;
    }

    /**
     * Buscar un usuario por email envia un error en caso de no exista ninguno
     * @param $email
     * @return Usuario
     * @throws SysValidationException
     */
    public static function traerUnoPorEmail($email)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var PDOStatement $consulta */
        $consulta =$objetoAccesoDato->RetornarConsulta("
                SELECT id, email, clave , nombre , empleado_id
                FROM  usuarios 
                WHERE email = :email
               ");
        $consulta->bindValue(':email',$email, \PDO::PARAM_STR);
        $consulta->execute();
        /** @var UsuarioEntidadDao $usuarioDao */
        $usuarioDao =  $consulta->fetchObject(UsuarioEntidadDao::class);
        if(!$usuarioDao)
        {
            throw new SysValidationException('No existe un usuario con ese email');
        }
        return $usuarioDao->getEntidad();

    }

    static function traerTodosConRelaciones()
    {
        $query = '
        SELECT a.id, a.nombre, a.apellido, a.nacionalidad, a.fecha_nacimiento AS fechaNacimiento
          FROM  actores AS a
        ';        
        return parent::queyArray($query);
    }

    static function traerTodosConPeliculas()
    {
        $query = '
          SELECT 
          a.id, 
          a.nombre , a.apellido, a.nacionalidad, a.fecha_nacimiento AS fechaNacimiento, 
          p.id, p.nombre, p.tipo , p.fecha_estreno AS fechaEstreno, p.cantidad_publico AS cantidadPublico, p.foto_pelicula AS foto
          FROM  actores AS a
          JOIN peliculas AS p ON p.estrella = a.id 
        ';        
        return parent::queyArray($query);
    }
    


}