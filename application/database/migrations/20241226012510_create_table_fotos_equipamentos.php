<?php

class Migration_create_table_fotos_equipamentos extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'idFotosEquipamentos' => array(
                'type' => 'INT',
                'auto_increment' => true,
                'primaryKey' => true
            ),
            'blob' => array(
                'type' => 'LONGBLOB',
                'null' => true,
                'default' => null
            ),
            'foto' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => true,
                'default' => null
            ),
            'thumb' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => true,
                'default' => null
            ),
            'url' => array (
                'type' => 'VARCHAR',
                'constraint' => '300',
                'null' => true,
                'default' => null,
                'unique' => true
            ),
            'path' => array(
                'type' => 'VARCHAR',
                'constraint' => '300',
                'null' => true,
                'default' => null
            ),
            'equipamentos_id' => array(
                'type' => 'INT',
                'null' => false
            )
        ));
        $this->dbforge->add_key('idFotosEquipamentos', true);
        $this->dbforge->add_field('CONSTRAINT fk_fotos_equipamentos_equipamentos1 FOREIGN KEY (equipamentos_id) REFERENCES equipamentos(idEquipamentos)');
        $this->dbforge->create_table('fotos_equipamentos');
    }

    public function down()
    {
        $this->dbforge->drop_table('fotos_equipamentos');
    }
}
