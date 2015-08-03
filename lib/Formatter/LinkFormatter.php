<?php
/**
 * FlameCore Essentials
 * Copyright (C) 2015 IceFlame.net
 *
 * Permission to use, copy, modify, and/or distribute this software for
 * any purpose with or without fee is hereby granted, provided that the
 * above copyright notice and this permission notice appear in all copies.
 *
 * @package  FlameCore\Essentials
 * @version  0.1
 * @link     http://www.flamecore.org
 * @license  http://opensource.org/licenses/ISC ISC License
 */

namespace FlameCore\Essentials\Formatter;

/**
 * Class LinkFormatter
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
class LinkFormatter
{
    /**
     * The pattern to template map
     *
     * @var array
     */
    protected $patterns = array(
        '((?:https?|ftps?)://\S+)' => 'web',
        '([\w\-\.]+@[a-z\-\.]+\.[a-z]+)' => 'email',
        // '@(\w+)' => 'user',
        // 'wiki:([\w/]+)' => 'wiki',
        // 'ticket:([0-9]+)' => 'ticket'
    );

    /**
     * The list of templates
     *
     * @var array
     */
    protected $templates = array(
        'web' => '<a href="{#1}" rel="nofollow" target="_blank">{title}</a>',
        'email' => '<a href="mailto:{#1}" target="_blank">{title}</a>',
        // 'user' => '<a href="http://www.iceflame.net/user/{#1}">{title}</a>',
        // 'wiki' => '<a href="http://wiki.iceflame.net/{#1}">{title}</a>',
        // 'ticket' => '<a href="http://develop.iceflame.net/tickets/{#1}">#{title}</a>'
    );

    /**
     * Formats the given link.
     *
     * @param string $link The link
     * @param string $title The optional title of the link
     * @return string Returns the formatted link.
     */
    public function format($link, $title = null)
    {
        foreach ($this->getPatterns() as $pattern => $type) {
            if (preg_match("#^$pattern$#", $link, $matches)) {
                $template = $this->templates[$type];
                $title = $title ? (string) $title : (isset($matches[1]) ? $matches[1] : $link);

                if (is_callable($template)) {
                    return $template($matches, $title);
                } else {
                    return $this->renderLink($template, $title, $matches);
                }
            }
        }

        return $link;
    }

    /**
     * Returns the pattern to template map.
     *
     * @return array
     */
    public function getPatterns()
    {
        return $this->patterns;
    }

    /**
     * Registers a link pattern.
     *
     * @param string $pattern The link pattern
     * @param string $type The link type
     * @param callable|string $template The template content, if this is a new link type
     */
    public function register($pattern, $type, $template = null)
    {
        if ($template !== null) {
            if ($this->hasTemplate($type)) {
                throw new \LogicException(sprintf('The link type "%s" has already a template assigned.', $type));
            }

            $this->setTemplate($type, $template);
        }

        $this->patterns[$pattern] = $type;
    }

    /**
     * Returns the list of templates.
     *
     * @return array
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * Returns whether a template for the given link type is defined.
     *
     * @param string $type The link type
     * @return bool
     */
    public function hasTemplate($type)
    {
        return isset($this->templates[$type]);
    }

    /**
     * Sets the template for the given link type.
     *
     * @param string $type The link type
     * @param callable|string $template The template content
     */
    public function setTemplate($type, $template)
    {
        if (!is_callable($template)) {
            $template = (string) $template;
        }

        $this->templates[$type] = $template;
    }

    /**
     * Renders the link.
     *
     * @param string $template The template
     * @param string $title The link title
     * @param array $matches The pattern matches
     * @return string Returns the rendered template.
     */
    protected function renderLink($template, $title, array $matches)
    {
        $replace = ['{title}' => $title];

        foreach ($matches as $key => $value) {
            $replace['{#'.$key.'}'] = $value;
        }

        return strtr($template, $replace);
    }
}
