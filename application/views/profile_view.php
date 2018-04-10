<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>My Profile</title>
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/style.css"); ?>">
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url(); ?>profile">Sistem Antrian</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<?php if ($this->session->userdata('login')){ ?>
				<li><p class="navbar-text">Hello <?php echo $this->session->userdata('uname'); ?></p></li>
				<li><a href="<?php echo base_url(); ?>home/logout">Log Out</a></li>
				<?php } else { ?>
				<li><a href="<?php echo base_url(); ?>login">Login</a></li>
				<li><a href="<?php echo base_url(); ?>signup">Signup</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-4">
			<h4>Profil Pengguna</h4>
			<hr/>
			<p>Nama: <?php echo $uname; ?></p>
			<p>Email: <?php echo $uemail; ?></p><br>
            <p>Nomor Antrian User: <div id="nomor_user"><?php echo $antrian; ?></div><br>
            <p>Kode Booking User: <div id="kode_user"><?php echo $kode_booking; ?></div>
			<p>...</p>
		</div>
		<div class="col-md-8">
			<p>Tes Notifikasi</p>
                <?php
                    foreach ($antrian_sekarang as $antrian) {
                ?>
            <br>
            <br>
            <div class="container">
                <div class="row row-table">
                    <div class="col-md-4 col-table">
                        <div class="col-content bg">
                            <p class="text-center lead">Nomor Sekarang</p>
                            <div id="nomor_sekarang"><?php echo $antrian->nomor_sekarang; ?></div>

                        </div>
                    </div>
                    <div class="col-md-4 col-table">
                        <div class="col-content bg">
                            <p class="text-center lead">Nomor Antrian Tersedia</p>
                            <div id="nomor_antrian"><?php echo $antrian->nomor_antrian + 1; ?></div>
                            <button id="ambil_nomor" class="btn btn-primary" type="button" disabled="disabled">Ambil nomor</button>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="container text-center">
                        <div class="row row-table">
                            <div class="col-md-12">
                                <div class="lead">Kode Booking Anda</div><br>
                                <div id="kode_booking" class="lead"></div>
                            </div>
                        </div>
                </div>
            </div>

		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url("assets/bootstrap/js/jquery.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"></script>

<script type="application/javascript">
    $(document).ready(function() {
        cek_user_antri();

        setInterval(function() {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url('profile'); ?>",
                cache: false,
                success: function (data) {
                    var html = $.parseHTML(data);
                    $('#nomor_sekarang').text($(html).find('#nomor_sekarang').text());
                }
            });
        }, 10000);
        
    });

    $(function() {
        $('#ambil_nomor').click(function () {

            var dataNomor = $('#nomor_antrian').text();
            var dataAntrian = $('#nomor_antrian').text();
            var kode_booking = generate_kode();

            dataAntrian++;
            $.ajax({
                type: "GET",
                url: "<?php echo site_url('profile/ambil_nomor/'); ?>",
                data: {"hitung":dataNomor, "kode_booking":kode_booking},
                cache: false,
                success: function (html) {
                    $('#nomor_antrian').text(dataAntrian);
                    $('#kode_booking').text(kode_booking);
                    $('#nomor_user').text(html);
                    $('#kode_user').text(kode_booking);

                    cek_user_antri();

                }
            });
        });
    });

    function cek_user_antri() {
        var kode_user = $('#kode_user').text();

        if (kode_user == 0) {
            $('#nomor_user').text("Anda belum mengantri");
            $('#kode_user').text("Anda belum mengantri");
        }

        if (kode_user != 0) {
            $('#ambil_nomor').prop('disabled', true);
        } else {
            $('#ambil_nomor').prop('disabled', false);
        }
    }

    function generate_kode() {
        var chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
        var string_length = 10;
        var randomstring = '';
        var charCount = 0;
        var numCount = 0;

        for (var i=0; i<string_length; i++) {
            // If random bit is 0, there are less than 3 digits already saved, and there are not already 5 characters saved, generate a numeric value.
            if((Math.floor(Math.random() * 2) == 0) && numCount < 3 || charCount >= 5) {
                var rnum = Math.floor(Math.random() * 10);
                randomstring += rnum;
                numCount += 1;
            } else {
                // If any of the above criteria fail, go ahead and generate an alpha character from the chars string
                var rnum = Math.floor(Math.random() * chars.length);
                randomstring += chars.substring(rnum,rnum+1);
                charCount += 1;
            }
        }
        return randomstring
    }
</script>

<?php } ?>

</body>
</html>