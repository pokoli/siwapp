<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SeriesTable extends Doctrine_Table
{
  /**
   * Returns an associative array with all series or those enabled only
   * depending on the param value.
   *
   * @param boolean Return only enabled series (default=true)
   * @return array
   * @author Carlos Escribano <carlos@markhaus.com>
   **/
   
  public static function getChoicesForSelect($enabled_only = true)
  {
    $series = array();
    $finder = Doctrine::getTable('Series')->createQuery();
    
    if ($enabled_only)
    {
      $finder->where('Enabled = ?', '1');
    }
    
    $finder->where('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'));
    if(!sfContext::getInstance()->getUser()->getAttribute('debug_developer'))
        $finder->andWhere("name <> 'DD' ");

    
    foreach ($finder->execute() as $s)
    {
      $series[$s->id] = $s->name;
    }
    
    return $series;
  }
}
