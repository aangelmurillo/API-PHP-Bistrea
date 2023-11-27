<?php

namespace proyecto\Controller;

use proyecto\Models\usuario;
use proyecto\Models\Table;
use proyecto\Response\Failure;
use proyecto\Response\Success;

class UsuarioController
{
    public function verUsuarios()
    {
        $db = Table::query("SELECT * FROM usuarios");
        $db = new Success($db);

        $db->Send();
    }
}


?>