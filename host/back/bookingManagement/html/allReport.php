<meta charset="utf-8">
  <table border="1"> 
    <thead>
      <tr>
        <!--th>Creacion</th-->
        <th>#</th>
        <th>Origen</th>
        <th>Habitacion</th>
        <th>Responsable</th>
        <th>Correo</th>
        <th>Telefono</th>
        <th>Check In <br/> dd-mm-yyyy</th>
        <th>Check Out <br/> dd-mm-yyyy</th>
        <th>ADULTOS</th>
        <th>NIÑOS</th>
        <th>INFANTES</th>
        <th>Notas <br/> Cliente</th>
        <th>Notas <br/> Hotel</th>
        <th>Valor</th>
        <th>Estado</th>
        <th>Abono</th>
        <th>Saldo</th>
        <!--th class='hidden-480'></th-->
      </tr>
    </thead>
    <tbody>
    <?php
    setlocale(LC_ALL,"es_ES"); 
    $i=0;
    while(isset($bookings[$i][0])):
      $id = $bookings[$i]['IDBOOKING'];
      $abono = isset($payments[$id])?$payments[$id ][0]['VALUE']:0;
      $local = !empty($bookings[$i]['LOCALPAYMENT'])?$bookings[$i]['LOCALPAYMENT']:0;
      $abono = $abono + $local;
      
    ?>
      <tr>
        <td><?=$i?></td>
        <td><?=$bookings[$i]['SOURCE']?></td> 
        <td class='hidden-350'><?=$bookings[$i]['NAMERESERVABLE']?></td>
        <td class='hidden-480'><?=$users[$bookings[$i]['CUSTOMER']][0]['NAMECLIENT']?></td> 
        <td class='hidden-480'><?=$users[$bookings[$i]['CUSTOMER']][0]['EMAILCLIENT']?></td> 
        <td class='hidden-480'><?=$users[$bookings[$i]['CUSTOMER']][0]['PHONECLIENT']?></td> 
        <td class='hidden-1024'><?=date("d-m-Y",strtotime($bookings[$i]['DATESTART']))?></td>
        <td class='hidden-480'><?=date("d-m-Y",strtotime($bookings[$i]['DATEEND']))?></td> 
        <td class='hidden-480'><?=$bookings[$i]['NUMGUEST']?></td> 
        <td class='hidden-480'><?=$bookings[$i]['NUMKIDS']?></td> 
        <td class='hidden-480'><?=$bookings[$i]['INFANTS']?></td> 
        <td class='hidden-480'><?=$bookings[$i]['OBSERVATION_CUSTOMER']?></td>
        <td class='hidden-480'><?=$bookings[$i]['OBSERVATION']?></td>
        <td class='hidden-480'><?=$bookings[$i]['PAYMENT']?></td>
        <td class='hidden-480'><?=($statusBoooking[$bookings[$i]['STATEBOOKING']])?></td>
        
        <td class='hidden-480'><?=$abono?></td>
        <td class='hidden-480'><?=($bookings[$i]['PAYMENT']-$abono)?></td>
        
      </tr>
    <?php
    $i++;
    endwhile;
    ?>
    </tbody>
  </table>
		