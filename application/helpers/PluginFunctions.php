<?php
/**
 * All Plugin helper functions
 * 
 * @version $Id$
 * @copyright Center for History and New Media, 2007-2008
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka_ThemeHelpers
 * @subpackage PluginHelpers
 **/
 
/**
 * @since 0.10
 * @access private
 * @see admin_plugin_footer()
 * @return void
 **/
function admin_plugin_footer()
{
    $request = Omeka_Context::getInstance()->getRequest();
    fire_plugin_hook('admin_theme_footer', $request);
}
 
/**
 * Plugins should be able to hook into the header script for either admin or
 * public themes. The hooks involved are 'admin_theme_header',
 * 'public_theme_header'. This will allow us to disambiguate between themes(is
 * that an actual word?).
 *
 * Each hook implementation will receive the request object, which is the
 * easiest way to determine what page you are actually on at any given time. For
 * example:
 *
 * function myplugin_admin_header($request)
 * {
 *      if ($request->get('controller') == 'items') {
 *          // Load a stylesheet that you only want on the items pages 
 *      }  
 * }
 *
 * @since 0.10
 * @access private
 * @return void
 **/
function admin_plugin_header()
{
    $request = Omeka_Context::getInstance()->getRequest();
    fire_plugin_hook('admin_theme_header', $request);
}

/**
 * Hook is fired on the public advanced search form.
 * 
 * @since 0.10
 * @return string
 **/
function plugin_append_to_advanced_search()
{
    return get_plugin_hook_output('public_append_to_advanced_search');
}

/**
 * Retrieve the HTML that is output by the 'public_append_to_items_browse_each'
 * hook.  This hook is fired on the public theme, inside the items/browse loop.
 * 
 * @since 0.10
 * @return string
 **/
function plugin_append_to_items_browse_each()
{
    return get_plugin_hook_output('public_append_to_items_browse_each');
}

/**
 * Hook is fired at the end of the items/browse page, after the loop.
 * 
 * @since 0.10
 * @see plugin_append_to_items_browse_each()
 **/
function plugin_append_to_items_browse()
{
    return get_plugin_hook_output('public_append_to_items_browse');
}

 /**
  * Hook is fired at the end of the items/show page.
  * 
  * @since 0.10
  * @see plugin_append_to_items_browse_each()
  */
function plugin_append_to_items_show()
{
    return get_plugin_hook_output('public_append_to_items_show');
}

/**
 * @since 0.10
 * @see plugin_append_to_items_browse_each()
 **/
function plugin_append_to_collections_browse_each()
{
    return get_plugin_hook_output('public_append_to_collections_browse_each');
}

/**
 * Hook is fired on the public collections/browse page.
 * 
 * @since 0.10
 * @return string
 **/
function plugin_append_to_collections_browse()
{
    return get_plugin_hook_output('public_append_to_collections_browse');
}

/**
 * Hook is fired on the public collections/show page.
 * 
 * @since 0.10
 * @return string
 **/
function plugin_append_to_collections_show()
{
    return get_plugin_hook_output('public_append_to_collections_show');
}

/**
 * Allow plugins to hook in to the footer of public themes.
 * 
 * Uses the 'public_theme_footer' hook, which receives the request object as
 * the first argument.
 * 
 * @since 0.9
 * @see plugin_header()
 * @return void
 **/
function plugin_footer() 
{
    $request = Omeka_Context::getInstance()->getRequest();
	fire_plugin_hook('public_theme_footer', $request);
}

/**
 * Allows plugins to hook in to the header of public themes.
 *
 * Uses the 'public_theme_header' hook to inject content into the theme.  This
 * hook receives the request object as the first argument, which allows the 
 * plugin writer to tailor the header output to a specific request (specific
 * controller, action, etc.).
 * 
 * @since 0.9
 * @return void
 **/
function plugin_header() 
{
    $request = Omeka_Context::getInstance()->getRequest();
	fire_plugin_hook('public_theme_header', $request);
}