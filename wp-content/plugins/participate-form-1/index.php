<?php
/*
* Plugin Name: Participate form 1
* Description: Add form in participate section
* Version: 1.0
* Author: Daniel Arribas
* License: GNU
*/





/*
 * ------------------
 * Legal terms module
 * ------------------
 * 
 * Show a textarea for insert additional text independent to the post description
 * The textarea content is saved when the save_post event is released [table: postmeta, field: legal_terms]
 * Only visible for "PREMIOS" category
 */

function add_legal_terms() {
    // Get category of the post. If belongs to PREMIOS (17) category, show it
    $postCategory = get_the_category($post->ID);
    if($postCategory[0]->term_id == 17)
        add_meta_box( 'legal_terms', 'Cómo canjeo mi premio', 'add_new_field', 'post', 'normal', 'high' );
}

add_action( 'add_meta_boxes', 'add_legal_terms' );


function add_new_field( $post )
{
    $values = get_post_custom( $post->ID );
    if ( isset( $values['legal_terms'] ) ) {
        $legal_terms_text = esc_attr( $values['legal_terms'][0] );
    }
    wp_nonce_field( 'my_legal_terms_nonce', 'legal_terms_nonce' );

?>
<table class="form-table">
<tr valign="top">
<td><textarea rows="10" cols="100" name="legal_terms"><?php echo $legal_terms_text; ?></textarea></td>
</tr>
</table>

<?php
} // close add_new_field function


function legal_terms_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['legal_terms_nonce'] ) || !wp_verify_nonce( $_POST['legal_terms_nonce'], 'my_legal_terms_nonce' ) ) return;

    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;

    // Make sure your data is set before trying to save it
    if( isset( $_POST['legal_terms'] ) ) {
        update_post_meta( $post_id, 'legal_terms', wp_kses( $_POST['legal_terms']) );
    }    
}

add_action( 'save_post', 'legal_terms_save' );





/*
 * ------------------------
 * Points from prize module
 * ------------------------
 * 
 * Show a input text for insert a number
 * The value is saved when the save_post event is released [table: postmeta, field: _premios_price]
 * Only visible for "PREMIOS" category
 */

function add_prize_points() {
    // Get category of the post. If belongs to PREMIOS (17) category, show it
    $postCategory = get_the_category($post->ID);
    if($postCategory[0]->term_id == 17)
        add_meta_box( 'prize_points', 'Asignar puntos a este premio', 'add_new_field_prize_points', 'post', 'normal', 'high' );
}

add_action( 'add_meta_boxes', 'add_prize_points' );


function add_new_field_prize_points( $post ) {
    wp_nonce_field( 'prize_points_nonce', 'prize_points_nonce' );  // Create hide field
    $value = get_post_meta( $post->ID, '_premios_price', true );
    $prize_points_value = esc_attr($value);

    ?>
    Introduce el numero de puntos que vale este premio (seran restados de la cuenta del usuario)
    <input type="text" id="prize_points" name="prize_points" value="<?php echo $prize_points_value; ?>" /> puntos
    <?php
    
}


function prize_points_save( $post_id ) {
    // Check if our nonce is set.
    if ( ! isset( $_POST['prize_points_nonce'] ) ) return;
    
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['prize_points_nonce'], 'prize_points_nonce' ) ) return;
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    
    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) return;
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    }

    // Make sure that it is set.
    if( isset( $_POST['prize_points'] ) ) {
        $my_data = sanitize_text_field( $_POST['prize_points'] );
        update_post_meta( $post_id, '_premios_price', $my_data );
    }
    
}

add_action( 'save_post', 'prize_points_save' );





/*
 * --------------------------
 * Vouchers from prize module
 * --------------------------
 * 
 * Show a input text for insert a number, input file for upload .xls and .xlsx files, list of available codes (uploaded or generated previously) and list of codes spent
 * The number value and file content is saved when the save_post event is released [table: posts_avaible]
 * The number generate as many codes as indicated value. If the value is less than amount shown, the last records are eliminated up to that value
 * The file must be .xls or .xlsx type, and contain a single column with the codes to insert. These codes will be added to the table
 * Only visible for "PREMIOS" category
 */

function add_vouchers_from_prize() {
    // Get category of the post. If belongs to PREMIOS (17) category, show it
    $postCategory = get_the_category($post->ID);
    if($postCategory[0]->term_id == 17)
        add_meta_box( 'vouchers_from_prize', 'Vales disponibles para solicitar el premio', 'add_new_vouchers', 'post', 'normal', 'high' );
}

add_action( 'add_meta_boxes', 'add_vouchers_from_prize' );


/*
 * Function add_new_vouchers
 * @param $post
 * 
 * Shows in a text box the number of vouchers available for this prize (editable)
 * Input type file for push a excel file with codes
 * Listed with the prize codes generated (not spent)
 * Listed with the prize codes spent, user and date
 */
function add_new_vouchers( $post ) {
    global $wpdb;
    
    // Get number of avaible prizes
    $resultQPS = $wpdb->get_results( "SELECT COUNT(id) FROM wp_3_posts_avaible WHERE post_id = ".$post->ID." AND active = 1 LIMIT 1", ARRAY_N );
    $totalVouchers = !empty($resultQPS[0][0]) ? $resultQPS[0][0] : 0;
    $totalVouchers_text = esc_attr( $totalVouchers );
    
    wp_nonce_field( 'my_vouchers_from_prize_nonce', 'vouchers_from_prize_nonce' );

    ?>

    <div style="display: block; width: 100%; height: 10px;"></div>
    
    <div style="display: inline-table; width: 45%;">
        <input type="text" id="vouchers_input" name="vouchers_input" value="<?php echo $totalVouchers_text; ?>" />
        <img src="wp-content/plugins/aditionals-data-post/images/info.png" style="width: 22px; cursor: pointer;" alt="Ver ayuda para introducir vales" title="Ver ayuda para introducir vales" onclick="openHelpBox('insertVouchersHelpBox');" />
        <div id="insertVouchersHelpBox" style="display: none; position: absolute; margin: 4px 0 0 0; padding: 6px; background-color: #FFF; border: 1px #999 solid; border-radius: 6px; font-size: 10px;">
            <div style="position: absolute; right: 10px; padding: 0 5px; cursor: pointer;" title="Cerrar ayuda" onclick="openHelpBox('insertVouchersHelpBox');">X</div>
            Vales disponibles para este premio (solo los activos). <br />
            Si se incrementa su valor, se añadirán tantos vales hasta la cantidad indicada (generando automáticamente su código). <br />
            Si se decrementa su valor, se eliminarán vales hasta la cantidad indicada, empezando por el último vale generado.
        </div>
    </div>
    <div style="display: inline-table; width: 45%; margin-left: 5%;">
        <form id="vouchers_file_form" name="vouchers_file_form" method="post">
            <input type="hidden" id="post_id_upl" name="post_id_upl" value="<?php echo $post->ID; ?>" />
            <input type="file" id="vouchers_file" name="vouchers_file" />
        </form>
        <div id="vouchers_file_msg" style="display: none; padding: 5px 10px;"></div>
        <img src="wp-content/plugins/aditionals-data-post/images/info.png" style="width: 22px; cursor: pointer;" alt="Ver ayuda para subir ficheros con códigos" title="Ver ayuda para subir ficheros con códigos" onclick="openHelpBox('insertCodesHelpBox');" />
        <div id="insertCodesHelpBox" style="display: none; position: absolute; margin: 4px 0 0 0; padding: 6px; background-color: #FFF; border: 1px #999 solid; border-radius: 6px; font-size: 10px;">
            <div style="position: absolute; right: 10px; padding: 0 5px; cursor: pointer;" title="Cerrar ayuda" onclick="openHelpBox('insertCodesHelpBox')">X</div>
            Subir códigos de vales asociados a este premio. <br />
            Para subir códigos de vales, se puede subir un fichero .xls o .xlsx con el siguiente formato: COLUMNA 1 - Códigos de los vales (no incluir cabecera ni títulos) <br />
            Cada código del fichero generará un nuevo vale
            Puede ver un ejemplo de fichero <a href="wp-content/uploads/aditionals-data-post/template/excel-example.xls" title="" target="_blank">aquí</a>
        </div>
        <input type="button" id="upload_vouchers_file" name="upload_vouchers_file" value="SUBIR CÓDIGOS" onclick="uploadCodesFile()" />
    </div>
    
    <div style="display: block; width: 100%; height: 10px;"></div>
    
    <?php
    
    // Get code of avaible prizes
    $resultQPS = $wpdb->get_results( "SELECT code, active, user_id, finish_date FROM wp_3_posts_avaible WHERE post_id = ".$post->ID." ORDER BY code", ARRAY_N );
    
    $activeCodeLine = $inactiveCodeLine = '';
    foreach($resultQPS as $keyPS => $valPS) {
        $ps_code = !empty($valPS[0]) ? $valPS[0] : '';
        $ps_active = !empty($valPS[1]) ? $valPS[1] : '';
        $ps_user_id = !empty($valPS[2]) ? $valPS[2] : '';
        $ps_finish_date = !empty($valPS[3]) ? $valPS[3] : '';
        
        if($ps_active == 1) {
            $activeCodeLine .= '<tr valign="top">';
            $activeCodeLine .= '<td style="margin: 0; padding: 5px 0 0 10px;">'.esc_attr($ps_code).'</td>';
            $activeCodeLine .= '</tr>';
        } else {
            if(!empty($ps_user_id)) {
                // Get user data
                $resultQU = $wpdb->get_results( "SELECT display_name FROM wp_users WHERE ID = ".$ps_user_id." LIMIT 1", ARRAY_N );
                $user_display_name = !empty($resultQU[0][0]) ? $resultQU[0][0] : '';

                // Reset date (server save date with 2 hours less)
                if(!empty($ps_finish_date)) {
                    $reset_finish_date = strtotime('+2 hour', strtotime($ps_finish_date));
                    $finish_date_upg = date('d/m/Y H:i:s', $reset_finish_date);
                } else
                    $finish_date_upg = '';

                $inactiveCodeLine .= '<tr valign="top">';
                $inactiveCodeLine .= '<td style="margin: 0; padding: 5px 0 0 10px; color: #B40404;">'.esc_attr($ps_code).'</td>';
                $inactiveCodeLine .= '<td style="margin: 0; padding: 5px 0 0 20px; color: #B40404;">'.esc_attr($user_display_name).'</td>';
                $inactiveCodeLine .= '<td style="margin: 0; padding: 5px 0 0 20px; color: #B40404;">'.esc_attr($finish_date_upg).'</td>';
                $inactiveCodeLine .= '</tr>';
            }
        }
    }
    
    // Show active codes list
    if(!empty($activeCodeLine)) {
        
        ?>
        <div style="display: inline-table; width: 45%;">
            <table class="form-table">
                <thead style="max-height: 300px; overflow: auto; width: 100%; display: inline-block;">
                    <tr valign="top">
                        <th style="margin: 0; padding: 5px 0 0 10px; font-weight: 700;">Códigos activos</th>
                    </tr>
                </thead>
                <tbody style="max-height: 300px; overflow: auto; width: 100%; display: inline-block;">
                    <?php echo $activeCodeLine; ?>
                </tbody>
            </table>
        </div>
        <?php
        
    }
    
    // Show spent codes list
    if(!empty($inactiveCodeLine)) {
        
        ?>
        <div style="display: inline-table; width: 45%; margin-left: 5%;">
            <table class="form-table">
                <thead style="max-height: 300px; overflow: auto; width: 100%; display: inline-block;">
                    <tr valign="top">
                        <th style="margin: 0; padding: 5px 0 0 10px; font-weight: 700;">Códigos gastados</th>
                        <th style="margin: 0; padding: 5px 0 0 20px; font-weight: 700;">Usuario</th>
                        <th style="margin: 0; padding: 5px 0 0 20px; font-weight: 700;">Fecha envío</th>
                    </tr>
                </thead>
                <tbody style="max-height: 300px; overflow: auto; width: 100%; display: inline-block;">
                    <?php echo $inactiveCodeLine; ?>
                </tbody>
            </table>
        </div>
        <?php
        
    }
    
    ?>
    <script>
        function openHelpBox(idDiv) {
            if(document.getElementById(idDiv).style.display == 'none') {
                document.getElementById(idDiv).style.display = 'block';
                setTimeout(function() {
                    document.getElementById(idDiv).style.display = 'none';
                }, 4000);
            } else {
                document.getElementById(idDiv).style.display = 'none';
            }
        }

        function openVoucherFileMsg(message) {
            document.getElementById('vouchers_file_msg').innerHTML = message;
            document.getElementById('vouchers_file_msg').style.display = 'block';
            setTimeout(function() {
                document.getElementById('vouchers_file_msg').style.display = 'none';
            }, 4000);
        }

        function uploadCodesFile() {
            // Validate input file
            if(document.getElementById('vouchers_file').value != '') {

                // Get form object and construct FormData
                //      fileUp contains the file (received with $_FILES)
                //      dataUp contains the rest of the form data (received with $_REQUEST / $_POST)
                var form = jQuery('#vouchers_file_form')[0];
                var formData = new FormData(form);
                formData.append("fileUp", jQuery('input[type=file]')[0].files[0]);
                formData.append("postId", jQuery('#post_id_upl').val());

                // Upload file
                jQuery.ajax({
                    url: "wp-content/plugins/aditionals-data-post/inc/upload-vouchers.php",
                    method: "POST",
                    type: "POST",
                    dataType: "html",
                    contentType: "multipart/form-data",
                    processData: false,
                    contentType: false,
                    data: formData,
                    cache: false,
                    success: function(data) {
                        var dataDecod = JSON.parse(data);
                        if(dataDecod['result'] == 'success') {
                            if(dataDecod['message'] != "undefined")
                                openVoucherFileMsg('<span style="color: green;">'+dataDecod['message']+'</span>');
                            else
                                openVoucherFileMsg('<span style="color: green;">Subida completada, la página se recargará en unos segundos.</span>');
                            //-- window.location.reload();
                        } else {
                            // Error message
                            if(dataDecod['message'] != "undefined")
                                openVoucherFileMsg('<span style="color: red;">Ha ocurrido un error en la subida del archivo.<br />'+dataDecod['message']+'</span>');
                            else
                                openVoucherFileMsg('<span style="color: red;">Ha ocurrido un error en la subida del archivo</span>');
                        }
                    },
                    error: function() {
                        // Error message
                        openVoucherFileMsg('<span style="color: red;">Ha ocurrido un error en la subida del archivo.<br />Por favor, revise el fichero para que el formato sea correcto</span>');
                    }
                });

            } else {
                // Warning message
                openVoucherFileMsg('<span style="color: red;">Debe adjuntar un fichero .xls o .xlsx</span>');
            }
        }
    </script>
    <?php
    
}


/*
 * Function vouchers_from_prize_save
 * @param $post_id
 * 
 * Create or delete vouchers
 * If the number of vouchers entered is greater than the number of avaible vouchers, inserts a new voucher up to the indicate value
 * If the number of vouchers entered is less than the number of avaible vouchers, delete the avaible vouchers up to the indicate value
 */
function vouchers_from_prize_save( $post_id ) {
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['vouchers_from_prize_nonce'] ) || !wp_verify_nonce( $_POST['vouchers_from_prize_nonce'], 'my_vouchers_from_prize_nonce' ) ) return;

    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;

    // Make sure your data is set before trying to save it
    if( isset( $_POST['vouchers_input'] ) ) {
        global $wpdb;
        
        $vouchers_input = (int) $_POST['vouchers_input'];
        
        // Get number of avaible prizes
        $resultQPS = $wpdb->get_results( "SELECT COUNT(id) FROM wp_3_posts_avaible WHERE post_id = ".$post_id." AND active = 1 LIMIT 1", ARRAY_N );
        $totalVouchers = !empty($resultQPS[0][0]) ? $resultQPS[0][0] : 0;

        // Subtract number of actual vouchers to inserted vouchers
        $vouchersResult = $vouchers_input - $totalVouchers;

        if($vouchersResult > 0) {
            // Get code of avaible prizes
            $resultQPS2 = $wpdb->get_results( "SELECT code FROM wp_3_posts_avaible WHERE post_id = ".$post_id." AND active = 1 ORDER BY code DESC LIMIT 1", ARRAY_N );
            $codeAP = !empty($resultQPS2[0][0]) ? $resultQPS2[0][0] : '';
            
            for($cntF = 1; $cntF <= $vouchersResult; $cntF++) {
                
                if(!empty($codeAP)) {
                    $lastCode = explode('-', $codeAP);
                    $incrementCode = $lastCode[1] + $cntF;
                } else {
                    $incrementCode = $cntF;
                }
                
                $sufx = 0;
                for($a = strlen($cntF); $a < 5; $a++) {
                    $sufx .= '0';
                }
                
                // Code format: ID_PRIZE-XXXXXX
                $code = $post_id.'-'.$sufx.$incrementCode;
                
                $wpdb->insert( 'wp_3_posts_avaible', array( 'post_id' => $post_id, 'code' => $code ) );
            }
        }

        if($vouchersResult < 0) {
            $vouchersResult = $totalVouchers - $vouchers_input;
            for($cntF = 1; $cntF <= $vouchersResult; $cntF++) {
                $resultQPS = $wpdb->get_results( "SELECT id FROM wp_3_posts_avaible WHERE post_id = ".$post_id." AND active = 1 ORDER BY id DESC LIMIT 1", ARRAY_N );
                $voucherId = !empty($resultQPS[0][0]) ? $resultQPS[0][0] : 0;
                //$wpdb->update( 'wp_3_posts_avaible', array('active' => 0), array( 'id' => $voucherId ) );
                $wpdb->delete( 'wp_3_posts_avaible', array( 'id' => $voucherId ) );
            }
        }
        
    }
}

add_action( 'save_post', 'vouchers_from_prize_save' );


?>