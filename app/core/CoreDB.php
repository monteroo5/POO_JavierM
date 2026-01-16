<?php
class CoreDB
{
    /**
     * Devuelve una conexión a la bd viajes_db
     * @return mysqli Conexión mysqli con la BD
     * @throws Exception Excepción si no se ha podido realizar la conexión
     */
    public static function getConecction(): mysqli
    {
        return new mysqli("127.0.0.1", "root", "Sandia4you", "viajes_db");
    }
}