<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
<div class="header">
	<!-- Logo -->
	<div class="header-left">
		<a class="logo">
			<img src="../../images/logo-2.png" style="max-width:170px">
		</a>
	</div>
	<!-- /Logo -->
	
	<a id="toggle_btn" href="javascript:void(0);">
		<span class="bar-icon">
			<span></span>
			<span></span>
			<span></span>
		</span>
	</a>
	
	
	<!-- /Header Title -->
	
	<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
	
	<!-- Header Menu -->
	<ul class="nav user-menu">
		<li class="nav-item dropdown has-arrow main-drop">
			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
				<span class="user-img mr-2"><img src="../../images/avatar.jpg" alt="User Picture">
				<span class="status online"></span></span>
				<span>Mona</span>
			</a>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="profile.php">My Profile</a>
				<a class="dropdown-item" href="settings.php">Settings</a>
				<a class="dropdown-item" href="logout.php">Logout</a>
			</div>
		</li>
	</ul>
	<!-- /Header Menu -->
	
	<!-- Mobile Menu -->
	<div class="dropdown mobile-user-menu">
		<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
		<div class="dropdown-menu dropdown-menu-right">
			<a class="dropdown-item" href="profile.php">My Profile</a>
			<a class="dropdown-item" href="settings.php">Settings</a>
			<a class="dropdown-item" href="login.php">Logout</a>
		</div>
	</div>
	<!-- /Mobile Menu -->
	
</div>
</template>
