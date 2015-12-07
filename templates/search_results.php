<?php
// Header stuff
$page_title       = isset( $data[ 'page_title' ] ) ? $data[ 'page_title' ] : null;

// Other Data
$search_results = isset( $data[ 'search_results' ] ) ? $data[ 'search_results' ] : null;
$search_query = isset( $data[ 'search_query' ] ) ? $data[ 'search_query' ] : null;

?>
<?php if( isset($search_results) ) : ?>
    <p>Found <b><?php echo count($search_results); ?> users</b> relevant to your search <b>"<?php echo $search_query;?>"</b>:</p>
    <?php /** @var User $result */foreach($search_results as $result) : ?>
        <section class="card">
            <a class="search-header" href="my_profile.php?profileId=<?php echo $result->getId(); ?>"><?php echo $result->getUsername();?>'s Profile Page</a>
            <p><?php echo $result->getDescription(); ?></p>
        </section>
    <?php endforeach; ?>
<?php endif; ?>