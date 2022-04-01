<div class="wrapper">

  <div class="container">



      <!-- Page-Title -->

      <div class="row">

          <div class="col-sm-12">

              <div class="page-title-box">

                  <div class="btn-group pull-right">

                      <ol class="breadcrumb hide-phone p-0 m-0">

                          <li class="active">

                              Tools Marketing

                          </li>

                      </ol>

                  </div>

                  <h4 class="page-title">Tools Marketing</h4>

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
          <div style="padding-top: 7%;"></div>
           <!-- <div class="alert alert-success" role="alert"> -->
               <h3 style="color: #000;"><strong>Untuk Mengakses Tools Marketing Klik Tombol Dibawah Ini
</strong></h3>
          <!-- </div> -->
          <br><h4>Masukkan Password : yaminikeren</h4><br>
          
          <a href="https://www.yayasanyamini.com/marketing-kit/" class="btn btn-lg btn-info" target="_blank">Tools Marketing <i class="fa fa-arrow-right"></i></a>

        </div>
      </div>

      <!-- end row -->






      




      <?php $this->load->view('copyright');?>



  </div>

</div>




