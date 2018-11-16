<?php
    use yii\bootstrap\ActiveForm;
    use app\models\Auswertung;
    $model = new Auswertung();
    
    
    
    
    ### Vergleichsfunktion, Toleranzen usw.: 
    function vergleich($ist,$soll){        
        $farbe = "";
        
        
        // 10% Toleranz:
        $soll_toleranz = $soll * 1.1;
        
        if($ist > $soll && $ist < $soll_toleranz){
            $farbe = "yellow";            
        }
        else if($ist > $soll_toleranz){
            $farbe = "red";
        }   
        else if($ist <= $soll){
            $farbe = "green";
        }    
        
        return $farbe;
    }
    
    
    
    
?>

<div class='daten'><!--
  <section class='eingabe'>
    <div class='eingabe_links'>
    <span class="input">
        <input name="input_werkzeug"  type="text" id="input_werkzeug" />
        <label class="input__label input__label--yoko" for="input_werkzeug">
            <span class="input__label-content input__label-content--yoko">WerkzeugNr.</span>
        </label>
    </span>
    <br>

      <span class="input">
        <input id="input_start" class='startneu' value='' >
            <label class="input__label input__label--yoko" for="input_orno">
            <span class="input__label-content input__label-content--yoko">Starttermin</span>
        </label>
    </span>
    <span class="input">
        <input id="input_ende" class='endeneu' value=''>
         <label class="input__label input__label--yoko" for="input_orno">
            <span class="input__label-content input__label-content--yoko">Endtermin</span>
        </label>
    </span>    
 <div id="rl">
   
  <select>
    <option> Januar </option>
    <option> Februar</option>
    <option> März</option>
    <option> April</option>
    <option> Mai</option>
    <option> Juni</option>
    <option> Juli</option>
    <option> August</option>
    <option> September</option>
    <option> Oktober</option>
    <option> November</option>
    <option> Dezember</option>
  </select><br>
   <select>
    <option> 2017</option>
    <option> 2016</option>
    <option> 2015</option>
  </select>
    
    </div>
  <br>
-->

<!-- Modal -->
<div class="modal fade" id="Auftragsmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Auftrag auswählen</h4>
      </div>
      <div class="modal-body">
        <div id="auftrag_auswahl"> </div>				
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Schließen</button>
        
      </div>
    </div>
  </div>
</div>
   </div>
 
    <!--
   <div class='eingabe_rechts'> -->
   <!-- <button data-toggle='modal' data-target='#Auftragsmodal'> here </button> -->
   
  <!--  <div class='werkart'>  
    
     
    Optionen:<br>
    Strikter Zeitraum: <input type="checkbox"><br>
    Erweiterter Zeitraum:<input type="checkbox">
    <button class="button button--winona button--border-thick button--round-l button--text-upper button--size-s button--text-medium" data-text="Auswerten" id="ausw_such"><span>Auswerten</span></button> 
    
   </div>
   
   
   
   </div>
  </section>			

</div>-->
<h1> Auswertung Werkzeug W1087 </h1>
<h4>(21.10. - 08.11.) (Strikter Zeitraum) </h4>

<?php 
$messwerte = Yii::$app->db->CreateCommand("SELECT GESCHWINDIGKEIT FROM m3_streckenlog WHERE MSTIME BETWEEN '2017-21-10 00:47:52' AND '2017-08-11 05:14:04' AND LINIE LIKE 'Linie 13' ")
             ->queryAll();
             
$unterbrechungen = 0;
$gesamt = 0;
$geschw = 0;
foreach($messwerte as $wert){
    if($wert['GESCHWINDIGKEIT'] < 0.5){
        $unterbrechungen++;        
    }
    else{
        $geschw += $wert['GESCHWINDIGKEIT'];
    }
    $gesamt++; 
}

$unt_proz =  round(($unterbrechungen / $gesamt) * 100,2);
$lauf_proz = 100 - $unt_proz;
$vdurchschnitt = round($geschw / ($gesamt - $unterbrechungen),2);

$unt_stunden = round($unterbrechungen / 60,2);
$lauf_stunden = round(($gesamt - $unterbrechungen) / 60,2);
#echo $unterbrechungen . "<br>" . $gesamt;
#echo "<br>Prozent: " .   round(($unterbrechungen / $gesamt) * 100,2) . "%";

?>


<div id="legende_auswertung"> 
<table>
<tr>
<td> ( Rüsten </td><td> <div class="punkte ruest"> </div></td>
<td> )( Anfahren </td><td> <div class="punkte anfahr"> </div></td>
<td> )( Produktion </td><td> <div class="punkte produktion"></div></td>
<td> )( Abrüsten </td><td> <div class="punkte abruest"></div></td>
<td> )( Unterbrechung </td><td> <div class="punkte unterbrechung"></div></td>
<td> )( Sonstige </td><td> <div class="punkte sonstige"></div></td>
<td> )( Fehler </td><td> <div class="punkte fehler"></div> </td>
<td> ) </td>

</tr>
</table>
</div>


<div id="vergleich_linien">
<div class="balken_linien">
<div class='produktion abschnitt' style='width: <?php echo $lauf_proz; ?>%;' data-art='Produktion' data-laufzeit='<?php echo $lauf_stunden;?>'><?php echo $lauf_proz;?>%</div><div class='unterbrechung abschnitt' style='width: <?php echo $unt_proz; ?>%;' data-art='Unterbrechung' data-laufzeit='<?php echo $unt_stunden; ?>'><?php echo $unt_proz; ?>%</div><!--<div class='anfahr abschnitt' style='width: 2%;' data-art='Unterbrechung'><font color="white">2%</font></div><div class='ruest abschnitt' style='width: 4%;' data-art='Unterbrechung'>4%</div><div class='sonstige abschnitt' style='width: 4%;'><font color="white">4%</font></div>
--></div><br>
<!--<div class="balken_linien">
Woche 2:  <i>( 07.08.2017 - 13.08.2017 ) (7 Tage)</i>  <br>
<div class='produktion abschnitt' style='width: 53%;' data-art='Produktion' data-laufzeit='89'>53%</div><div class='unterbrechung abschnitt' style='width: 40%;' data-art='Unterbrechung' data-laufzeit='50.1'>40%</div><div class='anfahr abschnitt' style='width: 3%;' data-art='Unterbrechung'><font color="white">3%</font></div><div class='ruest abschnitt' style='width: 0%;' data-art='Unterbrechung'></div><div class='sonstige abschnitt' style='width: 4%;'><font color="white">4%</font></div>
</div><br>
<div class="balken_linien">
Woche 3: <i>( 14.08.2017 - 20.08.2017 ) (7 Tage)</i> <br>
<div class='produktion abschnitt' style='width: 64%;' data-art='Produktion' data-laufzeit='100'>64%</div><div class='unterbrechung abschnitt' style='width: 30%;' data-art='Unterbrechung' data-laufzeit='30.7'>30%</div><div class='anfahr abschnitt' style='width: 1%;' data-art='Unterbrechung'><font color="white">1%</font></div><div class='ruest abschnitt' style='width: 0%;' data-art='Unterbrechung'></div><div class='sonstige abschnitt' style='width: 5%;'><font color="white">5%</font></div>
</div><br>
<div class="balken_linien">
Woche 4: <i>( 21.08.2017 - 27.08.2017 ) (7 Tage)</i> <br>
<div class='produktion abschnitt' style='width: 50%;' data-art='Produktion' data-laufzeit='76'>50%</div><div class='unterbrechung abschnitt' style='width: 30%;' data-art='Unterbrechung' data-laufzeit='20'>30%</div><div class='anfahr abschnitt' style='width: 2%;' data-art='Unterbrechung'><font color="white">2%</font></div><div class='ruest abschnitt' style='width: 0%;' data-art='Unterbrechung'></div><div class='sonstige abschnitt' style='width: 18%;'><font color="white">18%</font></div>
</div><br>
<div class="balken_linien">
Woche 5: <i>( 28.08.2017 - 31.08.2017 ) (4 Tage)</i> <br>
<div class='produktion abschnitt' style='width: 30%;' data-art='Produktion' data-laufzeit='24'>30%</div><div class='unterbrechung abschnitt' style='width: 20%;' data-art='Unterbrechung' data-laufzeit='5'>20%</div><div class='anfahr abschnitt' style='width: 1%;' data-art='Unterbrechung'><font color="white">1%</font></div><div class='ruest abschnitt' style='width: 0%;' data-art='Unterbrechung'></div><div class='sonstige abschnitt' style='width: 9%;'><font color="white">9%</font></div>
</div> 

-->
</div>

<div class="daten">
<table class="vergleich">
<tr>
<th> Arbeitsgänge </th>
<td> <b>Zeitraum 1</b> <br> <i>21.10.2017 - 08.11.2017</i><br>SOLL</td>
<td> <br><br>IST </td>
<td> <br><br>Differenz </td>
</tr>
<tr>
<th> Rüsten </th>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<th> Anfahren </th>
<td>2 Std</td>
<td> 1,56 Std</td>
<td class="bg-success">-0,44 Std</td>
</tr>
<tr>
<th> Produktion </th>
<td> 168.91 Std </td>
<td> <?php echo $lauf_stunden;?>Std</td>
<td class="bg-success"> <?php echo ($lauf_stunden-168.91);?>Std</td>
</tr>
<tr>
<th> Unterbrechungen </th>
<td> -- </td>
<td> <?php echo $unt_stunden; ?> Std</td>
<td></td>
</tr>
<tr>
<th> Gepl Zeit / Zeitdifferenz </th>
<td> 170.91 Std </td>
<td> <?php echo round(($gesamt / 60),2); ?> Std </td>
<td class="bg-danger"> +<?php echo round((($gesamt / 60) - 170.91),2);?> Std </td>
</tr>
<tr><td>_</td>
</tr>
<tr>
<th> Produktionsdaten </th>
</tr>
<tr>
<th> Ausschuss </th>
<td> max. 6%</td>
<td> 3.47%</td>
<td class="bg-success"> -2.53%</td>
</tr>
<tr>
<th> Profilmeter </th>
<td> 29991 m </td>
<td> 31032 m </td>
<td> 1041 m </td>
</tr>
<tr> 
<th> Ø Geschwindigkeit </th>
<td> 2.96 m/min </td>
<td> <?php echo $vdurchschnitt;?> m/min</td>
<td class="bg-success"> <?php echo (2.96 - $vdurchschnitt); ?> m/min </td>
</tr>
<tr> 
<th> Linie </th>
<td> Linie 13</td>

</tr><!--
<tr> 
<th> Ausschusskosten </th>
<td> -- € </td>

</tr>-->


</table> <br> <br> 
<i>
<b>Ausgewertete (Teil-)Aufträge:</b> <br>
LG-12907-01-001     (21.10.2017  00:47  -  23.10.2017  22:31) <br>
442710243460 NTL electrical track profile 4510 W7 l= 4510mm W1087 <br>
<br>
LG-12919-01-001     (23.10.2017   23:27  -  25.10.2017  08:03) <br>
442710243460 NTL electrical track profile 4510 W7 l= 4510mm W1087 <br>
<br>
LG-12883-01-001     (25.10.2017  08:03   -   27.10.2017 05:43)<br>
442710243420 NTL electrical track profile 4510 W13 l= 4510mm W1087 <br>
<br>
LG-12918-01-001     (27.10.2017  05:43  -   03.11.2017  01:40) <br>
442710243420 NTL electrical track profile 4510 W13 l= 4510mm W1087 <br>
<br>
LG-12920-01-001    (03.11.2017 01:45    -  06.11.2017  10:15) <br> 
442710243420 NTL electrical track profile 4510 W13 l= 4510mm W1087  <br>
<br>
LG-12962-01-001     (06.11.2017  13:42   -   08.11.2017  05:14) <br>
442710243420 NTL electrical track profile 4510 W13 l= 4510mm W1087 <br>
</i>


