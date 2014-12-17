<?php namespace ConnorVG\Deploy;

/**
 * Created by Connor S. Parks.
 */
class DataInteractor {

    /**
     * Saves data.
     *
     * @param array  $data
     * @param string $config
     */
    public static function save($data = [], $config = '.default')
    {
        if (!is_dir(save_path()))
            mkdir(save_path());

        @file_put_contents(save_path() . '/dat-' . $config, json_encode($data));
    }

    /**
     * Loads data.
     *
     * @param string $config
     * @return array
     */
    public static function load($config = '.default')
    {
        try {
            $data = @file_get_contents(save_path() . '/dat-' . $config);

            return json_decode($data, true) ?: [];
        } catch (\Exception $e) { }

        return [];
    }

}
