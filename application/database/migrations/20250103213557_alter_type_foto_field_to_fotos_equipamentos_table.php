<?php

class Migration_alter_type_foto_field_to_fotos_equipamentos_table extends CI_Migration
{
    public function up()
    {
        // Altera o campo foto para longblob
        $this->db->query('ALTER TABLE `fotos_equipamentos` CHANGE `foto` `foto` LONGBLOB NULL DEFAULT NULL;');
    }

    public function down()
    {
        // Altera o campo foto para mediumblob
        $this->db->query('ALTER TABLE `fotos_equipamentos` CHANGE `foto` `foto` VARCHAR(255);');}
}
