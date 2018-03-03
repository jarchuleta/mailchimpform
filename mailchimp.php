<?php
   /*
   Plugin Name: MailChimpForm
   Plugin URI:
   description: >-
  a plugin to create awesomeness and spread joy
   Version: 1.0
   Author: James Archuleta
   Author URI: http://jamesarchuleta.com
   License: GPL2
   */


$api_key = 'API_HERE';
$list_id='list_id';

add_shortcode('test', 'form_creation');
add_action( 'admin_post_nopriv_mail_chimp_form', 'prefix_send_email_to_admin' );
add_action( 'admin_post_mail_chimp_form', 'prefix_send_email_to_admin' );



function my_action_javascript() { ?>
	<?php
}

// Example 1 : WP Shortcode to display form on any page or post.
function form_creation($vars){
    ?>
      <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
      First Name: <input type="text" name="firstname"><br>
      Last Name: <input type="text" name="lastname"><br>
      Email Address: <input type="text" name="email"><br>
      <input type="hidden" name="action" value="mail_chimp_form">
      <input type="submit" />
      </form>

      ]
<?php
}

function prefix_send_email_to_admin(){
  print_r($_POST);

  include("vendor/autoload.php");

  use \DrewM\MailChimp\MailChimp;

  $MailChimp = new MailChimp($api_key);

  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $first = $_POST['firstname']; // needs validation
  $last = $_POST['lastname']; // needs validation

  if ($email){
    $result = $MailChimp->post("lists/$list_id/members", [
    				'email_address' => $email,
    				'status'        => 'subscribed',
            'merge_fields' => ['FNAME'=>$first, 'LNAME'=>$last],
    			]);
  }


}



?>
