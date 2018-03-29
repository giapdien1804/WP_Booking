<footer>
    <div class="container">
        <div class="row">
            <?php if (is_active_sidebar('footer_sidebar_1')) {
                dynamic_sidebar('footer_sidebar_1');
            } ?>
            <?php if (is_active_sidebar('footer_sidebar_2')) {
                dynamic_sidebar('footer_sidebar_2');
            } ?>

            <?php if (is_active_sidebar('home_widget_1')) {
                dynamic_sidebar('home_widget_1');
            } ?>
            <?php if (is_active_sidebar('home_widget_2')) {
                dynamic_sidebar('home_widget_2');
            } ?>
        </div>
        <?php if (!empty(GDS::get_option(['option_text', 'footer_bg']))) : ?>
            <div class="img-footer">
                <img class="img-responsive" src="<?= GDS::get_option(['option_text', 'footer_bg']); ?>"
                     alt="img_footer"/>
            </div>
        <?php endif; ?>
    </div>
</footer>

<div class="modal fade" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="myModalEmail">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalEmail">We are always here to help you. Don't hesitate to send
                    us!</h4>
            </div>
            <div class="modal-body">
                <?php echo do_shortcode('[site_contact_form]'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="loader">
    <div class="tb-cell">
        <div id="page-loading">
            <div></div>
            <p>Loading</p>
        </div>
    </div>
</div>


<a href="javascript:;" class="scrollToTop"><i class="fa fa-arrow-up"></i></a>

<?php wp_footer(); ?>
<script>
    $(".loader").delay(1000).fadeOut("slow");
</script>

<?php echo GDS::get_option(['other_social', 'code_footer']) ?>

</body>
</html>
