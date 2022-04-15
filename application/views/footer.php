<!-- jQuery  -->

<script src="<?php echo base_url()?>berkas/core/js/bootstrap.min.js"></script>

<script src="<?php echo base_url()?>berkas/core/js/detect.js"></script>

<script src="<?php echo base_url()?>berkas/core/js/fastclick.js"></script>

<script src="<?php echo base_url()?>berkas/core/js/jquery.blockUI.js"></script>

<script src="<?php echo base_url()?>berkas/core/js/waves.js"></script>

<script src="<?php echo base_url()?>berkas/core/js/jquery.slimscroll.js"></script>

<script src="<?php echo base_url()?>berkas/core/js/jquery.scrollTo.min.js"></script>

<script src="<?php echo base_url()?>berkas/plugins/switchery/switchery.min.js"></script>

<script src="<?php echo base_url()?>berkas/plugins/summernote/summernote.min.js"></script>

        <script>

            jQuery(document).ready(function(){

                $('.cek').summernote({
                    height: 250,                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    focus: false                 // set focus to editable area after initializing summernote
                });
            });
        </script>



<!-- Counter js  -->

<script src="<?php echo base_url()?>berkas/plugins/waypoints/jquery.waypoints.min.js"></script>

<script src="<?php echo base_url()?>berkas/plugins/counterup/jquery.counterup.min.js"></script>



<!-- Sweetalert -->

<script src="<?php echo base_url()?>berkas/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>



<!-- Tooltipster js -->

<script src="<?php echo base_url()?>berkas/plugins/tooltipster/tooltipster.bundle.min.js"></script>

<!-- <script src="<?php echo base_url()?>berkas/core/pages/jquery.tooltipster.js"></script> -->



<!-- Bootstrap Select -->

<script src="<?php echo base_url()?>berkas/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>  



<!-- App js -->

<script src="<?php echo base_url()?>berkas/core/js/jquery.core.js"></script>

<script src="<?php echo base_url()?>berkas/core/js/jquery.app.js"></script>



<script type="text/javascript">

    $(document).ready(function () {

    	//Tooltip

        $('.tooltip-hover').tooltipster();

        $('.tooltipster').tooltipster();



        //Input mask

        $( '.uang' ).mask('000.000.000.000.000', {reverse: true});

        $('.phone').mask('0000 0000 0000');
        $('.select2').select2();


        //Core Select
        // $('.input-select').each(function(i, e) {
        //     $(e).attr("data-live-search", "true");
        //     var cls_old = $(e).attr("class");
        //     var cls_new = cls_old+' selectpicker';
        //     $(e).prop("class", cls_new);
        // });


    });

</script>



	<!--Datepicker-->

    <script type="text/javascript">
        $('input[type=date]').each(function(i, e) {
            var val = $(e).data('val'); 
            $(e).prop("type", "text");
            $(e).datepicker({
                showButtonPanel: true,
                changeMonth: true,
                format: 'dd-mm-yyyy'
            }).datepicker('setDate', val);
        });

        $('.datepicker2').datepicker({
            showButtonPanel: true,
            changeMonth: true,
            format: 'dd-mm-yyyy'
        }).datepicker('setDate', '27-08-1990');

    

    </script>

    

    <!--Currency-->

    <script type="text/javascript">

    jQuery(function($) {

        $(':input[type=currency]').prop("type", "text").addClass("currency").attr('data-a-sep','.').attr('data-a-dec',',').autoNumeric('init', { mDec: '0' });

    });



    </script>