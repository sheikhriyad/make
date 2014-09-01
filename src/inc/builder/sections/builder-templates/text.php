<?php
/**
 * @package Make
 */

ttfmake_load_section_header();

global $ttfmake_section_data, $ttfmake_is_js_template;
$section_name   = ttfmake_get_section_name( $ttfmake_section_data, $ttfmake_is_js_template );
$columns_number = ( isset( $ttfmake_section_data['data']['columns-number'] ) ) ? $ttfmake_section_data['data']['columns-number'] : 3;
$section_order  = ( ! empty( $ttfmake_section_data['data']['columns-order'] ) ) ? $ttfmake_section_data['data']['columns-order'] : range(1, 4);
$columns_class  = ( in_array( $columns_number, range( 1, 4 ) ) && true !== $ttfmake_is_js_template ) ? $columns_number : 3;
?>

<?php if ( false === ttfmake_is_plus() ) : ?>
<div class="ttfmake-plus-info">
	<p>
		<em>
		<?php
		printf(
			__( '%s and convert any column into an area for widgets.', 'make' ),
			sprintf(
				'<a href="%1$s" target="_blank">%2$s</a>',
				esc_url( ttfmake_get_plus_link( 'widget-area' ) ),
				sprintf(
					__( 'Upgrade to %s', 'make' ),
					'Make Plus'
				)
			)
		);
		?>
		</em>
	</p>
</div>
<?php endif; ?>

<?php do_action( 'ttfmake_section_text_before_columns_select', $ttfmake_section_data ); ?>
<?php do_action( 'ttfmake_section_text_after_columns_select', $ttfmake_section_data ); ?>
<?php do_action( 'ttfmake_section_text_after_title', $ttfmake_section_data ); ?>

<div class="ttfmake-text-columns-stage ttfmake-text-columns-<?php echo $columns_class; ?>">
	<?php $j = 1; foreach ( $section_order as $key => $i ) : ?>
	<?php
		$column_name = $section_name . '[columns][' . $i . ']';
		$iframe_id   = 'ttfmake-iframe-' . $i;
		$textarea_id = 'ttfmake-content-' . $i;
		$link        = ( isset( $ttfmake_section_data['data']['columns'][ $i ]['image-link'] ) ) ? $ttfmake_section_data['data']['columns'][ $i ]['image-link'] : '';
		$image_id    = ( isset( $ttfmake_section_data['data']['columns'][ $i ]['image-id'] ) ) ? $ttfmake_section_data['data']['columns'][ $i ]['image-id'] : 0;
		$title       = ( isset( $ttfmake_section_data['data']['columns'][ $i ]['title'] ) ) ? $ttfmake_section_data['data']['columns'][ $i ]['title'] : '';
		$content     = ( isset( $ttfmake_section_data['data']['columns'][ $i ]['content'] ) ) ? $ttfmake_section_data['data']['columns'][ $i ]['content'] : '';
	?>
	<div class="<?php echo esc_attr( apply_filters( 'ttfmake-text-column-classes', 'ttfmake-text-column ttfmake-text-column-position-' . $j, $i, $ttfmake_section_data ) ); ?>" data-id="<?php echo $i; ?>">
		<div title="<?php esc_attr_e( 'Drag-and-drop this column into place', 'make' ); ?>" class="ttfmake-sortable-handle">
			<div class="sortable-background"></div>
		</div>

		<?php do_action( 'ttfmake_section_text_before_column', $ttfmake_section_data, $i ); ?>

		<div class="ttfmake-titlediv">
			<div class="ttfmake-titlewrap">
				<input placeholder="<?php esc_attr_e( 'Enter title here', 'make' ); ?>" type="text" name="<?php echo $column_name; ?>[title]" class="ttfmake-title ttfmake-section-header-title-input" value="<?php echo esc_attr( htmlspecialchars( $title ) ); ?>" autocomplete="off" />
				<a href="#" class="convert-to-widget-link">
					<?php _e( 'Convert column to widget area', 'make' ); ?>
				</a>
				<a href="#" class="edit-content-link" data-textarea="<?php echo $textarea_id; ?>" data-iframe="<?php echo $iframe_id; ?>">
					<?php _e( 'Edit content', 'make' ); ?>
				</a>
			</div>
		</div>

		<?php ttfmake_get_builder_base()->add_uploader( $column_name, ttfmake_sanitize_image_id( $image_id ) ); ?>

		<div class="ttfmake-iframe-wrapper">
			<div class="ttfmake-iframe-overlay">
				<a href="#" class="edit-content-link" data-textarea="<?php echo $textarea_id; ?>" data-iframe="<?php echo $iframe_id; ?>">
					<span class="screen-reader-text">
						<?php _e( 'Edit content', 'make' ); ?>
					</span>
				</a>
			</div>
			<iframe width="100%" height="300" id="<?php echo $iframe_id; ?>"></iframe>
		</div>
		<textarea id="<?php echo $textarea_id; ?>" name="<?php echo $column_name; ?>[content]" style="display:none;"><?php echo esc_textarea( $content ); ?></textarea>

		<?php if ( true !== $ttfmake_is_js_template ) : ?>
		<script type="text/javascript">
			(function($){
				var iframe = document.getElementById('ttfmake-iframe-<?php echo $i; ?>'),
					iframeContent = iframe.contentDocument ? iframe.contentDocument : iframe.contentWindow.document,
					iframeBody = $('body', iframeContent),
					content = $('#ttfmake-content-<?php echo $i; ?>').val();

				iframeBody.html(content);
			})(jQuery);
		</script>
		<?php endif; ?>

		<?php do_action( 'ttfmake_section_text_after_column', $ttfmake_section_data, $i ); ?>
	</div>
	<?php $j++; endforeach; ?>
</div>

<?php do_action( 'ttfmake_section_text_after_columns', $ttfmake_section_data ); ?>

<div class="clear"></div>

<input type="hidden" value="<?php echo esc_attr( implode( ',', $section_order ) ); ?>" name="<?php echo $section_name; ?>[columns-order]" class="ttfmake-text-columns-order" />
<input type="hidden" class="ttfmake-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttfmake_section_data['data']['state'] ) ) echo esc_attr( $ttfmake_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttfmake_load_section_footer();