	<div class="artikel">
	  <?php if(!empty($daftar_bantuan)): ?>
	    <table  class="table table-bordered">
	      <caption><h3>Daftar Bantuan Yang Diterima (Sasaran Perorangan)</h3></caption>
	      <thead>
	        <tr>
	          <th>Nama</th>
	          <th>Awal</th>
	          <th>Akhir</th>
	          <th>ID KARTU</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php foreach ($daftar_bantuan as $bantuan) : ?>
	        <tr>
	          <td><?php echo $bantuan['nama']?></td>
	          <td><?php echo tgl_indo($bantuan['sdate'])?></td>
	          <td><?php echo tgl_indo($bantuan['edate'])?></td>
	          <td>
	            <?php if($bantuan['no_id_kartu']) : ?>
	              <button type="button" target="kartu_peserta" title="Kartu Peserta" href="<?php echo site_url('first/kartu_peserta/'.$bantuan['id'])?>" onclick="show_kartu_peserta($(this));" class="uibutton special"><span class="fa fa-print">&nbsp;</span><?php echo $bantuan['no_id_kartu']?></button>
	            <?php endif; ?>
	          </td>
	        </tr>
	      <?php endforeach; ?>
	      </tbody>
	    </table>
	  <?php else: ?>
	    <span>Anda tidak terdaftar dalam program bantuan apapun</span>
	  <?php endif; ?>
	</div>
