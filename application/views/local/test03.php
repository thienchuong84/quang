<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if( !isset($extensions) ) cdie('ko co exten');

if( isset($extensions) )
	cpre($extensions);
else
	echo 'ko có biến $extensions';

/* End of file test03.php */
/* Location: ./application/views/local/test03.php */