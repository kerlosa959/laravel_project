<<<<<<< HEAD
<?php

abstract class Paymentwall_Response_Abstract
{
	protected $response;

	public function __construct($response = [])
	{
		$this->response = $response;
	}

	protected function wrapInternalError()
	{
		$response = [
			'success' => 0,
			'error' => [
				'message' => 'Internal error'
			]
		];
		return json_encode($response);
	}
=======
<?php

abstract class Paymentwall_Response_Abstract
{
	protected $response;

	public function __construct($response = [])
	{
		$this->response = $response;
	}

	protected function wrapInternalError()
	{
		$response = [
			'success' => 0,
			'error' => [
				'message' => 'Internal error'
			]
		];
		return json_encode($response);
	}
>>>>>>> f39eb1854d2944c0ca39f812f88e829928281819
}