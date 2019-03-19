<?php
	$dirContent = array_diff(scandir('./'), array('.', '..', 'style', '.git', '.sass-cache'));
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
			<br>
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
				<h1><a href="/">Thomas Næsje</a></h1>
				<nav>
					<ul>
						<li><a href='#'>About</a></li>
						<li>
							<a href='projects'>Projects</a>
							<ul>
								<?= $page_links ?>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="main-content">
			<?= $sites_HTML ?>
		</div>
	</body>
</html>
