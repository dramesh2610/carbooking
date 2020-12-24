<?php

namespace App\Controllers;

use App\Models\Home_model;

class Home extends BaseController
{
	public function __construct()
	{
		$this->home_model = new Home_model();
	}

	//Home page
	public function index()
	{
		$car_company_data = $this->home_model->get_company_data();
		$data = [
			'company_name' => $car_company_data
		];
		return view('main_view', $data);
	}

	//Get the list of unique cars
	public function getCarList() {
		$companyName = $_POST['companyName'];
		$data = $this->home_model->get_car_model($companyName);

		echo json_encode($data);

	}

	//Get the car data based on model type
	public function getCarData() {
		$carModelId = $_POST['carModelId'];
		$data = $this->home_model->get_car_data($carModelId);

		echo json_encode($data);
	}

	//get the car company names filter by year
	public function getYearData() {
		$yearSearch = $_POST['yearSearch'];
		$data = $this->home_model->get_year_data($yearSearch);

		echo json_encode($data);
	}

	//Insert the purchased car details.
	public function buyDataInsert() {
		$buyCarId = $_POST['buyCarId'];
		$this->home_model->insert_buy_car_data($buyCarId);
	}
}
