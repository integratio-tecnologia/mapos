<?php

class Migration_alter_length_fields_at_servicos_table extends CI_Migration
{
    public function up()
    {
        // Altera o comprimento do campo nome e descricao
        $this->db->query('ALTER TABLE `mapos`.`servicos` CHANGE COLUMN `nome` `nome` VARCHAR(200) NULL DEFAULT NULL ;');
        $this->db->query('ALTER TABLE `mapos`.`servicos` CHANGE COLUMN `descricao` `descricao` VARCHAR(255) NULL DEFAULT NULL ;');
    }

    public function down()
    {
        // Remove as alterações nos comprimentos dos campos
        $this->db->query('ALTER TABLE `mapos`.`servicos` CHANGE COLUMN `nome` `nome` VARCHAR(45) NULL DEFAULT NULL ;');
        $this->db->query('ALTER TABLE `mapos`.`servicos` CHANGE COLUMN `descricao` `descricao` VARCHAR(45) NULL DEFAULT NULL ;');
    }
}
