<?php

namespace Bex\Behat\ScreenshotExtension\Driver;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Url extends Local implements ImageDriverInterface
{
    const CONFIG_PARAM_SCREENSHOT_URL = 'screenshot_url';

    private $screenshotUrl;
    private $screenshotDirectory;

    /**
     * @param  ArrayNodeDefinition $builder
     *
     * @return void
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        parent::configure($builder);

        $builder
            ->children()
                ->scalarNode(self::CONFIG_PARAM_SCREENSHOT_URL)
                ->end()
            ->end();
    }

    /**
     * @param  ContainerBuilder $container
     * @param  array            $config
     *
     * @return void
     */
    public function load(ContainerBuilder $container, array $config)
    {
        parent::load($container, $config);

        $this->screenshotUrl  = $config[self::CONFIG_PARAM_SCREENSHOT_URL];
        $this->screenshotDirectory = $config[self::CONFIG_PARAM_SCREENSHOT_DIRECTORY];
    }

    /**
     * @param string $binaryImage
     * @param string $filename
     *
     * @return string URL to the image
     */
    public function upload($binaryImage, $filename)
    {
        $urlToImage = parent::upload($binaryImage, $filename);
        $externUrlToImage = str_replace($this->screenshotDirectory, $this->screenshotUrl, $urlToImage);

        return sprintf("%s or %s", $urlToImage, $externUrlToImage);
    }
}
