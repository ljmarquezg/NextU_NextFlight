<?php
	/*==================================================================================
						Configurar Child Theme
	==================================================================================*/
	add_action( 'wp_enqueue_scripts', 'next_flight_enqueue_styles' );
	function next_flight_enqueue_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'loader-style', get_stylesheet_directory_uri() . '/css/loader.css' );
		wp_enqueue_script( 'modal', get_stylesheet_directory_uri() . '/js/modal.js', array( 'jquery' ), '1.0', true ); 
	} 
	/*==================================================================================
		   					Reorganizar hoks
	==================================================================================*/
	//=========================== Header ==============================================
	//-------------------------- Agregar loader en el header---------------------------
	add_action('wp_head', 'loader');
	function loader() {
    ?>
	    <div class="loader-container">
	   		<div class="loader">
				<div class="inner one"></div>
				<div class="inner two"></div>
				<div class="inner three"></div>
				<div class="inner text">Loading destinations</div>
			</div>
		</div>
    <?php
	}
	?>
	<?php 
	//=========================== Despues del contenido =================================
	//-------------------------- Agregar formulario de vuelos --------------------------
	add_action('travel_agency_after_content', 'show_fligths',10);
	function show_fligths(){
		?>
		<section class="search-form">
			<div class="container">
				<div class="text">
            		<h2 class="title">Choose your destiny</h2>
        		</div>
    		</div>
    		<div class="form">
			<div class="travel-form">
			 		<?php echo do_shortcode('[tp_search_shortcodes slug="17702855"]')?>
				</div>
        	</div>
		</section>	
	<?php
	}
	?>
	<?php 
	//-------------------------- Agregar Hook con Rutas del mapa  --------------------------
	add_action('travel_agency_after_content', 'rutas_mapa',20);
	function rutas_mapa() {
	?>
	<section id="scroll-rutas" class="our-features" style="background:url(http://localhost/nextflight/wp-content/plugins/travel-agency-companion/includes/images/img13.jpg) no-repeat">
		
        <header class="section-header wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInUp;">
			<h2 class="section-title">Map Flight Routes</h2>
			<div class="section-content">
			<p>Check availables flights close to your location</p>
			</div>            
		</header>
   		<div class="features-holder wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInUp;">
	   		<div class="container">
    			<div class="form">
	            	<?php
             		echo do_shortcode('[tp_map_widget  width=100% height=500 direct=true subid=""]');
            		?>
        		</div>
    		</div>
		</div>   
	</section>
	<?php
	}
	?>	

	<?php 
	//-------------------------- Agregar Hook con ofertas de vuelos --------------------------
	add_action('travel_agency_after_content', 'ofertas',30);
	function ofertas() {
	?>
	<section class="activities" id="scroll-ofertas">
	    <header class="section-header">        
        	<div class="holder">
    			<h2 class="section-title">
					Check the offers we have for you
				</h2>
				<div class="section-content" title="Shift-click to edit this element.">
					<p> Check the best prices close to your location</p>
					<button class="btn-more title toggle" id="map-routes"><span>Show</span> Offers</button>
				</div>
				<div class="form toggler" style="display: none;">
					<?php
						echo do_shortcode('[tp_ducklett_widget responsive=true limit=6 type=brickwork filter=1  subid=""]');
					?>
        		</div>
    		</div>
   		</header>		
    </section>
	<?php
	}
	?>

	<?php
	//=========================== Antes del footer =================================
	//----------- Agregar el mapa con las oficinas de Next Flight ------------------
		add_action( 'travel_agency_after_content', 'agregar_mapa',90);
		function agregar_mapa(){
			echo do_shortcode('[intergeo id="AjM"][/intergeo]');
		};
	?>

	<?php 
	//========================Mapas en la sección footer ======================
	
	?>
<?php
	function travel_agency_header(){     
    $phone       = get_theme_mod( 'phone', __( '(888) 123-45678', 'travel-agency' ) );
    $phone_label = get_theme_mod( 'phone_label', __( 'Call us, we are open 24/7', 'travel-agency' ) );
    $ed_social   = get_theme_mod( 'ed_social_links', true );
    $ed_search   = get_theme_mod( 'ed_search', true ); 
    ?>
    <header class="site-header">
		
        <div class="header-holder">			
            <?php if( $ed_social || $ed_search ){ ?>
            <div class="header-t">
				<div class="container">
				<div class="flex-header">
					<?php if( $ed_social )
							echo'<div class="flex-content">';
							travel_agency_social_links(); 
							echo '</div>';?>

					<?php
						echo'<div class="flex-content contact">';
    						if( $phone_label ) echo '<span class="phone-label">' . esc_html( travel_agency_get_phone_label() ) . '</span>';
							if( $phone ) echo ' - <a href="' . esc_url( 'tel:' . preg_replace( '/\D/', '', $phone ) ) . '" class="tel-link"><span class="phone">' . esc_html( travel_agency_get_header_phone() ) . '</span></a>';
							echo '</div>';
                        ?>
					<div class="tools">
						<?php if( $ed_search ) echo'<div class="flex-content">'; travel_agency_get_header_search(); echo '</div>'; ?>						
					</div>                     
				</div>
				</div>
			</div> <!-- header-t ends -->
            <?php } ?>
            
            <div class="header-b">
				<div class="container">
					<div class="site-branding">
						<?php 
                	        if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                                the_custom_logo();
                            } 
                        ?>
                        <div class="text-logo">
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php
                			$description = get_bloginfo( 'description', 'display' );
                			if ( $description || is_customize_preview() ) : ?>
                				<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
                			<?php
                			endif; ?>
                        </div>
            		</div><!-- .site-branding -->
                    
                    <?php if( $phone_label || $phone ){ ?>
                    <div class="right">
					<div class="nav-holder">
			<div class="container">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="home-link"><i class="fa fa-home"></i></a>
                <div id="primary-toggle-button"><?php esc_html_e( 'MENU', 'travel-agency' );?><i class="fa fa-bars"></i></div>
                <nav id="site-navigation" class="main-navigation">
        			<?php
        				wp_nav_menu( array(
        					'theme_location' => 'primary',
        					'menu_id'        => 'primary-menu',
                            'fallback_cb'    => 'travel_agency_primary_menu_fallback',
        				) );
        			?>
        		</nav><!-- #site-navigation --> 
			</div>
		</div> <!-- nav-holder ends -->
                    </div>
                    <?php } ?>
                    
				</div>
			</div> <!-- header-b ends -->
                        
		</div> <!-- header-holder ends -->
	
	</header> <!-- header ends -->
    <?php
}
add_action( 'travel_agency_header', 'travel_agency_header', 20 );
	 