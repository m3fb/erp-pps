<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<h1>fauserbuchungen/lagereingang</h1>
  
<p>
    <?php 
     
    $porno = Yii::$app->getRequest()->getQueryParam('id',NULL);
    $tables = $model->eckdaten($porno); 
     
    
    
    $form = ActiveForm::begin(['id' => 'lagereingang-form',
			'method' => 'get', 
			'action' => ['fauserbuchungen/einlagerung']
			]); 
    
    // echo Form::widget([
    // 'model'=>$model,
    // 'form'=>$form,
    // 'columns'=>2,
    // 'attributes'=>[       // 2 column layout
        // 'MENGE'=>['type'=>Form::INPUT_TEXT,'label' => 'Sollmenge', 'options'=>[ 'value'=>$tables[0]['MENGE'] . ' ' . $tables[0]['MASSEINH']]],
        // 'MASSEINH'=>['type'=>Form::INPUT_TEXT,'label' => 'Liefermenge', 'options'=>['placeholder'=>'']],
        // 'POSNO'=>['type'=>Form::INPUT_TEXT,'label' => 'Gebinde', 'options'=>['placeholder'=>'']],                 
        // 'VORGNO'=>['type'=>Form::INPUT_TEXT,'label' => 'Gebindemenge', 'options'=>['placeholder'=>'']]
        
    // ]
// ]);

    

    // echo $form->field($model, 'AUSGNO')->checkBox(['label' => 'Teillieferung', 'selected' => $model->AUSGNO]);
    ?>
    
    <input name='pono' value='<?php echo $porno; ?>'>
    <table>
    <tr>
        <td>Sollmenge<br><input name="Sollmenge" class='form-control' value='<?php echo $tables[0]['MENGE'];?>'></td>
        <td>Liefermenge<br><input name="Liefermenge" class='form-control' value='' ></td>
    </tr>
    <tr>
    
    <td>Gebindemenge<br><input name="Gebindemenge" class='form-control' value='' ></td>
    
    </tr>
    </table>
    <br>
   <input name="masseeinheit" class='form-control' value='<?php echo $tables[0]['MASSEINH'];?>' style='display:none;'>
   <input name="postxtl" class='form-control' value='<?php echo $tables[0]['POSTXTL'];?>' style='display:none;'>
   <input name="vorgno" class='form-control' value='<?php echo $tables[0]['VORGNO'];?>' style='display:none;'>
   <input name="posart" class='form-control' value='<?php echo $tables[0]['POSART'];?>' style='display:none;'>
   
	
	<?= Html::submitButton(' Bestätigen', ['class'=> 'btn btn-primary glyphicon glyphicon-ok','name'=>'btnAbschicken']) ;?>	
    <?php
     ActiveForm::end(); 
    // Abfrage über Sollmenge  - Angabe der tatsächlich gelieferten Menge
    
    
    
    
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</p>
