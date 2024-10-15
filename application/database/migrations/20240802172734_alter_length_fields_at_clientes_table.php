<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_length_fields_at_clientes_table extends CI_Migration {

    public function up()
    {
        // Altera o comprimento do campo rua
        $this->db->query('ALTER TABLE `mapos`.`clientes` CHANGE COLUMN `rua` `rua` VARCHAR(100) NULL DEFAULT NULL ;');
        $this->db->query('ALTER TABLE `mapos`.`clientes` CHANGE COLUMN `bairro` `bairro` VARCHAR(100) DEFAULT NULL ;');
        $this->db->query('ALTER TABLE `mapos`.`clientes` CHANGE COLUMN `cidade` `cidade` VARCHAR(100) DEFAULT NULL ;');
        $this->db->query('ALTER TABLE `mapos`.`clientes` CHANGE COLUMN `contato` `contato` VARCHAR(100) DEFAULT NULL ;');

    }

    public function down()
    {
        // Remove as alterações nos comprimentos dos campos
        $this->db->query('ALTER TABLE `mapos`.`clientes` CHANGE COLUMN `rua` `rua` VARCHAR(70) NULL DEFAULT NULL ;');
        $this->db->query('ALTER TABLE `mapos`.`clientes` CHANGE COLUMN `bairro` `bairro` VARCHAR(45) DEFAULT NULL ;');
        $this->db->query('ALTER TABLE `mapos`.`clientes` CHANGE COLUMN `cidade` `cidade` VARCHAR(45) DEFAULT NULL ;');
        $this->db->query('ALTER TABLE `mapos`.`clientes` CHANGE COLUMN `contato` `contato` VARCHAR(45) DEFAULT NULL ;');

    }
}