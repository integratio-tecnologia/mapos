<?php

class Migration_add_foreign_key_to_os_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('os', array(
            'equipamentos_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => NULL,
                'after' => 'usuarios_id',
            ),
        ));
        $this->db->query('ALTER TABLE `os` ADD INDEX `fk_os_equipamentos1` (`equipamentos_id` ASC);');
        $this->db->query('ALTER TABLE `os` ADD CONSTRAINT `fk_os_equipamentos1` FOREIGN KEY (`equipamentos_id`) REFERENCES `equipamentos` (`idEquipamentos`) ON DELETE NO ACTION ON UPDATE NO ACTION;');
    }

    public function down()
    {
        $this->dbforge->drop_column('os', 'equipamentos_id');
        $this->db->query('ALTER TABLE `os` DROP INDEX `fk_os_equipamentos1`;');
        $this->db->query('ALTER TABLE `os` DROP FOREIGN KEY `fk_os_equipamentos1`;');
    }
}
