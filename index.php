<?php
	$dirContent = array_diff(scandir('./'), array('.', '..', 'style'));
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
	 $page_links = '';
	 $sites_HTML = '';
	 foreach($data as $page) {
		 $page_links .= '<li><a href="'.$page['link'].'">'.$page['name'].'</a></li>';
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
		 ';
	 }
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
	<body>
		<div class='nav-bar'>
			<div class="nav-bar-inner">
				<h1><a href="/">TKON</a></h1>
				<nav>
					<ul>
						<li><a href='#'>About</a></li>
						<?= $page_links ?>
					</ul>
				</nav>
			</div>
		</div>
		<div class="main-content">
			<?= $sites_HTML ?>
		</div>
	</body>
</html>
