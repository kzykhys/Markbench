<?php

namespace Markbench\Driver;

use Markbench\DriverInterface;


/**
 * @author Carsten Brandt <mail@cebe.cc>
 */
class SundownDriver implements DriverInterface
{

    /**
     * @var Markdown
     */
    private $markdown;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $md = new \Sundown\Markdown(new \Sundown\Render\HTML, array(
            'tables' => true,
            'autolink' => true,
            'strikethrough' => true,
            'lax_html_blocks' => true,
            // 'no_intra_emphasis' => true,
            'fenced_code_blocks' => true,
            // 'space_after_headers' => true,
            // 'superscript' => true,
        ));
        $md->getRender()->setRenderFlags(array(
            'hard_wrap' => true,
            // 'filter_html' => true,
        ));
        $this->markdown = $md;
    }

    /**
     * {@inheritdoc}
     */
    public function run($markdown = '')
    {
        return $this->markdown->render($markdown);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sundown';
    }

    /**
     * {@inheritdoc}
     */
    public function getDialect()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function checkRequirements()
    {
        return class_exists('Sundown\Markdown');
    }

}
