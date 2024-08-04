<!DOCTYPE html>
<html>
<style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
<body>
<div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="6">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="<?php echo base_url();?>src/images/logo_CORP_03_1.jpg" alt="..." width="200" height="100">
                            </td>
                            <td>
                                Tanda Terima Gaji<br>
								Bulan : <?php echo date("m-Y", strtotime(date($slip->bulan_gaji))); ?><br>
								Periode : <?php echo $slip->periode_gaji; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="6">
                    <table>
                        <tr>
                            <td>
								NIP<br>
                                Nama<br>
                                Jabatan
                            </td>
							<td></td>
							<td>
                                : <?php echo $slip->nip; ?><br>
                                : <?php echo $slip->nama; ?><br>
								: <?php echo $slip->jabatan; ?>
                            </td>
							<td>
								Jml Hari Kerja<br>
								Surat Dokter<br>
                                Cuti
							</td>
							<td>
								: <br>
								: <br>
                                :
							</td>
							<td align='right'>
								<?php echo $slip->hari_kerja_berjalan; ?><br>
								<?php echo $slip->surat_dokter; ?><br>
								<?php echo $slip->potong_cuti; ?>
							</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
				<td colspan="6">
                <table>
				<thead>
				  <tr>
					<th bgcolor="#008080"><font color="white">Keterangan</font></th>
					<th bgcolor="#008080"><font color="white">Nom</font></th>
					<th bgcolor="#008080"><font color="white">Keterangan</font></th>
					<th bgcolor="#008080"><font color="white">Nom</font></th>
				  </tr>
				</thead>
				<tr>
					<td>
						Gaji Pokok
					</td>
					<td align="right">
						<?php $number = $slip->gapok; $nom = number_format($number); echo $nom;?>.-
					</td>
					<td>
						Potongan kasbon
					</td>
					<td align="right">
						<?php $number = $slip->pot_kasbon; $nom = number_format($number); echo $nom;?>,-
					</td>
				</tr>
				<tr>
					<td>
						Tunjangan transport
					</td>
					<td align="right">
						<?php $number = $slip->tu_transport; $nom = number_format($number); echo $nom;?>.-
					</td>
					<td>
						Potongan Absensi
					</td>
					<td align="right">
						<?php $number = $slip->pot_absen; $nom = number_format($number); echo $nom;?>.-
					</td>
				</tr>
				<tr>
					<td>
						Uang makan
					</td>
					<td align="right">
						<?php $number = $slip->tu_makan; $nom = number_format($number); echo $nom;?>.-
					</td>
					<!--td>
						Potongan Terlambat
					</td>
					<td align="right">
						<?php //$number = $slip->pot_terlambat; $nom = number_format($number); echo $nom;?>
					</td-->
					<td>
						Potongan BPJS TK
					</td>
					<td align="right">
						<?php $number = $slip->pot_bpjs_tk; $nom = number_format($number); echo $nom;?>.-
					</td>
				</tr>
				<tr>
					<td>
						Insentif
					</td>
					<td align="right">
						<?php $number = $slip->tu_insentif; $nom = number_format($number); echo $nom;?>.-
					</td>
					
					<!--td>
						Potongan Pulang
					</td>
					<td align="right">
						<?php //$number = $slip->pot_pulang; $nom = number_format($number); echo $nom;?>
					</td-->
				</tr>
				<tr>
					<td>
						Uang Lembur
					</td>
					<td align="right">
						<?php $number = $slip->tu_lembur; $nom = number_format($number); echo $nom;?>.-
					</td>
					<!--td>
						Potongan BPJS TK
					</td>
					<td align="right">
						<?php $number = $slip->pot_bpjs_tk; $nom = number_format($number); echo $nom;?>.-
					</td-->
				</tr>
				<tr>
					<td>
						BPJS Kesehatan 
					</td>
					<td align="right">
						<?php $number = $slip->tu_bpjs_kes; $nom = number_format($number); echo $nom;?>.-
					</td>
					<td>
						<!--Pinjaman Koperasi-->
					</td>
					<td align="right">
						<?php //$number = $slip->pot_koperasi; $nom = number_format($number); echo $nom;?>
					</td>
				</tr>
				<tr>
					<td>
						<!--Tunjangan Jabatan-->
					</td>
					<td align="right">
						<?php //$number = $slip->tu_jabatan; $nom = number_format($number); echo $nom;?>
					</td>
					<td>
						<!--Potongan WFH-->
					</td>
					<td align="right">
						<?php //$number = $slip->pot_wfh; $nom = number_format($number); echo $nom;?>
					</td>
				</tr>
				<!--tr>
					<td>
						Tunjangan BPJS TK
					</td>
					<td align="right">
						<?php //$number = $slip->tu_bpjs_tk; $nom = number_format($number); echo $nom;?>
					</td>
					<!--td>
						 Potongan BPJS Kes
					</td>
					<td align="right">
						<?php //$number = $slip->pot_bpjs_kes; $nom = number_format($number); echo $nom;?>.-
					</td>
				</tr-->
				<tr bgcolor="#008080">
					<td>
						<font color="white">Total Gaji <?php $number = $slip->hari_kerja; $nom = number_format($number); echo $nom; ?> Hari</font>
					</td>
					<td align="right">
						<font color="white"><?php $number = $slip->gross_gaji; $nom = number_format($number); echo $nom;?>.- </font>
					</td>
					<td>
						<font color="white">Jumlah Potongan</font>
					</td>
					<td align="right">
						<font color="white"><?php $number = $slip->pot_total; $nom = number_format($number); echo $nom;?>.-</font>
					</td>
				</tr>
				<tr bgcolor="#fffff">
					<td>
						
					</td>
					<td align="right">
						
					</td>
					
					<td>

					</td>
					<td align="right">

					</td>
				</tr>
				<tr bgcolor="#fffff">
					<td>
						Upah Per/Hari<br>
					</td>
					<td align="right">
						
					</td>
					<td align="right">
						: Rp.<br>
					</td>
					<td align="right">
						<?php $number = $slip->upah_perhari; $nom = number_format($number); echo $nom;?>.-
					</td>
				</tr>
				<tr bgcolor="#fffff">
					<td style="border-top: 1px solid #cdd0d4;">
						Total Gaji <?php $number = $slip->hari_kerja_berjalan; $nom = number_format($number); echo $nom; ?> Hari<br>
						Total Potongan<br>
					</td>
					<td align="right" style="border-top: 1px solid #cdd0d4;">
						+<br>
						-<br>
					</td>
					<td align="right" style="border-top: 1px solid #cdd0d4;">
						: Rp.<br>
						: Rp.<br>
					</td>
					<td align="right" style="border-top: 1px solid #cdd0d4;">
						<?php $number = (($slip->hari_kerja_berjalan)*($slip->upah_perhari)); $nom = number_format($number); echo $nom; ?>.-<br>
						<?php $number = $slip->pot_total; $nom = number_format($number); echo $nom;?>.-<br>
					</td>
				</tr>
				<tr bgcolor="#fffff">
					<td style="border-top: 1px solid #cdd0d4;">
						<font style="font-weight: bold">Gaji Diterima: </font>
					</td>
					<td align="right" style="border-top: 1px solid #cdd0d4;">
						
					</td>
					<td align="right" style="border-top: 1px solid #cdd0d4;">
						: Rp.<br>
					</td>
					<td align="right" style="border-top: 1px solid #cdd0d4;">
						<font style="font-weight: bold"><?php $number = $slip->net_gaji; $nom = number_format($number); echo $nom;?>.-</font>
					</td>
				</tr>
				</table>
				</td>
            </tr>
        </table>
    </div>
</body>

</html>
