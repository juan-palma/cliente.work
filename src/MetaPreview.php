<?php
	require 'src/MetaPreview.php';

	$preview = new MetaPreview();
	$data    = $preview->fetch($_POST['https://sca.cliente.work'] ?? '');
	echo json_encode($data);
?>