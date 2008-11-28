
function edit_block(delta) {
	//alert(delta);
	d = document.getElementById('producer_block_display_' + delta);
	e = document.getElementById('producer_block_edit_' + delta);
	b = document.getElementById('producer_block_cmd_' + delta)
	if (b.value == "Edit") {
		b.value = "Update";
		d.style.display = 'none';
		e.style.display = 'block';
	} else {
		b.value = "Edit";
		e.style.display = 'none';
		d.style.display = 'block';
		d.innerHTML = e.value;
		// todo: ajax call to save to profile info
	}
}

