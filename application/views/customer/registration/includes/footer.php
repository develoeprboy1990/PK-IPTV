<!--begin::Javascript-->
		
<!-- DataTables -->
<!--<script src="<?= DEFAULT_ASSETS ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= DEFAULT_ASSETS ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>plugins/global/plugins.bundle.js"></script>
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<!--<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>-->
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/widgets.bundle.js"></script>
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/custom/widgets.js"></script>
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/custom/apps/chat/chat.js"></script>
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/custom/utilities/modals/create-app.js"></script>
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/custom/utilities/modals/new-target.js"></script>
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/custom/utilities/modals/users-search.js"></script>
	
<style>
.tab {

}

/* Style the buttons inside the tab */
.tab button {
background-color: inherit;
float: left;
border: none;
outline: none;
cursor: pointer;
padding: 14px 16px;
transition: 0.3s;
font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
background-color: #ddd;border-radius: 10px 10px 0 0;
}

/* Create an active/current tablink class */
.tab button.active {
border-top: 1px solid #ddd;
border-left:1px solid #ddd;
border-right:1px solid #ddd;
border-radius: 10px 10px 0 0;
}

/* Style the tab content */
.tabcontent {}

/* Style the close button */
.topright {
float: right;
cursor: pointer;
font-size: 28px;
}

.topright:hover {color: red;}
</style>
<script>
function openCity(evt, cityName) {
var i, tabcontent, tablinks;
tabcontent = document.getElementsByClassName("tabcontent");
for (i = 0; i < tabcontent.length; i++) {
tabcontent[i].style.display = "none";
}
tablinks = document.getElementsByClassName("tablinks");
for (i = 0; i < tablinks.length; i++) {
tablinks[i].className = tablinks[i].className.replace(" active", "");
}
document.getElementById(cityName).style.display = "block";
evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();
</script>
	
	
	<!--end::Custom Javascript-->
	<!--end::Javascript-->
	<?php isset($_extra_scripts) ? $this->load->view($_extra_scripts) : ''; ?>
</body>
<!--end::Body-->
</html>