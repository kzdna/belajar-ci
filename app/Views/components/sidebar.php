
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == '') ? "" : "collapsed" ?>" href="/">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li><!-- End Home Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'keranjang') ? "" : "collapsed" ?>" href="keranjang">
                <i class="bi bi-cart-check"></i>
                <span>Keranjang</span>
            </a>
        </li><!-- End Keranjang Nav --> 
        <?php
        if (session()->get('role') == 'admin') {
        ?>
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'produk') ? "" : "collapsed" ?>" href="produk">
                <i class="bi bi-receipt"></i>
                <span>Produk</span>
            </a>
        </li><!-- End Produk Nav --> 

        <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'profile') ? "" : "collapsed" ?>" href="profile">
        <i class="bi bi-person-lines-fill"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Home Nav -->

        <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'contact') ? "" : "collapsed" ?>" href="contact">
        <i class="bi bi-person-lines-fill"></i>
                <span>Contact</span>
            </a>
        </li><!-- End Home Nav -->
        <?php
        }
        ?>
    </ul>
</aside><!-- End Sidebar-->
    </ul>

  </aside><!-- End Sidebar-->