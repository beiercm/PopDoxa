<!DOCTYPE html>
<html>
<head>
	<title>Pagniation in Practice</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h1>Advanced PHP Pagination Class Tutorial - Part (1/3)</h1>
		<?php
			require_once('get_connection.php'); 
			require_once('index.php');
			
			$conn = connection:: getinstance();
			$row_count = $con->row_count(); 

			if($row_count)
			{
				$data['total_records'] = $row_count; 
				$data['records_per_page'] = 2; 
				$data['pagination_url'] = "pagination.php"; 

				$page = new pagination; 
				$page->pagination_display($data); 
			}
			else

		?>
	</div>
</body>
</html>