<?php


namespace Ecjia\App\Installer;


use ecjia_error;
use Exception;
use RC_File;

class InstallEnvConfig
{

    protected $envPath;

    /**
     * InstallEnvConfig constructor.
     * @param $envPath
     */
    public function __construct($envPath = null)
    {
        if (is_null($envPath)) {
            $this->envPath = base_path('.env');
        }
        else {
            $this->envPath = $envPath;
        }

    }

    public function readEnvExamplePath()
    {
        return royalcms()->appPath('installer') . '/data/env.example';
    }

    /**
     * 创建.env文件
     */
    public function createEnv()
    {
        $envExamplePath = $this->readEnvExamplePath();

        if (RC_File::exists($envExamplePath)) {
            RC_File::copy($envExamplePath, $this->envPath);
        }
    }

    /**
     * 修改.env文件
     * @param array $data
     * @return string | null | ecjia_error
     */
    public function modifyEnv(array $data)
    {
        try {
            $contentArray = collect(file($this->envPath, FILE_IGNORE_NEW_LINES));
            $contentArray->transform(function ($item) use ($data){
                foreach ($data as $key => $value) {
                    if (str_contains($item, $key)) {
                        return $key . '=' . $value;
                    }
                }

                return $item;
            });

            $content = implode($contentArray->toArray(), "\n");

            return RC_File::put($this->envPath, $content);

        }
        catch (Exception $e) {
            return new ecjia_error('write_config_file_failed', __('写入配置文件出错', 'installer'));
        }
    }

    /**
     * 修改.env文件
     * @param array $data
     * @return string | null | ecjia_error
     */
    public function modifyEnvVariable(array $data)
    {
        try {
            $envset = new EnvironmentSet();
            $content = $envset->readFile($this->envPath);

            foreach ($data as $key => $value) {
                [$newEnvFileContent, $isNewVariableSet] = $envset->setEnvVariable($content, $key, $value);
                $content = $newEnvFileContent;
            }

            $envset->writeFile($this->envPath, $newEnvFileContent);
        } catch (Exception $e) {
            return new ecjia_error('write_config_file_failed', __('写入配置文件出错', 'installer'));
        }
    }

}