	<div class="box box-primary box-solid">
	  <div class="box-header">
	    <h3 class="box-title"><i class="fa fa-user"></i> Layanan Mandiri</h3>
	  </div>
	  <div class="box-body">
	  <ul id="ul-mandiri">
		  <table id="mandiri" width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tbody>
			  <tr>
				  <td width="25%">Nama</td>
				  <td width="2%" class="titik">:</td>
				  <td width="73%"><?php echo $_SESSION['nama']?></td>
			  </tr>
			  <tr>
				  <td bgcolor="#eee">NIK</td>
				  <td class="titik" bgcolor="#eee">:</td>
				  <td bgcolor="#eee"><?php echo $_SESSION['nik']?></td>
			  </tr>
			  <tr>
				  <td>No KK</td>
				  <td class="titik">:</td>
				  <td><?php echo $_SESSION['no_kk']?></td>
			  </tr>
			  <tr>
				  <td colspan="3">
					  <form action="<?php echo $mandiri_page?>" method="get">
						  <button type="submit" name="mandiri" value="profil" class="btn btn-primary btn-block">Profil</button>
					  </form>
				  </td>
			  </tr>
			  <tr>
				  <td colspan="3">
					  <form action="<?php echo $mandiri_page?>" method="get">
						  <button type="submit" name="mandiri" value="layanan" class="btn btn-primary btn-block">Layanan</button>
					  </form>
				  </td>
			  </tr>
			  <tr>
				  <td colspan="3">
					  <form action="<?php echo $mandiri_page?>" method="get">
						  <button type="submit" name="mandiri" value="lapor" class="btn btn-primary btn-block">Lapor</button>
					  </form>
				  </td>
			  </tr>
			  <tr>
				  <td colspan="3">
					  <form action="<?php echo $mandiri_page?>" method="get">
						  <button type="submit" name="mandiri" value="bantuan" class="btn btn-primary btn-block">Bantuan</button>
					  </form>
				  </td>
			  </tr>
			  <tr>
				  <td colspan="3">
					  <form action="<?php echo $mandiri_page?>" method="get">
						  <button type="submit" name="mandiri" value="logoff" class="btn btn-danger btn-block">Keluar</button>
					  </form>
				  </td>
			  </tr>
			  </tbody>
		  </table>
	  </ul>
  </div>
</div>
