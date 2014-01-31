<div class="content">
  <form action="<?php echo url_for("dashboard/createhelp") ?>" method="post" <?php $contactForm->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="invoice">
  <?php
  echo $contactForm->renderHiddenFields();
  ?>
  <div class="block" style="float:left; min-width:48%">
    <h3><?php echo __('Enter your Question') ?></h3>
    <ul class="inline">
      <?php echo $contactForm['subject']->renderRow() ?><br>
      <?php echo $contactForm['message']->renderRow() ?><br>
    </ul>
    <?
    echo gButton(__('Send'), 'type=submit class=action primary save', 'button=true');
    ?>
 </div>
  </form>
  <div class="block" style="float:left; min-width:48%">
    <h3><?php echo __('Support Program') ?></h3>
    <ul class="inline">
    <li> <a href="http://download.teamviewer.com/download/TeamViewerQS_es.exe"><?php echo __('Windows') ?></a> </li><br/>
        <li> <a href="http://download.teamviewer.com/download/TeamViewerQS.dmg"><?php echo __('MAC') ?> </a> </li><br/>
        <li> <a target="_blank" href="https://play.google.com/store/apps/details?id=com.teamviewer.quicksupport.market"><?php echo __('Android') ?> </a> </li><br/>
        <li> <a target="_blank" href="https://itunes.apple.com/es/app/teamviewer-quicksupport/id661649585"><?php echo __('iOS') ?> </a> </li><br/>
    </ul>

</div>
