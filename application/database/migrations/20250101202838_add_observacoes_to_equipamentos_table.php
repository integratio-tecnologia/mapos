<?php

class Migration_add_observacoes_to_equipamentos_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('equipamentos', array(
            'observacoes' => array(
                'type' => 'TEXT',
                'null' => true,
                'default' => null,
                'after' => 'data_fabricacao',
            ),
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('equipamentos', 'observacoes');
    }
}
