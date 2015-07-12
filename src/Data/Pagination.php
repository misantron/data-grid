<?php

namespace Data;

use Component\Component;
use Psr\Http\Message\ServerRequestInterface;
use Purl\Url;

class Pagination extends Component
{
    const
        LINK_CURRENT = 'current',
        LINK_NEXT  = 'next',
        LINK_PREV  = 'prev',
        LINK_FIRST = 'first',
        LINK_LAST  = 'last'
    ;

    /** @var string */
    private $scheme;
    /** @var string */
    private $host;
    /** @var string */
    private $route;
    /** @var array */
    private $queryParams;

    private $pageSize;
    private $currentPage;

    private $totalCount;

    private $defaultPageValue = 1;
    private $pageParamName = 'page';
    private $defaultPageSize = 20;

    /**
     * @param ServerRequestInterface $value
     * @return $this
     */
    public function setRequest($value)
    {
        if($value instanceof ServerRequestInterface){
            $this->scheme = $value->getUri()->getHost();
            $this->host = $value->getUri()->getHost();
            $this->route = $value->getUri()->getPath();
            $this->queryParams = $value->getQueryParams();
        }
        return $this;
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setQueryParams($value)
    {
        $this->queryParams = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        if($this->currentPage === null){
            $this->currentPage = $this->getCurrentPageFromQuery();
        }
        return $this->currentPage;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setPageSize($value)
    {
        $pageSize = $value < 1 ? 1 : (int) $value;
        $this->pageSize = $pageSize;
        return $this;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        if($this->pageSize === null){
            $this->pageSize = $this->defaultPageSize;
        }
        return $this->pageSize;
    }

    /**
     * @return int
     */
    public function getPageCount()
    {
        $pageSize = $this->getPageSize();
        if($pageSize < 1){
            return $this->totalCount > 0 ? 1 : 0;
        } else {
            $totalCount = $this->totalCount < 0 ? 0 : (int) $this->totalCount;
            return (int) ceil(($totalCount + $pageSize - 1) / $pageSize);
        }
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        $pageSize = $this->getPageSize();
        return $pageSize < 1 ? 0 : $this->getCurrentPage() * $pageSize;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        $pageSize = $this->getPageSize();
        return $pageSize < 1 ? -1 : $pageSize;
    }

    /**
     * @return string
     */
    public function render()
    {
        return '';
    }

    public function getLinks($absolute = false)
    {
        $currentPage = $this->getCurrentPage();
        $pageCount = $this->getPageCount();
        $links = [
            self::LINK_CURRENT => $this->createUrl($currentPage, $absolute),
        ];
        if ($currentPage > 0) {
            $links[self::LINK_FIRST] = $this->createUrl(0, $absolute);
            $links[self::LINK_PREV] = $this->createUrl($currentPage - 1, $absolute);
        }
        if ($currentPage < $pageCount - 1) {
            $links[self::LINK_NEXT] = $this->createUrl($currentPage + 1, $absolute);
            $links[self::LINK_LAST] = $this->createUrl($pageCount - 1, $absolute);
        }
        return $links;
    }

    /**
     * @param int $page
     * @param bool $absolute
     * @return string
     */
    private function createUrl($page, $absolute = false)
    {
        $url = new Url($this->route);
        if($absolute){
            $url->scheme = $this->scheme;
            $url->host = $this->host;
        }
        $queryParams = $this->queryParams;
        $queryParams[$this->pageParamName] = $page;
        $url->query->setData($queryParams);

        return $url->getUrl();
    }

    /**
     * @return int
     */
    private function getCurrentPageFromQuery()
    {
        if($this->queryParams === null){
            return $this->defaultPageValue;
        }
        return isset($this->queryParams[$this->pageParamName]) & is_scalar($this->queryParams[$this->pageParamName]) ?
            (int) $this->queryParams[$this->pageParamName] : $this->defaultPageValue;
    }
}