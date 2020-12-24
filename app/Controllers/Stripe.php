<?php

namespace App\Controllers;

use App\Models\Home_model;
use CodeIgniter\Controller;

class Stripe extends BaseController
{
	public function __construct()
	{
		//load the home model
		$this->home_model = new Home_model();
	}

	public function index()
	{
		$car_buy_data = $this->home_model->get_buy_data();
		$data = [
			'car_buy_data' => $car_buy_data
		];
		return view('stripe_view', $data);
	}

	public function payment()
    {
      require_once('app/libraries/stripe-php/init.php');
      // Stripe secret key
	  $stripeSecret = 'sk_test_51I1p7FBIVYkuVPah08tf5WpX6e5Ov6KthheipNOUrO5mBLn0IMR4zJgvZ17bhH2r6fYjsR5Fwz6PBNrXvVjvVqi100DZ7DvZFO';

      \Stripe\Stripe::setApiKey($stripeSecret);

        $stripe = \Stripe\Charge::create ([
                "amount" => $this->input->post('amount'),
                "currency" => "usd",
                "source" => $this->input->post('tokenId'),
                "description" => "Carbooking"
        ]);

       // after successfull payment, you can store payment related information into your database

        $data = array('success' => true, 'data'=> $stripe);

        echo json_encode($data);
    }
}
