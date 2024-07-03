<div class="menu_section">
    <h3>General</h3>
    <ul class="nav side-menu">
        <li>
            <a><i class="fa fa-home"></i>Home<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="<?php echo base_url(); ?>home">Dashboard</a></li>
                <!-- <li><a href="<?php echo base_url(); ?>home/banner">Banner</a></li> -->
            </ul>
        </li>
        <?php $a = $this->session->userdata('level');
        if (strpos($a, '40') !== false) { ?>
            <li>
                <a><i class="fa fa-edit"></i>BOC Digital Memo<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '401') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/create_memo">Create</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '401') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/inbox">Inbox</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '401') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/send_memo">Outbox</a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <?php $a = $this->session->userdata('level');
        if (strpos($a, '70') !== false) { ?>
            <li>
                <a><i class="fa fa-edit"></i>External Letter<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '701') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/letter_in">Letter In</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '701') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/x">Letter Out</a></li>
                    <?php } ?>

                </ul>
            </li>
        <?php } ?>
        <?php $a = $this->session->userdata('level');
        if (strpos($a, '60') !== false) { ?>
            <li>
                <a><i class="fa fa-edit"></i>Tello<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '601') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>task/task">Task List</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '601') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>task/create_task">Create</a></li>
                    <?php } ?>

                </ul>
            </li>
        <?php } ?>
        <?php $a = $this->session->userdata('level');
        if (strpos($a, '50') !== false) { ?>
            <li>
                <a><i class="fa fa-edit"></i>Management Asset<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '501') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/asset_list">Asset List</a></li>
                        <li><a href="<?php echo base_url(); ?>asset/item_list">Item List</a></li>
                    <?php } ?>
                    <!-- <?php $a = $this->session->userdata('level');
                            if (strpos($a, '501') !== false) { ?>
						<li><a href="<?php echo base_url(); ?>app/abk_list">Mobil List</a></li>
				<?php } ?>
				<?php $a = $this->session->userdata('level');
                if (strpos($a, '501') !== false) { ?>
						<li><a href="<?php echo base_url(); ?>app/mobil_list">ABK List</a></li>
				<?php } ?> -->
                </ul>
            </li>
        <?php } ?>
        <?php $a = $this->session->userdata('level');
        if (strpos($a, '10') !== false) { ?>
            <li>
                <a><i class="fa fa-edit"></i>Queue<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '101') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/antrian_input">Create Queue</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '102') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/antrian_panggil">Queue Management</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '103') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/antrian_monitor">Queue Monitor </a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <?php $a = $this->session->userdata('level');
        if (strpos($a, '20') !== false) { ?>
            <li>
                <a><i class="fa fa-edit"></i>Mit-E<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '201') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/quotation">Quotation</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '202') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/">Invoice</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '203') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/">Report</a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <?php $a = $this->session->userdata('level');
        if (strpos($a, '30') !== false) { ?>
            <li>
                <a><i class="fa fa-edit"></i>Human Resources<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '301') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>app/import">Upload Gaji</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '302') !== false) { ?>
                        <!--li><a href="<?php echo base_url(); ?>app/slip_gaji_pdf">Slip Gaji</a></li-->
                        <li><a href="<?php echo base_url(); ?>app/cetak_gaji">Slip Gaji</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '302') !== false) { ?>
                        <!--li><a href="<?php echo base_url(); ?>app/slip_gaji_pdf">Slip Gaji</a></li-->
                        <li><a href="<?php echo base_url(); ?>app/absen_wfh">Absen WFH</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '303') !== false) { ?>
                        <!--li><a href="<?php echo base_url(); ?>app/slip_gaji_pdf">Slip Gaji</a></li-->
                        <li><a href="<?php echo base_url(); ?>app/user">User</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '302') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>cuti/view">Cuti</a></li>
                    <?php } ?>
                    <?php $a = $this->session->userdata('level');
                    if (strpos($a, '302') !== false) { ?>
                        <li><a href="<?php echo base_url(); ?>absensi">Absensi</a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <?php $a = $this->session->userdata('level');
        if (strpos($a, '30') !== false) { ?>
            <li>
                <a><i class="fa fa-edit"></i>Financial<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php
                    if (strpos($a, '301') !== false) { ?>
                        <li>
                            <a href="<?= base_url(); ?>financial/financial_entry">Financial Entry</a>
                        </li>
                    <?php }
                    if (strpos($a, '301') !== false) { ?>
                        <li>
                            <a href="<?= base_url(); ?>financial/invoice">Invoice</a>
                        </li>
                    <?php }
                    if (strpos($a, '301') !== false) { ?>
                        <li>
                            <a href="<?= base_url(); ?>customer">Customer</a>
                        </li>
                    <?php }
                    if (strpos($a, '301') !== false) { ?>
                        <li>
                            <a href="<?= base_url(); ?>financial/showreport">Neraca L/R</a>
                        </li>
                    <?php }
                    if (strpos($a, '301') !== false) { ?>
                        <li>
                            <a href="<?= base_url(); ?>financial/coa_report">Report per CoA</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>


        <!--li>
         <a><i class="fa fa-edit"></i> My Project <span class="fa fa-chevron-down"></span></a>
         <ul class="nav child_menu">
			<li><a href="<?php echo base_url(); ?>app/input_customer">Add Customers</a></li>
            <li><a href="<?php echo base_url(); ?>app/input_form">Add Projects</a></li>
			<li><a href="<?php echo base_url(); ?>app/list_project">Project Investment</a></li>
			<li><a href="<?php echo base_url(); ?>app/list_open">Project Opened</a></li>
         </ul>
      </li>
	  <li>
         <a><i class="fa fa-bar-chart-o"></i> Financials <span class="fa fa-chevron-down"></span></a>
         <ul class="nav child_menu">
            <li><a href="<?php echo base_url(); ?>app/input_finance">Financials Movement</a></li>
			<li><a href="<?php echo base_url(); ?>app/detail_transaction">Detail Transaction</a></li>
			<li><a href="<?php echo base_url(); ?>app/finance_report">Financials Report</a></li>
         </ul>
      </li>
      <?php //if ($this->session->userdata('level')==1) {
        ?>
	  <li>
         <a><i class="fa fa-desktop"></i> Admin Board <span class="fa fa-chevron-down"></span></a>
         <ul class="nav child_menu">
            <li><a href="<?php echo base_url(); ?>app/pending_transaction">Financials Moderation</a></li>
			<li><a href="<?php echo base_url(); ?>app/cari_customer_bayar_all">Investment Review</a></li>
			<li><a href="<?php echo base_url(); ?>app/admin_dashboard">Admin Dashboard</a></li>
			<li><a href="<?php echo base_url(); ?>app/eom">End Of Month (EOM)</a></li>
			<li><a href="<?php echo base_url(); ?>app/cash_list">Cash List</a></li>
			<li><a href="<?php echo base_url(); ?>app/payable_list">Payable List</a></li>
			<li><a href="<?php echo base_url(); ?>app/agent_list">Agent List</a></li>
         </ul>
      </li>
	  <li>
         <a><i class="fa fa-database"></i> Tools <span class="fa fa-chevron-down"></span></a>
         <ul class="nav child_menu">
            <li><a href="<?php echo base_url(); ?>backup/index" onClick="return clickdb1();">BackUp Database</a></li>
			<li><a href="<?php echo base_url(); ?>backup/clean_db" onClick="return clickdb2();">Clean DB Project</a></li>
         </ul>
      </li-->

        <?php //} 
        ?>
        <li>
            <a><i class="fa fa-key"></i>Password<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="<?php echo base_url(); ?>login/password">Change Password</a></li>
            </ul>
        </li>
    </ul>
</div>

<!--footer menu-->
<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo base_url(); ?>login/logout">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>
<!--footer menu-->

<div class="menu_section">
    <!--<h3>Live On</h3>
   <ul class="nav side-menu">
      <li>
         <a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
         <ul class="nav child_menu">
            <li><a href="e_commerce.html">E-commerce</a></li>
            <li><a href="projects.html">Projects</a></li>
            <li><a href="project_detail.html">Project Detail</a></li>
            <li><a href="contacts.html">Contacts</a></li>
            <li><a href="profile.html">Profile</a></li>
         </ul>
      </li>
      <li>
         <a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
         <ul class="nav child_menu">
            <li><a href="page_403.html">403 Error</a></li>
            <li><a href="page_404.html">404 Error</a></li>
            <li><a href="page_500.html">500 Error</a></li>
            <li><a href="plain_page.html">Plain Page</a></li>
            <li><a href="login.html">Login Page</a></li>
            <li><a href="pricing_tables.html">Pricing Tables</a></li>
         </ul>
      </li>
      <li>
         <a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
         <ul class="nav child_menu">
            <li><a href="#level1_1">Level One</a>
            <li>
               <a>Level One<span class="fa fa-chevron-down"></span></a>
               <ul class="nav child_menu">
                  <li class="sub_menu"><a href="level2.html">Level Two</a>
                  </li>
                  <li><a href="#level2_1">Level Two</a>
                  </li>
                  <li><a href="#level2_2">Level Two</a>
                  </li>
               </ul>
            </li>
            <li><a href="#level1_2">Level One</a>
            </li>
         </ul>
      </li>
      <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
   </ul>-->
</div>

<script>
    function clickdb1() {
        return confirm('Are you sure to Back Up Data Base? ');
    }

    function clickdb2() {
        return confirm('Are you sure to clear Data Base? ');
    }
</script>