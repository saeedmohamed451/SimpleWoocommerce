<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 5/28/2015
 * Time: 5:18 PM
 */
if (!class_exists('g5plusFramework_Admin')) {
	class g5plusFramework_Admin {

		private $prefix;


		private $version;


		public function __construct( $prefix, $version ) {
			$this->prefix = $prefix;
			$this->version = $version;

			add_action('wp_ajax_popup_icon', array($this,'popup_icon'));
		}

		/**
		 * Register the stylesheets for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles() {

            $pages = isset($_GET['page']) ? $_GET['page'] : '';
            if ($pages == '_options') return;


			wp_enqueue_style( $this->prefix.'admin', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME.'/admin/assets/css/admin.css'), array(), $this->version, 'all' );

			wp_enqueue_style( $this->prefix.'pe-icon-7-stroke', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME.'/admin/assets/plugins/pe-icon-7-stroke/css/styles.min.css'), array(), $this->version, 'all' );


			wp_enqueue_style( $this->prefix.'font-awesome', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME.'/admin/assets/plugins/fonts-awesome/css/font-awesome.min.css'), array(), '4.6.3', 'all' );

			wp_enqueue_style( $this->prefix.'popup-icon', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME.'/admin/assets/css/popup-icon.css'), array(), $this->version, 'all' );

			wp_enqueue_style( $this->prefix.'bootstrap-tagsinput', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME.'/admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'), array(), $this->version, 'all' );

			wp_enqueue_style('select2', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME.'/admin/assets/plugins/jquery.select2/css/select2.min.css'), array(), '4.0.3', 'all' );




		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts() {

			wp_enqueue_script( $this->prefix .'admin', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME.'/admin/assets/js/admin.js'), array( 'jquery' ), $this->version, false );


			wp_enqueue_script( $this->prefix .'bootstrap-tagsinput', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME.'/admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js'), array( 'jquery' ), $this->version, false );

			wp_enqueue_script('select2', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME.'/admin/assets/plugins/jquery.select2/js/select2.full.min.js'), array( 'jquery' ), '4.0.3', true );

			wp_enqueue_script( $this->prefix .'media-init', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME.'/admin/assets/js/g5plus-media-init.js'), array( 'jquery' ), $this->version, false );
			if (function_exists('wp_enqueue_media')) {
				wp_enqueue_media();
			}

			wp_enqueue_script( $this->prefix .'popup-icon', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME.'/admin/assets/js/popup-icon.js'), array( 'jquery' ), $this->version, false );

			wp_localize_script( $this->prefix .'admin' , 'g5plus_framework_meta' , array(
				'ajax_url' => admin_url( 'admin-ajax.php?activate-multi=true' )
			) );

		}

		public function popup_icon() {
			$icons = array('glass', 'music', 'search', 'envelope-o', 'heart', 'star', 'star-o', 'user', 'film', 'th-large', 'th', 'th-list', 'check', 'remove', 'close', 'times', 'search-plus', 'search-minus', 'power-off', 'signal', 'gear', 'cog', 'trash-o', 'home', 'file-o', 'clock-o', 'road', 'download', 'arrow-circle-o-down', 'arrow-circle-o-up', 'inbox', 'play-circle-o', 'rotate-right', 'repeat', 'refresh', 'list-alt', 'lock', 'flag', 'headphones', 'volume-off', 'volume-down', 'volume-up', 'qrcode', 'barcode', 'tag', 'tags', 'book', 'bookmark', 'print', 'camera', 'font', 'bold', 'italic', 'text-height', 'text-width', 'align-left', 'align-center', 'align-right', 'align-justify', 'list', 'dedent', 'outdent', 'indent', 'video-camera', 'photo', 'image', 'picture-o', 'pencil', 'map-marker', 'adjust', 'tint', 'edit', 'pencil-square-o', 'share-square-o', 'check-square-o', 'arrows', 'step-backward', 'fast-backward', 'backward', 'play', 'pause', 'stop', 'forward', 'fast-forward', 'step-forward', 'eject', 'chevron-left', 'chevron-right', 'plus-circle', 'minus-circle', 'times-circle', 'check-circle', 'question-circle', 'info-circle', 'crosshairs', 'times-circle-o', 'check-circle-o', 'ban', 'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'mail-forward', 'share', 'expand', 'compress', 'plus', 'minus', 'asterisk', 'exclamation-circle', 'gift', 'leaf', 'fire', 'eye', 'eye-slash', 'warning', 'exclamation-triangle', 'plane', 'calendar', 'random', 'comment', 'magnet', 'chevron-up', 'chevron-down', 'retweet', 'shopping-cart', 'folder', 'folder-open', 'arrows-v', 'arrows-h', 'bar-chart-o', 'bar-chart', 'twitter-square', 'facebook-square', 'camera-retro', 'key', 'gears', 'cogs', 'comments', 'thumbs-o-up', 'thumbs-o-down', 'star-half', 'heart-o', 'sign-out', 'linkedin-square', 'thumb-tack', 'external-link', 'sign-in', 'trophy', 'github-square', 'upload', 'lemon-o', 'phone', 'square-o', 'bookmark-o', 'phone-square', 'twitter', 'facebook-f', 'facebook', 'github', 'unlock', 'credit-card', 'feed', 'rss', 'hdd-o', 'bullhorn', 'bell', 'certificate', 'hand-o-right', 'hand-o-left', 'hand-o-up', 'hand-o-down', 'arrow-circle-left', 'arrow-circle-right', 'arrow-circle-up', 'arrow-circle-down', 'globe', 'wrench', 'tasks', 'filter', 'briefcase', 'arrows-alt', 'group', 'users', 'chain', 'link', 'cloud', 'flask', 'cut', 'scissors', 'copy', 'files-o', 'paperclip', 'save', 'floppy-o', 'square', 'navicon', 'reorder', 'bars', 'list-ul', 'list-ol', 'strikethrough', 'underline', 'table', 'magic', 'truck', 'pinterest', 'pinterest-square', 'google-plus-square', 'google-plus', 'money', 'caret-down', 'caret-up', 'caret-left', 'caret-right', 'columns', 'unsorted', 'sort', 'sort-down', 'sort-desc', 'sort-up', 'sort-asc', 'envelope', 'linkedin', 'rotate-left', 'undo', 'legal', 'gavel', 'dashboard', 'tachometer', 'comment-o', 'comments-o', 'flash', 'bolt', 'sitemap', 'umbrella', 'paste', 'clipboard', 'lightbulb-o', 'exchange', 'cloud-download', 'cloud-upload', 'user-md', 'stethoscope', 'suitcase', 'bell-o', 'coffee', 'cutlery', 'file-text-o', 'building-o', 'hospital-o', 'ambulance', 'medkit', 'fighter-jet', 'beer', 'h-square', 'plus-square', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-double-down', 'angle-left', 'angle-right', 'angle-up', 'angle-down', 'desktop', 'laptop', 'tablet', 'mobile-phone', 'mobile', 'circle-o', 'quote-left', 'quote-right', 'spinner', 'circle', 'mail-reply', 'reply', 'github-alt', 'folder-o', 'folder-open-o', 'smile-o', 'frown-o', 'meh-o', 'gamepad', 'keyboard-o', 'flag-o', 'flag-checkered', 'terminal', 'code', 'mail-reply-all', 'reply-all', 'star-half-empty', 'star-half-full', 'star-half-o', 'location-arrow', 'crop', 'code-fork', 'unlink', 'chain-broken', 'question', 'info', 'exclamation', 'superscript', 'subscript', 'eraser', 'puzzle-piece', 'microphone', 'microphone-slash', 'shield', 'calendar-o', 'fire-extinguisher', 'rocket', 'maxcdn', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-circle-down', 'html5', 'css3', 'anchor', 'unlock-alt', 'bullseye', 'ellipsis-h', 'ellipsis-v', 'rss-square', 'play-circle', 'ticket', 'minus-square', 'minus-square-o', 'level-up', 'level-down', 'check-square', 'pencil-square', 'external-link-square', 'share-square', 'compass', 'toggle-down', 'caret-square-o-down', 'toggle-up', 'caret-square-o-up', 'toggle-right', 'caret-square-o-right', 'euro', 'eur', 'gbp', 'dollar', 'usd', 'rupee', 'inr', 'cny', 'rmb', 'yen', 'jpy', 'ruble', 'rouble', 'rub', 'won', 'krw', 'bitcoin', 'btc', 'file', 'file-text', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-numeric-asc', 'sort-numeric-desc', 'thumbs-up', 'thumbs-down', 'youtube-square', 'youtube', 'xing', 'xing-square', 'youtube-play', 'dropbox', 'stack-overflow', 'instagram', 'flickr', 'adn', 'bitbucket', 'bitbucket-square', 'tumblr', 'tumblr-square', 'long-arrow-down', 'long-arrow-up', 'long-arrow-left', 'long-arrow-right', 'apple', 'windows', 'android', 'linux', 'dribbble', 'skype', 'foursquare', 'trello', 'female', 'male', 'gittip', 'gratipay', 'sun-o', 'moon-o', 'archive', 'bug', 'vk', 'weibo', 'renren', 'pagelines', 'stack-exchange', 'arrow-circle-o-right', 'arrow-circle-o-left', 'toggle-left', 'caret-square-o-left', 'dot-circle-o', 'wheelchair', 'vimeo-square', 'turkish-lira', 'try', 'plus-square-o', 'space-shuttle', 'slack', 'envelope-square', 'wordpress', 'openid', 'institution', 'bank', 'university', 'mortar-board', 'graduation-cap', 'yahoo', 'google', 'reddit', 'reddit-square', 'stumbleupon-circle', 'stumbleupon', 'delicious', 'digg', 'pied-piper-pp', 'pied-piper-alt', 'drupal', 'joomla', 'language', 'fax', 'building', 'child', 'paw', 'spoon', 'cube', 'cubes', 'behance', 'behance-square', 'steam', 'steam-square', 'recycle', 'automobile', 'car', 'cab', 'taxi', 'tree', 'spotify', 'deviantart', 'soundcloud', 'database', 'file-pdf-o', 'file-word-o', 'file-excel-o', 'file-powerpoint-o', 'file-photo-o', 'file-picture-o', 'file-image-o', 'file-zip-o', 'file-archive-o', 'file-sound-o', 'file-audio-o', 'file-movie-o', 'file-video-o', 'file-code-o', 'vine', 'codepen', 'jsfiddle', 'life-bouy', 'life-buoy', 'life-saver', 'support', 'life-ring', 'circle-o-notch', 'ra', 'resistance', 'rebel', 'ge', 'empire', 'git-square', 'git', 'y-combinator-square', 'yc-square', 'hacker-news', 'tencent-weibo', 'qq', 'wechat', 'weixin', 'send', 'paper-plane', 'send-o', 'paper-plane-o', 'history', 'circle-thin', 'header', 'paragraph', 'sliders', 'share-alt', 'share-alt-square', 'bomb', 'soccer-ball-o', 'futbol-o', 'tty', 'binoculars', 'plug', 'slideshare', 'twitch', 'yelp', 'newspaper-o', 'wifi', 'calculator', 'paypal', 'google-wallet', 'cc-visa', 'cc-mastercard', 'cc-discover', 'cc-amex', 'cc-paypal', 'cc-stripe', 'bell-slash', 'bell-slash-o', 'trash', 'copyright', 'at', 'eyedropper', 'paint-brush', 'birthday-cake', 'area-chart', 'pie-chart', 'line-chart', 'lastfm', 'lastfm-square', 'toggle-off', 'toggle-on', 'bicycle', 'bus', 'ioxhost', 'angellist', 'cc', 'shekel', 'sheqel', 'ils', 'meanpath', 'buysellads', 'connectdevelop', 'dashcube', 'forumbee', 'leanpub', 'sellsy', 'shirtsinbulk', 'simplybuilt', 'skyatlas', 'cart-plus', 'cart-arrow-down', 'diamond', 'ship', 'user-secret', 'motorcycle', 'street-view', 'heartbeat', 'venus', 'mars', 'mercury', 'intersex', 'transgender', 'transgender-alt', 'venus-double', 'mars-double', 'venus-mars', 'mars-stroke', 'mars-stroke-v', 'mars-stroke-h', 'neuter', 'genderless', 'facebook-official', 'pinterest-p', 'whatsapp', 'server', 'user-plus', 'user-times', 'hotel', 'bed', 'viacoin', 'train', 'subway', 'medium', 'yc', 'y-combinator', 'optin-monster', 'opencart', 'expeditedssl', 'battery-4', 'battery-full', 'battery-3', 'battery-three-quarters', 'battery-2', 'battery-half', 'battery-1', 'battery-quarter', 'battery-0', 'battery-empty', 'mouse-pointer', 'i-cursor', 'object-group', 'object-ungroup', 'sticky-note', 'sticky-note-o', 'cc-jcb', 'cc-diners-club', 'clone', 'balance-scale', 'hourglass-o', 'hourglass-1', 'hourglass-start', 'hourglass-2', 'hourglass-half', 'hourglass-3', 'hourglass-end', 'hourglass', 'hand-grab-o', 'hand-rock-o', 'hand-stop-o', 'hand-paper-o', 'hand-scissors-o', 'hand-lizard-o', 'hand-spock-o', 'hand-pointer-o', 'hand-peace-o', 'trademark', 'registered', 'creative-commons', 'gg', 'gg-circle', 'tripadvisor', 'odnoklassniki', 'odnoklassniki-square', 'get-pocket', 'wikipedia-w', 'safari', 'chrome', 'firefox', 'opera', 'internet-explorer', 'tv', 'television', 'contao', '500px', 'amazon', 'calendar-plus-o', 'calendar-minus-o', 'calendar-times-o', 'calendar-check-o', 'industry', 'map-pin', 'map-signs', 'map-o', 'map', 'commenting', 'commenting-o', 'houzz', 'vimeo', 'black-tie', 'fonticons', 'reddit-alien', 'edge', 'credit-card-alt', 'codiepie', 'modx', 'fort-awesome', 'usb', 'product-hunt', 'mixcloud', 'scribd', 'pause-circle', 'pause-circle-o', 'stop-circle', 'stop-circle-o', 'shopping-bag', 'shopping-basket', 'hashtag', 'bluetooth', 'bluetooth-b', 'percent', 'gitlab', 'wpbeginner', 'wpforms', 'envira', 'universal-access', 'wheelchair-alt', 'question-circle-o', 'blind', 'audio-description', 'volume-control-phone', 'braille', 'assistive-listening-systems', 'asl-interpreting', 'american-sign-language-interpreting', 'deafness', 'hard-of-hearing', 'deaf', 'glide', 'glide-g', 'signing', 'sign-language', 'low-vision', 'viadeo', 'viadeo-square', 'snapchat', 'snapchat-ghost', 'snapchat-square', 'pied-piper', 'first-order', 'yoast', 'themeisle', 'google-plus-circle', 'google-plus-official', 'fa', 'font-awesome');
            $pe_icon_7_stroke = array('pe-7s-album','pe-7s-arc','pe-7s-back-2','pe-7s-bandaid','pe-7s-car','pe-7s-diamond','pe-7s-door-lock','pe-7s-eyedropper','pe-7s-female','pe-7s-gym','pe-7s-hammer','pe-7s-headphones','pe-7s-helm','pe-7s-hourglass','pe-7s-leaf','pe-7s-magic-wand','pe-7s-male','pe-7s-map-2','pe-7s-next-2','pe-7s-paint-bucket','pe-7s-pendrive','pe-7s-photo','pe-7s-piggy','pe-7s-plugin','pe-7s-refresh-2','pe-7s-rocket','pe-7s-settings','pe-7s-shield','pe-7s-smile','pe-7s-usb','pe-7s-vector','pe-7s-wine','pe-7s-cloud-upload','pe-7s-cash','pe-7s-close','pe-7s-bluetooth','pe-7s-cloud-download','pe-7s-way','pe-7s-close-circle','pe-7s-id','pe-7s-angle-up','pe-7s-wristwatch','pe-7s-angle-up-circle','pe-7s-world','pe-7s-angle-right','pe-7s-volume','pe-7s-angle-right-circle','pe-7s-users','pe-7s-angle-left','pe-7s-user-female','pe-7s-angle-left-circle','pe-7s-up-arrow','pe-7s-angle-down','pe-7s-switch','pe-7s-angle-down-circle','pe-7s-scissors','pe-7s-wallet','pe-7s-safe','pe-7s-volume2','pe-7s-volume1','pe-7s-voicemail','pe-7s-video','pe-7s-user','pe-7s-upload','pe-7s-unlock','pe-7s-umbrella','pe-7s-trash','pe-7s-tools','pe-7s-timer','pe-7s-ticket','pe-7s-target','pe-7s-sun','pe-7s-study','pe-7s-stopwatch','pe-7s-star','pe-7s-speaker','pe-7s-signal','pe-7s-shuffle','pe-7s-shopbag','pe-7s-share','pe-7s-server','pe-7s-search','pe-7s-film','pe-7s-science','pe-7s-disk','pe-7s-ribbon','pe-7s-repeat','pe-7s-refresh','pe-7s-add-user','pe-7s-refresh-cloud','pe-7s-paperclip','pe-7s-radio','pe-7s-note2','pe-7s-print','pe-7s-network','pe-7s-prev','pe-7s-mute','pe-7s-power','pe-7s-medal','pe-7s-portfolio','pe-7s-like2','pe-7s-plus','pe-7s-left-arrow','pe-7s-play','pe-7s-key','pe-7s-plane','pe-7s-joy','pe-7s-photo-gallery','pe-7s-pin','pe-7s-phone','pe-7s-plug','pe-7s-pen','pe-7s-right-arrow','pe-7s-paper-plane','pe-7s-delete-user','pe-7s-paint','pe-7s-bottom-arrow','pe-7s-notebook','pe-7s-note','pe-7s-next','pe-7s-news-paper','pe-7s-musiclist','pe-7s-music','pe-7s-mouse','pe-7s-more','pe-7s-moon','pe-7s-monitor','pe-7s-micro','pe-7s-menu','pe-7s-map','pe-7s-map-marker','pe-7s-mail','pe-7s-mail-open','pe-7s-mail-open-file','pe-7s-magnet','pe-7s-loop','pe-7s-look','pe-7s-lock','pe-7s-lintern','pe-7s-link','pe-7s-like','pe-7s-light','pe-7s-less','pe-7s-keypad','pe-7s-junk','pe-7s-info','pe-7s-home','pe-7s-help2','pe-7s-help1','pe-7s-graph3','pe-7s-graph2','pe-7s-graph1','pe-7s-graph','pe-7s-global','pe-7s-gleam','pe-7s-glasses','pe-7s-gift','pe-7s-folder','pe-7s-flag','pe-7s-filter','pe-7s-file','pe-7s-expand1','pe-7s-exapnd2','pe-7s-edit','pe-7s-drop','pe-7s-drawer','pe-7s-download','pe-7s-display2','pe-7s-display1','pe-7s-diskette','pe-7s-date','pe-7s-cup','pe-7s-culture','pe-7s-crop','pe-7s-credit','pe-7s-copy-file','pe-7s-config','pe-7s-compass','pe-7s-comment','pe-7s-coffee','pe-7s-cloud','pe-7s-clock','pe-7s-check','pe-7s-chat','pe-7s-cart','pe-7s-camera','pe-7s-call','pe-7s-calculator','pe-7s-browser','pe-7s-box2','pe-7s-box1','pe-7s-bookmarks','pe-7s-bicycle','pe-7s-bell','pe-7s-battery','pe-7s-ball','pe-7s-back','pe-7s-attention','pe-7s-anchor','pe-7s-albums','pe-7s-alarm','pe-7s-airplay');
			ob_start();
			?>
			<div id="g5plus-framework-popup-icon-wrapper">
				<div class="popup-icon-wrapper">
					<div class="popup-content">
						<div class="icon-search">
							<input placeholder="Search" type="text" id="txtSearch">

							<div class="preview">
								<span></span> <a id="iconPreview" href="javascript:;"><i class="fa fa-home"></i></a>
							</div>
							<div style="clear: both;"></div>
						</div>
						<div class="list-icon">
							<h3>Font pe-icon-7-stroke</h3>
							<ul id="group-1">
								<?php foreach ($pe_icon_7_stroke as $icon) {
									?>
									<li><a title="<?php echo esc_attr($icon); ?>" href="javascript:;"><i class="<?php echo esc_attr($icon); ?>"></i></a></li>
									<?php

								} ?>
							</ul>
							<br>

							<h3>Font Awesome</h3>
							<ul id="group-1">
								<?php foreach ($icons as $icon) {
									?>
									<li><a title="fa fa-<?php echo esc_attr($icon); ?>" href="javascript:;"><i
												class="fa fa-<?php echo esc_attr($icon); ?>"></i></a></li>
									<?php

								} ?>
							</ul>
						</div>
					</div>
					<div class="popup-bottom">
						<a id="btnSave" href="javascript:;" class="button button-primary">Insert Icon</a>
					</div>
				</div>
			</div>

			<?php
			die(); // this is required to return a proper result
		}


	}
}