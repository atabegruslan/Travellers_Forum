## Site

http://ruslan-website.com/wp5/travellers_forum/

## Start with a minimal theme

1. http://wp-puzzle.com/basic/
2. http://html5blank.com/ (more minimal)
3. My Basic theme (even more minimal)

## Install some plugins

- Akeeba
- Custom Post Type UI
- Advanced Custom Fields Pro

We will need those later.

## Ready SMTP Server

https://github.com/Ruslan-Aliyev/mail/tree/master#ready-smtp-server

## Ready WP Mail SMTP Plugin

https://wordpress.org/plugins/wp-mail-smtp/

wp-admin > Settings > WP Mail SMTP > Settings tab

| Field  | Value  |
|---|---|
| From Email  | Give value  |
| From Name  | Give value  |
| Other SMTP  | Tick  |
| Return Path  | Tick  |
| SMTP Host  | smtp.gmail.com  |
| Encryption  | TLS  |
| SMTP Port  | 587  |
| Authentication  | On  |
| SMTP Username  | Your Gmail Username  |
| SMTP Password  | Your Gmail Password  |

It's better to have this mail plugin, because this would make mailing work on both localhost and server.
When using Ultimate Member (User Accounts plugin) next, this mailing plugin will become useful.

## Ultimate Members

https://wordpress.org/plugins/ultimate-member/

https://www.youtube.com/watch?v=AuAPvSmo3CQ

https://www.youtube.com/watch?v=so33OViB4R0 

wp-admin > Settings > General > Membership: Anyone can register = Tick Yes

wp-admin > Settings > General > New User Default Role = Subscriber

Once you installed and activated Ultimate Members, you will be lead back to `wp-admin/plugins.php`.

It's best if you click `settings` under Ultimate Members now, then click `Add Pages`. Else you will have to manually add those pages later.

After setup, you will realize that the Classic Editor is automatically replaced by the Gutenberg Editor
To change it back: 

wp-admin > Settings > Writting > Classic Editor settings: select your wanted editor

https://www.wpbeginner.com/plugins/how-to-disable-gutenberg-and-keep-the-classic-editor-in-wordpress/

You might need to reinstall Classic Editor again (https://wordpress.org/plugins/classic-editor/)

A few pages will be automatically added for you:

| Name  | Content  |
|---|---|
| Account  | [ultimatemember_account]  |
| Login  | [ultimatemember form_id="9"]  |
| Logout  |   |
| Members  | [ultimatemember form_id="11"]  |
| Password Reset  | [ultimatemember_password]  |
| Privacy Policy  | Who we are (blah blah ...)  |
| Register  | [ultimatemember form_id="8"]  |
| User  | [ultimatemember form_id="10"]  |

wp-admin > Ultimate Member > Settings > Email tab > Activate `Account Activation Email`.

wp-admin > Ultimate Member > User Roles -> select Subscriber > Registration Status = Require Email Activation

https://wordpress.org/support/topic/ultimate-member-email-verification-possible/

Sometimes Ultimate Member pages won't display properly, in which case, just add to css:
```css
.um {
    opacity: 1 !important;
}
```

Also don't forget to include `get_footer` and `wp_footer`, as that will include the needed `<script>`s.

#### Create menu named "User Accounts" with "Display Location" being `uac_menu_links`.

Menu Items:

| Name  | Renamed  | Permissions  |
|---|---|---|
| User  | My Profile  | Everyone  |
| - Login  |   | Logged out users  |
| - Register  |   | Logged out users  |
| - Logout  |   | Logged in users  |
| - Account  |   | Logged in users  |
| - Password Reset  |   | Everyone  |
| Members  | Community  | Logged in users  |

In `functions.php`

```
register_nav_menus(
	array(
		'uacmenu' => __('uac_menu_links')
	)
);
```

In `header.php`

```
$args = array(
	'theme_location' => 'uacmenu',
	'menu_class' => 'uac_menu'
);
wp_nav_menu($args);
``` 

#### Author archive link issue

Ultimate Member plugin always wants to redirect the author archive link to author's user-profile page.

So we have to comment out the below 3 lines in `wp-content/plugins/ultimate-member/includes/core/class-rewrite.php`

```php
/**
 * Author page to user profile redirect
 */
function redirect_author_page() {
	if ( UM()->options()->get( 'author_redirect' ) && is_author() ) {
		// $id = get_query_var( 'author' );
		// um_fetch_user( $id );
		// exit( wp_redirect( um_user_profile_url() ) );
	}
}
```

## WP Event Manager

https://wordpress.org/plugins/wp-event-manager/

https://wp-eventmanager.com/

https://youtu.be/eTF2H8FVVi0

https://youtu.be/1RKQDJaXJ6Q

Install, Activate and follow through with automatic Setup

![wp-event-manager_setup](https://raw.githubusercontent.com/atabegruslan/Travellers_Forum/master/Illustrations/wp-event-manager_setup.png)

A few pages will be automatically added for you:

| Name  | Content  |
|---|---|
| Event Dashboard  | [event_dashboard]  |
| Events  | [events]  |
| Post an Event  | [submit_event_form]  |

wp-admin > Event Listings > Settings > Event Listings tab > enable `Multi-select Categories` & `Multi-select Event Types`

wp-admin > Event Listings > Settings > Event Submission tab > tick `Enable categories for listings` & `Enable event types for listings`

You will see that 2 extra options will appear in left sidebar: `Event Categories` & `Event Types`

wp-admin > Event Listings > Settings > Event Submission tab > tick `Enable multi select event type for event listing submission` & `Enable multi select event category for event listing submission`

wp-admin > Event Listings > Field Editor > Event fields > Add Field :

![Event_Listings-include_categories](https://raw.githubusercontent.com/atabegruslan/Travellers_Forum/master/Illustrations/Event_Listings-include_categories.png)

wp-admin > Event Listings > Event Categories : here you can create your custom categories for your events

#### Create menu named "Events" with "Display Location" being `events_menu_links`.

Menu Items:

| Name  | Permissions  |
|---|---|
| Events  | Everyone  |
| Post an Event  | Logged in users  |

In `functions.php`

```
register_nav_menus(
	array(
		'uacmenu' => __('uac_menu_links'),
		'eventsmenu' => __('events_menu_links') // here
	)
);
```

In `header.php`

```
$args = array(
	'theme_location' => 'eventsmenu',
	'menu_class' => 'events_menu'
);
wp_nav_menu($args);
``` 

## Custom Categories and Posts

https://wordpress.org/plugins/custom-post-type-ui/

https://wordpress.org/plugins/advanced-custom-fields/

| Tanonomy  | Term  | Post  |  |
|---|---|---|---|
| category  | ads, notices  | post  | WP Default  |
| gallery  | cities, attractions, get_togethers, trips  | album  | Custom  |
| event_listing_category  | get_togethers, trips  | event_listing  | Added by WP Event Manager plugin  |
| destination_category  | cities, attractions, gathering_venues  | destination  | Custom  |

## Search

### Without plugin

Customize `searchform.php` & `search.php`

Put below into `functions.php`
```
function cpt_post_search($query)
{
	if ($query->is_search)
	{
		$query->set( 'post_type', array( 'post', 'event_listing', 'album', 'destination' ) );
	}

	return $query;
}
add_filter( 'pre_get_posts', 'cpt_post_search' );
```

### With plugin

http://docs.designsandcode.com/search-filter/

`do_shortcode('[searchandfilter fields="search,category,gallery,event_listing_category,destination_category" types=",select,select,select,select" headings=",Categories,Galleries,Event Types,Destination Types" submit_label="Filter"]')`

## Contact Form - WPForms Lite

https://wordpress.org/plugins/wpforms-lite/

https://youtu.be/9YR9ANKSaXU

Setup a contact form then manually add a page

| Name  | Content  |
|---|---|
| Contact Us  | [wpforms id="103" title="false" description="false"]  |

## Create and edit posts and custom posts from frontend

https://wordpress.org/plugins/wp-user-frontend/

https://www.advancedcustomfields.com/resources/create-a-front-end-form/


## Widgets

```
function customWidgetInit()
{
    register_sidebar(
        array(
            'name' => 'Sidebar',
            'id'   => 'news-sidebar'
        )
    );
}
add_action('widgets_init', 'customWidgetInit');
```

### Important note: The widget ID can't contain capital letters. So something like `'id' => 'newsSidebar'` is not ok.

## Create and edit posts and custom posts from frontend

### Via plugins:

https://wordpress.org/plugins/user-submitted-posts/ (posts only)

https://wordpress.org/plugins/frontier-post/

https://wordpress.org/plugins/wp-user-frontend/

### ACF form (must have wp-user-frontend deactivated, else header conflict)

#### Edit

On `single-custom_post.php` page, put `acf_form_head()` at the top and append: `acf_form()`.
 
To include Featured-Image and Categories, create new custom fields for them:

![front_post_album_1](https://raw.githubusercontent.com/atabegruslan/Travellers_Forum/master/Illustrations/front_post_album_1.PNG)

![front_post_album_2](https://raw.githubusercontent.com/atabegruslan/Travellers_Forum/master/Illustrations/front_post_album_2.PNG)

![front_post_album_3](https://raw.githubusercontent.com/atabegruslan/Travellers_Forum/master/Illustrations/front_post_album_3.PNG)

#### Create

Create a new page `page-create_custom_post.php` page. See my `page-new-album.php` as an example.

Then in `functions.php`:

```
function front_post_album_save_additional_fields($post_id)
{
    $image_id = $_POST['acf']['field_xxx'];
    add_post_meta($post_id, '_thumbnail_id', $image_id);

    $terms = $_POST['acf']['field_xxx'];
    wp_set_post_terms($post_id, $terms, 'taxonomy_name');
}
add_action('acf/save_post', 'front_post_album_save_additional_fields', 10);
```

Find out what `field_xxx` actually is by looking in the Developer Console's Network tab.

https://www.advancedcustomfields.com/resources/using-acf_form-to-create-a-new-post/

https://thestizmedia.com/front-end-posting-with-acf-pro/

https://www.advancedcustomfields.com/resources/acf-update_value/

### Do it yourself:

See `wp-content\themes\travellers_forum\page-create-news.php`

### Via AJAX:

1. Create new page, in content input, text tab (not visual tab): 

`<input id="testAjax" type="submit" value="Submit" />`

2. Find out which theme your WP site is using, by looking at: `left hand side > appearances > themes`: see which is active (e.g.: `twentysixteen`)

3. Create `wp-content\themes\twentysixteen\js\ajax.js`

```
jQuery(document).ready(function($){

	$("#testAjax").click(function() {
	
		//alert( "Handler for .click() called." );
		
		console.log(theme_directory); //http://localhost/wordpress3/wp-content/themes/twentysixteen

        $.ajax({url: theme_directory+ "/ajax_test.php", success: function(result){
			alert(result);
        }});		
	});
});
```

4. Add to `wp-content\themes\twentysixteen\functions.php` :

```
function add_style_js()
{
	wp_register_script('ajax', get_template_directory_uri().'/js/ajax.js');
	wp_enqueue_script('ajax');
}

add_action('wp_footer', 'add_style_js', 5);
```

5. Add to `wp-content\themes\twentysixteen\header.php` :

```
<script>			
	var theme_directory = "<?php echo get_template_directory_uri() ?>";
</script>
```

6. Create `wp-content\themes\twentysixteen\ajax_test.php`

```
<?php
	echo 'Test';
?>
```

## Pagination
- https://codex.wordpress.org/Pagination
- https://codex.wordpress.org/Function_Reference/paginate_links
- https://www.wpexplorer.com/pagination-wordpress-theme/

## Archives

- Rewrite (eg author's) archive link's base: https://wpgeodirectory.com/support/topic/how-to-rename-author-link-for-author-archive-listing-page/#post-56652
	- Or do it via plugin: https://wordpress.org/plugins/edit-author-slug/
- Change (eg category's and tag's) archive links' base in the admin dasboard: https://www.wpbeginner.com/wp-tutorials/how-to-change-the-category-base-prefix-in-wordpress/
- Redirect (eg author's) archive link: http://justintadlock.com/archives/2013/01/29/how-to-change-your-author-archive-link
- More on rewrites:
	- https://codex.wordpress.org/Rewrite_API/add_rewrite_rule
	- https://wordpress.stackexchange.com/questions/229665/custom-rewrite-rules-for-archive-page-and-single-post

## Template parts

https://mekshq.com/passing-variables-via-get_template_part-wordpress/

- If you need to pass data to template, use `include(locate_template('template-parts/xx/yy.php'))`
- If you don't need to pass data to template, use `get_template_part('template-parts/xx/yy')`

No need for `echo` in either case.

## Comments

1. https://www.wpbeginner.com/glossary/comment/
2. https://developer.wordpress.org/reference/functions/comments_template/
3. https://github.com/atabegruslan/Travellers_Forum/blob/master/wp-content/themes/travellers_forum/comments.php

## Breadcrumbs

 - 2 Ways to Add Breadcrumbs: https://torquemag.io/2017/10/add-breadcrumbs-wordpress-website/
	- Plugins: https://www.wpbeginner.com/plugins/how-to-display-breadcrumb-navigation-links-in-wordpress/
		- PickPlugins Breadcrumb: https://wordpress.org/plugins/breadcrumb/
		- NavXT: https://wordpress.org/plugins/breadcrumb-navxt/
		- Yoast: https://wordpress.org/plugins/wordpress-seo/
	- Code: https://www.isitwp.com/adding-breadcrumbs/

## Upload to server

- Option 1 & 2: https://www.wpbeginner.com/wp-tutorials/how-to-move-wordpress-from-local-server-to-live-site/
	- Regarding step 7 of method 2 - SQL Replace: `UPDATE {wp_table_name} SET {column_name} = REPLACE(column_name, 'localhost/test/', 'www.yourlivesite.com/')`
	- Then check and update the home URL of the home menu item.
- Option 3: Akeeba plugin.
- In case you need to add a new user via DB, here is how: https://wpengine.com/support/add-admin-user-phpmyadmin/

## Social Login

- https://wpbuffs.com/integrate-facebook-login/
- https://wp-native-articles.com/blog/news/how-to-fix-facebook-apps-error-cant-load-url-domain-url-isnt-included-apps-domains/
- https://developers.google.com/identity/sign-in/web/sign-in


## Tutorials

### Theme
	- https://www.youtube.com/playlist?list=PLpcSpRrAaOaqMA4RdhSnnNcaqOVpX7qi5
	- https://www.youtube.com/playlist?list=PLriKzYyLb28nUFbe0Y9d-19uVkOnhYxFE
	- https://www.youtube.com/playlist?list=PLriKzYyLb28kpEnFFi9_vJWPf5-_7d3rX
	
![](https://raw.githubusercontent.com/atabegruslan/Travellers_Forum/master/Illustrations/wp_system_files.png)

### Hooks
	- https://www.youtube.com/playlist?list=PLriKzYyLb28kR_CPMz8uierDWC2y3znI2
	- https://www.youtube.com/playlist?list=PLJetLDY7yKuqoLwINbyf-lQeVsc49G3o_
	
![](https://raw.githubusercontent.com/atabegruslan/Travellers_Forum/master/Illustrations/WP_actions_and_filters.png)

#### System Hooks:

- https://developer.wordpress.org/reference/hooks/
- https://adambrown.info/p/wp_hooks

#### For comparison:

- Plain PHP
	- https://stackoverflow.com/questions/8336308/how-to-do-a-php-hook-system
	- https://www.php.net/manual/en/function.uopz-set-hook.php

- Joomla Triggers
	- https://docs.joomla.org/J3.x:Triggering_content_plugins_in_your_extension
	- https://docs.joomla.org/J3.x:Creating_a_Plugin_for_Joomla

### Making dependent plugins

Take a `dependent/dependent.php` plugin file for example:

```php

/*
Plugin Name: Dependent
Description: Dependent
Version:     1.0
Author:      Ruslan Aliyev
*/

function prerequisite_met() 
{ // https://wordpress.stackexchange.com/questions/189208/check-for-dependent-plugin-and-if-false-dont-activate-plugin
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' ) ;  // to get is_plugin_active() early
    $dependency = 'woocommerce/woocommerce.php';

    if(!file_exists(WP_PLUGIN_DIR . '/' . $dependency))
    {
        return show_error();
    }   

    if (!is_plugin_active($dependency)) 
    {
        return show_error();
    }

    return true ;
}

function show_error()
{
    echo '<h3>'.__('Please update all woocommerce extensions before activating.', 'wc').'</h3>';
    @trigger_error(__('Please update all woocommerce extensions before activating.', 'wc'), E_USER_ERROR);

    return false;
}

register_activation_hook(   __FILE__, 'prerequisite_met' );
```

### Enqueuing styles and scripts

#### Theme directory and child theme directory

- https://stackoverflow.com/questions/31797203/whats-the-difference-between-get-stylesheet-directory-uri-and-get-template-di

#### Admin

- https://blog.wplauncher.com/add-scripts-styles-to-specific-wordpress-admin-pages/
- https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts

#### Media

- https://stackoverflow.com/questions/63002931/media-queries-and-wp-enqueue-style-doesnt-seem-to-work

#### Enqueue and localize 

In other words, put PHP variables into JS.

**For example:** 

Use WordPress localization function to add string called 'Thank you' into `global.js` file. 

Enqueue `global.js` file using WP functions.

Write small script that will change button text to 'Thank you' after clicking.

**Below is how you do that:** 

functions.php
```php
function my_register_scripts()
{
	// The path doesn't have to be the parent theme's. 
	// It can be the child theme's (get_stylesheet_directory_uri) 
	// or a plugin's path.
	wp_register_script( 'thank_you_script', get_template_directory_uri() . '/js/global.js', ["jquery"], 1.0, true );
}
add_action('init', 'my_register_scripts');

function my_enqueue_scripts()
{
	$message = 'Thank you';
	wp_localize_script( 'thank_you_script', 'thank_you_obj', ['message' => $message] );
	wp_enqueue_script( 'thank_you_script' );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );
```

global.js
```js
(function($) {
    $(document).ready(function(){
	
        $("button").click(function(e){
			$(e.target).html(thank_you_obj.message);
		}); 
		
    });
})(jQuery);
```

### Querying

- https://www.billerickson.net/code/wp_query-arguments/
- https://wordpress.stackexchange.com/questions/48516/filtering-posts-by-post-meta-data

**Example 1:** Write WP query that will pull all custom post types called 'porftolio' that have special meta key called type and filter them
by meta value movie:

```php
$porftolioMovies = new WP_Query(
	[
		'post_type'  => 'porftolio',
		'meta_query' => [
			[
				'key'   => 'type',
				'value' => 'movie',
			]
		],
	]
);
```

**Example 2:** What is the $wpdb variable in WordPress, and how can you use it to improve the following code?

```php
function perform_database_action(){
    mysql_query(“INSERT into table_name (col1, col2, col3) VALUES ('$value1','$value2', '$value3');
}
```

$wpdb: interacting with database without using raw SQL code

```php
global $wpdb;

$wpdb->insert('table_name', [
    'col1' => $value1,
    'col2' => $value2,
    'col3' => $value3,
]);
```

## WP Cron

WP Cron works on a per request basis. It does not rely on server's Cron. It can be problematic for less popular sites.

https://chrislema.com/understanding-wp-cron/

## Making API routes

- https://www.sitepoint.com/wordpress-rest-api-adding-custom-routes/
- https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/

---

# Todo

- Bug: events part
- froalaEditor problem
