<?php
class Skaicius{
	public $sk;
	public $a;
	public $b;
	public $a1; //naudojama rasti maziausia dydi
	public $b1;
	public $suma; //naudojama aritmetinei progresijai
	public $skaic;

	//3x+1 skaičiavimas vienam skaičiui
	function skaiciavimas ($sk){
		$this->sk = $sk;
		if ($this->sk % 2 == 0){
				$this->sk = $this->sk / 2;
			}
			else {
				$this->sk = 3 * $this->sk + 1;
		}
	}
	
	//gauname apsakiciuota dydi
	function sk_gavimas() {
		return $this->sk;
	}
	
	//skaiciuojame didziausia dydi
	function dydis ($a, $b){
		$this->a = $a;
		$this->b = $b;
	
		if ($this->a < $this->b){
			$this->a = $this->b;
		}
	}
	
	//gauname apsakiciuota dydi
	function dyd_gavimas() {
		return $this->a;
	}
	
	//skaiciuojame maziausia dydi
	function maz ($a1, $b1){
		$this->a1 = $a1;
		$this->b1 = $b1;
	
		if ($this->a1 > $this->b1){
			$this->a1 = $this->b1;
		}
	}
	
	//gauname apsakiciuota dydi
	function maz_gavimas() {
		return $this->a1;
	}
	
	//aritmetine progresija (si karta bus sekos (pvz 1, 2, 3...) skaiciu suma)
	function arit_prog ($suma, $skaic){
		$this->suma = $suma;
		$this->skaic = $skaic;
	
		$this->suma = $this->suma + $this->skaic;
	}
	
	//gauname apsakiciuota dydi
	function arit_gavimas() {
		return $this->suma;
	}
}

class Papildymas extends Skaicius{
	public $c;
	public $d;
	
	function hist ($a, $b){
		$this->a = $a;
		$this->b = $b;
		
		if ($a == $b){
			$this->a = 1;
		}
	}
	
	function hist_gavimas() {
		return $this->a;
	}
	
	function spausdinimas($c, $d){
		$this->c = $c;
		$this->d = $d;
		
		echo "Iteracija: ", $c, ", daznis: ", $d, "<br>";
	}
}
?>