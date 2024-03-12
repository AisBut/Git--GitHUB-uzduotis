<?php
require_once 'skaicius.php';
require_once 'HTMLforma.html';

$it = 1; //vieno skaiciaus iteraciju kiekis (jau iskaitant pradini skaiciu);
$itarr = []; //iteraciju kiekio masyvas
$max = []; //maksimali vieno skaiciaus reiksme
$n = 0; //kiek is viso yra skaiciu intervale
$sum = 0; //aritmetines progresijos suma
$kartai = 0;//kartojame if (aritmetines progresijos) cikla iki pasirinkto skaiciaus
$kiekis; //kiek is viso intervale yra skaiciu

$tempobj = new Skaicius();//naujas objektas
$maxobj = new Skaicius();
$sumobj = new Skaicius();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (!empty($_POST['pirmasis']) && !empty($_POST['paskutinysis']) && !empty($_POST['narys'])){
		$sk1 = $_POST['pirmasis'];
		$sk2 = $_POST['paskutinysis'];
		$pasirink = $_POST['narys']; //aritmetines progresijos narys
		
		echo "Intervalas: ", $sk1, " - ", $sk2, "<br>";

		for ($i = $sk1; $i <= $sk2; $i++){ //pagrindinis loop
			$temp = $i; //laikinas kintamasis
			$max[$n] = $temp; //maksimalaus dydzio n-tasis tampa tuo laikinuoju dydziu
			
			if ($pasirink > $kartai){ //iskvieciamas aritmetines progresijos metodas
				$sumobj->arit_prog($sum, $temp);
				$sum = $sumobj->arit_gavimas();
				$kartai += 1;
			}
	
			while ($temp > 1){
				$tempobj->skaiciavimas($temp); //iskviueciame skaiciavimo metoda
				$temp = $tempobj->sk_gavimas(); //priskiriame suskaicuota dydi su kitu metodu
				
				$it += 1;
				
				$maxobj->dydis($max[$n], $temp);
				$max[$n] = $maxobj->dyd_gavimas();
			}
			
			$itarr[$n] = $it;
			$it = 1;
			$n += 1;
}

$kiekis = $sk2 - $sk1 + 1; 
$histograma = []; //saugosime histogramos duomenis cia (cia bus iteracijos)
$hist_dazn = []; //cia bus iteraciju daznis
$histograma[0] = $itarr[0];
$hist_dazn[0] = 1;
$hisobj = new Papildymas();
$skirt = 0; //kiek skirtingu iteraciju yra is viso

for ($i = 1; $i < $kiekis; $i++){ //histogramos funkcija
	$ar_buvo = 0; //ziurima, ar iteracija sutapo su musu saugomomis skirtingomis iteracijomis
	for ($j = 0; $j < $skirt + 1; $j++){
		$hisobj->hist($itarr[$i], $histograma[$j]);
		$laik = $hisobj->hist_gavimas();
		//echo $laik, "<br>";
		
		if ($laik == 1){
			$hist_dazn[$j] += 1;
			$ar_buvo = 1;
		}
	}
	if ($ar_buvo == 0){
		$histograma[$skirt+1] = $itarr[$i];
		$hist_dazn[$skirt+1] = 1;
		$skirt += 1;
	}
}


$MAX = $max[0]; //cia bus issaugotas pats didziausias skaicius is musu intervalo
$MAXi = $itarr[0]; //maksimalus iteraciju kiekis is musu intervalo
$MINi = $itarr[0]; //minimalus iteraciju kiekis is musu intervalo

$MAXobj = new skaicius(); //sukuriami objektai
$MAXiOBJ = new skaicius(); 
$MINiOBJ = new skaicius();

for ($i = 0; $i < $n; $i++){ //ieskome musu intervalo pacios didziausios reiksmes
	$MAXobj->dydis($MAX, $max[$i]); 
	$MAX = $MAXobj->dyd_gavimas(); 
	
	$MAXiOBJ->dydis($MAXi, $itarr[$i]); 
	$MAXi = $MAXiOBJ->dyd_gavimas(); 
	
	$MINiOBJ->maz($MINi, $itarr[$i]); 
	$MINi = $MINiOBJ->maz_gavimas(); 
}

echo "Rezultatai: <br>";

for ($i = 0; $i < $n; $i++){
	if ($MAX == $max[$i]){
		echo "Didžiausią reikšmę pasiekė ", $sk1 + $i, ", kuris yra ", $max[$i], "<br>";
	}
	if ($MAXi == $itarr[$i]){
		echo "Didžiausią iteracijų kiekį pasiekė ", $sk1 + $i, ", kuris yra ", $itarr[$i], "<br>";
	}
	if ($MINi == $itarr[$i]){
		echo "Mažiausią iteracijų kiekį pasiekė ", $sk1 + $i, ", kuris yra ", $MINi, "<br>";
	}
}
echo "Aritmetinės progresijos ", $pasirink, " nario dydis yra: ", $sum, "<br>";

for ($i = 0; $i < $skirt + 1; $i++){
	$hisobj->spausdinimas ($histograma[$i], $hist_dazn[$i]);
}
}
}
?>