<?php

namespace OpenOrchestra\DisplayBundle\BBcode;

use OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinitionCollectionInterface;
use OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinitionFactory;

/**
 * Class DisplayBundleBBcodeCollection
 *
 */
class DisplayBundleBBcodeCollection implements BBcodeDefinitionCollectionInterface
{
    protected $definitions = array();

    /**
     * Set the BBcode definitions introduced in the display bundle
     * 
     * @param $definitionFactory
     */
    public function __construct(BBcodeDefinitionFactory $definitionFactory)
    {
        $this->definitions[] = $definitionFactory->create('div', '<div>{param}</div>');
        $this->definitions[] = $definitionFactory->create('div', '<div class="{option}">{param}</div>', true);
        $this->definitions[] = $definitionFactory->create('span', '<span>{param}</span>');
        $this->definitions[] = $definitionFactory->create('span', '<span class="{option}">{param}</span>', true);
        $this->definitions[] = $definitionFactory->create('sup', '<sup>{param}</sup>');
        $this->definitions[] = $definitionFactory->create('pre', '<pre>{param}</pre>');
        $this->definitions[] = $definitionFactory->create('quote', '<blockquote>{param}</blockquote>');

        $this->definitions[] = $definitionFactory->create('table', '<table>{param}</table>');
        $this->definitions[] = $definitionFactory->create('tbody', '<tbody>{param}</tbody>');
        $this->definitions[] = $definitionFactory->create('td', '<td>{param}</td>');
        $this->definitions[] = $definitionFactory->create('tr', '<tr>{param}</tr>');
        $this->definitions[] = $definitionFactory->create('th', '<tr>{param}</th>');

        $this->definitions[] = $definitionFactory->create('section', '<section>{param}</section>');
        $this->definitions[] = $definitionFactory->create('section', '<section class="{option}">{param}</section>', true);
        $this->definitions[] = $definitionFactory->create('article', '<article>{param}</article>');
        $this->definitions[] = $definitionFactory->create('article', '<article class="{option}">{param}</article>', true);
        $this->definitions[] = $definitionFactory->create('nav', '<nav>{param}</nav>');
        $this->definitions[] = $definitionFactory->create('nav', '<nav class="{option}">{param}</nav>', true);
        $this->definitions[] = $definitionFactory->create('aside', '<aside>{param}</aside>');
        $this->definitions[] = $definitionFactory->create('aside', '<aside class="{option}">{param}</aside>', true);
        $this->definitions[] = $definitionFactory->create('footer', '<footer>{param}</footer>');
        $this->definitions[] = $definitionFactory->create('footer', '<footer class="{option}">{param}</footer>', true);
    }

    /**
     * Get an array of CodeDefinitions
     * 
     * @return array
     */
    public function getDefinitions() {
        return $this->definitions;
    }
}
