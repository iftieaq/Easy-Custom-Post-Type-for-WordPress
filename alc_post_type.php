<?php

/**
 * Alliance Post Type
 *
 * Create a custom post type in WordPress easily
 * with Alliance Post Type. Alliance post type will help
 * you to create a custom post type within a minute.
 * It will automatically generate all labels and
 * post updated labels and also give you a chance to use.
 * your own custom labels.
 *
 * It also supports custom taxonomy like category
 * and tags. APT also generate labels for custom taxonomy.
 *
 * @author Ifty Rahman
 * @copyright 2014 Ifty Rahman
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2
*/
 
class Alc_post_type
{
	
    public $type_name;
    public $type_type;
    public $label_args;
    public $supports_args;
    
	/**
     * The constructor
     *
     * Accepts the type name and supports array
     * 
     *
     * @param string $name post type name
     * @param array $supports post supports list such as thumbnail, title, content etc.
     * 
     */
	 
    function __construct($name = '', $supports = array())
	{
		
		// set post type name
        $this->type_name = strtolower($name);
        
		// call internal methods
        $this->change_labels();
        $this->supports($supports);
        $this->post_type();
        
        $this->updated_message('change_messages');
        $this->add_init(create_post_type);
	}
    
	/**
     * Set the post capability type
     *
     * Accepts the capability type name
     *
     * @param string $type capability type
     * 
	*/
	 
	public function post_type($type='post')
	{
		// set the capability_type
		$this->post_type = $type;
	}
	
	/**
     * Callback function
     *
     * Accepts the function name
     *
     * @param string $func the function name
     * 
	*/
    public function add_init($func)
	{
		// simple action method
        add_action('init', array($this, $func));
	}
    
	/**
     * Callback function for updated message
     *
     * Accepts the function name
     *
     * @param string $func the function name
     * 
	*/
    public function updated_message($func)
	{
		// simple filter method
        add_filter('post_updated_messages', array($this, $func));
	}

	
	/**
     * Set the supports details
     *
     * Accepts the custom support array
     * 
     * @param array $config the support array
     * 
	*/
    public function supports($config)
	{
        // this array will contain supports data
        $args = array();
        
		// set default support
        if (empty($config))
		{
            $args = array(
                'title',
                'editor',
                'thumbnail'
            );
		}
        else
		{
            $args = $config;
		}
        
		// set the support array
        $this->supports_args = $args;
	}
    
    	
	/**
     * Change default labels
     * 
     * @param array $config the support array
     * 
	*/
    public function change_labels($config = array())
	{
        
		// get the type name
        $name  = $this->type_name;
		
		// make the name capitalize
        $uname = ucwords($name);
        
		// set default labels for post type
        $defaults = array(
            'name' => $uname . 's',
            'singular_name' => $uname,
            'add_new' => 'Add New',
            'add_new_item' => 'Add New ' . $uname,
            'edit_item' => 'Edit ' . $uname,
            'new_item' => 'New ' . $uname,
            'all_items' => 'All ' . $uname . 's',
            'view_item' => 'View ' . $uname,
            'search_items' => 'Search ' . $uname . 's',
            'not_found' => 'No ' . $uname . 's found',
            'not_found_in_trash' => 'No ' . $uname . 's found in Trash',
            'parent_item_colon' => '',
            'menu_name' => $uname . 's'
        );
        
		// parse both arguments
        $args = wp_parse_args($config, $defaults);
        
		// set labels
        $this->label_args = $args;
	}
    
		
	/**
     * Change WordPress default notification message
     * 
     * @return array the new updated message
     * 
	*/
    public function change_messages($messages)
	{
        
		// make name capitalize
        $name = ucwords($this->type_name);
        
		// Change notification messages
        $messages[$this->type_name][1]  = $name . ' updated.';
        $messages[$this->type_name][4]  = $name . ' updated.';
        $messages[$this->type_name][6]  = $name . ' published.';
        $messages[$this->type_name][7]  = $name . ' saved.';
        $messages[$this->type_name][8]  = $name . ' submitted.';
        $messages[$this->type_name][9]  = $name . ' scheduled successfully.';
        $messages[$this->type_name][10] = $name . ' draft updated.';
        
		// return message
        return $messages;
        
	}
    
    	
	/**
     * Create a new post type
     * 
	*/
	
    public function create_post_type()
	{
		// register post type
        register_post_type($this->type_name, array(
            'labels' => $this->label_args,
            '_builtin' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'hierarchical' => true,
            'capability_type' => $this->post_type,
            'rewrite' => array(
                'slug' => $this->type_name,
                'with_front' => true
            ),
            'supports' => $this->supports_args
        ));
        
	}
    
    
    	
	/**
     * Set taxonomy labels
     *
     * Accepts the post type name
     * 
     * @param string $name the post type name
     * 
     * @return array return the the new labels array
	*/
	
    public function tax_labels($name)
	{
        
		// make name capitalize
        $uname = ucwords($name);
        
		// set tax labels
        $args = array(
            'name' => $uname,
            'singular_name' => $uname,
            'search_items' => 'Search ' . $uname . 's',
            'popular_items' => 'Popular ' . $uname . 's',
            'all_items' => 'All ' . $uname . 's',
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => 'Edit ' . $uname,
            'update_item' => 'Update ' . $uname,
            'add_new_item' => 'Add New ' . $uname,
            'new_item_name' => 'New ' . $uname . ' Name',
            'separate_items_with_commas' => 'Separate ' . $uname . 's with commas',
            'add_or_remove_items' => 'Add or remove ' . $uname . 's',
            'choose_from_most_used' => 'Choose from the most used ' . $uname . 's',
            'not_found' => 'No ' . $uname . 's found.',
            'menu_name' => $uname
        );
        
		// return the label arguments
        return $args;
        
	}
    
    
    	
	/**
     * Register the taxonomy
     *
     * Accepts the taxonomy name and taxonomy type
     * 
     * @param string $name the taxonomy name
     * @param string $type the taxonomy type, cats or tags
     * 
	*/
	
    public function add_tax($name, $type = 'cats')
	{
		// get the name
        $lname = strtolower($name);
		
		// make name capitalize
        $uname = ucwords($name);
        
		// taxonomy type tags or category?
        if ($type == 'tags')
          {
            $hierarchical = false;
          }
        else
          {
            $hierarchical = true;
          }
        
        // get the labels
        $labels = $this->tax_labels($lname);
        
		// set-up the parameters
        $args = array(
            'hierarchical' => $hierarchical,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array(
                'slug' => $lname
            )
        );
        
		// register the taxonomy
        register_taxonomy($lname, $this->type_name, $args);
        
		// call the method
        $this->add_init(add_tax);
	}
    
}

/*


// Example of uses

// create a video post type
$video = new Alc_post_type('video');

// set capability type, 'post' or 'page'. Default is post
$video->post_type('page');

// You can use your own labels
$custom_labels = array(
			'add_new' => 'Create New',
			'add_new_item' => 'Add New Item',
		);
		
// pass the label container array		
$video->change_labels($custom_labels);

// you can also define post supports
$video->supports(array('title', 'thumbnail', 'editor', 'comments'));

// create a taxonomy like tags. use 'tags' for second parameter if you want to create a taxonomy like tags
$video->add_tax('keyword', 'tags');

// create a taxonomy like category. use 'cats' for second parameter if you want to create a taxonomy like category
$video->add_tax('type', 'cats');


*/
