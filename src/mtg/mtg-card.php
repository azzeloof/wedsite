<div class="flip-container" ontouchstart="this.classList.toggle('hover');">	
<div class="flipper">	
<div class="card front">
	<div class="card-background">
		<article>
			<div class="card-body"></div>
			<header class="card-name">
				<div>
					<h1><?php echo($profile->name); ?></h1>
					<?php echo($profile->cost); ?>
				</div>
			</header>
				
			<div class="art">
				<img src="<?php echo($profile->image); ?>" width="100%" height="auto">
			</div>

			<header class="card-type">
				<div>
					<h2><?php echo($profile->type); ?> <i class="ss ss-tor"></i></h2>
				</div>
			</header>
		<div class="textBox">
			<p><?php echo($profile->description); ?></p>
			<blockquote>
				<p>“<?php echo($profile->quote); ?>”</p>
			</blockquote>
		</div>	
		<header class="powerToughness">
			<div>
				<h2><?php echo($profile->powerToughness); ?></h2>
			</div>
		</header>
		
		<footer>
			<p>100/100 C<br />
			ABC ‧ EN - Zeloof</p>
			<h6>™ &amp; © 2025 Cizards of the Woast</h6>
		</footer>
		
		</article>
		
	</div>
</div>
<div class="card back">
	<img src="mtg/images/Back.jpg" alt="Back" width="100%" height="auto">
</div>
</div>
</div>			
