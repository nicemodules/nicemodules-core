<?php

namespace NiceModules\Core\Plugin;


use NiceModules\Core\Helper\WpHelper;
use NiceModules\Core\Lang\Locales;
use NiceModules\Core\Plugin;
use NiceModules\Core\Router\FrontendRouter;
use NiceModules\Core\Session;
use stdClass;

abstract class FrontendPlugin extends Plugin
{
    protected function initializeRouter()
    {
        $this->router = new FrontendRouter();
    }

    protected function initializeSession()
    {
        $locales = new Locales();
        $locale = get_user_locale();
        echo '<pre>'.print_r('EXE___', 1).'</pre>';
        Session::instance()->set('orm_language', $locales->getLocaleLang($locale));
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

        $post = new stdClass();
        $post->post_content = parent::getContent();
        $post->post_title = ''; // TODO: define  titles in controller
        $post->post_type = "page";
        $post->comment_status = "closed";
        $posts[] = $post;
        return $posts;
    }

}