<?php


namespace Ecjia\App\Installer;


class EnvironmentSet
{

    /**
     * Set or update env-variable.
     *
     * @param string $envFileContent Content of the .env file.
     * @param string $key            Name of the variable.
     * @param string $value          Value of the variable.
     *
     * @return array [string newEnvFileContent, bool isNewVariableSet].
     */
    public function setEnvVariable(string $envFileContent, string $key, string $value): array
    {
        $oldPair = $this->readKeyValuePair($envFileContent, $key);

        // Wrap values that have a space or equals in quotes to escape them
        if (preg_match('/\s/',$value) || strpos($value, '=') !== false) {
            $value = '"' . $value . '"';
        }

        $newPair = $key . '=' . $value;

        // For existed key.
        if ($oldPair !== null) {
            $replaced = preg_replace('/^' . preg_quote($oldPair, '/') . '$/uimU', $newPair, $envFileContent);
            return [$replaced, false];
        }

        // For a new key.
        return [$envFileContent . "\n" . $newPair . "\n", true];
    }

    /**
     * Read the "key=value" string of a given key from an environment file.
     * This function returns original "key=value" string and doesn't modify it.
     *
     * @param string $envFileContent
     * @param string $key
     *
     * @return string|null Key=value string or null if the key is not exists.
     */
    public function readKeyValuePair(string $envFileContent, string $key): ?string
    {
        // Match the given key at the beginning of a line
        if (preg_match("#^ *{$key} *= *[^\r\n]*$#uimU", $envFileContent, $matches)) {
            return $matches[0];
        }

        return null;
    }


    public function modifyEnvVariable($content, $key, $value)
    {
        [$newEnvFileContent, $isNewVariableSet] = $this->setEnvVariable($content, $key, $value);

        if ($isNewVariableSet) {
            return new \ecjia_error('new_variable_set', "A new environment variable with key '{$key}' has been set to '{$value}'");
        } else {
            [$_, $oldValue] = explode('=', $this->readKeyValuePair($content, $key), 2);
            return new \ecjia_error('changed_variable_set', "Environment variable with key '{$key}' has been changed from '{$oldValue}' to '{$value}'");
        }
    }


    public function readFile(string $path)
    {
        return $content = file_get_contents($path);
    }

    /**
     * Overwrite the contents of a file.
     *
     * @param string $path
     * @param string $contents
     *
     * @return boolean
     */
    public function writeFile(string $path, string $contents): bool
    {
        return (bool)file_put_contents($path, $contents, LOCK_EX);
    }

}