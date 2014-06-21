<?php

/**
 * Estimate form.
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EstimateForm extends BaseEstimateForm
{
  /**
   * @see CommonForm
   */

  public function configure($expense = false)
  {
    unset($this['number'], $this['due_date'], $this['closed'], $this['created_at'], $this['updated_at'], $this['series_id']);

    $this->widgetSchema['issue_date'] = new sfWidgetFormI18nJQueryDate($this->JQueryDateOptions);
    $this->widgetSchema['delivery_date'] = new sfWidgetFormI18nJQueryDate($this->JQueryDateOptions);
    $this->widgetSchema['draft'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['status'] = new sfWidgetFormChoice(array('choices'=>Estimate::getStatusArray()));

    $this->widgetSchema->setNameFormat('invoice[%s]');

    parent::configure();
    $this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Image',
      'file_src'  => self::getUploadsDir().'/'.$this->getObject()->getImage(),
      'is_image'  => true,
      'edit_mode' => is_file(sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.$this->getObject()->getImage()),
      'template'  => '<div id="image_container"><div>%file%<br/>%input%</div><div class="dl">%delete% %delete_label%</div><div>'
    ));

    $this->validatorSchema['image'] = new sfValidatorFile(array(
                                     'mime_types' => 'web_images',
                                     'required' => false,
                                     'validated_file_class'=>'SiwappValidatedFile',
                                     'path'      => sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR
                             ));
    $this->validatorSchema['image_delete'] = new sfValidatorPass();

    $this->setDefault('draft',0);
    $this->setDefault('issue_date' , time());
    $this->setDefault('status', 2);
    $this->setDefault('company_id',sfContext::getInstance()->getUser()->getAttribute('company_id') );
    $this->validatorSchema['series_id']= new sfValidatorPass();
  }

  public static function getUploadsDir()
  {
    $root_path = substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'/'));
    $web_dir = str_replace(DIRECTORY_SEPARATOR,'/',sfConfig::get('sf_web_dir'));
    $upload_dir = str_replace(DIRECTORY_SEPARATOR,'/',sfConfig::get('sf_upload_dir'));
    return $root_path.str_replace($web_dir, null, $upload_dir);
  }

  public function checkimage(sfValidatorBase $validator, $values)
  {

    if(!$values['image'])
    {
      return $values;
    }
    try
    {
      //TODO: This method saves the image but it breaks.
      $values['image']->canSave();
    }
    catch(Exception $e)
    {
      $validator->setMessage('invalid',$validator->getMessage('invalid').': '.$e->getMessage());
      throw new sfValidatorError($validator,'invalid');
    }
    return $values;

  }
}
