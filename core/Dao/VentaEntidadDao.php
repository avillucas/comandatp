<?php
namespace Core\Dao;

use Core\Empleado;
use Core\Entidad;
use Core\Exceptions\SysException;
use Core\Exceptions\SysValidationException;
use Core\Mozo;
use Core\Preparador;
use Core\Usuario;
use Core\Helado;
use Core\Producto;
use Core\Venta;

class VentaEntidadDao extends EntidadDao
{

    /** @var string $nombre */
    public $nombre;
    /** @var string $email */
    public $email;
    /** @var string $clave */
    public $clave;
    /** @var Empleado $empleado */
    public $empleado_id = null;

  
    public static function crear($id = null, Producto $producto, $cantidad,$fechaVenta)
    {        
        $venta = new Venta($id, $producto, $cantidad,$fechaVenta);
        VentaEntidadDao::save($venta);
        return $venta;
    }

  
    public static function insertar(Entidad $entidad)
    {
        /** @var Venta $venta */
        $venta = $entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO ventas (producto_id,cantidad,fecha_venta)
            VALUES (:producto_id,:cantidad,:fecha_venta)
        ");
        $consulta->bindValue(':producto_id', $venta->getProducto()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $venta->getCantidad(), \PDO::PARAM_INT);
        $consulta->bindValue(':fecha_venta', $venta->getFechaVenta(), \PDO::PARAM_STR);        
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
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

    public static function eliminar(Entidad $entidad)
    {
        /** @var Usuario $entidad */
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				DELETE 
				FROM usuarios 				
				WHERE id=:id
        ");
        $consulta->bindValue(':id', $entidad->getId(), \PDO::PARAM_INT);
        $consulta->execute();
        return true;
    }

    /**
     * @return array|Usuario[]
     */
    public static function traerTodos()
    {
        $query = '
          SELECT v.id, v.cantidad, v.fecha_venta , v.producto_id
          FROM  ventas AS v
        ';
        return parent::baseTraerTodos(VentaEntidadDao::class,$query);
    }

    public static function traerUno($id)
    {
        $query = '
        SELECT v.id, v.cantidad, v.fecha_venta, v.producto_id 
        FROM  ventas AS v
        ';
        return parent::baseTraerUno(VentaEntidadDao::class,$id,$query);
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
        SELECT v.id, v.cantidad, v.fecha_venta , v.producto_id
        FROM  ventas AS v
        ';
        return parent::queyArray($query);
    }


}