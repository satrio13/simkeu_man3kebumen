<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/nav');
echo $contents;
$this->load->view('template/js');
$this->load->view('template/foot');
?>