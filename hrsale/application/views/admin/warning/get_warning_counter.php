<!-- luffy 10 Dec 2019 - 02:56 pm | get total warning on warning dialog -->
<?php $getCounter = $this->Warning_model->getCounterByEmployeeId($warning_to)->countWarningCounter;
if($getCounter==3)
  $color='#F1A9A0';
else $color='#fff';
?>
<div class="form-group">
  <label for="subject">Total Get Warning:</label>
  <input class="form-control" style="border:none; background:<?=$color;?>" value='<?php
  if($getCounter<1){echo 'never';}else{echo $getCounter.' time'; if($getCounter>=2)echo 's';}?>' readonly />
  <input name='warning_counter' value='<?=$getCounter;?>' type='hidden' readonly />
</div>
