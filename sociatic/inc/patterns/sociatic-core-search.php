<?php
/**
 * Pattern content.
 */
return array(
	'title'      => __( 'Sociatic Core Search', 'sociatic' ),
	'categories' => array( 'sociatic-core' ),
	'content'    => '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:cover {"url":"' . esc_url( SOCIATIC_URI ) . 'assets/img/hero-page-bg-core.webp","id":3800,"dimRatio":0,"isDark":false} -->
<div class="wp-block-cover is-light"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-3800" alt="" src="' . esc_url( SOCIATIC_URI ) . 'assets/img/hero-page-bg-core.webp" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"margin":{"top":"50px"}}},"layout":{"type":"constrained","contentSize":"1190px"}} -->
<div class="wp-block-group" style="margin-top:50px"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"80%"} -->
<div class="wp-block-column" style="flex-basis:80%"><!-- wp:query-title {"type":"search","showSearchTerm":false,"style":{"typography":{"fontStyle":"normal","fontWeight":"800","lineHeight":"1.2"}},"textColor":"theme-1","className":" sociatic-animate sociatic-move-up sociatic-delay-1","fontSize":"heading-page","fontFamily":"mulish"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"20%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:20%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->',
);
