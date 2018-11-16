<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->registerJsFile(
    '@web/einlagern.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>   
<h1>fauserbuchungen/lagereingang</h1>

<p>
    <?php 
  
    
    $gebindearray = array();
  
    $pono = Yii::$app->getRequest()->getQueryParam('pono',NULL);
    $masseinh = Yii::$app->getRequest()->getQueryParam('masseeinheit',NULL);
    
    $postxtl = Yii::$app->getRequest()->getQueryParam('postxtl',NULL);
    $vorgno = Yii::$app->getRequest()->getQueryParam('vorgno',NULL);
    $posart = Yii::$app->getRequest()->getQueryParam('posart',NULL);
    
    $menge = Yii::$app->getRequest()->getQueryParam('Liefermenge',NULL);
    #$masseinh = $array['MASSEINH'];
    #$gebinde = $array['POSNO'];
    $gebindemenge = Yii::$app->getRequest()->getQueryParam('Gebindemenge',NULL);  
    #$teil = $array['AUSGNO'];
      
    $sollmenge = $menge;
    $i = 0; 
    
    
    
    
       
    
    $form = ActiveForm::begin(['id' => 'lagereingang-form',
			'method' => 'get',
			'action' => ['fauserbuchungen/schreib']
			]);  
    
    
     
    while($menge > 0){
        
        if($gebindemenge < $menge){
            $menge -= $gebindemenge;
        }
        else{
            $gebindemenge = $menge;
            $menge = 0;
        }
          
        $i++;
        echo "Gebinde ". $i . ":<br>";
        echo "<input name='gebinde-".$i."' id='gebinde-".$i."' class='gebinde form-control' value='".$gebindemenge."' style='width: 200px;' ><input name='gebinde-".$i."-zusatzinfo' class='form-control' value='' placeholder='Zusatzinfo' style='width: 400px;'><br>";
        $info = '';                                                                                   
        $gebindearray[$i]['pono'] = $pono . '-' . $i;
        $gebindearray[$i]['gebindemenge'] = $gebindemenge;
        $daten =  'PONO:' . $gebindearray[$i]['pono'] . '  MENGE:' . $gebindemenge . ' Sonstige Info:' . $info . ' MSTIME:' . date('Y-d-m H:i:s',strtotime('now')) . '\n';
       


    }
    
    echo "<input name='gebindeanzahl' style='display:none;' value='".$i."'>"; 
    echo "<input name='pono' style='display:none;' value='".$pono."'>"; 
    echo "<input name='masseeinheit' style='display:none;' value='".$masseinh."'>"; 
    echo "<input name='postxtl' value='".$postxtl."' style='display:none;'>";
    echo "<input name='vorgno' value='".$vorgno."' style='display:none;'>";
    echo "<input name='posart' value='".$posart."' style='display:none;'>";
 
    echo "<div id='gebindeanzahl'>Gebindeanzahl: ".$i."</div>";
    echo "<div id='mengenkontrolle'><span id='istmenge'> </span> ".$masseinh." / <span id='sollmenge'>".$sollmenge."</span> ".$masseinh."</div>";
    echo "<div id='einbuchen'> </div>";
    
    ActiveForm::end(); 
    
    ?>    
    
</p>
