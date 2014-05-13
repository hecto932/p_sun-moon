<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
				 'crear_noticia' => array(
				 							array('field' => 'id_estado', 'label' => 'Estado', 'rules' => 'required'),
				 							array('field' => 'creado', 'label' => 'Fecha', 'rules' => 'required')
				 						 ),
                 'login_usuarios' => array(
                                    		array('field' => 'email', 'label' => 'Username', 'rules' => 'required'),
                                    		array('field' => 'password', 'label' => 'Password', 'rules' => 'required')
                                  		  )        
               );