<div id="big_wrapper">
		<header>
				<div id="logo"><a href="/cms"><img src="/dynamique/logo/<?php echo(sslashesCMS($_SESSION['admLogo'])) ?>" width="565" height="439" alt="<?php echo(sslashesCMS($_SESSION['admClient'])) ?>"/></a></div>
				<div id="menu" >
						<ul <?php echo((!$_SESSION['login'])?('style="display:none"'):('')) ?>>
								<li>Accueil
									<ul>
												<li><a href="/cms/page/1">Contenu de l'accueil</a></li>
																
										</ul>
								
								</li>
								<li>Modules
										<ul>
												<li><a href="/cms/page/252"><strong>Ajouter utilisateurs</strong></a></li>
												<?php	
												
												sousMenuCMS($arrMenu,252);									
										
										
										?>											
										</ul>
								</li>
								
								
								
								
						</ul>
				</div>
				<div id="login">
						<ul>	
								<?php if(!$_SESSION['login']) { ?>
								<li><a href="/cms/">Vous n'êtes pas identifié</a></li>
								<?php } else { ?>
								<li><?php echo(sslashesCMS($_SESSION['loginNom'])) ?></li>
								<li><a href="/cms/deconnexion" title="Déconnexion"><i class="fa fa-sign-out fa-2x"></i></a></li>
								<?php } ?>
								
						</ul>
				</div>
		</header>
		<div id="wrapper">
				<section>	