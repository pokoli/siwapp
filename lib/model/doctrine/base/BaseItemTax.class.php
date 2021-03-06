<?php

/**
 * BaseItemTax
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $company_id
 * @property integer $item_id
 * @property integer $tax_id
 * @property Company $Company
 * @property Item $Item
 * 
 * @method integer getCompanyId()  Returns the current record's "company_id" value
 * @method integer getItemId()     Returns the current record's "item_id" value
 * @method integer getTaxId()      Returns the current record's "tax_id" value
 * @method Company getCompany()    Returns the current record's "Company" value
 * @method Item    getItem()       Returns the current record's "Item" value
 * @method ItemTax setCompanyId()  Sets the current record's "company_id" value
 * @method ItemTax setItemId()     Sets the current record's "item_id" value
 * @method ItemTax setTaxId()      Sets the current record's "tax_id" value
 * @method ItemTax setCompany()    Sets the current record's "Company" value
 * @method ItemTax setItem()       Sets the current record's "Item" value
 * 
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseItemTax extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('item_tax');
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('item_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('tax_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));

        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Company', array(
             'local' => 'company_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Item', array(
             'local' => 'item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}