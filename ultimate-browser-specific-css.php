<?php
/*
Plugin Name: Ultimate Browser Specific Css
Version: 1.0
Plugin URI: http://www.idiotinside.com/
Description: javascript plugin that helps you to write Browser specific css on your wordpress website
Author: sureshdsk
Author URI: http://profiles.wordpress.org/sureshdsk/
*/

register_activation_hook(__FILE__, 'bsc_install');
register_uninstall_hook(__FILE__, 'bsc_uninstall'); 
function bsc_install() {
//INSTALL 

$data = array( 'bsc_position' => '1','bsc_style' => ' /* custom css */ ' );
    if ( ! get_option('bsc_data')){
      add_option('bsc_data' , $data);
    } else {
      update_option('bsc_data' , $data);
    }
	
}
function bsc_uninstall() {
//UNINSTALL 

/* delete_option('bsc_data'); */

}


add_action('admin_menu', 'bsc_menu');
function bsc_menu() {
add_menu_page('Browser Specific Css','Browser Specific Css', 'administrator', 'bsc-options', 'bsc_control');
}
function bsc_control(){ 
//settings page
$data = get_option('bsc_data');

if (isset($_POST['bsc_updatedata'])) {

$bsc_style = htmlspecialchars($_POST['bsc_style'], ENT_QUOTES); echo "<br>";
$newdata = array( 'bsc_position' => $_POST['bsc_position'] ,'bsc_style' => $bsc_style );
echo '<div id="message" class="updated"><p><strong>';

	 update_option('bsc_data',$newdata);
        echo 'Settings Updated!';
		echo '</strong></p></div>';
		echo "<script>self.location='admin.php?page=bsc-options';</script>";
}


?>
<div id="icon-themes" class="icon32"><br></div>

    <h2>Ultimate Browser Specific Css </h2>
		 <form method="post" action="">

        <p>
            <label>
                Write your css <br>
                <textarea name="bsc_style" rows="15" cols="100"><?php echo stripslashes($data['bsc_style']);  ?></textarea>
            </label>
        </p>

         <p>
            <label>
               Load style in header/footer <br>
               <select name="bsc_position"><option value="1" <?php if ($data['bsc_position']=='1') { echo 'selected'; } ?>>Header</option>
<option value="0"<?php if ($data['bsc_position']=='0') { echo 'selected'; } ?>>Footer</option></select>
            </label>
        </p>

        <p>
            <input type="hidden" name="bsc_updatedata" value="1" />
            <input type="submit" value="Save" class="button button-primary">
        </p>

    </form>
	
<?php
}

function bsc_script(){


wp_enqueue_script('browser-specific-css',plugin_dir_url(__FILE__) . 'script/brower-specific-css.js');


}
add_action('wp_enqueue_scripts','bsc_script');

function bsc_custom_styles() {
$datah = get_option('bsc_data');

   $out='<style type="text/css">';
   
  $out .= stripslashes($datah['bsc_style']);
   $out .= '</style>';
   
   echo $out;
}
add_action( 'wp_head', 'bsc_custom_styles' );
$bscdata = get_option('bsc_data');
if ($bscdata['bsc_position']=='1') {
remove_action('wp_footer', 'bsc_custom_styles', 100);
add_action( 'wp_head', 'bsc_custom_styles' );


}
else  {
remove_action( 'wp_head', 'bsc_custom_styles' );
add_action('wp_footer', 'bsc_custom_styles', 100);


}



?>
