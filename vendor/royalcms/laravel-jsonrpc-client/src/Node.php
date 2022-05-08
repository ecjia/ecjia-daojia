<?php


namespace Royalcms\Laravel\JsonRpcClient;


class Node
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string|null
     */
    private $path;

    /**
     * @var
     */
    private $query;

    /**
     * Node constructor.
     * @param $host
     * @param $port
     * @param $path
     */
    public function __construct($host, $port = 80, $path = null, $query = null)
    {
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     * @return Node
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int|mixed $port
     * @return Node
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getPath(): ?mixed
    {
        return $this->path;
    }

    /**
     * @param mixed|null $path
     * @return Node
     */
    public function setPath(?mixed $path): Node
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     * @return Node
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * Get Node's url
     * @return string
     */
    public function getUrl()
    {
        if ($this->port == 80) {
            $url = "http://{$this->host}";
        } elseif ($this->port == 443) {
            $url = "https://{$this->host}";
        } else {
            $url = "http://{$this->host}:{$this->port}";
        }

        if (!empty($this->path)) {
            $url = $url . $this->path;
        }

        if (!empty($this->query)) {
            $url = $url . $this->query;
        }

        return $url;
    }


}