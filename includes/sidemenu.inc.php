<div class="col-sm-3">
  <div class="p5">
    <button class="btn btn-dark menu-button form-control" onclick='toggleMenu()' style="display:none"> <i class="fas fa-bars"></i> Menu </button>
  </div>
  <div class="menu-container" id="side-menu">
    <div style="padding: 10px; margin-bottom:10px"> 
        <a href="<?php echo $rootURL; ?>profile" style="text-decoration:none;"> 
            <i class="fas fa-user" style="padding:10px; border-radius:50%; border:#fff thin solid"></i> &nbsp;<?php echo $userData['fname']." ".$userData['lname']; ?> 
        </a> 
    </div>
    <?php if(isset($_SESSION['user_session'])){ ?>
      <a href="<?php echo $rootURL; ?>user" class="menu-item"> <i class="fas fa-tachometer-alt"></i> Dashboard </a>
      <!-- <a href="<?php echo $rootURL; ?>investments" class="menu-item"> <i class="fas fa-chart-line"></i> Investments </a>
      <a href="<?php echo $rootURL; ?>wallet" class="menu-item"> <i class="fas fa-wallet"></i> Wallet </a>
      <a href="<?php echo $rootURL; ?>referrals" class="menu-item"> <i class="fas fa-cog"></i> Referrals </a> -->
      <a href="<?php echo $rootURL; ?>logout" class="menu-item"> <i class="fas fa-sign-out-alt"></i> Logout </a>
    <?php } 
        else if(isset($_SESSION['admin_session']))
      { 
    ?>
      <a href="<?php echo $rootURL; ?>home" class="menu-item"> <i class="fas fa-tachometer-alt"></i> Admin Dashboard </a>
      <a href="<?php echo $rootURL; ?>user" class="menu-item"> <i class="fas fa-users"></i> My Dashboard </a>
      <a href="<?php echo $rootURL; ?>admin/users" class="menu-item"> <i class="fas fa-users"></i> Users </a>
      <!-- <a href="<?php echo $rootURL; ?>admin/investments" class="menu-item"> <i class="fas fa-chart-line"></i> Investments </a>
      <a href="<?php echo $rootURL; ?>admin/payouts" class="menu-item"> <i class="fas fa-wallet"></i> Payouts </a> -->
      <a href="<?php echo $rootURL; ?>logout" class="menu-item"> <i class="fas fa-sign-out-alt"></i> Logout </a>
    <?php 
      } 
        else if(isset($_SESSION['security_session']))
      { 
    ?>
      <a href="<?php echo $rootURL; ?>home" class="menu-item"> <i class="fas fa-tachometer-alt"></i> Security Dashboard </a>
      <a href="<?php echo $rootURL; ?>user" class="menu-item"> <i class="fas fa-users"></i> My Dashboard </a>
      <!-- <a href="<?php echo $rootURL; ?>admin/users" class="menu-item"> <i class="fas fa-users"></i> Users </a> -->
      <!-- <a href="<?php echo $rootURL; ?>admin/investments" class="menu-item"> <i class="fas fa-chart-line"></i> Investments </a>
      <a href="<?php echo $rootURL; ?>admin/payouts" class="menu-item"> <i class="fas fa-wallet"></i> Payouts </a> -->
      <a href="<?php echo $rootURL; ?>logout" class="menu-item"> <i class="fas fa-sign-out-alt"></i> Logout </a>
    <?php } ?>
  </div>
</div>

<script>
  const toggleMenu = () => {
    $("#side-menu").slideToggle('fast');
  }
</script>