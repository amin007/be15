<!-- Footer
================================================== -->
	<div data-role="footer">
		<h4>&copy; Hak Cipta Terperihara 2014. </h4>
		<p><span>
		Theme <?php
$pilih = ( isset($pilih) ) ? $pilih : null;
$theme = ($pilih==null) ? 'Asal Jquery Mobile' : $pilih;
echo $theme = (isset($theme)) ? $theme : null;
?>
		</span></p>
	</div>
</div>

<?php require 'jquery.php'; ?>

</body>
</html>
