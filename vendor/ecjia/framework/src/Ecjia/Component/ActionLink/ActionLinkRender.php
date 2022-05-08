<?php

namespace Ecjia\Component\ActionLink;

class ActionLinkRender
{

    private $group;

    public function __construct(ActionLinkGroup $group)
    {
        $this->group = $group;
    }

    /**
     * @return ActionLinkGroup
     */
    public function getGroup(): ActionLinkGroup
    {
        return $this->group;
    }

    /**
     * @param ActionLinkGroup $group
     * @return ActionLinkRender
     */
    public function setGroup(ActionLinkGroup $group): ActionLinkRender
    {
        $this->group = $group;
        return $this;
    }

    public function render()
    {
        $links = $this->group->getLinks();

        return collect($links)->map(function ($link) {
            return $this->renderTemplate($link);
        })->implode(' ');
    }

    /**
     * @param ActionLink $link
     * @return string
     */
    protected function renderTemplate($link)
    {
        $href = $link->getHref();
        $text = $link->getText();

        if ($link->getIcon()) {
            $icon = '<i class="' . $link->getIcon() . '"></i>';
        } else {
            $icon = '';
        }

        if ($link->isPjax()) {
            $pjax = ' data-pjax';
        } else {
            $pjax = '';
        }

        return <<<HTML
<a class="btn plus_or_reply{$pjax}" href="{$href}">{$icon}{$text}</a>
HTML;
    }





}