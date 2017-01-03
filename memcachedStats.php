<?php

$memcache = new Memcache();
@$memcache->connect('127.0.0.1', 11211) or die ("Could not connect to memcache server");
?>
<!doctype html>
<html>
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Memcached</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<?php if ($memcache->getVersion() === false) { ?>
		Please, verify the Memcache configuration
	<?php }else{	?>
	<div class="container">
		<div class="row content">
			<div CLASS="col-md-12">
				<div STYLE="background-color:#2c3880; color:#fff; text-align:center; border-radius:2px;">
					<h3 STYLE="padding:13px 0px;">MEMCACHED
						<span style="float:right;"><?php echo "v".$memcache->getVersion();?></span>
					</h3>
				</div>
			</div>

			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover table-bordered" width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							
							<?php $memCacheStatsArr=$memcache->getStats();
								if(count($memCacheStatsArr)>0){
									foreach($memCacheStatsArr as $key=>$value){	?>
									<tr>
										<th><?php echo $key;?></th>
										<td><?php echo $value;?></td>
									</tr>
									<?php }								
								}							
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row content">
			<div CLASS="col-md-12">
				<div STYLE="background-color:#2c3880; color:#fff; text-align:center; border-radius:2px;">
					<h3 STYLE="padding:13px 0px;">KEYS
					</h3>
				</div>
			</div>

			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover table-bordered" width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							
							<?php $allSlabs = $memcache->getExtendedStats('slabs');
								if(count($allSlabs)>0){
									foreach($allSlabs as $server => $slabs) {
    									foreach($slabs AS $slabId => $slabMeta) {
        									if (!is_int($slabId)) {
       										     continue;
        									}
       										$cdump = $memcache->getExtendedStats('cachedump', (int) $slabId, 1000);
        									foreach($cdump AS $server => $entries) {
            									if ($entries) {
                									foreach($entries AS $eName => $eData) {	?>
                    									<tr>
															<td><?php echo $eName;?></td>
														</tr>
                									<?php }
            									}
        									}
    									}
									}						
								}							
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</body>
</html>
<?php @$memcache->close(); ?>