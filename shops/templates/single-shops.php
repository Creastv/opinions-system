<?php
get_header();
while ( have_posts() ) : the_post();
    $shop = [
        'logo'      =>   get_the_post_thumbnail( get_the_ID(), 'thumbnail' ),
        'name'       =>  get_the_title(get_the_ID()),
        'desc'       =>  get_post_meta( get_the_ID(), 'shop-desc', true ),
        'phone'      =>  get_post_meta( get_the_ID(), 'shop-phone', true ),
        'email'      =>  get_post_meta( get_the_ID(), 'shop-email', true ),
        'url'        =>  get_post_meta( get_the_ID(), 'shop-url', true ),
        'address'    =>  get_post_meta( get_the_ID(), 'shop-address', true ),
        'address2'   =>  get_post_meta( get_the_ID(), 'shop-address2', true ),
        'city'       =>  get_post_meta( get_the_ID(), 'shop-city', true ),
        'zip'        =>  get_post_meta( get_the_ID(), 'shop-zip-code', true ),
    ]; 
      echo "<article>";
      echo $shop['logo'];
      echo '<br><br>';
        echo "Nazwa sklepu: <strong>" . $shop['name'] . "</strong><br>";
        echo "Opis sklepu: <strong>" . $shop['desc'] . "</strong><br>";
        echo "Nr telefonu: <strong>" . $shop['phone'] . "</strong><br>";
        echo "Adres email: <strong>" . $shop['email'] . "</strong><br>";
        echo "Link sklepu: <strong>" . $shop['url'] . "</strong><br>";
        echo "Adress: <strong>" . $shop['address'] . ', '. $shop['address2'] . "</strong><br>";
        echo "Miasto: <strong>" . $shop['city'] . "</strong><br>";
        echo "Kod pocztowy: <strong>" . $shop['zip'] . "</strong><br>";
      echo "</article>";

endwhile; ?>
<?php 

$taxonomies = get_terms( array(
	'taxonomy' => 'shop-cat',
	// 'hide_empty' => false
) );

if ( !empty($taxonomies) ) :
	$output = '<select>';
	foreach( $taxonomies as $category ) {
		if( $category->parent == 0 ) {
			$output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
			foreach( $taxonomies as $subcategory ) {
				if($subcategory->parent == $category->term_id) {
				$output.= '<option value="'. esc_attr( $subcategory->term_id ) .'">
					'. esc_html( $subcategory->name ) .'</option>';
				}
			}
			$output.='</optgroup>';
		}
	}
	$output.='</select>';
	echo $output;
endif;
get_footer();
