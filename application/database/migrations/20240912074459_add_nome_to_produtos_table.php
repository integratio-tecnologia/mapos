<?php

class Migration_add_nome_to_produtos_table extends CI_Migration
{
    public function up()
    {
        // Adiciona o campo nome
        $this->dbforge->add_column('produtos', array(
            'nome' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ),
        ));

    }

    public function down()
    {
        // Remove o campo nome fantasia
        $this->dbforge->drop_column('produtos', 'nome');
    }
}
