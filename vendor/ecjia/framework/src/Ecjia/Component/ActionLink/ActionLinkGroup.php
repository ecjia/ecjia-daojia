<?php

namespace Ecjia\Component\ActionLink;

class ActionLinkGroup
{

    private $links = [];


    public function addLink(ActionLink $link)
    {
        $this->links[] = $link;

        return $this;
    }

    public function getLinks()
    {
        return $this->links;
    }

}