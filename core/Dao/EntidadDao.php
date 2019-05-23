<?php
namespace Core\Dao;


use Core\Entidad;
use Core\Exceptions\SysNotFoundException;

abstract  class EntidadDao
{

    /** @var int $id */
    public $id;

    /**
     * Guarda el usuario en la base de datos
     * @return string
     */
    abstract public static function insertar(Entidad $entidad);

    /**
     * Actualiza el usuario en la base de datos
     * @return bool
     */
    abstract public static function actualizar(Entidad $entidad);

    /**
     * Elimina de la base la entidad
     * @return bool
     */
    abstract public static function eliminar(Entidad $entidad);

    /**
     * @param $id de la entidad a eliminar
     * @throws SysNotFoundException
     * @return void
     */
    public static function traerOFallar($id)
    {
        $entidad = static::traerUno($id);
        if(!$entidad)
        {
            throw new SysNotFoundException('No existe el recurso buscado');
        }
        return $entidad;
    }

    /**
     * Retorna una lista de todas las entidades
     * @return Entidad[]
     */
    abstract static function traerTodos();

    abstract  static  function traerTodosConRelaciones();

    /**
     * Retorna una entidad en base al id enviado
     * @param $id
     * @return Entidad
     */
    abstract static function traerUno($id);

    /**
     * Crea/Modifica la entidad en su persistencia
     */
    public function save(Entidad &$entidad)
    {
        if($entidad->hasId()){
            static::actualizar($entidad);
            return ;
        }
        $id = static::insertar($entidad);
        $entidad->setId($id) ;
        return ;
    }

    /**
     * @return Entidad
     */
     public abstract function getEntidad();


    protected function baseTraerUno($dao,$id,$query)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $query .=' WHERE id = :id';
        $consulta = $objetoAccesoDato->RetornarConsulta($query);
        $consulta->bindValue(':id', $id, \PDO::PARAM_INT);
        $consulta->execute();
        /** @var EntidadDao $dao */
        $dao = $consulta->fetchObject($dao);
        if(!$dao)
        {
            throw new SysNotFoundException("La entidad (".$id.") buscada no existe");
        }
        return $dao->getEntidad();
    }

    protected function baseTraerTodos($dao,$query)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta($query);
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_CLASS, $dao);
    }


    protected function queyArray($query)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta($query);
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }

}