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

class PeliculaEntidadDao extends EntidadDao
{

      /** @var string $nombre */
      private $nombre;
      /** @var string $tipo */
      private $tipo;
      /** @var Date $fechaEstreno */
      private $fechaEstreno;    
      /** @var int $cantidadPublico */
      private $cantidadPublico;
      /** @var string $foto */
      private $foto;
  
    public static function crear( $nombre, $tipo,$fechaEstreno,$cantidadPublico,$foto=null,$actor=null)
    {        
        $foto = 'http://es.web.img3.acsta.net/c_215_290/medias/nmedia/18/91/38/17/20477080.jpg';
        $pelicula = new Pelicula(null, $nombre, $tipo,$fechaEstreno,$cantidadPublico,$foto,$actor);
        PeliculaEntidadDao::save($pelicula);
        return $pelicula;
    }

  
    public static function insertar(Entidad $entidad)
    {
        /** @var Pelicula $pelicula */
        $pelicula = $entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO peliculas (nombre,tipo,fecha_estreno, cantidad_publico, foto_pelicula,estrella)
            VALUES (:nombre,:tipo,:fecha_estreno,:cantidad_publico,:foto_pelicula,:actor)
        ");
        $consulta->bindValue(':nombre', $pelicula->getNombre(), \PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $pelicula->getTipo(), \PDO::PARAM_STR);
        $consulta->bindValue(':fecha_estreno', $pelicula->getFechaEstreno(), \PDO::PARAM_STR);        
        $consulta->bindValue(':cantidad_publico', $pelicula->getCantidadPublico(), \PDO::PARAM_STR);                
        $consulta->bindValue(':foto_pelicula', $pelicula->getFoto(), \PDO::PARAM_STR);                
        $consulta->bindValue(':actor', $pelicula->getActor(), \PDO::PARAM_INT);                
        
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
        $pelicula =  new Pelicula($this->id,$this->nombre,$this->fechaEstreno,$this->cantidadPublico,$this->foto);        
        return $pelicula;
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
        SELECT p.id, p.nombre, p.tipo , p.fecha_estreno AS fechaEstreno, p.cantidad_publico AS cantidadPublico, p.foto_pelicula AS foto
          FROM  peliculas AS p
        ';
        return parent::queyArray($query);
    }


}