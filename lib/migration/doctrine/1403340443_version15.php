<?php

class Version15 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('product', 'size', 'varchar', '255', array());
    $this->addColumn('product', 'color', 'varchar', '255', array());
    $this->addColumn('item', 'size', 'varchar', '255', array());
    $this->addColumn('item', 'color', 'varchar', '255', array());
    $this->addColumn('common', 'delivery_date', 'date', '25', array());
    $this->addColumn('common', 'image', 'clob', '', array());
  }

  public function down()
  {
    $this->removeColumn('product', 'size');
    $this->removeColumn('product', 'color');
    $this->removeColumn('item', 'size');
    $this->removeColumn('item', 'color');
    $this->removeColumn('common', 'delivery_date');
    $this->removeColumn('common', 'image');
  }
}
