<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
</head>
	<!-- <body style="background-color:#f3f3f3;">
	   <form action="https://ex-1.pajak.go.id/djpws/token" method="POST">
        <input type="text" name="user" value="bekasikota"> 
        <input type="text" name="pwd" value="P4trioTCity"> 
        <button type="submit">Send</button>
     </form> -->

      <div class="container">
 
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapse">DETAIL JUMLAH DASHBOARD &nbsp;<span class="badge badge-grey"><?php echo $jml_semua ;?></span></a>
          </h4>
        </div>

      <div id="collapse" class="panel-collapse collapse">

        <ul class="list-group">

        <?php
          $no = 1;
          $a = 1;
          foreach ($get_aktivitas as $g) {
          
            $condition      = [];
            $condition[]    = ['id_aktivitas', $g->id_aktivitas, 'where'];
            $getJumlahData  = $this->M_core->get_tbl('v_permohonan_izin', 'id_permohonan', $condition)->num_rows();
          
        ?>

            <li class="list-group-item ">
               <div class="panel panel-success" >
                <div class="panel-heading">
                  <h4 class="panel-title text-white">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $no++;?>">
                    <?php echo $g->nama_aktivitas;?> <span class="badge badge-warning text-white"><?php echo $getJumlahData ;?></span></a> 
                  </h4>

                </div>
                <div id="collapse<?php echo $a++;?>" class="panel-collapse collapse">
                  <div class="panel-body">
                     
                      <div class="card-box table-responsive">
                    
                      <?php 
                         $this->db->group_by('v_permohonan_izin.id_user');
                         $this->db->select('v_permohonan_izin.id_user, v_permohonan_izin.id_aktivitas, m_user.nm_user');
                         $this->db->from('v_permohonan_izin ');
                         $this->db->join('m_user', 'v_permohonan_izin.id_user = m_user.id_user', 'left');
                         $this->db->where('v_permohonan_izin.id_aktivitas', $g->id_aktivitas);
                         $this->db->where('v_permohonan_izin.id_user !=', null);
                         $query = $this->db->get();

                        $getPermohonan = $query->result();

                      


                        foreach ($getPermohonan as $row) {
                          $condition     = [];
                          $condition[]   = ['id_aktivitas', $g->id_aktivitas, 'where'];
                          $condition[]   = ['id_user', $row->id_user, 'where' ];
                          $condition[]   = ['id_user != ', null, 'where' ];
                          $jml = $this->M_core->get_tbl('v_permohonan_izin', 'id_user', $condition)->num_rows();
                          
                      ?>
                      <?php
                      if ($jml != 0) {
                        
                      ?>
                        <table id="datatables-ss" class="table table-striped table-bordered">
                            <tr>
                                <td width="500px"><?php echo $row->nm_user;?></td>
                                <td width=""><?php echo $jml;?></td>
                            </tr>
                        </table>    
                      <?php
                          }else{

                      ?>

                         <table id="datatables-ss" class="table table-striped table-bordered">
                            <tr>
                                <td width="500px"><?php echo $row->id_user;?></td>
                                <td width="">0</td>
                            </tr>
                        </table>    
                        <?php
                          }
                        }
                        ?>
                    </div>
                    
                  </div>
                </div>
              </div>
            </li>

          <?php
            }
          ?>

            </ul>

        </div>
      </div>
    </div>
  </div>  

     
	</body>

</html>