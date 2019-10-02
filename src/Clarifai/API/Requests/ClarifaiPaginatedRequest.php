<?php

namespace Clarifai\API\Requests;

use Clarifai\API\RequestMethod;
use Clarifai\Internal\_Pagination;

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
        if ((!is_null($this->page) || !is_null($this->perPage)) &&
            $this->requestMethod() == RequestMethod::GET) {
            return $this->url() . '?' .
                (!is_null($this->page) ? "page=$this->page" : '') .
                (!is_null($this->page) && !is_null($this->perPage) ? '&' : '') .
                (!is_null($this->perPage) ? "per_page=$this->perPage" : '');
        }
        else {
            return $this->url();
        }
    }

    protected function addPaginationFieldsToRequest($request) {
        $pagination = new _Pagination();
        if (!is_null($this->page)) {
            $pagination->setPage($this->page);
        }
        if (!is_null($this->perPage)) {
            $pagination->setPerPage($this->perPage);
        }
        if ($pagination->byteSize() > 0) {
            $request->setPagination($pagination);
        }
    }
}
