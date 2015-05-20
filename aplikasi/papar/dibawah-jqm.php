<?php
/*
<!-- Footer
================================================== -->
<footer class="footer">
	<div class="container">
		<span class="label label-info">
		&copy; Hak Cipta Terperihara 2014. Theme <
$theme = ($pilih==null) ? 'Asal Bootstrap Twitter' : $pilih;
echo $theme = (isset($theme)) ? $theme : null;
	
		</span>
	</div>
</footer>
*/
?>
	<div data-role="footer">
		<h4>&copy; Hak Cipta Terperihara 2014. </h4>
		<span>
		Theme <?php
$theme = ($pilih==null) ? 'Asal Bootstrap Twitter' : $pilih;
echo $theme = (isset($theme)) ? $theme : null;
?>
		</span>
	</div>
</div>

<?php require 'jquery.php'; ?>

</body>
</html>
