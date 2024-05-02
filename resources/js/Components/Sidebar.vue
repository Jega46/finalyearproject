<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
	<div class="sidebar" id="sidebar">
		<div class="sidebar-inner slimscroll">
			<div id="sidebar-menu" class="sidebar-menu">
				<ul>
					<li>
						<a href="/dashboard"><i class="la la-cogs"></i> <span>Dashboard</span></a>
					</li>
					<li>
						<a href="/employees"><i class="la la-cogs"></i> <span>Employees</span></a>
					</li>
					<li>
						<a href="/attendance"><i class="la la-cogs"></i> <span>Attendance</span></a>
					</li>
					<li>
						<a href="/payroll"><i class="la la-cogs"></i> <span>Payroll</span></a>
					</li>
					<li>
						<a href="/pos"><i class="la la-cogs"></i> <span>POS</span></a>
					</li>
					<li>
						<a href="/inventory"><i class="la la-cogs"></i> <span>Inventory</span></a>
					</li>
					<li>
						<a href="/products"><i class="la la-cogs"></i> <span>Products</span></a>
					</li>
					<li>
						<a href="/reports"><i class="la la-cogs"></i> <span>Reports</span></a>
					</li>
					<li>
						<a href="/settings"><i class="la la-cogs"></i> <span>Settings</span></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>
