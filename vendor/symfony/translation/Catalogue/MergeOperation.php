<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Catalogue;

<<<<<<< HEAD
/**
 * Merge operation between two catalogues.
=======
use Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * Merge operation between two catalogues as follows:
 * all = source ∪ target = {x: x ∈ source ∨ x ∈ target}
 * new = all ∖ source = {x: x ∈ target ∧ x ∉ source}
 * obsolete = source ∖ all = {x: x ∈ source ∧ x ∉ source ∧ x ∉ target} = ∅
 * Basically, the result contains messages from both catalogues.
>>>>>>> v2-test
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class MergeOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function processDomain($domain)
    {
        $this->messages[$domain] = array(
            'all' => array(),
            'new' => array(),
            'obsolete' => array(),
        );

        foreach ($this->source->all($domain) as $id => $message) {
            $this->messages[$domain]['all'][$id] = $message;
            $this->result->add(array($id => $message), $domain);
=======
    protected function processDomain(string $domain)
    {
        $this->messages[$domain] = [
            'all' => [],
            'new' => [],
            'obsolete' => [],
        ];
        $intlDomain = $domain.MessageCatalogueInterface::INTL_DOMAIN_SUFFIX;

        foreach ($this->source->all($domain) as $id => $message) {
            $this->messages[$domain]['all'][$id] = $message;
            $this->result->add([$id => $message], $this->source->defines($id, $intlDomain) ? $intlDomain : $domain);
>>>>>>> v2-test
            if (null !== $keyMetadata = $this->source->getMetadata($id, $domain)) {
                $this->result->setMetadata($id, $keyMetadata, $domain);
            }
        }

        foreach ($this->target->all($domain) as $id => $message) {
            if (!$this->source->has($id, $domain)) {
                $this->messages[$domain]['all'][$id] = $message;
                $this->messages[$domain]['new'][$id] = $message;
<<<<<<< HEAD
                $this->result->add(array($id => $message), $domain);
=======
                $this->result->add([$id => $message], $this->target->defines($id, $intlDomain) ? $intlDomain : $domain);
>>>>>>> v2-test
                if (null !== $keyMetadata = $this->target->getMetadata($id, $domain)) {
                    $this->result->setMetadata($id, $keyMetadata, $domain);
                }
            }
        }
    }
}
