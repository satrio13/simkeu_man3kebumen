  <footer class="main-footer">
    <strong>
    <?php
    $tahun_sekarang = '2020';
    $tahun_besok = date('Y');
    if($tahun_besok > $tahun_sekarang){ ?>
    &copy; <?= $tahun_sekarang; ?> - <?= $tahun_besok; ?>
    <?php }else{ ?>
    &copy; <?php echo $tahun_besok; ?>
    <?php } ?>

    <a href="javascript:void(0)">MAN 3 KEBUMEN</a></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block text-danger">time execution: <?= $this->benchmark->elapsed_time(); ?> 
                                                                  | memory usage: <?= $this->benchmark->memory_usage(); ?>
                                                                  <button onclick="topFunction()" id="myBtn">Back To Top</button>
    </div>
  </footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>  
<script src="<?= base_url(); ?>assets/AdminLTE-3.0.2/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/AdminLTE-3.0.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/AdminLTE-3.0.2/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url(); ?>assets/AdminLTE-3.0.2/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?= base_url(); ?>assets/AdminLTE-3.0.2/dist/js/adminlte.js"></script>
<script src="<?= base_url(); ?>assets/sweetalert/sweetalert.min.js"></script>
<script>var base_url = '<?= base_url() ?>';</script>
<script src="<?= base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?= base_url(); ?>assets/js/script.js"></script>