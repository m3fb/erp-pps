<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
$this->title = 'Planung';
$this->params['breadcrumbs'][] = $this->title;

$js2 = '$(function() { 
   $("#0_1,#1_1,#1_3,#1_5").addClass("progress-bar-light-green");
   $("#1_2,#1_4,#1_6").addClass("progress-bar-dark-green");
   $("#0_2,#2_1,#2_3,#2_5").addClass("progress-bar-light-blue");
   $("#2_2,#2_4,#2_6").addClass("progress-bar-dark-blue");
   $("#0_3,#3_1,#3_3,#3_5").addClass("progress-bar-light-grey");
   $("#3_2,#3_4,#3_6").addClass("progress-bar-dark-grey");
   $("#progress_mb_0").addClass("progress-margin-bottom-0");
});';

$this->registerJs($js2, $this::POS_READY);

?>
<div class="site-about">
	
<div style="float:left; width:100px;"><span class="label label-default">KW</span></div>

<div class="progress progress-margin-bottom-0">
     <div id="0_1" class="progress-bar progress-bar-default" style="width: 33.3%">
    <span>KW35</span>
  </div>
   <div id="0_2" class="progress-bar progress-bar-info" style="width: 33.3%">
    <span >KW36</span>
  </div>
   <div id="0_3" class="progress-bar progress-bar-default" style="width: 33.3%">
    <span >KW37</span>
  </div>
 </div>

<div style="float:left; width:100px;"><span class="label label-default">datum</span></div>
<div class="progress">
     <div id="1_1" class="progress-bar progress-bar-default" style="width: 5.55%">
    <span>24.08</span>
  </div>
   <div id="1_2" class="progress-bar progress-bar-info" style="width: 5.55%">
    <span >25.08</span>
  </div>
   <div id="1_3" class="progress-bar progress-bar-default" style="width: 5.55%">
    <span >26.08</span>
  </div>
   <div id="1_4" class="progress-bar progress-bar-info" style="width: 5.55%">
    <span >27.08</span>
  </div>
   <div id="1_5" class="progress-bar progress-bar-default" style="width: 5.55%">
    <span >28.08</span>
  </div>
   <div id="1_6" class="progress-bar progress-bar-info" style="width: 5.55%">
    <span >29.08</span>
  </div>
   <div id="2_1" class="progress-bar progress-bar-default" style="width: 5.55%">
    <span>31.08</span>
  </div>
   <div id="2_2" class="progress-bar progress-bar-info" style="width: 5.55%">
    <span >01.09</span>
  </div>
   <div id="2_3" class="progress-bar progress-bar-default" style="width: 5.55%">
    <span >02.09</span>
  </div>
   <div id="2_4" class="progress-bar progress-bar-info" style="width: 5.55%">
    <span >03.09</span>
  </div>
   <div id="2_5" class="progress-bar progress-bar-default" style="width: 5.55%">
    <span >04.09</span>
  </div>
   <div id="2_6" class="progress-bar progress-bar-info" style="width: 5.55%">
    <span >05.09</span>
  </div>
   <div id="3_1" class="progress-bar progress-bar-default" style="width: 5.55%">
    <span>07.09</span>
  </div>
   <div id="3_2" class="progress-bar progress-bar-info" style="width: 5.55%">
    <span >08.09</span>
  </div>
   <div id="3_3" class="progress-bar progress-bar-default" style="width: 5.55%">
    <span >09.09</span>
  </div>
   <div id="3_4" class="progress-bar progress-bar-info" style="width: 5.55%">
    <span >10.09</span>
  </div>
   <div id="3_5" class="progress-bar progress-bar-default" style="width: 5.55%">
    <span >11.09</span>
  </div>
   <div id="3_6" class="progress-bar progress-bar-info" style="width: 5.55%">
    <span >12.09.</span>
  </div>
</div>

<div>
	<span class="label label-width100 label-default">Werkzeug</span>
</div>
<div>
	<span class="label label-default">T Linie 01</span>
</div>
<div>
	<span class="label label-success">P Linie 01</span>
</div>



</div>
