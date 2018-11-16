<?php
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;

$table_content='';
$i = 1;
$label_status;
foreach ($openTasks->models as $model)
	{
		if ($department == $model['department']) {
			
			if ($model['due_date'] < date('Y-m-d')) {
				 $label_status = 'danger';
				 } elseif ($model['due_date'] == date('Y-m-d')) {
				 $label_status = 'warning';
				 } else {
				 $label_status = 'active';
				 }
			
			$table_content.= "
				<tr class='".$label_status."'>
					<th scope='row'>".$i."</th>
					<td>".$model['name']." <br> <u><small>". $model['beauftragter'] ."</small></u>
					<br><h6><small> Erstellt von ".$model->user->firstname ." " .$model->user->surename." am "
					.Yii::$app->formatter->asDate($model['create_date'])." / "
					.Yii::$app->formatter->asTime($model['create_date'])."</small></h6> </td>
					<td>".Yii::$app->formatter->asDate($model['due_date'])."</td>
				</tr>";
			$i++;
		}
	}
?>

<div class="bs-example" data-example-id="simple-table">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Aufgabe</th>
          <th>Datum</th>
        </tr>
      </thead>
      <tbody>
        <?php echo $table_content ?>
      </tbody>
    </table>
  </div>
  

