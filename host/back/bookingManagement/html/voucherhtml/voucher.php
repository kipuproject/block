<?php
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */
    // get the HTML
    ob_start();
    $num = 'CMD01-'.date('ymd');
    $nom = 'Kipu';
    $date = $fecha;
?>
<style type="text/css">
<!--
    div.zone { border: none; border-radius: 6mm; background: #FFFFFF; border-collapse: collapse; padding:3mm; font-size: 2.7mm;}
    h1 { padding: 0; margin: 0; color: black; font-size: 7mm; }
    h2 { padding: 0; margin: 0; color: #222222; font-size: 5mm; position: relative; }
	.tabla td{ border:1px solid whitesmoke;background:whitesmoke; font-size:12px;width:110px;
	
	}
-->
</style>

<page format="100x200" orientation="L" backcolor="whitesmoke" style="font: arial;">
    <div style="rotate: 90; position: absolute; width: 100mm; height: 4mm; left: 195mm; top: 0; font-style: italic; font-weight: normal; text-align: center; font-size: 2.5mm;">
Voucher Sistema de Reservas <?=$nombrehotel?> - Fecha <?php echo $date; ?>
    </div>
    <table style="width: 99%;border: none;" cellspacing="4mm" cellpadding="0">
        <tr>
            <td colspan="2" style="width: 100%">
                <div class="zone" style="height: 34mm;position: relative;font-size: 5mm;">
                    <div style="position: absolute; right: 3mm; top: 3mm; text-align: right; font-size: 4mm; ">
                        <b>Datos de Reserva:</b><br>
                    </div>
                    <div style="position: absolute; right: 3mm; bottom: 3mm; text-align: right; font-size: 4mm; ">
                        <b>Tipo de Habitación</b><br>
						<?=$typeRooms[$booking['ROOMTYPE']][0]['NAME']?> <br>
						
                        Valor por Noche : <b><?=number_format($vallornoche)?></b><br>
                        N° Referencia: <b><?=$booking['IDBOOKING']?></b><br>
                        Check In : <b><?=$checkin?></b><br> Check Out : <b><?=$chekcout?></b><br>
                    </div>
                    <h1>Voucher de Reserva</h1>
                    <b style="font-size:14px;">Fecha <?php echo $date; ?> </b><br>
                    <img src="<?=$logo?>" alt="logo">
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 25%;">
                <div class="zone" style="height: 40mm;vertical-align: middle;text-align: center;">
                   <img src="<?=$this->rutaURL?>/html/voucherhtml/qrplanet.png" alt="logo" style="height:40mm;">
                </div>
            </td>
            <td style="width: 75%">
                <div class="zone" style="height: 40mm;vertical-align: middle; text-align: justify">
                   
				<b>Detalle reserva </b><br>
						<table class="tabla" style="border:1px solid whitesmoke;"><tr>
									<td>Detalle</td>
									<td>Cantidad</td>
									<td>Valor Unitario</td>
									<td>Valor Total</td>
								</tr><tr>
									<td>No de Noches:</td>
									<td><?=$numnoches?></td>
									<td><?=number_format($vallornoche)?></td>
									<td>$<?=number_format($numnoches*$vallornoche)?></td>
								</tr><tr>
									<td>No de Niños:</td>
									<td><?=$booking['NUMKIDS']?></td>
									<td>-</td>
									<td>-</td>
								</tr><tr>
									<td>Adicionales:</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
								<tr>
									<td>Total:</td>
									<td></td>
									<td></td>
									<td>$<?=number_format($booking['VALUEBOOKING'])?></td>
								</tr></table>
		                                   
					<br>
					
                    <h2>Responsable de Reserva:</h2>
                    <b><?=$booking['NAMECLIENT']?></b>
                    <i>Identificacion: <?=$booking['DNI']?></i>
                </div>
            </td>
        </tr>
    </table>
</page>
<?php
     $content = ob_get_clean();

    // convert
    require_once(dirname(__FILE__).'/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('voucherkipu.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

