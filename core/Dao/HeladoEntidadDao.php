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

class HeladoEntidadDao extends EntidadDao
{

    /** @var string $nombre */
    public $nombre;
    /** @var string $email */
    public $email;
    /** @var string $clave */
    public $clave;
    /** @var Empleado $empleado */
    public $empleado_id = null;

  
    public static function crear($sabor, $tipo, $kilos,$foto=null)
    {        
        $helado = new Helado(null, $tipo, $kilos,$sabor);
        HeladoEntidadDao::save($helado);
        return $helado;
    }

    /**
     * @param string $email
     * @param string $clave
     * @return Usuario
     */
    public static function crearPreparador($nombre, $email, $clave,$sectorId)
    {
        $empleado = new Empleado();
        EmpleadoEntidadDao::save($empleado);
        //
        $sector = SectorEntidadDao::traerUno($sectorId);
        //crea un mozo
        $preparador = new Preparador(null, $empleado, $sector) ;
        PreparadorEntidadDao::save($preparador);
        //crea el usuario
        $usuario = new Usuario(null,$nombre, $email, $clave,$preparador->getEmpleado());
        UsuarioEntidadDao::save($usuario);
        //
        return $usuario;
    }

    public static function insertar(Entidad $entidad)
    {
        /** @var Helado $helado */
        $helado = $entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO helados (sabor,tipo,kilos)
            VALUES (:sabor,:tipo,:kilos)
        ");
        $consulta->bindValue(':sabor', $helado->getSabor(), \PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $helado->getTipo(), \PDO::PARAM_STR);
        $consulta->bindValue(':kilos', $helado->getKilos(), \PDO::PARAM_STR);        
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
          SELECT s.id, s.email, s.clave , s.nombre, s.empleado_id
          FROM  usuarios AS s
        ';
        return parent::baseTraerTodos(UsuarioEntidadDao::class,$query);
    }

    public static function traerUno($id)
    {
        $query = '
          SELECT s.id, s.email, s.clave , s.nombre, s.empleado_id
          FROM  usuarios AS s
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
          SELECT h.id, h.sabor, h.tipo , h.kilos
          FROM  helados AS h
        ';
        return parent::queyArray($query);
    }


}