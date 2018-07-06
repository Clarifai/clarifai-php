<?php

namespace Clarifai\API\Requests;

abstract class ClarifaiPaginatedRequest extends ClarifaiRequest
{
    private $page = null;
    private $perPage = null;

    /**
     * @param int|null $page
     * @return ClarifaiPaginatedRequest $this
     */
    public function withPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @param int|null $perPage
     * @return ClarifaiPaginatedRequest $this
     */
    public function withPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function buildUrl()
    {
        if (is_null($this->page) && is_null($this->perPage))
        {
            return $this->url();
        }
        else
        {
            return $this->url() . '?' .
                (!is_null($this->page) ? "page=$this->page" : '') .
                (!is_null($this->page) && !is_null($this->perPage) ? '&' : '') .
                (!is_null($this->perPage) ? "per_page=$this->perPage" : '');
        }
    }
}
