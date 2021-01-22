<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BmiModel extends Model 
{
	private $BmiModel;
 
	public function hitungbmr($weight, $height, $age){
		
		$value = 1.0;

		/*if ($gender == 'female'){*/
		$value = 655 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age);

		/*}else{
			$value = 65 + (13.7 * $weight) + (5 * $height) - (6.8 * $age);
		}*/
		
		// console.log($hasil);
		// console.log($berat);
		// console.log($tinggi);
		// console.log($umur);

		return $value;
	}

	public function hitungamr($bmr){
		$persenan = array(
			1.2,	// minim
			1.375,	// ringan
			1.55,	// normal
			1.725,	// $height
			1.9		// $weight
			);

		//return $bmr * $persenan[$aktivitas];
		return $bmr;
	}
		

	public function hitungbmi($weight, $height){
		
		//$height = $height/100;
		//print_r($height); die;
		//print_r($weight / ($height * $height)); die;
		return $weight / ($height * $height) * 10000;
		//return $weight / ($height * $height);
	}


	public function hitungbmi_ft($weight, $height){
		/*$value = $weight / ($height * $height);
		
		return $value * 703;*/
		//print_r($weight / ($height * $height) * 10000); die;

		return $weight / ($height * $height) * 10000;
	}

	public function resultBMI($bmiscore){
		if ($bmiscore < 18.5){
			return "You Lose Weight"; // underweight
		}else if ($bmiscore < 25 && $bmiscore >= 18.5){
			return "Your Ideal Body Weight"; // ideal weight
		}else if ($bmiscore < 30 && $bmiscore >= 25){
			return "You are overweight"; // overweight
		}else if ($bmiscore >= 30){
			return "You Experience Obesity"; // obesity
		}
	}

}
	