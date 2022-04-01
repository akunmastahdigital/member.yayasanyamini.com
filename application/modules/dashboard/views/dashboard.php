<div class="wrapper">

  <div class="container">



      <!-- Page-Title -->

      <div class="row">

          <div class="col-sm-12">

              <div class="page-title-box">

                  <div class="btn-group pull-right">

                      <ol class="breadcrumb hide-phone p-0 m-0">

                          <li class="active">

                              Dashboard

                          </li>

                      </ol>

                  </div>

                  <h4 class="page-title">Dashboard</h4>

              </div>

          </div>

      </div>

      <!-- end page title end breadcrumb -->



      <div class="row">

        <div class="col-md-8 col-md-offset-2" >

          <?php if($this->session->flashdata('teks-alert') != '') { ?>

            <!--alert-->

            <div class="alert <?php echo $this->session->flashdata('tipe-alert');?>-border" role="alert" style="background-color: red">

                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <i class="<?php echo $this->session->flashdata('icon-alert');?>"></i> <?php echo $this->session->flashdata('teks-alert');?>

            </div>

          <?php } ?>

        </div>

      </div>





      <div class="row text-center">
         <div class="col-md-8 col-md-offset-2" >
          <div style="padding: 50px;"></div>
           <div class="alert alert-success" role="alert">
               <h3 style="color: #fff;"><strong>Selamat Datang di Member Area Ziswaf Yamini
</strong></h3>
          </div>


        </div>
      </div>

      <!-- end row -->






      




      <?php $this->load->view('copyright');?>



  </div>

</div>




