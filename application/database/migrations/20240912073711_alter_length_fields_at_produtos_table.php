<?php

class Migration_alter_length_fields_at_produtos_table extends CI_Migration
{
    public function up()
    {
        // Altera o comprimento do campo descricao
        $this->db->query('ALTER TABLE `mapos`.`produtos` CHANGE COLUMN `descricao` `descricao` VARCHAR(120) NULL DEFAULT NULL ;');
    }

    public function down()
    {
        // Remove as alterações nos comprimentos dos campos
        $this->db->query('ALTER TABLE `mapos`.`produtos` CHANGE COLUMN `descricao` `descricao` VARCHAR(80) NULL DEFAULT NULL ;');
    }
}
