<?php
/**
 * Pattern content.
 */
return array(
	'title'      => __( 'Sociatic Core Archive', 'sociatic' ),
	'categories' => array( 'sociatic-core' ),
	'content'    => '<!-- wp:group {"style":{"spacing":{"margin":{"top":"0px","bottom":"0px"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:0px;margin-bottom:0px"><!-- wp:cover {"url":"' . esc_url( trailingslashit( get_template_directory_uri() ) ) . 'assets/img/hero-page-bg-core.webp","id":3800,"dimRatio":0,"isDark":false} -->
<div class="wp-block-cover is-light"><img class="wp-block-cover__image-background wp-image-3800" alt="" src="' . esc_url( trailingslashit( get_template_directory_uri() ) ) . 'assets/img/hero-page-bg-core.webp" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"margin":{"top":"50px"}}},"layout":{"type":"constrained","contentSize":"1190px"}} -->
<div class="wp-block-group" style="margin-top:50px"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"80%"} -->
<div class="wp-block-column" style="flex-basis:80%"><!-- wp:query-title {"type":"archive","showPrefix":false,"className":"sociatic-animate sociatic-move-up sociatic-delay-1","style":{"typography":{"fontStyle":"normal","fontWeight":"800","lineHeight":"1.1"}},"textColor":"gv-color-text-primary","fontSize":"heading-page","fontFamily":"mulish"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%"} -->
<div class="wp-block-column" style="flex-basis:20%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->',
	'is_sync' => false,
);
