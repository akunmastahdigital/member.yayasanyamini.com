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



          <div class="col-lg-2 col-md-3 col-sm-6">

              <div class="card-box widget-box-one">

                  <div class="wigdet-one-content">

                      <p class="m-0 text-uppercase font-600 font-secondary text-overflow">On Progress</p>

                      <h2 class="text-danger"><span data-plugin="counterup"><?php echo $onProgress;?></span></h2>

                      <p class="text-muted m-0">Jml On Progress</p>

                  </div>

              </div>

          </div><!-- end col-->



          <div class="col-lg-2 col-md-3 col-sm-6">

              <div class="card-box widget-box-one">

                  <div class="wigdet-one-content">

                      <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Pembatalan Proses</p>

                      <h2 class="text-info"><span data-plugin="counterup"><?php echo $terhapus;?></span></h2>

                      <p class="text-muted m-0">Jml Pembatalan</p>

                  </div>

              </div>

          </div> <!-- end col -->



          <div class="col-lg-2 col-md-3 col-sm-6">

              <div class="card-box widget-box-one">

                  <div class="wigdet-one-content">

                      <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Pending</p>

                      <h2 class="text-warning"><span data-plugin="counterup"><?php echo $jml_di_pending;?></span></h2>

                      <p class="text-muted m-0">Jml di pending</p>

                  </div>

              </div>

          </div> <!-- end col-->



          <div class="col-lg-2 col-md-3 col-sm-6">

              <div class="card-box widget-box-one">

                  <div class="wigdet-one-content">

                      <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Tolak</p>

                      <h2 class="text-danger"><span data-plugin="counterup"><?php echo $jml_di_tolak;?></span></h2>

                      <p class="text-muted m-0">Jml yang di tolak</p>

                  </div>

              </div>

          </div> <!-- end col-->



          <div class="col-lg-2 col-md-3 col-sm-6">

              <div class="card-box widget-box-one">

                  <div class="wigdet-one-content">

                      <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Terbit</p>

                      <h2 class="text-success"><span data-plugin="counterup"><?php echo $jml_di_terbit;?></span> </h2>

                      <p class="text-muted m-0">Jml yang terbit</p>

                  </div>

              </div>

          </div> <!-- end col-->



          <div class="col-lg-2 col-md-3 col-sm-6">

              <div class="card-box widget-box-one">

                  <div class="wigdet-one-content">

                      <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Semua</p>

                      <h2 class="text-info"><span data-plugin="counterup"><?php echo $jml_semua;?></span></h2>

                      <p class="text-muted m-0">Semua permohonan</p>

                  </div>

              </div>

          </div> <!-- end col-->



          



      </div>

      <!-- end row -->






      <div class="row">

          <div class="col-lg-4">

              <div class="card-box">

                  <h4 class="header-title m-t-0">Perbandingan

                    <span class="label label-danger pull-right"><?php echo date('Y');?></span>

                  </h4>

                  <div id="cont_perbandingan" style="min-width: 310px; height: 280px; max-width: 600px; margin: 0 auto"></div>

              </div>

          </div><!-- end col -->



          <div class="col-lg-4">

              <div class="card-box">

                  <h4 class="header-title m-t-0">Statistik Perbandingan

                    <span class="label label-danger pull-right"><?php echo date('Y');?></span>

                  </h4>

                  <div id="cont_perbandingan2" style="min-width: 310px; height: 280px; max-width: 600px; margin: 0 auto"></div>

              </div>

          </div><!-- end col -->



          <div class="col-lg-4">

              <div class="card-box">

                  <h4 class="header-title m-t-0">Grafik Seluruh Permohonan

                  <span class="label label-danger pull-right"><?php echo date('Y');?></span>

                  </h4>

                  <div id="cont_grafik" style="min-width: 310px; height: 280px; max-width: 600px; margin: 0 auto"></div>

              </div>

          </div><!-- end col -->



      </div>

      <!-- end row -->





      <?php $this->load->view('copyright');?>



  </div>

</div>



<!--Morris Chart-->

<script src="<?php echo base_url()?>berkas/plugins/morris/morris.min.js"></script>

<script src="<?php echo base_url()?>berkas/plugins/raphael/raphael-min.js"></script>



<!-- Chart JS -->

<script src="<?php echo base_url()?>berkas/plugins/chart.js/chart.min.js"></script>

<script src="<?php echo base_url()?>berkas/core/pages/jquery.chartjs.init.js"></script>



<!--C3 Chart-->

<script type="text/javascript" src="<?php echo base_url()?>berkas/plugins/d3/d3.min.js"></script>

<script type="text/javascript" src="<?php echo base_url()?>berkas/plugins/c3/c3.min.js"></script>

<script src="<?php echo base_url()?>berkas/core/pages/jquery.c3-chart.init.js"></script>



<!-- Dashboard init -->

<script src="<?php echo base_url()?>berkas/core/pages/jquery.dashboard.js"></script>



<!-- Highchart -->

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>

<script src="https://code.highcharts.com/modules/exporting.js"></script>



<script type="text/javascript">

  

$(document).ready(function () {



    // cont_perbandingan

    Highcharts.chart('cont_perbandingan', {

        chart: {

            plotBackgroundColor: null,

            plotBorderWidth: null,

            plotShadow: false,

            type: 'pie'

        },

        title: {

            text: ''

        },

        tooltip: {

            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'

        },

        plotOptions: {

            pie: {

                allowPointSelect: true,

                cursor: 'pointer',

                dataLabels: {

                    enabled: false

                },

                showInLegend: true

            }

        },

        series: [{

            name: 'Brands',

            colorByPoint: true,

            data: [{

                name: 'Izin Terbit',

                y: <?php echo $cont_p1[0];?>

            }, {

                name: 'Izin Tolak',

                y: <?php echo $cont_p1[1];?>,

                sliced: true,

                selected: true

            }]

        }]

    });





    //cont_perbandingan2

    Highcharts.chart('cont_perbandingan2', {

        chart: {

            type: 'column'

        },

        title: {

            text: ''

        },

        subtitle: {

            text: ''

        },

        xAxis: {

            categories: [

                <?php foreach($vpi_all->result_array() as $vpia) { ?>'<?php echo $vpia['nama_bulan'];?>',<?php } ?>

            ],

            crosshair: true

        },

        yAxis: {

            min: 0,

            title: {

                text: 'Jumlah'

            }

        },

        tooltip: {

            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',

            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +

                '<td style="padding:0"><b>{point.y}</b></td></tr>',

            footerFormat: '</table>',

            shared: true,

            useHTML: true

        },

        plotOptions: {

            column: {

                pointPadding: 0.2,

                borderWidth: 0

            }

        },

        series: [{

            name: 'Izin Masuk',

            data: [<?php foreach($vpi_all->result_array() as $vpia) { ?><?php echo $vpia['jml_izin'];?>,<?php } ?>],

            color: '#434348'



        }, {

            name: 'Izin Terbit',

            data: [<?php foreach($vpi_all->result_array() as $vpia) { ?><?php echo $vpia['jml_izin_terbit'];?>,<?php } ?>],

            color: '#7cb5ec'



        }, {

            name: 'Izin Tolak',

            data: [<?php foreach($vpi_all->result_array() as $vpia) { ?><?php echo $vpia['jml_izin_tolak'];?>,<?php } ?>],

            color: '#f5707a'



        }]

    });





    //cont_grafik

    Highcharts.chart('cont_grafik', {

        chart: {

            type: 'line'

        },

        title: {

            text: ''

        },

        subtitle: {

            text: ''

        },

        xAxis: {

            categories: [<?php foreach($vpi_all->result_array() as $vpia) { ?>'<?php echo $vpia['nama_bulan'];?>',<?php } ?>]

        },

        yAxis: {

            title: {

                text: 'Jumlah'

            }

        },

        plotOptions: {

            line: {

                dataLabels: {

                    enabled: true

                },

                enableMouseTracking: false

            }

        },

        series: [{

            name: 'Izin',

            data: [<?php foreach($vpi_all->result_array() as $vpia) { ?><?php echo $vpia['jml_izin'];?>,<?php } ?>]

        }]

    });



});

</script>