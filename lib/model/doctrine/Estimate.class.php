<?php

/**
 * Estimate
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Estimate extends BaseEstimate
{
  const DRAFT    = 0;
  const REJECTED = 1;
  const PENDING  = 2;
  const APPROVED = 3;

  public function __toString()
  {
    return $this->getSeries()->getValue().($this->getDraft() ? '[draft]' : $this->getNumber());
  }

  public function __get($name)
  {
    if(strpos($name, 'tax_amount_') === 0)
    {
      return $this->calculate($name, true);
    }
    return parent::__get($name);
  }

  public function __isset($name)
  {
    if($name == 'due_amount' || $name == 'tax_details')
    {
      return true;
    }
    if(strpos($name, 'tax_amount_') === 0)
    {
      return true;
    }
    return parent::__isset($name);
  }

  public static function getStatusArray()
  {
    return array(
      '' => '',
      Estimate::PENDING => 'Pending',
      Estimate::APPROVED => 'Approved',
      Estimate::REJECTED => 'Rejected'
    );
  }

  public function checkStatus()
  {
    if($this->getDraft())
    {
      $this->setStatus(Estimate::DRAFT);
    }
  }

  public function getStatusString()
  {
    switch($this->getStatus())
    {
      case Estimate::DRAFT:
        $status = 'draft';
        break;
      case Estimate::REJECTED:
        $status = 'rejected';
        break;
      case Estimate::PENDING:
        $status = 'pending';
        break;
      case Estimate::APPROVED:
        $status = 'approved';
        break;
      default:
        $status = 'unknown';
        break;
    }

    return $status;
  }

  public function preSave($event)
  {
    // compute the number of invoice
    if (!$this->getNumber() && !$this->getDraft())
    {
      $this->setNumber($this->_table->getNextNumber($this->getSeriesId()));
    }

    parent::preSave($event);
  }

  public function generateInvoice()
  {
    $invoice = new Invoice();

    // Get Invoice column mapping and intersect with Estimate columns
    // to remove non common columns. Unset id and type columns.
    $iKeys = array_flip(array_keys($invoice->getTable()->getColumns()));
    $data  = $this->toArray(false);
    unset(
      $data['id'],
      $data['type'],
      $data['created_at'],
      $data['updated_at'],
      $data['draft'],
      $data['number'],
      $data['sent_by_email']
    );
    $data  = array_intersect_key($data, $iKeys);

    $invoice->fromArray($data);
    // $invoice->setDraft(true);
    $invoice->setIssueDate(sfDate::getInstance()->format('Y-m-d'));
    $invoice->setDueDate(sfDate::getInstance()->addMonth()->format('Y-m-d'));

    $invoice->setEstimate($this);

    // Copy Items and taxes
    foreach ($this->Items as $item)
    {
      $iTmp = $item->copy(false);
      foreach ($item->Taxes as $tax)
      {
        $iTmp->Taxes[] = $tax;
      }
      $invoice->Items[] = $iTmp;
    }

    // copy tags
    foreach ($this->getTags() as $tag)
    {
      $invoice->addTag($tag);
    }

    if ($invoice->trySave())
    {
      $invoice->refresh(true)->setAmounts()->save();
      //Mark the estimate as APPROVED
      $this->setStatus(Estimate::APPROVED)->save();

      return $invoice;
    }



    return false;
  }

  public function getImageURL()
  {
    if(!$this->getImage())
        return false;
    return str_replace("\\", "/",self::getUploadsDir().'/'.$this->getImage());
  }

  public static function getUploadsDir()
  {
    $uri = sfContext::getInstance()->getRequest()->getUri();
    $server_url = substr($uri,0,strpos($uri,'/',9));
    $root_path = substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'/'));
    $web_dir = str_replace(DIRECTORY_SEPARATOR,'/',sfConfig::get('sf_web_dir'));
    $upload_dir = str_replace(DIRECTORY_SEPARATOR,'/',sfConfig::get('sf_upload_dir'));
    return $server_url.$root_path.str_replace($web_dir, null, $upload_dir);
  }
}
