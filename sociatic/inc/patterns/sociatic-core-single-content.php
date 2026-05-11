<?php
/**
 * Pattern content.
 */
return array(
	'title'      => __( 'Sociatic Core Single Content', 'sociatic' ),
	'categories' => array( 'sociatic-core' ),
	'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"100px","right":"20px","bottom":"100px","left":"20px"}}},"layout":{"type":"constrained","contentSize":"1190px"}} -->
<div class="wp-block-group" style="padding-top:100px;padding-right:20px;padding-bottom:100px;padding-left:20px"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"50px","left":"50px"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:post-featured-image {"height":"500px","style":{"border":{"radius":"20px"}}} /-->

<!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:post-content {"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":"1.5"}},"fontFamily":"hind-siliguri"} /-->

<!-- wp:columns {"style":{"spacing":{"margin":{"top":"50px","bottom":"40px"},"padding":{"bottom":"40px"}},"border":{"bottom":{"color":"var:preset|color|theme-13","width":"1px"}}}} -->
<div class="wp-block-columns" style="border-bottom-color:var(--wp--preset--color--theme-13);border-bottom-width:1px;margin-top:50px;margin-bottom:40px;padding-bottom:40px"><!-- wp:column {"verticalAlignment":"center","style":{"spacing":{"padding":{"bottom":"10px","top":"10px"}}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="padding-top:10px;padding-bottom:10px"><!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"18px","lineHeight":"1.1","fontStyle":"normal","fontWeight":"700"}},"textColor":"theme-2","fontFamily":"mulish"} -->
<h4 class="wp-block-heading has-theme-2-color has-text-color has-mulish-font-family" style="font-size:18px;font-style:normal;font-weight:700;line-height:1.1">Category :</h4>
<!-- /wp:heading -->

<!-- wp:post-terms {"term":"post_tag","style":{"elements":{"link":{"color":{"text":"var:preset|color|theme-2"}}},"typography":{"fontSize":"18px","fontStyle":"normal","fontWeight":"400","lineHeight":"1"}},"textColor":"theme-0","fontFamily":"hind-siliguri"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"style":{"spacing":{"blockGap":"20px"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"right","level":4,"style":{"typography":{"fontSize":"18px","lineHeight":"1.1","fontStyle":"normal","fontWeight":"700"}},"textColor":"theme-2","fontFamily":"mulish"} -->
<h4 class="wp-block-heading has-text-align-right has-theme-2-color has-text-color has-mulish-font-family" style="font-size:18px;font-style:normal;font-weight:700;line-height:1.1">Share This :</h4>
<!-- /wp:heading -->

<!-- wp:social-links {"iconColor":"white","iconColorValue":"#ffffff","iconBackgroundColor":"theme-6","iconBackgroundColorValue":"#fc7629","size":"has-small-icon-size","style":{"spacing":{"blockGap":{"top":"15px","left":"15px"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<ul class="wp-block-social-links has-small-icon-size has-icon-color has-icon-background-color"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /-->

<!-- wp:social-link {"url":"#","service":"twitter"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:post-comments-form {"textColor":"theme-1","className":"wp-block-post-comments"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:group {"style":{"spacing":{"padding":{"top":"40px","right":"40px","bottom":"40px","left":"40px"},"margin":{"bottom":"40px"}}},"className":"is-style-customboxshadow ","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-customboxshadow" style="margin-bottom:40px;padding-top:40px;padding-right:40px;padding-bottom:40px;padding-left:40px"><!-- wp:heading {"level":4,"style":{"typography":{"lineHeight":"1.2","fontStyle":"normal","fontWeight":"800"},"spacing":{"margin":{"bottom":"30px"}}},"textColor":"theme-1","fontSize":"heading-4","fontFamily":"mulish"} -->
<h4 class="wp-block-heading has-theme-1-color has-text-color has-mulish-font-family has-heading-4-font-size" style="margin-bottom:30px;font-style:normal;font-weight:800;line-height:1.2">Popular Post</h4>
<!-- /wp:heading -->

<!-- wp:query {"queryId":35,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"default"}} -->
<!-- wp:post-title {"level":6,"isLink":true,"style":{"typography":{"fontSize":"18px","lineHeight":"1.5","fontStyle":"normal","fontWeight":"800"},"spacing":{"margin":{"bottom":"10px"}}},"textColor":"theme-1","fontFamily":"mulish"} /-->

<!-- wp:post-date {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400","lineHeight":"1.3"}},"textColor":"theme-14","fontFamily":"hind-siliguri"} /-->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"40px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-bottom:40px"><!-- wp:cover {"url":"' . esc_url( SOCIATIC_URI ) . 'assets/img/popup-core-bg.webp","id":3880,"dimRatio":0,"minHeight":200,"isDark":false,"style":{"spacing":{"padding":{"top":"40px","right":"40px","bottom":"40px","left":"40px"}}},"className":"sociatic-radius-25"} -->
<div class="wp-block-cover is-light sociatic-radius-25" style="padding-top:40px;padding-right:40px;padding-bottom:40px;padding-left:40px;min-height:200px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-3880" alt="" src="' . esc_url( SOCIATIC_URI ) . 'assets/img/popup-core-bg.webp" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"left","level":4,"style":{"typography":{"lineHeight":"1.2","fontStyle":"normal","fontWeight":"800"},"spacing":{"margin":{"bottom":"20px"}}},"textColor":"theme-1","fontSize":"heading-4","fontFamily":"mulish"} -->
<h4 class="wp-block-heading has-text-align-left has-theme-1-color has-text-color has-mulish-font-family has-heading-4-font-size" style="margin-bottom:20px;font-style:normal;font-weight:800;line-height:1.2">Weekly Newsletter</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"left","style":{"spacing":{"margin":{"bottom":"20px"}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":"1.5"}},"textColor":"theme-2","fontFamily":"hind-siliguri"} -->
<p class="has-text-align-left has-theme-2-color has-text-color has-hind-siliguri-font-family" style="margin-bottom:20px;font-size:16px;font-style:normal;font-weight:400;line-height:1.5">Lorem ipsum dolor sit amet consectetur adipiscing elit ut elit tellus luctus nec.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"width":100,"className":"is-style-custombuttonstyle4"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 is-style-custombuttonstyle4"><a class="wp-block-button__link wp-element-button">Subscribe Newsletter</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
);
