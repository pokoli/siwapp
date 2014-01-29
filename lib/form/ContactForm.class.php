<?php

class ContactForm extends sfForm
{

  public function configure()
  {
     $this->setWidgets(array(
        'message' => new sfWidgetFormTextarea(array(), array('rows' => '10', 'cols' => '50')),
        'subject' => new sfWidgetFormChoice(array('choices' => $this::getSubjects())),
     ));

     $this->widgetSchema->setNameFormat('contact[%s]');

     $this->setValidators(array(
        'subject' => new sfValidatorString(array('required' => true)),
        'message' => new sfValidatorString(array('required' => true)),
    ));
  }

  public static function getSubjects()
  {
    return array(
      'Fiscal'      => 'Fiscal',
      'Comptable-Informatica'     => 'Comptable o Informatica',
      'Tecnica'      => 'Tècnica',
    );
  }
}

?>
