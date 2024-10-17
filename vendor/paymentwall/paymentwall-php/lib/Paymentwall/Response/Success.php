<<<<<<< HEAD
<?php

class Paymentwall_Response_Success extends Paymentwall_Response_Abstract implements Paymentwall_Response_Interface
{
	public function process()
	{
		if (!isset($this->response)) {
			return $this->wrapInternalError();
		}

		$response = [
			'success' => 1
		];

		return json_encode($response);
	}
=======
<?php

class Paymentwall_Response_Success extends Paymentwall_Response_Abstract implements Paymentwall_Response_Interface
{
	public function process()
	{
		if (!isset($this->response)) {
			return $this->wrapInternalError();
		}

		$response = [
			'success' => 1
		];

		return json_encode($response);
	}
>>>>>>> f39eb1854d2944c0ca39f812f88e829928281819
}