<?php
class Shortcode_Contact_Form
{



	/**
	 * Form has error
	 *
	 * @var bool
	 */
	protected $error = FALSE;



	/**
	 * Form has error
	 *
	 * @var bool
	 */
	protected $errors;



	/**
	 * Form has error
	 *
	 * @var bool
	 */
	protected $submit = FALSE;



	/**
	 * Register hooks
	 *
	 **/
	public function __construct()
	{

		add_action( 'register_shortcode_ui', array( $this, 'register_ui' ) );
		add_action( 'init', array( $this, 'register_shortcode' ) );

	} // END __construct



	/**
	 * Check if field has error
	 *
	 * @param string $field Field name
	 * @return bool
	 */
	public function has_error( $field )
	{

		return isset( $this->errors[$field ] );

	} // END has_error



	/**
	 * Check for required fields
	 *
	 * @return bool
	 */
	public function is_valid()
	{

		if ( !isset( $_POST['contact-form-nonce'] ) || !wp_verify_nonce( $_POST['contact-form-nonce'], 'submit-contact-form' ) )
			return FALSE;

		$required = array(
			'contact-name',
			'contact-email',
			'contact-phone',
		);

		foreach ( $required as $r ) :

			if ( isset( $_POST[$r] ) && '' != $_POST[$r] )
				continue;

			$this->error = TRUE;
			$this->errors[] = $r;
			$this->submit = FALSE;

		endforeach;

		return !$this->error;

	} // END is_valid



	/**
	 * Register shortcode
	 *
	 **/
	public function register_shortcode()
	{

		add_shortcode( 'kontaktformular', array( $this, 'render' ) );

	} // END register_shortcode



	/**
	 * Register UI
	 *
	 **/
	public function register_ui()
	{

		shortcode_ui_register_for_shortcode( 'kontaktformular',
			array(
				/*
				 * How the shortcode should be labeled in the UI. Required argument.
				 */
				'label' => esc_html__( 'Kontaktformular', 'TEXTDOMAIN' ),
				/*
				 * Include an icon with your shortcode. Optional.
				 * Use a dashicon, or full URL to image.
				 */
				'listItemImage' => 'dashicons-email-alt',
				/*
				 * Register UI for attributes of the shortcode. Optional.
				 */
				'attrs' => array(
					array(
						'label'       => esc_html__( 'Betreff', 'TEXTDOMAIN' ),
						'attr'        => 'subject',
						'type'        => 'text',
						'meta'		  => array(
							'placeholder' => '[' . get_bloginfo( 'blogname' ) . '] ' . __( 'Kontaktformular', 'TEXTDOMAIN' ),
						)
					),
					array(
						'label'  => esc_html__( 'Absender', 'TEXTDOMAIN' ),
						'attr'   => 'from',
						'type'   => 'text',
						'meta'   => array(
							'placeholder' => get_bloginfo( 'blogname' ) . ' <' . sanitize_email( get_bloginfo( 'admin_email' ) ) . '>',
						),
					),
					array(
						'label'  => esc_html__( 'Empfänger', 'TEXTDOMAIN' ),
						'attr'   => 'to',
						'type'   => 'email',
						'meta'   => array(
							'placeholder' => get_option( 'admin_email' ),
						),
					),
					array(
						'label'  => esc_html__( 'Benachrichtigung', 'TEXTDOMAIN' ),
						'attr'   => 'success',
						'type'   => 'text',
						'meta'   => array(
							'placeholder' => __( 'Vielen Dank für Ihre Nachricht', 'TEXTDOMAIN' ),
						),
					),
				),
			)
		);

	} // END register_ui



	/**
	 * Render shortcode
	 *
	 * @access public
	 * @param array $atts Attributes
	 * @return string Output
	 */
	public function render( $atts )
	{

		$atts = shortcode_atts( array(
	        'subject' => '[' . get_bloginfo( 'blogname' ) . '] ' . __( 'Kontaktformular', 'TEXTDOMAIN' ),
	        'from' => get_bloginfo( 'blogname' ) . ' <' . sanitize_email( get_bloginfo( 'admin_email' ) ) . '>',
			'to' => get_option( 'admin_email' ),
			'success' => __( 'Vielen Dank für Ihre Nachricht', 'TEXTDOMAIN' ),
	    ), $atts );

		ob_start();

		if ( $this->is_valid() ) :
			$this->send_mail( $atts );
			?>
			<div class="response success">
				<p>
					<?php echo $atts['success'] ?>
				</p>
			</div>
			<?php
		endif;

		if ( $this->error || !$this->submit )
			$this->render_form();

		return ob_get_clean();

	} // END render


	/**
	 * Shortcode render
	 *
	 * @access public
	 * @return void
	 **/
	public function render_form()
	{

		?>

		<form class="contact-form" id="contact-form" method="post" action="#contact-form">

			<p>
				<label class="label--required" for="contact-name"><?php _e( 'Name', 'TEXTDOMAIN' ) ?></label>
				<input required type="text" name="contact-name" id="contact-name" value="">
				<?php if ( $this->has_error( 'contact-name' ) ) : ?><span class="input-error"><?php _e( 'Dies ist ein Pflichtfeld', 'TEXTDOMAIN' ) ?></span><?php endif; ?>
			</p>

			<p>
				<label class="label--required" for="contact-email"><?php _e( 'E-Mail', 'TEXTDOMAIN' ) ?></label>
				<input required type="email" name="contact-email" id="contact-email" value="">
				<?php if ( $this->has_error( 'contact-email' ) ) : ?><span class="input-error"><?php _e( 'Dies ist ein Pflichtfeld', 'TEXTDOMAIN' ) ?></span><?php endif; ?>
			</p>

			<p>
				<label class="label--required" for="contact-phone"><?php _e( 'Telefon', 'TEXTDOMAIN' ) ?></label>
				<input type="text" name="contact-phone" id="contact-phone" value="">
				<?php if ( $this->has_error( 'contact-phone' ) ) : ?><span class="input-error"><?php _e( 'Dies ist ein Pflichtfeld', 'TEXTDOMAIN' ) ?></span><?php endif; ?>
			</p>

			<p class="submit">
				<button type="submit"><?php _e( 'Absenden', 'TEXTDOMAIN' ) ?></button>
			</p>

			<?php wp_nonce_field( 'submit-contact-form', 'contact-form-nonce' ) ?>

		</form>

		<?php

	} // END render_form



	/**
	 * Send form
	 *
	 * @param array $atts Attributes
	 * @return bool
	 */
	public function send_mail( $atts )
	{

		if ( TRUE === $this->submit )
			return;

		$headers = "FROM:" . $atts['from'] . "\n";
		$headers.= "REPLY-TO: " . sanitize_text_field( $_POST['contact-name'] ) . ' <' . sanitize_email( $_POST['contact-email'] ) . '>' . "\n";
		$recipient = $atts['to'];
		$subject = $atts['subject'];

		$text = "# Anschrift\n";
		$text .= "Name: " .  sanitize_text_field( $_POST['contact-name'] ) . "\n";
		$text .= "Telefon: " .  sanitize_text_field( $_POST['contact-phone'] ) . "\n";
		$text .= "E-Mail: " .  sanitize_text_field( $_POST['contact-email'] ) . "\n";
		$text .= "Beschreibung:\n " .  esc_html( $_POST['contact-message'] ) . "\n";

		$this->submit = TRUE;

		wp_mail( sanitize_email( $_POST['contact-email'] ), $subject, "Vielen Dank für Ihre Nachricht,\n\nhiermit erhalten Sie eine Kopie Ihrer Anfrage.\n\n" . $text, $headers );
		wp_mail( $recipient, $subject, $text, $headers );

		return TRUE;

	} // END send_mail



} // END class Shortcode_Contact_Form

new Shortcode_Contact_Form;
