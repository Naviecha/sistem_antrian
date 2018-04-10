<?php
    include_once('db.php');
    $result = mysqli_query($con,"select count from user");
    $row = mysqli_fetch_assoc($result);
?>
<html>
    <title>Hitung Click</title>
    <head>
        <script type="text/javascript" src="http://localhost/dorm/assets/bootstrap/js/jquery.min.js"></script>
        <script type="text/javascript" >
            $(function() {
            $("#ambil_nomor").click(function() {
                $.ajax({
                    type: "POST",
                    url: "data_update.php",
                    data: "current_count="+ $('#display').text(),
                    cache: false,
                    success: function(html){
                        $("#display").text(html);
                    }
                });
            });
            });
        </script>

        <script type="text/javascript" >
            $(function() {
            $("#reset_count").click(function() {
                $.ajax({
                    type: "POST",
                    url: "data_update.php",
                    data: "reset_count="+ $('#display').text(),
                    cache: false,
                    success: function(html){
                        $("#display").text(html);
                    }
                });
            });
            });
        </script>

        <style type="text/css">
        	#ambil_nomor {
			    background-color: #4CAF50; /* Green */
			    border: none;
			    color: white;
			    padding: 15px 32px;
			    text-align: center;
			    font-size: 18px;
			    margin-top: -120px;
				margin-left: -250px;
				position: fixed;
				top: 50%;
				left: 50%;
			}

			#reset_count {
			    background-color: #4CAF50; /* Green */
			    border: none;
			    color: white;
			    padding: 15px 32px;
			    text-align: center;
			    font-size: 18px;
			    margin-top: -120px;
				margin-left: -30px;
				position: fixed;
				top: 50%;
				left: 50%;
			}

			#display {
				font-size: 70;
				text-align: center;
				margin-top: 130px;
				margin-left: -120px;
			}	
        </style>

    </head>
    <body>
    	<button id="ambil_nomor" type="button">Ambil nomor</button>
    	<button id="reset_count" type="button">Reset Antrian</button>
        <div id="display"><?php echo $row['count']; ?></div>
    </body>

</html>