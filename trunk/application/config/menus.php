<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$CI =& get_instance();
	$CI->config->set_item('language', 'es');
	$CI->lang->load('back', 'es');
	/*
	 * Para agregar opciones en el menu se necesita agregar un arreglo en con dos opciones
	 * el nombre del objeto en plural y su nombre en singular.
	 *
	 * */
	$config['opciones_mainmenu'] = array(
											/*
											array(
													'plural' => $CI->lang->line('noticias'),
													'singular' => $CI->lang->line('noticia'),
													'url' => $CI->lang->line('noticias_url'),
													'index' => 'noticias'
												 ),
											array(
													'plural' => $CI->lang->line('eventos'),
													'singular' => $CI->lang->line('evento'),
													'url' => $CI->lang->line('eventos_url'),
													'index' => 'eventos'
												 ),*/
											array(
													'plural' 	=> $CI->lang->line('reservaciones'),
													'singular' 	=> $CI->lang->line('reservacion'),
													'url' 		=> $CI->lang->line('reservaciones_url'), 
													'index' 	=> 'reservaciones'
												 ),
											array(
													'plural' 	=> $CI->lang->line('tipos_habitacion'),
													'singular' 	=> $CI->lang->line('tipo_habitacion'),
													'url' 		=> $CI->lang->line('tipos_habitacion_url'), 
													'index' 	=> 'tipos_habitacion'
												 ),
											array(
													'plural' 	=> $CI->lang->line('habitaciones'),
													'singular' 	=> $CI->lang->line('habitacion'),
													'url' 		=> $CI->lang->line('habitaciones_url'), 
													'index' 	=> 'habitaciones'
												 ),
											array(
													'plural' 	=> $CI->lang->line('servicios'),
													'singular' 	=> $CI->lang->line('servicio'),
													'url' 		=> $CI->lang->line('servicios_url'), 
													'index' 	=> 'servicios'
												 ),
											array(
													'plural' 	=> $CI->lang->line('testimonios'),
													'singular' 	=> $CI->lang->line('testimonio'),
													'url' 		=> $CI->lang->line('testimonios_url'), 
													'index' 	=> 'testimonios'
												 ),
												  /*
											array(
													'plural' => $CI->lang->line('membresias'),
													'singular' => $CI->lang->line('membresia'),
													'url' => $CI->lang->line('membresias_url'),
													'index' => 'membresias'
												 ),*/
											array(
													'plural' => $CI->lang->line('usuarios'),
													'singular' => $CI->lang->line('usuario'),
													'url' => $CI->lang->line('usuarios_url'),
													'index' => 'usuarios'

												 ),
											array(
													'plural' => $CI->lang->line('monitor'),
													'singular' => $CI->lang->line('monitor'),
													'url' => $CI->lang->line('monitor_url'),
													'index' => 'monitor'
												 ),
											array(
													'plural' => $CI->lang->line('banners'),
													'singular' => $CI->lang->line('banner'),
													'url' => $CI->lang->line('banners_url'),
													'index' => 'banners'
												 )
										);

	/*
	 * Para agregar opciones en el submenu se necesita agregar un arreglo con
	 * las diversas opciones del apartado.
	 *
	 * */
	$config['opciones_submenu'] = array(
											/*
											$CI->lang->line('noticias_url') => array(
																						array("url" => $CI->lang->line('listado_url'), "titulo" => $CI->lang->line('listado')),
																						array("url" => $CI->lang->line('buscar_url'), "titulo" => $CI->lang->line('buscar')),
																						array("url" => $CI->lang->line('crear_url'), "titulo" => $CI->lang->line('crear')),
															   						),
											$CI->lang->line('eventos_url') => array(
																						array("url" => $CI->lang->line('listado_url'), "titulo" => $CI->lang->line('listado')),
																						array("url" => $CI->lang->line('buscar_url'), "titulo" => $CI->lang->line('buscar')),
																						array("url" => $CI->lang->line('crear_url'), "titulo" => $CI->lang->line('crear')),
																						array('url' => $CI->lang->line('facturas_url'), 'titulo' => $CI->lang->line('facturas')),
																						array('url' => $CI->lang->line('usuarios_url'), 'titulo' => $CI->lang->line('usuarios')),
																						array('url' => $CI->lang->line('empresas_url'), 'titulo' => $CI->lang->line('empresas')),
																				   ),
											*/
											$CI->lang->line('reservaciones_url') => array(
																						array("url" => $CI->lang->line('resumen_url'), "titulo" => $CI->lang->line('resumen')),
																						array("url" => $CI->lang->line('reservar_url'), "titulo" => $CI->lang->line('reservar')),
																						array("url" => $CI->lang->line('pagos_url'), "titulo" => $CI->lang->line('pagos')),
																						array("url" => $CI->lang->line('asignacion_url'), "titulo" => $CI->lang->line('asignacion')),
																						array("url" => $CI->lang->line('listado_url'), "titulo" => $CI->lang->line('listado')),
																						array("url" => $CI->lang->line('buscar_url'), "titulo" => $CI->lang->line('buscar'))
																				   ),
											$CI->lang->line('tipos_habitacion_url') => array(
																						array("url" => $CI->lang->line('temporadas_url'), "titulo" => $CI->lang->line('temporadas')),
																						array("url" => $CI->lang->line('listado_url'), "titulo" => $CI->lang->line('listado')),
																						array("url" => $CI->lang->line('buscar_url'), "titulo" => $CI->lang->line('buscar')),
																						array("url" => $CI->lang->line('crear_url'), "titulo" => $CI->lang->line('crear')),
																				   ),
											$CI->lang->line('habitaciones_url') => array(
																						array("url" => $CI->lang->line('listado_url'), "titulo" => $CI->lang->line('listado')),
																						array("url" => $CI->lang->line('buscar_url'), "titulo" => $CI->lang->line('buscar')),
																						array("url" => $CI->lang->line('crear_url'), "titulo" => $CI->lang->line('crear')),
																				   ),
											$CI->lang->line('servicios_url') => array(
																						array("url" => $CI->lang->line('listado_url'), "titulo" => $CI->lang->line('listado')),
																						array("url" => $CI->lang->line('buscar_url'), "titulo" => $CI->lang->line('buscar')),
																						array("url" => $CI->lang->line('crear_url'), "titulo" => $CI->lang->line('crear')),
																				   ),
											$CI->lang->line('testimonios_url') => array(
																						array("url" => $CI->lang->line('listado_url'), "titulo" => $CI->lang->line('listado')),
																						array("url" => $CI->lang->line('buscar_url'), "titulo" => $CI->lang->line('buscar'))
																				   ),
											/*
											$CI->lang->line('membresias_url') => array(
																						array("url" => $CI->lang->line('listado_url'), "titulo" => $CI->lang->line('listado')),
																						array("url" => $CI->lang->line('buscar_url'), "titulo" => $CI->lang->line('buscar')),
															   						),
											*/
											$CI->lang->line('usuarios_url') => array(
																						array("url" => $CI->lang->line('listado_url'), "titulo" => $CI->lang->line('listado')),
																						array("url" => $CI->lang->line('buscar_url'), "titulo" => $CI->lang->line('buscar')),
																						array("url" => $CI->lang->line('crear_url'), "titulo" => $CI->lang->line('crear')),
															   						),
											$CI->lang->line('monitor_url') => array(
																						array("url" => $CI->lang->line('listado_url'), "titulo" => $CI->lang->line('listado')),
																						array("url" => $CI->lang->line('buscar_url'), "titulo" => $CI->lang->line('buscar')),
																				   ),
											$CI->lang->line('banners_url') => array(
																						array("url" => $CI->lang->line('listado_url'), "titulo" => $CI->lang->line('listado')),
																						array("url" => $CI->lang->line('buscar_url'), "titulo" => $CI->lang->line('buscar')),
																						array("url" => $CI->lang->line('crear_url'), "titulo" => $CI->lang->line('crear')),
																				   )
									   );

	$config['active'] = $config['opciones_mainmenu'][0]['url'];
	$config['sub'] = 'listado';

?>
