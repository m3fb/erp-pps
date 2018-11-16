<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;


$this->registerCss(".my-navbar { background-color: #dff0d8;
									color:#3c763d;
}");



#print_r($items);
#------------------------------------------------------------------------------------------------------------------------
#Hier beginnt die Navigationsleiste
 
            NavBar::begin([
                'brandLabel' => 'm3profile GmbH - ProControl',
                'brandUrl' => ['/procontrol/index'],
                'brandOptions'=>['style' => 'color: #3c763d;'],
                'options' => [
                    'class' => 'my-navbar navbar-fixed-top ',
                ],
                'innerContainerOptions' => ['class' => 'container-fluid'],
            ]);
	            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'encodeLabels' => false,
                'items' => [],

                   # ['label' => 'Home', 'url' => ['/site/index'], 'linkOptions' => ['style' => 'color: #3c763d;']],
                
            ]);
?>            
<p class="navbar-text "><span id="myclock"></span></p>

<?php		
#--------------		
            NavBar::end();
	
?>
