<?php

class Migration_create_table_unidades extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'idUnidades' => [
                'type' => 'INT',
                'auto_increment' => true,
                'primaryKey' => true
            ],
            'unidade' => [
                'type' => 'VARCHAR',
                'constraint' => 80,
                'null' => FALSE
            ],
            'cadastro' => [
                'type' => 'DATE',
                'null' => true
            ],
            'situacao' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
                'default' => 1
            ]
        ]);
        $this->dbforge->add_key('idUnidades', true);
        $this->dbforge->create_table('unidades');
    }

    public function down()
    {
        $this->dbforge->drop_table('unidades');
    }
}
