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
    private $file;

    public function __construct($filePath)
    {
        if(!file_exists($filePath)) {
            parent::__construct(
                "php://memory",
                404
            );
        } else {
            $this->createBody();
            $this->file = $filePath;
            parent::__construct(
                $this->body,
                200,
                $this->getHeadersForFile()
            );
        }
    }

    private function createBody()
    {
        $this->body = new Stream($this->file);
    }

    private function getHeadersForFile() {
        return [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => "attachment; filename=" . basename($this->file),
            'Content-Transfer-Encoding' => 'Binary',
            'Content-Description' => 'File Transfer',
            'Pragma' => 'public',
            'Expires' => '0',
            'Cache-Control' => 'must-revalidate',
            'Content-Length' => "{$this->body->getSize()}"
        ];
    }
}
