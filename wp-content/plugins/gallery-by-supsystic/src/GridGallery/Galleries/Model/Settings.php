<?php

/**
 * Class GridGallery_Galleries_Model_Settings
 *
 * @package GridGallery\Galleries\Model
 * @author Artur Kovalevsky
 */
class GridGallery_Galleries_Model_Settings extends GridGallery_Core_BaseModel
{

    /**
     * @var string
     */
    protected $table;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->table = $this->db->prefix . 'gg_settings_sets';
    }

    /**
     * Saves the settings to the database.
     *
     * @param int $id Gallery Id.
     * @param mixed $data The settings.
     */
    public function save($id, $data)
    {
        if (null === $this->get($id)) {
            return $this->insert($id, $data);
        }

        return $this->update($id, $data);
    }

    public function getCatsFromPreset($data, $config) {
        $config->load('@galleries/categories_presets.php');
        $presets = $config->get('categories_presets');
        $preset_number = isset($data['categories']) ? $data['categories']['preset'] : null;
        $customPresets = get_option('customCatsPresets');

		$index1 = (int)$preset_number - sizeof($presets);
        if(isset($customPresets[$index1])
                && !$presets[$preset_number] && !empty($customPresets) && $customPresets[$index1]['categories']) {

            $data['categories'] = array_merge($data['categories'], $customPresets[$index1]['categories']);
        } else {
            if(isset($presets[$preset_number]) && is_array($presets[$preset_number]) && !empty($presets[$preset_number])) {
                $data['categories'] = array_merge($data['categories'], $presets[$preset_number]);
            }
        }

        return $data;
    }

    public function getPagesFromPreset($data, $config) {
        $config->load('@galleries/pagination_presets.php');
        $presets = $config->get('pagination_presets');
        $preset_number = isset($data['pagination']) ? $data['pagination']['preset'] : null;
        $customPresets = get_option('customPagesPresets');

		$index1 = (int)$preset_number - sizeof($presets);
        if(isset($customPresets[$index1]) && !$presets[$preset_number]
            && !empty($customPresets) && $customPresets[$index1]['pagination']) {

            $data['pagination'] = array_merge($data['pagination'], $customPresets[$index1]['pagination']);
        } else {
            if(isset($presets[$preset_number]) && is_array($presets[$preset_number]) && !empty($presets[$preset_number])) {
                $data['pagination'] = array_merge($data['pagination'], $presets[$preset_number]);
            }
        }

        return $data;
    }

    public function settingsDiff($stats, $id, $data) {
        foreach($this->get($id)->data as $key => $value) {
            if(isset($data[$key]) && is_array($data[$key])) {
                if(is_array($value) && !empty($value)) {
                    $diffOptions = @array_diff_assoc($data[$key], $value);
                    $this->saveDiffOptions($stats, $key, $diffOptions);
                    foreach($value as $el => $opt) {
                        if(is_array($opt) && isset($data[$key][$el]) && is_array($data[$key][$el])) {
                            $diffOptions = @array_diff_assoc($data[$key][$el], $opt);
                            $this->saveDiffOptions($stats, $key, $diffOptions);
                        }
                    }
                }
            }
        }
    }

    public function saveDiffOptions($stats, $element, $diffOptions) {
        if(sizeof($diffOptions) > 0)
            foreach($diffOptions as $key => $value)
                $stats->save('settings.' . $element . '.' . $key);
    }

    public function isMobile($checkMobile) {

        if (!class_exists('Mobile_Detect')) {
            require_once 'plugins/Mobile_Detect.php';
        }

        $detect = new Mobile_Detect;
        if($detect->isMobile() && $checkMobile == 'on'){
            return true;
        }

        return false;
    }

    /**
     * Returns the settings for the gallery by id.
     *
     * @param int $id Gallery Id.
     * @return stdClass
     */
    public function get($id)
    {
        return $this->getBy('gallery_id', (int)$id);
    }


    public function getByGalleryId($galleryId)
    {
        return $this->get($galleryId);
    }

    public function getById($id)
    {
        return $this->getBy('id', (int)$id);
    }

    /**
     * Saves the data to the database.
     * @param int $id Gallery Id.
     * @param array $data
     * @return bool|int
     */
    protected function insert($id, $data)
    {
        $fields = array(
            'gallery_id' => $id,
            'data' => serialize($data)
        );

        $query = $this->getQueryBuilder()->insertInto($this->table)
            ->fields(array_keys($fields))
            ->values(array_values($fields));

        if (false !== $this->db->query($query->build())) {
            return true;
        }

        return false;
    }

    /**
     * Updates the settings.
     * @param int $id
     * @param array $data
     * @return bool
     */
    protected function update($id, $data)
    {
        $query = $this->getQueryBuilder()->update($this->table)
            ->where('gallery_id', '=', (int)$id)
            ->fields('data')
            ->values('%s');

        if (false !== $this->db->query(
            $this->db->prepare(
                $query->build(),
                serialize($data))
            )
        ) {
            return true;
        }

        return false;
    }

    protected function getBy($field, $value)
    {
        $query = $this->getQueryBuilder()->select('*')
            ->from($this->table)
            ->where($field, '=', $value);

        if (null !== $row = $this->db->get_row($query->build())) {
            if (isset($row->data)) {
                $row->data = unserialize($row->data);
            }
        }

		return $row;
    }

    public function getSettListByRegExp() {
		global $wpdb;
        $dbVersion = $wpdb->db_version();
        $dbVersion = $dbVersion ? $dbVersion : '8.0.0';
        $queryStr = 'SELECT id, gallery_id, data FROM '
            . $this->table;
        if (version_compare($dbVersion, '8.0.0', '>=')) {
            $queryStr .= ' WHERE data REGEXP \'^.*\"posts\";a\:[[:digit:]]+\:.*s:6:"enable";s:1:"1";.*;s:9:"autoposts";s:1:"1";.*$\'';
        } else {
            $queryStr .= ' WHERE data REGEXP \'^.*\"posts\";a\:[[:digit:]]+\:\{.*s:6:"enable";s:1:"1";.*;s:9:"autoposts";s:1:"1";.*\}.*$\'';
        }

		$settArr = $wpdb->get_results($queryStr, OBJECT);

		if(count($settArr) > 0) {
			foreach($settArr as $key => $elem) {
				$settArr[$key]->data = unserialize($settArr[$key]->data);
			}
		}

		return $settArr;
	}

    public function postThumb($galleries) {
        if($galleries) {
            foreach($galleries as $gallery) {
                if (isset($gallery->settings['posts']) && $gallery->settings['posts']['enable'] == '1') {
                    $postCover = wp_get_attachment_url(get_post_thumbnail_id($gallery->settings['posts']['current']));
                    if (!$postCover) {
                        $postCover = wp_get_attachment_url(get_post_thumbnail_id($gallery->settings['pages']['current']));
                    }
                    $gallery->settings['posts']['postCover'] = $postCover;
                    $gallery->settings['posts']['length'] = 0;
                    $posts = get_option('post_to_render' . $gallery->id);
                    $pages = get_option('pages_to_render' . $gallery->id);
                    if($posts) {
                        $gallery->settings['posts']['length'] += count($posts);
                    }
                    if($pages) {
                        $gallery->settings['posts']['length'] += count($pages);
                    }
                }
            }
        }
    }

    public function getPostsToRender($gallery_id) {
        $posts = array();
        if(get_option('post_to_render' . $gallery_id)) {
            foreach(get_option('post_to_render' . $gallery_id) as $id) {
                $row = array();
                $post = get_post($id);
                $row['author'] = get_user_by('id', $post->post_author)->user_login;
                $row['authorUrl'] = get_author_posts_url( get_the_author_meta( $post->post_author ), $row['author'] );
                $row['title'] = $post->post_title;
                $row['content'] = strip_tags($post->post_content);
                $row['date'] = get_post_time('M j, Y', false, $id, true);
                $row['dateUrl'] = get_day_link(mysql2date("Y", $post->post_date_gmt), mysql2date("m", $post->post_date_gmt), mysql2date("d", $post->post_date_gmt));
                $row['categories'] = $this->getCategories($id);
                $row['url'] = get_permalink($id);
                $row['photo'] = wp_get_attachment_url(get_post_thumbnail_id($id));
                $row['photoId'] = get_post_thumbnail_id($id);
                $posts[] = $row;
            }
        }
        return $posts;
    }

    public function getPagesToRender($gallery_id) {
        $pages = array();
        if(get_option('pages_to_render' . $gallery_id)) {
            foreach(get_option('pages_to_render' . $gallery_id) as $id) {
                $row = array();
                $page = get_post($id);
                $row['author'] = get_user_by('id', $page->post_author)->user_login;
                $row['authorUrl'] = get_author_posts_url( get_the_author_meta( $page->post_author ), $row['author']);
                $row['title'] = $page->post_title;
                $row['content'] = strip_tags($page->post_content);
                $row['date'] = get_post_time('M j, Y', false, $id, true);
                $row['dateUrl'] = get_day_link(mysql2date("Y", $page->post_date_gmt), mysql2date("m", $page->post_date_gmt), mysql2date("d", $page->post_date_gmt));
                $row['categories'] = $this->getCategories($id);
                $row['url'] = get_permalink($id);
                $row['photo'] = wp_get_attachment_url(get_post_thumbnail_id($id));
                $row['photoId'] = get_post_thumbnail_id($id);
                $pages[] = $row;
            }
        }
        return $pages;
    }

    public function getCategories($id) {
        $categories = array();
        foreach(wp_get_post_categories($id) as $category_id) {
            $row = array();
            $row['name'] = get_the_category_by_ID($category_id);
            $row['url'] = get_category_link($category_id);
            array_push($categories, $row);
        }
        return $categories;
    }

	static public function getFontsList() {
		return array("Default", "Abel", "Abril Fatface", "Aclonica", "Acme", "Actor", "Adamina", "Advent Pro",
			"Aguafina Script", "Aladin", "Aldrich", "Alegreya", "Alegreya SC", "Alex Brush", "Alfa Slab One", "Alice",
			"Alike", "Alike Angular", "Allan", "Allerta", "Allerta Stencil", "Allura", "Almendra", "Almendra SC", "Amaranth",
			"Amatic SC", "Amethysta", "Andada", "Andika", "Angkor", "Annie Use Your Telescope", "Anonymous Pro", "Antic",
			"Antic Didone", "Antic Slab", "Anton", "Arapey", "Arbutus", "Architects Daughter", "Arimo", "Arizonia", "Armata",
			"Artifika", "Arvo", "Asap", "Asset", "Astloch", "Asul", "Atomic Age", "Aubrey", "Audiowide", "Average",
			"Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre", "Averia Serif Libre", "Bad Script", "Balthazar",
			"Bangers", "Basic", "Battambang", "Baumans", "Bayon", "Belgrano", "Belleza", "Bentham", "Berkshire Swash",
			"Bevan", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Bitter", "Black Ops One", "Bokor", "Bonbon", "Boogaloo",
			"Bowlby One", "Bowlby One SC", "Brawler", "Bree Serif", "Bubblegum Sans", "Buda", "Buenard", "Butcherman",
			"Butterfly Kids", "Cabin", "Cabin Condensed", "Cabin Sketch", "Caesar Dressing", "Cagliostro", "Calligraffitti",
			"Cambo", "Candal", "Cantarell", "Cantata One", "Cardo", "Carme", "Carter One", "Caudex", "Cedarville Cursive",
			"Ceviche One", "Changa One", "Chango", "Chau Philomene One", "Chelsea Market", "Chenla", "Cherry Cream Soda",
			"Chewy", "Chicle", "Chivo", "Coda", "Coda Caption", "Codystar", "Comfortaa", "Coming Soon", "Concert One",
			"Condiment", "Content", "Contrail One", "Convergence", "Cookie", "Copse", "Corben", "Cousine", "Coustard",
			"Covered By Your Grace", "Crafty Girls", "Creepster", "Crete Round", "Crimson Text", "Crushed", "Cuprum", "Cutive",
			"Damion", "Dancing Script", "Dangrek", "Dawning of a New Day", "Days One", "Delius", "Delius Swash Caps",
			"Delius Unicase", "Della Respira", "Devonshire", "Didact Gothic", "Diplomata", "Diplomata SC", "Doppio One",
			"Dorsa", "Dosis", "Dr Sugiyama", "Droid Sans", "Droid Sans Mono", "Droid Serif", "Duru Sans", "Dynalight",
			"EB Garamond", "Eater", "Economica", "Electrolize", "Emblema One", "Emilys Candy", "Engagement", "Enriqueta",
			"Erica One", "Esteban", "Euphoria Script", "Ewert", "Exo", "Expletus Sans", "Fanwood Text", "Fascinate", "Fascinate Inline",
			"Federant", "Federo", "Felipa", "Fjord One", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky", "Forum",
			"Francois One", "Fredericka the Great", "Fredoka One", "Freehand", "Fresca", "Frijole", "Fugaz One", "GFS Didot",
			"GFS Neohellenic", "Galdeano", "Gentium Basic", "Gentium Book Basic", "Geo", "Geostar", "Geostar Fill", "Germania One",
			"Give You Glory", "Glass Antiqua", "Glegoo", "Gloria Hallelujah", "Goblin One", "Gochi Hand", "Gorditas",
			"Goudy Bookletter 1911", "Graduate", "Gravitas One", "Great Vibes", "Gruppo", "Gudea", "Habibi", "Hammersmith One",
			"Handlee", "Hanuman", "Happy Monkey", "Henny Penny", "Herr Von Muellerhoff", "Holtwood One SC", "Homemade Apple",
			"Homenaje", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell Double Pica", "IM Fell Double Pica SC",
			"IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer",
			"IM Fell Great Primer SC", "Iceberg", "Iceland", "Imprima", "Inconsolata", "Inder", "Indie Flower", "Inika",
			"Irish Grover", "Istok Web", "Italiana", "Italianno", "Jim Nightshade", "Jockey One", "Jolly Lodger", "Josefin Sans",
			"Josefin Slab", "Judson", "Julee", "Junge", "Jura", "Just Another Hand", "Just Me Again Down Here", "Kameron",
			"Karla", "Kaushan Script", "Kelly Slab", "Kenia", "Khmer", "Knewave", "Kotta One", "Koulen", "Kranky", "Kreon",
			"Kristi", "Krona One", "La Belle Aurore", "Lancelot", "Lato", "League Script", "Leckerli One", "Ledger", "Lekton",
			"Lemon", "Lilita One", "Limelight", "Linden Hill", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow",
			"Londrina Sketch", "Londrina Solid", "Lora", "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel",
			"Luckiest Guy", "Lusitana", "Lustria", "Macondo", "Macondo Swash Caps", "Magra", "Maiden Orange", "Mako", "Marck Script",
			"Marko One", "Marmelad", "Marvel", "Mate", "Mate SC", "Maven Pro", "Meddon", "MedievalSharp", "Medula One", "Merriweather",
			"Metal", "Metamorphous", "Michroma", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modern Antiqua",
			"Molengo", "Monofett", "Monoton", "Monsieur La Doulaise", "Montaga", "Montez", "Montserrat", "Moul", "Moulpali",
			"Mountains of Christmas", "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards",
			"Muli", "Mystery Quest", "Neucha", "Neuton", "News Cycle", "Niconne", "Nixie One", "Nobile", "Nokora", "Norican",
			"Nosifer", "Nothing You Could Do", "Noticia Text", "Nova Cut", "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round",
			"Nova Script", "Nova Slim", "Nova Square", "Numans", "Nunito", "Odor Mean Chey", "Old Standard TT", "Oldenburg",
			"Oleo Script", "Open Sans", "Open Sans Condensed", "Orbitron", "Original Surfer", "Oswald", "Over the Rainbow",
			"Overlock", "Overlock SC", "Ovo", "Oxygen", "PT Mono", "PT Sans", "PT Sans Caption", "PT Sans Narrow", "PT Serif",
			"PT Serif Caption", "Pacifico", "Parisienne", "Passero One", "Passion One", "Patrick Hand", "Patua One", "Paytone One",
			"Permanent Marker", "Petrona", "Philosopher", "Piedra", "Pinyon Script", "Plaster", "Play", "Playball", "Playfair Display",
			"Podkova", "Poiret One", "Poller One", "Poly", "Pompiere", "Pontano Sans", "Port Lligat Sans", "Port Lligat Slab",
			"Prata", "Preahvihear", "Press Start 2P", "Princess Sofia", "Prociono", "Prosto One", "Puritan", "Quantico",
			"Quattrocento", "Quattrocento Sans", "Questrial", "Quicksand", "Qwigley", "Radley", "Raleway", "Rammetto One",
			"Rancho", "Rationale", "Redressed", "Reenie Beanie", "Revalia", "Ribeye", "Ribeye Marrow", "Righteous", "Rochester",
			"Rock Salt", "Rokkitt", "Ropa Sans", "Rosario", "Rosarivo", "Rouge Script", "Ruda", "Ruge Boogie", "Ruluko",
			"Ruslan Display", "Russo One", "Ruthie", "Sail", "Salsa", "Sancreek", "Sansita One", "Sarina", "Satisfy", "Schoolbell",
			"Seaweed Script", "Sevillana", "Shadows Into Light", "Shadows Into Light Two", "Shanti", "Share", "Shojumaru",
			"Short Stack", "Siemreap", "Sigmar One", "Signika", "Signika Negative", "Simonetta", "Sirin Stencil", "Six Caps",
			"Slackey", "Smokum", "Smythe", "Sniglet", "Snippet", "Sofia", "Sonsie One", "Sorts Mill Goudy", "Special Elite",
			"Spicy Rice", "Spinnaker", "Spirax", "Squada One", "Stardos Stencil", "Stint Ultra Condensed", "Stint Ultra Expanded",
			"Stoke", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Suwannaphum", "Swanky and Moo Moo", "Syncopate",
			"Tangerine", "Taprom", "Telex", "Tenor Sans", "The Girl Next Door", "Tienne", "Tinos", "Titan One", "Trade Winds",
			"Trocchi", "Trochut", "Trykker", "Tulpen One", "Ubuntu", "Ubuntu Condensed", "Ubuntu Mono", "Ultra", "Uncial Antiqua",
			"UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "Unna", "VT323", "Varela", "Varela Round", "Vast Shadow",
			"Vibur", "Vidaloka", "Viga", "Voces", "Volkhov", "Vollkorn", "Voltaire", "Waiting for the Sunrise", "Wallpoet",
			"Walter Turncoat", "Wellfleet", "Wire One", "Yanone Kaffeesatz", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada"
		);
	}

	public function cloneByGalleryId($oldGalleryId, $newGalleryId) {

		$oldSett = $this->getBy('gallery_id', $oldGalleryId);
		if(property_exists($oldSett, 'data')) {
			$this->save($newGalleryId, $oldSett->data);
		}
		// clone options
		$oldOption = get_option('post_to_render' . $oldGalleryId);
		if(!empty($oldOption)) {
			update_option('post_to_render' . $newGalleryId, $oldOption);
		}
		return true;
	}
}
