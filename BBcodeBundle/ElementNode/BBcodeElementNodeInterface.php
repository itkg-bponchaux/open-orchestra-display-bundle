<?php 

namespace OpenOrchestra\BBcodeBundle\ElementNode;

use OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinitionInterface;

/**
 * Interface BBcodeElementNodeInterface
 */
Interface BBcodeElementNodeInterface
{
    /**
     * Return the element as html with all replacements made
     *
     * @return the html representation of this node
     */
    public function getAsHTML();

    /**
     * Sets the CodeDefinition that defines this element.
     *
     * @param codeDef the code definition that defines this element node
     */
    public function setBBCodeDefinition(BBcodeDefinitionInterface $codeDef);
}
