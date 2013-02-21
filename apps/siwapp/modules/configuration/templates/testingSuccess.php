<?php use_helper('JavascriptBase')?>

<?php include_partial('configuration/navigation')?>

<div id="settings-wrapper" class="content">

  <p>
    <?php echo __('Testings are ').' '. ($sf_user->getAttribute('debug_developer') ? __('Enabled') : __('Disabled')) ?><br>
    <?php echo __('Click on the save button to change it.')?><br>
  </p>
  <form action="<?php echo url_for('@testing')?>" method="post" >

  <?php include_partial('submit')?>
</div>
