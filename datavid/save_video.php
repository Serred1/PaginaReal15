<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/demoalert.js"></script>
</head>

<body>
    <div id="alert-container"></div>
    <?php
    $alertMessage = '';
    $alertType = '';
	date_default_timezone_set('America/Mexico_City');
	require_once 'conn.php';
	
	if(ISSET($_POST['save'])){
		$file_name = $_FILES['video']['name'];
		$file_temp = $_FILES['video']['tmp_name'];
		$file_size = $_FILES['video']['size'];
		
		if($file_size < 150000000){
			$file = explode('.', $file_name);
			$end = end($file);
			$allowed_ext = array('avi', 'flv', 'wmv', 'mov', 'mp4');
			if(in_array($end, $allowed_ext)){
				$name = $file_name;
				$location = '../video/'.$name.".".$end;
				$sql=$conn->query("SELECT * FROM video WHERE video_name='$name'");
				if($datos=$sql->fetch_object()){
					$alertMessage = 'Este video ya existe';
                    $alertType = 'error';
				}else{
					if(move_uploaded_file($file_temp, $location)){
						mysqli_query($conn, "INSERT INTO `video` VALUES('', '$name', '$location')") or die(mysqli_error());
						$alertMessage = 'Video agregado';
                        $alertType = 'success';
					}
				}
				
			}else{
				$alertMessage = 'Formato de video invalido';
                    $alertType = 'error';
			}
		}else{
			$alertMessage = 'Archivo muy pesado';
            $alertType = 'error';
		}
	}
?>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (!empty($alertMessage)) : ?>
                Swal.fire({
                    title: '<?php echo $alertMessage; ?>',
                    icon: '<?php echo $alertType; ?>',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redireccionar a la página videos.php tanto para 'success' como para 'error'
                        window.location.href = 'videos.php';
                    }
                });
            <?php endif; ?>
        });
    </script>
</body>

</html>