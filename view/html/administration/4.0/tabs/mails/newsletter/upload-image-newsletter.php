<?php

/**
 * Dropzone PHP file upload/delete
 */

// Listing unwanted character (accent) to remove them
$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
    'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
    'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
    'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
    'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

// Check if the request is for deleting or uploading
$delete_file = 0;
if(isset($_POST['delete_file'])){
    $delete_file = $_POST['delete_file'];
}

//$targetPath = dirname( __FILE__ ) . '/uploads/';
$targetPath = "../../../../../../assets/images/utils/newsletters/";

// Check if it's an upload or delete and if there is a file in the form
if ( !empty($_FILES) && $delete_file == 0 ) {

    // Check if the upload folder is exists
    if ( file_exists($targetPath) && is_dir($targetPath) ) {

        // Check if we can write in the target directory
        if ( is_writable($targetPath) ) {

            /**
             * Start dancing
             */
            $tempFile = $_FILES['file']['tmp_name'];

            $file_name = strtr( $_FILES['file']['name'], $unwanted_array );

            $targetFile = $targetPath . $file_name;

            // Check if there is any file with the same name
            if ( !file_exists($targetFile) ) {

                move_uploaded_file($tempFile, $targetFile);

                // Be sure that the file has been uploaded
                if ( file_exists($targetFile) ) {
                    $response = array (
                        'status'    => 'success',
                        'file_link' => 'Image uploadé : ' . $file_name
                    );
                } else {
                    $response = array (
                        'status' => 'Erreur',
                        'info'   => 'Impossible d\'uploader l\'image... une erreur inconnue est survenue.'
                    );
                }

            } else {
                // A file with the same name is already here
                $response = array (
                    'status'    => 'Erreur',
                    'info'      => 'Une image avec un nom identique existe déjà !.',
                    'file_link' => 'Une image avec un nom identique existe déjà. [' . $file_name . ']'
                );
            }

        } else {
            $response = array (
                'status' => 'Erreur',
                'info'   => 'Le dossier de stockage d\'image n\'existe pas.'
            );
        }
    } else {
        $response = array (
            'status' => 'Erreur',
            'info'   => 'Aucun dossier avec ce nom.'
        );
    }

    // Return the response
    echo json_encode($response);
    exit;
}


// Remove file
if( $delete_file == 1 ){
    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

    $file_name = strtr( $_POST['target_file'], $unwanted_array );
    $file_path = $targetPath . $file_name;

    // Check if file is exists //// ON NE SUPPRIME PLUS
    /*if ( file_exists($file_path) ) {

        // Delete the file ///// PAS BESOIN DE SUPPRIMER
        //unlink($file_path); 

        // Be sure we deleted the file
        if ( !file_exists($file_path) ) {
            $response = array (
                'status' => 'Réussite',
                'info'   => 'Image supprimée - ' . strtr($file_name, $unwanted_array)
            );
        } else {
            // Check the directory's permissions
            $response = array (
                'status' => 'Erreur',
                'info'   => 'MERDE. On peut pas supprimer l\'image !'
            );
        }
    } else {
        // Something weird happend and we lost the file
        $response = array (
            'status' => 'Erreur',
            'info'   => 'Impossible de trouver l\'image - ' . strtr($file_name, $unwanted_array)
        );
    } */

    $response = array (
        'status' => 'Réussite',
        'info'   => 'Image supprimée - ' . strtr($file_name, $unwanted_array)
    );

    // Return the response
    echo json_encode($response);
    exit;
}
?>