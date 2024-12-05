<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    
class MY_Router extends CI_Router
{
    protected function _set_routing()
    {
        if (file_exists(APPPATH.'config/routes.php'))
        {
            include(APPPATH.'config/routes.php');
        }

        if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/routes.php'))
        {
            include(APPPATH.'config/'.ENVIRONMENT.'/routes.php');
        }

        if (isset($route) && is_array($route))
        {
            isset($route['default_controller']) && $this->default_controller = $route['default_controller'];
            isset($route['translate_uri_dashes']) && $this->translate_uri_dashes = $route['translate_uri_dashes'];
            unset($route['default_controller'], $route['translate_uri_dashes']);
            $this->routes = $route;
        }

        $_c = trim($this->config->item('controller_trigger'));
        if ( ! empty($_GET[$_c]))
        {
            $this->uri->filter_uri($_GET[$_c]);
            $this->set_class($_GET[$_c]);

            $_f = trim($this->config->item('function_trigger'));
            if ( ! empty($_GET[$_f]))
            {
                $this->uri->filter_uri($_GET[$_f]);
                $this->set_method($_GET[$_f]);
            }

            $this->uri->rsegments = array(
                1 => $this->class,
                2 => $this->method
            );
        }
        else
        {
            if ($this->uri->uri_string !== '')
            {
                $this->_parse_routes();
            }
            else
            {
                $this->_set_default_controller();
            }
        }
    }
}

