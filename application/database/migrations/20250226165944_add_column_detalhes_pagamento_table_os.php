<?php

class Migration_add_column_detalhes_pagamento_table_os extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('os', [
            'formaPagamento' => [
                'type' => 'TEXT',
                'null' => true,
                'default' => null,
                'after' => 'garantias_id',
            ],
            'prazoPagamento' => [
                'type' => 'TEXT',
                'null' => true,
                'default' => null,
            ],
            'parcelas' => [
                'type' => 'INT',
                'null' => true,
                'default' => null,
            ],
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('os', 'formaPagamento');
        $this->dbforge->drop_column('os', 'prazoPagamento');
        $this->dbforge->drop_column('os', 'parcelas');
    }
}
