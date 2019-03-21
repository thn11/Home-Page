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
					'link' => '/'.$f,
				];
			} else {
				return [
					'name' => $f,
					'link' => '/'.$f,
				];
			}
	 }, $folders);
	 $page_links = '';
	 foreach($data as $page) {
		 $page_links .= '<li><a href="'.$page['link'].'">'.$page['name'].'</a></li>';
	 }
?>

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
