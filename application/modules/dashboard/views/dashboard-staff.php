<style>

/* Heart of the matter */
@media (min-width: 768px) {
  .ten-columns > .col-sm-2 {
    width: 20%;
  }

  /* .card-box.widget-box-one.card_jenis{
    min-height:125px;
  } */
}


</style>
<div class="wrapper">
  <div class="container">

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


    <div class="row">
        
        <div class="col-md-6">
            <div class="row ten-columns text-center">
            <?php 
                $a = array('danger', 'success', 'primary', 'warning', 'info', 'orange', 'danger');
                $no = 0;
             foreach ($list_jenis as $lj) { ?>
                <div class="col-sm-4">
                    <div class="card-box widget-box-one card_jenis" >
                        <div class="wigdet-one-content" style="font-size:14px;">
                            <p class="m-0 font-secondary"><?php echo $lj['jenis_izin'] ?></p>
                            <h3 class="text-<?php echo $a[$no] ?>"><?php echo $lj['jumlah_transaksi'] ?></h3>
                        </div>
                    </div>
                </div>
            <?php $no++; } ?>
                <div class="col-sm-4">
                    <div class="card-box widget-box-one card_jenis" >
                        <div class="wigdet-one-content" style="font-size:14px;">
                            <p class="m-0 font-secondary">Total Transaksi</p>
                            <h3 class="text-brown"><?php echo $sum_lj ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



      <!-- <div class="row">
          <div class="col-lg-4">
              <div class="card-box">
                  <h4 class="header-title m-t-0">Perbandingan</h4>
                  <div id="pie-chart" style="height: 280px;"></div>
              </div>
          </div>

          <div class="col-lg-4">
              <div class="card-box">

                  <h4 class="header-title m-t-0">Statistik</h4>
                  <div id="statistik-chart" style="height: 280px;"></div>
              </div>
          </div>

          <div class="col-lg-4">
              <div class="card-box">

                  <h4 class="header-title m-t-0">Total Ziswaf</h4>
                  <div id="bar-chart" style="height: 280px;"></div>
              </div>
          </div>

      </div> -->

        <!-- <div class="row">
            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Info Amil Terkini</h4>

                    <div class="table-responsive">
                        <table class="table table table-hover m-0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>User Name</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        <img src="<?php echo base_url() ?>berkas/core/images/users/avatar-1.jpg" alt="user" class="thumb-sm img-circle">
                                    </th>
                                    <td>
                                        <h5 class="m-0">Louis Hansen</h5>
                                        <p class="m-0 text-muted font-13"><small>Web designer</small></p>
                                    </td>
                                    <td>+12 3456 789</td>
                                    <td>USA</td>
                                    <td>07/08/2016</td>
                                </tr>

                                <tr>
                                    <th>
                                        <img src="<?php echo base_url() ?>berkas/core/images/users/avatar-2.jpg" alt="user" class="thumb-sm img-circle">
                                    </th>
                                    <td>
                                        <h5 class="m-0">Craig Hause</h5>
                                        <p class="m-0 text-muted font-13"><small>Programmer</small></p>
                                    </td>
                                    <td>+89 345 6789</td>
                                    <td>Canada</td>
                                    <td>29/07/2016</td>
                                </tr>

                                <tr>
                                    <th>
                                        <img src="<?php echo base_url() ?>berkas/core/images/users/avatar-3.jpg" alt="user" class="thumb-sm img-circle">
                                    </th>
                                    <td>
                                        <h5 class="m-0">Edward Grimes</h5>
                                        <p class="m-0 text-muted font-13"><small>Founder</small></p>
                                    </td>
                                    <td>+12 29856 256</td>
                                    <td>Brazil</td>
                                    <td>22/07/2016</td>
                                </tr>

                                <tr>
                                    <th>
                                        <img src="<?php echo base_url() ?>berkas/core/images/users/avatar-4.jpg" alt="user" class="thumb-sm img-circle">
                                    </th>
                                    <td>
                                        <h5 class="m-0">Bret Weaver</h5>
                                        <p class="m-0 text-muted font-13"><small>Web designer</small></p>
                                    </td>
                                    <td>+00 567 890</td>
                                    <td>USA</td>
                                    <td>20/07/2016</td>
                                </tr>

                                <tr>
                                    <th>
                                        <img src="<?php echo base_url() ?>berkas/core/images/users/avatar-5.jpg" alt="user" class="thumb-sm img-circle">
                                    </th>
                                    <td>
                                        <h5 class="m-0">Mark</h5>
                                        <p class="m-0 text-muted font-13"><small>Web design</small></p>
                                    </td>
                                    <td>+91 123 456</td>
                                    <td>India</td>
                                    <td>07/07/2016</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            

            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Info Muzakki terkini</h4>

                    <div class="table-responsive">
                        <table class="table table table-hover m-0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>User Name</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        <span class="avatar-sm-box bg-success">L</span>
                                    </th>
                                    <td>
                                        <h5 class="m-0">Louis Hansen</h5>
                                        <p class="m-0 text-muted font-13"><small>Web designer</small></p>
                                    </td>
                                    <td>+12 3456 789</td>
                                    <td>USA</td>
                                    <td>07/08/2016</td>
                                </tr>

                                <tr>
                                    <th>
                                        <span class="avatar-sm-box bg-primary">C</span>
                                    </th>
                                    <td>
                                        <h5 class="m-0">Craig Hause</h5>
                                        <p class="m-0 text-muted font-13"><small>Programmer</small></p>
                                    </td>
                                    <td>+89 345 6789</td>
                                    <td>Canada</td>
                                    <td>29/07/2016</td>
                                </tr>

                                <tr>
                                    <th>
                                        <span class="avatar-sm-box bg-brown">E</span>
                                    </th>
                                    <td>
                                        <h5 class="m-0">Edward Grimes</h5>
                                        <p class="m-0 text-muted font-13"><small>Founder</small></p>
                                    </td>
                                    <td>+12 29856 256</td>
                                    <td>Brazil</td>
                                    <td>22/07/2016</td>
                                </tr>

                                <tr>
                                    <th>
                                        <span class="avatar-sm-box bg-pink">B</span>
                                    </th>
                                    <td>
                                        <h5 class="m-0">Bret Weaver</h5>
                                        <p class="m-0 text-muted font-13"><small>Web designer</small></p>
                                    </td>
                                    <td>+00 567 890</td>
                                    <td>USA</td>
                                    <td>20/07/2016</td>
                                </tr>

                                <tr>
                                    <th>
                                        <span class="avatar-sm-box bg-orange">M</span>
                                    </th>
                                    <td>
                                        <h5 class="m-0">Mark</h5>
                                        <p class="m-0 text-muted font-13"><small>Web design</small></p>
                                    </td>
                                    <td>+91 123 456</td>
                                    <td>India</td>
                                    <td>07/07/2016</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            

        </div> -->


      <?php $this->load->view('copyright');?>

  </div>
</div>

<!-- <style>
    @import 'https://code.highcharts.com/css/highcharts.css';

    .highcharts-pie-series .highcharts-point {
        stroke: #EDE;
        stroke-width: 2px;
    }
    .highcharts-pie-series .highcharts-data-label-connector {
        stroke: silver;
        stroke-dasharray: 2, 2;
        stroke-width: 2px;
    }

    .highcharts-figure, .highcharts-data-table table {
        min-width: 320px; 
        max-width: 600px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chart = Highcharts.chart('statistik-chart', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Fruit Consumption'
            },
            xAxis: {
                categories: ['Apples', 'Bananas', 'Oranges']
            },
            yAxis: {
                title: {
                    text: 'Fruit eaten'
                }
            },
            series: [{
                name: 'Jane',
                data: [1, 0, 4]
            }, {
                name: 'John',
                data: [5, 7, 3]
            }]
        });

        const chart2 = Highcharts.chart('pie-chart', {

            chart: {
                styledMode: true
            },

            title: {
                text: 'Pie point CSS'
            },

            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },

            series: [{
                type: 'pie',
                allowPointSelect: true,
                keys: ['name', 'y', 'selected', 'sliced'],
                data: [
                    ['Apples', 29.9, false],
                    ['Pears', 71.5, false],
                    ['Oranges', 106.4, false],
                    ['Plums', 129.2, false],
                    ['Bananas', 144.0, false],
                    ['Peaches', 176.0, false],
                    ['Prunes', 135.6, true, true],
                    ['Avocados', 148.5, false]
                ],
                showInLegend: true
            }]
        });

        const chart3 = Highcharts.chart('bar-chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monthly Average Rainfall'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
                name: 'Tokyo',
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

            }, {
                name: 'New York',
                data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

            }, {
                name: 'London',
                data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

            }, {
                name: 'Berlin',
                data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

            }]
        });
    });
</script> -->