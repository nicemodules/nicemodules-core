<?php

namespace NiceModules\Core\Plugin;


use NiceModules\Core\Helper\WpHelper;
use NiceModules\Core\Plugin;
use NiceModules\Core\Router\FrontendRouter;

abstract class FrontendPlugin extends Plugin
{
    protected function initializeRouter()
    {
        $this->router = new FrontendRouter();
    }

    public function initialize()
    {
        if ($this->content = $this->router->route()) {
            add_action('wp_enqueue_scripts', [$this, 'attachFiles']);
            add_filter('the_posts', [$this, 'renderContent']);
            remove_filter('the_content', 'wpautop');
        }
    }

    public function renderContent()
    {
        if (!WpHelper::detectFunctionUsage(['WP->main'])) {
            return;
        }
        
        $post = new \stdClass();
        $post->post_content =  parent::getContent();
        $post->post_title = 'undefined'; // TODO: define  titles in controller
        $post->post_type = "page";
        $post->comment_status = "closed";
        $posts[] = $post;
        return $posts;
    }

}