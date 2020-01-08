<body class="">
  <div class="wrapper">
    <div class="sidebar" data-color="rose" data-background-color="black" data-image="<?= base_url(); ?>assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
      -->
      <div class="logo">
        <a href="#" class="simple-text logo-mini">
          R
        </a>
        <a href="#" class="simple-text logo-normal">
          R A I S A
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="<?= base_url(); ?>assets/img/faces/<?= $karyawan['foto']; ?>" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                <?= $karyawan['nama']; ?>
                <b class="caret"></b>
              </span>
            </a>
            <?php if ($sidemenu == 'Profil') : ?>
              <div class="collapse show" id="collapseExample">
                <ul class="nav">
                <?php else : ?>
                  <div class="collapse" id="collapseExample">
                    <ul class="nav">
                    <?php endif; ?>

                    <?php if ($sidesubmenu == 'Profil') : ?>
                      <li class="nav-item active">
                      <?php else : ?>
                      <li class="nav-item">
                      <?php endif; ?>
                      <a class="nav-link" href="<?= base_url('profil'); ?>">
                        <span class="sidebar-mini"> P </span>
                        <span class="sidebar-normal"> Profil </span>
                      </a>
                    </li>
                    <?php if ($sidesubmenu == 'Ubah Password') : ?>
                      <li class="nav-item active">
                      <?php else : ?>
                      <li class="nav-item">
                      <?php endif; ?>
                      <a class="nav-link" href="<?= base_url('profil/ubahpwd'); ?>">
                        <span class="sidebar-mini"> U </span>
                        <span class="sidebar-normal"> Ubah Password </span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
                        <span class="sidebar-mini"> K </span>
                        <span class="sidebar-normal"> Keluar </span>
                      </a>
                    </li>
                    <!-- <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> EP </span>
                    <span class="sidebar-normal"> Edit Profile </span>
                  </a>
                </li> -->
                  </ul>
                </div>
            </div>
          </div>
          <ul class="nav active">
            <!-- QUERY ROLE MENU -->
            <?php
            $role_id = $this->session->userdata('role_id');
            $queryMenu = "SELECT `user_menu`.`id`,`menu`,`icon`
                                FROM `user_menu` JOIN `user_access_menu`
                                ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                                WHERE `user_access_menu`.`role_id` = $role_id
                                AND `user_menu`.`is_active` = 1
                                ORDER BY `user_access_menu`.`menu_id` ASC ";
            $menu = $this->db->query($queryMenu)->result_array();
            foreach ($menu as $m) : ?>
              <?php if ($m['menu'] == 'Dashboard' and $sidemenu == $m['menu']) { ?>
                <li class="nav-item active">
                  <a class="nav-link" href="<?= base_url('dashboard'); ?>">
                    <i class="material-icons">dashboard</i>
                    <p> Dashboard </p>
                  </a>
                </li>
              <?php } elseif ($m['menu'] == 'Dashboard' and $sidemenu != $m['menu']) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('dashboard'); ?>">
                    <i class="material-icons">dashboard</i>
                    <p> Dashboard </p>
                  </a>
                </li>
              <?php } else { ?>
                <?php if ($sidemenu == $m['menu']) : ?>
                  <li class="nav-item active">
                    <a class="nav-link" data-toggle="collapse" href="#<?= $m['menu']; ?>">
                      <i class="material-icons"><?= $m['icon']; ?></i>
                      <p> <?= $m['menu']; ?>
                      <?php if ($m['menu'] == 'Jam Kerja') {echo '<span class="badge badge-success badge-sm">Baru</span>'; }?> 
                        <b class="caret"></b>
                      </p>
                    </a>
                    <div class="collapse show" id="<?= $m['menu']; ?>">
                      <ul class="nav">
                      <?php else : ?>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="collapse" href="#<?= $m['menu']; ?>">
                            <i class="material-icons"><?= $m['icon']; ?></i>
                            <p> <?= $m['menu']; ?> 
                            <?php if ($m['menu'] == 'Jam Kerja') {echo '<span class="badge badge-success badge-sm">Baru</span>'; }?>
                              <b class="caret"></b>
                            </p>
                          </a>
                          <div class="collapse" id="<?= $m['menu']; ?>">
                            <ul class="nav">
                            <?php endif; ?>
                            <!-- QUERY ROLE SUBMENU -->
                            <?php
                            $querySubMenu = "SELECT *
                                        FROM `user_sub_menu`
                                        WHERE `menu_id` = {$m['id']}
                                        AND `user_sub_menu`.`is_active` = 1 
                                        ORDER BY `user_sub_menu`.`id` ASC
                                        ";

                            $Submenu = $this->db->query($querySubMenu)->result_array();
                            foreach ($Submenu as $sm) : ?>
                              <?php if ($sidesubmenu == $sm['title']) : ?>
                                <li class="nav-item active">
                                <?php else : ?>
                                <li class="nav-item">
                                <?php endif; ?>
                                <a class="nav-link" href="<?= base_url($sm['url']); ?>">
                                  <span class="sidebar-mini"> <?= substr($sm['title'], 0, 1); ?> </span> 
                                  <span class="sidebar-normal"> <?= $sm['title']; ?> </span>
                                </a>
                              </li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                      </li>
                    <?php }; ?>
                  <?php endforeach; ?>
                </ul>
              </div>
        </div>