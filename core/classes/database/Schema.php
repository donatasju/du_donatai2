<?php

namespace Core\Database;

use \Core\Database\SQLBuilder;

class Schema extends \Core\Database\Abstracts\Schema {
    
    public function __construct(Abstracts\Connection $c, $name) {
        $this->name = $name;
        $this->pdo = $c->getPDO();
        $this->connection = $c;
    }

    public function create() {
        $sql = strtr("CREATE DATABASE @schema", [
            '@schema' => SQLBuilder::schema($this->name)
        ]);

        $this->pdo->exec($sql);
        
        $sql3 = strtr("GRANT ALL ON @schema .* TO @user@@host; FLUSH PRIVILEGES;",[
            '@schema' => SQLBuilder::schema($this->name),
            '@user' => SQLBuilder::value($this->connection->getCredentialUser()),
            '@host' => SQLBuilder::value($this->connection->getCredentialHost())
        ]);

        $this->pdo->exec($sql3);
    }

}

