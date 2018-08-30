<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 14.02.18
 */

namespace Xsv\Base\Response;

use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;

class FileResponse extends Response
{
    private $body;
    private $resource;
    private $name;

    public function __construct($resource, $name = "")
    {
        $this->name = $name;
        $this->resource = $resource;

        if(is_resource($resource)) {
            $this->createBody();
            parent::__construct(
                $this->body,
                200,
                $this->getHeadersForFile()
            );
        } else if(file_exists($resource)) {
            if(empty($name)) {
                $this->name = basename($resource);
            }
            $this->createBody();
            parent::__construct(
                $this->body,
                200,
                $this->getHeadersForFile()
            );
        } else {
            parent::__construct(
                "php://memory",
                404
            );
        }
    }

    private function createBody()
    {
        $this->body = new Stream($this->resource);
    }

    private function getHeadersForFile() {
        return [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => "attachment; filename=" . $this->name,
            'Content-Transfer-Encoding' => 'Binary',
            'Content-Description' => 'File Transfer',
            'Pragma' => 'public',
            'Expires' => '0',
            'Cache-Control' => 'must-revalidate',
            'Content-Length' => "{$this->body->getSize()}"
        ];
    }
}
