<?php
namespace Core\IO;

use Slim\Http\UploadedFile;

class IO
{
    public static function traerExtension($fileName)
    {
        $p = explode('.',$fileName);
        return end($p);
    }

    public static function subirArchivo(UploadedFile $fileData,$rutaDirectorio, string $nuevoNombre)
    {
        $ext = IO::traerExtension($fileData->getClientFilename());
        $nuevoArchivo = $nuevoNombre.'.'.$ext;
        $nuevaRuta = IO::traerRutaArchivo($rutaDirectorio.DIRECTORY_SEPARATOR.$nuevoArchivo);
        $fileData->moveTo($nuevaRuta);
        return $nuevoArchivo;
    }

    public static function createIfNotExists($file)
    {
        if(!file_exists($file))
        {
            mkdir($file);
        }
    }

    public static function backupFile($fileName,$fileDir,$backupDir)
    {
        //se asume que el path esta compuesto de un solo directorio
        //la ruta del archivo en backup
        $backupPath =  $backupDir.DIRECTORY_SEPARATOR.time().''.$fileName;
        //la ruta del archivo original
        $filePath = $fileDir.DIRECTORY_SEPARATOR.$fileName;
        if(rename($filePath,$backupPath) !== false)
        {
            return $backupPath;
        }
        return false;
    }

    public static function traerDirectorioPublico()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'public';
    }

    public function traerRutaArchivo($archivo)
    {
        return IO::traerDirectorioPublico().DIRECTORY_SEPARATOR.$archivo;
    }
}
