<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4">

<?php
//script php dimodifikasi berdasarkan script
//http://www.phpeasystep.com/phptu/18.html

//koneksi ke database
include "koneksi-database.php";


$namafile= $_FILES['filegbr']['name'];
$namafolder="gambar/"; //folder tempat menyimpan file
if (!empty($_FILES["filegbr"]["tmp_name"]))
{
    $jenis_gambar=$_FILES['filegbr']['type']; //memeriksa format gambar
    if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/png")
    {           
        $lampiran = $namafolder . basename($namafile);  
        
        //mengupload gambar dan update row table database dengan path folder dan nama image		
        if (move_uploaded_file($_FILES['filegbr']['tmp_name'], $lampiran)) 
		{
            
			$query_insert = "INSERT INTO datapic (img)
			VALUES ('$namafile')";
			$insert = mysql_query($query_insert);
			
			$data = "SELECT id,img from datapic order by id desc limit 1";
			$bacadata = mysql_query($data);
			$select_result = mysql_fetch_array($bacadata);			
			$id    = $select_result['id'];
			$img = $select_result['img'];

		     	if ($insert)
			    {
				$updatename	= "UPDATE datapic SET newname = CONCAT(id, '-',img)";
				$rename 	= mysql_query($updatename);		
				$dash = '-';				
			    rename($lampiran,$namafolder.$id.$dash.$img);
				
				}
				
				else
				{}
						
			$bacanm = "SELECT newname from datapic order by id desc limit 1";
			$baca 	= mysql_query($bacanm);
			$select_result = mysql_fetch_array($baca);			
			$newname    = $select_result['newname'];
			
			echo"
			<br/><br/><h2><span class='label label-success'>Data berhasil disimpan</span></h2> <br/>
			Nama File lama : $img <br/>
			Nama Baru : $newname <br/>
			
			
			<img src='$namafolder$newname' height='300'>";
			
			
			//Jika gagal upload, tampilkan pesan Gagal		
        } else {
           echo "Gambar gagal dikirim";
        }
   } else {
        echo "Jenis gambar yang anda kirim salah. Harus .jpg .gif .png";
   }
} else {
    echo "Anda belum memilih gambar";
}
?>

</div>
<div class="col-md-4"></div>
</div>

</body>
</html>