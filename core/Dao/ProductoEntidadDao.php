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

class ProductoEntidadDao extends EntidadDao
{

    /** @var string $nombre */
    public $nombre;
    /** @var string $email */
    public $email;
    /** @var string $clave */
    public $clave;
    /** @var Empleado $empleado */
    public $empleado_id = null;

  
    public static function crear($tipo, $descripcion,$fechaDeVencimiento, $precio,$rutaDeFoto=null)
    {        
        $producto = new Producto(null, $tipo, $descripcion,$fechaDeVencimiento, $precio,$rutaDeFoto);
        ProductoEntidadDao::save($producto);
        return $producto;
    }

  
    public static function insertar(Entidad $entidad)
    {
        /** @var Producto $producto */
        $producto = $entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO productos (tipo,descripcion,fecha_vencimiento, precio, ruta_de_foto)
            VALUES (:tipo,:descripcion,:fecha_vencimiento,:precio,:ruta_de_foto)
        ");
        $consulta->bindValue(':tipo', $producto->getTipo(), \PDO::PARAM_STR);
        $consulta->bindValue(':descripcion', $producto->getDescripcion(), \PDO::PARAM_STR);
        $consulta->bindValue(':precio', $producto->getPrecio(), \PDO::PARAM_STR);        
        $consulta->bindValue(':ruta_de_foto', $producto->getRutaDeFoto(), \PDO::PARAM_STR);                
        $consulta->bindValue(':fecha_vencimiento', $producto->getFechaDeVencimiento(), \PDO::PARAM_STR);                
        
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function eliminar(Entidad $entidad)
    {
        /** @var Producto $entidad */
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				DELETE 
				FROM productos 				
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
     * @return array|Usuario[]
     */
    public static function traerTodos()
    {
        $query = '
          SELECT s.id, s.email, s.clave , s.nombre, s.empleado_id
          FROM  usuarios AS s
        ';
        return parent::baseTraerTodos(UsuarioEntidadDao::class,$query);
    }

    public static function traerUno($id)
    {
        $query = '
        SELECT p.id, p.descripcion, p.tipo, p.fecha_vencimiento as fechaVencimiento, p.precio, p.ruta_de_foto  as rutaDeFoto
        FROM  productos AS p
        ';
        return parent::baseTraerUno(UsuarioEntidadDao::class,$id,$query);
    }

    /**
     * @return Usuario
     */
    public function getEntidad()
    {
        $empleado = null;
        if(isset($this->empleado_id))
        {
            $empleado = EmpleadoEntidadDao::traerUno($this->empleado_id);
        }
        $usuario =  new Usuario($this->id,$this->nombre,$this->email,null,$empleado);
        $usuario->setClaveEncriptada($this->clave);
        return $usuario;
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
          SELECT p.id, p.descripcion, p.tipo, p.fecha_vencimiento as fechaVencimiento, p.precio, p.ruta_de_foto  as rutaDeFoto
          FROM  productos AS p
        ';
        return parent::queyArray($query);
    }


}