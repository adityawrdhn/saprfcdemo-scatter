		<table>
		<tr>
			<th>No.</th>
			<th>Nama</th>
			<th>Competency</th>
			<th>Performance</th>
			<th>Quadran</th>
		</tr>
		<?php
		//koneksi ke database
		$con= mysqli_connect("localhost","root","","dbline" );
		$sql = mysqli_query($con,"SELECT * FROM talent_pool ORDER BY id ASC");
		$no = 1;
		while($data = mysqli_fetch_assoc($sql)){
			echo '
			<tr>
				<td>'.$no.'</td>
				<td>'.$data['nama'].'</td>
				<td>'.$data['value1'].'</td>
				<td>'.$data['value2'].'</td>
				<td>'.$data['quadran'].'</td>
			</tr>
			';
			$no++;
		}
		?>
		</table>