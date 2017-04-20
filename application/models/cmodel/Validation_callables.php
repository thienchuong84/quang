<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validation_callables extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function validateDateFormat( $date, $format = 'Y-m-d' )
	{
		$d = DateTime::createFromFormat( $format, $date );
		return $d && $d->format($format) == $date;
	}
}

/* End of file Validation_callables.php */
/* Location: ./application/models/cmodel/Validation_callables.php */