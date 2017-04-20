<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$CI =& get_instance();

$CI->load->model('cmodel/validation_callables');

$config['reportTalktimeRules'] = [
	[
		'field' => 'txtStartDate',
		'label' => 'Start Date',
		// 'rules' => 'trim|required',
		'rules' => [
			'trim',
			'required',
			[
				'validate_date_format', [ $CI->validation_callables, 'validateDateFormat']
			]
		],
		'errors' => array(
			'required' => 'You must provide a %s.',
			'validate_date_format' => 'The format date of <b>%s</b> is failed. Must : yyyy-mm-dd.'
		)
	],
	[
		'field' => 'txtEndDate',
		'label' => 'End Date',
		// 'rules' => 'trim|required',
		'rules' => [
			'trim',
			'required',
			[
				'validate_date_format', [ $CI->validation_callables, 'validateDateFormat']
			]
		],
		'errors' => array(
			'required' => 'You must provide a %s.',
			'validate_date_format' => 'The format date of <b>%s</b> is failed. Must : yyyy-mm-dd.'
		)
	],
	[
		'field' => 'chkExtens[]',		// chú ý cặp dấu [] , khi check array checkbox
		'label' => 'Extensions',
		'rules' => 'trim|required',
		'errors' => array( 'required' => 'You must provide a %s')
	]
];

/* End of file report_talktime_validate_file.php */
/* Location: ./application/config/cconfig/report_talktime_validate_file.php */