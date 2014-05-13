<?php

/*
  Uploadify v2.1.0
  Release Date: August 24, 2009

  Copyright (c) 2009 Ronnie Garcia, Travis Nickels

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
 */
if (!empty($_FILES)) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
    $_FILES['Filedata']['name'] = str_replace(' ', '_', $_FILES['Filedata']['name']);
    $targetFile = str_replace('//', '/', $targetPath) . $_FILES['Filedata']['name'];

    #Check image size here
    # si el tamano no es correcto, pasar un codigo de error que me invento

    $img_size = getimagesize($tempFile);
    $width = $img_size[0];
    $height = $img_size[1];
    //echo '<pre>'.print_r($img_size,true).'</pre>';

    if (isset($_GET['tipo']))
        $type = $_GET['tipo'];
    else
        $type = '';
    //echo $type;
    switch ($type) {
		 case 'canal_logo':
            if (round($width / $height, 2) > round(144 / 110, 2) && round($width / $height, 2) < round(120 / 90, 2))
                $_FILES['Filedata']['error'] = 128;
            break;
		case 'operadora':
            if ((round($width / $height, 2) > round(115 / 60, 2)) && (round($width/$height, 2) < round(90/30, 2)))
               $_FILES['Filedata']['error'] = 128;
            break;
		case 'mupis':
            if ((round($width / $height, 2) > round(1323 / 446, 2)) && (round($width/$height, 2) < round(695/390, 2)))
               $_FILES['Filedata']['error'] = 128;
            break;
		case 'digital_media_logo':
			if ((round($width / $height, 2) > round(144 / 110, 2)) && (round($width/$height, 2) < round(120/90, 2)))
               $_FILES['Filedata']['error'] = 128;
            break;
		case 'digital_media_screen':
			if ((round($width / $height, 2) != round(600 / 417, 2)))
               $_FILES['Filedata']['error'] = 128;
            break;
		case 'mupis':
			if ((round($width / $height, 2) < round(900 / 500, 2)) && (round($width / $height, 2) > round(1300 / 500, 2)))
               $_FILES['Filedata']['error'] = 128;
            break;
        case 'familia':
            if ($width / $height != 197 / 143)
                $_FILES['Filedata']['error'] = 128;
            break;
        case 'proyecto_logo':
            if (round($width / $height, 2) != round(80 / 160, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
        case 'proyecto_principal':
            if (round($width / $height, 2) != round(640 / 300, 2))
               $_FILES['Filedata']['error'] = 128;

            break;
        case 'proyecto_planos':
            if (round($width / $height, 2) != round(400 / 500, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
        case 'proyecto_inmuebles':
            if (round($width / $height, 2) != round(500 / 250, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
        case 'producto_logo':
            if (round($width / $height, 2) != round(140 / 100, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
        case 'producto_principal':
            if (round($width / $height, 2) != round(430 / 250, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
        case 'producto_secundario':
            if (round($width / $height, 2) != round(800 / 530, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
		case 'proyecto_principal':
            //if (round($width / $height, 2) != round(430 / 250, 2))
               // $_FILES['Filedata']['error'] = 128;

            break;
        case 'categoria':
            if (round($width / $height, 2) != round(500 / 300, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
        case 'promocion':
            if (round($width / $height, 2) != round(280 / 180, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
        case 'home':
            if (round($width / $height, 2) != round(200 / 163, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
        case 'noticia':
            if (round($width / $height, 2) != round(470 / 300, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
        case 'promocion':
            if (round($width / $height, 2) != round(339 / 259, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
		case 'premios':
			if(round($width / $height, 2) != round(370/300, 2))
				$_FILES['Filedata']['error'] = 128;
			break;
        default:
            if (round($width / $height, 2) != round(339 / 259, 2))
                $_FILES['Filedata']['error'] = 128;

            break;
    }
    //die('q');
    //echo '<pre>'.print_r($_FILES['Filedata'],true).'</pre>';
    move_uploaded_file($tempFile, $targetFile);
    $msg = false;
    switch ($_FILES['Filedata']['error']) {
        case 0:
            //$msg = "No Error"; // comment this out if you don't want a message to appear on success.
            break;
        case 1:
            $msg = "The file is bigger than this PHP installation allows";
            break;
        case 2:
            $msg = "The file is bigger than this form allows";
            break;
        case 3:
            $msg = "Only part of the file was uploaded";
            break;
        case 4:
            $msg = "No file was uploaded";
            break;
        case 6:
            $msg = "Missing a temporary folder";
            break;
        case 7:
            $msg = "Failed to write file to disk";
            break;
        case 8:
            $msg = "File upload stopped by extension";
            break;
        case 128:
            $msg = "Tamaño de imagen incorrecto : " . $width . 'x' . $height;
            break;
        default:
            $msg = "Error desconocido " . $_FILES['Filedata']['error'];
            break;
    }

//$msg = $tempFile.' => '.$targetFile;

    if ($msg) {
        $arr = array('error' => $msg);
        echo json_encode($arr);
    }
    else
        echo json_encode($_FILES['Filedata']);
    //echo $_FILES['Filedata'];
    // } else {
    // 	echo 'Invalid file type.';
    // }
}
?>
