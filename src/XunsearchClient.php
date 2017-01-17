<?php
namespace Liugj\Xunsearch;

use Illuminate\Support\Facades\Cache;

class XunsearchClient
{
    /**
     * indexHost
     *
     * @var string
     * @access protected
     */
    protected $indexHost = null;

    /**
     * searchHost
     *
     * @var string
     * @access protected
     */
    protected $searchHost = null;

    /**
     * options
     *
     * @var mixed
     * @access protected
     */
    protected $options = [];

    /**
     * __construct
     *
     * @param mixed $indexHost
     * @param mixed $searchHost
     *
     * @access public
     *
     * @return mixed
     */
    public function __construct($indexHost, $searchHost, $options = [])
    {
        $this->indexHost  = $indexHost;
        $this->searchHost = $searchHost;
        $this->options    = $options;
    }
    /**
     * 初始化索引参数 initIndex
     *
     * @param string $indexName
     *
     * @access public
     *
     * @return \XSIndex
     */
    public function initIndex(string $indexName)
    {
        $config  = $this->loadConfig($indexName);
        return  (new \XS($config))->getIndex();
    }

    /**
     * 获取搜索操作对象
     *
     * @param string $searchName
     *
     * @access public
     *
     * @return XSSearch 搜索操作对象
     */
    public function initSearch(string $searchName)
    {
        $config  = $this->loadConfig($searchName);
        return  (new \XS($config))->getSearch();
    }

    /**
     * 解析INI配置文件
     * 由于 PHP 自带的 parse_ini_file 存在一些不兼容，故自行简易实现
     *
     * @param string $data 文件内容
     *
     * @return array 解析后的结果
     */
    private function parseIniData($data)
    {
        $ret = array();
        $cur = &$ret;
        $lines = explode("\n", $data);
        foreach ($lines as $line) {
            if ($line === '' || $line[0] == ';' || $line[0] == '#') {
                continue;
            }
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            if ($line[0] === '[' && substr($line, -1, 1) === ']') {
                $sec = substr($line, 1, -1);
                $ret[$sec] = array();
                $cur = &$ret[$sec];
                continue;
            }
            if (($pos = strpos($line, '=')) === false) {
                continue;
            }
            $key = trim(substr($line, 0, $pos));
            $value = trim(substr($line, $pos + 1), " '\t\"");
            $cur[$key] = $value;
        }

        return $ret;
    }

    /**
     * 加载项目配置文件
     *
     * @param string $schema 索引名称
     *
     * @access private
     *
     * @return array
     */
    private function loadConfig($schema)
    {
        $file = $this->options['schema'][$schema];
        $key = 'xunsearch_'. md5($file);
        $mtime = filemtime($file);

        if (($data = Cache :: get($key)) !== null) {
            if ($data['mtime'] != $mtime) {
                $data = false;
            }
        }

        if (!$data) {
            $content = file_get_contents($file);
            $data['config'] =  $this->parseIniData($content);
            $data['mtime']  = $mtime;
            Cache :: put($key, $data, 86400);
        }

        $data['config']['server.search'] = $this->searchHost;
        $data['config']['server.index']  = $this->indexHost;
        $data['config']['project.default_charset'] = 'utf8';
        $data['config']['project.name'] = $schema;

        return $data['config'];
    }
}
