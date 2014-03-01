## Usage

This class requires PHP 5. Make sure you have it running.

To intergate it, download the class file alc_post_type.php , and move it into the root of your theme directory. 

Next, include the alc_post_type.php file in your functions.php using include function

    include (TEMPLATEPATH . '/alc_post_type.php');

Now you have access to the class and its methods. At first instantiate the class.
For example we will us a video post type.

    $video = new Alc_post_type('video');

That's it. A custom post type has been created. Now you can use more codes to override some of default settings. For example, If you want you provide a support for title or editor or both, then use this.

  <pre><code>$video->supports(array('title', 'thumbnail', 'editor', 'comments'));</code></pre>
	
Now if you look carefully, you will see Alliance Post Type automatically generate labels such as 'Add New Video', 'Edit Video' etc. You can also overrride them using 'change_labels' method. Here is an example

<pre><code>$custom_labels = array(
			'add_new' => 'Create New',
			'add_new_item' => 'Add New Item',
		);

$video->change_labels($custom_labels);</code></pre>


You can also define capability type , post or page. Default is post. Example
$video->post_type('page');

That's not everything, However you can also create custom taxonomy for post your post type. If you want to create a taxonomy like categories, here is an example. The first parameater will be a name what you want and the second parameater is taxonomy type. It can be 'cats' or 'tags'. 

<pre><code>$video->add_tax('Type', 'cats');</code></pre>

To create a taxonomy like tags, use this

  <pre><code>$video->add_tax('Keywords', 'tags');</code></pre>

