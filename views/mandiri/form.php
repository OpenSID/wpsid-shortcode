<?php $this->load->helper('form') ?>
<div class="box box-primary box-solid">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-user"></i> Layanan Mandiri</h3><br>
			Silakan datang atau hubungi operator desa untuk mendapatkan kode PIN anda.
		</div>
		<div class="box-body">
			<?php echo (isset($_POST['mandiri']) && isset($_SESSION['mandiri']) && $_SESSION['mandiri'] == -1) ? '<span style="color: red !important"><strong>NIK atau PIN salah!</strong></span><br>' : '';?>
			<h4>Masukan NIK dan PIN</h4>
			<?=form_open($mandiri_page)?>
				<input name="nik" type="text" placeholder="NIK" style="margin-left:0px" value="<?php echo (OPENSID_DEMO_SITE) ? '5201142005716996' : '';?>" required="">
				<input name="pin" type="password" placeholder="PIN" style="margin-left:0px" value="<?php echo (OPENSID_DEMO_SITE) ? '123456' : '';?>" required="">
				<button type="submit" name="mandiri" value="login" id="submit" style="margin-left:0px">Masuk</button>
			</form>
		</div>
	</div>
