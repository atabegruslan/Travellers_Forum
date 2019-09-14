<?php get_header(); ?>

<?php
$args = array(
	'post_type' => 'destination'
);

$destination = new WP_Query($args);
?>

<?php  if ($destination->have_posts()): while($destination->have_posts()): $destination->the_post(); ?>

	<?php
        if (get_the_post_thumbnail_url() === false)
        {
            $imgUrl = get_stylesheet_directory_uri() . '/images/noimage.jpg';
        }
        else
        {
            $imgUrl = get_the_post_thumbnail_url();
        }

        $displayData = array(
            'link' => get_the_permalink(),
            'img_url' => $imgUrl,
            'category' => get_the_terms($destination->ID, 'destination_category'),
            'title' => get_the_title(),
            'varying_info' => array(
                'author' => get_the_author(),
                'created' => get_the_date()
            )
        );

		echo render_layout('entry-item.row', $displayData);
	?>

<?php endwhile; ?>
<?php endif;?>

<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>