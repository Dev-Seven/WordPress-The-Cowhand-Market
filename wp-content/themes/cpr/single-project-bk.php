<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package cpr
 */

get_header();?>


<section class="inner-banner">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb" typeof="BreadcrumbList" vocab="http://schema.org/">
          <?php
          if ( function_exists( 'bcn_display' ) ) {
            bcn_display();
          }
          ?>
        </div>
        <h1>Projects</h1>
      </div>
    </div>
  </div>
</section>
<?php
       $author_name = get_field( 'author_name' );
       $publisher_name = get_field( 'publisher_name' );
       $published_date = get_field( 'published_date' ); 
       $project_image = get_field( 'project_image' ); 
       $title  = get_the_title(); 
	   $content  = get_the_content(); 
       $publisher_link  = get_field( 'publisher_link' );
       $publisher_pdf  = get_field( 'publisher_pdf' );
  ?>
<div class="books-title-sec" id="Test_1">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-6 col-xl-7 col-xxl-8">
        <h2><?php the_title(); ?></h2>
      </div>
      <div class="col-md-12 col-lg-6 col-xl-5 col-xxl-4 publish-by-sec">
        <div class="publish-by-left">
          <h3><?php echo $author_name; ?>
          <?php
$documents = get_posts(array(
	'post_type' => 'people',
	'meta_query' => array(
	 array(
		   'key' => 'project_detail', // name of custom field
		   'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
		   'compare' => 'LIKE'
			   )
		   )
	   ));
	?>
<?php if( $documents ): ?>
<?php foreach( $documents as $document ): ?>
  <?php echo get_the_title( $document->ID ); ?>
  <?php endforeach; ?>
<?php endif; ?> 
          <?php //echo $author_name; ?></h3>
        </div>
        <div class="editby">
            <p><?php echo $publisher_name; ?></p>
			  <p><?php echo $published_date; ?></p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="books-content-sec">
  <div class="container">
    <div class="row">
	
		<?php if ($project_image != "") {?>
      <div class="col-md-12 col-lg-4">  <img src="<?php echo $project_image; ?>" alt=""/> 	</div>
      <div class="col-md-12 col-lg-8">
        <div class="book-content wpapers">
          <?php
          $maincontent = get_the_id();
          $content_post = get_post( $maincontent );
          $content = $content_post->post_content;
          $content = apply_filters( 'the_content', $content );
          $content = str_replace( ']]>', ']]&gt;', $content );
          echo $content;
          ?>
			 <?php if ($publisher_link != "") {?>
         <a href="<?php echo $publisher_link; ?>" target="_blank" class="btn_1 outline">Publisher Page<span>&gt;</span></a>
			 <?php } ?>
			 <?php if ($publisher_pdf != "") {?>
		  <div class="pdf-link"><a href="<?php echo $publisher_pdf; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-pdf.png" alt=""/></a>
			 <?php } ?>
			</div>

		 <?php } else { ?>
		
      <div class="col-md-12">
        <div class="book-content wpapers">
          <?php
          $maincontent = get_the_id();
          $content_post = get_post( $maincontent );
          $content = $content_post->post_content;
          $content = apply_filters( 'the_content', $content );
          $content = str_replace( ']]>', ']]&gt;', $content );
          echo $content;
          ?>
			 <?php if ($publisher_link != "") {?>
         <a href="<?php echo $publisher_link; ?>" target="_blank" class="btn_1 outline">Publisher Page<span>&gt;</span></a>
			 <?php } ?>
			 <?php if ($publisher_pdf != "") {?>
		  <div class="pdf-link"><a href="<?php echo $publisher_pdf; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-pdf.png" alt=""/></a>
			 <?php } ?>
			</div>
     <?php } ?>
		  
		  </div>
      </div>
    </div>
  </div>
</div>
	</div>
	</div>
<?php get_footer(); ?>

