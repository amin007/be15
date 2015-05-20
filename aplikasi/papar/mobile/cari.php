	<div data-role="content">
		<form method="get" action="">

		<div class="ui-field-contain">
			<label for="name">Full Name:</label>
			<input type="text" name="text" id="name" value="" placeholder="What's Your Name?">
		</div>
			
		<div class="ui-field-contain">
			<label for="search">Looking for anything?</label>
			<input type="search" name="search" id="search" value="" placeholder="Search for content">
		</div>

		<div class="ui-field-contain">
			<label for="date">Today's date:</label>
			<input type="date" name="date" id="date" value="">
		</div>
		  
		<div class="ui-field-contain">
			<label for="colors">Choose Favorite Color:</label>
			<select id="colors" name="colors">
			<option value="red">Red</option>
			<option value="green">Green</option>
			<option value="blue">Blue</option>
			</select>
		</div>
			
		<div class="ui-field-contain">
			<label for="switch">Flip Switch:</label>
			<input type="checkbox" data-role="flipswitch" name="switch" id="switch">
		</div>

		<div class="ui-field-contain">
			<legend>Choose Favorite Movies:</legend>
			<label for="mov1">The Shawshank Redemption</label>
			<input type="checkbox" name="mov1" id="mov1">
			<label for="mov2">The Godfather</label>
			<input type="checkbox" name="mov2" id="mov2">
			<label for="mov3">Pulp Fiction</label>
			<input type="checkbox" name="mov3" id="mov3">
		</div>

		</form>
		<a href="<?php echo URL ?>mobile/cariNama" data-icon="grid">Cari nama</a>
	</div>