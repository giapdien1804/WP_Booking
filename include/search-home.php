<?php

$get_location = isset($_GET['tour_search_location']) ? $_GET['tour_search_location'] : '';
$get_price = isset($_GET['tour_search_price_range']) ? $_GET['tour_search_price_range'] : '';
$get_duration = isset($_GET['tour_search_howlong']) ? $_GET['tour_search_howlong'] : '';

?>

<div class="container">
    <form method="get" class="form-search-home" role="search" action="<?php echo home_url('/'); ?>">
        <h3 class="text-bold">Find your perfect tours</h3>
        <input type="hidden" name="type" title="search" value="tour">
        <div class="form-group">
            <input class="form-control" name="s" id="s" value="<?php echo get_search_query() ?>"
                   placeholder="Enter your destinations" type="text">
        </div>
        <?php if (GDS::get_option(['post_enable', 'location']) == true) : ?>
            <div class="form-group">
                <select class="form-control" id="tour_search_location" name="tour_search_location">
                    <?php
                    foreach (LIP::get_all_post_list('location') as $item => $value) {
                        $slt = ($get_location == $item) ? 'selected' : '';
                        echo "<option value='{$item}' {$slt}>{$value}</option>";
                    }
                    ?>
                </select>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <select class="form-control" id="tour_search_howlongs" name="tour_search_howlong">
                <?php
                foreach (LIP::duration_list('tour', 'Select duration') as $item => $value) {
                    $slt = ($get_duration == $item) ? 'selected' : '';
                    echo "<option {$slt} value='{$item}'>{$value}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" id="tour_search_howlonga" name="tour_search_price_range">
                <option value="0-0">Select price</option>
                <?php
                foreach (LIP::showPrice_list() as $item => $value) {
                    $slt = ($get_price == $item) ? 'selected' : '';
                    echo "<option {$slt} value='{$item}'>{$value}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-green text-bold text-uppercase btn-search-home">Search</button>
    </form>
</div>