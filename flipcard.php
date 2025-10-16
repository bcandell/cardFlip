<?php
/**
 * Course Catalog Loop Block
 * Version: 3.1 - Server-side rendering (no AJAX)
 */

$args = [
    'post_type'      => 'course',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'post_status'    => 'publish'
];

$query = new WP_Query($args);

if ($query->have_posts()) {
    echo '<div class="course-grid">';
    
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();

        $title = esc_html(get_the_title());
        $summary = get_field('summary_text', $post_id);
        $details = get_field('additional_details', $post_id);
        $custom_link = get_field('custom_link', $post_id);
        $custom_link_url = $custom_link['url'] ?? '';
        $custom_link_label = $custom_link['title'] ?? 'Learn More';

        ?>
        <article class="course-card" data-course-id="<?php echo $post_id; ?>">
            <h2><?php echo $title; ?></h2>
            
            <?php if ($summary): ?>
                <div class="summary-text"><?php echo wp_kses_post($summary); ?></div>
            <?php endif; ?>
            
            <?php if ($details): ?>
                <div class="additional-details"><?php echo wp_kses_post($details); ?></div>
            <?php endif; ?>
            
            <?php if ($custom_link_url): ?>
                <p><a class="custom-link" href="<?php echo esc_url($custom_link_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($custom_link_label); ?></a></p>
            <?php endif; ?>
            
            <?php
            // Display ACF taxonomy tags
            $custom_taxonomies = get_field('custom_taxonomies', $post_id);
            if ($custom_taxonomies && is_array($custom_taxonomies)):
            ?>
                <div class="acf-taxonomy-tags">
                    <?php foreach ($custom_taxonomies as $taxonomy_group): 
                        // Ensure taxonomy_group is an array
                        if (!is_array($taxonomy_group)) continue;
                        ?>
                        <div class="taxonomy-group">
                            <?php if (!empty($taxonomy_group['taxonomy_text'])): ?>
                                <h4 class="taxonomy-header"><?php echo esc_html($taxonomy_group['taxonomy_text']); ?></h4>
                            <?php endif; ?>
                            
                            <?php 
                            // Check if terms exists and is an array
                            if (!empty($taxonomy_group['terms']) && is_array($taxonomy_group['terms'])): 
                                foreach ($taxonomy_group['terms'] as $term): 
                                    // Ensure term is an array
                                    if (!is_array($term)) continue;
                                    ?>
                                    <div class="term-tag-group">
                                        <?php
                                        $term_name = $term['term_name'] ?? '';
                                        $term_color = $term['term_tile_color'] ?? '#ccc';
                                        if ($term_name):
                                        ?>
                                            <span class="term-tag" style="background-color: <?php echo esc_attr($term_color); ?>">
                                                <?php echo esc_html($term_name); ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php 
                                        // Check if sub_terms exists and is an array
                                        if (!empty($term['sub_terms']) && is_array($term['sub_terms'])): ?>
                                            <div class="sub-term-tags">
                                                <?php foreach ($term['sub_terms'] as $sub_term): 
                                                    // Ensure sub_term is an array
                                                    if (!is_array($sub_term)) continue;
                                                    
                                                    $sub_name = $sub_term['sub_term_name'] ?? '';
                                                    $sub_color = $sub_term['sub_term_tile_color'] ?? '#eee';
                                                    if ($sub_name):
                                                    ?>
                                                        <span class="sub-term-tag" style="background-color: <?php echo esc_attr($sub_color); ?>">
                                                            <?php echo esc_html($sub_name); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; 
                            endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>
        <?php
    }
    
    echo '</div>';
    wp_reset_postdata();
} else {
    echo '<div class="course-grid"><p class="no-courses">No courses found.</p></div>';
}
?>