<?php

class ContactForm extends sfForm
{

  public function configure()
  {
     $this->setWidgets(array(
        'subject' => new sfWidgetFormInput(),
        'message' => new sfWidgetFormTextarea(),
     ));

     $this->widgetSchema->setNameFormat('contact[%s]');

     $this->setValidators(array(
        'subject' => new sfValidatorString(array('required' => true)),
        'message' => new sfValidatorString(array('required' => true)),
    ));
  }
}

?>
