<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BmiModel;

class BmicalController extends Controller
{
	public function __construct(BmiModel $bmimodel)
    {
        $this->BmiModel = $bmimodel;
    }
  
    public function index(Request $request)
    {
		$weight = $request->input('weight', null); 
		$height = $request->input('height', null); 
		$age = $request->input('age', null); 

		$amr1 = $this->BmiModel->hitungbmr($weight, $height, $age);
		$amr = $this->BmiModel->hitungamr($amr1);

		$bmi = $this->BmiModel->hitungbmi($weight, $height);
		echo json_encode($bmi);
		//return $bmi;
    }


    public function standard(Request $request)
	{
		$weight = $request->input('weight', null); 
		$height = $request->input('height', null);
		$age = $request->input('age', null);

		$amr1 = $this->BmiModel->hitungbmr($weight, $height, $age);
		$amr = $this->BmiModel->hitungamr($amr1);

		$bmi = $this->BmiModel->hitungbmi_ft($weight, $height);
		echo json_encode($bmi);
		//return $bmi;
	}
}
