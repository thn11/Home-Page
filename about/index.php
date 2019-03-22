<?php
	$dirContent = array_diff(scandir('./'), array('.', '..', 'style', '.git', '.sass-cache', 'components'));
	$folders = array_filter($dirContent, function ($c) {
			return is_dir('./'.$c);
	});
	$data = array_map(function ($f) {
			if (is_file('./'.$f.'/site.info')){
				$string = file_get_contents('./'.$f.'/site.info');
				$json = json_decode($string, true);
				return [
					'name' => $json['name'],
					'description' => $json['description'],
					'link' => '/'.$f,
				];
			} else {
				return [
					'name' => $f,
					'description' => 'No description yet.',
					'link' => '/'.$f,
				];
			}
	 }, $folders);
	 $sites_HTML = '';
	 foreach($data as $page) {
		 $sites_HTML .= '
			<a href="'.$page['link'].'">
				<div class="card">
					'. (is_file('./'.$page['link'].'/feature.png') ? '<image class="card-image" src="'.$page['link'].'/feature.png"></image>' : '') .'
					<div class="card-content">
						<h3 class="card-header">'.$page['name'].'</h3>
						<p class="card-text">'.$page['description'].'</p>
					</div>
				</div>
			</a>
			<br>
		 ';
	 }
?>

<html>
<?php include 'components/header.php'?>
	<body>
		<?php include 'components/nav.php' ?>

		<div class="main-content projects">
			<?= $sites_HTML ?>
		</div>

		<?php include 'components/footer.php' ?>
	</body>
</html>
