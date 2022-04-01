<style>
body {
    background: url('https://images.pexels.com/photos/295813/pexels-photo-295813.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') repeat fixed;
    background-size:cover
}

.panel-black{
    background-color: rgba(0,0,0,.7);
    padding:20px;
    padding-bottom:0px;
}
.panel input{
    color: #fff;
}

</style>
<div class="wrapper">
    <div class="container">
    <div class="col-md-3"></div>
    <div class="col-md-6">
          <?php
                            if ($this->session->flashdata('psn') <> '' ) {
                                

                        ?>

                            <div class="alert alert-icon alert-black alert-dismissible fade in" role="alert" style="background-color: red">
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <i class="mdi mdi-alert"></i>
                                                <strong><?php echo $this->session->flashdata('psn')?></strong> 
                                            </div>
                        <?php
                        }
                        ?>   

                        </div>
            <div class="col-md-3"></div>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4">
                <div class="panel panel-color panel-black">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">LOGIN APLIKASI</h3>
                        <p class="panel-sub-title font-13 text-muted text-center"><i>Masukan username dan password</i></p>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="<?php echo base_url('user/submitLogin');?>">

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" placeholder="Username" name="username" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="password" placeholder="Password" name="password" required>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="checkbox checkbox-success">
                                            <input id="checkbox-signup" type="checkbox" checked>
                                            <label for="checkbox-signup">
                                                Remember me
                                            </label>
                                        </div>

                                    </div>
                                </div> -->

                            <div class="form-group text-center m-t-30">
                                    <div class="col-sm-12">
                                        <a href="#" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                                    </div>
                                </div>

                                <div class="form-group account-btn text-center m-t-10">
                                    <div class="col-xs-12">
                                        
                                            <button class="btn w-md btn-bordered btn-black waves-effect waves-light" 
                                            type="submit">Log In</button>
                                       
                                    </div>
                                </div>

                            </form>
                    </div>
                </div>
            </div><!-- end col -->

        </div>
        <!-- end row -->


       

    </div>
</div>