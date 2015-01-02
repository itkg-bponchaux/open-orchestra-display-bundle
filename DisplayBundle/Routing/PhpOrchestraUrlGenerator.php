<?php

namespace PHPOrchestra\DisplayBundle\Routing;

use PHPOrchestra\BaseBundle\Context\CurrentSiteIdInterface;
use PHPOrchestra\ModelInterface\Model\NodeInterface;
use PHPOrchestra\ModelInterface\Repository\NodeRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class PhpOrchestraUrlGenerator
 */
class PhpOrchestraUrlGenerator extends UrlGenerator
{
    protected $nodeRepository;
    protected $siteManager;

    /**
     * Constructor
     *
     * @param RouteCollection         $routes
     * @param RequestContext          $context
     * @param NodeRepositoryInterface $nodeRepository
     * @param CurrentSiteIdInterface  $siteManager
     * @param LoggerInterface         $logger
     */
    public function __construct(
        RouteCollection $routes,
        RequestContext $context,
        NodeRepositoryInterface $nodeRepository,
        CurrentSiteIdInterface $siteManager,
        LoggerInterface $logger = null
    )
    {
        $this->routes = $routes;
        $this->context = $context;
        $this->logger = $logger;
        $this->nodeRepository = $nodeRepository;
        $this->siteManager = $siteManager;
    }

    /**
     * @param string      $name
     * @param array       $parameters
     * @param bool|string $referenceType
     *
     * @return string
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        try {
            $uri = parent::generate($name, $parameters, $referenceType);
        } catch (RouteNotFoundException $e) {
            $uri = $this->dynamicGenerate($name, $parameters, $referenceType);
        }

        return $uri;
    }

    /**
     * Generate url for a PHPOrchestra node
     *
     * @param string $nodeId
     * @param array  $parameters
     * @param string $referenceType
     *
     * @return string
     */
    protected function dynamicGenerate($nodeId, $parameters, $referenceType)
    {
        $schemeAuthority = '';
        $url = $this->getNodeAlias($nodeId);
        if ($this->context->getParameter('_locale') != $this->siteManager->getCurrentSiteDefaultLanguage()) {
            $url = '/' . $this->context->getParameter('_locale') . $url;
        }
        $scheme = $this->context->getScheme();
        $host = $this->context->getHost();

        if (self::ABSOLUTE_URL === $referenceType || self::NETWORK_PATH === $referenceType) {
            $port = '';
            if ('http' === $scheme && 80 != $this->context->getHttpPort()) {
                $port = ':' . $this->context->getHttpPort();
            } elseif ('https' === $scheme && 443 != $this->context->getHttpsPort()) {
                $port = ':' . $this->context->getHttpsPort();
            }

            $schemeAuthority = self::NETWORK_PATH === $referenceType ? '//' : "$scheme://";
            $schemeAuthority .= $host.$port;
        }

        if (self::RELATIVE_PATH === $referenceType) {
            $url = self::getRelativePath($this->context->getPathInfo(), $url);
        } else {
            $url = $schemeAuthority . $this->context->getBaseUrl() . $url;
        }

        if (!empty($parameters)) {
            $url = $url . '?' . http_build_query($parameters);
        }

        return $url;
    }

    /**
     * return relative path to $nodeId
     *
     * @param string $nodeId
     *
     * @return string
     * @throws RouteNotFoundException
     */
    protected function getNodeAlias($nodeId)
    {
        $alias = '';

        if ($nodeId != NodeInterface::ROOT_NODE_ID) {
            $node = $this->nodeRepository->findOneByNodeId($nodeId);

            if (is_null($node)) {
                throw new RouteNotFoundException(
                    sprintf('Unable to generate a URL for the node "%s" as such node does not exist.', $nodeId)
                );
            }

            $alias = $this->getNodeAlias($node->getParentId()) . '/' . $node->getAlias();
        }

        return $alias;
    }
}
