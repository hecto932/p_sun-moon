<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** PHPExcel */
class Pxl
{
   function __construct()
  {
  	
  	//die(APPPATH.'libraries/pxl/PHPExcel.php');
      require_once APPPATH.'./libraries/pxl/PHPExcel.php';
      require_once APPPATH.'./libraries/pxl/PHPExcel/IOFactory.php';
  }
} 