<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_nomefantasia_to_clientes_table extends CI_Migration {

    public function up()
    {
        // Adiciona o campo nome fantasia
        $this->dbforge->add_column('clientes', array(
            'nomeFantasia' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ),
        ));

    }

    public function down()
    {
        // Remove o campo nome fantasia
        $this->dbforge->drop_column('clientes', 'nomeFantasia');

    }
}